<?php

if ( function_exists('register_sidebar') ) {
	register_sidebars(2);
}


/* 
 * return content which is arranged top thumbnail link to img tag.
 */
function adjust_single_image($content) {
	$matches1 = $matches2 = $matches3 = array();
	
	// search *first* img/object tag
	preg_match('/<(img|object)(?:[^>]+?)>/', $content, $matches1);
	
	if ($matches1[1] != 'img') {
		return $content; // do nothing.
	}
	
	// retrieve first img tag
	preg_match('/<img(?:[^>]+?)>/', $content, $matches2);
	$target = $matches2[0];
	
	// check image link and arrange it.
	$chk_imglink = '/<a(?:.+?)href="(.+?\.(?:jpe?g|png|gif))"(?:[^>]*?)>'. preg_quote($target, '/') .'<\/a>/';
	$content = preg_replace($chk_imglink, '<img src="$1" />', $content);
	
	return $content;
}


/* 
 * return class name and image tag (resized w/h attributes) to fit a grid.
 */
function adjust_grid_image($content, $col_w, $gap_w, $max_col, $flg_img_forcelink, $flg_obj_fit) {
	global $post;
	
	$col_class_base = 'x';
	$col_class = $col_class_base . '1'; // default column-width class
	$arr_w = array();
	for ($i=0; $i<$max_col; $i++) {
		$arr_w[] = ($col_w * ($i+1)) + ($gap_w * $i);
	}
	
	$grid_img = '';
	$w = $h = 0;
	$matches1 = $matches2 = $matches3 = array();
	
	// search *first* img/object tag
	preg_match('/<(img|object)(?:[^>]+?)>/', $content, $matches1);
	
	if ($matches1[1] == 'img') {
		preg_match('/<img(?:.+?)src="(.+?)"(?:[^>]+?)>/', $content, $matches2);
		$img_url = ($matches2[1]) ? $matches2[1] : '';
		if ($img_url) {
			// first, try to get attributes
			$matches_w = $matches_h = array();
			preg_match('/width="([0-9]+)"/', $matches2[0], $matches_w);
			preg_match('/height="([0-9]+)"/', $matches2[0], $matches_h);
			if ($matches_w[1] and $matches_h[1]) {
				$w = $matches_w[1];
				$h = $matches_h[1];
			}
			else {
				// ... or get original size info.
				$upload_path = trim( get_option('upload_path') ); 
				$mark = substr(strrchr($upload_path, "/"), 1); // default mark is 'uploads'
				$split_url = split($mark, $img_url);
				if ($split_url[1] != null) {
					$img_path = $upload_path . $split_url[1];
					list($w, $h) = @getimagesize($img_path);
				}
			}
		}
		
		for ($i=0; $i<$max_col; $i++) { // set new width and col_class
			if ( ($i >= $max_col - 1) or ($w < $arr_w[$i+1]) ) {
				$nw = $arr_w[$i];
				$col_class = $col_class_base . ($i+1);
				break;
			}
		}
		$nh = (!$w or !$h) ? $nw : intval( ($h * $nw) / $w ); // set new height
		
		$grid_img = $matches2[0];
		// add width/height properties if nothing
		$flg_no_w = (strpos($grid_img_edit, 'width=') === false);
		$flg_no_h = (strpos($grid_img_edit, 'height=') === false);
		if ($flg_no_w or $flg_no_h) {
			$grid_img_close = (substr($grid_img, -2) == '/>') ? '/>' : '>';
			$grid_img_edit = substr( $grid_img, 0, -(strlen($grid_img_close)) );
			$grid_img_edit .= ($flg_no_w) ? ' width="0"' : '';
			$grid_img_edit .= ($flg_no_h) ? ' height="0"' : '';
			$grid_img = $grid_img_edit . $grid_img_close;
		} 
		// replace new width/height properties
		$grid_img = preg_replace('/width="(\d+)"/', 'width="'. $nw .'"', $grid_img);
		$grid_img = preg_replace('/height="(\d+)"/', 'height="'. $nh .'"', $grid_img);
		
		// check image link
		//$chk_imglink = '/(<a(?:.+?)rel="(?:lightbox[^"]*?)"(?:[^>]*?)>)'. preg_quote($matches2[0], '/') .'/';
		$chk_imglink = '/(<a(?:.+?)href="(?:.+?\.(?:jpe?g|png|gif))"(?:[^>]*?)>)'. preg_quote($matches2[0], '/') .'/';
		if ($flg_img_forcelink) {
			$grid_img = '<a href="'. get_permalink() .'" title="' . esc_attr($post->post_title) . '">' . $grid_img . '</a>';
		}
		else if ( preg_match($chk_imglink, $content, $matches3) ) {
			$grid_img = $matches3[1] . $grid_img . '</a>';
		}
	}
	else if ($matches1[1] == 'object') {
		preg_match('/<object(.+?)<\/object>/', $content, $matches2);
		
		$matches_w = $matches_h = array();
		preg_match('/width="([0-9]+)"/', $matches2[0], $matches_w);
		preg_match('/height="([0-9]+)"/', $matches2[0], $matches_h);
		if ($matches_w[1] and $matches_h[1]) {
			$w = $matches_w[1];
			$h = $matches_h[1];
		}
		else {
			$flg_obj_fit = 'none';
		}
		
		//set col_class (and new width if in '*-fit' condition)
		if ($flg_obj_fit == 'small-fit') {
			for ($i=0; $i<$max_col; $i++) { 
				if ($i >= $max_col -1) {
					$nw = $arr_w[$i];
					$col_class = $col_class_base . ($i+1);
					break;
				}
				else if ( $w < $arr_w[$i+1] ) {
					$nw = $arr_w[$i];
					$col_class = $col_class_base . ($i+1);
					break;
				}
			}
		}
		else if ($flg_obj_fit == 'large-fit') {
			for ($i=$max_col -1; $i>=0; $i--) { 
				if ( $w > $arr_w[$i] ) {
					if ($i >= $max_col -1) {
						$nw = $arr_w[$i];
						$col_class = $col_class_base . ($i+1);
					}
					else {
						$nw = $arr_w[$i+1];
						$col_class = $col_class_base . ($i+2);
					}
					break;
				}
				if ($i == 0) {
					$nw = $arr_w[$i];
					$col_class = $col_class_base . ($i+1);
				}
			}
		}
		else {
			for ($i=0; $i<$max_col; $i++) { 
				if ($i >= $max_col -1) {
					$col_class = $col_class_base . ($i+1);
					break;
				}
				else if ( $w < $arr_w[$i] ) {
					$col_class = $col_class_base . ($i+1);
					break;
				}
			}
		}
		$nh = (!$w or !$h) ? $nw : intval( ($h * $nw) / $w ); // set new height
		
		$grid_img = $matches2[0];
		if ($flg_obj_fit == 'small-fit' or $flg_obj_fit == 'large-fit') {
			// replace new width/height properties
			$grid_img = preg_replace('/width="(\d+)"/', 'width="'. $nw .'"', $grid_img);
			$grid_img = preg_replace('/height="(\d+)"/', 'height="'. $nh .'"', $grid_img);
		}
	}
	
	return array($col_class, $grid_img);
}


/* 
 * echo paginate links using internal function "paginate_links()".
 * 
 * see: http://www.yuriko.net/arc/2008/07/26/navigation/
 */
function paginate_links2($is_top_single=false) {
	global $wp_rewrite;
	global $wp_query;
	global $paged;
	$paginate_base = ($is_top_single) ? trailingslashit( get_option('siteurl') ) : get_pagenum_link(1); /* mod */
	if (strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()) {
		$paginate_format = '';
		$paginate_base = add_query_arg('paged', '%#%', $paginate_base); /* mod */
	} else {
		$paginate_format = (substr($paginate_base, -1 ,1) == '/' ? '' : '/') .
			user_trailingslashit('page/%#%/', 'paged');
		$paginate_base .= '%_%';
	}
	echo paginate_links( array(
		'base' => $paginate_base,
		'format' => $paginate_format,
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'current' => ($paged ? $paged : 1),
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
	));
}


?>