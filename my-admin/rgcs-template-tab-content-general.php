<?php
/*
Template Name: rrency Shortcode Admin Options Page
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/
?>
<style>
	.rgcs_refresh_rate_select{
		font-weight: 800;
		background: #eee;
		color: #222;
		display: inline-block;
		width: auto;
		padding: 10px;
		border-radius: 5px;
		cursor: pointer;
	}
	.rgcs_refresh_rate_select.selected{
		background: #4885ed;
		color: #fff;
	}
	.rgcs_refresh_rate_selection{
	    background: #eeeeee;
	    width: auto;
	    display: inline-block;
	    border-radius: 5px;
	}
	.rgcs_refresh_rate_deactivated{
	    border-bottom-right-radius: 0;
	    border-top-right-radius: 0;
	}
	.rgcs_refresh_rate_activated{
	    border-bottom-left-radius: 0;
	    border-top-left-radius: 0;
	}
</style>

<div class="rgcs__tab_">

	<div class="rgcs_pre_loader"><div class="rgcs_pre_loader"></div></div>

	<div class="rgcs_saved_notif">Setting saved</div>

	<p class="rgcs__tab_title">Number of coins to retrieve</p>
	<p>
		<input type="number" class="rgcs_selected_num_max" placeholder="Number of coins to retrieve" value="<?php echo $num_retrieve; ?>" max="1000">
		<p class="labeling" style="padding-left: 15px;">
			<i>Note: This sets the number of coins to retrieve from <a href="https://coinmarketcap.com/all/views/all/" target="_blank"> coinmarketcap.com</a>. Default (10 items). Maximum coins to retrieve is 1000.
			<br>
			<span class="fa fa-exclamation">&nbsp;</span>Important Note: The higher the number the slower the loading process. 
			<br>
			Loadspeed of your site will not be affected since all requests happen after the page has loaded.
			<br><br>
			If options for <b>SELECT COINS TO DISPLAY</b> didn't update, please refresh the page.  </i>
		</p>
	</p>
	<hr>
	<p class="rgcs__tab_title">Real Time</p>
	<?php 

	$get_previous_rate = get_option('rynerg_rgcs_refresh_rate_of_currencies'); 
	$deact_stat = $act_stat = $act_text = $deact_text = '';

	$r_stats = array( 'd_stat' => 'selected' ,'a_stat'=>'','d_text'=>'Deactivated','a_text'=>'Activate' );

	if( $get_previous_rate == 'activated' ){
		$r_stats = array( 'd_stat' => '' ,'a_stat'=>'selected','d_text'=>'Deactivate','a_text'=>'Activated' );
	}

	?>
	<div class="rgcs_refresh_rate">
		<p class="labeling">
			<i>This will set the refresh rate to real time but will reduce the max items to be collected to 30. And due to API restrictions, if the data was changed, wait for atleast 1-5 minutes for the data to be recollected.</i>
		</p><br>
		<div class="rgcs_refresh_rate_selection">
			<div class="rgcs_refresh_rate_deactivated rgcs_refresh_rate_select <?php echo $r_stats['d_stat']; ?>" data_type = 'deactivate'>
				<?php echo $r_stats['d_text']; ?>
			</div>
			<div class="rgcs_refresh_rate_activated rgcs_refresh_rate_select <?php echo $r_stats['a_stat']; ?>" data_type = 'activate'>
				<?php echo $r_stats['a_text']; ?>
			</div>
		</div>
		
	</div>

	<br><hr>

	<p>
		<button type="button" class="rgcs_save_btn" data-action="save_selected_number">SAVE CHANGES</button>
	</p>
</div>
<script type="text/javascript">
	if( jQuery('.rgcs_refresh_rate_activated').hasClass('selected') ){
        jQuery('.rgcs_selected_num_max').keyup(function(){
            if( jQuery('.rgcs_selected_num_max').val() > 30 ){
                jQuery('.rgcs_selected_num_max').val('30');
            }
        });
    }
</script>