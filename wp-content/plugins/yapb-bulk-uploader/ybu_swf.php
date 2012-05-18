<?php
	/*
	This file is part of YAPB Bulk Uploader.

    'YAPB Bulk Uploader' is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    'YAPB Bulk Uploader' is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with 'YAPB Bulk Uploader'.  If not, see <http://www.gnu.org/licenses/>.
	
	Note that this software makes use of other libraries that are published under their own
	license. This program in no way tends to violate the licenses under which these 
	libraries are published.
	
	*/ 

function ybu_createPostDate()
{
	global $wp_locale;
	//based on touch_time command in WordPress...

	$time_adj = time() + (get_option( 'gmt_offset' ) * 3600 );
	$dd = gmdate( 'd', $time_adj );
	$mm = gmdate( 'm', $time_adj );
	$yy = gmdate( 'Y', $time_adj );
	$hh = gmdate( 'H', $time_adj );
	$mn = gmdate( 'i', $time_adj );
	$ss = gmdate( 's', $time_adj );
	
	$enabled = get_option("yapb_check_post_date_from_exif") ? 'disabled' : "";
	
	$month = "<select id=\"ybu_mm\" name=\"ybu_mm\" $enabled>\n";
	for ( $i = 1; $i < 13; $i = $i +1 ) {
		$month .= "\t\t\t" . '<option value="' . zeroise($i, 2) . '"';
		if ( $i == $mm )
			$month .= ' selected="selected"';
		$month .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
	}
	$month .= '</select>';

	$day = '<input type="text" id="ybu_dd" name="ybu_dd" value="' . $dd . '" size="2" maxlength="2" autocomplete="off" '.$enabled.'/>';
	$year = '<input type="text" id="ybu_yy" name="ybu_yy" value="' . $yy . '" size="4" maxlength="4" autocomplete="off" '.$enabled.'/>';
	$hour = '<input type="text" id="ybu_hh" name="ybu_hh" value="' . $hh . '" size="2" maxlength="2" autocomplete="off" '.$enabled.'/>';
	$minute = '<input type="text" id="ybu_mn" name="ybu_mn" value="' . $mn . '" size="2" maxlength="2" autocomplete="off" '.$enabled.'/>';
	/* translators: 1: month input, 2: day input, 3: year input, 4: hour input, 5: minute input */
	printf(__('%1$s%2$s, %3$s @ %4$s : %5$s'), $month, $day, $year, $hour, $minute);

	echo '<input type="hidden" id="ybu_ss" name="ybu_ss" value="' . $ss . '" />';
}
?>

<script type="text/javascript">
SWFUpload.onload = function() 
{
	ybu_swfu = new SWFUpload({
			//flash location
			flash_url : "<?php echo includes_url('js/swfupload/swfupload.swf'); ?>",
		
			//button style
			button_text: '<p class="ybu_btn"><?php _e("Select Files"); ?></p>',
			button_text_style: '.ybu_btn {font-family: "Lucida Grande", Verdana, Arial, "BitStream Vera Sans", sans-serif; font-size: 13px; margin: 0px; padding: 0px}',
			button_height: '22',
			button_width: '<?php echo 13 * strlen(_("Select Files")) ?>',
			button_image_url: "",
			button_placeholder_id: "ybu_upload_button",
			button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,

			//upload info
			upload_url : "<?php echo plugins_url('ybu_upload.php', __FILE__); ?>",
			file_post_name: "yapb_imageupload",
			post_params : {
				"auth_cookie" : "<?php if ( is_ssl() ) echo $_COOKIE[SECURE_AUTH_COOKIE]; else echo $_COOKIE[AUTH_COOKIE]; ?>",
				"_wpnonce" : '<?php echo wp_create_nonce("yapb-upload"); ?>'
			},

			//file selection info
			file_types: "*.jpg;*.gif;*.png",
			file_size_limit : '<?php echo  wp_convert_bytes_to_hr(wp_max_upload_size());	 ?>',

			//handlers
			file_queued_handler : ybu_fileQueued,
			file_queue_error_handler : ybu_fileQueueError,
			upload_start_handler : ybu_uploadStart,
			upload_progress_handler : ybu_uploadProgress,
			upload_error_handler : ybu_uploadError,
			upload_success_handler : ybu_uploadSuccess,
			upload_complete_handler: ybu_uploadComplete,
			file_dialog_complete_handler : ybu_fileDialogComplete,
			
			debug: false
		});
};

function ybu_enableDatePicker(enabled)
{
	//get all datepicker elements
	datePicker = document.getElementById("ybu_postdate");
	
	//enable or disable date picker elements based on checkbox
	dateElems = datePicker.getElementsByTagName("input");
	for(var elem in dateElems)
		dateElems[elem].disabled = !enabled;

	dateElems = datePicker.getElementsByTagName("select");
	for(var elem in dateElems)
		dateElems[elem].disabled = !enabled;

}

function ybu_togglePostDate()
{
	var datePicker;
	var exifDate;
	var dateElems;
	
	//get exifdate checkbox
	exifDate = document.getElementById("ybu_exifdate");

	//switch on or of datepicker
	ybu_enableDatePicker(!exifDate.checked);
}

function ybu_togglePublishState()
{
	var stateSelect = document.getElementById("ybu_post_status");
	var index = stateSelect.selectedIndex;
	if(index>=0)
	{
		//get exifdate checkbox
		var exifDate = document.getElementById("ybu_exifdate");
		var exifDateLabel = document.getElementById("ybu_exifdate_label");
		

		//get state
		var state = stateSelect.options[index].value;

		if(state == "draft")
		{
			//disable exifdate
			exifDate.disabled = true;
			exifDateLabel.disabled = true;

			//disable date picker
			ybu_enableDatePicker(false);
		}
		else
		{
			//enable exifdate
			exifDate.disabled = false;
			exifDateLabel.disabled = false;
			
			//enable date picker based on exifDate state
			ybu_enableDatePicker(!exifDate.checked);
		}
	}
}

function ybu_toggle_multiple_categories()
{
	var catSelect = document.getElementById("ybu_category");
	var selMultiple = document.getElementById("ybu_category_multiple");
	if(selMultiple.checked)
	{
		catSelect.multiple = true;
		catSelect.style.height = "11em";
	}
	else
	{
		catSelect.multiple = false;
		catSelect.style.height = "auto";
	}
}

</script>

<div class="wrap">

    <h2>Upload YAPB images</h2>
	<form id="ybu_upload_form">
		<table class="form-table">
		
			<tr valign="top">
            	<th scope="row"><?php _e('Use IPTC') ?></th>
                <td>
                    <input type="checkbox" name="ybu_iptc" id="ybu_iptc" value="1" <?php checked('1',get_option("ybu_iptc_checked")); ?> />
                    <label for='ybu_iptc'>Use IPTC data to set post title, content and tags</label>
                </td>
            </tr>
            
            <tr valign="top">
            	<th scope="row"><?php _e('Select Category') ?></th>
                <td>
					<?php wp_dropdown_categories(array('hierarchical'=> 1, 'selected'=>(get_option("yapb_default_post_category_activate") ? get_option("yapb_default_post_category") : get_option('default_category')), 'hide_empty'=>0, 'name'=>'ybu_category')); ?>
					<br/>
					<input type="checkbox" name="ybu_category_multiple" id="ybu_category_multiple" onclick="ybu_toggle_multiple_categories()" />
					<label for='ybu_category_multiple'>Select multiple categories</label>
                </td>
            </tr>
            
             <tr valign="top">
            	<th scope="row"><?php _e('Select Post Status') ?></th>
                <td>
					<select id="ybu_post_status" name="ybu_post_status" onchange="ybu_togglePublishState()">
						<option value="publish" selected="selected">Publish</option>
						<option value="draft">Draft</option>
					</select>
                </td>
            </tr>
            
            <tr valign="top">
            	<th scope="row"><?php _e('Select Post Date') ?></th>
                <td>
                    <span id="ybu_postdate"><?php ybu_createPostDate(); ?></span>
                    <br/>
                    <input type="checkbox" name="ybu_exifdate" id="ybu_exifdate" value="1" <?php checked('1',get_option("yapb_check_post_date_from_exif")); ?> onclick="ybu_togglePostDate()" />
                   	<label id="ybu_exifdate_label" for='ybu_exifdate'>Use EXIF date as post date</label>
          		</td>
                    
            </tr>
            
            
            
            
            <tr valign="top">
                <td>
                     <div class="buttons">
                     	<div class="button">
           				 <div id="ybu_upload_button"><?php _e('Sorry, flash uploader not loaded...') ?></div>
           				</div>
           			 </div>
       				
                </td>
            </tr>
        </table>
	</form>
	
	<div id="ybu_progress" style="visibility: hidden">
		<h2>Upload Progress</h2>
		<UL id="ybu_progress_list"></UL>
		<h3 id="ybu_done" style="visibility: hidden">Uploads complete!</h3>
	</div>
</div>
	
