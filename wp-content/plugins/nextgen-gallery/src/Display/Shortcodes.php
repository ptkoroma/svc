<?php

namespace Imagely\NGG\Display;

use Imagely\NGG\DisplayedGallery\Renderer;

/**
 * NGG registers its shortcodes using Shortcodes::add($tag, $callback)
 *
 * We do this for the following reason:
 *
 * NGG is used with a wide variety of third-party themes and plugins. Some of which, do things
 * a little unorthodox, and end up modifying the markup generated by the shortcode, which breaks
 * the display for our users.
 *
 * Rather than having to explain to our userbase, "you shouldn't use NGG with [plugin x]", we
 * decided to find a mechanism that would make our plugin immune from such manipulation from other
 * plugins, or at least reduce likelihood of such a thing happening.
 *
 * This is how the mechanism works:
 *
 * When you register a shortcode using Shortcodes::add(), we store a reference to
 * the callback internally, but add the shortcode will actually call one of the internal methods of
 * this class which outputs a placeholder (@see $_privateholder_text) instead of the markup generated
 * by the callback. It's just a simple string and something that a third-party plugin is unlikely to
 * manipulate in any way.
 *
 * We then register a filter for the_content, at high a priority of PHP_INT_MAX as an attempt to make
 * our hook be the last hook to be executed. This hook then substitutes the placeholders with the markup
 * generated by the shortcode's callback that was provided in \Imagely\NGG\Display\Shortcodes::add()
 */
class Shortcodes {

	private static $_instance  = null;
	private $_shortcodes       = [];
	private $_found            = [];
	private $_placeholder_text = 'ngg_shortcode_%d_placeholder';

	/**
	 * @return Shortcodes
	 */
	static function get_instance() {
		if ( \is_null( self::$_instance ) ) {
			self::$_instance = new Shortcodes();
		}
		return self::$_instance;
	}

	/**
	 * Adds a shortcode
	 *
	 * @param $name
	 * @param $callback
	 * @param callable|null Parameters transformer
	 */
	static function add( $name, $callback, $transformer = null ) {
		$manager = self::get_instance();
		$manager->add_shortcode( $name, $callback, $transformer );
	}

	/**
	 * @return string[]
	 */
	public function get_shortcodes() {
		return $this->_shortcodes;
	}

	public function is_disabled(): bool {
		return defined( 'NGG_DISABLE_SHORTCODE_MANAGER' ) && NGG_DISABLE_SHORTCODE_MANAGER;
	}

	/**
	 * Removes a previously added shortcode
	 *
	 * @param $name
	 */
	static function remove( $name ) {
		$manager = self::get_instance();
		$manager->remove_shortcode( $name );
	}

	public function register_hooks() {
		if ( $this->is_disabled() ) {
			return;
		}

		// For theme & plugin compatibility and to prevent the output of our shortcodes from being
		// altered we substitute our shortcodes with placeholders at the start of the the_content() filter
		// queue and then at the end of the the_content() queue, we substitute the placeholders with our
		// actual markup.
		\add_filter( 'the_content', [ $this, 'fix_nested_shortcodes' ], -1 );
		\add_filter( 'the_content', [ $this, 'parse_content' ], PHP_INT_MAX );
		\add_filter( 'widget_text', [ $this, 'fix_nested_shortcodes' ], -1 );
	}

	/**
	 * We're parsing our own shortcodes because WP can't yet handle nested shortcodes [ngg param="[slideshow]"]
	 *
	 * @param string $content
	 * @return string
	 */
	public function fix_nested_shortcodes( $content ) {
		// Try to find each registered shortcode in the content.
		foreach ( $this->_shortcodes as $tag => $tag_details ) {

			$shortcode_start_tag = "[{$tag}";
			$offset              = 0;

			// Find each occurrence of the shortcode.
			while ( ( $start_of_shortcode = \strpos( $content, $shortcode_start_tag, $offset ) ) !== false ) {

				$index                       = $start_of_shortcode + \strlen( $shortcode_start_tag );
				$found_attribute_assignment  = false;
				$current_attribute_enclosure = null;
				$last_found_char             = '';
				$content_length              = \strlen( $content ) - 1;

				while ( true ) {
					// Parse out the shortcode, character-by-character.
					$char = $content[ $index ];
					if ( $char == '"' || $char == "'" && $last_found_char == '=' ) {
						// Is this the closing quote for an already found attribute assignment?
						if ( $found_attribute_assignment && $current_attribute_enclosure == $char ) {
							$found_attribute_assignment  = false;
							$current_attribute_enclosure = null;
						} else {
							$found_attribute_assignment  = true;
							$current_attribute_enclosure = $char;
						}
					} elseif ( $char == ']' ) {
						// we've found a shortcode closing tag. But, we need to ensure
						// that this ] isn't within the value of a shortcode attribute.
						if ( ! $found_attribute_assignment ) {
							break; // exit loop - we've found the shortcode.
						}
					}

					$last_found_char = $char;

					// Prevent infinite loops in our while(TRUE).
					if ( $index == $content_length ) {
						break;
					}

					++$index;
				}

				// Get the shortcode.
				$shortcode             = \substr( $content, $start_of_shortcode + 1, --$index - $start_of_shortcode );
				$shortcode_replacement = \str_replace(
					[ '[', ']' ],
					[ '&#91;', '&#93;' ],
					$shortcode
				);

				// Replace the shortcode with one that doesn't have nested shortcodes.
				$content = \str_replace(
					$shortcode,
					$shortcode_replacement,
					$content
				);

				// Calculate the offset for the next loop iteration.
				$offset = $index + 1 + \strlen( $shortcode_replacement ) - \strlen( $shortcode );
			}
		}
		\reset( $this->_shortcodes );

		return $content;
	}

	/**
	 * Deactivates all shortcodes
	 */
	public function deactivate_all() {
		foreach ( \array_keys( $this->_shortcodes ) as $shortcode ) {
			$this->deactivate( $shortcode );
		}
	}

	/**
	 * Parses the content for shortcodes and returns the substituted content
	 *
	 * @param $content
	 * @return string
	 */
	public function parse_content( $content ) {
		$regex = \str_replace( '%d', '(\d+)', $this->_placeholder_text );

		if ( $this->is_rest_request() ) {
			\ob_start();
		}

		if ( \preg_match_all( "/{$regex}/m", $content, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$placeholder = \array_shift( $match );
				$id          = \array_shift( $match );
				$content     = \str_replace( $placeholder, $this->execute_found_shortcode( $id ), $content );
			}
		}

		if ( $this->is_rest_request() ) {
			// Pre-generating displayed gallery cache by executing shortcodes in the REST API can prevent users
			// from being able to add and save blocks with lots of images and no pagination (for example a very large
			// basic slideshow or pro masonry / mosaic / tile display).
			if ( \apply_filters( 'ngg_disable_shortcodes_in_request_api', false ) ) {
				return $content;
			}
			\ob_start();
		}

		return $content;
	}

	public function render_legacy_shortcode( $params, $inner_content ) {
		return Renderer::get_instance()->display_images( $params, $inner_content );
	}

	public function execute_found_shortcode( $found_id ) {
		return isset( $this->_found[ $found_id ] )
			? $this->render_shortcode(
				$this->_found[ $found_id ]['shortcode'],
				$this->_found[ $found_id ]['params'],
				$this->_found[ $found_id ]['inner_content']
			)
			: 'Invalid shortcode';
	}

	/**
	 * Adds a shortcode
	 *
	 * @param $name
	 * @param $callback
	 * @param callable|null $transformer
	 */
	public function add_shortcode( $name, $callback, $transformer = null ) {
		$this->_shortcodes[ $name ] = [
			'callback'    => $callback,
			'transformer' => $transformer,
		];

		if ( $this->is_disabled() ) {
			// Because render_shortcode() is a wrapper to several shortcodes it requires the $name parameter and can't be passed directly to add_shortcode()
			add_shortcode( $name, function ( $params, $inner_content ) use ( $name ) {
				return $this->render_shortcode( $name, $params, $inner_content );
			} );
		} else {
			\add_shortcode( $name, [ $this, $name . '____wrapper' ] );
		}
	}

	/**
	 * Removes a shortcode
	 *
	 * @param $name
	 */
	public function remove_shortcode( $name ) {
		unset( $this->_shortcodes[ $name ] );
		$this->deactivate( $name );
	}

	/**
	 * De-activates a shortcode
	 *
	 * @param $shortcode
	 */
	public function deactivate( $shortcode ) {
		if ( isset( $this->_shortcodes[ $shortcode ] ) ) {
			\remove_shortcode( $shortcode );
		}
	}

	public function is_rest_request() {
		return \defined( 'REST_REQUEST' ) || \strpos( $_SERVER['REQUEST_URI'], 'wp-json' ) !== false;
	}

	public function __call( $method, $args ) {
		$params        = \array_shift( $args );
		$inner_content = \array_shift( $args );
		$parts         = \explode( '____', $method );
		$shortcode     = \array_shift( $parts );

		if ( \doing_filter( 'the_content' ) && ! \doing_filter( 'widget_text' ) ) {
			$retval = $this->replace_with_placeholder( $shortcode, $params, $inner_content );
		} else {          // Widgets don't use placeholders.
			return $this->render_shortcode( $shortcode, $params, $inner_content );
		}

		return $retval;
	}

	public function render_shortcode( $shortcode, $params = [], $inner_content = '' ) {
		if ( isset( $this->_shortcodes[ $shortcode ] ) ) {
			$shortcode = $this->_shortcodes[ $shortcode ];

			if ( \is_callable( $shortcode['transformer'] ) ) {
				$params = \call_user_func( $shortcode['transformer'], $params );
			}

			$method = ( \is_null( $shortcode['callback'] ) && \is_callable( $shortcode['transformer'] ) ) ? [ $this, 'render_legacy_shortcode' ] : $shortcode['callback'];

			$retval = \call_user_func( $method, $params, $inner_content );
		} else {
			$retval = 'Invalid shortcode';
		}

		return $retval;
	}

	/**
	 * Prevents wptexturize
	 *
	 * @param $shortcode
	 * @param array     $params
	 * @param string    $inner_content
	 * @return mixed|void
	 */
	public function replace_with_placeholder( $shortcode, $params = [], $inner_content = '' ) {
		$id                  = \count( $this->_found );
		$this->_found[ $id ] = [
			'shortcode'     => $shortcode,
			'params'        => $params,
			'inner_content' => $inner_content,
		];

		$placeholder = \sprintf( $this->_placeholder_text, $id );

		return \apply_filters( 'ngg_shortcode_placeholder', $placeholder, $shortcode, $params, $inner_content );
	}

	/**
	 * @return string
	 */
	public function get_shortcode_regex() {
		$keys = \array_keys( $this->_shortcodes );
		return '/' . \get_shortcode_regex( $keys ) . '/';
	}
}
