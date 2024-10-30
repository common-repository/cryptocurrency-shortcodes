<?php
/*
Template Name: Get Shortcodes
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/
if( ! function_exists('rgcs_template_shortcode') ):
function rgcs_template_shortcode($atts){		
	ob_start();	
	
	$attribs = shortcode_atts(
		array(
			'type' 			=> 'list',
			'max' 			=> '1000',
			'title' 		=> '',
			'bg_color' 		=> '#222',
			'font_color' 	=> '#fff',
			'c_speed' 		=> '9000',
			'c_data_per_slide'		=> '6'
		),$atts
	);

	$type 		= $attribs['type'];
	$max 		= $attribs['max'];
	$bg_color 	= $attribs['bg_color'];
	$font_color = $attribs['font_color'];
	$c_speed 	= $attribs['c_speed'];
	$c_data_per_slide 	= $attribs['c_data_per_slide'];

	if($type == 'list'){
		include('rg-shortcode-template-list.php');
	}elseif($type == 'carousel'){
		?>
		<style>
			.rynerg_rgcs_get_sample_shortcode_carousel, .rgcs_shortcode_carousel_container{ background: <?php echo $bg_color; ?> }
			.rgcs_shortcode_carousel_container{ color: <?php echo $font_color; ?> }
			.rynerg_rgcs_get_sample_shortcode_carousel .rgcs_shortcode_carousel_container > .slick-list > .slick-track{ line-height: 0; }
			.rgcs_carousel_item > span{ width: 16px; height: 16px; padding: 0; display: inline-block; position: relative; left: -10px; top: 3px;}
		</style>
		<?php
		include('rg-shortcode-template-carousel.php');
	}

	return ob_get_clean();
}
add_shortcode( 'rgsc_crypto_shortcode', 'rgcs_template_shortcode');
endif;