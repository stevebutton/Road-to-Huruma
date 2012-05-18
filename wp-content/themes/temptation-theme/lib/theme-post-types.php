<?php
function celta_post_types() {
	register_post_type( 'portfolio_item',
		array(
			'labels' => array(
				'name' => __( 'Portfolio Items' ),
				'singular_name' => __( 'Portfolio Item' ),
				'add_new' => __( 'Add New Portfolio Item' ),
				'add_new_item' => __( 'Add New Portfolio Item' ),
				'edit' => __( 'Edit Portfolio Item' ),
				'edit_item' => __( 'Edit Portfolio Item' ),
			),
			'description' => __( 'Portfolio Items.' ),
			'public' => true,
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
			'rewrite' => array( 'slug' => 'item', 'with_front' => false ),
			'has_archive' => true
		)
	);
	register_taxonomy( 'portfolio_category', array( 'portfolio_item' ), array( 'label' => "Categories", "singular_label" => "Category" ) );
	register_post_type( 'slide',
		array(
			'labels' => array(
				'name' => __( 'Slider Items' ),
				'singular_name' => __( 'Slide' ),
				'add_new' => __( 'Add New Slide' ),
				'add_new_item' => __( 'Add New Slide' ),
				'edit' => __( 'Edit Slide' ),
				'edit_item' => __( 'Edit Slide' ),
			),
			'description' => __( 'Slider Items.' ),
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		)
	);
	register_taxonomy( 'slide_category', array( 'slide' ), array( 'label' => "Categories", "singular_label" => "Category" ) );
}
?>