<?php
function celta_add_shortcodes_interface() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_buttons', 'celta_filter_mce_button' );
		add_filter( 'mce_external_plugins', 'celta_filter_mce_plugin' );
	}
}
	
function celta_filter_mce_button( $buttons ) {
	array_push( $buttons, '|', 'shortcodes_button_button', 'shortcodes_column', 'shortcodes_social_button', 'shortcodes_twitter', 'shortcodes_toggle_button', 'shortcodes_featured_button',
				'shortcodes_slider_button', 'shortcodes_cycle_button' );
	return $buttons;
}

function celta_filter_mce_plugin( $plugins ) {
	$plugins['shortcodes_button'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_button.js';
	$plugins['shortcodes_column'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_column.js';
	$plugins['shortcodes_social'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_social.js';
	$plugins['shortcodes_twitter'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_twitter.js';
	$plugins['shortcodes_toggle'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_toggle.js';
	$plugins['shortcodes_slider'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_slider.js';
	$plugins['shortcodes_cycle'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_cycle.js';
	$plugins['shortcodes_featured'] = get_template_directory_uri() . '/lib/js/shortcodes-interface/shortcodes_featured.js';
	return $plugins;
}

function my_formatTinyMCE( $init ) {
   $init['theme_advanced_buttons2_add'] = 'styleselect';
   $init['theme_advanced_styles'] = 'Check List=custom-list check;Exclamation List=custom-list exclamation;Arrows List=custom-list arrows;Square List=custom-list square;Disc List=custom-list disc;Custom List=custom-list';
   return $init;
}
 
add_filter( 'tiny_mce_before_init', 'my_formatTinyMCE' );
?>