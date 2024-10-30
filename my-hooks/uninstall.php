<?php
/*
Template Name: Uninstall Cryptocurrency
*/

if( $rg__type_action == 'deactivate' ){

	if (!defined('WP_UNINSTALL_PLUGIN')) {
	    die;
	}

	delete_option('rynerg_rgcs_refresh_json_content');
	delete_option('rynerg_rgcs_api_crypto_json');
	delete_option('rynerg_rgcs_selected_currencies');
	delete_option('rynerg_rgcs_number_of_currencies_to_retrieve');	
	flush_rewrite_rules();

}elseif($rg__type_action == 'uninstall'){

	if (!defined('WP_UNINSTALL_PLUGIN')) {
	    die;
	}		
	delete_option('rynerg_rgcs_refresh_json_content');
	delete_option('rynerg_rgcs_api_crypto_json');
	delete_option('rynerg_rgcs_selected_currencies');
	delete_option('rynerg_rgcs_number_of_currencies_to_retrieve');	
	flush_rewrite_rules();

}