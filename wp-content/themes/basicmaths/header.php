<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { bloginfo('name'); print ' | '; single_post_title(); }       
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); }
        elseif ( is_page() ) { bloginfo('name'); print ' | '; single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); print ' Archive';}
    ?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/img/favicon.ico" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen,projection" />

	<?php wp_head(); ?>

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'basicmaths' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'basicmaths' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE8.js" type="text/javascript"></script>
<![endif]-->

</head>
 
<body <?php body_class(); ?>>

<div id="wrapper">

	<div id="header">
	
		<h1><a href="<?php echo get_option('home'); ?>/"><span><?php bloginfo('name'); ?></span></a></h1>
		<span class="description"><?php bloginfo('description'); ?></span>
					
	</div>
	
	<div id="skip">
		<a href="#content" title="<?php _e('Skip navigation to the content', 'basicmaths'); ?>"><span><?php _e('Skip to content', 'basicmaths'); ?></span></a>
	</div>

	<div id="access">
	
		<ul id="nav">
			<li class="page_item page-item-home <?php if ( is_home() || is_front_page() ) { echo 'current_page_item'; } ?>"><a href="<?php bloginfo('home'); ?>" title="Home"><?php _e('Home', 'basicmaths') ?></a></li>
			<?php wp_list_pages('sort_column=menu_order&title_li=&depth=2'); ?>
			<li id="nav-search">
				<label for="nav-s"><?php _e( 'Search', 'basicmaths' ) ?></label>
				<form id="nav-searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="nav-s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="30" tabindex="1" />
						<input type="submit" class="button" value="<?php _e( 'Go', 'basicmaths' ) ?>" tabindex="2" />
					</div>
				</form>
			</li>
		</ul>

	</div>

