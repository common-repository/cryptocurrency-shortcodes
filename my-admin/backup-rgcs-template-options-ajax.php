<?php
/*
Template Name: Administrator Options Page Ajax
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/

// if( ! function_exists('rynerG_crypto_select_currencies') ):

// add_action('wp_ajax_nopriv_rynerG_crypto_select_currencies','rynerG_crypto_select_currencies');
// add_action('wp_ajax_rynerG_crypto_select_currencies','rynerG_crypto_select_currencies');
// function rynerG_crypto_select_currencies(){
// 	$arr = $_REQUEST['arr'];
// 	$result['type'] = 'basic';

// 	if($arr == 'remove_all'){
// 		update_option('rynerg__select_currencies','',yes);
// 		$result['list_num'] = '0';
// 	}elseif( $arr == 'all' ){
// 		update_option('rynerg__select_currencies','all',yes);
		
// 	}elseif( $arr == 'onload' || $arr == 'num_reload' ){
// 		$result['type'] = 'onload';
// 		if( get_option('rynerg__select_currencies') !== 'all' ){
// 			$result['list_num'] = count(get_option('rynerg__select_currencies'));
// 		}
// 	}else{
// 		$arra = [];
// 		$arra = explode(',', $arr);
// 		$rynerg__select_currencies = get_option('rynerg__select_currencies');
// 		$new = [];

// 		if($rynerg__select_currencies == 'all'){
// 			update_option('rynerg__select_currencies','',yes);
// 			$result['list_num'] = get_option('rynerg__number_of_currencies_to_retrieve');
// 		}
// 		$rynerg__select_currencies = get_option('rynerg__select_currencies');

// 		if($new == '' || empty($new) || $new === false ){
// 			foreach($arra as $ar){
// 				array_push($new, $ar);
// 			}
// 		}else{
// 			$new = $rynerg__select_currencies;
// 			foreach($arra as $ar){
// 				if( in_array($ar,$new) === false ){
// 					array_push($new, $ar);
// 				}
// 			}
// 		}
// 		update_option('rynerg__select_currencies',$new,yes);
		
// 	}
// 	$list = get_option('rynerg__select_currencies');
// 	if($list == '' || empty($list) || $list == ' ' || $list === false){
// 		$count_list = '0';
// 	}else{
// 		$count_list = count($list);
// 	}
// 	$result['list_num'] = $count_list;
// 	$result['result'] = rynerG_crypto_return_html();
// 	$result['num'] = get_option('rynerg__number_of_currencies_to_retrieve');
// 	$result['select'] = rynerG_crypto_return_select();
	
// 	$result = json_encode($result);
//     echo $result;
//     die();
// }

// endif;


if( ! function_exists('rynerg_cs_select_currencies') ):

add_action('wp_ajax_nopriv_rynerg_rgcs_select_currencies','rynerg_rgcs_select_currencies');
add_action('wp_ajax_rynerg_rgcs_select_currencies','rynerg_rgcs_select_currencies');
function rynerg_rgcs_select_currencies(){

	$rgcs_arr = $_REQUEST['rgcs_arr_holder'];

	if($rgcs_arr == 'remove_all'){
		$blank_arr = [];
		delete_option('rynerg_rgcs_selected_currencies');
		$result['return_count'] = 0;
	}elseif( $rgcs_arr == 'reload_me'){
		$result['return_count'] = count(get_option('rynerg_rgcs_selected_currencies'));
		$result['return_selected_items'] = rynerg_rgcs_return_selected_items();
	}else{
		$rgcs_array = [];
		$rgcs_array = explode(',', $rgcs_arr);
		$new = [];

		foreach($rgcs_array as $arr){
			// if( in_array($arr,$new) === false ){
				array_push($new, $arr);
			// }
		}		
		update_option('rynerg_rgcs_selected_currencies',$new,yes);
		$result['return_count'] = count(get_option('rynerg_rgcs_selected_currencies'));
		$result['return_selected_items'] = rynerg_rgcs_return_selected_items();
	}
	$result['rgcs_arr_holder'] = $rgcs_arr;
	$result = json_encode($result);
    echo $result;
    die();
}

endif;


if( ! function_exists('rynerg_rgcs_return_selected_items') ):
function rynerg_rgcs_return_selected_items(){
	$selected_items = get_option('rynerg_rgcs_selected_currencies');	
	$apiCrypto = new RynerG_crypto_shortcode();
	$apiCrypto = $apiCrypto->callCurrency();
	$data = json_decode($apiCrypto);
	$str = '';
	if($selected_items == true):
	foreach($selected_items as $selected_key=>$id){
		if( !is_null($id) || $id != '' || !emtpy($id) ):
			foreach( $data as $sa ){
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
			$bg = "background-image:url(https://s2.coinmarketcap.com/static/img/coins/16x16/".$id.".png);";
			$additional = 'Market Cap: '.$cap.'<br> Supply: '.$supply.'<br>Price: '.$price.'<br>'.$i.$tags;
			$arr ='<span value="'.$id.'" id="'.$id.'" style="'.$bg.'"> &emsp;'. $name .'&emsp;<i class="fa fa-times"></i> <div class="rgcs_display_other_options_on_hover" style="text-align:left;">'.$additional.'</div> </span>';

			$str = $str.$arr;
		endif;
	}
	endif;
	return $str;
}
endif;
/*
*
* Returns new html display for new selected currencies
*
*/


// if( ! function_exists('rynerG_crypto_return_html') ):

// function rynerG_crypto_return_html(){
// 	$list = get_option('rynerg__select_currencies');
// 	$apiCrypto = new RynerG_crypto_shortcode();
// 	$apiCrypto = $apiCrypto->callCurrency();
// 	$data = json_decode($apiCrypto);
// 	$num = count($list);
// 	$str = '';
// 	// $str = '<div class="rg-title"> <i class="fa fa-hand-point-right"></i> &emsp;Selected Currencies (<b>'.$num.'</b>) </div><br>';
// 	if($list !== false || $list !== 'false' || !empty($list) || $list !== '' || $list != 'all'){
// 		// $str = '<div class="rg-title"> No Currencies Selected </div><br>';
// 	// }elseif($list == 'all'){
// 		// $str = '<div class="rg-title"> Selected Currencies ('.$num.') </div><br>';
// 		// $str = $str.'<span value="all" id="all">All Selected('.$num.')&emsp;&#10006;</span><br>';
// 	// }else{

// 		// $str = '<div class="rg-title"> Selected Currencies </div><br>';
// 		foreach($list as $id){
// 			foreach( $data as $sa ){
// 				foreach($sa as $a){
// 					if(!empty($a->id) && $id == $a->id ){
// 						$cap = $a->quote->USD->market_cap;
// 						$supply = $a->circulating_supply;
// 						$price = "$".$a->quote->USD->price;
// 						$tags = '';
// 						if($a->tags['0'] != '' || !empty($a->tags['0'])){
// 							$tags = '<br><br><strong>'.$a->tags['0'].'</strong>';	
// 						}
// 						$percent_change_24h = $a->quote->USD->percent_change_24h;
// 	    				$per = str_replace("-","",$percent_change_24h);
// 						if( $percent_change_24h > 0)
// 			    			{$i = 'Increased by %'.$per;}
// 			    		else
// 			    			{$i = 'Decreased by %'.$per;}
// 			    		$name = $a->name;		    									
// 						break 1;
// 					}
// 				}
// 			}
// 			$bg = "background-image:url(https://s2.coinmarketcap.com/static/img/coins/16x16/".$id.".png); background-repeat: no-repeat; background-size: 20px; background-position: left;";
// 			$additional = 'Market Cap: '.$cap.'<br> Supply: '.$supply.'<br>Price: '.$price.'<br>'.$i.$tags;
// 			$arr ='<span value="'.$id.'" id="'.$id.'" style="'.$bg.'"> &emsp;'. $name .'&emsp;<i class="fa fa-times"></i> <div class="rgcs_display_other_options_on_hover" style="text-align:left;">'.$additional.'</div> </span>';

// 			$str = $str.$arr;
			
// 		}
// 	}
	
	
// 	return $str;
// }
// endif;


/*
*
* Refresh dropdown for selecting currencies
*
*/


// if( ! function_exists('rynerG_crypto_return_select') ):

// function rynerG_crypto_return_select(){
// 	$list = get_option('rynerg__select_currencies');
// 	$apiCrypto = new RynerG_crypto_shortcode();
// 	$apiCrypto = $apiCrypto->callCurrency();
// 	$data = json_decode($apiCrypto);
// 	$str = '';
	
// 	foreach( $data as $sa ){
// 		foreach($sa as $a){
// 			$additionalClass = '';
// 			if(!empty($a->id)){
// 				if($list !== false || $list !== 'false' || !empty($list) || $list !== '' || $list == 'all'){
// 					if( in_array($a->id, $list) ){
// 						$additionalClass = 'im_selected';
// 					}
// 				}
// 				$str = $str.'<option 
// 					style="font-size: 16px;"
// 					value="'.$a->id.'" 
// 					name="'.$a->name.'" 
// 					class="'.$a->id.' rg_transition_04s '.$additionalClass.'"
// 					supply="'.$a->circulating_supply.'" 
// 					price="$'.$a->quote->USD->price.'" 
// 					percent_change_24h="'.$a->quote->USD->percent_change_24h.'" 
// 					tags="'.$a->tags['0'].'" 
// 					market_cap="'.$a->quote->USD->market_cap.'"  > ' 
// 					.$a->name.'</option>';
// 			}
// 		}
// 	}
// 	return $str;
// }

// endif;


/*
*
* Ajax save number of currencies to retrieve
*
*/


if( ! function_exists('rynerg_rgcs_numbers_save_selected') ):

add_action('wp_ajax_nopriv_rynerg_rgcs_numbers_save_selected','rynerg_rgcs_numbers_save_selected');
add_action('wp_ajax_rynerg_rgcs_numbers_save_selected','rynerg_rgcs_numbers_save_selected');
function rynerg_rgcs_numbers_save_selected(){
	$val = $_REQUEST['val'];
	$get_previous_number = get_option('rynerg__number_of_currencies_to_retrieve');
	$result['remove'] = 'false';
	if(($get_previous_number !== false || !empty($get_previous_number) || $get_previous_number !== '') && ($val < $get_previous_number) ){
		$result['remove'] = 'true';
	}
	update_option('rynerg__number_of_currencies_to_retrieve',$val,yes);
	$result['result'] = get_option('rynerg__number_of_currencies_to_retrieve');

	$result = json_encode($result);
    echo $result;
    die();
}

endif;

?>