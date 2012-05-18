<?php

//add theme options
require_once ( TEMPLATEPATH . '/includes/theme-options.php' );

if ( function_exists('register_sidebar') )
    register_sidebar();

// Add Post Thumbnail Theme Support
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured', 401, 301, true );
}

$includes_path = TEMPLATEPATH . '/includes/';

// load javascripts
require_once ($includes_path . 'theme-js.php');

// Load Post Images
require_once ($includes_path . 'images.php');

// Add Menu Theme Support
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'nav-menus' );
	add_action( 'init', 'register_gpp_menus' );

	function register_gpp_menus() {
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu' )
			)
		);
	}
}


//get thumbnail
function postimage($size=medium) {
	if ( $images = get_children(array(
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'numberposts' => 1,
		'order' => 'ASC',
		'post_mime_type' => 'image',)))
	{
		foreach( $images as $image ) {
			$attachmentimage=wp_get_attachment_image( $image->ID, $size );
			echo $attachmentimage.apply_filters('the_title', $parent->post_title);
		}
	} 
}

//get thumbnails
function postimages($size=medium) {
	if ( $images = get_children(array(
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'post_mime_type' => 'image')))
	{
		foreach( $images as $image ) {
			$attachmenturl=wp_get_attachment_url($image->ID);
			
			if($size=='featured') {
				$attachmentimage=wp_get_attachment_image( $image->ID, array(401, 301) );
			} else {
				$attachmentimage=wp_get_attachment_image( $image->ID, $size );
			}
			
			
			$imagelink=get_permalink($image->post_parent);

			echo '<div class="box"><a href="'.$imagelink.'">'.$attachmentimage.apply_filters('the_title', $parent->post_title).'</a></div>';
		}
	} 
}


//check any attachment 
function checkimage($size=medium) {
	if ( $images = get_children(array(
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_mime_type' => 'image',)))
	{
		foreach( $images as $image ) {
			$attachmentimage=wp_get_attachment_image( $image->ID, $size );
			return $attachmentimage;
		}
	} 
}

function trim_excerpt($text) {
  return rtrim($text,'[...]');
}
add_filter('get_the_excerpt', 'trim_excerpt');
function new_excerpt_length($length) {
	return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

?>