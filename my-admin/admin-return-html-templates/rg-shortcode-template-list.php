<?php
/*
Template Name: List Shortcode
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/


$data 		= get_option('rynerg_rgcs_api_crypto_json');
$coins_id 	= get_option('rynerg_rgcs_selected_currencies');
$img_url 	= 'https://s2.coinmarketcap.com/static/img/coins/16x16/';

?>

<div class="rynerg_rgcs_get_sample_shortcode_list">
	<div class="rgcs_shortcode_list_container">
		<table class="rgcs_shortcode_list_default">
			<thead>
				<th> Name </th>
				<th> Symbol </th>
				<th> Market Cap </th>
				<th> Price </th>
				<th> Circulating Supply </th>
				<th> Volume (24h) </th>
				<th> % Change 1h </th>
				<th> % Change 24h </th>
				<th> % Change 7d </th>				
			</thead>
			<tbody>
				<?php
				foreach ($coins_id as $c_id){
					echo "<tr>";
					foreach ( $data as $data_key=>$da ){
						foreach ($da as $val) {
							if(!empty($val->id) && $c_id == $val->id ){								
								echo '<td> &nbsp; <img src="'.$img_url.$val->id.'.png"> &nbsp;'. $val->name. '</td>';
								echo '<td>'.$val->symbol.'</td>';								
								echo '<td>'.number_format($val->quote->USD->market_cap,4,'.',',').'</td>';								
								echo '<td>'.number_format($val->quote->USD->price,4,'.',',').'</td>';								
								echo '<td>'.number_format($val->circulating_supply,4,'.',',').'</td>';
								echo '<td>'.number_format($val->quote->USD->volume_24h,4,'.',',').'</td>';

								$p_change_1h = $val->quote->USD->percent_change_1h;
			    				$p_1h = number_format(str_replace("-","",$p_change_1h),2,'.','');
								if( $p_change_1h > 0)
					    			{$p_change_1h = '<i class="fa fa-long-arrow-alt-up" style="color:#0073aa;"></i> &nbsp; %'.$p_1h;}
					    		else
					    			{$p_change_1h = '<i class="fa fa-long-arrow-alt-down" style="color:#d82222;"></i> &nbsp; %'.$p_1h;}

								
								$p_change_24h = $val->quote->USD->percent_change_24h;
			    				$p_24h = number_format(str_replace("-","",$p_change_24h),2,'.','');
								if( $p_change_24h > 0)
					    			{$p_change_24h = '<i class="fa fa-long-arrow-alt-up" style="color:#0073aa;"></i> &nbsp; %'.$p_24h;}
					    		else
					    			{$p_change_24h = '<i class="fa fa-long-arrow-alt-down" style="color:#d82222;"></i> &nbsp; %'.$p_24h;}


								$p_change_7d = $val->quote->USD->percent_change_7d;
			    				$p_7d = number_format( (float)str_replace("-","",$p_change_7d) ,2,'.','');
								if( $p_change_7d > 0)
					    			{$p_change_7d = '<i class="fa fa-long-arrow-alt-up" style="color:#0073aa;"></i> &nbsp; %'.$p_7d;}
					    		else
					    			{$p_change_7d = '<i class="fa fa-long-arrow-alt-down" style="color:#d82222;"></i> &nbsp; %'.$p_7d;}

					    		echo '<td>'.$p_change_24h.'</td>';
					    		echo '<td>'.$p_change_1h.'</td>';
								echo '<td>'.$p_change_7d.'</td>';
								break 2;
							}
						}
					}
					echo "</tr>";
				}				
				?>
			</tbody>
		</table>
	</div>
</div>

