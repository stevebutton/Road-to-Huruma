<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'mansion_options', 'mansion_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */
// Get Wordpress Categories
global $categories;
$cats_array = get_categories();
$blog = array();
foreach ($cats_array as $cats) {
	$catarray = array(
		'value' =>	$cats->cat_ID,
		'label' => __( $cats->cat_name )		
	);
	array_push($blog, $catarray);
}

// radio options
$griddesign = array(
	'one' => array(
		'value' => 'one',
		'label' => __( 'Show 1 image per post' ),
		'checked' => 'checked'
	),
	'all' => array(
		'value' => 'all',
		'label' => __( 'Show all images per post' ),
		'checked' => ''
	)
);

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $blog, $griddesign;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'mansion_options' ); ?>
			<?php $options = get_option( 'mansion_theme_options' ); ?>

			<table class="form-table">
			
				<?php
				/**
				 * A sample of radio buttons
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Choose your grid design' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Grid Design' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $griddesign as $option ) {
								$radio_setting = $options['griddesign'];

								if ( '' != $radio_setting ) {
									if ( $options['griddesign'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="mansion_theme_options[griddesign]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php if($checked) { echo $checked; } else { echo $option['checked']; } ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>

				
				<?php
				/**
				 * A sample select input option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Select Blog Category' ); ?></th>
					<td>
						<select name="mansion_theme_options[blog]">
							<?php
								$selected = $options['blog'];
								$p = '';
								$r = '';

								foreach ( $blog as $option ) {
									$label = $option['label'];
									if ( $selected == $option['value'] ) // Make default first in list
										$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
									else
										$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
								}
								echo $p . $r;
							?>
						</select>
						<label class="description" for="mansion_theme_options[blog]"><?php _e( 'This only applies if you are creating your blog page using Blog Page Template' ); ?></label>
					</td>
				</tr>

				
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $blog, $griddesign;

/*
	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );
*/

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['blog'], $blog ) )
		$input['blog'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['griddesign'] ) )
		$input['griddesign'] = null;
	if ( ! array_key_exists( $input['griddesign'], $griddesign ) )
		$input['griddesign'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	/* $input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] ); */

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/