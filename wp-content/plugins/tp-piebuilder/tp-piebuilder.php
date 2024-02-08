<?php
/**
 * Plugin Name: TP Piebuilder
 * Plugin URI: http://www.themepalace.com/plugins/tp-piebuilder
 * Description: This Plugin provides you an elegent Bar Graph and Pie Charts with multiple designs and colors. ie. Default Pie Chart, Doughnut Pie Chart, Polar Pie Chart, Bar Graph, Horizontal Bar Graph.
 * Version: 1.0
 * Author: Theme Palace
 * Author URI: http://themepalace.com
 * Requires at least: 4.5
 * Tested up to: 6.0
 * Requires PHP: 5.6
 *
 * Text Domain: tp-piebuilder
 * Domain Path: /languages/
 *
 * @package TP Piebuilder
 * @category Core
 * @author Theme Palace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'TP_PieBuilder' ) ) :

	final class TP_PieBuilder {

		public function __construct()
		{
			$this->tp_piebuilder_constant();
			$this->tp_piebuilder_hooks();
			$this->tp_piebuilder_includes();
		}

		public function tp_piebuilder_constant()
		{
			define( 'TP_PIEBUILDER_BASE_PATH', dirname(__FILE__ ) );
			define( 'TP_PIEBUILDER_URL_PATH', plugin_dir_url(__FILE__ ) );
			define( 'TP_PIEBUILDER_PLUGIN_BASE_PATH', plugin_basename(__FILE__) );
		}

		public function tp_piebuilder_hooks()
		{
			// enqueue admin scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'tp_piebuilder_enqueue' ) );

			add_filter( 'plugin_action_links_' .  TP_PIEBUILDER_PLUGIN_BASE_PATH, array( $this, 'tp_piebuilder_add_action_links' ) );
		}

		public function tp_piebuilder_add_action_links ( $links )
		{
			/*
			 * Add Support link to plugin action
			 */
			$mylinks = array(
				'<a href="' . admin_url( 'upload.php?page=tp-piebuilder-admin' ) . '">' . esc_html__( 'Support', 'tp-piebuilder' ) . '</a>',
			);
			return array_merge( $links, $mylinks );
		}

		public function tp_piebuilder_enqueue()
		{
			/*
			 * Enqueue scripts
			 */

            // Load TP Piebuilder style
            wp_enqueue_style( 'tp-piebuilder-style', TP_PIEBUILDER_URL_PATH . 'assets/css/style.min.css' );

            // Load TP Piebuilder custom js
	        wp_enqueue_script( 'tp-piebuilder-script', TP_PIEBUILDER_URL_PATH . 'assets/js/pie.min.js', array() );

	        // Load TP Piebuilder custom js
	        wp_register_script( 'tp-piebuilder-initialize', TP_PIEBUILDER_URL_PATH . 'assets/js/pie-initialize.min.js', array( 'jquery', 'tp-piebuilder-script' ) );

		}

	    public function tp_piebuilder_includes()
		{
			/*
			 * Shortcode Page
			 */
			include_once('includes/tp-setting.php');
			include_once('includes/tp-shortcodes.php');
		}

	}

	new TP_PieBuilder();

endif;
