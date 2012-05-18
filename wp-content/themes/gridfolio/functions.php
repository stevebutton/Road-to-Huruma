<?php

	// Libraries file pulls in the relavant libraries
	include_once(TEMPLATEPATH . "/libraries/load.php");


	// 
	// List any smaller functions below that do not need to be in a library
	// 
	
	
	// used to decide whether to use the light, dark or text based logo
	function cudazi_get_logo()
	{
		global $custom_settings;
	?>
        <h1><a href="<?php echo home_url( '/' ); ?>">
        <?php if($custom_settings["logo"]["usetextlogo"]) { 
			bloginfo('name'); 
        }else{ 
				if($custom_settings["logo"]["url"])
				{
					$logourl = $custom_settings["logo"]["url"];
				}else{
					if($custom_settings["theme"] == 'dark')
					{
						$logourl = get_bloginfo('template_url') . "/images/logo-dark.png";
					}else{
						$logourl = get_bloginfo('template_url') . "/images/logo.png";
					}
				}
            ?><img src="<?php echo $logourl; ?>" alt="<?php bloginfo('name'); ?>" />
        <?php } ?>
        </a></h1><?php
	}
	
	// Function to pull the attached files from a post
	// Pass options in via array $options['max'] = 3;
	function cudazi_get_attachment_files( $options ) {
		// Set up defaults
		if(!$options['id']) { $options['id'] = get_the_id(); } 
		if(!$options['max']) { $options['max'] = -1; } 
		if(!$options['media_size']) { $options['media_size'] = "medium"; } 
		if(!$options['post_mime_type']) { $options['post_mime_type'] = "image"; } 
		if(!$options['linkto']) { /*no default*/ } 
		
		if(
			$arr_attachments = get_children(
				array(
					"post_type"=> "attachment",
					"numberposts"=> $options['max'],
					"post_mime_type" => $options['post_mime_type'],
					"post_parent"=> $options['id'],
					"post_status"=> null,
					"order" => "ASC",
					"orderby" => "menu_order"
					)
				)
			){
			$img_array = array();
			foreach( $arr_attachments as $attachment ) {
				$before = $after = "";
				if($options['linkto'] == "attachment"){
					$before .= "<a href='" . wp_get_attachment_url( $attachment->ID ) . "'>";
					$after .= "</a>";
				}
				$attachment_array[] = $before . wp_get_attachment_image($attachment->ID, $options['media_size'] ) . $after;
			}
			return $attachment_array;
		}
	}
	
	
	
	// Small function to create a simple slider 
	// Pass in the array of attachments to  use and options arrays
	function cudazi_create_slider( $arr_of_attachments, $options )
	{
		// Set up defaults
		if(!$options['class']) { $options['class'] = 'slider'; } 
		
		$slider = $slide_count = $slides = "";
		if( !empty( $arr_of_attachments ) )
		{
			foreach( $arr_of_attachments as $attachment ) {
				$slides .= "<li>" . $attachment . "</li>";
				$slide_count++;
			}
			
			$slider .= "<ul class='".$options['class']."'>";
				$slider .= $slides;
			$slider .= "</ul>";
			
			return $slider;
		}
	}
	
