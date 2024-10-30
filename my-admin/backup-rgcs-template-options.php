<?php
/*
Template Name: rrency Shortcode Admin Options Page
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/


function rynerg__cryptocurrency_callback(){

	$rg__Plugin_LINK = new RynerG_crypto_shortcode();
	$rg__Plugin_LINK = $rg__Plugin_LINK->define_me()['rg__Plugin_LINK'];	

	$apiCrypto = new RynerG_crypto_shortcode();
	$apiCrypto = $apiCrypto->callCurrency();

	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$img_url = 'https://s2.coinmarketcap.com/static/img/coins/16x16/';
	$list = get_option('rynerg__select_currencies');
	
	if($list == '' || empty($list) || $list == ' ' || $list === false){
		$count_list = '0';
	}else{
		$count_list = count($list);
	}

	
	$num = get_option('rynerg__number_of_currencies_to_retrieve');

?>

<div class="rg-sheet-options">
	<p class="rg-big-title rg-contents"><i class="fa fa-coins"></i>&nbsp;Cryptocurrency Shortcodes</p>
	<hr>
	
	<br>
	<div class="rg-contents">
		<?php
			$data = json_decode($apiCrypto);
			?>
			<div class="rg-currencies__general">
				<div class="rg-title" style="padding:10px;">
					<i class="fa fa-hand-point-right"></i> &emsp;General
				</div>

				<div class="" style="padding-left: 30px;">
					<div class="rg-select-numbers" style="position: relative;">
						<div class="rg-title">Number of cryptocurrencies to retrieve</div>
						<br>
						<div style="position: relative;">
							<input type="number" class="rg-num-to-retrieve" placeholder="Number of coins to retrieve" value="<?php echo $num; ?>">
							<button type="button" class="save_selected rg_transition_04s">Save</button>
						</div>
						<div style="max-width:800px; padding-left: 15px;">
							<i>Note: This sets the number of currencies to retrieve from <a href="https://coinmarketcap.com/all/views/all/" target="_blank"> coinmarketcap.com</a>. Leave blank to set to 10.
							<br>
							<span class="fa fa-exclamation">&nbsp;</span>Important Note: The higher the number the slower the loading process. Loadspeed of your site will not be affected since all requests happen after the page has loaded but actions for the carousel and slider will only start once all data are collected.
							<br><br>
							If options for <b>SELECT CURRENCIES TO DISPLAY</b> didn't update, please refresh the page.  </i>
						</div>
					</div>
					<br><hr>
					<div class="rg-select-currencies" style="position: relative;">
						<select style="height: initial; padding: 10px; -webkit-appearance: none; appearance: none; width: 100%; font-weight: 800;">
							<option value="none" style="font-size: 16px; font-weight: 700;">SELECT CURRENCIES TO DISPLAY</option>
							<optgroup label="GENERAL" style="font-size: 16px;">
								<option value="all" style="font-weight: 700; color: #0073aa; font-size: 16px;">SELECT ALL</option>
								<option value="remove_all" style="font-weight: 700; color: red; font-size: 16px;">REMOVE ALL</option>
							</optgroup>
							<optgroup label="CURRENCIES (<?php echo $num; ?>)" style="font-size: 16px;" class="select_currencies_container" data-content = "<?php echo $num; ?>">
								<?php
								foreach( $data as $sa ){
									foreach($sa as $a){
										if(!empty($a->id)){
											echo '<option 
												style="font-size: 16px;"
												value="'.$a->id.'" 
												name="'.$a->name.'" 
												class="'.$a->id.' rg_transition_04s" 
												supply="'.$a->circulating_supply.'" 
												price="$'.$a->quote->USD->price.'" 
												percent_change_24h="'.$a->quote->USD->percent_change_24h.'" 
												tags="'.$a->tags['0'].'" 
												market_cap="'.$a->quote->USD->market_cap.'"  > ' 
												.$a->name.'</option>';
										}
									}
								} ?>
							</optgroup>
						</select>
						<button type="button" class="save_selected rg_transition_04s"><i class="fa fa-caret-down prevent_default" style="position: absolute; right: 110%; color: #23282d; font-size: 20px;"></i>Save</button>
					</div>
				</div>
			</div>

			
			
			
			<br><hr>
			
			<div class="rg-selected-currencies_ rg__tabs" style="position: relative; min-height: 50px;">
				<div class="rg-pre-loader"><div class="pre-loader"></div> </div>
				<div class="rg-saved-notif">Selection Saved</div>
				<div class="rg-title" style="padding:10px;" retrieve_me="rynerG_crypto_selected_currencies">
					<strong class="fa fa-hand-point-right"></strong> &emsp;Selected Currencies <i>(<?php echo $count_list; ?>)</i>
				</div>
				<div class="rynerG_crypto_selected_currencies rg__tabs__content">

				</div>
				<div class="rynerG_crypto_selected__remove rg__tabs__content">
					All currencies selected will be removed upon save.<br>
					<button type="button" class="__rg_black_small_btn">Cancel</button>
				</div>
				<div class="rynerG_crypto_selected__all rg__tabs__content">
					All currencies will be selected upon save. Total of <i><?php echo $num; ?></i> currencies.<br>
					<button type="button" class="__rg_black_small_btn">Cancel</button>
				</div>
			</div>
			
			<div class="rg-shortcodes-for-currencies rg__tabs">
				<div class="rg-title" style="padding:10px;" retrieve_me="rg__shortcodes">
					<i class="fa fa-hand-point-right"></i> &emsp;Shortcodes
				</div>
				<div class="rg-shortcodes-for-currencies-content rg__tabs__content rg__shortcodes" style="font-weight: 400;">
					<table>						
						<tbody>
							<tr>
								<td><span>[rg__sc_cryptocurrency type=list] <i>or</i><br>
									echo do_shortcode('[rg__sc_cryptocurrency type=list]');
								</span></td>
								<td>Lists the selected currencies in a table.</td>
							</tr>
							<tr>
								<td><span>[rg__sc_cryptocurrency type=carousel] <i>or</i><br>
									echo do_shortcode('[rg__sc_cryptocurrency type=carousel]');
								</span></td>
								<td style="position:relative;">Displays the selected currencies as a carousel. </td>

							</tr>
							<tr>
								<td colspan=2 style="text-align:center; font-weight: 800;"> You can add these to your shortcodes</td>
							</tr>
							<tr>
								<td>bg=#23282d</td>
								<td><i>bg</i> refers to the container's background. The default background color are set to black or #23282d. Accepted values are color names or hex values. You can refer to <a href="https://htmlcolorcodes.com/" target="_blank">https://htmlcolorcodes.com/</a> for more color options.</td>
							</tr>
							<tr>
								<td>font_color=white</td>
								<td><i>font_color</i> refers to the font's color. The default color are set to black or #fff or white. Accepted values are color names or hex values. You can refer to <a href="https://htmlcolorcodes.com/" target="_blank">https://htmlcolorcodes.com/</a> for more color options.</td>
							</tr>
							<tr>
								<td>type=list</td>
								<td><i>type</i> refers to how it will display your selections. Accepted values are <i> list, slider, carousel</i>.
							</tr>
							<tr>
								<td>max=10</td>
								<td><i>max</i> will display the number of values entered. Accepted values are <i> numbers</i> lower than your selected <strong>number of cryptocurrency to retrieve</strong>. Default will be the number entered to retrieve.
							</tr>
							
						</tbody>
						
					</table>

				</div>
				

			</div>
			<div class="rg__tabs rg-samples-for-currencies">
				<div class="rg-title" style="padding:10px;" retrieve_me="rg__screenshots">
					<i class="fa fa-hand-point-right"></i> &emsp;Screenshots
				</div>
				<div class="rg__tabs__content rg-samples-for-currencies_content rg__socials rg__screenshots" style="overflow:hidden;">
					<br><br>
					<div>Example Output For List Shortcode</div>
					<img src="<?php echo rg__Plugin_LINK;?>/my-images/List-Example.png" >
					<br><br>
					<div>Example Output For Carousel Shortcode</div>
					<img src="<?php echo rg__Plugin_LINK;?>/my-images/Carousel-Example.png" >
					<br><br>
				</div>
			</div>
			<div class="rg__tabs rg-samples-for-currencies" >
				<div class="rg-title" style="padding:10px;" retrieve_me="rg__others">
					<i class="fa fa-hand-point-right"></i> &emsp;Others
				</div>
				<div class="rg__tabs__content rg-samples-for-currencies_content rg__socials rg__others" style="overflow:hidden;">
					This plugin is a beta version.<br>
					<div class="" style="padding: 10px 15px;">
						Ongoing Updates:<br>
						1. Slider Type<br>
						2. Templates for each type<br>
						3. Browser Compatibility<br>
						4. OWN CLIENT'S API

					</div>
					<br>
					If you have any feedbacks, please feel free to message me.<br>
					<div class="" style="padding: 10px 15px;">
						<a href="https://www.facebook.com/DeathISHereRyner" target="_blank" style="display:inline-block;">
							<i class="fab fa-facebook-messenger"></i>
						</a>
						&emsp;
						<a href="https://www.instagram.com/__ryner/" target="_blank" style="display:inline-block;">
							<i class="fab fa-instagram"></i>
						</a>
						&emsp;
						<a href="mailto:galaus.ryner@gmail.com" target="_blank" style="display:inline-block;">
							<i class="fa fa-envelope"></i>
						</a>
					</div>


				</div>
			</div>
		
	</div>
</div>


<div class="rynerg_cs_container">
	<p class="rgcs_big_title"><i class="fa fa-coins"></i>&emsp;Cryptocurrency Shortcodes</p>
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
			<div class="rgcs__tab_title">Select Currencies to Display</div>
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