<?php
/*
Template Name: rrency Shortcode Admin Options Page
Author: Ryner S. Galaus
Author URI: https://profiles.wordpress.org/ryner1
*/
?>
<div class="rgcs__tab_">
	<p class="rgcs__tab_title">[rgsc_crypto_shortcode type=list]</p>
		<span style="padding-left:15px; display: block;">
			Lists the selected currencies in a table.
		</span>

	<p class="rgcs__tab_title">[rgsc_crypto_shortcode type=carousel]</p>
		<span style="padding-left:15px; display: block;">
			Displays the selected currencies as a carousel. <br>
			Carousel will only move if number of selected items is more than or equal to five (5).<br>			
		</span>				

	<p class="rgcs__tab_title">Additionals</p>
		<span style="padding-left:15px; display: block;">
			<table>
				<tr>
					<td>
						bg_color=#222 
					</td>
					<td><i>bg_color</i> refers to the carousel container's background. The default background color are set to black or #222. Accepted values are color names or hex values. You can refer to <a href="https://htmlcolorcodes.com/" target="_blank">https://htmlcolorcodes.com/</a> for more color options.</td>
				</tr>
				<tr>
					<td>font_color=white</td>
					<td><i>font_color</i> refers to the font's color. The default color are set to black or #fff or white. Accepted values are color names or hex values. You can refer to <a href="https://htmlcolorcodes.com/" target="_blank">https://htmlcolorcodes.com/</a> for more color options.</td>
				</tr>
				<tr>
					<td>type=list</td>
					<td><i>type</i> refers to how it will display your selections. Accepted values are <i> list, slider, carousel</i>.</td>
				</tr>
				<tr>
					<td>max=10</td>
					<td><i>max</i> will display the number of values entered. Accepted values are <i> numbers</i> lower than your selected <strong>number of cryptocurrency to retrieve</strong>. Default will be the number entered to retrieve.</td>
				</tr>
				<tr>
					<td>c_speed=9000</td>
					<td>Indicates the speed of the carousel. The number represents milliseconds. So 9000 is 9 seconds. Default is 9000 </td>
				</tr>
				<tr>
					<td>c_data_per_slide=6</td>
					<td>Indicates the number of data to be displayed for the carousel. Default is 6. </td>
				</tr>
			</table>
			
		</span>				
	
</div>