<?php
	
	// Strip Auto Widget Format on the cudazi_column widget
	// Otherwise, your content may get unwanted P tags, etc...
	function cudazi_strip_auto_widget_formatting($content) {
		$formatted_content = '';
		$pattern = '{(\[cudazi_column\].*?\[/cudazi_column\])}is';
		$contents = '{\[cudazi_column\](.*?)\[/cudazi_column\]}is';
		$arr_pieces = preg_split($pattern, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
		foreach ($arr_pieces as $piece) 
		{
			if (preg_match($contents, $piece, $matches)) 
			{
				$formatted_content .= $matches[1];
			} else {
				$formatted_content .= wptexturize(wpautop($piece));
			}
		}
	
		return $formatted_content;
	}
	remove_filter('the_content', 'wpautop');
	remove_filter('the_content', 'wptexturize');
	add_filter('the_content', 'cudazi_strip_auto_widget_formatting', 100);


	// [cudazi_column]
	function cudazi_column_sc($atts, $content = null) {
		$output = $addclass = "";
		extract(shortcode_atts(array(
			'width' => 4,
			'class' => '',
			'special' => ''
		), $atts));
		
		if(!$width || $width > 12){
			$width = 3;			
		}
		
		$output .= "<div class='grid_" . $width ." " . $class . " " . $addclass . "'>";
			if($special == 'boxed'){
				$output .= "<div class='shadow rounded centered boxed'>";
				$output .= $content;
				$output .= "</div>";
			}else{
				$output .= $content;
			}			
		$output .= "</div>";
		
		if($class == "omega")
		{
			$output .= "<div class='clear'></div>";
		}
		
		return $output;
	}
	add_shortcode('cudazi_column', 'cudazi_column_sc');

	
	// Contact Form Shortcode
	// [cudazi_contact to='you@email.com']	
	function cudazi_contact_sc($atts) {	
		global $custom_settings;
		extract(shortcode_atts(array(
			"to" => $custom_settings["contactform"]["to"],
			"subject" => __('Contact Form Message','cudazi'),
			"button" => __('Send Message','cudazi'),
			"sent" => __('Message Sent!','cudazi'),
			"error" => __('Error, please be sure you filled out all fields properly.','cudazi')
		), $atts));

			ob_start();
			if($to != "")
			{
				if(isset($_POST["cf_submit"]))
				{	
					$from = $_POST["cf_email"];
					$hasErrors = false;
					if(empty($_POST["cf_name"]) || empty($_POST["cf_email"]) || empty($_POST["cf_message"]))
					{
						$hasErrors = true;
					}else{
						if(preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/", $_POST["cf_email"]) == 1) {
							$hasErrors = false;
						}else{
							$hasErrors = true;
						}
					}
					if($hasErrors == false)
					{
						$headers = "From: <".$from . ">";
						$body = "\nContact Form Message:\n\n";
						$body .= "From: " . $_POST["cf_name"] . " (".$_POST['cf_email'].")\n";
						$body .= "\nMessage:\n" . $_POST["cf_message"] . "\n\n";
						mail($to,$subject,$body,$headers);
					}
					if($hasErrors == false)
					{
						echo "<p class='message success'>".$sent."</p>";
					}else{
						echo "<p class='message error'>".$error."</p>";
					}
				
				}
				
				?>
                <a name="contactform_sent" id="contactform_sent"></a>
				<h3><?php _e('Contact Form','cudazi'); ?></h3>
				<p id="contact-form-errror" class="message warning hidden"><?php _e('Name, valid email and message required.','cudazi'); ?></p>
				<form action="#contactform_sent" method="post" class="standardForm">
					<label for="cf_name" class="hidden"><?php _e('Enter Your Name','cudazi'); ?></label>
						<input class="textbox rounded" type="text" id="cf_name" name="cf_name" value="Your Name" />
					<label for="cf_email" class="hidden"><?php _e('Enter Your Email Address','cudazi'); ?></label>
					<input class="textbox rounded" type="text" id="cf_email" name="cf_email" value="Email" />
					<input class="hidden" type="text" id="email_2" name="email_2" value="" />
					<label for="cf_message" class="hidden"><?php _e('Enter Your Message','cudazi'); ?></label>
						<textarea class="textarea rounded" name="cf_message" id="cf_message"><?php _e('Enter a Message','cudazi'); ?></textarea>
					<input class="submit rounded" type="submit" name="cf_submit" id="cf_submit" value="<?php _e('Send Message','cudazi'); ?>" />
				</form>
				<?php
			}else{
				echo cudazi_admin_message("To address not set on the contact form", 'error', '');
			}
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	add_shortcode('cudazi_contact', 'cudazi_contact_sc');

?>