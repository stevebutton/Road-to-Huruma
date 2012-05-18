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
General Options page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member Multisite ( Configuration )</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
if (is_multisite () && is_main_site ()) /* These panels will ONLY be available on the Main Site; with Multisite Networking. */
	{
		echo '<form method="post" name="ws_plugin__s2member_options_form" id="ws-plugin--s2member-options-form">' . "\n";
		echo '<input type="hidden" name="ws_plugin__s2member_options_save" id="ws-plugin--s2member-options-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-options-save")) . '" />' . "\n";
		echo '<input type="hidden" name="ws_plugin__s2member_configured" id="ws-plugin--s2member-configured" value="1" />' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_mms_options_page_before_left_sections", get_defined_vars ());
		/**/
		if (apply_filters ("ws_plugin__s2member_during_mms_options_page_during_left_sections_display_mms_patches", true, get_defined_vars ()))
			{
				do_action ("ws_plugin__s2member_during_mms_options_page_during_left_sections_before_mms_patches", get_defined_vars ());
				/**/
				echo '<div class="ws-menu-page-group" title="Multisite WordPress® Patches ( required )" default-state="open">' . "\n";
				/**/
				echo '<div class="ws-menu-page-section ws-plugin--s2member-mms-patches-section">' . "\n";
				echo '<img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="float:right; margin:0 0 0 25px; border:0;" />' . "\n";
				echo '<h3>Multisite WordPress® Patches ( required for compatiblity )</h3>' . "\n";
				echo '<p>In order for s2Member to function properly in a Multisite environment, you MUST implement three patches. One goes into your /wp-login.php file, one into /wp-includes/load.php, another into /wp-admin/user-new.php. We have TRAC tickets into WordPress® for these changes. However, until the official release of WordPress® includes these updates, you can just use the automatic patcher below. All you do is check the box &amp; click Save. s2Member will handle everything automatically for you. You\'ll want to do this again, after every WordPress® upgrade you perform.</p>' . "\n";
				do_action ("ws_plugin__s2member_during_mms_options_page_during_left_sections_during_mms_patches", get_defined_vars ());
				echo '<div id="ws-plugin--s2member-mms-patches-details-wrapper">' . "\n";
				echo '<h3>Rather Do It Yourself? ( <a href="#" onclick="jQuery(\'div#ws-plugin--s2member-mms-patches-details\').toggle(); return false;" class="ws-dotted-link">manual instructions</a> )</h3>' . "\n";
				echo '<div id="ws-plugin--s2member-mms-patches-details" style="display:none;">' . "\n";
				echo '<p><strong>Patch #1</strong> ( /wp-login.php )</p>' . "\n";
				echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/mms-patch-wp-login.php")) . '</p>' . "\n";
				echo '<p><strong>Patch #2</strong> ( /wp-includes/load.php )</p>' . "\n";
				echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/mms-patch-load.php")) . '</p>' . "\n";
				echo '<p><strong>Patch #3</strong> ( /wp-admin/user-new.php )</p>' . "\n";
				echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/mms-patch-user-new.php")) . '</p>' . "\n";
				echo '</div>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '<div class="ws-menu-page-hr"></div>' . "\n";
				/**/
				echo '<table class="form-table" style="margin:0;">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th style="padding-top:0;">' . "\n";
				echo '<label for="ws-plugin--s2member-mms-options-patch-files">' . "\n";
				echo 'Automatically Patch Files? ( the easiest way )' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<label><strong>Yes</strong> <input type="checkbox" name="ws_plugin__s2member_mms_options_patch_files" id="ws-plugin--s2member-mms-options-patch-files" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-mms-options-patch-files")) . '" /> ( automatically patch WordPress® for me )</label>' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '</div>' . "\n";
				/**/
				do_action ("ws_plugin__s2member_during_mms_options_page_during_left_sections_after_mms_patches", get_defined_vars ());
			}
		/**/
		if (apply_filters ("ws_plugin__s2member_during_mms_options_page_during_left_sections_display_mms_registration", true, get_defined_vars ()))
			{
				do_action ("ws_plugin__s2member_during_mms_options_page_during_left_sections_before_mms_registration", get_defined_vars ());
				/**/
				echo '<div class="ws-menu-page-group" title="Multisite Registration Configuration" default-state="open">' . "\n";
				/**/
				echo '<div class="ws-menu-page-section ws-plugin--s2member-mms-registration-section">' . "\n";
				echo '<img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="float:right; margin:0 0 0 25px; border:0;" />' . "\n";
				echo '<h3>Multisite Registration ( Main Site Configuration )</h3>' . "\n";
				echo '<p>s2Member supports Free Subscribers ( at Level #0 ), along with four Primary Levels [1-4] of paid Membership. If you want your visitors to be capable of registering absolutely free, you will want to "allow" Open Registration. Whenever a visitor registers without paying, they\'ll automatically become a Free Subscriber, at Level #0. &nbsp;&nbsp;<strong>With Multisite Networking enabled</strong>, your ( Main Site ) could ALSO offer a Customer access to create a Blog of their own, where a Customer becomes a "Member" of your ( Main Site ), and also a Blog Owner/Administrator. With s2Member installed ( network wide ), each of your Blog Owners could offer Membership too, using a single copy of the s2Member plugin ( which is a great selling point<em>!</em> ). We refer to this as a Multisite Blog Farm.</p>' . "\n";
				echo '<p>Multisite Networking also makes a new Registration Form available ( driven by your theme ); which we refer to as ( <code>wp-signup.php</code> ). If you\'re planning to offer Blogs, you MUST use <a href="' . apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php") . '" target="_blank" rel="external">wp-signup.php</a>, instead of using the Standard Login/Registration Form. In a Multisite installation, we refer to the Standard Login/Registration Form, as ( <code>wp-login.php?action=register</code> ). If you\'re planning to offer Membership Access only, and NOT Blogs, you can just use the <a href="' . add_query_arg ("action", urlencode ("register"), wp_login_url ()) . '" target="_blank" rel="external">Standard Login/Registration Form</a>, which is easily customized through <code>s2Member -> General Options -> Login/Registration Design</code>.</p>' . "\n";
				do_action ("ws_plugin__s2member_during_mms_options_page_during_left_sections_during_mms_registration", get_defined_vars ());
				echo '<div id="ws-plugin--s2member-mms-registration-support-package-details-wrapper">' . "\n";
				echo '<h3>Running a Multisite Blog Farm? ( <a href="#" onclick="jQuery(\'div#ws-plugin--s2member-mms-registration-support-package-details\').toggle(); return false;" class="ws-dotted-link">please read</a> )</h3>' . "\n";
				echo '<div id="ws-plugin--s2member-mms-registration-support-package-details" style="display:none;">' . "\n";
				echo '<p>( <em>Highly recommended!</em> ) <strong>Before you go live</strong>, please contact <a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank" rel="external">s2Member.com</a> for full documentation. There is some additional functionality that can be enabled for security on a Blog Farm installation; and also some menus/documentation/functionality that can be disabled. NOTE ~ You will be asked to make a <a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank" rel="external">donation</a>, or to purchase a <a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank" rel="external">Support Package</a> for s2Member.</p>' . "\n";
				echo '</div>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '<table class="form-table">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th>' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-file">' . "\n";
				echo 'What Do You Plan To Offer? ( please choose one )' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				/**/
				if (defined ("MULTISITE_FARM") && MULTISITE_FARM) /* Lock this down if a config option is set in /wp-config.php. */
					{
						echo '<select name="ws_plugin__s2member_mms_registration_file" id="ws-plugin--s2member-mms-registration-file" disabled="disabled">' . "\n";
						echo '<option value="wp-signup" selected="selected">Blog Farm ( I plan to offer both Membership &amp; Blog creation )</option>' . "\n";
						echo '</select><br />' . "\n";
						echo 'This is now locked. Your /wp-config.php file says: <code>MULTISITE_FARM = true</code>.' . "\n";
					}
				else
					{
						echo '<select name="ws_plugin__s2member_mms_registration_file" id="ws-plugin--s2member-mms-registration-file">' . "\n";
						echo '<option value="wp-login"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-login") ? ' selected="selected"' : '') . '>Membership Only ( I\'m NOT offering Blogs )</option>' . "\n";
						echo '<option value="wp-signup"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup") ? ' selected="selected"' : '') . '>Blog Farm ( I plan to offer both Membership &amp; Blog creation )</option>' . "\n";
						echo '</select><br />' . "\n";
						echo 'Depending on your selection, the options below may change.' . "\n";
					}
				/**/
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				/**/
				echo '<div class="ws-menu-page-hr"></div>' . "\n";
				/**/
				echo '<table class="form-table ws-plugin--s2member-mms-registration-wp-login" style="margin:0;">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th style="padding-top:0;">' . "\n";
				echo '<label for="ws-plugin--s2member-allow-subscribers-in">' . "\n";
				echo 'Your Main Site / Allow Open Registration? ( via <code>wp-login.php?action=register</code> )' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<select name="ws_plugin__s2member_allow_subscribers_in" id="ws-plugin--s2member-allow-subscribers-in">' . "\n";
				echo '<option value="0"' . ( (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"]) ? ' selected="selected"' : '') . '>No ( do NOT allow Open Registration )</option>' . "\n";
				echo '<option value="1"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"]) ? ' selected="selected"' : '') . '>Yes ( allow Open Registration; Free Subscribers at Level #0 )</option>' . "\n";
				echo '</select><br />' . "\n";
				echo 'If you set this to <code>Yes</code>, you\'re unlocking <a href="' . add_query_arg ("action", urlencode ("register"), wp_login_url ()) . '" target="_blank" rel="external">wp-login.php?action=register</a> ( on your Main Site ). When a visitor registers without paying, they\'ll automatically become a Free Subscriber, at Level #0. The s2Member software reserves Level #0; to be used ONLY for Free Subscribers. All other Membership Levels [1-4] require payment.' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				/**/
				echo '<table class="form-table ws-plugin--s2member-mms-registration-wp-signup" style="margin:0;">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th style="padding-top:0;">' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-grants">' . "\n";
				echo 'Your Main Site / Allow Open Registration? ( via <code>wp-signup.php</code> )' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td style="padding-bottom:0;">' . "\n";
				echo '<select name="ws_plugin__s2member_mms_registration_grants" id="ws-plugin--s2member-mms-registration-grants">' . "\n";
				echo '<option value="none"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_grants"] === "none") ? ' selected="selected"' : '') . '>No ( do NOT allow Open Registration )</option>' . "\n";
				echo '<option value="user"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_grants"] === "user") ? ' selected="selected"' : '') . '>Yes ( allow Open Registration; Free Subscribers at Level #0 )</option>' . "\n";
				echo '<option value="all"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_grants"] === "all") ? ' selected="selected"' : '') . '>Yes ( allow Open Registration; Free Subscribers, with a free Blog too )</option>' . "\n";
				echo '</select><br />' . "\n";
				echo 'If you set this to <code>Yes</code>, you\'re unlocking <a href="' . apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php") . '" target="_blank" rel="external">wp-signup.php</a> ( on your Main Site ).' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				/**/
				echo '<table class="form-table ws-plugin--s2member-mms-registration-wp-signup ws-plugin--s2member-mms-registration-wp-signup-blogs-level0">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th>' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-blogs-level0">' . "\n";
				echo 'Level #0 ( Free Subscribers ):' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td style="padding-bottom:0;">' . "\n";
				echo '<input type="text" name="ws_plugin__s2member_mms_registration_blogs_level0" id="ws-plugin--s2member-mms-registration-blogs-level0" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level0"]) . '" /><br />' . "\n";
				echo 'How many blogs can a Free Subscriber create?' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				/**/
				echo '<div class="ws-menu-page-hr ws-plugin--s2member-mms-registration-wp-signup"></div>' . "\n";
				/**/
				echo '<table class="form-table ws-plugin--s2member-mms-registration-wp-signup" style="margin:0;">' . "\n";
				echo '<tbody>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th style="padding-top:0;">' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-blogs-level1">' . "\n";
				echo 'Membership Level #1 / Maximum Blogs Allowed:' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<input type="text" name="ws_plugin__s2member_mms_registration_blogs_level1" id="ws-plugin--s2member-mms-registration-blogs-level1" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level1"]) . '" /><br />' . "\n";
				echo 'How many blogs can a Member ( at Level #1 ) create?' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th>' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-blogs-level2">' . "\n";
				echo 'Membership Level #2 / Maximum Blogs Allowed:' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<input type="text" name="ws_plugin__s2member_mms_registration_blogs_level2" id="ws-plugin--s2member-mms-registration-blogs-level2" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level2"]) . '" /><br />' . "\n";
				echo 'How many blogs can a Member ( at Level #2 ) create?' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th>' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-blogs-level3">' . "\n";
				echo 'Membership Level #3 / Maximum Blogs Allowed:' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<input type="text" name="ws_plugin__s2member_mms_registration_blogs_level3" id="ws-plugin--s2member-mms-registration-blogs-level3" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level3"]) . '" /><br />' . "\n";
				echo 'How many blogs can a Member ( at Level #3 ) create?' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<th>' . "\n";
				echo '<label for="ws-plugin--s2member-mms-registration-blogs-level4">' . "\n";
				echo 'Membership Level #4 / Maximum Blogs Allowed:' . "\n";
				echo '</label>' . "\n";
				echo '</th>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '<tr>' . "\n";
				/**/
				echo '<td>' . "\n";
				echo '<input type="text" name="ws_plugin__s2member_mms_registration_blogs_level4" id="ws-plugin--s2member-mms-registration-blogs-level4" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level4"]) . '" /><br />' . "\n";
				echo 'How many blogs can a Member ( at Level #4 ) create?' . "\n";
				echo '</td>' . "\n";
				/**/
				echo '</tr>' . "\n";
				echo '</tbody>' . "\n";
				echo '</table>' . "\n";
				echo '</div>' . "\n";
				/**/
				echo '</div>' . "\n";
				/**/
				do_action ("ws_plugin__s2member_during_mms_options_page_during_left_sections_after_mms_registration", get_defined_vars ());
			}
		do_action ("ws_plugin__s2member_during_mms_options_page_after_left_sections", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>' . "\n";
		/**/
		echo '</form>' . "\n";
	}
else /* Otherwise, we can display a simple notation; leading into Multisite Networking. */
	{
		echo '<p style="margin-top:0;"><span class="ws-menu-page-hilite">Your WordPress® installation does not have Multisite Networking enabled.<br />Which is perfectly OK :-) Multisite Networking is 100% completely optional.</span></p>' . "\n";
		echo '<img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="float:right; margin:0 0 0 25px; border:0;" />' . "\n";
		/**/
		if (file_exists ($ws_plugin__s2member_temp = dirname (dirname (dirname (__FILE__))) . "/ms.txt"))
			{
				echo '<div class="ws-menu-page-hr"></div>' . "\n";
				/**/
				if (!function_exists ("NC_Markdown"))
					include_once dirname (dirname (__FILE__)) . "/markdown/nc-markdown.inc.php";
				/**/
				$ws_plugin__s2member_temp = file_get_contents ($ws_plugin__s2member_temp);
				$ws_plugin__s2member_temp = preg_replace ("/(\=)( )(.+?)( )(\=)/", "<h3>$3</h3>", $ws_plugin__s2member_temp);
				$ws_plugin__s2member_temp = NC_Markdown ($ws_plugin__s2member_temp);
				/**/
				echo preg_replace ("/(\<a)( href)/i", "$1" . ' target="_blank" rel="nofollow external"' . "$2", $ws_plugin__s2member_temp);
			}
	}
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_mms_options_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_mms_options_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>