<?php

class sspdc extends Director {

	function __construct() {
	
		Director::__construct(get_option('sspdc_api_key'), get_option('sspdc_api_path'), true);
		
		$sspdc_fmt = unserialize(get_option('sspdc_fmt'));
		
		# Regular size for display within posts
		$this->format->add(array('name' => 'post', 'width' => $sspdc_fmt['post_width'], 'height' => $sspdc_fmt['post_height'], 'crop' => $sspdc_fmt['post_crop'], 'quality' =>$sspdc_fmt['post_quality'], 'sharpening' => $sspdc_fmt['post_sharpening']));
		
		# Regular size for album preview image 
		$this->format->preview(array('width' => $sspdc_fmt['preview_width'], 'height' => $sspdc_fmt['preview_height'], 'crop' => $sspdc_fmt['preview_crop'], 'quality' =>$sspdc_fmt['preview_quality'], 'sharpening' => $sspdc_fmt['preview_sharpening']));
		
		# Size for  matrix thumbnails
		$this->format->add(array('name' => 'thumb', 'width' => $sspdc_fmt['matrix_width'], 'height' => $sspdc_fmt['matrix_height'], 'crop' => $sspdc_fmt['matrix_crop'], 'quality' => $sspdc_fmt['matrix_quality'], 'sharpening' => $sspdc_fmt['matrix_sharpening']));
		
		# Full size image for lightbox viewing
		$this->format->add(array('name' => 'fullsize', 'width' => $sspdc_fmt['fullsize_width'], 'height' => $sspdc_fmt['fullsize_height'], 'crop' => $sspdc_fmt['fullsize_crop'], 'quality' => $sspdc_fmt['fullsize_quality'], 'sharpening' => $sspdc_fmt['fullsize_sharpening']));
		
		# Size for photostrip thumbnails
		$this->format->add(array('name' => 'photostrip', 'width' => $sspdc_fmt['photostrip_width'], 'height' => $sspdc_fmt['photostrip_height'], 'crop' => $sspdc_fmt['photostrip_crop'], 'quality' => $sspdc_fmt['photostrip_quality'], 'sharpening' => $sspdc_fmt['photostrip_sharpening']));
		
		# Size for widget thumbnails
		$this->format->add(array('name' => 'widget', 'width' => $sspdc_fmt['widget_width'], 'height' => $sspdc_fmt['widget_height'], 'crop' => $sspdc_fmt['widget_crop'], 'quality' => $sspdc_fmt['widget_quality'], 'sharpening' => $sspdc_fmt['widget_sharpening']));
		
		# Size for video preview
		$this->format->add(array('name' => 'video_preview', 'width' => $sspdc_fmt['video_preview_width'], 'height' => $sspdc_fmt['video_preview_height'], 'crop' => $sspdc_fmt['video_preview_crop'], 'quality' => $sspdc_fmt['video_preview_quality'], 'sharpening' => $sspdc_fmt['video_preview_sharpening']));
		
		for ( $i = 1; $i <= 3; $i++ ) {
			if ( !empty($sspdc_fmt[$i]['name'])) {
				
				$this->format->add(array('name' => $sspdc_fmt[$i]['name'], 'width' => $sspdc_fmt[$i]['width'], 'height' => $sspdc_fmt[$i]['height'], 'crop' => $sspdc_fmt[$i]['crop'], 'quality' => $sspdc_fmt[$i]['quality'], 'sharpening' => $sspdc_fmt[$i]['sharpening']));
			}
		}
		
		if ( get_option('sspdc_cache') == '1' ) {
			$cache = "cache";
			$this->cache->set('sspdc'. $cache);
		}
		
		$this->gallery = new sspdcGallery($this);
		$this->album = new sspdcAlbum($this);
		$this->content = new sspdcContent($this);
	}
}

class sspdcGallery extends DirectorGallery {
	
	public function html( $gallery_id ) {
		
		$gallery = $this->get( $gallery_id );
		
		
		if ( !empty( $gallery ) ) {
		
			foreach ( $gallery->albums->album AS $album ) {	
				
				$a = new sspdc;
				
				$html .= $a->album->html($album->id, 'preview', 'true', 'lightbox');	
			}
		
		}
		
		return $html;
	}

}

class sspdcAlbum extends DirectorAlbum {

	public function html( $album_id, $style = 'matrix', $description = 'false', $link = 'lightbox', $thumbnailsNum = '') {
		/* 
		Create html for an album.
		Either matrix view or album preview image as entry point 
		
		[sspdc album=(album_id) style=(preview|matrix) description=(true|false) link=(none|lightbox|director|url:)]
		*/	
		
		/* get album data */
		
		$album = $this->get( $album_id );
		$images = $album->contents[0];
		
		$html = '';	
		
		if ( $style == 'preview') {
			
			/* 	
				Create preview as entry point of the given SSP Director album with attached lightbox view 
				
				CSS:
					.sspdc_album_preview: 	container class 
					.sspdc_album_text:		container class for name and desc.
			*/
			
			
			$lightview_is_active = class_exists('lightview_plus');
			
			$html = '';
					
			$url = explode( ':', $link, 2);
			
			if ( $url[0] == 'url') {
				$html .= '<div class="sspdc_album_preview">';
				$html .= '<a href="'. $url[1] . '">';
				$html .= '<img src="' .  $album->preview->url . '"  alt="' . $image->title . '" /></a>';
			}
			
			elseif ( $link == 'none' ) {
		
				$html .= '<div class="sspdc_album_preview">';
				$html .= '<img src="' .  $album->preview->url . '"  alt="' . $image->title . '" />';
			}
			
			
			elseif ( empty( $link ) || $link == 'lightbox' ) {
			
				foreach( $images as $image ) {
				
				/* Check 'lightobx' product */
					
				if ($lightview_is_active) {
 					$box = 'class="lightview" rel="gallery[album-'.$album->id.']"';
 					$title = $image->title . ' :: ' . $image->caption;
				} else {
 					$box = 'rel="lightbox[album-'.$album->id.']"';
 					$title = $image->title;
				}
							
					if ( $html == '' ) {
						$html .= '<div class="sspdc_album_preview">';
						
						$html .= '<a href="'. $image->fullsize->url . '" ' . $box . ' title="'.  $title . '"><img src="' .  $album->preview->url . '"  alt="' . $image->title . '" /></a>';
						
					}
					
					else {
					
						$html .= '<a href="'. $image->fullsize->url . '" ' . $box . ' title="'.  $title . '" alt="' . $image->title . '" /> </a>';
					}
				}
			}
			
			if ( $description == 'true' && $url[0] == 'url') {
				
				$html .= '<div class="sspdc_album_text"><div class="sspdc_album_name"><h3><a href="' .$url[1]. '">'. $album->name . '</a></h3></div><div class="sspdc_album_description"><p>'. $album->description . '</p></div></div>';
			}
			
			elseif ( $description == 'true' ) {
				
				$html .= '<div class="sspdc_album_text"><div class="sspdc_album_name"><h3>'. $album->name . '</h3></div><div class="sspdc_album_description"><p>'. $album->description . '</p></div></div>';
			}
			
			$html .= '</div><br clear="left" />';
		}
		
		elseif ( $style == "matrix" ) {
			
			/* 	
				Create thumbnail matrix as entry point of the given SSP Director album with attached lightbox view 
				
				CSS:
					.sspdc_matrix: 			container class for all thumbnails
					.sspdc_thumbnail:		thumbnail class
			*/
			
			$lightview_is_active = class_exists('lightview_plus');
			
			$html = '<div class="sspdc_album_matrix">';
			
			if ( $description == 'true' ) {
			
				$html .= '<div class="sspdc_album_text"><div class="sspdc_album_name"><h4>'. $album->name . '</h4></div><div class="sspdc_album_description"><p>'. $album->description . '</p></div></div>';
			}
			$i = 0;	
			foreach( $images as $image ) {
			
			
			
				/* Check 'lightobx' product */
			
				if ($lightview_is_active) {
 					$box = 'class="lightview" rel="gallery[post-'.get_the_ID().']"';
 					$title = $image->title . ' :: ' . $image->caption;
				} else {
 					 $box = 'rel="lightbox[post-'.get_the_ID().']"';
 					 $title = $image->title;
				}
				
				if ( $link == 'director' ) {
					$link_url = $content->link;
				
					if ( $content->target == FALSE) {
						$link_target = '_blank';
					}
					
					else {
						$link_target = '_self';
					}
					
					$html .= '<div class="sspdc_thumbnail"><a href="'. $link_url . '" title="'.  $title . '"><img src="' . $image->thumb->url . '"  alt="'  . $image->title . '"  target="'. $link_target . '" /></a></div>';
					
				}
				
				else {
					
					if ($i < $thumbnailsNum || $thumbnailsNum == '') {
						$html .= '<div class="sspdc_thumbnail"><a href="'. $image->fullsize->url . '" ' . $box . ' title="'.  $title . '"><img src="' . $image->thumb->url . '"  alt="'  . $image->title . '" /></a></div>';
					}
					
					else {
					
					$html .= '<div class="sspdc_thumbnail"><a href="'. $image->fullsize->url . '" '. $box . ' title="'.  $title . '"></a></div>';
					}
					
				}
				
				$i++;
			}	
			
			$html .= '</div>';
		}
		
		
	return $html;
	
	}
}

class sspdcContent extends DirectorContent {

	public function html( $content_id, $link = 'lightbox', $format = 'post', $mediaplayer = '' ) {
		
		$lightview_is_active = class_exists('lightview_plus');
		
		$content = $this->get( $content_id );
	
		$director = new sspdc;
		
		if ( $director->utils->is_image( $content->src ) ) {
			
			
			/* Check 'lightbox' product */
			
			if ($lightview_is_active) {
 				$box = 'class="lightview" rel="gallery[post-' . get_the_ID() .']"';
 				$title = $content->title . ' :: ' . $content->caption;
			} else {
 				 $box = 'rel="lightbox[post-'.get_the_ID().']"';
 				 $title = $content->title;
			}
			
			$link_target = '_self';
			$url = explode( ':', $link, 2);
			
			if ( $url[0] == 'url' ) {
				$link_url = $url[1];
			}
			
			elseif ( $link == 'post' ) {
				
				//$link_url = get_bloginfo('siteurl') . '/?p=' . get_the_ID();
				$link_url = get_permalink();
				$box = '';
				$title = $content->title;
			}
			
			elseif ( $link == 'director' ) {
				$link_url = $content->link;
				
				if ( $content->target == FALSE ) {
					$link_target = '_blank';
				}
			}
			
			elseif ( $link == 'original' ) {
				$link_url = $content->original->url;
			}
			
			elseif ( $link == 'none' ) {
				$link_url = '';
			}
			
			elseif ( empty( $link ) || $link == 'lightbox' ) {
				$link_url = $content->fullsize->url;
			}
			
			
			/***
			*	Generate img src link to the specified format
			***/
			
			if ( $format == 'post' || empty($format)  ) {
			
				$content_url = $content->post->url;
			}
			
			else {

				$content_url = $content->$format->url;
				
			}
			
			
			/***
			*	Generate HTML for output
			***/
			
			$html = '<div class="sspdc_image">';
			
			if ( $link == 'none' ) {
				$html .= '<img src="' .  $content_url . '"  alt="' . $content->title . '" />';
			}
			
			else {
				$html .= '<a href="' . $link_url .'" ' . $box . '" target="' . $link_target . '" title="'.  $title . '"><img src="' .  $content_url . '"  alt="' . $content->title . '" /></a>';
			}
			
			$html .= '</div>';
			
			/***
			*	Override $html generation if user wants only the 'raw' link
			*	to the specified format 
			***/
			
			if ( $link =='raw' ) {
			
				$html = $content_url;	
			}
		}
		
		else {
			
			
			/***
			*	Video stuff
			***/
	
			$lightview_is_active = class_exists('lightview_plus');
			
			if ( $lightview_is_active ) {
 				//$box = 'class="lightview" rel="set[video]"';
 				//$title = $content->title . ' :: ' . $content->caption;
 				
 				$html = '<a href="' . get_settings("siteurl").'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/js/mediaplayer/player.swf?file='
 				.$content->original->url.'" title=" :: :: autoplay: true,  autosize: true" class="lightview" rel="set[video]">Flash movie</a>';
			} 
			
			else {
 				 
				$html = '<span id="video-'.get_the_ID().'">Sorry. FLV player did not load.</span>';
				
				$sspdc_fmt = unserialize(get_option('sspdc_fmt'));			
	
				if (!empty( $mediaplayer ) ){
					$options = explode( '&', html_entity_decode ( $mediaplayer));
					
					foreach ($options as $option ) {
						
						$vars = explode ( '=', $option );
						
						$mediaplayer_vars[$vars[0]] = $vars[1]; 
					}
					
					$addVariable = '';
					foreach ( $mediaplayer_vars as $key => $value )	{
						
						$addVariable .= 'flashvars.'.$key.' ="'.$value.'";';
					}
					
				}
				
				
				$html .= 	'<script type="text/javascript">';
				$html .=	'var flashvars = {};';
				$html .=	'flashvars.id 			= "n'.get_the_ID().'";';
				$html .=	'flashvars.controlbar 	= "over";';
				$html .=	'flashvars.image 		= "'.$content->video_preview->url.'";';
				$html .=	'flashvars.file			= "'.$content->original->url.'";';
				$html .=	$addVariable;
				
				$html .=	'var params = {};';
				$html .=	'params.allowfullscreen = "true";';
				$html .=	'params.allowscriptaccess = "always";';
				
				$html .=	'var attributes = {};';
				$html .=	'attributes.id = "video-'.get_the_ID().'";';
				
				$html .= 'swfobject.embedSWF("'. get_settings("siteurl").'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/js/mediaplayer/player.swf", "video-'.get_the_ID().'", "'.$sspdc_fmt["video_width"].'", "'.$sspdc_fmt["video_height"].'", "10.0.0","'. get_settings("siteurl").'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/js/mediaplayer/expressinstall.swf", flashvars, params, attributes);';
				$html .= 	'</script>';
			}
		}
		
		return $html;		
	}
}
?>