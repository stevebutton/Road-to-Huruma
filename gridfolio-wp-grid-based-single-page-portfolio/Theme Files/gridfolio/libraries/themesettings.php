<?php
	global $custom_settings;
	$custom_settings = get_custom_settings(); 
	
	
		
	// Adding Custom Admin Settings Page
	add_action('admin_menu', 'theme_settings'); 
	add_action('admin_head', 'theme_styles');
	function theme_settings() { 
		add_menu_page( 
			__('Custom Theme Settings','cudazi'),
			__('Settings+','cudazi'),
			'manage_options', 
			'cudazi-themesettings', 
			'theme_settings_form', 
			get_bloginfo('template_url') . "/libraries/images/icon-settings-16x16.gif", 
			null );
		add_submenu_page( 
			'cudazi-themesettings', 
			__("Settings+","cudazi"), 
			__("General","cudazi"), 
			'manage_options', 
			'cudazi-themesettings', 
			'theme_settings_form'
		);
		add_submenu_page( 
			'cudazi-themesettings', 
			__("Suggested Plugins","cudazi"), 
			__("Suggested Plugins","cudazi"), 
			'manage_options', 
			'cudazi-themesettings-plugins', 
			'theme_help_plugins'
		);
		add_submenu_page( 
			'cudazi-themesettings', 
			__("Theme Help","cudazi"), 
			__("Theme Help","cudazi"), 
			'manage_options', 
			'cudazi-themesettings-help', 
			'theme_help_form'
		);
	}

	
	
	//
	// Gets custom settings array.
	// If not set in DB, inserts defaults below for the first run
	// and then pulls in settings from DB from then on.
	//
	function get_custom_settings()
	{
		$custom_settings_array = get_option("custom_settings");
		
		if(!empty($custom_settings_array))
		{
			// Custom Settings set, pull from DB
			$s = $custom_settings_array;
		}else{
			// set defaults into DB
			update_option("custom_settings", $s);
		}
		return $s;
	}

function theme_help_form()
{
?>
	<div class="wrap">
		<form method="post" name="brightness" target="_self" class="adminoptions" action="">
		<div class="icon32 adminoptions" id="icon-edit-pages"><br /></div>
        	<h2><?php _e("Theme Help","cudazi"); ?></h2>
			<hr />
			<h3>Support</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<p>Resources</p>
						</th>
						<td>
							<p><strong><a href="http://www.google.com/search?q=wordpress+101">Google</a>, <a href="http://youtube.com">YouTube</a> and the <a href="http://net.tutsplus.com">Tuts+ Network of Sites</a></strong> are your best friends when learning how to use or modify a WordPress theme</p>
							<ul>
								<li><a href="http://codex.wordpress.org/New_To_WordPress_-_Where_to_Start">New to WordPress &mdash; Where to Start</a></li>
								<li><a href="http://codex.wordpress.org/FAQ_Installation">Frequently Asked Questions about Installing WordPress</a></li>
								<li><a href="http://codex.wordpress.org/First_Steps_With_WordPress">First Steps with WordPress</a></li>
								<li><a href="http://codex.wordpress.org/Writing_Posts">Writing Posts</a></li>
								<li><a href="http://themeforest.net/support">ThemeForest Support</a></li>
							</ul>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<p>Tips</p>
						</th>
						<td>
							<p>Read through the included documentation before asking a question, chances are it is covered in there.</p>
							<p>Use the "Find in Files" feature of many text editors to search for a specific function or message you want to edit in the theme.</p>
						</td>
					</tr>
					
				</tbody>
			</table>
			<hr />
			
			<h3>Updates / Contact</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<p>Twitter</p>
						</th>
						<td>
							<p>Stay up to date on current changes by following me on Twitter <a href="http://twitter.com/cudazi">@cudazi</a></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<p>How to Contact</p>
						</th>
						<td>
							<p>You must contact me <a href="http://themeforest.net/user/cudazi/">via my profile page</a> to verify sales information.</p>
							<p>I do offer free support - anything beyond that (customizations, etc...) I will need to write up a quote - thanks!</p>
						</td>
					</tr>
			</table>
			<hr />
			<br /><br /><br />
			</form>
        </div>
<?php	
}


function theme_help_plugins()
{
?>
	<div class="wrap">
		
			<form method="post" name="brightness" target="_self" class="adminoptions" action="">
			<div class="icon32 adminoptions" id="icon-edit-pages"><br /></div>
			<h2><?php _e("Suggested Plugins","cudazi"); ?></h2>
			
			<p>The plugins below are suggested but not installed or activated by default unless noted.</p>
				
			<hr />
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<p>FancyBox for WordPress</p>
						</th>
						<td>
							<p>
								
								Lightbox - Integrates FancyBox by Janis Skarnelis into WordPress.<br />
								Theme tested with version 2.7.2 by Jose Pardilla<br />
								<a href="http://blog.moskis.net/downloads/plugins/fancybox-for-wordpress/">http://blog.moskis.net/downloads/plugins/fancybox-for-wordpress/</a>
							</p>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">
							<p>Regenerate Thumbnails</p>
						</th>
						<td>
							<p>
								
								Allows you to regenerate all thumbnails after changing the thumbnail sizes.<br />
								Theme tested with Version 2.0.3 by Viper007Bond<br />
								<a href="http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/">http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/</a>
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<p>Widget Logic</p>
						</th>
						<td>
							<p>
								
								Widget Logic lets you control on which pages widgets appear.<br />
                                It uses any of WP's conditional tags. It also adds a 'widget_content' filter.<br />
								<a href="http://wordpress.org/extend/plugins/widget-logic/">http://wordpress.org/extend/plugins/widget-logic/</a>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			
			<br /><br /><br />
			</form>
        </div>
<?php	
}

// display the settings form on the custom settings admin page
function theme_settings_form(){ 
	
	//must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
	
	global $custom_settings;
    if(isset($_POST['submit-updates']) && $_POST['submit-updates'] == "yes"){
		
		$custom_settings["theme"] = $_POST["options"]["theme"];
		$custom_settings["logo"]["url"] = $_POST["options"]["logo"]["url"];
		$custom_settings["logo"]["usetextlogo"] = $_POST["options"]["logo"]["usetextlogo"];

		$custom_settings["disable_footer"] = stripslashes($_POST["options"]["disable_footer"]);
		
		$custom_settings["disable_blog_link_menu"] = stripslashes($_POST["options"]["disable_blog_link_menu"]);
		$custom_settings["disable_blog_link_summary"] = stripslashes($_POST["options"]["disable_blog_link_summary"]);
		
		$custom_settings["blog_summary"]["category_id"] = $_POST["options"]["blog_summary"]["category_id"];
		$custom_settings["blog_summary"]["max"] = $_POST["options"]["blog_summary"]["max"];
		
		$custom_settings["contactform"]["to"] = $_POST["options"]["contactform"]["to"];
		
		$custom_settings["additional_js"] = stripslashes($_POST["options"]["additional_js"]);
		$custom_settings["css"]["extra"] = stripslashes($_POST["options"]["css"]["extra"]);
		$custom_settings["disable_admin_error_messages"] = $_POST["options"]["disable_admin_error_messages"];
		
		// *************************************************
		// pass array into custom settings row in DB
		update_option("custom_settings", $custom_settings);
		// *************************************************
		
        echo "<div id=\"message\" class=\"updated fade\"><p><strong>".__("All Settings Saved!","cudazi")."</strong></p></div>";
    }
	
	function save_button()
	{
		// simple function to output save button...
		echo "<div class='updated'><p class='submit'><input type='submit' value='".__("Save Changes","cudazi")."' class='button-primary' name='Submit'/></p></div>";
	}
?>
<a name="top"></a>
<div class="wrap">

	<form method="post" name="brightness" target="_self" class="adminoptions" action="">
		<div class="icon32" id="icon-options-general"><br /></div>
		
        <h2><?php _e("Settings+","cudazi"); ?></h2>
		
        <hr class="clear" />
		
        <h3><?php _e("Overview","cudazi"); ?></h3>
		<p><?php _e("Please read through this page to find general theme settings. Many other settings are available when adding/editing pages.","cudazi"); ?></p>
				
		<?php save_button(); ?>
        
		<div class="tool-box"><hr /></div>
		
		
		
		
		<h3><?php _e("Theme","cudazi"); ?></h3>
		<table class="form-table">
            <tbody>
            	<tr valign="top">
                    <th scope="row">
                        <label><?php _e("Choose a Theme:","cudazi"); ?></label>
                    </th>
						<td>
							<select name="options[theme]">
                                <option value="default" <?php if($custom_settings["theme"] == 'default' || !$custom_settings["theme"]){ echo "selected='selected'"; } ?> >Default</option>
                                <option value="dark" <?php if($custom_settings["theme"] == 'dark'){ echo "selected='selected'"; } ?> >Dark</option>
                            </select>
						<br /><?php _e("Upload a light or dark background using the Appearance > Background page. Some custom backgrounds are included with the theme or use your own or a custom background color. Edit other site elements in more detail using the additional CSS area on this page or edit the stylesheets.","cudazi"); ?>
                    </td>
                </tr>
            </tbody>
        </table>
		
		
		<h3><?php _e("Logo","cudazi"); ?></h3>
		<p><?php _e("Overwrite the default logo in the images folder or update below:","cudazi"); ?></p>
		<table class="form-table">
            <tbody>
            	<tr valign="top">
                    <th scope="row">
                        <label><?php _e("Logo URL:","cudazi"); ?></label>
                    </th>
						<td>
						<input type="text" class="regular-text" value="<?php echo $custom_settings["logo"]["url"]; ?>" name="options[logo][url]">
						<br /><?php _e("Enter the full URL. Upload the image into your theme folder or the WordPress media gallery. Size to 183x64 for perfect results. If your logo is very tall and enlarges the header, you may need to adjust the padding of the section class, see the additional CSS area note below","cudazi"); ?>
                    </td>
                </tr>
            	<tr valign="top">
                    <th scope="row">
                        <label><?php _e("Text Logo","cudazi"); ?></label>
                    </th>
                    <td>
						<label><input type="checkbox" name="options[logo][usetextlogo]" <?php if($custom_settings["logo"]["usetextlogo"]) { echo " checked='checked'"; } ?>/> <?php _e("Use Text Logo (Site Name) - This will override the Logo URL above","cudazi"); ?></label>
                    </td>
                </tr>
            </tbody>
        </table>
        

        
		
		
		
        <div class="tool-box"><hr /></div>
        <h3><?php _e("Blog Summary Page Template","cudazi"); ?></h3>
        <p><?php _e("Create a page with the  blog summary page template to use the blog summary section.","cudazi"); ?></p>
        <table class="form-table">
			<tbody>
				<tr valign="top">
                    <th scope="row">
                        <label><?php _e("Blog Summary Maximum","cudazi"); ?></label>
                    </th>
						<td>
						<input size="4" type="text" class="small-text" value="<?php echo $custom_settings["blog_summary"]["max"]; ?>" name="options[blog_summary][max]">
						<br /><?php _e("Maximum items to display in the blog summary template.","cudazi"); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label><?php _e("Blog Summary Category","cudazi"); ?></label>
                    </th>
						<td>
						<input type="text" class="small-text" value="<?php echo $custom_settings["blog_summary"]["category_id"]; ?>" name="options[blog_summary][category_id]">
						<br /><?php _e("Category ID or IDs to use in the blog summary template. Enter a comma-separated list of IDs to include or exclude with a minus sign.","cudazi"); ?>
                    </td>
                </tr>
			</tbody>
		</table>
        
        
        <div class="tool-box"><hr /></div>
        <h3><?php _e("Contact Form Page Template","cudazi"); ?></h3>        
        <p><?php _e("Create a page with the contact form page template to use the contact form.","cudazi"); ?></p>
        <p><?php _e("Note: The form is a shortcode and can also be inserted in page content: [cudazi_contact to='you@email.com']","cudazi"); ?></p>
        <table class="form-table">
			<tbody>
				<tr valign="top">
                    <th scope="row">
                        <label><?php _e("Contact Form To Address","cudazi"); ?></label>
                    </th>
						<td>
						<input type="text" class="regular-text" value="<?php echo $custom_settings["contactform"]["to"]; ?>" name="options[contactform][to]">
						<br /><?php _e("Enter the email address you want the contact form sent to.","cudazi"); ?>
                    </td>
                </tr>
			</tbody>
		</table>
		


        <div class="tool-box"><hr /></div>
        <h3><?php _e("Additional Settings","cudazi"); ?></h3>
        
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label><?php _e("Disable Website Footer","cudazi"); ?></label></th>
					<td>
						<label><input type="checkbox" name="options[disable_footer]" <?php if($custom_settings["disable_footer"]) { echo " checked='checked'"; } ?>/> <?php _e("Disable the website footer","cudazi"); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
        
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label><?php _e("Disable Link to Posts Page (blog) in Menu","cudazi"); ?></label></th>
					<td>
						<label><input type="checkbox" name="options[disable_blog_link_menu]" <?php if($custom_settings["disable_blog_link_menu"]) { echo " checked='checked'"; } ?>/> <?php _e("Remove item set as posts page under Settings > Reading in main menu","cudazi"); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
        
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label><?php _e("Disable Link to Posts Page (blog) in Blog Summary template","cudazi"); ?></label></th>
					<td>
						<label><input type="checkbox" name="options[disable_blog_link_summary]" <?php if($custom_settings["disable_blog_link_summary"]) { echo " checked='checked'"; } ?>/> <?php _e("Remove item set as posts page under Settings > Reading in blog summary template","cudazi"); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
        
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label><?php _e("Admin Notes/Errors","cudazi"); ?></label></th>
					<td>
						<label><input type="checkbox" name="options[disable_admin_error_messages]" <?php if($custom_settings["disable_admin_error_messages"]) { echo " checked='checked'"; } ?>/> <?php _e("Disable Admin Error Messages / Notes (cudazi_admin_message() function)","cudazi"); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
		
        
        
        <div class="tool-box"><hr /></div>
        <h3><?php _e("Add-On Tools","cudazi"); ?></h3>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label><?php _e("Additional JavaScript","cudazi"); ?></label>
                            <br /><small><?php _e("Use for Google Analytics, etc. Applied in the footer of the website.","cudazi"); ?></small>
                        </th>
                        <td>
                            <textarea class="large-text code" cols="50" rows="10" name="options[additional_js]"><?php echo htmlspecialchars($custom_settings["additional_js"]); ?></textarea>
                            <?php _e("Surround JavaScript with proper script tags:","cudazi"); ?> <code>&lt;script type='text/javascript'&gt;&lt;/script&gt;</code>
                        </td>
                    </tr>
                </tbody>
            </table>


            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label><?php _e("Additional CSS","cudazi"); ?></label>
                            <br /><small><?php _e("Use this to override all theme styles without having to edit the CSS file directly. <a href='http://www.google.com/search?q=css+tutorial' target='_blank'>CSS Tutorials...</a>","cudazi"); ?></small>
                        </th>
                        <td>
                            <textarea class="large-text code" cols="50" rows="10" name="options[css][extra]"><?php echo htmlspecialchars($custom_settings["css"]["extra"]); ?></textarea>
                            <?php _e("Enter the CSS directly without the opening/closing &lt;style&gt; tags:","cudazi"); ?><br />
                            <code>.section { padding-top:125px; padding-bottom:300px; } /* Override the padding between sections! */</code>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        
        <div class="tool-box"><hr /></div>
        
        <?php save_button(); ?>
        
		
		<input name="submit-updates" type="hidden" value="yes"/>
		<br /><br /><br /><br />
        
        
	</form>
    </div>
<!--</div>-->
<?php 
}


// Add Dashboard Head CSS to custom settings page 
function theme_styles() { 
	echo "<style type=\"text/css\"> 
	.adminoptions hr { height:1px; border:0; background:#ccc; }
	</style>";
}

?>