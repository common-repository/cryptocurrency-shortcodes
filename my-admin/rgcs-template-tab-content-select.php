<?php
/*
Template Name: rrency Shortcode Admin Options Page
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/
?>

<div class="rgcs__tab_">

	<div class="rgcs_pre_loader"><div class="rgcs_pre_loader"></div></div>

	<div class="rgcs_saved_notif">Saved</div>


	<p>
		<div class="rgcs_select_container">
			<div class="rgcs__tab_title rgcs_select_search_btn">
				Select Here
			</div>
			
			<div class="rgcs_select_options">
				<div class="rgcs_select_search">
					<input class="rgcs_search_currency" placeholder="Search Name">
				</div>
				<?php
				$item_ctr = 1;
				foreach( $items as $sa ){
					foreach($sa as $a){
						if(!empty($a->id)){

							echo '<p
								value="'.$a->id.'"
								name="'.$a->name.'"
								class="'.$a->id.'"
								item_num = "'.$item_ctr.'"
								supply="'.$a->circulating_supply.'"
								price="$'.$a->quote->USD->price.'"
								percent_change_24h="'.$a->quote->USD->percent_change_24h.'"
								market_cap="'.$a->quote->USD->market_cap.'">
									<img src="'.$img_url.$a->id.'.png"> &nbsp;
									'.$a->name.'

								</p>
							';
							$item_ctr++;
						}
					}
				}
				?>				
			</div>
		</div>
	</p>
	<p>
		<div class="rgcs_selected_container rgcs_selected_items active">
			<div class="rgcs__tab_title">
				Selected Items
			</div>
			<div class="rgcs_selected_items rgcs_selected_items_selected ">
				<p class="rgcs_nothing_selected">Nothing Selected Yet</p>
				<p class="rgcs_display_selected">

				</p>
			</div>
		</div>

		<div class="rgcs_selected_container rgcs_selected_items_all">
			<div class="rgcs__tab_title">
				Select All Items
			</div>
			<div class="rgcs_selected_items rgcs_selected_items_all">
				All currencies will be selected upon save. <span></span>
			</div>
		</div>

		<div class="rgcs_selected_container rgcs_selected_items_reset">
			<div class="rgcs__tab_title">
				Remove All Items
			</div>
			<div class="rgcs_selected_items rgcs_selected_items_reset">
				All currencies selected will be removed upon save.
			</div>
		</div>
	</p>


	<p>
		<button type="button" class="rgcs_save_btn" data-action="save_selected_option">Save</button>
		<button type="button" class="rgcs_save_btn" data-action="save_selected_option_all">Select All</button>
		<button type="button" class="rgcs_save_btn" data-action="save_selected_option_reset">Reset</button>
	</p>
<!-- 	<br>
	<p>
		<div class="rgcs_view_selected_option_container">
			<div class="">
				<p class="labeling">Enter shortcode to view sample &emsp; <i>Result will be based on the selected items above.</i></p>
				<input class="rgcs_view_selected_option_shortcode" placeholder="Shortcode">				
				<button type="button" class="rgcs_save_btn" data-action="view_selected_option">View Sample</button>
			</div>
			<br><hr><br>			

			<div class="rgcs_view_selected_items_as_shortcode">
				
			</div>	
		</div>
	</p> -->
</div>
<div class="rgcs_samples">

</div>