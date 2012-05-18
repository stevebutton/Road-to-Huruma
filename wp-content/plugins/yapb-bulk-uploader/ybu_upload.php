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

//set logging on. Comment this line to skip any logging
$ybu_logFile = dirname(__FILE__)."/log.txt";

function ybu_log($message)
{
	global $ybu_logFile;
	
	if(!empty($ybu_logFile))
	{
		$date = date("Y-m-d H:i:s");
		@file_put_contents($ybu_logFile, "$date : $message\n", FILE_APPEND);
	}	
}

function ybu_die($message)
{
	ybu_log("Exiting with Err: $message");
	//header("HTTP/1.1 $code $message");
	die("Err: $message");
}

//require wp stuff
$wpdir = realpath(dirname(__FILE__) . '/../../../');
require_once(realpath($wpdir . '/wp-load.php'));
require_once(realpath($wpdir . '/wp-admin/includes/admin.php'));

ybu_log('***************************************************');
ybu_log("YAPB loaded in ".YAPB_PLUGINDIR_NAME);
ybu_log("WP loaded from $wpdir");

//check if post at all
if(empty($_POST))
{
	$maxPostSize = wp_convert_bytes_to_hr(wp_convert_hr_to_bytes(ini_get( 'post_max_size' )));	
	ybu_die("No POST content found. Please check your max_post_size ($maxPostSize) directive in php.ini");
}

// Flash often fails to send cookies with the POST or upload, so we need to pass it in GET or POST instead
if ( is_ssl() && empty($_COOKIE[SECURE_AUTH_COOKIE]) && !empty($_REQUEST['auth_cookie']) )
	$_COOKIE[SECURE_AUTH_COOKIE] = $_REQUEST['auth_cookie'];
elseif ( empty($_COOKIE[AUTH_COOKIE]) && !empty($_REQUEST['auth_cookie']) )
	$_COOKIE[AUTH_COOKIE] = $_REQUEST['auth_cookie'];
unset($current_user);

ybu_log("Going for signon using cookie ".$_COOKIE[AUTH_COOKIE]);

//perform actual sign on using cookie
$user = wp_authenticate_cookie('', '', '');

if(is_wp_error($user))
	ybu_die("You need to be signed-on in order to upload images");
	
if (!current_user_can('edit_posts'))
	ybu_die("You are not allowed to create posts on this blog");
	
ybu_log("login as: \n".$user->display_name);

//set default post values
$defaults = array("post_type" =>  "post",
			    "post_status" =>  "publish",
	   			"post_category" => (get_option("yapb_default_post_category_activate") ? get_option("yapb_default_post_category") : get_option('default_category')),
		 	   	"user_ID" =>  $user->ID,
	   			"comment_status" =>  get_option('default_comment_status'),
	   			"ping_status" =>  get_option('default_ping_status'),
	   			"action" =>  "YBUPost", //needed for wp_handle_upload
				"exifdate" => 0, //will be set to 1 if checkbox ticked.
				"ybu_iptc" => 0); //will be set to 1 if checkbox ticked.



//merge defaults with post array
$_POST = wp_parse_args($_POST, $defaults);

//update iptc box to last set value
update_option("ybu_iptc_checked", $_POST['ybu_iptc']);

//fix some post values.
//1. remove exifdate if not set (YAPB checks for existance, not for value)
if($_POST['exifdate']==0) 
	unset($_POST['exifdate']);
	
//2. transform post_category into array (split by ,)
if(!empty($_POST['post_category']) && !is_array($_POST['post_category']))
	$_POST['post_category'] = explode(",",$_POST['post_category']);

//3. make sure post is executed as currently logged-in user
$_POST["post_author"] = $user->ID;

ybu_log("Post info: " . print_r($_POST, true));
ybu_log("Upload info: " . print_r($_FILES, true));

//check for upload errors before actually inserting the post
if(!empty($_FILES['yapb_imageupload']['error']))
{
	switch ($_FILES['yapb_imageupload']['error']) 
	{ 
			case UPLOAD_ERR_INI_SIZE: 
 				$maxSize = wp_convert_bytes_to_hr(wp_convert_hr_to_bytes(ini_get( 'upload_max_filesize' )));
 				//$fileSize = wp_convert_bytes_to_hr($_POST['filesize']);
				ybu_die("The size of the upload exceeds the upload_max_size ($maxSize) directive in php.ini.");
	        case UPLOAD_ERR_FORM_SIZE: 
	            ybu_die('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified.'); 
	        case UPLOAD_ERR_PARTIAL: 
	            ybu_die( 'The uploaded file was only partially uploaded'); 
	        case UPLOAD_ERR_NO_FILE: 
	            ybu_die( 'No file was uploaded'); 
	        case UPLOAD_ERR_NO_TMP_DIR: 
	            ybu_die( 'Server configuration error: Missing a temporary folder'); 
	        case UPLOAD_ERR_CANT_WRITE: 
	            ybu_die( 'Server error: Failed to write file to disk'); 
	        case UPLOAD_ERR_EXTENSION: 
	            ybu_die( 'File upload stopped by extension'); 
	        default: 
	            ybu_die( 'Unknown upload error'); 
	} 
}

//change publish state to pending if the user is not allowed to publish
if ($_POST['post_status']=='publish' && !current_user_can('publish_posts'))
{
	$_POST['post_status'] = 'pending';
	ybu_log("Changed publish status to pending, because user has no publish rights");
}

//reuse form post of WP. This will kick-off YAPB as well
$postid = wp_insert_post($_POST);

ybu_log("insert post result: ".print_r($postid, true));

//check post
if(empty($postid) || $postid==0 || is_wp_error($postid))
	ybu_die("Could not create post");
	
//check image	
$image = YapbImage::getInstanceFromDb($postid);
if(empty($image))
	ybu_die("Image not found in post");
	
//add iptc info if necessart
if($_POST['ybu_iptc']==1)
{	
	ybu_log("image path: ".$image->systemFilePath());
	
	getimagesize($image->systemFilePath(), $data);
	if(isset($data['APP13']))
	{
		$iptc = iptcparse($data['APP13']);
		if($iptc)
		{
			$updates = array('ID' => $image->post_id);
				
			//get keywords
			if($iptc['2#025'])
				$updates['tags_input'] = implode(", ",$iptc['2#025']);

			//get title	
			if($iptc["2#005"][0]) //title
			{
				$updates['post_title'] = $iptc["2#005"][0]; //set post title
				$updates['post_name'] = $iptc["2#005"][0]; //set post slug
			}
			else if($iptc["2#105"][0]) //headline
			{
				$updates['post_title'] = $iptc["2#105"][0]; //post title
				$updates['post_name'] = $iptc["2#105"][0]; //post slug
			}
			
			//get description
			if($iptc["2#120"][0])
				$updates['post_content'] = $iptc["2#120"][0];
				
			ybu_log("iptc update: ".print_r($updates, true));
				
			wp_update_post(add_magic_quotes($updates));
		}
	}
}

//add some info on the output(necessary for Mac's)
ybu_log("Success!");
echo "Success!";

//kill log file (if any)
if(!empty($ybu_logFile)) @unlink($ybu_logFile);