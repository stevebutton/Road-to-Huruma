<?php
/*
Plugin Name: SSPD Connector
Plugin URI: http://rdp-photo.net/sspdc
Description: SSPD Connector helps you to link content from a SlideShowPro Director installation to WordPress posts and pages. 
Version: 1.0.4b
Text Domain: sspdc
Author: Ruggero De Pellegrini
Author URI: http://rdp-photo.net
*/

/*  Copyright 2008  RUGGERO DE PELLEGRINI  (email: mail@rdp-photo.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*	Changelog
1.0.4b
	Misc
		* Single images and "matrix album" in the same post are shown as one lightbox/lightview gallery. (thanks you jonas)
		* "preview album" are shown as one (seperate) lightbox/lightview gallery
		
1.0.3b
	Misc
		* Lightview/Lightbox don't show single images in different posts as a gallery anymore. 
		* Single images in the same post are shown as a gallery.
		
1.0.2b
	Misc
		* Updated MediaPlayer
		
1.0.1b
	Features
		* BrandNew Extended media tab for inserting images into posts
		* Lightview integration with WordPress plugin Lightview-Plus and Lightview
		* German language file
	Misc
		* only image title is added as "alt" and "title" to the image
		* Updated to Director API 1.1.5
		* changed cache settings
	Bugfix
		* many
		
0.9.11
	Bugfix
		* "PHP Fatal error: Objects used as arrays in post/pre increment/decrement must return values by reference in /É./wp-content/plugins/slideshowpro-director-connector/classes/Utils.php on line 39" should be fixed by updating to Director API 1.1.4
	Misc
		* Updated to Director API 1.1.4
		
0.9.10
	Bugfix
		* Fixed bug where API path and key could not be saved

0.9.9
	Misc
		* Added check if class 'Director' already exists. This helps when other plugins already loaded the class. Hopefully other plugins check this too.
		* Plugin now uses only the extended Director class called 'sspdc'
0.9.8
	Misc
		* Updated to Director API 1.1.3

0.9.7
	Bugfixes
		* Fixed collision with other plugins using swfobject.js
	Misc
		* Updated to swfobject.js 2.1

0.9.6
	Features
		* Replaced flowplayer with the JW FLV Media Player 4.4 
		* Added 3 empty image formats on options page
		* Added new shortcode options 
	Bugfixes
		* Temporary fix for lightbox display of pictures in widget. Only single images can be displayed (no next or prev button)
	Misc
		* Updated to DirectorPHP 1.1.2
		* Cleaned up database entries and added serialization

0.9.5
	Bugfixes
		* Changed creation of path to flowplayer for better handling of wordpress installations in subdirectories 

0.9.4
	Features:
		* Basic video support 
		* New video preview format added to settings page
		* New video size options added to settings page
		
	Bugfixes
		* Widget always shows most recent images even when an album is selected.
		* New Diretcor API included where malformed UTF8 character problem is fixed.
		* API Path accepts more than 40 characters
	
	Misc
		* Changed spelling of SlideshowPro to SlideShowPro.
		* Added PHP version check on configuration page.
		* Image quality fields on options page accept 3 digits.
		* Nicer formatting of image title tag 

0.9.3
	Bugfixes
		* Fixed: Plugin overrides admin css and leaves blank admin interface.

0.9.2
	Features
		* DirectorPHP caching improves SSPDC performance dramatically. It can be activated on the plugin configuration page. 
		
	Bugfixes
		* Some small fixes in image title and caption display in lightbox.
		* Some users complained that the Director album list remained empty. The DirectorPHP API relies on php_curl for communication with Director. Connector won't work without it. So I added a check on the plugin configuration page with instruction if prerequisites are not met. It's not a really a bug...
	
	Misc
		* Added a check for php_curl on plugin configuration page.
		* Added a check for writable cache directory.
		
0.9.1
	Features
		* New 'description = (true|false)' shortcode for album title and caption output. 
		* New simple SSPDC widget added with option to choose any album or recect images.
	
	Bugfixes
		* Shortcode handler displayed text entered between multiple shortcodes below all pictures instead of in between. 
	
	Misc
		* Replaced plugin screenshots with smaller versions.
		* Moved generation of html output to sspdc extended Director class.
		* Added file sspdc_class.php.
		* Added more album css classes.

0.9.0		
		
	Misc
		* First Relesase / Basic functionality
	
*/

/***
*	This plugin would be useless without the API from SlideShowPro. 
* 	Version 1.2 is included with this plugin. Thanks to the SlideShowPro Team!!
***/
if (!class_exists('Director')) {
	include_once ('classes/DirectorPHP.php');
}

include ('sspdc_class.php');

define('SSPDC_DB', 2);

/***
* 	We need to add some functions, actions, hooks and pages to Wordpress
***/

//  Activste some basic values  
register_activation_hook( __FILE__, 'sspdc_activate' );

// Check if Plugin was installed before



// Serialize old option from before version 0.9.6 / db version < 2

$sspdc_db_version = get_option('sspdc_db_version');
if ( empty(  $sspdc_db_version ) || $sspdc_db_version < 2 ) {
			sspdc_serialize();
			sspdc_delete_options();
			update_option('sspdc_db_version', SSPDC_DB);
}



add_action('admin_menu', 'sspdc_config_pages');

// Hook for adding shortcodes
add_shortcode('sspdc', 'sspdc_shortcode_handler');

add_filter('media_upload_tabs', 'sspdc_media_tab');
add_action('media_upload_sspdc', 'media_upload_sspdc');

if ( !function_exists('wp_enqueue_style') )
add_action('admin_head_media_upload_sspdc_form', 'media_admin_css');

//add_action('wp_admin_css', 'sspdc_admin_css');


add_action('plugins_loaded', 'widget_sspdc_init');

function swfobject_include() {
	
	$swfobject_path = get_settings('siteurl').'/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/js/mediaplayer/swfobject.js';
	wp_deregister_script('swfobject');
	wp_register_script('swfobject', $swfobject_path, false, '2.2');
	wp_enqueue_script( 'swfobject');
	
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain( 'sspdc', '/wp-content/plugins/'.$plugin_dir.'/lang');
}

function sspdc_header() {
	
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/sspdc.css" />'."\n";
}

add_action('wp_head', 'sspdc_header');
add_action('init', 'swfobject_include');
//add_action('save_post', 'sspdc_add_tags');


function sspdc_admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/sspdc_admin.css" />'."\n";
}

/***
*	I don't have a clue how this nonce stuff works.
*	Took it from aksimet and adapted it (thanks Matt).
*	Somebody who understands it should write something about it ;-)
***/

if ( !function_exists('wp_nonce_field') ) {
	function sspdc_nonce_field($action = -1) { return; }
	$sspdc_nonce = -1;
} else {
	function sspdc_nonce_field($action = -1) { return wp_nonce_field($action); }
	$sspdc_nonce = 'sspdc-update-key';
}


/***
*	Function for adding submenus
***/

function sspdc_config_pages() {
	if ( function_exists('add_submenu_page') ) {
		add_submenu_page('plugins.php', __('SSPDC Configuration', 'sspdc'), __('SSPDC Configuration', 'sspdc'), 'manage_options', 'sspdc-key-config', 'sspdc_conf');
	}
	
	if ( function_exists('add_options_page') ) {
		add_options_page(__('SSPDC', 'sspdc'), __('SSPDC', 'sspdc'), 'manage_options', 'sspdc-options', 'sspdc_options');
	}
}

function sspdc_media_tab ( $tabs ) {

	$sspdc_tab = array('sspdc' => __('SSPD Connector', 'sspdc'));
    return array_merge($tabs,$sspdc_tab);
}

function media_upload_sspdc() {
	
	//echo print_r($_REQUEST);
	// Generate TinyMCE HTML output
	
	if ( isset($_POST['send']) ) {
		
		//	echo print_r($_POST);
		
		$keys = array_keys($_POST['send']);
		$send_id = (int) array_shift($keys);
		
		if ( isset( $_POST['image'] ) ) {
		
			$image_id = $_POST['image'][$send_id];
			$format = $_POST['imageformat'][$send_id];
			
			if ( $_POST['imagelink'][$send_id] == 'url') {
				$link = $_POST['imagelinkurl'][$send_id];
			}
			else {
				$link = $_POST['imagelink'][$send_id];
			}
			
			if (!isset( $_POST['video'][$send_id]) ){
				$sspdc_tag = '<p>[sspdc content=' . $image_id . ' link=' . $link . ' format='. $format .']</p>';
			}
			
			elseif (isset( $_POST['video'][$send_id]) && empty( $_POST['video'][$send_id])) {
				$sspdc_tag = '<p>[sspdc content=' . $image_id . ']</p>';
			
			}
			
			else {
				$sspdc_tag = '<p>[sspdc content=' . $image_id .' mediaplayer="' .  stripslashes($_POST['video'][$send_id]) . '"]</p>';
			}
			
			/***
			*	Check wp_options if title and caption should be appendend
			*   to the post
			***/
			
			if ( $_POST['title'][$send_id] == 'yes' || $_POST['caption'][$send_id] == 'yes' ) {
				$sspdc = new sspdc;
				
				$image = $sspdc->content->get($send_id);
			
				if ( $_POST['title'][$send_id] == 'yes') {
			
					$title =  '<p>' . $image->title . '</p>';
					$sspdc_tag .= $title;
				}
			
			
				if ( $_POST['caption'][$send_id] == 'yes' ) {
			
					$caption = '<p>' .$image->caption .'</p>';
					$sspdc_tag .= $caption;
				}
			}
		}

		return media_send_to_editor( $sspdc_tag );
	}
	
	elseif ( isset($_POST['send_album']) ) {
		
		$album_id = $_POST['select_album'];
		$sspdc_tag = '<p>[sspdc album=' . $album_id . ' style=' . $_POST['style'] .  ']</p>';
		
		/***
		*	Check wp_options if title and caption should be appendend
		*   to the post
		***/
		
		if ( $_POST['name'] == 'yes' || $_POST['description'] == 'yes' ) {
			
			$sspdc = new sspdc;
			$album = $sspdc->album->get($album_id);	
			
			if ( $_POST['description'] == 'yes' ) {
			
				$description = '<p>' .$album->description .'</p>';
				$sspdc_tag = $description . $sspdc_tag;
			}
			
			if ( $_POST['name'] == 'yes') {
			
				$name =  '<p>' . $album->name . '</p>';
				$sspdc_tag = $name . $sspdc_tag;
			}
			
		}
		
		return media_send_to_editor( $sspdc_tag );
	}
	
	elseif ( $_REQUEST['select_gallery'] > 0 ) {
	
		$gallery_id = $_REQUEST['select_gallery'];
		$sspdc_tag = '[sspdc gallery=' . $gallery_id . ']';
		return media_send_to_editor( $sspdc_tag );
	}
	
	return wp_iframe( 'media_upload_sspdc_form', $errors );
}

function media_upload_sspdc_form( $errors ) {

	global $wpdb, $wp_query, $wp_locale, $type, $tab, $post_mime_types;
	
	media_upload_header();

	$post_id 	= intval($_REQUEST['post_id']);
	$album_id 	= 0;
	$total 		= 1;
	$images = false;
	
	$form_action_url = get_option('siteurl') . "/wp-admin/media-upload.php?type={$GLOBALS['type']}&tab=sspdc&post_id=$post_id";

	/* 
		Get album and number of images in album;
	*/	
	if ($_REQUEST['select_album']) {
		$album_id = (int) $_REQUEST['select_album'];
		
	}
	
	// Get the images from Slideshow Pro Director
	
	if ( $album_id != 0 ) {
		
		$sspdc = new sspdc();
		$admin_thumb_format = array (
			
				'name' => 'admin_thumb',
				'width'	=> '128',
				'height' => '128',
				'crop' => 1,
				'quality' => 75,
				'sharpening' => 0 );
			
		$sspdc->format->add($admin_thumb_format);
		$album = $sspdc->album->get( $album_id );
		$images = $album->contents[0];	
		
	}
	
	
	
	// Build navigation
	$_GET['paged'] = intval($_GET['paged']);
	if ( $_GET['paged'] < 1 )
		$_GET['paged'] = 1;
	$start = ( $_GET['paged'] - 1 ) * 10;
	if ( $start < 1 )
		$start = 0;
		
	
?>
<div>
<form id="filter" action="" method="get">
<input type="hidden" name="type" value="<?php echo attribute_escape( $GLOBALS['type'] ); ?>" />
<input type="hidden" name="tab" value="<?php echo attribute_escape( $GLOBALS['tab'] ); ?>" />
<input type="hidden" name="post_id" value="<?php echo (int) $post_id; ?>" />

<div class="tablenav">
	
	<?php
	$page_links = paginate_links( array(
		'base' => add_query_arg( 'paged', '%#%' ),
		'format' => '',
		'total' => ceil($total / 10),
		'current' => $_GET['paged']
	));
	
	if ( $page_links )
		echo "<div class='tablenav-pages'>$page_links</div>";
	?>
	
	<div class="alignleft actions">
		<select id="select_album" name="select_album">
		
		<option value="0" <?php selected('0', $album_id); ?> ><?php attribute_escape( _e('Please choose...', 'sspdc') ); ?></option>
		
			<?php
			
			/* Show album selection */
			
			$albums = new sspdc();
			$album_list = $albums->album->all(array( 'only_published' => 'true',
													'only_active' => 'true',
													'list_only' => 'true'
													));
			
			
			foreach( $album_list as $album_list_item)  {
					
					if ( $album_id == $album_list_item->id ) {
					
						$selected = "selected";
					}
					
					else {
					
						$selected = "";
					}
					
					echo '<option value="'.$album_list_item->id.'"'.$selected.' >'.$album_list_item->name.'</option>'."\n";
			}
			?>
		</select>
		
		<input type="submit" id="select_album" value="<?php attribute_escape( _e('Select Album &#187;','sspdc') ); ?>" class="button-secondary" />
		</form>
	</div>
	
	<div class="alignright">
		<select id="select_gallery" name="select_gallery">
		
		<option value="0" <?php selected('0', $gallery_id); ?> ><?php attribute_escape( _e('Please choose...', 'sspdc') ); ?></option>
		
			<?php
			
			/* Show album selection */
			
			$galleries = new sspdc();
			$gallery_list = $galleries->gallery->all();
			
			
			foreach( $gallery_list as $gallery_list_item)  {
					
					if ( $gallery_id == $gallery_list_item->id ) {
					
						$selected = "selected";
					}
					
					else {
					
						$selected = "";
					}
					
					echo '<option value="'.$gallery_list_item->id.'"'.$selected.' >'.$gallery_list_item->name.'</option>'."\n";
			}
			?>
		</select>
		
		<input type="submit" id="select_gallery" value="<?php attribute_escape( _e('Select Gallery &#187;','sspdc') ); ?>" class="button-secondary" />
		</form>
	</div>
</div>


<br class="clear" />
<form enctype="multipart/form-data" method="post" action="<?php echo attribute_escape($form_action_url); ?>" class="media-upload-form" id="library-form">

	<?php wp_nonce_field('sspdc-media-form'); ?>

	<script type="text/javascript">
	<!--
	jQuery(function($){
		var preloaded = $(".media-item.preloaded");
		if ( preloaded.length > 0 ) {
			preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
			updateMediaForm();
		}
	});
	-->
	</script>

	
	
	<?php if ( !empty( $album ) ) { ?>
		<div id="media-items">	
			
		<div id="media-item-<?php echo $album->id ?>" class="media-item preloaded"><div class="filename"></div><a class="toggle describe-toggle-on" href="#"><?php  attribute_escape( _e("Show", "sspdc") ); ?></a>
				
				
		<a class="toggle describe-toggle-off" href="#"><?php attribute_escape( _e("Hide", "sspdc") );?></a>
		<div class="filename new">Album: <?php echo $album->name ?></div>
				
		<table class="slidetoggle describe startclosed">
			<tbody>
			  	<tr>
			  		
			  		<td rowspan='4'>
			  			<?php if (empty($album->preview->url)) { ?>
							<?php _e('not set', 'sspdc'); ?>
						<?php } 
						
						else { ?>
							<img class='thumbnail' alt='<?php echo attribute_escape( $album->name ); ?>' src='<?php echo attribute_escape( $album->preview->url ); ?>'/>
						<?php }  ?>
					</td>
			  		
			  		<tr>
						<td>
							<?php attribute_escape( _e('Album ID: ', "sspdc") ); ?><?php echo $album->id ?>
						</td>
					</tr>
					
					<tr>
						<td>
							<?php attribute_escape( _e('Title: ', "sspdc") ); ?><?php echo $album->name ?>
						</td>
					</tr>
					
					<tr>
						<td>
							<?php attribute_escape( _e('Description: ', "sspdc") ); ?><?php echo $album->description ?>
						</td>
					</tr>
				
				
			  		
			  	
			  	<tr class="style">
			  		<td class="label">
			  			<label for="style">
			  				<?php attribute_escape( _e("Album style", 'sspdc') ); ?>
			  			</label>
			  		</td>	
					<td>
					  	<input type="radio" name="style" value="matrix" checked />
					  	<label for="style" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Matrix", "sspdc") );?></label>
					  	<input type="radio" name="style" value="preview" />
					  	<label for="style" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Preview", "sspdc") );?></label>
					</td>
				</tr>
				
				
				<tr class="name">
					<td class="label"><label for="name"><?php attribute_escape( _e("Add name to post", 'sspdc') ); ?></label></td>
					
					<td class="field" style="text-align: left">
							
						<input name="name" id="name" value="yes" checked="checked" type="radio" />
						<label for="name" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Yes", "sspdc") );?></label>
							
						<input name="name" id="name" value="no" checked="checked" type="radio" />
						<label for="name" class="align" style="padding-right: 5px"><?php attribute_escape( _e("No", "sspdc") );?></label>
							
					</td>
				</tr>
				
				<tr class="description">
					<td class="label"><label for="description"><?php attribute_escape( _e("Add caption to post", 'sspdc') ); ?></label></td>
					<td class="field" style="text-align: left">
							
						<input name="description" id="description" value="yes" checked="checked" type="radio" />
						<label for="description" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Yes", "sspdc") );?></label>
							
						<input name="description" id="description" value="no" checked="checked" type="radio" />
						<label for="description" class="align" style="padding-right: 5px"><?php attribute_escape( _e("No", "sspdc") );?></label>
							
					</td>
				</tr>
					

				   
				<tr class="submit">
					<td>
						<input type="hidden"  name="album[<?php echo $album->id ?>]" value="<?php echo $album->id ?>" />
					</td>
					<td class="savesend">
						<button type="submit" class="button" value="1" name="send_album[<?php echo $album->id ?>]"><?php echo attribute_escape( __('Insert Album into Post', 'sspdc') ); ?></button>
					</td>
				 </tr>
			</tbody>
		</table>
		</div>
		</div>
	<?php }
	
	
	if ( !empty( $images ) ) { ?>		
		<?php $sspdc_fmt = unserialize((get_option('sspdc_fmt'))); ?> 
		<div id="media-items">	
			<?php foreach ($images as $image) { ?>	
				<div id="media-item-<?php echo $image->id ?>" class="media-item preloaded"><div class="filename"></div><a class="toggle describe-toggle-on" href="#"><?php  attribute_escape( _e("Show", "sspdc") ); ?></a>
				<a class="toggle describe-toggle-off" href="#"><?php attribute_escape( _e("Hide", "sspdc") );?></a>
				<div class="filename new"><?php echo $image->title ?></div>
			  	<table class="slidetoggle describe startclosed"><tbody>
				<tr>
					<td rowspan='7'>
						<img class='thumbnail' alt='<?php echo attribute_escape( $image->title ); ?>' src='<?php echo attribute_escape( $image->admin_thumb->url ); ?>'/>
					</td>
					<tr>
						<td>
							<?php attribute_escape( _e('Image ID: ', "sspdc") ); ?><?php echo $image->id ?>
						</td>
					</tr>
					
					<tr>	
						<td>
							<?php attribute_escape( _e('Title: ', "sspdc") ); ?><?php echo attribute_escape( $image->title ); ?><?php if ($sspdc->utils->is_video( $image->src )) { echo _e(' (Video) ', 'sspdc');} ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php attribute_escape( _e('Caption: ', "sspdc")); echo attribute_escape( stripslashes($image->caption) ); ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php attribute_escape( _e('Link: ', "sspdc"));  if ($image->link == ''){ echo "none"; } else {  echo attribute_escape( stripslashes($image->link) );} ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php attribute_escape( _e('Tags: ', "sspdc"));  if ($image->tags == ''){ echo "none"; } else {  echo attribute_escape( stripslashes($image->tags) );} ?>
						</td>
					</tr>
					
				
				<tr><td>&nbsp;</td></tr>
				  <?php if ($sspdc->utils->is_image( $image->src )) { ?>
					
				<tr class="imageformat">
					<td class="label"><label for="imageformat"><?php attribute_escape( _e("Format", 'sspdc') ); ?></label></td>
						
					<td class="field" style="text-align: left">
							
						<input name="imageformat[<?php echo $image->id ?>]" id="imageformat[<?php echo $image->id ?>]" checked="checked" value="post" type="radio" />
						<label for="imageformat" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Post", 'sspdc') );?></label>
								
						<input name="imageformat[<?php echo $image->id ?>]" id="imageformat[<?php echo $image->id ?>]" value="original" type="radio" />
						<label for="imageformat" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Original","sspdc"));?></label>
								
						<?php if ( !empty( $sspdc_fmt[1][name]) ) { ?>
							<input name="imageformat[<?php echo $image->id ?>]" id="imageformat[<?php echo $image->id ?>]"  value="<?php echo $sspdc_fmt[1][name] ?>" type="radio" />
							<label for="imageformat" class="align" style="padding-right: 5px"><?php attribute_escape( _e($sspdc_fmt[1][name], 'sspdc') );?></label>
						<?php } ?>
								
						<?php if ( !empty( $sspdc_fmt[2][name]) ) { ?>
							<input name="imageformat[<?php echo $image->id ?>]" id="imageformat[<?php echo $image->id ?>]"  value="<?php echo $sspdc_fmt[2][name] ?>" type="radio" />
							<label for="imageformat" class="align" style="padding-right: 5px"><?php attribute_escape( _e($sspdc_fmt[2][name], 'sspdc') );?></label>
						<?php } ?>
								
						<?php if ( !empty( $sspdc_fmt[3][name]) ) { ?>
							<input name="imageformat[<?php echo $image->id ?>]" id="imageformat[<?php echo $image->id ?>]" value="<?php echo $sspdc_fmt[3][name] ?>" type="radio" />
							<label for="imageformat" class="align" style="padding-right: 5px"><?php attribute_escape( _e($sspdc_fmt[3][name], 'sspdc') );?></label>
						<?php } ?>
							
					</td>
				</tr>
					
				<tr class="imagelink">
						<td class="label"><label for="imagelink"><?php attribute_escape( _e("Link", 'sspdc') ); ?></label></td>
						<td class="field" style="text-align: left">
							
							<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]" value="none" checked="checked" type="radio" />
							<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("None", 'sspdc') );?></label>
							
							<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]"  value="post" type="radio" />
							<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Post", 'sspdc') );?></label>
							
							<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]"  value="original" type="radio" />
							<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Original", 'sspdc') );?></label>
							
							<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]"  value="raw" type="radio" />
							<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Raw link to format", 'sspdc') );?></label>
							
							<?php if (!empty($image->link[0])) { ?>
								<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]"  value="director" type="radio" />
								<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Director (see above)", 'sspdc') );?></label>
							<?php } ?>
							
							<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]"  value="lightbox" type="radio" />
							<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Lightbox", 'sspdc') );?></label>
							
						</td>
					</tr>
				<tr class="imagelink">
						<td></td>
						<td class="field" style="text-align: left">
							<input name="imagelink[<?php echo $image->id ?>]" id="imagelink[<?php echo $image->id ?>]" value="url" type="radio" />
							<label for="imagelink" class="align" style="padding-right: 5px"><?php attribute_escape( _e("URL (enter below)",'sspdc') );?></label>
							<label for="imagelink" style="padding-right: 5px"><?php attribute_escape( _e('', "sspdc") );?></label>
							<input id="imagelinkurl[<?php echo $image->id ?>]" name="imagelinkurl[<?php echo $image->id ?>]" value="http://" type="text"/>
						</td>
					</tr>
					
				<?php } elseif ($sspdc->utils->is_video( $image->src ))  { ?>
				<tr class="video">
					<td class="label" style="vertical-align:top"><label for="imagelink"><?php attribute_escape( _e("Videoparameter", 'sspdc') ); ?></label></td>
					<td class="field" style="text-align: left">
										
						<input id="video[<?php echo $image->id ?>]" name="video[<?php echo $image->id ?>]" value="" type="text"/>
						<p class="help">(e.g. controlbar=bottom&backcolor=#000000&frontcolor=#999999)<br /> <a href="http://developer.longtailvideo.com/trac/wiki/FlashVars" target="_blank">check this list</a></p>
					</td>
				</tr>
					
				<?php } ?>
					
				<tr class="title">
						<td class="title"><label for="title"><?php attribute_escape( _e("Add title to post",'sspdc') ); ?></label></td>
						<td class="field" style="text-align: left">
							
							<input name="title[<?php echo $image->id ?>]" id="title[<?php echo $image->id ?>]" value="yes" checked="checked" type="radio" />
							<label for="title" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Yes", "sspdc") );?></label>
							
							<input name="title[<?php echo $image->id ?>]" id="title[<?php echo $image->id ?>]" value="no" checked="checked" type="radio" />
							<label for="title" class="align" style="padding-right: 5px"><?php attribute_escape( _e("No", "sspdc") );?></label>
							
						</td>
					</tr>
					
				<tr class="caption">
						<td class="label"><label for="caption"><?php attribute_escape( _e("Add caption to post", 'sspdc') ); ?></label></td>
						<td class="field" style="text-align: left">
							
							<input name="caption[<?php echo $image->id ?>]" id="caption[<?php echo $image->id ?>]" value="yes" checked="checked" type="radio" />
							<label for="caption" class="align" style="padding-right: 5px"><?php attribute_escape( _e("Yes", "sspdc") );?></label>
							
							<input name="caption[<?php echo $image->id ?>]" id="caption[<?php echo $image->id ?>]" value="no" checked="checked" type="radio" />
							<label for="caption" class="align" style="padding-right: 5px"><?php attribute_escape( _e("No", "sspdc") );?></label>
							
						</td>
					</tr>
					
				<tr class="submit">
					<td>
						<input type="hidden"  name="image[<?php echo $image->id ?>]" value="<?php echo $image->id ?>" />
					</td>
					<td class="savesend">
						<button type="submit" class="button" value="1" name="send[<?php echo $image->id ?>]"><?php echo attribute_escape( __('Insert into Post', 'sspdc') ); ?></button>
					</td>
				 </tr>
				</tbody></table>
			</div>
			<?php } ?>
				
		
		
	<?php } ?>
	
	
	<input type="hidden" name="post_id" id="post_id" value="<?php echo (int) $post_id; ?>" />
	<input type="hidden" name="select_album" id="select_album" value="<?php echo (int) $album_id; ?>" />
	</div>
	
</form>

<?php
}


function sspdc_options() {
	global $sspdc_nonce;
	
	if ( isset($_POST['submit']) ) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			die(__('Cheatin&#8217; uh?', 'sspdc'));
	
		$sspdc_fmt['post_width'] =  $_POST['sspdc_fmt_post_width'];
		$sspdc_fmt['post_height'] =  $_POST['sspdc_fmt_post_height'];
		$sspdc_fmt['post_crop'] =  $_POST['sspdc_fmt_post_crop'];
		$sspdc_fmt['post_quality'] =  $_POST['sspdc_fmt_post_quality'];
		$sspdc_fmt['post_sharpening'] =  $_POST['sspdc_fmt_post_sharpening'];
		
		$sspdc_fmt['preview_width'] =  $_POST['sspdc_fmt_preview_width'];
		$sspdc_fmt['preview_height'] =  $_POST['sspdc_fmt_preview_height'];
		$sspdc_fmt['preview_crop'] =  $_POST['sspdc_fmt_preview_crop'];
		$sspdc_fmt['preview_quality'] =  $_POST['sspdc_fmt_preview_quality'];
		$sspdc_fmt['preview_sharpening'] =  $_POST['sspdc_fmt_preview_sharpening'];
		
		$sspdc_fmt['matrix_width'] =  $_POST['sspdc_fmt_matrix_width'];
		$sspdc_fmt['matrix_height'] =  $_POST['sspdc_fmt_matrix_height'];
		$sspdc_fmt['matrix_crop'] =  $_POST['sspdc_fmt_matrix_crop'];
		$sspdc_fmt['matrix_quality'] =  $_POST['sspdc_fmt_matrix_quality'];
		$sspdc_fmt['matrix_sharpening'] =  $_POST['sspdc_fmt_matrix_sharpening'];
		
		$sspdc_fmt['fullsize_width'] =  $_POST['sspdc_fmt_fullsize_width'];
		$sspdc_fmt['fullsize_height'] =  $_POST['sspdc_fmt_fullsize_height'];
		$sspdc_fmt['fullsize_crop'] =  $_POST['sspdc_fmt_fullsize_crop'];
		$sspdc_fmt['fullsize_quality'] =  $_POST['sspdc_fmt_fullsize_quality'];
		$sspdc_fmt['fullsize_sharpening'] =  $_POST['sspdc_fmt_fullsize_sharpening'];
		
		$sspdc_fmt['photostrip_width'] =  $_POST['sspdc_fmt_photostrip_width'];
		$sspdc_fmt['photostrip_height'] =  $_POST['sspdc_fmt_photostrip_height'];
		$sspdc_fmt['photostrip_crop'] =  $_POST['sspdc_fmt_photostrip_crop'];
		$sspdc_fmt['photostrip_quality'] =  $_POST['sspdc_fmt_photostrip_quality'];
		$sspdc_fmt['photostrip_sharpening'] =  $_POST['sspdc_fmt_photostrip_sharpening'];
		
		$sspdc_fmt['widget_width'] =  $_POST['sspdc_fmt_widget_width'];
		$sspdc_fmt['widget_height'] =  $_POST['sspdc_fmt_widget_height'];
		$sspdc_fmt['widget_crop'] =  $_POST['sspdc_fmt_widget_crop'];
		$sspdc_fmt['widget_quality'] =  $_POST['sspdc_fmt_widget_quality'];
		$sspdc_fmt['widget_sharpening'] =  $_POST['sspdc_fmt_widget_sharpening'];
		
		/* Custom options sspdc_fmt_custom3_sharpening */
		
		$sspdc_fmt[1]['name'] =  str_replace(' ', '_', $_POST['sspdc_fmt_custom1_name']);
		$sspdc_fmt[1]['width'] =  $_POST['sspdc_fmt_custom1_width'];
		$sspdc_fmt[1]['height'] =  $_POST['sspdc_fmt_custom1_height'];
		$sspdc_fmt[1]['crop'] =  $_POST['sspdc_fmt_custom1_crop'];
		$sspdc_fmt[1]['quality'] =  $_POST['sspdc_fmt_custom1_quality'];
		$sspdc_fmt[1]['sharpening'] =  $_POST['sspdc_fmt_custom1_sharpening'];
		
		$sspdc_fmt[2]['name'] =  str_replace(' ', '_', $_POST['sspdc_fmt_custom2_name']);
		$sspdc_fmt[2]['width'] =  $_POST['sspdc_fmt_custom2_width'];
		$sspdc_fmt[2]['height'] =  $_POST['sspdc_fmt_custom2_height'];
		$sspdc_fmt[2]['crop'] =  $_POST['sspdc_fmt_custom2_crop'];
		$sspdc_fmt[2]['quality'] =  $_POST['sspdc_fmt_custom2_quality'];
		$sspdc_fmt[2]['sharpening'] =  $_POST['sspdc_fmt_custom2_sharpening'];
		
		$sspdc_fmt[3]['name'] =  str_replace(' ', '_', $_POST['sspdc_fmt_custom2_name']);
		$sspdc_fmt[3]['width'] =  $_POST['sspdc_fmt_custom3_width'];
		$sspdc_fmt[3]['height'] =  $_POST['sspdc_fmt_custom3_height'];
		$sspdc_fmt[3]['crop'] =  $_POST['sspdc_fmt_custom3_crop'];
		$sspdc_fmt[3]['quality'] =  $_POST['sspdc_fmt_custom3_quality'];
		$sspdc_fmt[3]['sharpening'] =  $_POST['sspdc_fmt_custom3_sharpening'];
				
		/* Video size option */
		
		$sspdc_fmt['video_preview_width'] =  $_POST['sspdc_fmt_video_preview_width'];
		$sspdc_fmt['video_preview_height'] =  $_POST['sspdc_fmt_video_preview_height'];
		$sspdc_fmt['video_preview_crop'] =  $_POST['sspdc_fmt_video_preview_crop'];
		$sspdc_fmt['video_preview_quality'] =  $_POST['sspdc_fmt_video_preview_quality'];
		$sspdc_fmt['video_preview_sharpening'] =  $_POST['sspdc_fmt_video_preview_sharpening'];
		

		
		$sspdc_fmt['video_width'] =  $_POST['sspdc_fmt_video_width'];
		$sspdc_fmt['video_height'] =  $_POST['sspdc_fmt_video_height'];
		
		update_option('sspdc_fmt', serialize($sspdc_fmt));
	}
	
	if ( !empty($_POST) ) {

	}

	?>
	
	<?php $sspdc_fmt = unserialize((get_option('sspdc_fmt'))); ?> 
	<div class="wrap">
	<h2><?php _e('SlideShowPro Director Connector Options', 'sspdc'); ?></h2>
	<div class="narrow">
	<form action="" method="post" id="sspdc-options" >
	<h3><?php _e('Formats', 'sspdc') ?></h3>
		<p><?php _e("This section controls the on-demand image publishing system of Director.", 'sspdc'); ?></p>
		
		<table class="form-table">
			<tr valign="middle">
				<th scope="row"><?php _e('Name', 'sspdc') ?></th>
				<th align="center"><?php _e('Width', 'sspdc') ?></th>
				<th align="center"><?php _e('Height', 'sspdc') ?></th>
				<th align="center"><?php _e('Crop', 'sspdc') ?></th>
				<th align="center"><?php _e('Quality', 'sspdc') ?></th>
				<th align="center"><?php _e('Sharpening', 'sspdc') ?></th>
			</tr>
			
			<tr>
				<th><?php _e('Single Image in Posts & Pages', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_post_width" name="sspdc_fmt_post_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['post_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_post_height" name="sspdc_fmt_post_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['post_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_post_crop" name="sspdc_fmt_post_crop">
						<option value="0" <?php if($sspdc_fmt['post_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['post_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_post_quality" name="sspdc_fmt_post_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['post_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_post_sharpening" name="sspdc_fmt_post_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['post_sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<th><?php _e('Album Preview', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_preview_width" name="sspdc_fmt_preview_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['preview_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_preview_height" name="sspdc_fmt_preview_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['preview_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_preview_crop" name="sspdc_fmt_preview_crop">
						<option value="0" <?php if($sspdc_fmt['preview_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['preview_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_preview_quality" name="sspdc_fmt_preview_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['preview_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_preview_sharpening" name="sspdc_fmt_preview_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['preview_sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<th><?php _e('Album Matrix', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_matrix_width" name="sspdc_fmt_matrix_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['matrix_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_matrix_height" name="sspdc_fmt_matrix_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['matrix_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_matrix_crop" name="sspdc_fmt_matrix_crop">
						<option value="0" <?php if($sspdc_fmt['matrix_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['matrix_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_matrix_quality" name="sspdc_fmt_matrix_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['matrix_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_matrix_sharpening" name="sspdc_fmt_matrix_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['matrix_sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<th><?php _e('Lightview Fullsize', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_fullsize_width" name="sspdc_fmt_fullsize_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['fullsize_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_fullsize_height" name="sspdc_fmt_fullsize_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['fullsize_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_fullsize_crop" name="sspdc_fmt_fullsize_crop">
						<option value="0" <?php if($sspdc_fmt['fullsize_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['fullsize_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_fullsize_quality" name="sspdc_fmt_fullsize_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['fullsize_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_fullsize_sharpening" name="sspdc_fmt_fullsize_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['fullsize_sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<th><?php _e('Photostrip Thumbnails', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_photostrip_width" name="sspdc_fmt_photostrip_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['photostrip_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_photostrip_height" name="sspdc_fmt_photostrip_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['photostrip_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_photostrip_crop" name="sspdc_fmt_photostrip_crop">
						<option value="0" <?php if($sspdc_fmt['photostrip_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['photostrip_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_photostrip_quality" name="sspdc_fmt_photostrip_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['photostrip_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_photostrip_sharpening" name="sspdc_fmt_photostrip_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['photostrip_sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<th><?php _e('Widget Thumbnails','sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_widget_width" name="sspdc_fmt_widget_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['widget_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_widget_height" name="sspdc_fmt_widget_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['widget_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_widget_crop" name="sspdc_fmt_widget_crop">
						<option value="0" <?php if($sspdc_fmt['widget_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['widget_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_widget_quality" name="sspdc_fmt_widget_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['widget_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_widget_sharpening" name="sspdc_fmt_widget_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['widget_sharpening'];?>" />
				</td>
			</tr>
			<tr><td colspan="6"><hr /></td></tr>
			
			<tr> 
				<td>
					<input id="sspdc_fmt_custom1_name" name="sspdc_fmt_custom1_name" type="text" size="15" maxlength="15" value="<?php echo $sspdc_fmt[1]['name'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom1_width" name="sspdc_fmt_custom1_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt[1]['width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom1_height" name="sspdc_fmt_custom1_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt[1]['height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_custom1_crop" name="sspdc_fmt_custom1_crop">
						<option value="0" <?php if($sspdc_fmt[1]['crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt[1]['crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom1_quality" name="sspdc_fmt_custom1_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt[1]['quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom1_sharpening" name="sspdc_fmt_custom1_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt[1]['sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<td>
					<input id="sspdc_fmt_custom2_name" name="sspdc_fmt_custom2_name" type="text" size="15" maxlength="15" value="<?php echo $sspdc_fmt[2]['name'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom2_width" name="sspdc_fmt_custom2_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt[2]['width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom2_height" name="sspdc_fmt_custom2_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt[2]['height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_custom2_crop" name="sspdc_fmt_custom2_crop">
						<option value="0" <?php if($sspdc_fmt[2]['crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt[2]['crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom2_quality" name="sspdc_fmt_custom2_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt[2]['quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom2_sharpening" name="sspdc_fmt_custom2_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt[2]['sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<td>
					<input id="sspdc_fmt_custom3_name" name="sspdc_fmt_custom3_name" type="text" size="15" maxlength="14" value="<?php echo $sspdc_fmt[3]['name'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom3_width" name="sspdc_fmt_custom3_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt[3]['width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom3_height" name="sspdc_fmt_custom3_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt[3]['height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_custom3_crop" name="sspdc_fmt_custom3_crop">
						<option value="0" <?php if($sspdc_fmt[3]['crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt[3]['crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom3_quality" name="sspdc_fmt_custom3_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt[3]['quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_custom3_sharpening" name="sspdc_fmt_custom3_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt[3]['sharpening'];?>" />
				</td>
			</tr>
			
			<tr><td colspan="6"><hr /></td></tr>
			<tr>
				<th><?php _e('Video Preview', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_video_preview_width" name="sspdc_fmt_video_preview_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['video_preview_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_video_preview_height" name="sspdc_fmt_video_preview_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['video_preview_height'];?>" />
				</td>
				<td align="center">
					<select id="sspdc_fmt_video_preview_crop" name="sspdc_fmt_video_preview_crop">
						<option value="0" <?php if($sspdc_fmt['video_preview_crop'] == 0) echo "selected"; ?>><?php _e('No', 'sspdc') ?></option>
						
						<option value="1" <?php if($sspdc_fmt['video_preview_crop'] == 1) echo "selected"; ?>><?php _e('Yes', 'sspdc') ?></option>
					</select>
				</td>
				<td align="center">
					<input id="sspdc_fmt_video_preview_quality" name="sspdc_fmt_video_preview_quality" type="text" size="3" maxlength="3" value="<?php echo $sspdc_fmt['video_preview_quality'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_video_preview_sharpening" name="sspdc_fmt_video_preview_sharpening" type="text" size="1" maxlength="1" value="<?php echo $sspdc_fmt['video_preview_sharpening'];?>" />
				</td>
			</tr>
			
			<tr>
				<th><?php _e('Video Size', 'sspdc') ?></th>
				<td align="center">
					<input id="sspdc_fmt_video_width" name="sspdc_fmt_video_width" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['video_width'];?>" />
				</td>
				<td align="center">
					<input id="sspdc_fmt_video_height" name="sspdc_fmt_video_height" type="text" size="4" maxlength="4" value="<?php echo $sspdc_fmt['video_height'];?>" />
				</td>
				<td align="center">
					
				</td>
				<td align="center">
					
				</td>
				<td align="center">
					
				</td>
			</tr>
		</table>
	
	<p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;', 'sspdc'); ?>" /></p>
	
	<p><?php _e("Don't forget to install the fabulous Lightbox 2 plugin by Rupert Morris. Otherwise the fullsize format will open in a new browser window which is not very nice.", 'sspdc');?></p>
	<p><?php _e("Get Lightbox from here: <a href='http://wordpress.org/extend/plugins/lightbox-2/'> Lightbox 2</a>", 'sspdc'); ?>
	
	<h4><?php _e('Recommended Lightbox Options', 'sspdc')?></h4>
	
	<ul>
		<li>Filter Images in Posts: yes</li>
		<li>Filter Images in Excerpt: no </li>
		<li>Filter Images in Comments: no</li>
	</ul>
	
<?php }


/***
*	Function for adding a submenu to the plugins menu if one has permission
*	to manage options.
***/

function sspdc_conf() {
	global $sspdc_nonce;

	if ( isset($_POST['submit']) ) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			die(__('Cheatin&#8217; uh?', 'sspdc'));

		check_admin_referer( $sspdc_nonce );
		
		/**
		 * @todo A real connection check would be great but the Director __construct only checks the values so far.		 
		 */
		
		$director = new Director($_POST['sspdc_api_key'],$_POST['sspdc_api_path'],false);
		
		if ( !$director->dead == 1 ) {
				
			update_option('sspdc_api_key', $_POST['sspdc_api_key']);
			update_option('sspdc_api_path', $_POST['sspdc_api_path']);
			
			?><div id="message" class="updated fade"><p><strong><?php _e('Your SlideShowPro Director API settings are ok. Options saved.', 'sspdc') ?></strong></p></div><?php
			unset($director);
			unset( $_POST['sspdc_api_key']);
			unset( $_POST['sspdc_api_path']);
			
		}
		
		else {
		
			?><div id="message" class="error"><p><strong><?php _e('API Settings are wrong. Pleas double check it.', 'sspdc') ?></strong></p></div>
		<?php
		}	
		
		update_option('sspdc_cache', $_POST['sspdc_cache']);
	}	
?>
<?php if ( !empty($_POST ) ) : ?>

<?php endif; ?>


<div class="wrap">
<h2><?php _e('SlideShowPro Director Connector Configuration', 'sspdc'); ?></h2>
<div class="narrow">
<form action="" method="post" id="sspdc-conf" >

<?php sspdc_nonce_field($sspdc_nonce) ?>

	
<h3><?php _e('API Key Settings', 'sspdc') ?></h3>
	<p><?php _e('The settings can be found on the "System Info" page of your SlideShowPro Director installation.', 'sspdc'); ?></p>

	<table class="form-table">
		<tr valign="middle">
			<th scope="row">
				<label for="sspdc_api_key"><?php _e('Director API Key', 'sspdc'); ?></label>
			</th> 
			<td><input id="sspdc_api_key" name="sspdc_api_key" type="text" size="40" value="<?php echo get_option('sspdc_api_key'); ?>" /> 
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="sspdc_api_path"><?php _e('Director API Path', 'sspdc'); ?></label>
			</th> 
			<td><input id="sspdc_api_path" name="sspdc_api_path" type="text" size="40" value="<?php echo get_option('sspdc_api_path'); ?>" /> 
			</td>
		</tr>
	</table>
<h3><?php _e('API Cache Settings', 'sspdc') ?></h3>
	<p><?php _e('The API cache can improve performance dramatically.', 'sspdc') ?></p>
	<?php if (!is_writable ( realpath(dirname(__FILE__)) . '/classes/cache' )) { 
		$disable_cache = 1;
		update_option('sspdc_cache', '0');
		echo "<p style='color:red;'>WARNING: Your cache directory is not writable. You can't activate caching unless you allow your webserver to write to <code>'wp-content/plugins/" . plugin_basename(dirname(__FILE__)) . "/classes/cache'</code>.</p>";
	}?>

	<table class="form-table">
		<tr valign="middle">
			<th scope="row">
				<label for="sspdc_cache"><?php _e('API Cache', 'sspdc'); ?></label>
			</th> 
			<td>
			<?php _e('On:', 'sspdc'); ?><input <?php if ($disable_cache == 1) { echo "DISABLED";} ?> id="sspdc_cache" name="sspdc_cache" type="radio" value="1" <?php if (get_option('sspdc_cache') == '1') { _e('checked="checked"','sspdc'); } ?> /> 
			<?php _e('Off:', 'sspdc'); ?><input <?php if ($disable_cache == 1) { echo "DISABLED";} ?> id="sspdc_cache" name="sspdc_cache" type="radio" value="0" <?php if (get_option('sspdc_cache') == '0') { _e('checked="checked"', 'sspdc');}  DISABLED?> /> 
			</td>
		</tr>
	</table>
	<p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;', 'sspdc'); ?>" /></p>
</form>
</div>
<div class="narrow">
	<h3><?php _e('Prerequisites', 'sspdc') ?></h3>
<p>
	<?php $phpversion = explode( ".", phpversion()); ?>
	
	<?php if ( $phpversion[0] < "5" ) { ?>
		<p style="color:red;"><?php _e('WARNING: Your PHP version is too old. SSPDC will not work. ', 'sspdc');?></p><p><?php _e('The DirectorPHP API needs at least PHP 5. Please install it or get in touch with your internet provider or system administrator', 'sspdc'); ?></p>
	<?php } 
	
	else {?>
	<p style="color:green;"><?php _e('Great! PHP 5 is available. Version: ', 'sspdc'); echo phpversion(); ?></p>
	
	<?php } ?>
	
	<?php if ( !function_exists ( curl_version ) ) { ?>
		<p style="color:red;"><?php _e('WARNING: php_curl is not installed. SSPDC will not work. ', 'sspdc');?></p><p><?php _e('The DirectorPHP API relies on php_curl for talking to Director. Please install it or get in touch with your internet provider or system administrator and give him this link: <a href="http://ch.php.net/manual/en/book.curl.php">http://ch.php.net/manual/en/book.curl.php</a>.', 'sspdc'); ?></p>
	<?php } 
	
	else {?>
	<p style="color:green;"><?php _e('Cool! PHP curl is installed. Version: ', 'sspdc'); $curl = curl_version(); echo $curl['version'];?></p>
	
	<?php } ?>
	
</p>
</div>
</div>
<?php
}



if ( !get_option('sspdc_api_key') || !get_option('sspdc_api_path') && !isset($_POST['submit']) ) {
	add_action('admin_notices', 'sspdc_warning');
	return;
}

function sspdc_warning() {
		echo "
		<div id='sspdc-warning' class='updated fade'><p><strong>".__('SlideshowPro Director Connector is almost ready.', 'sspdc')."</strong> ".sprintf(__('You must <a href="%1$s">enter your  API key &amp; path</a> for it to work.', 'sspdc'), "plugins.php?page=sspdc-key-config")."</p></div>
		";
	}

function sspdc_shortcode_handler( $atts, $content=null) {

	/*** 
	*	Create $html for a single image. Used in posts.
	*
	*	-> [sspdc content=(content_id) link=(lightbox|director|url:) format=(custom_format_name) mediaplayer=flashvars]
	***/
	
	if ( array_key_exists( 'image', $atts ) ) {
	
		$atts['content'] = $atts['image'];
	}
	
	if ( !empty( $atts['content'] ) ) {
		
		$sspdc = new sspdc();
		return $sspdc->content->html( $atts['content'], $atts['link'], $atts['format'], $atts['mediaplayer'] );
		
		end;
	}
	
	/*** 
	*	Create html for an album.
	*	Either matrix view or album preview image as entry point 
	*	
	*	[sspdc album=(album_id) style=(preview|matrix) description=(true|false) link=() ssp_flashvars=flashvars]
	***/
	
	if ( !empty( $atts['album'] ) ) {				
		$sspdc_a = new sspdc();
		return $sspdc_a->album->html( $atts['album'] , $atts['style'], $atts['description'], $atts['link'], $atts['num']);
		end;
	}
	
	/*** 
	*	Create html for a gallery.
	*	Album preview image as entry point 
	*	
	*	[sspdc gallery=(gallery_id)]
	***/
	
	if ( !empty( $atts['gallery'] ) ) {				
		$sspdc_g = new sspdc();
		
		return $sspdc_g->gallery->html($atts['gallery']);
		
		end;
	}
}

function sspdc_add_tags($post_id) {
	
	/* Work in progress. Not implemented yet */
	if (!wp_is_post_revision( $post_id )) {
	
		$post = get_post($post_id, ARRAY_A);
		
		$shortcode = shortcode_parse_atts($post['post_content']);
		
		if (array_key_exists ( 'content', $shortcode )){
			
			$sspdc_content_id = trim ( $shortcode['content'], ']' );
			$sspdc = new sspdc;
			$content = $sspdc->content->get($sspdc_content_id);
			$tags = explode ( ' ', $content->tags );
			
			
			
			$post['post_tag'] ='halo';
			wp_update_post($post);
			
			
			
		}
	}
}

function widget_sspdc_init() {

	if (!function_exists('register_sidebar_widget')) return;
	
	$sspdc_fmt = get_option('sspdc_fmt');
	
	if (!empty($sspdc_fmt )) {
		$sspdc_fmt = unserialize( get_option('sspdc_fmt'));
	
		if ( !isset( $sspdc_fmt['widget_width'] )) {
		
			//sspdc_activate();
			$sspdc_fmt['widget_width'] = 54;
			$sspdc_fmt['widget_height'] = 54;
			$sspdc_fmt['widget_crop'] = 1;
			$sspdc_fmt['widget_quality'] = 75;
			$sspdc_fmt['widget_sharpening'] = 1;
			
			update_option('sspdc_fmt', serialize($sspdc_fmt));
		}
	}
	
	function widget_sspdc($args) {
		
		extract($args);
		
		$options = get_option('sspdc_widget');
		$title = $options['title'];
		$before_images = $options['before'];
		$after_images = $options['after'];
		$image_count = $options['image_count'];
		$album_id = $options['album_id'];
		
		echo $before_widget . $before_title . $title . $after_title . $before_images;
		sspdc_widget($image_count, $album_id);
		echo $after_images . $after_widget;
	}
	
	function widget_sspdc_control() {
		$options = get_option('sspdc_widget');
		//echo print_r( $options);
		
		if ( $_POST['sspdc_submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['sspdc_widget_title']));
			$options['before'] = $_POST['sspdc_widget_before'];
			$options['after'] = $_POST['sspdc_widget_after'];
			$options['image_count'] = $_POST['sspdc_widget_imagecount'];
			$options['album_id'] = $_POST['sspdc_widget_album'];
			update_option('sspdc_widget', $options);
		}

		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$selected_album = $options['album_id'];
		$before = htmlspecialchars($options['before'], ENT_QUOTES);
		$after = htmlspecialchars($options['after'], ENT_QUOTES);
		$image_count = $options['image_count'];
		
		?>
		<p><label for="sspdc_widget_title"><?php _e('Title:', 'sspdc'); ?><input class="widefat" id="sspdc_widget_title" name="sspdc_widget_title" type="text" value="<?php echo $title; ?>" /></label></p>
		
		<p><label for="sspdc_widget_imagecount"><?php _e('Image count:', 'sspdc') ?><input class="widefat" id="sspdc_widget_imagecount" name="sspdc_widget_imagecount" type="text" value="<?php echo $image_count ?>"  /></label></p>
		
		<p><label for="sspdc_widget_before"><?php _e('Before all images:', 'sspdc') ?> <input class="widefat" id="sspdc_widget_before" name="sspdc_widget_before" type="text" value="<?php echo $before ?>" /></label></p>
		
		<p><label for="sspdc_widget_after"><?php _e('After all images:', 'sspdc') ?> <input class="widefat" id="sspdc_widget_after" name="sspdc_widget_after" type="text" value="<?php echo $after ?>" /></label></p>
		
		<p><label for="sspdc_widget_album"><?php _e('Album:','sspdc'); ?></p>
		
		<p>
		<select id="sspdc_widget_album" name="sspdc_widget_album">
		<option value="0"><?php attribute_escape( _e('Recent images','sspdc') ); ?></option>
		
			<?php
			
			/* Show album selection */
			
			$sspdc = new sspdc();
			$album_list = $sspdc->album->all(array( 'only_published' => 'true',
													'only_active' => 'true',
													'list_only' => 'true'
													));
			
			foreach( $album_list as $album_list_item)  {
					
					if ( $selected_album == $album_list_item->id ) {
					
						$selected = "selected";
					}
					
					else {
					
						$selected = "";
					}
					
					echo '<option value="'.$album_list_item->id.'"'.$selected.' >'.$album_list_item->name.'</option>'."\n";
			}
			?>
		</select>
		<p>
		
		<input type="hidden" id="sspdc_submit" name="sspdc_submit" value="1" />
		<?php
	}		

	register_sidebar_widget('SSPDC', 'widget_sspdc');
	register_widget_control('SSPDC', 'widget_sspdc_control');
}


function sspdc_photostrip( $album_id, $image_count ) {
		
		$director = new sspdc;
		$album = $director->album->get( $album_id );
		$images = $album->contents[0];
		
		$i = 0;
		$html = '<div class="sspdc_photostrip">';
		
		foreach( $images as $image ) {
			
			if ($i < $image_count ) {
			
				$html .= '<div class="sspdc_thumbnail"><a href="'. $image->fullsize->url . '" rel="lightbox[photostrip]" title="'.  $image->title . '. ' . $image->caption . '"><img src="' . $image->thumb->url . '"  alt="'  . $image->title . ", " . $image->caption . '" /> </a></div>';
			}
			
			else {
			
				$html .= '<div class="sspdc_thumbnail"><a href="'. $image->fullsize->url . '" rel="lightbox[photostrip]" title="'.  $image->title .'"> </a></div>';
			}
			
			$i++;
		}
		
		$html .= '</div>';
		echo $html;
}

function sspdc_widget( $image_count, $album_id = NULL ) {
		
		$director = new sspdc;
		
		if ( is_null ( $album_id ) || $album_id < 1 ) {
			
			
			$images = $director->content->all(array('limit' => $image_count, 'only_images' => true));
		}
		
		else {
			$album = $director->album->get( $album_id );
			$images = $album->contents[0];
		}
		
		$lightview_is_active = class_exists('lightview_plus');
		
		$i = 0;
		$html = '<div class="sspdc_widget">';
		
		foreach( $images as $image ) {
			
			if ($lightview_is_active) {
 				$box = 'class="lightview" rel="gallery[widget-'.$album_id.']"';
 				$title = $image->title . ' :: ' . $image->caption;
			} else {
 				 $box = 'rel="lightbox[widget-'. $album_id .']"';
 				 $title = $image->title;
			}
			
			if ($i < $image_count ) {
			
				$html .= '<div class="sspdc_widget_thumbnail"><a href="'. $image->fullsize->url . '" ' . $box . ' title="'.  $title . '"><img src="' . $image->widget->url . '"  alt="'  . $image->title . '" /> </a></div>';
			}
			
			else {
			
				$html .= '<div class="sspdc_widget_thumbnail"><a href="'. $image->fullsize->url . '" ' . $box . ' title="'.  $title .'"> </a></div>';
			}
			
			$i++;
		}
		
		$html .= '</div>';
		echo $html;
}

function sspdc_activate() {

	global $sspdc_db;
	/***
	*	Initialize some values like used on rdp-photo.net
	***/
	$sspdc_fmt['post_width'] = 655;
	$sspdc_fmt['post_height'] = 580;
	$sspdc_fmt['post_crop'] = 0;
	$sspdc_fmt['post_quality'] = 95;
	$sspdc_fmt['post_sharpening'] = 2;
	
	$sspdc_fmt['preview_width'] = 508;
	$sspdc_fmt['preview_height'] = 450;
	$sspdc_fmt['preview_crop'] = 0;
	$sspdc_fmt['preview_quality'] = 95;
	$sspdc_fmt['preview_sharpening'] = 2;
	
	$sspdc_fmt['matrix_width'] = 90;
	$sspdc_fmt['matrix_height'] = 90;
	$sspdc_fmt['matrix_crop'] = 1;
	$sspdc_fmt['matrix_quality'] = 75;
	$sspdc_fmt['matrix_sharpening'] = 1;
	
	$sspdc_fmt['fullsize_width'] = 950;
	$sspdc_fmt['fullsize_height'] = 700;
	$sspdc_fmt['fullsize_crop'] = 0;
	$sspdc_fmt['fullsize_quality'] = 95;
	$sspdc_fmt['fullsize_sharpening'] = 3;
	
	$sspdc_fmt['photostrip_width'] = 58;
	$sspdc_fmt['photostrip_height'] = 58;
	$sspdc_fmt['photostrip_crop'] = 1;
	$sspdc_fmt['photostrip_quality'] = 75;
	$sspdc_fmt['photostrip_sharpening'] = 1;
	
	$sspdc_fmt['widget_width'] = 54;
	$sspdc_fmt['widget_height'] = 54;
	$sspdc_fmt['widget_crop'] = 1;
	$sspdc_fmt['widget_quality'] = 75;
	$sspdc_fmt['widget_sharpening'] = 1;
	
	$sspdc_fmt['video_preview_width'] = 400;
	$sspdc_fmt['video_preview_height'] = 280;
	$sspdc_fmt['video_preview_crop'] = 0;
	$sspdc_fmt['video_preview_quality'] = 75;
	$sspdc_fmt['video_preview_sharpening'] = 1;
	
	$sspdc_fmt['video_width'] = 400;
	$sspdc_fmt['video_height'] = 280;
	
	add_option('sspdc_fmt', serialize( $sspdc_fmt ));
	update_option('sspdc_db_version', SSPDC_DB);
	
	
}

function sspdc_activate_old() {

	/***
	*	Initialize some values like used on rdp-photo.net
	***/
	
	add_option('sspdc_fmt_post_width', 655);
	add_option('sspdc_fmt_post_height', 580);
	add_option('sspdc_fmt_post_crop', 0);
	add_option('sspdc_fmt_post_quality', 95);
	add_option('sspdc_fmt_post_sharpening', 2);
	
	add_option('sspdc_fmt_preview_width', 508);
	add_option('sspdc_fmt_preview_height', 450);
	add_option('sspdc_fmt_preview_crop', 0);
	add_option('sspdc_fmt_preview_quality', 95);
	add_option('sspdc_fmt_preview_sharpening', 2);
	
	add_option('sspdc_fmt_matrix_width', 90);
	add_option('sspdc_fmt_matrix_height', 90);
	add_option('sspdc_fmt_matrix_crop', 1);
	add_option('sspdc_fmt_matrix_quality', 75);
	add_option('sspdc_fmt_matrix_sharpening', 1);
	
	add_option('sspdc_fmt_fullsize_width', 950);
	add_option('sspdc_fmt_fullsize_height', 700);
	add_option('sspdc_fmt_fullsize_crop', 0);
	add_option('sspdc_fmt_fullsize_quality', 95);
	add_option('sspdc_fmt_fullsize_sharpening', 3);
	
	add_option('sspdc_fmt_photostrip_width', 58);
	add_option('sspdc_fmt_photostrip_height', 58);
	add_option('sspdc_fmt_photostrip_crop', 1);
	add_option('sspdc_fmt_photostrip_quality', 75);
	add_option('sspdc_fmt_photostrip_sharpening', 1);
	
	add_option('sspdc_fmt_widget_width', 54);
	add_option('sspdc_fmt_widget_height', 54);
	add_option('sspdc_fmt_widget_crop', 1);
	add_option('sspdc_fmt_widget_quality', 75);
	add_option('sspdc_fmt_widget_sharpening', 1);
	
	add_option('sspdc_fmt_video_preview_width', 500);
	add_option('sspdc_fmt_video_preview_height', 400);
	add_option('sspdc_fmt_video_preview_crop', 0);
	add_option('sspdc_fmt_video_preview_quality', 75);
	add_option('sspdc_fmt_video_preview_sharpening', 1);
	
	add_option('sspdc_fmt_video_width', 500);
	add_option('sspdc_fmt_video_height', 400);
}

function sspdc_serialize() {
	
	global $sspdc_db;
	
	$test = get_option('sspdc_fmt_post_height');
	
	if (!empty ( $test ) ) {
	
	$sspdc_fmt['post_width'] = get_option('sspdc_fmt_post_width');
	$sspdc_fmt['post_height'] = get_option('sspdc_fmt_post_height');
	$sspdc_fmt['post_crop'] = get_option('sspdc_fmt_post_crop');
	$sspdc_fmt['post_quality']= get_option('sspdc_fmt_post_quality');
	$sspdc_fmt['post_sharpening'] = get_option('sspdc_fmt_post_sharpening');
	
	$sspdc_fmt['preview_width'] = get_option('sspdc_fmt_preview_width');
	$sspdc_fmt['preview_height'] = get_option('sspdc_fmt_preview_height');
	$sspdc_fmt['preview_crop'] = get_option('sspdc_fmt_preview_crop');
	$sspdc_fmt['preview_quality']= get_option('sspdc_fmt_preview_quality');
	$sspdc_fmt['preview_sharpening'] = get_option('sspdc_fmt_preview_sharpening');
	
	$sspdc_fmt['matrix_width'] = get_option('sspdc_fmt_matrix_width');
	$sspdc_fmt['matrix_height'] = get_option('sspdc_fmt_matrix_height');
	$sspdc_fmt['matrix_crop'] = get_option('sspdc_fmt_matrix_crop');
	$sspdc_fmt['matrix_quality']= get_option('sspdc_fmt_matrix_quality');
	$sspdc_fmt['matrix_sharpening'] = get_option('sspdc_fmt_matrix_sharpening');
	
	$sspdc_fmt['fullsize_width'] = get_option('sspdc_fmt_fullsize_width');
	$sspdc_fmt['fullsize_height'] = get_option('sspdc_fmt_fullsize_height');
	$sspdc_fmt['fullsize_crop'] = get_option('sspdc_fmt_fullsize_crop');
	$sspdc_fmt['fullsize_quality']= get_option('sspdc_fmt_fullsize_quality');
	$sspdc_fmt['fullsize_sharpening'] = get_option('sspdc_fmt_fullsize_sharpening');
	
	$sspdc_fmt['photostrip_width'] = get_option('sspdc_fmt_photostrip_width');
	$sspdc_fmt['photostrip_height'] = get_option('sspdc_fmt_photostrip_height');
	$sspdc_fmt['photostrip_crop'] = get_option('sspdc_fmt_photostrip_crop');
	$sspdc_fmt['photostrip_quality']= get_option('sspdc_fmt_photostrip_quality');
	$sspdc_fmt['photostrip_sharpening'] = get_option('sspdc_fmt_photostrip_sharpening');
	
	$sspdc_fmt['widget_width'] = get_option('sspdc_fmt_widget_width');
	$sspdc_fmt['widget_height'] = get_option('sspdc_fmt_widget_height');
	$sspdc_fmt['widget_crop'] = get_option('sspdc_fmt_widget_crop');
	$sspdc_fmt['widget_quality']= get_option('sspdc_fmt_widget_quality');
	$sspdc_fmt['widget_sharpening'] = get_option('sspdc_fmt_widget_sharpening');
	
	$sspdc_fmt['video_width'] = get_option('sspdc_fmt_video_width');
	$sspdc_fmt['video_height'] = get_option('sspdc_fmt_video_height');
	$sspdc_fmt['video_crop'] = get_option('sspdc_fmt_video_crop');
	$sspdc_fmt['video_quality']= get_option('sspdc_fmt_video_quality');
	$sspdc_fmt['video_sharpening'] = get_option('sspdc_fmt_video_sharpening');
	
	add_option('sspdc_fmt', serialize($sspdc_fmt));
	}
}

function sspdc_delete_options() {
	
	/***
	*	Delete pre v0.9.6 options from database
	***/
	
	delete_option('sspdc_fmt_post_width');
	delete_option('sspdc_fmt_post_height');
	delete_option('sspdc_fmt_post_crop');
	delete_option('sspdc_fmt_post_quality');
	delete_option('sspdc_fmt_post_sharpening');
	
	delete_option('sspdc_fmt_preview_width');
	delete_option('sspdc_fmt_preview_height');
	delete_option('sspdc_fmt_preview_crop');
	delete_option('sspdc_fmt_preview_quality');
	delete_option('sspdc_fmt_preview_sharpening');
	
	delete_option('sspdc_fmt_matrix_width');
	delete_option('sspdc_fmt_matrix_height');
	delete_option('sspdc_fmt_matrix_crop');
	delete_option('sspdc_fmt_matrix_quality');
	delete_option('sspdc_fmt_matrix_sharpening');
	
	delete_option('sspdc_fmt_fullsize_width');
	delete_option('sspdc_fmt_fullsize_height');
	delete_option('sspdc_fmt_fullsize_crop');
	delete_option('sspdc_fmt_fullsize_quality');
	delete_option('sspdc_fmt_fullsize_sharpening');
	
	delete_option('sspdc_fmt_photostrip_width');
	delete_option('sspdc_fmt_photostrip_height');
	delete_option('sspdc_fmt_photostrip_crop');
	delete_option('sspdc_fmt_photostrip_quality');
	delete_option('sspdc_fmt_photostrip_sharpening');
	
	delete_option('sspdc_fmt_widget_width');
	delete_option('sspdc_fmt_widget_height');
	delete_option('sspdc_fmt_widget_crop');
	delete_option('sspdc_fmt_widget_quality');
	delete_option('sspdc_fmt_widget_sharpening');
	
	delete_option('sspdc_fmt_video_preview_width');
	delete_option('sspdc_fmt_video_preview_height');
	delete_option('sspdc_fmt_video_preview_crop');
	delete_option('sspdc_fmt_video_preview_quality');
	delete_option('sspdc_fmt_video_preview_sharpening');
	
	delete_option('sspdc_fmt_video_width');
	delete_option('sspdc_fmt_video_height');
}
?>
