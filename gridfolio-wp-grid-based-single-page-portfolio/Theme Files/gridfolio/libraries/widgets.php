<?php
	/*
		Setup and init widget areas.
	*/
	function cudazi_widgets_init() {
		
		register_sidebar( array(
			'name' => __( 'Default Sidebar', 'cudazi' ),
			'id' => 'blog',
			'description' => __( 'Appears in any template with a sidebar.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Archive', 'cudazi' ),
			'id' => 'archive',
			'description' => __( 'Appears in the archive.php template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Search Results', 'cudazi' ),
			'id' => 'search',
			'description' => __( 'Appears in the search.php search results template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		) );
		
		
		
		register_sidebar( array(
			'name' => __( 'Single Post', 'cudazi' ),
			'id' => 'single-post',
			'description' => __( 'Appears in the single.php single post display template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		) );
		
		
		
		
		register_sidebar( array(
			'name' => __( 'Home Column A', 'cudazi' ),
			'id' => 'home-column-a',
			'description' => __( 'Home column A - Appears when you set a page up using the home page template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget centered %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Home Column B', 'cudazi' ),
			'id' => 'home-column-b',
			'description' => __( 'Home column B - Appears when you set a page up using the home page template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget centered %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Home Column C', 'cudazi' ),
			'id' => 'home-column-c',
			'description' => __( 'Home column C - Appears when you set a page up using the home page template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget centered %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Home Column D', 'cudazi' ),
			'id' => 'home-column-d',
			'description' => __( 'Home column D - Appears when you set a page up using the home page template.', 'cudazi' ),
			'before_widget' => '<div id="%1$s" class="widget centered %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		) );
	}
	
	
	
	/** Register sidebars by running cudazi_widgets_init() on the widgets_init hook. */
	add_action( 'widgets_init', 'cudazi_widgets_init' );
?>