<?php

	// Display messages to logged in admins to help with setup/errors
	function cudazi_admin_message($message, $level='error',$helpurl='')
	{
		global $custom_settings;
		if(!$custom_settings["disable_admin_error_messages"])
		{
			if($message)
			{
				// http://codex.wordpress.org/Roles_and_Capabilities#manage_options
				if ( current_user_can('manage_options') ) 
				{ 
					$output = "<p class='message ".$level."'><strong>" . $message . "</strong>";
					if($helpurl){
						$output .= " [<a href='" . $helpurl . "'>".__("More Information","cudazi")."</a>] ";
					}
					$output .= "<br /><small>".__("This message is only displayed to admin users and can be disabled in the custom Settings+ page.","cudazi")."</small></p>";
					return $output;
				}
			}
		}
	}
	
	// Not used in theme, useful for debugging array info
	function print_r_pre($array,$sep='<hr />')
	{
		echo "<pre>";
		echo $sep;
		print_r($array);
		echo $sep;
		echo "</pre>";
	}
?>