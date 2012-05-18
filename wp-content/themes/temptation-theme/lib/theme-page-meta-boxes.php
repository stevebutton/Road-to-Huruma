<?php
$page_meta_box = array(
	'id' => 'page-meta-box',
	'title' => 'Extra Page Settings',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Page Title',
			'desc' => 'In this field you can define a more descriptive title of the page. If you leave it blank, then the default name of the page will be displayed.',
			'id'   => $prefix . 'page_title',
			'type' => 'text',
			'std'  => ''
		),
		array(
			'name' => 'Page Subtitle',
			'desc' => 'Enter the subtitle of the page. It will be displayed next to the page title.',
			'id'   => $prefix . 'page_subtitle',
			'type' => 'text',
			'std'  => ''
		),
		array(
			'name' => 'Page Type',
			'desc' => 'Select the type of page that you are creating.',
			'id'   => $prefix . 'page_type',
			'type' => 'select',
			'options' => array( 'Regular Page', 'Portfolio Page', 'Blog Page' )
		),
		array(
			'name' => 'Portfolio Page Categories',
			'desc' => 'In case you want to show only 1 category of portfolio items, select it in this field.',
			'id'   => $prefix . 'portfolio_category',
			'type' => 'category'
		)
	)
);

function celta_page_add_box() {
	global $page_meta_box;
	add_meta_box($page_meta_box['id'], $page_meta_box['title'], 'celta_page_show_box', $page_meta_box['page'], $page_meta_box['context'], $page_meta_box['priority']);
}

function celta_page_show_box() {
	global $page_meta_box, $post;
	echo '<input type="hidden" name="celta_page_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
		foreach ($page_meta_box['fields'] as $field) {
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>',
					'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
					'<td>';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:65%" />',
						'<br />', $field['desc'];
					break;
				case 'upload':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:65%" /><input class="optionsUploadButton" type="button" value="Upload Image" />',
						'<br />', $field['desc'];
					break;
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
						'<br />', $field['desc'];
					break;
				case 'select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $option) {
						echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
					echo '</select>';
					echo '<br />', $field['desc'];
					break;
				case 'category':
					$taxonomies = get_terms( 'portfolio_category' );
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					echo '<option>All</option>';
						foreach ( $taxonomies  as $taxonomy ) {
							echo '<option value="'.$taxonomy->slug.'"', $meta == $taxonomy->slug ? ' selected="selected"' : '', '>'. $taxonomy->name. '</option>';
						}
					echo '</select>';
					echo '<br />', $field['desc'];
					break;
				case 'radio':
					foreach ($field['options'] as $option) {
						echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
					}
					break;
				case 'checkbox':
					echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
					break;
			}
			echo '<td>';
			echo '</tr>';
		}
	echo '</table>';
}

function celta_page_save_data($post_id) {
	global $page_meta_box;
	if (!wp_verify_nonce($_POST['celta_page_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	foreach ($page_meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
?>