<?php

	// Registers the Portfolio custom post type
	function cudazi_register_post_types() {
    	$labels = array(
			'name' => __('Portfolio'),
			'singular_label' => __('Portfolio'),
			'add_new_item' => __('Add Portfolio Item'),
			'description' => __('Large portfolio items with slider.'),
			'edit_item' => __('Edit Portfolio Item'),
			'new_item' => __('New Portfolio Item'),
			'view_item' => __('View Portfolio Item')
		);
		$args = array(
        	'labels' => $labels,
			'exclude_from_search' => false,
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'menu_position' => 20,
			'hierarchical' => false,
			'supports' => array('title', 'editor', 'page-attributes')
        );
    	register_post_type( 'portfolio' , $args );
	}
	add_action('init', 'cudazi_register_post_types');


	
	
	add_action("admin_init", "admin_init_additional_boxes");
	add_action('save_post', 'meta_additional_save_portfolio');

	// Portfolio Meta Box
	function admin_init_additional_boxes(){
		add_meta_box("additional-options", __('Additional Options','cudazi'), "meta_additional_options_portfolio", "portfolio", "normal", "high");
	}

	// Portfolio Meta Box Additional Options
	function meta_additional_options_portfolio(){
		global $post;
		$custom = get_post_custom($post->ID);
		$custom_subheading = $custom["custom_subheading"][0];
		echo "<div class='inside'>";
		echo "<p><label>". __('Add optional sub heading','cudazi') . "</label><br /><input type='text' style='width:99%;' value='".$custom_subheading."' class='code' name='custom_subheading'></p>";
		echo "</div>";
	}

	// Portfolio Meta Box Save
	function meta_additional_save_portfolio(){
		global $post;
		update_post_meta($post->ID, "custom_subheading", $_POST["custom_subheading"]);
	}
	
	
?>