<?php
/**
 * Get all theme options from the database
 */
global $options;
foreach ( $options as $value ) {
	if ( isset( $value['id'] ) ) { 
		if ( get_option( $value['id'] ) === FALSE ) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_option( $value['id'] );
		}
	}
}
?>