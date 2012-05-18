<?php
// Portfolio Post Meta Box
$meta_box_portfolio = array(
	'id' => 'portfolio-meta-box',
	'title' => __( 'Portfolio Settings', LANGUAGE ),
	'page' => 'portfolio_item',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __( 'Large Image or Video', LANGUAGE ), 
			'desc' => __( 'Enter the URL of the full size image or video that will be opened in the lightbox', LANGUAGE ),
			'id'   => $prefix . 'full_img_1',
			'type' => 'upload',
			'std'  => ''
		),
		array(
			'name' => __( 'Large Image or Video', LANGUAGE ),
			'desc' => __( 'Enter the URL of the full size image or video that will be opened in the lightbox', LANGUAGE ),
			'id'   => $prefix . 'full_img_2',
			'type' => 'upload',
			'std'  => ''
		),
		array(
			'name' => __( 'Large Image or Video', LANGUAGE ),
			'desc' => __( 'Enter the URL of the full size image or video that will be opened in the lightbox', LANGUAGE ),
			'id'   => $prefix . 'full_img_3',
			'type' => 'upload',
			'std'  => ''
		),
		array(
			'name' => __( 'Large Image or Video', LANGUAGE ),
			'desc' => __( 'Enter the URL of the full size image or video that will be opened in the lightbox', LANGUAGE ),
			'id'   => $prefix . 'full_img_4',
			'type' => 'upload',
			'std'  => ''
		),
		array(
			'name' => __( 'Large Image or Video', LANGUAGE ),
			'desc' => __( 'Enter the URL of the full size image or video that will be opened in the lightbox', LANGUAGE ),
			'id'   => $prefix . 'full_img_5',
			'type' => 'upload',
			'std'  => ''
		)
	)
);

function celta_portfolio_add_box() {
	global $meta_box_portfolio;
	add_meta_box($meta_box_portfolio['id'], $meta_box_portfolio['title'], 'celta_portfolio_show_box', $meta_box_portfolio['page'], $meta_box_portfolio['context'], $meta_box_portfolio['priority']);
}

function celta_portfolio_show_box() {
	global $meta_box_portfolio, $post;
	echo '<input type="hidden" name="celta_portfolio_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
		foreach ($meta_box_portfolio['fields'] as $field) {
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
					break;
				case 'radio':
					foreach ($field['options'] as $option) {
						echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
					}
					break;
				case 'checkbox':
					echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />',
						$field['desc'];
					break;
			}
			echo '<td>';
			echo '</tr>';
		}
	echo '</table>';
}

function celta_portfolio_save_data($post_id) {
	global $meta_box_portfolio;
	if (!wp_verify_nonce($_POST['celta_portfolio_meta_box_nonce'], basename(__FILE__))) {
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
	foreach ($meta_box_portfolio['fields'] as $field) {
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