<?php
/*============================================================ Layout Columns Shortcodes ============================================================*/
function celta_columns_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"size" => 'full-width',
		"last" => 'false'
	), $atts));
	
	$clear = '';
	
	if ( $last == 'true' ) {
		$last = ' last';
		$clear = '<div class="clear"></div>';
	} else {
		$last = '';
	}
	
	return '<div class="' . $size . $last . '">' . do_shortcode( $content ) . '</div>' . $clear;
	
}

add_shortcode( 'column', 'celta_columns_shortcode' );

/*============================================================ Social Profiles Shortcodes ============================================================*/
function celta_social_shortcode( $atts, $content = null ) {
	require( CELTA_LIB . "theme-options-vars.php" );
	$output = '<div class="social-networks"><ul class="social-links">';
	
	if ( $celta_blogger != '' )
		$output .= '<li class="blogger"><a href="' . $celta_blogger . '" title="Blogger">Blogger</a></li>';
	if ( $celta_delicious != '' )
		$output .= '<li class="delicious"><a href="' . $celta_delicious . '" title="Delicious">Delicious</a></li>';
	if ( $celta_deviantart != '' )
		$output .= '<li class="deviant"><a href="' . $celta_deviantart . '" title="DeviantArt">Deviant Art</a></li>';
	if ( $celta_digg != '' )
		$output .= '<li class="digg"><a href="' . $celta_digg . '" title="Digg">Digg</a></li>';
	if ( $celta_facebook != '' )
		$output .= '<li class="facebook"><a href="' . $celta_facebook . '" title="Facebook">Facebook</a></li>';
	if ( $celta_flickr != '' )
		$output .= '<li class="flickr"><a href="' . $celta_flickr . '" title="Flickr">Flickr</a></li>';
	if ( $celta_forrst != '' )
		$output .= '<li class="forrst"><a href="' . $celta_delicious . '" title="Delicious">Delicious</a></li>';
	if ( $celta_lastfm != '' )
		$output .= '<li class="lastfm"><a href="' . $celta_lastfm . '" title="LastFM">Last FM</a></li>';
	if ( $celta_linkedin != '' )
		$output .= '<li class="linkedin"><a href="' . $celta_linkedin . '" title="Linkedin">Linkedin</a></li>';
	if ( $celta_myspace != '' )
		$output .= '<li class="myspace"><a href="' . $celta_myspace . '" title="MySpace">My Space</a></li>';
	if ( $celta_reddit != '' )
		$output .= '<li class="reddit"><a href="' . $celta_delicious . '" title="Delicious">Delicious</a></li>';
	if ( $celta_tumblr != '' )
		$output .= '<li class="tumblr"><a href="' . $celta_tumblr . '" title="Tumblr">Tumblr</a></li>';
	if ( $celta_twitter != '' )
		$output .= '<li class="twitter"><a href="' . $celta_twitter . '" title="Twitter">Twitter</a></li>';
	if ( $celta_vimeo != '' )
		$output .= '<li class="vimeo"><a href="' . $celta_vimeo . '" title="Vimeo">Vimeo</a></li>';
	
	$output .= '</ul></div>';
	
	return $output;
	
}

add_shortcode( 'socialProfiles', 'celta_social_shortcode' );

/*============================================================ Twitter Shortcodes ============================================================*/
function celta_twitter_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"user" => '',
		"count" => 2
	), $atts));
	
	$output = '<script>';
	
	$output .= 'jQuery(document).ready(function() {
					jQuery("#twitter-feed").tweet({
						username: "' . $user . '",
						join_text: false,
						avatar_size: null,
						count: ' . $count . ',
						auto_join_text_default: "",
						loading_text: "loading latest tweets..."
					});
				});';
				
	$output .= '</script>';
	
	return $output . '<div id="twitter-feed"></div>';
	
}

add_shortcode( 'twitter', 'celta_twitter_shortcode' );

/*============================================================ Images Slider Shortcodes ============================================================*/
function celta_cycle_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"category" => ''
	), $atts));
	
	$output = '<div class="featured cycle"><ul id="slider-cycle">';
	
	if ( $category != '' ) {
		$loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1, 'tax_query' => array( array( 'taxonomy' => 'slide_category', 'field' => 'slug', 'terms' => $category ) ) ) );
	} else {
		$loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1 ) );
	}
	
	while ( $loop->have_posts() ) : $loop->the_post(); 
		
		$output .= '<li>';
			$thumb = get_post_thumbnail_id(); 
			$image = celta_resize( $thumb, '', 610, 263, true ); 
			$output .= '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" alt="" />';
			$output .= '<div class="caption">';
				$output .= '<h3>' . get_the_title() . '</h3>';
				$output .= '<p>' . get_the_content() . '</p>';
			$output .= '</div>';
		$output .= '</li>';
		
	endwhile;
	
	$output .= '</ul>';
	
	$output .= '<ul id="slider-cycle-nav">
					<li><a id="cycle-prev"></a></li>
					<li><a id="cycle-next"></a></li>
				</ul>';
				
	$output .= '</div>';
	
	return $output;
	
}

add_shortcode( 'imagesSlider', 'celta_cycle_shortcode' );

/*============================================================ Content Slider Shortcodes ============================================================*/
function celta_slider_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"category" => ''
	), $atts));
	
	$output = '<div class="featured"><div id="slider"><ul>';
	
	if ( $category != '' ) {
		$loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1, 'tax_query' => array( array( 'taxonomy' => 'slide_category', 'field' => 'slug', 'terms' => $category ) ) ) );
	} else {
		$loop = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => -1 ) );
	}
	
	while ( $loop->have_posts() ) : $loop->the_post(); 
		
		$output .= '<li>';
			$thumb = get_post_thumbnail_id(); 
			$image = celta_resize( $thumb, '', 610, 263, true ); 
			$output .= '<div class="slide-img"><img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" alt="" /></div>';
			$output .= '<div class="slide-text">';
				$output .= do_shortcode( get_the_content() );
			$output .= '</div>';
		$output .= '</li>';
		
	endwhile;
	
	$output .= '</ul>';
				
	$output .= '</div></div>';
	
	return $output;
	
}

add_shortcode( 'contentSlider', 'celta_slider_shortcode' );

/*============================================================ Featured Paragraph Shortcodes ============================================================*/
function celta_featured_shortcode( $atts, $content = null ) {

	return '<p class="slogan">' . do_shortcode( $content ) . '</p>';

}

add_shortcode( 'featured', 'celta_featured_shortcode' );

/*============================================================ Divider Shortcodes ============================================================*/
function celta_divider_shortcode( $atts, $content = null ) {

	return '<div class="separator-line"></div>';

}

add_shortcode( 'divider', 'celta_divider_shortcode' );


/*============================================================ Toggle Shortcodes ============================================================*/
function celta_toggle_shortcode( $atts, $content = null ) {

	return '<div class="toggle-container full-width">' . do_shortcode( $content ) . '</div>';

}

add_shortcode( 'toggle', 'celta_toggle_shortcode' );

function celta_toggle_title_shortcode( $atts, $content = null ) {

	return '<div class="toggle-header"><h4>' . $content . '</h4><a class="toggle-link toggle-open" href="#"></a><div class="clear"></div></div>';

}

add_shortcode( 'toggleTitle', 'celta_toggle_title_shortcode' );

function celta_toggle_box_shortcode( $atts, $content = null ) {

	return '<div class="toggle-content">' . do_shortcode( $content ) . '</div>';

}

add_shortcode( 'toggleBox', 'celta_toggle_box_shortcode' );

/*============================================================ Button Shortcodes ============================================================*/
function celta_button_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		"link" => ''
	), $atts));

	return '<a class="button" href="' . $link . '">' . do_shortcode( $content ) . '</a>';

}

add_shortcode( 'button', 'celta_button_shortcode' );

// Add Shortcodes to Widgets
add_filter('widget_text', 'do_shortcode');
?>