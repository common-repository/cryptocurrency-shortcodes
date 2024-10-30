<?php
/*
Template Name: Carousel Shortcode
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/
$get_previous_rate 	= get_option('rynerg_rgcs_refresh_rate_of_currencies'); 


if( $get_previous_rate == 'activated' ){

	$det 		= get_option('rynerg_rgcs_refresh_json_content');
	$now_det 	= new DateTime();
	$apiCrypto 	= new RynerG_crypto_shortcode();
	update_option('rynerg_rgcs_refresh_json_content',$now_det);
	$apiCrypto->callCurrencyRealTime();
}
$data 				= get_option('rynerg_rgcs_api_crypto_json');
$max_countdown 		= $max;
$c_data_per_slide 	= $c_data_per_slide;
$c_speed 			= $c_speed;
$coins_id 			= get_option('rynerg_rgcs_selected_currencies');
$img_url 			= 'https://s2.coinmarketcap.com/static/img/coins/16x16/';

if( $coins_id != false ):
	$ctr_coins	= count($coins_id);	

?>
<div class="rynerg_rgcs_get_sample_shortcode_carousel <?php echo ( $ctr_coins >= 5 ) ? 'rgcs_move_carousel' : ''; ?>" style="visibility: hidden; min-height: 40px;" >
	<div class="rgcs_shortcode_carousel_container" rgcs_recur_carousel = 1 rgcs_recur_left = 0 style="visibility: hidden;" max_countdown = "<?php echo $max_countdown ?>" c_data_per_slide = "<?php echo $c_data_per_slide ?>" c_speed = "<?php echo $c_speed ?>">
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() { 
		jQuery('body').addClass('rynerg_crypto_shortcode_carousel_active');
	});
</script>

<?php endif; 