<?php
	/*
	This file is part of YAPB Bulk Uploader.

    'YAPB Bulk Uploader' is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    'YAPB Bulk Uploader' is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with 'YAPB Bulk Uploader'.  If not, see <http://www.gnu.org/licenses/>.
	
	Note that this software makes use of other libraries that are published under their own
	license. This program in no way tends to violate the licenses under which these 
	libraries are published.
	
	*/

class YBUPlugin
{

	var $pluginDir;
	var $pluginUrl;
	
	function YBUPlugin()
	{
		$this->pluginDir = plugin_dir_path(__FILE__);
		$this->pluginUrl = plugin_dir_url(__FILE__);
		
		// Hook for adding admin menus
		add_action('admin_menu', array(&$this, '_add_admin_pages'));
		
		//make sure swf gets loaded
		add_action('admin_enqueue_scripts', array(&$this, '_on_admin_init'));
	}
	
	function _add_admin_pages()
	{
		
		//add the actual posts page
		add_posts_page('YAPB Bulk','YAPB Bulk', 1, basename(__FILE__), array(&$this,'_add_posts_page'));
	}
	
	function _add_posts_page()
	{
		global $user_ID;
		include($this->pluginDir."ybu_swf.php");
	} 
	
	function _on_admin_init($hook) 
	{
		if (array_key_exists('page', $_GET)) 
		{
			if ($_GET['page'] == basename(__FILE__)) 
			{
				wp_enqueue_script('swfupload');
				wp_enqueue_script('swfupload-swfobject');
				wp_enqueue_script('ybu_swf', plugins_url("ybu_swf.js", __FILE__));
				
				wp_enqueue_style("ybu_css", plugins_url("ybu.css", __FILE__));
			}
		}
	}
}
?>
