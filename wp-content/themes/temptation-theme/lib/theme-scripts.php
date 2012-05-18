<?php
if ( ! is_admin() ) {

	// Include jQuery
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	
	// Include Twitter Feed script
	wp_register_script( 'celta_feed', $theme_path . '/scripts/jquery.tweet.js', false, '1.0' );
	wp_enqueue_script( 'celta_feed' );
	
	// Include Easing script
	wp_register_script( 'celta_easing', $theme_path . '/scripts/easing.js', false, '1.0' );
	wp_enqueue_script( 'celta_easing' );
	
	// Include Anything Slider script
	wp_register_script( 'celta_anything', $theme_path . '/scripts/jquery.anythingslider.min.js', false, '1.0' );
	wp_enqueue_script( 'celta_anything' );
	
	// Include Cycle Slider script
	wp_register_script( 'celta_cycle', $theme_path . '/scripts/jquery.cycle.all.js', false, '1.0' );
	wp_enqueue_script( 'celta_cycle' );
	
	// Include prettyPhoto
	wp_register_script( 'celta_prettyPhoto', $theme_path . '/scripts/prettyphoto/js/jquery.prettyPhoto.js', false, '1.0' );
	wp_enqueue_script( 'celta_prettyPhoto' );
	
	// Include Tools script
	wp_register_script( 'celta_tools', $theme_path . '/scripts/jquery.tools.min.js', false, '1.0' );
	wp_enqueue_script( 'celta_tools' );
	
	// Include Scroll TO script
	wp_register_script( 'celta_scrollto', $theme_path . '/scripts/jquery.scrollTo-1.4.2-min.js', false, '1.0' );
	wp_enqueue_script( 'celta_scrollto' );
	
	// Include Local Scroll script
	wp_register_script( 'celta_localscroll', $theme_path . '/scripts/jquery.localscroll-1.2.7-min.js', false, '1.0' );
	wp_enqueue_script( 'celta_localscroll' );
	
	// Include Custom JS script
	wp_register_script( 'celta_custom_js', $theme_path . '/scripts/custom.js', false, '1.0' );
	wp_enqueue_script( 'celta_custom_js' );

}
?>