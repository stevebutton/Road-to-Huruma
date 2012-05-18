<?php
	global $custom_settings;

	/**
	* Remove inline styles printed when the gallery shortcode is used.
	*/
	function cudazi_remove_gallery_css( $css ) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	add_filter( 'gallery_style', 'cudazi_remove_gallery_css' );
	
	
	
	function cudazi_remove_readmore_jump($link) {
		$offset = strpos($link, '#more-');
		if ($offset) {
			$end = strpos($link, '"',$offset);
		}
		if ($end) {
			$link = substr_replace($link, '', $offset, $end-$offset);
		}
		return $link;
	}
	add_filter('the_content_more_link', 'cudazi_remove_readmore_jump');

?>