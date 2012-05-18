<?php
	/** Tell WordPress to run cudazi_setup() when the 'after_setup_theme' hook is run. */
	add_action( 'after_setup_theme', 'cudazi_setup' );
	function cudazi_setup() {

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		add_custom_background();
		
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'cudazi', TEMPLATEPATH . '/languages' );
	
		$locale = get_locale();
		$locale_file = TEMPLATEPATH . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
	
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'footer-left' => __( 'Footer Left', 'cudazi' ),
			'footer-right' => __( 'Footer Right', 'cudazi' )
		) );
		
	}
?>