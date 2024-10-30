<?php
/*
Template Name: rrency Shortcode Admin Options Page
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/


function rynerg_rgcs_callback(){
	// $apiCrypto = new RynerG_crypto_shortcode();
	// $apiCrypto = $apiCrypto->callCurrency();
	// $items = json_decode($apiCrypto);
	$p_link 			= new RynerG_crypto_shortcode();
	$p_link 			= $p_link->define_me()['rg__Plugin_LINK'];	
	$redirect_uri 		= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$img_url 			= 'https://s2.coinmarketcap.com/static/img/coins/16x16/';
	$num_retrieve 		= get_option('rynerg_rgcs_number_of_currencies_to_retrieve');
	$items 				= get_option('rynerg_rgcs_api_crypto_json');
	$selected_items 	= get_option('rynerg_rgcs_selected_currencies');
?>

<div class="rynerg_cs_container">	
	<p class="rgcs_big_title rgcs_logo">
		<img src="<?php echo $p_link; ?>/my-images/rgcs_crypto_logo.png" class="rg_logo">
	&emsp;Cryptocurrency Shortcodes</p>
	<br>
	<div class="rgcs__tabs">
		<div class="rgcs_tab" >
			<button class="rgcs_tab_btn active" retreive_me='rgcs_tab_general'>
				General
			</button>
		</div>
		<div class="rgcs_tab" >
			<button class="rgcs_tab_btn" retreive_me='rgcs_tab_select'>
				Select Currencies
			</button>
		</div>
		<div class="rgcs_tab" >
			<button class="rgcs_tab_btn" retreive_me='rgcs_tab_shortcode'>
				Shortcodes
			</button>
		</div>
		<div class="rgcs_tab" >
			<button class="rgcs_tab_btn" retreive_me='rgcs_tab_shots'>
				Screenshots
			</button>
		</div>
		<div class="rgcs_tab" >
			<button class="rgcs_tab_btn" retreive_me='rgcs_tab_others'>
				Others
			</button>
		</div>	
	</div>
	<div class="rgcs__tab_contents">
		<div class="rgcs__tab_content rgcs_tab_general active">
			<div class="rgcs__tab_title">General</div>
			<?php include('rgcs-template-tab-content-general.php'); ?>
		</div>
		<div class="rgcs__tab_content rgcs_tab_select">
			<div class="rgcs__tab_title">Select Coins to Display</div>
			<?php include('rgcs-template-tab-content-select.php'); ?>
		</div>
		<div class="rgcs__tab_content rgcs_tab_shortcode">
			<div class="rgcs__tab_title">Shortcodes</div>
			<?php include('rgcs-template-tab-content-shortcode.php'); ?>
		</div>
		<div class="rgcs__tab_content rgcs_tab_shots">
			<div class="rgcs__tab_title">Screenshots</div>
			<?php include('rgcs-template-tab-content-screenshots.php'); ?>
		</div>

		<div class="rgcs__tab_content rgcs_tab_others">
			<div class="rgcs__tab_title">Others</div>
			<?php include('rgcs-template-tab-content-others.php'); ?>
		</div>
	</div>
</div>

<?php } ?>