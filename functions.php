<?php
/*
Plugin Name: Cryptocurrency Shortcodes
Plugin URI: 
Description: Simple plugin that retrieves cryptocurrencies(coins) made available by <a href="https://coinmarketcap.com/all/views/all/" target="_blank">coinmarketcap</a> through our API.
Version: 0.2
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Copyright: Ryner S. Galaus
Text Domain: rynerg_rgcs
Domain Path: /lang
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( ! class_exists('RynerG_crypto_shortcode') ) :

class RynerG_crypto_shortcode {
	
	function __construct() { /* Do nothing here */ }

	function initialize() {

		$basename = plugin_basename( __FILE__ );
		$path = plugin_dir_path( __FILE__ );
		$url = plugin_dir_url( __FILE__ );
		$slug = dirname($basename);
		if(!defined('rg__Plugin_LINK')){
			define('rg__Plugin_LINK',plugin_dir_url(__FILE__));
		}

		if( is_admin() ) {
			add_action('admin_menu', array($this, 'rynerg_register_fields_crypto'), 5);
			add_action( 'admin_enqueue_scripts', array($this,'rynerg__crypto_enqueue_admin_scripts_and_styles') );
		}		
		
		add_action( 'wp_enqueue_scripts', array($this,'rynerg__crypto_enqueue_client_scripts_and_styles') );
		if( ! class_exists('APIREST')){
			require_once('crypto_api/api_helper.php');	
		}
		$now_det = new DateTime();
		update_option('rynerg_rgcs_refresh_json_content',$now_det);

		$check_content = get_option('rynerg_rgcs_api_crypto_json');
		if($check_content == false){
			$ApiKey = file_get_contents(rg__Plugin_LINK.'crypto_api/api_my_key.txt');
			$CoinsUrl ='https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?sort=market_cap&start=1&limit=10&convert=USD&cryptocurrency_type=coins';
			$APIREST = new APIREST($CoinsUrl);
		 	$CallCoins = $APIREST->call(
		        array('X-CMC_PRO_API_KEY:'.$ApiKey)
		    );

			$data_json = json_decode($CallCoins);
			update_option('rynerg_rgcs_api_crypto_json',$data_json);
			update_option('rynerg_rgcs_number_of_currencies_to_retrieve',10);	
		}
		

	}

	function callCurrency(){		
		$det = get_option('rynerg_rgcs_refresh_json_content');
		$now_det = new DateTime();
		$det_cmp = $det->add(new DateInterval('P30D'));
		$data_json = get_option('rynerg_rgcs_api_crypto_json');

		if($now_det > $det_cmp){
			$ApiKey = file_get_contents(rg__Plugin_LINK.'crypto_api/api_my_key.txt');
			$CoinsUrl ='https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?sort=market_cap&start=1&limit=10&convert=USD&cryptocurrency_type=coins';
			$APIREST = new APIREST($CoinsUrl);
		 	$CallCoins = $APIREST->call(
		        array('X-CMC_PRO_API_KEY:'.$ApiKey)
		    );

			$data_json = json_decode($CallCoins);
			$new_data_json = update_option('rynerg_rgcs_api_crypto_json',$data_json,yes);
			return $new_data_json;
		}else{
			return $data_json;
		}		    			
	}

	function callCurrencyRealTime(){
		$ApiKey 		= file_get_contents(rg__Plugin_LINK.'crypto_api/api_my_key.txt');
		$CoinsUrl 		='https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?sort=market_cap&start=1&limit=30&convert=USD&cryptocurrency_type=coins';
		$APIREST 		= new APIREST($CoinsUrl);
	 	$CallCoins 		= $APIREST->call( array('X-CMC_PRO_API_KEY:'.$ApiKey) );
		$data_json 		= json_decode($CallCoins);
		$new_data_json 	= update_option('rynerg_rgcs_api_crypto_json',$data_json);

		return $new_data_json;
	}

	function define_me(){
		$define_me['rg__Plugin_LINK'] = plugin_dir_url(__FILE__);
		return $define_me;
	}


	function rynerg_register_fields_crypto() {
			add_submenu_page( 
				'options-general.php', 
				'Cryptocurrency', 
				'Cryptocurrency Shortcodes', 
				'manage_options', 
				'rynerg_rgcs', 
				'rynerg_rgcs_callback' );
	}

	function rynerg__crypto_enqueue_admin_scripts_and_styles(){
    
	    wp_register_style( 'admin_css_crypto', rg__Plugin_LINK.'assets/admin_css_crypto.css', null, 1.0, 'screen' );
	    wp_enqueue_style( 'admin_css_crypto' );

	    wp_register_script( 'admin_js_crypto', rg__Plugin_LINK.'assets/admin_js_crypto.js', array( 'jquery' ), 1.0, true );
	    wp_enqueue_script( 'admin_js_crypto' );

	    if( (! wp_style_is('admin_font_awesome_css_crypto', 'registered ') ) || (! wp_style_is('admin_font_awesome_css_crypto', 'enqueued ') ) ){

	    wp_register_style( 'admin_font_awesome_css_crypto', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', null, 1.0, 'screen' );
	    wp_enqueue_style( 'admin_font_awesome_css_crypto' );

		}

	    wp_register_style( 'admin_extend_client_css_crypto', rg__Plugin_LINK.'assets/client_css_crypto.css', null, 1.0, 'screen' );
	    wp_enqueue_style( 'admin_extend_client_css_crypto' );

	    wp_register_script( 'client_js_crypto', rg__Plugin_LINK.'assets/client_js_crypto.js', array( 'jquery' ), 1.0, true );
	    wp_enqueue_script( 'client_js_crypto' );
	    wp_localize_script( 'client_js_crypto', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));       

		if( (! wp_style_is('rsg_admin_slick', 'registered ') ) || (! wp_style_is('rsg_admin_slick', 'enqueued ') ) ){

			wp_register_style( 'rsg_admin_slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', null, 1.0, 'screen' );
		    wp_enqueue_style( 'rsg_admin_slick-theme' );

		    wp_register_style( 'rsg_admin_slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', null, 1.0, 'screen' );
	    	wp_enqueue_style( 'rsg_admin_slick-css' );

	    	wp_register_script( 'rsg_admin_slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js', array( 'jquery' ), 1.0, true );
	    	wp_enqueue_script( 'rsg_admin_slick-js' );

		}
	    

	}

	function rynerg__crypto_enqueue_client_scripts_and_styles(){
    
	    wp_register_style( 'client_css_crypto', rg__Plugin_LINK.'assets/client_css_crypto.css', null, 1.0, 'screen' );
	    wp_enqueue_style( 'client_css_crypto' );

	    wp_register_script( 'client_js_crypto', rg__Plugin_LINK.'assets/client_js_crypto.js', array( 'jquery' ), 1.0, true );
	    wp_enqueue_script( 'client_js_crypto' );
	    wp_localize_script( 'client_js_crypto', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));       

	    if( (! wp_style_is('client_font_awesome_css_crypto', 'registered ') ) || (! wp_style_is('client_font_awesome_css_crypto', 'enqueued ') ) ){

	    	wp_register_style( 'client_font_awesome_css_crypto', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', null, 1.0, 'screen' );
	    	wp_enqueue_style( 'client_font_awesome_css_crypto' );	

	    }

	    if( (! wp_style_is('rsg_client_slick', 'registered ') ) || (! wp_style_is('rsg_client_slick', 'enqueued ') ) ){

			wp_register_style( 'rsg_client_slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', null, 1.0, 'screen' );
		    wp_enqueue_style( 'rsg_client_slick-theme' );

		    wp_register_style( 'rsg_client_slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', null, 1.0, 'screen' );
	    	wp_enqueue_style( 'rsg_client_slick-css' );

	    	wp_register_script( 'rsg_client_slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js', array( 'jquery' ), 1.0, true );
	    	wp_enqueue_script( 'rsg_client_slick-js' );

		}
	    
	}

}
endif;


require_once('my-admin/rgcs-template-options.php');
require_once('my-admin/rgcs-template-options-ajax.php');
require_once('my-admin/admin-return-html-templates/rg-shortcode-template.php');

if( !function_exists('rynerg_rgcs_initialize_class') ):

	function rynerg_rgcs_deactivation_unsinstall(){

		if((isset($_GET['action']) == 'deactivate') && (isset($_GET['plugin']) == 'rg-cryptocurrency-shortcode') ){
			delete_option('rynerg_rgcs_refresh_json_content');
			delete_option('rynerg_rgcs_api_crypto_json');
			delete_option('rynerg_rgcs_selected_currencies');
			delete_option('rynerg_rgcs_number_of_currencies_to_retrieve');	
			delete_option('rynerg_rgcs_refresh_rate_of_currencies');
		}

	}

	function rynerg_rgcs_initialize_class(){
		global $RynerG_crypto_shortcode;	

		
		if( !isset($RynerG_crypto_shortcode) ) {
			if( ! defined('rynerg_crypto_plugin_version') ){
				define ( 'rynerg_crypto_plugin_version', '0.2');	
			}
			
		
			$rsg_version = get_option( 'rynerg_crypto_current_plugin_version' );

			if($rsg_version == false || $rsg_version === false){
				update_option( 'rynerg_crypto_current_plugin_version', rynerg_crypto_plugin_version);
			}else{
				if($rsg_version < rynerg_crypto_plugin_version){

				}else{

				}
			}
		
			$RynerG_crypto = new RynerG_crypto_shortcode();
			
			$RynerG_crypto->initialize();			

		}
	
		return $RynerG_crypto;
	}

	function rynerg_crypto_check_version(){
		$rsg_version = get_option( 'rynerg_crypto_current_plugin_version' );

		if($rsg_version == false || $rsg_version === false){
			update_option( 'rynerg_crypto_current_plugin_version', rynerg_crypto_plugin_version);
		}else{
			if($rsg_version !== rynerg_crypto_plugin_version){

				// rynerg_rgcs_initialize_class();
			}
		}
	}

endif;
add_action('plugins_loaded', 'rynerg_crypto_check_version');
rynerg_rgcs_initialize_class();
rynerg_rgcs_deactivation_unsinstall();
?>
