<?php
/*
Template Name: Administrator Options Page Ajax
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/



/*
*
* Update and Save contents
*
*/
if( ! function_exists('rynerg_cs_select_currencies') ):

add_action('wp_ajax_nopriv_rynerg_rgcs_select_currencies','rynerg_rgcs_select_currencies');
add_action('wp_ajax_rynerg_rgcs_select_currencies','rynerg_rgcs_select_currencies');
function rynerg_rgcs_select_currencies(){
	$data 		= get_option('rynerg_rgcs_api_crypto_json');		
	$rgcs_arr 	= $_REQUEST['rgcs_arr_holder'];
	$result['num_retrieve'] = get_option('rynerg_rgcs_number_of_currencies_to_retrieve');
	if($rgcs_arr == 'remove_all'){

		delete_option('rynerg_rgcs_selected_currencies');
		$result['return_count'] = 0;
		$result['rgcs_arr_holder'] = 'reload_me';
		$result = json_encode($result); echo $result; die();

	}elseif( $rgcs_arr == 'reload_me'){

		rynerg_rgcs_refresh_json_content();
		
		if( get_option('rynerg_rgcs_selected_currencies') == true ){			
			$result['return_count'] = count(get_option('rynerg_rgcs_selected_currencies'));
			$rgcs_arr_return = implode(',',get_option('rynerg_rgcs_selected_currencies'));
			$result['return_selected_items'] = rynerg_rgcs_return_selected_items($data);
			$result['rgcs_arr_holder'] = $rgcs_arr_return;
			$result = json_encode($result); echo $result; die();
		}else{			
			delete_option('rynerg_rgcs_selected_currencies');
			$result['return_count'] = 0;
			$result['rgcs_arr_holder'] = 'reload_me';
			$result = json_encode($result); echo $result; die();
		}
		
	}else{
		$rgcs_array = [];
		$rgcs_array = explode(',', $rgcs_arr);
		$new = [];

		foreach($rgcs_array as $arr){
			array_push($new, $arr);
		}
		update_option('rynerg_rgcs_selected_currencies',$new,yes);
		$result['return_count'] = count(get_option('rynerg_rgcs_selected_currencies'));
		$rgcs_arr_return = implode(',', $new);
		$result['rgcs_arr_holder'] = $rgcs_arr_return;
		$result['return_selected_items'] = rynerg_rgcs_return_selected_items($data);
		$result = json_encode($result); echo $result; die();
	}
	
	
}

endif;



/*
*
* Return HTML of Selected Items
*
*/
if( ! function_exists('rynerg_rgcs_return_selected_items') ):
function rynerg_rgcs_return_selected_items($data_json){
	$selected_items = get_option('rynerg_rgcs_selected_currencies');
	$data 			= $data_json;
	$num_Ctr 		= 0;
	$display_for_selected_items = '';

	if( ( $selected_items == true ) && ( $data == true ) ):
	foreach($selected_items as $selected_key=>$id){
		if( !is_null($selected_key) || $id != '' || !emtpy($id) || isset($selected_key) ):
			foreach( $data as $data_key=>$sa ){
				if( !is_null($data_key) || $sa != '' || !emtpy($data_key) || isset($data_key) || $sa != '' || $sa != null || isset($sa)){
					foreach($sa as $a){
						if(!empty($a->id) && $id == $a->id ){
							$cap = $a->quote->USD->market_cap;
							$supply = $a->circulating_supply;
							$price = "$".$a->quote->USD->price;
							$tags = '';						
							if(isset($a->tags)){
								foreach($a->tags as $tag){
									if(isset($tag) || $tag != ''){
										$tags = $tags.' <br><br>'.$tag;
									}
								}	
							}
							$percent_change_24h = $a->quote->USD->percent_change_24h;
		    				$per = str_replace("-","",$percent_change_24h);
							if( $percent_change_24h > 0)
				    			{$i = 'Increased by %'.$per;}
				    		else
				    			{$i = 'Decreased by %'.$per;}
				    		$name = $a->name;
							break 1;
						}
					}
				}
			}
			$bg = "background-image:url(https://s2.coinmarketcap.com/static/img/coins/16x16/".$id.".png);";
			$additional = 'Market Cap: '.$cap.'<br> Supply: '.$supply.'<br>Price: '.$price.'<br>'.$i.$tags;
			$arr ='<span value="'.$id.'" id="'.$id.'" style="'.$bg.'"> &emsp;'. $name .'&emsp;<i class="fa fa-times"></i> <div class="rgcs_display_other_options_on_hover" style="text-align:left;">'.$additional.'</div> </span>';

			$display_for_selected_items = $display_for_selected_items.$arr;	
		endif;
	}
	else:
		$display_for_selected_items = 'Nothing Selected Yet';		 
	endif;
		
	return $display_for_selected_items;
}
endif;



/*
*
* Retrieve and save number of coins to retrieve
*
*/
if( ! function_exists('rynerg_rgcs_numbers_save_selected') ):

add_action('wp_ajax_nopriv_rynerg_rgcs_numbers_save_selected','rynerg_rgcs_numbers_save_selected');
add_action('wp_ajax_rynerg_rgcs_numbers_save_selected','rynerg_rgcs_numbers_save_selected');
function rynerg_rgcs_numbers_save_selected(){
	$val 					= $_REQUEST['val'];
	$ret 					= $_REQUEST['ret'];

	$get_previous_number 	= get_option('rynerg_rgcs_number_of_currencies_to_retrieve');

	$result['remove'] 		= 'false';

	if(($get_previous_number !== false || !empty($get_previous_number) || $get_previous_number !== '') && ($val < $get_previous_number) ){
		$result['remove'] = 'true';
	}

	update_option('rynerg_rgcs_number_of_currencies_to_retrieve',$val,yes);

	if( $ret == 'activate' ){
		
		update_option('rynerg_rgcs_refresh_rate_of_currencies','activated');
		$det 		= get_option('rynerg_rgcs_refresh_json_content');
		$now_det 	= new DateTime();
		$apiCrypto 	= new RynerG_crypto_shortcode();
		update_option('rynerg_rgcs_refresh_json_content',$now_det);
		$apiCrypto->callCurrencyRealTime();

	}else{
		update_option('rynerg_rgcs_refresh_rate_of_currencies','deactivated');
	}
	$result['ret'] = get_option('rynerg_rgcs_refresh_rate_of_currencies');
	

	$result['result'] = get_option('rynerg_rgcs_number_of_currencies_to_retrieve');

	$result = json_encode($result); echo $result; die();
}

endif;



/*
*
* Refresh Jason Content in Database
*
*/
if( ! function_exists('rynerg_rgcs_refresh_json_content') ):

function rynerg_rgcs_refresh_json_content(){
	$det 		= get_option('rynerg_rgcs_refresh_json_content');
	$now_det 	= new DateTime();
	$det_cmp 	= $det->add(new DateInterval('P15D'));	

	if( $now_det > $det_cmp ){
		update_option('rynerg_rgcs_refresh_json_content',$now_det);
		$apiCrypto = new RynerG_crypto_shortcode();
		$data = $apiCrypto->callCurrency();
		update_option('rynerg_rgcs_api_crypto_json',$data,yes);
	}	
}

endif;



/*
*
* Return sample html for each shortcodes admin
*
*/
add_action('wp_ajax_nopriv_rynerg_rgcs_view_sample_shortcodes','rynerg_rgcs_view_sample_shortcodes');
add_action('wp_ajax_rynerg_rgcs_view_sample_shortcodes','rynerg_rgcs_view_sample_shortcodes');
if( ! function_exists('rynerg_rgcs_view_sample_shortcodes') ):

function rynerg_rgcs_view_sample_shortcodes(){
	$rgcs_sample_shortcode = $_REQUEST['rgcs_sample_shortcode'];
	$type 		= $_REQUEST['type'];
	$data 		= get_option('rynerg_rgcs_api_crypto_json');
	$coins_id	= get_option('rynerg_rgcs_selected_currencies');

	if( $coins_id == true ){
		$result['content_stat'] = 'not_empty';
		if($type == 'list'){
			$result['content'] = rynerg_rgcs_get_sample_shortcode_list($rgcs_sample_shortcode);
		}elseif($type == 'carousel'){
			$result['content'] = rynerg_rgcs_get_sample_shortcode_carousel($rgcs_sample_shortcode);
		}

	}else{
		$result['content_stat'] = 'empty';
	}
	
	$result['content_type'] = $type;
	$result = json_encode($result); echo $result; die();
}

endif;


add_action('wp_ajax_nopriv_rynerg_rgcs_carousel','rynerg_rgcs_carousel');
add_action('wp_ajax_rynerg_rgcs_carousel','rynerg_rgcs_carousel');
if( ! function_exists('rynerg_rgcs_carousel') ):

function rynerg_rgcs_carousel(){
	$max_countdown 		= (int)$_REQUEST['max_countdown'];
	$get_previous_rate 	= get_option('rynerg_rgcs_refresh_rate_of_currencies'); 


	if( $get_previous_rate == 'activated' ){

		$det 		= get_option('rynerg_rgcs_refresh_json_content');
		$now_det 	= new DateTime();
		$apiCrypto 	= new RynerG_crypto_shortcode();
		update_option('rynerg_rgcs_refresh_json_content',$now_det);
		$apiCrypto->callCurrencyRealTime();
	}
	$data 				= get_option('rynerg_rgcs_api_crypto_json');
	$coins_id 			= get_option('rynerg_rgcs_selected_currencies');
	$img_url 			= 'https://s2.coinmarketcap.com/static/img/coins/16x16/';

	if( $coins_id != false ):
		$ctr_coins	= count($coins_id);	
		$con_class = ( $ctr_coins >= 5 ) ? 'rgcs_move_carousel' : '';
		$res_string = '';
		foreach ($coins_id as $c_id):
			if($max_countdown > 0 ){
				$res_string = $res_string."<span class='rgcs_carousel_item'>";
				foreach ( $data as $data_key=>$da ){
					foreach ($da as $val) {
						if(!empty($val->id) && $c_id == $val->id ){

							$p_change_24h = $val->quote->USD->percent_change_24h;
		    				$p_24h = number_format( (float)str_replace("-","",$p_change_24h),2,'.','');
							if( $p_change_24h > 0)
				    			{$p_change_24h = '<i class="fas fa-long-arrow-alt-up" style="color:#0073aa;"></i>  %'.$p_24h;}
				    		else
				    			{$p_change_24h = '<i class="fas fa-long-arrow-alt-down" style="color:#d82222;"></i>  %'.$p_24h;}

				    		$bg = "background:url('".$img_url.$val->id.".png'); background-size: cover; background-repeat: no-repeat; ";
				    		$res_string = $res_string.'<span style="'.$bg.' "></span>'.$val->name.'&emsp; $'.number_format($val->quote->USD->price,4,'.',',').'&emsp;'.$p_change_24h;
							break 2;
						}
					}
				}
				$res_string = $res_string."</span>";	

			}
			$max_countdown--;
			
		endforeach;	

		$result['s'] = $res_string;

	endif; 

	$result['c_speed'] 	= $_REQUEST['c_speed'];
	$result['c_num'] 	= $_REQUEST['c_data_per_slide'];
	
	$result = json_encode($result); echo $result; die();
}

endif;

function rynerg_rgcs_get_sample_shortcode_list($rgcs_sample_shortcode){
	ob_start();
		include('admin-return-html-templates/rg-shortcode-template-list.php');
	return ob_get_clean();
}

function rynerg_rgcs_get_sample_shortcode_carousel(){
	ob_start();		
		include('admin-return-html-templates/rg-shortcode-template-carousel.php');	
	return ob_get_clean();
}