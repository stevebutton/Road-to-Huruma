<?php
// Set path to theme specific functions
define( 'CELTA_LIB', TEMPLATEPATH . '/lib/' );
$theme_path = get_bloginfo( 'template_directory' );

// Set variables with theme names
$themename = 'Temptation';  
$shortname = 'celta';  
$prefix = 'celta_';
define ( 'LANGUAGE', 'manifest' );

// Add Theme Options Panel Functions
require_once ( CELTA_LIB . 'theme-options.php' );	

// Set Theme Setup
add_action( 'after_setup_theme', 'celta_theme_setup' );

function celta_theme_setup() {
	// Set path to theme specific functions
	global $theme_path;
	
	if ( ! isset( $content_width ) ) $content_width = 610;
	
	add_theme_support( 'automatic-feed-links' );
	
	// Load Theme Scripts
	require_once ( CELTA_LIB . 'theme-scripts.php' );	
	
	// Apply Translation
	load_theme_textdomain( LANGUAGE, TEMPLATEPATH . '/languages' );
	
	// Add Theme Thumbnails
	require_once ( CELTA_LIB . 'theme-thumbnails.php' );	
	
	// Add Custom Post Types
	add_action( 'init', 'celta_post_types' );
	
	// Add Meta Boxes Actions
	add_action( 'admin_menu', 'celta_page_add_box' );
	add_action( 'save_post', 'celta_page_save_data' );
	add_action( 'admin_menu', 'celta_portfolio_add_box' );
	add_action( 'save_post', 'celta_portfolio_save_data' );
	
	// Add Shortcodes Interface Action
	add_action( 'admin_init', 'celta_add_shortcodes_interface' );
	
	// Add CSS3 Support in IE Action
	add_action( 'wp_head', 'celta_render_ie' );
	
	// Add Custom Widgets Action
	add_action( 'widgets_init', 'celta_load_widgets' );
	
}

// Add Custom Comments Function
require_once ( CELTA_LIB . 'theme-comments.php' );	

// Add Custom Post Types Function
require_once ( CELTA_LIB . 'theme-post-types.php' );

// Add Custom Meta Boxes Functions
require_once ( CELTA_LIB . 'theme-page-meta-boxes.php' );
require_once ( CELTA_LIB . 'theme-portfolio-meta-boxes.php' );

// Add Shortcodes Interface Functions
require_once ( CELTA_LIB . 'theme-shortcodes-interface.php' );

// Add CSS3 Support in IE Function
require_once ( CELTA_LIB . 'theme-iefixes.php' );

// Add Theme Shortcodes
require_once ( CELTA_LIB . 'theme-shortcodes.php' );

// Add Custom Widgets Function
require_once ( CELTA_LIB . 'theme-widgets.php' );

// Add Images Resize Function
require_once ( CELTA_LIB . 'theme-thumbnails-resize.php' );

// Fixes Shortcodes empty paragraphs
add_filter('the_content', 'shortcode_empty_paragraph_fix');

function create_feedtimeline() {
  load_template( TEMPLATEPATH . '/feedtimeline.php'); // You'll create a your-custom-feed.php file in your theme's directory
}
add_action('do_feed_timeline', 'create_feedtimeline', 10, 1);

function create_georss() {
  load_template( TEMPLATEPATH . '/feedgeorss.php');
}
add_action('do_feed_georss', 'create_georss', 10, 1);


function shortcode_empty_paragraph_fix($content) {   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}
?>