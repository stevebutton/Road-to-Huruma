<?php
	global $custom_settings;
	
	// Save a trip to the database, store in our custom settings array
	$custom_settings["page_for_posts"] =  get_option('page_for_posts');
	$custom_settings["show_on_front"] =  get_option('show_on_front');
	$custom_settings["page_on_front"] =  get_option('page_on_front');
	
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />

<?php 
	$the_page_title = wp_title( '', false, 'right' );
	if(!$the_page_title){
		$the_page_title = get_bloginfo("name");
	}else{
		$the_page_title = $the_page_title . " - " . get_bloginfo("name");
	}
	$the_page_title .= " - ". get_bloginfo("description");
?>
<title><?php echo $the_page_title; ?></title>
    
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<!-- Load CSS -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/screen.css" media="screen" />
    <?php if(!$custom_settings["theme"]){ $custom_settings["theme"] = 'default'; } ?>
	<link rel="stylesheet" id="themeCSS" type="text/css" href="<?php bloginfo('template_url'); ?>/css/colors-<?php echo $custom_settings["theme"]; ?>.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/960.css" media="screen" />
	<!-- //CSS -->

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" type="image/gif" href="<?php bloginfo('template_url'); ?>/images/favicon.gif" />
	<!--[if lt IE 7]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
	<![endif]-->
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )	{ wp_enqueue_script( 'comment-reply' ); }
	wp_enqueue_script("jquery");
	wp_enqueue_script("cudazi_jcarousellite", get_bloginfo('template_url') . "/js/jcarousellite_1.0.1.min.js");
	wp_enqueue_script("cudazi_general", get_bloginfo('template_url') . "/js/general.js");
	
	// Load Additional CSS Last
	if($custom_settings["css"]["extra"])
	{
		echo "<style type='text/css'>";
			include_once(TEMPLATEPATH . "/css/dynamic-css.php");
		echo "</style>";
	}
	
	wp_head(); // do not remove this!
?>
</head>
<body <?php body_class(); ?>>
	<div id="outer">


		<div id="header" class="clearfix shadow">
            <div class="container_12">
                <div class="grid_4" id="logo">
                	<?php cudazi_get_logo(); // in functions.php ?>
                </div><!--//logo-->
                <div class="grid_8 menu-container">
                    <ul class="main-menu rounded shadow clearfix"><?php
                        $arr_pages_menu = get_pages(
                            array(
                                'sort_column' => 'menu_order',
                                'sort_order' => 'ASC',
                                'exclude' => array(
                                    $custom_settings["page_on_front"]
                                )
                            )
                        );
                        // Loop through the pages
                        foreach ($arr_pages_menu as $the_page) { 
                        
                            // If the current page ID is the same as the page you set for posts
                            // Then - Use actual URL since there is nothing to scroll to
                            if($the_page->ID == $custom_settings["page_for_posts"])
                            {
                                // Only show the posts page link (blog) if not disabled in theme settings
                                if(!$custom_settings["disable_blog_link_menu"])
                                {
                                    // Get actual URL
                                    if(is_home()){ $addclass="class='active'"; }else{ $addclass=""; } // manually add .active class to blog page
                                    echo "<li><a ".$addclass." href='".get_permalink($the_page->ID) . "'>" . $the_page->post_title . "</a></li>";
                                }
                            }else{
                                // Create #go-slug URL to scroll to
                                echo "<li><a href='".home_url( '/' )."#go-" . $the_page->post_name . "'>" . $the_page->post_title . "</a></li>";
                            }
                            
                        } // end foreach
                        ?>
                    </ul>
                </div><!--//main-menu-->
            </div><!--//container_12-->
    	</div><!--//header-->