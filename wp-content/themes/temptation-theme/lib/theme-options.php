<?php
// Set Admin Panel Options
$options = array(
	
	array( "type" => "menu", "items" => array( "General", "Styles", "Social Media" ) ),

	array( "type" => "optionsBody" ),
	array( "type" => "open" ),
	
	array( "name" => "General", "type" => "section" ),
	array( "type" => "open" ),
	
	array( "name" => "Favicon",
	       "desc" => "Enter the URL to your own favicon file.",
	         "id" => $shortname."_favicon",
	       "type" => "upload",
	        "std" => "" ),
			
	array( "name" => "Logo URL",
	       "desc" => "Enter the URL to your own logo image.",
	         "id" => $shortname."_logo",
	       "type" => "upload",
	        "std" => "" ),
			
	array( "name" => "Copyright Text",
	       "desc" => "Enter the copyright text that will be displayed at the footer.",
	         "id" => $shortname."_copyright",
	       "type" => "text",
	        "std" => '&copy; Copyright 2011 Celta Themes - All Rights Reserved.' ),	
			
	array( "type" => "close" ),

	array( "name" => "Styles", "type" => "section" ),
	array( "type" => "open" ),
			
	array( "name" => "Skin",
		   "desc" => "Select the skin of the theme.",
	         "id" => $shortname."_skin",
	       "type" => "select",
	    "options" => array( "Orange", "Beige", "Blue", "Dark Blue", "Green", "Lime", "Pink", "Purple", "Red", "Turquoise" ),
	        "std" => "Orange" ),
			
	array( "name" => "Left Column Pattern",
		   "desc" => "Select the pattern for the left column.",
	         "id" => $shortname."_pattern_left",
	       "type" => "select",
	    "options" => array( "Plates", "Grid Left", "Noise" ),
	        "std" => "Plates" ),	
			
	array( "name" => "Right Column Pattern",
		   "desc" => "Select the pattern for the right column.",
	         "id" => $shortname."_pattern_right",
	       "type" => "select",
	    "options" => array( "Square Grid", "Lines 1", "Lines 2", "Square Grid Big", "Cross", "Cross Big" ),
	        "std" => "Square Grid" ),	
			
	array( "name" => "Custom CSS Code",
	       "desc" => "In case you want to modify the CSS of the theme, you can write your code here.",
	         "id" => $shortname."_custom_css",
	       "type" => "textarea",
	        "std" => "" ),

	array( "type" => "close" ),
	
	array( "name" => "Social Media", "type" => "section" ),
	array( "type" => "open" ),
	
	array( "name" => "Blogger Link",
	       "desc" => "Enter the link to your Blogger account.",
	         "id" => $shortname."_blogger",
	       "type" => "text",
	        "std" => "" ),
	
	array( "name" => "Delicious Link",
	       "desc" => "Enter the link to your Delicous account.",
	         "id" => $shortname."_delicious",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Deviant Art Link",
	       "desc" => "Enter the link to your Deviant Art account.",
	         "id" => $shortname."_deviantart",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Digg Link",
	       "desc" => "Enter the link to your Digg account.",
	         "id" => $shortname."_digg",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Facebook Link",
	       "desc" => "Enter the link to your Facebook account.",
	         "id" => $shortname."_facebook",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Flickr Link",
	       "desc" => "Enter the link to your Flickr account.",
	         "id" => $shortname."_flickr",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Forrst Link",
	       "desc" => "Enter the link to your Forrst account.",
	         "id" => $shortname."_forrst",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Last FM Link",
	       "desc" => "Enter the link to your Last FM account.",
	         "id" => $shortname."_lastfm",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Linkedin Link",
	       "desc" => "Enter the link to your Linkedin account.",
	         "id" => $shortname."_linkedin",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "My Space Link",
	       "desc" => "Enter the link to your My Space account.",
	         "id" => $shortname."_myspace",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Reddit Link",
	       "desc" => "Enter the link to your Reddit account.",
	         "id" => $shortname."_reddit",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Tumblr Link",
	       "desc" => "Enter the link to your Tumblr account.",
	         "id" => $shortname."_tumblr",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Twitter Link",
	       "desc" => "Enter the link to your Twitter account.",
	         "id" => $shortname."_twitter",
	       "type" => "text",
	        "std" => "" ),
			
	array( "name" => "Vimeo Link",
	       "desc" => "Enter the link to your Vimeo account.",
	         "id" => $shortname."_vimeo",
	       "type" => "text",
	        "std" => "" ),
	
	array( "type" => "close" ),
	
	array( "type" => "close" )

);

function celta_add_admin() {
	global $themename, $shortname, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ] )); 
			}
			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], stripslashes($_REQUEST[ $value['id'] ] ) ); } else { delete_option( $value['id'] ); } 
			}
			header("Location: admin.php?page=theme-options.php&saved=true");
			die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); 
			}
			header("Location: admin.php?page=theme-options.php&reset=true");
			die;
		}
	}
	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'celta_admin');
}

function celta_add_init() {  
	$file_dir = get_bloginfo( 'template_directory' );  
	wp_enqueue_style( "theme-options", $file_dir . "/lib/styles/theme-options.css", false, "1.0", "all" );  
	wp_enqueue_style( "colorpicker", $file_dir . "/lib/styles/colorpicker.css", false, "1.0", "all" );  
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( "colorpicker-js", $file_dir . "/lib/js/colorpicker.js", false, "1.0" );  
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( "theme-options-js", $file_dir . "/lib/js/theme-options.js", false, "1.0" );  
} 

add_action('admin_init', 'celta_add_init');
add_action('admin_menu', 'celta_add_admin');

function celta_admin() {
	global $themename, $shortname, $options;
	$i=0;
	if ( $_REQUEST['saved'] ) echo '<div id="optionsMessage">'.$themename.' Settings Saved.</div>';
	if ( $_REQUEST['reset'] ) echo '<div id="optionsMessage">'.$themename.' Settings Reseted.</div>';
	?>
	<div class="optionsWrapper">
		<form method="post">
			<div class="optionsHeader"><h2>Celta Themes</h2></div>
			<div class="optionsBar"><p><?php echo $themename; ?> Settings</p><p class="submit"><input name="save" type="submit" value="Save Changes" /></p></div>
				<?php foreach ($options as $value) {
					switch ( $value['type'] ) {
						case "open": ?>
							<?php break;
						case "close": ?>
							</div>
							<?php break;
						case 'text': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo htmlspecialchars(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'color': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input class="color" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'upload': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<input class="optionsUpload" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
								<p class="submit"><input class="optionsUploadButton" type="button" value="Upload Image" /></p>
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'textarea': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case 'select': ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
									<?php foreach ($value['options'] as $option) { ?>
										<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
									<?php } ?>
								</select>
								<div class="fieldDesc"><?php echo $value['desc']; ?></div>
								<div class="clear"></div>
							</div>
							<?php break;
						case "checkbox": ?>
							<div class="optionsField">
								<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
								<div class="optionsCheckbox">
									<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
									<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
									<?php echo $value['desc']; ?>
								</div>
								<div class="clear"></div>
							</div>
							<?php break;
						case "section":
							$i++; ?>
							<div class="optionsSection" id="<?php echo str_replace( ' ', '', strtolower( $value['name'] ) ); ?>">
							<?php break;
						case "menu": ?>
							<ul class="optionsMenu">
								<?php foreach ($value['items'] as $item) { ?>
									<li><a href="#<?php echo str_replace( ' ', '', strtolower( $item ) ); ?>" title="<?php echo $item; ?>" class="<?php echo str_replace( ' ', '', strtolower( $item ) ); ?>"><?php echo $item; ?></a></li>
								<?php } ?>
							</ul>
							<?php break;
						case "optionsBody": ?>
							<div class="optionsBody">
							<?php break;
					}
				} ?>
				<input type="hidden" name="action" value="save" />
			</form>
			<div class="clear"></div>
			<form method="post" class="optionsReset">
				<p class="submit">
					<input name="reset" type="submit" value="Reset Fields" />
					<input type="hidden" name="action" value="reset" />
				</p>
			</form>
		</div> 
<?php } ?>