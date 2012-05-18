<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
Download Options page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member File Download Options</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
echo '<form method="post" name="ws_plugin__s2member_options_form" id="ws-plugin--s2member-options-form">' . "\n";
echo '<input type="hidden" name="ws_plugin__s2member_options_save" id="ws-plugin--s2member-options-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-options-save")) . '" />' . "\n";
echo '<input type="hidden" name="ws_plugin__s2member_configured" id="ws-plugin--s2member-configured" value="1" />' . "\n";
/**/
do_action ("ws_plugin__s2member_during_down_ops_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_restrictions", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_restrictions", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Basic Download Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-restrictions-section">' . "\n";
		echo '<h3>File Download Restrictions ( required, if providing access to protected files )</h3>' . "\n";
		echo '<p>If your membership offering allows access to restricted files, you\'ll want to configure these options.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_restrictions", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Upload restricted files to this security-enabled directory:</strong><br /><code>' . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]) . '</code></p>' . "\n";
		echo '<p>- Now, you can link to any protected file, using this special format:<br />&nbsp;&nbsp;<code>' . get_bloginfo ("wpurl") . '/?s2member_file_download=example-file.zip</code><br />&nbsp;&nbsp;<small><em><strong>s2member_file_download</strong> = location of the file, relative to the /' . esc_html (basename ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/ directory. In other words, just the file name.</em></small></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p>s2Member will allow access to these protected files, based on the configuration you specify below. Repeated downloads of the same exact file are NOT tabulated against the totals below. Once a file has been downloaded, future downloads of the same exact file, by the same exact Member will not be counted against them. In other words, if a Member downloads the same file three times, the system only counts that as one unique download.</p>' . "\n";
		echo '<p>s2Member will automatically detect links, anywhere in your content, and/or anywhere in your theme files, that contain <code>?s2member_file_download</code>. Whenever a logged-in Member clicks a link that contains <code>?s2member_file_download</code>, the system will politely ask the user to confirm the download using a very intuitive JavaScript confirmation prompt that contains specific details about download limitations. This way your Members will be aware of how many files they\'ve downloaded in the current period; and they\'ll be able to make a conscious decision about whether to proceed with a specific download or not. If you want to suppress this JavaScript confirmation prompt, you add this to the end of your links: <code>&amp;s2member_skip_confirmation</code>.</p>' . "\n";
		echo '<p><em>* The above only applies to Users who are logged in as Members. For all other visitors in the general public, the <code>?s2member_file_download</code> links will redirect them your Membership Options Page, so that new visitors can signup, in order to gain access, by becoming a Member. You may also want to have a look down below at s2Member\'s "Advanced Download Restrictions", which provides a greater degree of flexibility.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-file-downloads-allowed">' . "\n";
		echo 'File Downloads ( Level #0 Or Higher ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level0_file_downloads_allowed" id="ws-plugin--s2member-level0-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level0_file_downloads_allowed_days" id="ws-plugin--s2member-level0-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
		echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-file-downloads-allowed">' . "\n";
		echo 'File Downloads ( Level #1 Or Higher ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level1_file_downloads_allowed" id="ws-plugin--s2member-level1-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level1_file_downloads_allowed_days" id="ws-plugin--s2member-level1-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
		echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-file-downloads-allowed">' . "\n";
		echo 'File Downloads ( Level #2 Or Higher ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level2_file_downloads_allowed" id="ws-plugin--s2member-level2-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level2_file_downloads_allowed_days" id="ws-plugin--s2member-level2-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
		echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-file-downloads-allowed">' . "\n";
		echo 'File Downloads ( Level #3 Or Higher ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level3_file_downloads_allowed" id="ws-plugin--s2member-level3-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level3_file_downloads_allowed_days" id="ws-plugin--s2member-level3-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
		echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-file-downloads-allowed">' . "\n";
		echo 'File Downloads ( Highest Level #4 ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level4_file_downloads_allowed" id="ws-plugin--s2member-level4-file-downloads-allowed" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed"]) . '" style="width:200px;" maxlength="9" /> every <input type="text" name="ws_plugin__s2member_level4_file_downloads_allowed_days" id="ws-plugin--s2member-level4-file-downloads-allowed-days" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_file_downloads_allowed_days"]) . '" style="width:200px;" maxlength="3" onkeyup="if(this.value > 365){ alert(\'( 365 days is the maximum ).\\nThis keeps the logs optimized.\'); this.value = 365; }" /> days.<br />' . "\n";
		echo 'Only this many unique downloads ( <code><em>999999999 = unlimited</em></code> ) will be permitted every X days.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_restrictions", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_limit_exceeded_page", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_limit_exceeded_page", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Download Limit Exceeded">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-limit-exceeded-page-section">' . "\n";
		echo '<h3>Download Limit Exceeded Page ( required, if providing access to protected files )</h3>' . "\n";
		echo '<p>This Page will be shown if a Member reaches their download limit, based on the configuration you\'ve specified in the fields above. This Page should be created by you, in WordPress®. This Page should provide an informative message to the Member, describing your file access restrictions. Just tell them a little bit about your policy on file downloads, and why they might have reached this Page.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_limit_exceeded_page", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-file-download-limit-exceeded-page">' . "\n";
		echo 'Download Limit Exceeded Page:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_file_download_limit_exceeded_page" id="ws-plugin--s2member-file-download-limit-exceeded-page">' . "\n";
		echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
		foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
			echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . ( ($ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Please choose a Page that Members will see if they reach their file download limit. This Page should provide an informative message to the Member, describing your file access restrictions. Just tell them a little bit about your policy on file downloads. We recommend the following title: <code>Download Limit Exceeded</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_limit_exceeded_page", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_advanced_restrictions", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_advanced_restrictions", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Advanced Download Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-restrictions-section">' . "\n";
		echo '<h3>Advanced Download Restrictions ( optional, for greater flexibility )</h3>' . "\n";
		echo '<p>By default, s2Member uses your Basic Download Restrictions - as configured above. However, you can force s2Member to allow file downloads, using an extra query string parameter ( <code>s2member_file_download_key</code> ). A file download `Key` is passed through this parameter, and it tells s2Member to allow the download of this particular file, regardless of Membership Level; and WITHOUT checking any Basic Restrictions, that you may, or may not, have configured above.</p>' . "\n";
		echo '<p>' . get_bloginfo ("wpurl") . '/?s2member_file_download=example-file.zip<code>&amp;s2member_file_download_key=&lt;?php echo s2member_file_download_key("example-file.zip"); ?&gt;</code><br />&nbsp;&nbsp;<small><em><strong>s2member_file_download_key</strong> = &lt;?php echo s2member_file_download_key("location of the file, relative to the /' . esc_html (basename ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])) . '/ directory"); ?&gt;</em></small></p>' . "\n";
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_advanced_restrictions", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p>The function `<code>s2member_file_download_key()</code>`, is part of the s2Member API. It produces a time-sensitive File Download Key that is unique to each and every visitor. Each Key it produces ( at the time it is produced ), will be valid for the current day, and only for a specific IP address and User-Agent string; as detected by s2Member. This makes it possible for you to create links on your site, which provide access to protected file downloads; and without having to worry about one visitor sharing their link with another. So let\'s take a quick look at what <code>s2member_file_download_key()</code> actually produces.</p>' . "\n";
		echo '<p><code>s2member_file_download_key ("example-file.zip")</code> = a site-specific hash of <em>s2member_xencrypt(date("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file)</em></p>' . "\n";
		echo '<p>When <code>s2member_file_download_key = <em>a valid Key</em></code>, it works independently from Member Level Access. That is, a visitor does NOT have to be logged in to receive access; they just need a valid Key. Using this advanced technique, you could extend s2Member\'s file protection routines, or even combine them with Specific Post/Page Access, and more. The possibilities are limitless really.</p>' . "\n";
		/**/
		#echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		#echo '<p><em>Please note... by default, Download Keys are NOT compatible with the Quick Cache plugin, and/or the WP Super Cache plugin. If you use the function <code>s2member_file_download_key()</code>, s2Member will have to prevent Quick Cache and/or WP Super Cache from caching the file you used it in; thereby (forcing) these plugins to be compatible. In other words, s2Member will automatically define <code>QUICK_CACHE_ALLOWED = false</code>, and <code>DONOTCACHEPAGE = true</code>.</em></p>' . "\n";
		#echo '<p><em>Alternatively, you can pass in a second argument, like this:</em><br /><code>s2member_file_download_key("example-file.zip", <strong>"cache-compatible"</strong>)</code> = a site-specific hash of <em>s2member_xencrypt($file)</em><br /><small>&mdash; but this is NOT as secure; your download links could be shared.</small></p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_advanced_restrictions", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_down_ops_page_during_left_sections_display_inline_extensions", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_before_inline_extensions", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Inline File Extensions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-inline-extensions-section">' . "\n";
		echo '<h3>Inline File Extensions ( optional, for content-disposition )</h3>' . "\n";
		echo '<p>There are two ways to serve files. Inline, or as an Attachment. By default, s2Member will serve all of your protected Files, as downloadable attachments. Meaning, visitors will be given a File Download Prompt. Otherwise known as <code>Content-Disposition: attachment</code>. In some cases though, you may wish to serve files Inline. For example, PDF files and images should usually be served Inline. When you serve a file Inline, it is displayed in your browser immediately, rather than your browser prompting you to download the file as an attachment.</p>' . "\n";
		echo '<p>Using the field below, you can list all of the extensions that you want s2Member to serve Inline ( ex: <code>htm,html,pdf,jpg,jpeg,jpe,gif,png</code> ). Please understand, some files just cannot be displayed inline. For instance, there is no way to display an <code>exe</code> file inline. So only specify extensions that can, and should be displayed inline by a web browser. Alternatively, if you would rather handle this on a case-by-case basis, you can simply add the following to the end of your download links: <code>&amp;s2member_file_inline=yes</code>.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_during_inline_extensions", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-file-download-inline-extensions">' . "\n";
		echo 'Default Inline File Extensions ( comma delimited ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_file_download_inline_extensions" id="ws-plugin--s2member-file-download-inline-extensions" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_inline_extensions"]) . '" /><br />' . "\n";
		echo 'Inline extensions in comma delimited format. Example: <code>htm,html,pdf,jpg,jpeg,jpe,gif,png</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_down_ops_page_during_left_sections_after_inline_extensions", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_down_ops_page_after_left_sections", get_defined_vars ());
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>' . "\n";
/**/
echo '</form>' . "\n";
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_down_ops_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_down_ops_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>