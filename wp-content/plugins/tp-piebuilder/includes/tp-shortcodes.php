<?php
/**
 * TP Piebuilder Shortcode
 *
 * @package TP PieBuilder
 * @since 0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TP_PieBuilder_Shortcode {

	public function __construct() 
	{
		$this->tp_piebuilder_create_shortcode();
	}

	public function tp_piebuilder_shortcode_function( $atts ) 
	{
		/*
		 * Default Pie Chart Shortcode Function
		 */
		
		ob_start();
			$input = shortcode_atts( array(
					'title'		=> '',
				    'values' 	=> '',
				    'labels'	=> '',
				    'fontfamily' => 'ariel',
				    'fontstyle' => 'italic',
				    'colors'	=> '#F16745, #FFC65D, #7BC8A4, #4CC3D9, #93648D, #475F77, #ebbe83, #79a8f7, #f87272, #adabab',
				), $atts );
			$quotes = array( "\"", "'" );
			$title 			= $input['title']; 
			$fontfamily 	= esc_attr( $input['fontfamily'] ); 
			$fontstyle 		= esc_attr( $input['fontstyle'] ); 
			$percentages 	= explode( ',', str_replace( $quotes, '', $input['values'] ) );
			$labels 		= explode( ',', str_replace( "\"", '', $input['labels'] ) );
			$colors 		= explode( ',', str_replace( $quotes, '', $input['colors'] ) );
			$radius			= array( 120, 120, 120, 120, 120, 120, 120, 120, 120, 120 );
			$id 			= uniqid( 'tp_pie_', false ); 
			?>
			<div class="tp-piebuilderWrapper" data-id="tp_pie_data_<?php echo esc_attr( $id ); ?>">
				<h3 class="pie-title"><?php echo esc_html( $title ); ?></h3>
		    	<canvas id="<?php echo esc_attr( $id ); ?>" width="600" height="600">
		        </canvas>
		    </div>
		    <?php  
		    $tp_pie_data = array(
		    	'canvas_id'	=> $id,
		    	'percent'	=> $percentages,
		    	'label'		=> $labels,
		    	'color'		=> $colors,
		    	'circle'	=> 0,
		    	'radius'	=> $radius,
		    	'fontstyle'	=> $fontstyle,
		    	'fontfamily' => $fontfamily,
		    	);

		    wp_localize_script( 'tp-piebuilder-initialize', 'tp_pie_data_'.$id, $tp_pie_data );
				
			// enqueue bar js
			wp_enqueue_script( 'tp-piebuilder-initialize' );
		return ob_get_clean();
	}

	public function tp_piebuilder_doughnut_shortcode_function( $atts ) 
	{
		/*
		 * Doughnut Pie Chart Shortcode Function
		 */
		
		ob_start();
			$input = shortcode_atts( array(
					'title'		=> '',
				    'values' 	=> '',
				    'labels'	=> '',
				    'fontfamily' => 'arial',
				    'fontstyle' => 'italic',
				    'colors'	=> '#F16745, #FFC65D, #7BC8A4, #4CC3D9, #93648D, #475F77, #ebbe83, #79a8f7, #f87272, #adabab',
				), $atts );
			$quotes = array( "\"", "'" );
			$title 			= $input['title']; 
			$fontfamily 	= esc_attr( $input['fontfamily'] ); 
			$fontstyle 		= esc_attr( $input['fontstyle'] ); 
			$percentages 	= explode( ',', str_replace( $quotes, '', $input['values'] ) );
			$labels 		= explode( ',', str_replace( "\"", '', $input['labels'] ) );
			$colors 		= explode( ',', str_replace( $quotes, '', $input['colors'] ) );
			$radius			= array( 100, 100, 100, 100, 100, 100, 100, 100, 100, 100 );
			$id 			= uniqid( 'tp_doughnut_', false ); 
			?>
			<div class="tp-piebuilderWrapper" data-id="tp_pie_data_<?php echo esc_attr( $id ); ?>">
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="pie-title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
		    	<canvas id="<?php echo esc_attr( $id ); ?>" width="600" height="600">
		        </canvas>
		    </div>
		    <?php  
		    $tp_pie_data = array(
		    	'canvas_id'	=> $id,
		    	'percent'	=> $percentages,
		    	'label'		=> $labels,
		    	'color'		=> $colors,
		    	'circle'	=> 45,
		    	'radius'	=> $radius,
		    	'fontstyle'	=> $fontstyle,
		    	'fontfamily' => $fontfamily,
		    	);

		    wp_localize_script( 'tp-piebuilder-initialize', 'tp_pie_data_'.$id, $tp_pie_data );
				
			// enqueue bar js
			wp_enqueue_script( 'tp-piebuilder-initialize' );
		return ob_get_clean();
	}

	public function tp_piebuilder_polar_shortcode_function( $atts ) 
	{
		/*
		 * Polar Pie Chart Shortcode Function
		 */
		
		ob_start();
			$input = shortcode_atts( array(
					'title'		=> '',
				    'values' 	=> '',
				    'labels'	=> '',
				    'fontfamily' => 'arial',
				    'fontstyle' => 'italic',
				    'colors'	=> '#F16745, #FFC65D, #7BC8A4, #4CC3D9, #93648D, #475F77, #ebbe83, #79a8f7, #f87272, #adabab',
				), $atts );
			$quotes = array( "\"", "'" );
			$title 			= $input['title']; 
			$fontfamily 	= esc_attr( $input['fontfamily'] ); 
			$fontstyle 		= esc_attr( $input['fontstyle'] ); 
			$percentages 	= explode( ',', str_replace( $quotes, '', $input['values'] ) );
			$labels 		= explode( ',', str_replace( "\"", '', $input['labels'] ) );
			$colors 		= explode( ',', str_replace( $quotes, '', $input['colors'] ) );
			$radius			= array( 125, 135, 130, 140, 135, 130, 120, 130, 140, 130 );
			$id 			= uniqid( 'tp_polar_', false ); 
			?>
			<div class="tp-piebuilderWrapper" data-id="tp_pie_data_<?php echo esc_attr( $id ); ?>">
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="pie-title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
		    	<canvas id="<?php echo esc_attr( $id ); ?>" width="600" height="600">
		        </canvas>
		    </div>
		    <?php  
		    $tp_pie_data = array(
		    	'canvas_id'	=> $id,
		    	'percent'	=> $percentages,
		    	'label'		=> $labels,
		    	'color'		=> $colors,
		    	'circle'	=> 15,
		    	'radius'	=> $radius,
		    	'fontstyle'	=> $fontstyle,
		    	'fontfamily' => $fontfamily,
		    	);

		    wp_localize_script( 'tp-piebuilder-initialize', 'tp_pie_data_'.$id, $tp_pie_data );
				
			// enqueue bar js
			wp_enqueue_script( 'tp-piebuilder-initialize' );
		return ob_get_clean();
	}

	public function tp_piebuilder_bar_shortcode_function( $atts ) 
	{
		/*
		 * Bar Graph Shortcode Function
		 */
		
		ob_start();
			$input = shortcode_atts( array(
					'title'		=> '',
				    'values' 	=> '',
				    'labels'	=> '',
				    'colors'	=> '#F16745, #FFC65D, #7BC8A4, #4CC3D9, #93648D, #475F77, #ebbe83, #79a8f7, #f87272, #adabab',
				), $atts );
			$quotes = array( "\"", "'" );
			$title 			= $input['title']; 
			$percentages 	= explode( ',', str_replace( $quotes, '', $input['values'] ) );;
			$labels 		= explode( ',', str_replace( "\"", '', $input['labels'] ) );
			$colors 		= explode( ',', str_replace( $quotes, '', $input['colors'] ) );
			$count 			= count( $labels )-1;
			$id 			= uniqid( 'tp_bar_', false ); 
			?>
			<div class="tp-bar" data-id="tp_bar_data_<?php echo esc_attr( $id ); ?>">
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="pie-title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
				<div class="tp-skills-bar">

					<?php if ( $count > 0 ) :
						for ( $i = 0; $i <= $count; $i++ ) : 
						?>
						<div class="outer-box">
							<div id="<?php echo esc_attr( $id ) . '_' . $i; ?>" class="inner-fill" style="background-color: <?php echo esc_attr( $colors[$i] ); ?>; height: <?php echo absint( $percentages[$i] ) . '%'; ?>">
								<span class="percent-value"><?php echo absint( $percentages[$i] ) . '%'; ?></span>
							</div><!-- .inner-fill -->
						</div><!-- .outer-box -->
						<?php 
						endfor;  
					endif; ?>

				</div><!-- .skills-bar -->

				<ul class="tp-skill-items">
					<?php if ( $count > 0 ) :
						for ( $i = 0; $i <= $count; $i++ ) : 
						?>
						<li><span class="color" style="background-color: <?php echo esc_attr( $colors[$i] ); ?>"></span><span><?php echo esc_html( $labels[$i] ); ?></span></li>
						<?php 
						endfor; 
					endif; ?>
				</ul>
			</div>
		<?php 
		return ob_get_clean();
	}

	public function tp_piebuilder_horizontal_bar_shortcode_function( $atts ) 
	{
		/*
		 * Horizontal Bar Graph Shortcode Function
		 */
		
		ob_start();
			$input = shortcode_atts( array(
					'title'		=> '',
				    'values' 	=> '',
				    'labels'	=> '',
				    'colors'	=> '#F16745, #FFC65D, #7BC8A4, #4CC3D9, #93648D, #475F77, #ebbe83, #79a8f7, #f87272, #adabab',
				), $atts );
			$quotes = array( "\"", "'" );
			$title 			= $input['title']; 
			$percentages 	= explode( ',', str_replace( $quotes, '', $input['values'] ) );;
			$labels 		= explode( ',', str_replace( "\"", '', $input['labels'] ) );
			$colors 		= explode( ',', str_replace( $quotes, '', $input['colors'] ) );
			$count 			= count( $labels )-1;
			$id 			= uniqid( 'tp_horizontalbar_', false ); 
			?>
			<div class="tp-horizontalbar" data-id="tp_horizontalbar_data_<?php echo esc_attr( $id ); ?>">
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="pie-title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
				<div class="tp-skills-horizontalbar">

					<?php if ( $count > 0 ) :
						for ( $i = 0; $i <= $count; $i++ ) : 
						?>
						<div class="outer-box">
							<div id="<?php echo esc_attr( $id ) . '_' . $i; ?>" class="inner-fill" style="background-color: <?php echo esc_attr( $colors[$i] ); ?>; width: <?php echo absint( $percentages[$i] ) . '%'; ?>">
								<span class="percent-value"><?php echo absint( $percentages[$i] ) . '%'; ?></span>
							</div><!-- .inner-fill -->
							<span class="skill-name"><?php echo esc_html( $labels[$i] ); ?></span>
						</div><!-- .outer-box -->
						<?php 
						endfor;  
					endif; ?>

				</div><!-- .skills-bar -->
			</div>

			<?php 
		return ob_get_clean();
	}

	public function tp_piebuilder_create_shortcode() 
	{
		/*
		 * Create Shortcodes
		 */
		add_shortcode( 'TP_PIEBUILDER', array( $this, 'tp_piebuilder_shortcode_function' ) );
		add_shortcode( 'TP_PIEBUILDER_DOUGHNUT', array( $this, 'tp_piebuilder_doughnut_shortcode_function' ) );
		add_shortcode( 'TP_PIEBUILDER_POLAR', array( $this, 'tp_piebuilder_polar_shortcode_function' ) );
		add_shortcode( 'TP_PIEBUILDER_BAR', array( $this, 'tp_piebuilder_bar_shortcode_function' ) );
		add_shortcode( 'TP_PIEBUILDER_HORIZONTAL_BAR', array( $this, 'tp_piebuilder_horizontal_bar_shortcode_function' ) );
	}

}

new TP_PieBuilder_Shortcode();
