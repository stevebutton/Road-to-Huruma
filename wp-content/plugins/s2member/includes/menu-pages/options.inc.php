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
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member General Options</h2>' . "\n";
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
do_action ("ws_plugin__s2member_during_options_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_security", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_security", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Security Encryption Key">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-security-section">' . "\n";
		echo '<img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="float:right; margin:0 0 0 25px; border:0;" />' . "\n";
		echo '<h3>Security Encryption Key ( optional, for tighter security )</h3>' . "\n";
		echo '<p>Just like WordPress®, s2Member is open-source software. Which is wonderful. However, this also makes it possible for anyone to grab a copy of the software, and try to learn their way around its security measures. In order to keep your installation of s2Member unique/secure, you should configure a Security Encryption Key. s2Member will use your Security Encryption Key to protect itself against hackers. It does this by encrypting all sensitive information with your Key. A Security Encryption Key is unique to your installation.</p>' . "\n";
		echo '<p>Once you configure this, you do NOT want to change it; not ever. In fact, it is a VERY good idea to keep this backed up in a safe place, just in case you need to move your site, or re-install s2Member in the future. Some of the sensitive data that s2Member stores, will be encrypted with this Key. If you change it, that data can no longer be read, even by s2Member itself. In other words, don\'t use s2Member for six months, then decide to change your Key. That would break your installation. You configure this once, for each installation of s2Member; and you NEVER change it.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_security", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-sec-encryption-key">' . "\n";
		echo 'Security Encryption Key:' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? ' ( <a href="#" onclick="ws_plugin__s2member_enableSecurityKey();" title="( not recommended )">edit key</a> )' : ' ( <a href="#" onclick="ws_plugin__s2member_generateSecurityKey();" title="Insert an auto-generated Key. ( recommended )">auto-generate</a> )') . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_sec_encryption_key" id="ws-plugin--s2member-sec-encryption-key" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) . '" maxlength="256" autocomplete="off"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? ' disabled="disabled"' : '') . ' />' . "\n";
		echo (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"]) ? '<br />This may contain letters, numbers, spaces; even punctuation. Up to 256 characters.<br /><em>Ex: <code>' . esc_html (strtoupper (ws_plugin__s2member_random_str_gen (56))) . '</code></em>' . "\n" : '';
		echo (count ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]) > 1) ? '<br /><a href="#" onclick="ws_plugin__s2member_securityKeyHistory();">Click here</a> for a history of your last 10 Encryption Keys.<div id="ws-plugin--s2member-sec-encryption-key-history" style="display:none;"><code>' . implode ('</code><br /><code>', $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key_history"]) . '</code></div>' . "\n" : '';
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_security", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_email_config", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_email_config", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Email Configuration">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-email-section">' . "\n";
		echo '<h3>EMail From: ' . esc_html ('"Name" <address>') . '</h3>' . "\n";
		echo '<p>This is the name/address that will appear in outgoing email notifications sent by the s2Member plugin.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_email_config", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-reg-email-from-name">' . "\n";
		echo 'EMail From Name:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_reg_email_from_name" id="ws-plugin--s2member-reg-email-from-name" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . '" /><br />' . "\n";
		echo 'We recommend that you use the name of your site here.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-reg-email-from-email">' . "\n";
		echo 'EMail From Address:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_reg_email_from_email" id="ws-plugin--s2member-reg-email-from-email" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]) . '" /><br />' . "\n";
		echo 'We recommend something like: support@your-domain.com.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_email_config", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_open_registration", (!is_multisite () || !is_main_site ()), get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_open_registration", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Open Registration / Free Subscribers">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-open-registration-section">' . "\n";
		echo '<h3>Open Registration / Free Subscribers ( optional )</h3>' . "\n";
		echo '<p>s2Member supports Free Subscribers ( at Level #0 ), along with four Primary Levels [1-4] of paid Membership. If you want your visitors to be capable of registering absolutely free, you will want to "allow" Open Registration. Whenever a visitor registers without paying, they\'ll automatically become a Free Subscriber, at Level #0.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_open_registration", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-allow-subscribers-in">' . "\n";
		echo 'Allow Open Registration? ( Free Subscribers )' . "\n";
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
		echo 'If you set this to <code>Yes</code>, you\'re unlocking <a href="' . add_query_arg ("action", urlencode ("register"), wp_login_url ()) . '" target="_blank" rel="external">wp-login.php?action=register</a>. When a visitor registers without paying, they\'ll automatically become a Free Subscriber, at Level #0. The s2Member software reserves Level #0; to be used ONLY for Free Subscribers. All other Membership Levels [1-4] require payment.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_open_registration", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_membership_levels", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_membership_levels", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Membership Levels/Labels">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-levels-section">' . "\n";
		echo '<h3>Membership Levels ( required, please customize these )</h3>' . "\n";
		echo '<p>The default Membership Levels are labeled generically; feel free to modify them as needed. s2Member supports Free Subscribers ( at Level #0 ), along with four Primary Levels [1-4] of paid Membership; plus unlimited Custom Capability packages. That being said, you don\'t have to use all of the Membership Levels if you don\'t want to. To use only 1 or 2 of these Levels, just create and/or modify your Membership Options Page, so that it only includes PayPal® Subscription Buttons for the Levels you wish to use.</p>' . "\n";
		echo (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()) ? '<p><em>Support for Custom Capabilities is available. If you\'re an advanced site owner, a theme designer, or a web developer integrating s2Member for a client, please see: <code>s2Member -> API Scripting -> Custom Capabilities</code></em></p>' . "\n" : '';
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_membership_levels", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-label">' . "\n";
		echo 'Level #0 ( Free Subscribers ):' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level0_label" id="ws-plugin--s2member-level0-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"]) . '" /><br />' . "\n";
		echo 'This is the Label for Level 0 ( reserved for Free Subscribers ).<br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-label">' . "\n";
		echo 'Membership Level #1 Label:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level1_label" id="ws-plugin--s2member-level1-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]) . '" /><br />' . "\n";
		echo 'This is the Label for Membership Level 1.<br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-label">' . "\n";
		echo 'Membership Level #2 Label:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level2_label" id="ws-plugin--s2member-level2-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]) . '" /><br />' . "\n";
		echo 'This is the Label for Membership Level 2.<br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-label">' . "\n";
		echo 'Membership Level #3 Label:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level3_label" id="ws-plugin--s2member-level3-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]) . '" /><br />' . "\n";
		echo 'This is the Label for Membership Level 3.<br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-label">' . "\n";
		echo 'Membership Level #4 Label:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level4_label" id="ws-plugin--s2member-level4-label" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]) . '" /><br />' . "\n";
		echo 'This is the Label for Membership Level 4.<br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_membership_levels", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_login_registration", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_login_registration", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Login/Registration Design">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-login-registration-section">' . "\n";
		echo '<h3>Login/Registration Page Customization ( required )</h3>' . "\n";
		echo '<p>These settings allow you to customize the user interface for your Login / Registration Pages:<br />( <a href="' . add_query_arg ("action", urlencode ("register"), wp_login_url ()) . '" target="_blank" rel="external">' . esc_html (add_query_arg ("action", urlencode ("register"), wp_login_url ())) . '</a> )</p>' . "\n";
		echo (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ()) ? '<p><em>A Multisite Blog Farm uses this Form instead, powered by your theme.<br />( <a href="' . apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php") . '" target="_blank" rel="external">' . esc_html (apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php")) . '</a> )</em></p>' . "\n" : '';
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_login_registration", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<h3>Overall Font/Size Configuration</h3>' . "\n";
		echo '<p>These settings are all focused on your Login/Registration Fonts.</p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-font-size">' . "\n";
		echo 'Overall Font Size:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_font_size" id="ws-plugin--s2member-login-reg-font-size" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_size"]) . '" /><br />' . "\n";
		echo 'Set this to a numeric value, calculated in pixels.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-font-family">' . "\n";
		echo 'Overall Font Family:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_font_family" id="ws-plugin--s2member-login-reg-font-family" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_family"]) . '" /><br />' . "\n";
		echo 'Set this to a web-safe font family.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-font-field-size">' . "\n";
		echo 'Form Field Font Size:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_font_field_size" id="ws-plugin--s2member-login-reg-font-field-size" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_field_size"]) . '" /><br />' . "\n";
		echo 'Set this to a numeric value, calculated in pixels.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<h3>Background Configuration</h3>' . "\n";
		echo '<p>These settings are all focused on your Login/Registration Background.</p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-background-color">' . "\n";
		echo 'Background Color:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_background_color" id="ws-plugin--s2member-login-reg-background-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"]) . '" /><br />' . "\n";
		echo 'Set this to a 6-digit hex color code.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-background-image">' . "\n";
		echo 'Background Image:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_background_image" id="ws-plugin--s2member-login-reg-background-image" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"]) . '" /><br />' . "\n";
		echo '<input type="button" id="ws-plugin--s2member-login-reg-background-image-media-btn" value="Open Media Library" class="ws-menu-page-media-btn" rel="ws-plugin--s2member-login-reg-background-image" />' . "\n";
		echo 'Set this to the URL of your Background Image. ( this is optional )<br />';
		echo 'If supplied, your Background Image will be tiled.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-background-image-repeat">' . "\n";
		echo 'Background Image Tile:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_login_reg_background_image_repeat" id="ws-plugin--s2member-login-reg-background-image-repeat">' . "\n";
		echo '<option value="repeat"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "repeat") ? ' selected="selected"' : '') . '>Seamless Tile ( background-repeat: repeat; )</option>' . "\n";
		echo '<option value="repeat-x"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "repeat-x") ? ' selected="selected"' : '') . '>Tile Horizontally ( background-repeat: repeat-x; )</option>' . "\n";
		echo '<option value="repeat-y"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "repeat-y") ? ' selected="selected"' : '') . '>Tile Vertically ( background-repeat: repeat-y; )</option>' . "\n";
		echo '<option value="no-repeat"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] === "no-repeat") ? ' selected="selected"' : '') . '>No Tiles ( background-repeat: no-repeat; )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'This controls the way your Background Image is styled with CSS. [ <a href="http://www.w3schools.com/css/pr_background-repeat.asp" target="_blank" rel="external">learn more</a> ]' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-background-text-color">' . "\n";
		echo 'Color of Text on top of your Background:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_background_text_color" id="ws-plugin--s2member-login-reg-background-text-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_color"]) . '" /><br />' . "\n";
		echo 'Set this to a 6-digit hex color code.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-background-text-shadow-color">' . "\n";
		echo 'Shadow Color for Text on top of your Background:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_background_text_shadow_color" id="ws-plugin--s2member-login-reg-background-text-shadow-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_shadow_color"]) . '" /><br />' . "\n";
		echo 'Set this to a 6-digit hex color code.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-background-box-shadow-color">' . "\n";
		echo 'Shadow Color for Boxes on top of your Background:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_background_box_shadow_color" id="ws-plugin--s2member-login-reg-background-box-shadow-color" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"]) . '" /><br />' . "\n";
		echo 'Set this to a 6-digit hex color code.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<h3>Logo Image Configuration</h3>' . "\n";
		echo '<p>These settings are all focused on your Login/Registration Logo.</p>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-logo-src">' . "\n";
		echo 'Logo Image Location:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_src" id="ws-plugin--s2member-login-reg-logo-src" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src"]) . '" /><br />' . "\n";
		echo '<input type="button" id="ws-plugin--s2member-login-reg-logo-src-media-btn" value="Open Media Library" class="ws-menu-page-media-btn" rel="ws-plugin--s2member-login-reg-logo-src" />' . "\n";
		echo 'Set this to the URL of your Logo Image.<br />' . "\n";
		echo 'Suggested size is around 500 x 100.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-logo-src-width">' . "\n";
		echo 'Logo Image Width:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_src_width" id="ws-plugin--s2member-login-reg-logo-src-width" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_width"]) . '" /><br />' . "\n";
		echo 'The pixel Width of your Logo Image. <em>* This ALSO affects the overall width of your Login/Registration forms. If you want wider form fields, use a wider Logo.</em>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-logo-src-height">' . "\n";
		echo 'Logo Image Height:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_src_height" id="ws-plugin--s2member-login-reg-logo-src-height" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_height"]) . '" /><br />' . "\n";
		echo 'The pixel Height of your Logo Image.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-logo-url">' . "\n";
		echo 'Logo Image Click URL:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_url" id="ws-plugin--s2member-login-reg-logo-url" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_url"]) . '" /><br />' . "\n";
		echo 'Set this to the Click URL for your Logo Image.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-reg-logo-title">' . "\n";
		echo 'Logo Image Title Attribute:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_reg_logo_title" id="ws-plugin--s2member-login-reg-logo-title" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_title"]) . '" /><br />' . "\n";
		echo 'Used as the <code>title=""</code> attribute for your Logo Image.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_login_registration", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_custom_reg_fields", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_custom_reg_fields", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Custom Registration Fields">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-custom-reg-fields-section">' . "\n";
		echo '<h3>Custom Registration Fields ( optional, for further customization )</h3>' . "\n";
		echo '<p>Some fields are already built-in by default. The defaults are: <code>*Username*, *Email*, *First Name*, *Last Name*</code>.</p>' . "\n";
		/**/
		echo '<p>Custom Fields will appear in your Standard Registration Form:<br />( <a href="' . add_query_arg ("action", urlencode ("register"), wp_login_url ()) . '" target="_blank" rel="external">' . esc_html (add_query_arg ("action", urlencode ("register"), wp_login_url ())) . '</a> )</p>' . "\n";
		echo (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ()) ? '<p><em>A Multisite Blog Farm uses this Form instead. It supports Custom Fields too.<br />( <a href="' . apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php") . '" target="_blank" rel="external">' . esc_html (apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php")) . '</a> )</em></p>' . "\n" : '';
		/**/
		if (defined ("BP_VERSION"))
			echo '<p><em class="ws-menu-page-hilite">* With BuddyPress installed, Custom Registration Fields are NOT applicable. BuddyPress themes usually come with their own Registration Form ( i.e. BuddyPress redirects you away from the default Registration Form, over to a special <code>/register</code> page ); BuddyPress also has its own Profile Field Configuration Tool, under <code>BuddyPress -> Profile Field Setup</code>. When BuddyPress is installed, the use of s2Member\'s Custom Fields is not advised; that is... UNLESS you\'re using the s2Member Pro Module. With the s2Member Pro Module, Custom Fields <strong>will</strong> be included in all PayPal® Pro Forms, including even Free Registration Forms generated by the s2Member Pro Module.</em></p>' . "\n";
		/**/
		if (!function_exists ("ws_plugin__s2member_generate_password"))
			echo '<p><em class="ws-menu-page-error">* Custom Passwords CANNOT be used with your installation of s2Member. This is due to a minor conflict with another plugin that is using <code>wp_generate_password()</code>. If you really want to allow Custom Passwords during registration, please disable some of your other plugins until this warning goes away.</em></p>' . "\n";
		/**/
		if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site () && !$GLOBALS["WS_PLUGIN__"]["s2member_pro"])
			echo '<p><em>* For security purposes, Custom Passwords are NOT possible on the Main Site of a Blog Farm. A User MUST wait for the activation/confirmation email; where a randomly generated password will be assigned. Please note... this limitation only affects your Main Site, via <code>/wp-signup.php</code>. In other words, your Customers ( i.e. other Blog Owners ) will still have the ability to allow Custom Passwords with s2Member. YOU are affected by this limitation, NOT them. * NOTE: s2Member (Pro) removes this limitation. If you install the s2Member Pro Module, you WILL be able to allow Custom Passwords; even on a Multisite Blog Farm.</em></p>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_custom_reg_fields", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label>' . "\n";
		echo 'Custom Registration Fields:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="hidden" name="ws_plugin__s2member_custom_reg_fields" id="ws-plugin--s2member-custom-reg-fields" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) . '" />' . "\n";
		echo '<div id="ws-plugin--s2member-custom-reg-field-configuration"></div>' . "\n"; /* This is filled by JavaScript routines. */
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-custom-reg-password">' . "\n";
		echo 'Allow Custom Passwords during Registration?' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_custom_reg_password" id="ws-plugin--s2member-custom-reg-password"' . ( (!function_exists ("ws_plugin__s2member_generate_password") || (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site () && !$GLOBALS["WS_PLUGIN__"]["s2member_pro"])) ? ' disabled="disabled"' : '') . '>' . "\n";
		echo '<option value="0"' . ( (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>No ( send auto-generated passwords via email; after registration )</option>' . "\n";
		echo '<option value="1"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) ? ' selected="selected"' : '') . '>Yes ( allow members to create their own password during registration )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Auto-generated Passwords are recommended for best security; because, this also serves as a form of email confirmation.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_custom_reg_fields", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_login_welcome_page", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_login_welcome_page", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Login Welcome Page">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-login-welcome-page-section">' . "\n";
		echo '<h3>Login Welcome Page ( required, please customize this )</h3>' . "\n";
		echo '<p>Please create and/or choose an existing Page to use as the first page Members will see after logging in.</p>' . "\n";
		echo '<p><em><strong>*Tip*</strong> This special Page will be protected from public access ( automatically ) by s2Member.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_login_welcome_page", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-login-welcome-page">' . "\n";
		echo 'Login Welcome Page:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_login_welcome_page" id="ws-plugin--s2member-login-welcome-page">' . "\n";
		echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
		foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
			echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . ( (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && $ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Please choose a Page to be used as the first page Members will see after logging in. This Page can contain anything you like. We recommend the following title: <code>Welcome To Our Members Area</code>.<br /><br />' . "\n";
		echo '&darr; Or, you may configure a Special Redirection URL, if you prefer. You\'ll need to type in the full URL, starting with: <code>http://</code>. <em>A few <a href="#" onclick="alert(\'Replacement Codes:\\n\\n%%current_user_login%% = The current User\\\'s login ( their Username, lowercase ).\\n%%current_user_id%% = The current User\\\'s ID.\\n%%current_user_level%% = The current User\\\'s s2Member Level.\\n%%current_user_role%% = The current User\\\'s WordPress® Role.\\n\\nFor example, if you\\\'re using BuddyPress, and you want to redirect Members to their BuddyPress Profile page after logging in, you would setup a Special Redirection URL, like this: ' . get_bloginfo ("wpurl") . '/members/%%current_user_login%%/profile/\\n\\nOr ... using %%current_user_level%%, you could have a separate Login Welcome Page for each Membership Level that you plan to offer. BuddyPress not required.\'); return false;">Replacement Codes</a> are also supported here.</em>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_login_redirection_override" id="ws-plugin--s2member-login-redirection-override" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"]) . '" /><br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_login_welcome_page", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_membership_options_page", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_membership_options_page", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Membership Options Page">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-membership-options-page-section">' . "\n";
		echo '<h3>Membership Options Page ( required, please customize this )</h3>' . "\n";
		echo '<p>Please create and/or choose an existing Page that showcases your Membership subscription options. This special Page is where you will insert the PayPal® Subscription Buttons generated for you by s2Member. This Page serves as your signup page. It should detail all of the features that come with Membership to your site, and provide a PayPal® Subscription Button for each Level of access you plan to offer. This is also the page that Users will be redirected to, should they attempt to access an area of your site that requires Membership.</p>' . "\n";
		echo '<p><em><strong>*Tip*</strong> s2Member will NEVER allow this Page to be protected from public access.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_membership_options_page", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-membership-options-page">' . "\n";
		echo 'Membership Options Page:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_membership_options_page" id="ws-plugin--s2member-membership-options-page">' . "\n";
		echo '<option value="">&mdash; Select &mdash;</option>' . "\n";
		foreach (($ws_plugin__s2member_temp_a = array_merge ((array)get_pages ())) as $ws_plugin__s2member_temp_o)
			echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '"' . ( ($ws_plugin__s2member_temp_o->ID == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) ? ' selected="selected"' : '') . '>' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Please choose a Page that provides Users a way to signup for Membership. This Page should also contain your PayPal&reg Subscription button(s). We recommend the following title: <code>Membership Signup</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_membership_options_page", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_post_level_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_post_level_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Post Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-post-level-access-section">' . "\n";
		echo '<h3>Post Level Access Restrictions ( optional )</h3>' . "\n";
		echo '<p>Here you can specify Posts that are restricted to certain Membership Access Levels. s2Member also supports Custom Post Types here, which were first introduced in WordPress® 3.0. If you have a theme or plugin installed, that has enabled Custom Post Types ( i.e. Music/Videos or something else ), you can put the IDs for those Posts here.</p>' . "\n";
		echo '<p><em><strong>*Note*</strong> Protecting individual Posts, ONLY protects the Permalinks for those Posts. It is still possible for excerpts of protected content to be seen in search results generated by WordPress®, feeds, and Archive views; such as your Home Page, inside a Category listing, or through other queries formulated by your theme. This is the intended functionality. Excerpts are a great way to "tease" public visitors. In other words, public visitors may have access to excerpts introduced by your theme, but any attempt to view the full Post ( i.e. the Permalink ) will result in an automatic redirect to your Membership Options Page; requiring registration. All of that being said, if you would like to protect many Posts at once ( including Archive views ), you can use Category Level Restrictions, Tag Level Restrictions, or have a look down below at s2Member\'s options for "Alternative View Protection", which deals with search results, as well as feeds.</em></p>' . "\n";
		echo ( (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()) && !$GLOBALS["WS_PLUGIN__"]["wp_show_ids"]) ? '<p><em><strong>*Tip*</strong> Can\'t find your Post IDs? Get <a href="http://www.primothemes.com/post/product/wp-show-ids-plugin/" target="_blank" rel="external">WP Show IDs</a>.</em></p>' . "\n" : '';
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_post_level_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-posts">' . "\n";
		echo 'Posts That Require Level #0 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level0_posts" id="ws-plugin--s2member-level0-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_posts"]) . '" /><br />' . "\n";
		echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-posts">' . "\n";
		echo 'Posts That Require Level #1 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level1_posts" id="ws-plugin--s2member-level1-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_posts"]) . '" /><br />' . "\n";
		echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-posts">' . "\n";
		echo 'Posts That Require Level #2 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level2_posts" id="ws-plugin--s2member-level2-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_posts"]) . '" /><br />' . "\n";
		echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-posts">' . "\n";
		echo 'Posts That Require Level #3 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level3_posts" id="ws-plugin--s2member-level3-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_posts"]) . '" /><br />' . "\n";
		echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-posts">' . "\n";
		echo 'Posts That Require Highest Level #4:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level4_posts" id="ws-plugin--s2member-level4-posts" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_posts"]) . '" /><br />' . "\n";
		echo 'Post IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_post_level_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_page_level_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_page_level_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Page Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-page-level-access-section">' . "\n";
		echo '<h3>Page Level Access Restrictions ( optional )</h3>' . "\n";
		echo '<p>Here you can specify Pages that are restricted to certain Membership Access Levels.</p>' . "\n";
		echo ( (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()) && !$GLOBALS["WS_PLUGIN__"]["wp_show_ids"]) ? '<p><em><strong>*Tip*</strong> Can\'t find your Page IDs? Get <a href="http://www.primothemes.com/post/product/wp-show-ids-plugin/" target="_blank" rel="external">WP Show IDs</a>.</em></p>' . "\n" : '';
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_page_level_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-pages">' . "\n";
		echo 'Pages That Require Level #0 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level0_pages" id="ws-plugin--s2member-level0-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_pages"]) . '" /><br />' . "\n";
		echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-pages">' . "\n";
		echo 'Pages That Require Level #1 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level1_pages" id="ws-plugin--s2member-level1-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"]) . '" /><br />' . "\n";
		echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-pages">' . "\n";
		echo 'Pages That Require Level #2 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level2_pages" id="ws-plugin--s2member-level2-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"]) . '" /><br />' . "\n";
		echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-pages">' . "\n";
		echo 'Pages That Require Level #3 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level3_pages" id="ws-plugin--s2member-level3-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"]) . '" /><br />' . "\n";
		echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-pages">' . "\n";
		echo 'Pages That Require Highest Level #4:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level4_pages" id="ws-plugin--s2member-level4-pages" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"]) . '" /><br />' . "\n";
		echo 'Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_page_level_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_tag_level_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_tag_level_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Tag Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-tag-level-access-section">' . "\n";
		echo '<h3>Tag Level Access Restrictions ( optional )</h3>' . "\n";
		echo '<p>Here you can specify Tags that are restricted to certain Membership Access Levels. This is very similar to Category Level Access. When you restrict access to a Tag Archive, it also restricts access to any Post having that Tag; even if a Post has other Tags. <em>*Tip*</em> ... Tags can be applied to any Post, without affecting your Category structure at all. If you\'d like to use Tags with Pages, get <a href="http://wordpress.org/extend/plugins/page-tagger/" target="_blank" rel="external">Page Tagger</a> <em>( compatible with s2Member )</em>.</p>' . "\n";
		echo '<p>Tags are caSe sensitive. The Tag <code>members only</code> is NOT the same as <code>Members Only</code>.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_tag_level_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-ptags">' . "\n";
		echo 'Tags That Require Level #0 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level0_ptags" id="ws-plugin--s2member-level0-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ptags"]) . '" /><br />' . "\n";
		echo 'Tags in comma delimited format. Example: <code>free,subscribers only</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-ptags">' . "\n";
		echo 'Tags That Require Level #1 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level1_ptags" id="ws-plugin--s2member-level1-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ptags"]) . '" /><br />' . "\n";
		echo 'Tags in comma delimited format. Example: <code>premium,members only</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-ptags">' . "\n";
		echo 'Tags That Require Level #2 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level2_ptags" id="ws-plugin--s2member-level2-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ptags"]) . '" /><br />' . "\n";
		echo 'Tags in comma delimited format. Example: <code>premium,members only</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-ptags">' . "\n";
		echo 'Tags That Require Level #3 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level3_ptags" id="ws-plugin--s2member-level3-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ptags"]) . '" /><br />' . "\n";
		echo 'Tags in comma delimited format. Example: <code>premium,members only</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-ptags">' . "\n";
		echo 'Tags That Require Highest Level #4:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level4_ptags" id="ws-plugin--s2member-level4-ptags" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ptags"]) . '" /><br />' . "\n";
		echo 'Tags in comma delimited format. Example: <code>premium,members only</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_tag_level_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_category_level_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_category_level_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Category Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-category-level-access-section">' . "\n";
		echo '<h3>Category Level Access Restrictions ( optional )</h3>' . "\n";
		echo '<p>Here you can specify Categories that are restricted to certain Membership Access Levels. Category restrictions are a bit more complex. When you restrict access to a Category, it also restricts access to any child Categories it may have ( aka: sub-Categories ). In other words, restricting a Category protects a Category Archive, all of its child Category Archives, and any Posts contained within the Category, or its child Categories.</p>' . "\n";
		echo ( (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()) && !$GLOBALS["WS_PLUGIN__"]["wp_show_ids"]) ? '<p><em><strong>*Tip*</strong> Can\'t find your Category IDs? Get <a href="http://www.primothemes.com/post/product/wp-show-ids-plugin/" target="_blank" rel="external">WP Show IDs</a>.</em></p>' . "\n" : '';
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_category_level_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-catgs">' . "\n";
		echo 'Categories That Require Level #0 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level0_catgs" id="ws-plugin--s2member-level0-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_catgs"]) . '" /><br />' . "\n";
		echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-catgs">' . "\n";
		echo 'Categories That Require Level #1 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level1_catgs" id="ws-plugin--s2member-level1-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_catgs"]) . '" /><br />' . "\n";
		echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-catgs">' . "\n";
		echo 'Categories That Require Level #2 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level2_catgs" id="ws-plugin--s2member-level2-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_catgs"]) . '" /><br />' . "\n";
		echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-catgs">' . "\n";
		echo 'Categories That Require Level #3 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level3_catgs" id="ws-plugin--s2member-level3-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_catgs"]) . '" /><br />' . "\n";
		echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-catgs">' . "\n";
		echo 'Categories That Require Highest Level #4:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_level4_catgs" id="ws-plugin--s2member-level4-catgs" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_catgs"]) . '" /><br />' . "\n";
		echo 'Category IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> — or you can type: <code>all</code>.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_category_level_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_uri_level_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_uri_level_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="URI Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-uri-level-access-section">' . "\n";
		echo '<h3>URI Level Access Restrictions ( optional )</h3>' . "\n";
		echo '<p>Here you can specify URIs ( or word fragments found in URIs ) that are restricted to certain Membership Access Levels. Control over URIs is a little more complex. This section is intended for advanced webmasters only. That being said, here are the basics... A REQUEST_URI, is the portion of the URL that comes after the domain. This is a URL <code>http://www.example.com/path/to/file.php</code>, and this is the URI: <code>/path/to/file.php</code>.</p>' . "\n";
		echo '<p>In the fields below, you can provide a list ( one per line ) of URIs on your site that should be off-limits based on Membership Level. You can also use word fragments instead of a full URI. If a word fragment is found anywhere in the URI, it will be protected. Wildcards and other regex patterns are not supported here, and therefore you don\'t need to escape special characters or anything. Please note, these ARE caSe sensitive. You must be specific with respect to case sensitivity. The word fragment <code>some-path/</code> would NOT match a URI that contains <code>some-Path/</code>. <em>A few <a href="#" onclick="alert(\'URI Replacement Codes:\\n\\n%%current_user_login%% = The current User\\\'s login ( their Username, lowercase ).\\n%%current_user_id%% = The current User\\\'s ID.\\n%%current_user_level%% = The current User\\\'s s2Member Level.\\n%%current_user_role%% = The current User\\\'s WordPress® Role.\\n\\nFor example, if you\\\'re using BuddyPress, and want to protect BuddyPress Groups, you could add URI protection, like this: /members/%%current_user_login%%/groups/\'); return false;">Replacement Codes</a> are also supported here.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_uri_level_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level0-ruris">' . "\n";
		echo 'URIs That Require Level #0 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<textarea name="ws_plugin__s2member_level0_ruris" id="ws-plugin--s2member-level0-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_ruris"]) . '</textarea><br />' . "\n";
		echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level1-ruris">' . "\n";
		echo 'URIs That Require Level #1 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<textarea name="ws_plugin__s2member_level1_ruris" id="ws-plugin--s2member-level1-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_ruris"]) . '</textarea><br />' . "\n";
		echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level2-ruris">' . "\n";
		echo 'URIs That Require Level #2 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<textarea name="ws_plugin__s2member_level2_ruris" id="ws-plugin--s2member-level2-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_ruris"]) . '</textarea><br />' . "\n";
		echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level3-ruris">' . "\n";
		echo 'URIs That Require Level #3 Or Higher:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<textarea name="ws_plugin__s2member_level3_ruris" id="ws-plugin--s2member-level3-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_ruris"]) . '</textarea><br />' . "\n";
		echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-level4-ruris">' . "\n";
		echo 'URIs That Require Highest Level #4:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<textarea name="ws_plugin__s2member_level4_ruris" id="ws-plugin--s2member-level4-ruris" rows="3" wrap="off" spellcheck="false">' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_ruris"]) . '</textarea><br />' . "\n";
		echo 'URIs and/or word fragments found in URIs. One per line please.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_uri_level_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_query_level_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_query_level_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Alternative View Protection">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-query-level-access-section">' . "\n";
		echo '<h3>Alternative View Protection ( optional / experimental )</h3>' . "\n";
		echo '<p>s2Member protects Categories, Tags, Posts, Pages, Files, URIs &amp; more. BUT, even with all of those security restrictions, it\'s still possible for protected content excerpts to be seen through XML feeds, in search results generated by WordPress®; and/or ( depending on your theme ), possibly in other Archive views; which might include: Posts by Author, Posts by Date, a list of featured items formulated by your theme, OR even through other widgets/plugins adding functionality to your site. ~ We refer to all of these collectively, as "Alternative Views".</p>' . "\n";
		echo '<p>Using the options below, you can tell s2Member to protect some ( or all ) of these "Alternative Views", by filtering WordPress® database queries for you. s2Member can automatically hide protected content that is NOT available to the current User/Member. In other words, s2Member is capable of pre-filtering ALL database queries, so that excerpts of protected content will not be allowed to slip through. This is marked "experimental", because we\'re still testing this against MANY widget/plugin/theme combinations. Please <a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank">report</a> all bugs.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_uri_level_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-filter-wp-query">' . "\n";
		echo 'Protect Alternative Views?' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_filter_wp_query" id="ws-plugin--s2member-filter-wp-query">' . "\n";
		echo '<option value="none"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"] === "none") ? ' selected="selected"' : '') . '>None ( do NOT filter any WordPress® queries )</option>' . "\n";
		echo '<option value="feeds"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"] === "feeds") ? ' selected="selected"' : '') . '>Feeds Only ( hide protected content in feeds only )</option>' . "\n";
		echo '<option value="searches"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"] === "searches") ? ' selected="selected"' : '') . '>Searches Only ( hide protected content in search results only )</option>' . "\n";
		echo '<option value="searches,feeds"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"] === "searches,feeds") ? ' selected="selected"' : '') . '>Searches &amp; Feeds Only ( hide protected content in search results &amp; feeds only )</option>' . "\n";
		echo '<option value="all"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"] === "all") ? ' selected="selected"' : '') . '>Yes ( filter ALL WordPress® queries; protecting all Alternative Views )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Attn Developers: Filters can be suppressed dynamically, using this technique:<br />' . "\n";
		echo '<code>query_posts(" ... &amp;suppress_filters=true");</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_query_level_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_sp_access", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_sp_access", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Specific Post/Page Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-access-section">' . "\n";
		echo '<h3>Specific Post/Page Access Restrictions ( optional )</h3>' . "\n";
		echo '<p>s2Member now supports an additional layer of functionality ( very powerful ), which allows you to sell access to specific Posts/Pages that you\'ve created in WordPress®. Specific Post/Page Access works independently from Member Level Access. That is, you can sell an unlimited number of Posts/Pages using "Buy Now" Buttons, and your Customers will NOT be required to have a Membership Account with your site in order to receive access. If they are already a Member, that\'s fine, but they won\'t need to be.</p>' . "\n";
		echo '<p>In other words, Customers will NOT need to login, just to receive access to the Specific Post/Page they purchased access to. s2Member will immediately redirect the Customer to the Specific Post/Page after checkout is completed successfully. An email is also sent to the Customer with a link ( see: <code>s2Member -> PayPal® Options -> Specific Post/Page Email</code> ). Authentication is handled automatically through self-expiring links, good for 72 hours by default.</p>' . "\n";
		echo '<p>Specific Post/Page Access, is sort of like selling a product. Only, instead of shipping anything to the Customer, you just give them access to a specific Post/Page on your site; one that you created in WordPress®. A Specific Post/Page that is protected by s2Member, might contain a download link for your eBook, access to file &amp; music downloads, access to additional support services, and the list goes on and on. The possibilities with this are endless; as long as your digital product can be delivered through access to a WordPress® Post/Page that you\'ve created.</p>' . "\n";
		echo '<p>Very simple. All you do is protect the Specific Post/Page IDs that are being sold on your site. Then, you can go to <code>s2Member -> PayPal® Buttons -> Specific Post/Page</code> to generate "Buy Now" Buttons that you can insert into your WordPress® Editor, and make available on your site. The Button Generator for s2Member, will even let you Package Additional Posts/Pages together into one transaction.</p>' . "\n";
		echo ( (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()) && !$GLOBALS["WS_PLUGIN__"]["wp_show_ids"]) ? '<p><em><strong>*Tip*</strong> Can\'t find your Post/Page IDs? Get <a href="http://www.primothemes.com/post/product/wp-show-ids-plugin/" target="_blank" rel="external">WP Show IDs</a>.</em></p>' . "\n" : '';
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_sp_access", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-specific-ids">' . "\n";
		echo 'Specific Post/Page IDs Being Sold On Your Site:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<input type="text" name="ws_plugin__s2member_specific_ids" id="ws-plugin--s2member-specific-ids" value="' . format_to_edit ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"]) . '" /><br />' . "\n";
		echo 'Post/Page IDs in comma delimited format. Example: <code>1,2,3,34,8,21</code> * Note... the word <code>all</code> does NOT work here. Also, please be careful not to create a conflict with other Access Restrictions. If you are going to sell Specific Post/Page Access, you should enter specific Post/Page IDs here; and <strong>make SURE that you\'ve NOT already protected any of these Posts/Pages with Member Level Access Restrictions</strong>. In other words, if you configure s2Member, in such as a way, that a Post/Page requires Membership Level Access, you cannot sell that same Post/Page through Specific Post/Page Access. Doing so, would create a conflict. Customers that purchased Specific Post/Page Access, would be unable to access the Post/Page - without also having a Membership. Not good. So be careful with this.' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_sp_access", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_ip_restrictions", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_ip_restrictions", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Unique IP Access Restrictions">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-ip-restrictions-section">' . "\n";
		echo '<h3>Unique IP Access Restrictions ( prevents username/link sharing )</h3>' . "\n";
		echo '<input type="button" id="ws-plugin--s2member-ip-restrictions-reset-button" value="Reset IP Restriction Logs" class="ws-menu-page-right" style="min-width:175px;" />' . "\n";
		echo '<p>As with any Membership system, it is possible for one Member to signup, and then share their Username with someone else; or even post it online for the whole world to see. This is known as Link Sharing ( aka: Username Sharing ). It is NOT likely that you\'ll be attacked in this way, but it\'s still a good idea to protect your system; just in case somebody tries this. s2Member\'s IP Restrictions work for Membership Level Access ( account logins ), Specific Post/Page Access, Registration Links, and other secure Entry Points. In all cases, the rules are simple. A single Username, Access Link, and/or Entry Point ... is only valid for a certain number of unique IP addresses. Once that limit is reached, s2Member assumes there has been a security breach. At that time, s2Member will place a temporary ban ( preventing access ) to a Specific Post/Page, or to an account associated with a particular Username. This temporary ban, will ONLY affect the offending Link and/or Username associated with the security breach. You can fine-tune this behavior, using the options below.</p>' . "\n";
		echo '<p><em>*Note* an empty IP address ( associated with someone browsing anonymously ), is also considered a unique IP address, so it cannot circumvent s2Member\'s security.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_ip_restrictions", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-max-ip-restriction">' . "\n";
		echo 'Maximum Unique IP Addresses Allowed:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_max_ip_restriction" id="ws-plugin--s2member-max-ip-restriction">' . "\n";
		$ws_plugin__s2member_temp_s = apply_filters ("ws_plugin__s2member_ip_restrictions__concurrency_time_per_ip", "30 days");
		echo '<option value="1"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 1) ? ' selected="selected"' : '') . '>Allow up to 1 unique IP per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="2"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 2) ? ' selected="selected"' : '') . '>Allow up to 2 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="3"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 3) ? ' selected="selected"' : '') . '>Allow up to 3 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="4"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 4) ? ' selected="selected"' : '') . '>Allow up to 4 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="5"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 5) ? ' selected="selected"' : '') . '>Allow up to 5 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="10"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 10) ? ' selected="selected"' : '') . '>Allow up to 10 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="20"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 20) ? ' selected="selected"' : '') . '>Allow up to 20 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="30"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 30) ? ' selected="selected"' : '') . '>Allow up to 30 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="40"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 40) ? ' selected="selected"' : '') . '>Allow up to 40 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="50"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 50) ? ' selected="selected"' : '') . '>Allow up to 50 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="75"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 75) ? ' selected="selected"' : '') . '>Allow up to 75 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="100"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 100) ? ' selected="selected"' : '') . '>Allow up to 100 different IPs per Customer ( every ' . $ws_plugin__s2member_temp_s . ' )</option>' . "\n";
		echo '<option value="0"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] == 0) ? ' selected="selected"' : '') . '>Allow infinite IPs ( all IP restrictions are effectively disabled )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'The default period of "30 days" could be modified through this WordPress® Filter:<br /><code>ws_plugin__s2member_ip_restrictions__concurrency_time_per_ip</code>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-max-ip-restriction-time">' . "\n";
		echo 'Security Breach Timeout Period:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_max_ip_restriction_time" id="ws-plugin--s2member-max-ip-restriction-time">' . "\n";
		echo '<option value="900"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 900) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 15 mins )</option>' . "\n";
		echo '<option value="1800"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 1800) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 30 mins )</option>' . "\n";
		echo '<option value="3600"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 3600) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 1 hour )</option>' . "\n";
		echo '<option value="7200"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 7200) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 2 hours )</option>' . "\n";
		echo '<option value="14400"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 14400) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 4 hours )</option>' . "\n";
		echo '<option value="21600"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 21600) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 6 hours )</option>' . "\n";
		echo '<option value="28800"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 28800) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 8 hours )</option>' . "\n";
		echo '<option value="43200"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 43200) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 12 hours )</option>' . "\n";
		echo '<option value="86400"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 86400) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 24 hours )</option>' . "\n";
		echo '<option value="172800"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 172800) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 2 days )</option>' . "\n";
		echo '<option value="345600"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 345600) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 4 days )</option>' . "\n";
		echo '<option value="604800"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 604800) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 1 week )</option>' . "\n";
		echo '<option value="1209600"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 1209600) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 2 weeks )</option>' . "\n";
		echo '<option value="2629743"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 2629743) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 1 month )</option>' . "\n";
		echo '<option value="5259487"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 5259487) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 2 months )</option>' . "\n";
		echo '<option value="7889231"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 7889231) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 3 months )</option>' . "\n";
		echo '<option value="15778463"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 15778463) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 6 months )</option>' . "\n";
		echo '<option value="31556926"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"] == 31556926) ? ' selected="selected"' : '') . '>If limit is exceeded ( punish for 1 year )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'When/if you change this, you should also <strong>Reset IP Restriction Logs</strong> ( click button above ).' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_ip_restrictions", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_profile_modifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_profile_modifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Member Profile Modifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-profile-modifications-section">' . "\n";
		echo '<h3>Giving Members The Ability To Modify Their Profile</h3>' . "\n";
		echo '<p>s2Member can be configured to redirect Members away from the <a href="profile.php" target="_blank" rel="external">default Profile Editing Panel</a> that is built into WordPress®. When/if a Member attempts to access the default Profile Editing Panel, they\'ll instead, be redirected to the Login Welcome Page that you\'ve configured through s2Member. <strong>Why would I redirect?</strong> Unless you\'ve made some drastic modifications to your WordPress® installation, the default Profile Editing Panel that ships with WordPress®, is NOT really suited for public access, even by a Member.</p>' . "\n";
		echo '<p>So instead of using this default Profile Editing Panel; s2Member creates an added layer of functionality, on top of WordPress®. It does this by providing you ( as the site owner ), with the ability to send your Members to a <a href="' . get_bloginfo ("wpurl") . '/?s2member_profile=1" target="_blank" rel="external">special Stand-Alone page</a>, where your Members can modify their entire Profile, including all Custom Fields, and their Password. This special Stand-Alone Editing Panel, has been designed ( with a bare-bones format ), intentionally. This makes it possible for you to <a href="#" onclick="if(!window.open(\'' . get_bloginfo ("wpurl") . '/?s2member_profile=1\', \'_popup\', \'height=350,width=400,left=100,screenX=100,top=100,screenY=100, location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1\')) alert(\'Please disable popup blockers and try again!\'); return false;" rel="external">open it up in a popup window</a>, or embed it into your Login Welcome Page using an IFRAME. Code samples are provided below.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_profile_modifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p>Stand-Alone page where Members can modify their Profile:<br />' . "\n";
		echo '<code><a href="' . get_bloginfo ("wpurl") . '/?s2member_profile=1" target="_blank" rel="external">' . get_bloginfo ("wpurl") . '/?s2member_profile=1</a></code></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Code Sample #1</strong> ( standard link tag ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", ws_plugin__s2member_esc_ds (get_bloginfo ("wpurl") . "/?s2member_profile=1"), file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-1-ops.php"))) . '</p>' . "\n";
		/**/
		echo '<p><strong>Code Sample #2</strong> ( open the link in a popup window ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", ws_plugin__s2member_esc_ds (get_bloginfo ("wpurl") . "/?s2member_profile=1"), file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2-ops.php"))) . '</p>' . "\n";
		/**/
		echo '<p><strong>Code Sample #3</strong> ( embed the form into a Post/Page using an IFRAME tag ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (preg_replace ("/\<\?php echo S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL; \?\>/", ws_plugin__s2member_esc_ds (get_bloginfo ("wpurl") . "/?s2member_profile=1"), file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-3-ops.php"))) . '</p>' . "\n";
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-force-admin-lockouts">' . "\n";
		echo 'Redirect Members away from the Default Profile Panel?' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_force_admin_lockouts" id="ws-plugin--s2member-force-admin-lockouts">' . "\n";
		echo '<option value="0"' . ( (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"]) ? ' selected="selected"' : '') . '>No ( I want to leave all options available to my Members )</option>' . "\n";
		echo '<option value="1"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"]) ? ' selected="selected"' : '') . '>Yes ( redirect Members to their Login Welcome Page )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Recommended setting ( <code>Yes</code> ). The Stand-Alone version is better.<br />' . "\n";
		echo 'You\'ll want to embed the Stand-Alone version into your Login Welcome Page.<br />' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_profile_modifications", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_options_page_during_left_sections_display_deactivation", (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site () || is_super_admin ()), get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_before_deactivation", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Deactivation Safeguards">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-deactivation-section">' . "\n";
		echo '<h3>Deactivation Safeguards ( optional, recommended )</h3>' . "\n";
		echo (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site () && is_super_admin ()) ? '<p><em class="ws-menu-page-hilite">On a Multisite Blog Farm, this panel is ONLY visible to YOU, as a Super Administrator. s2Member automatically Safeguards everything on a Multisite Blog Farm. However, as the Super Administrator, you may turn this off; on a per-Blog basis. For example, if you\'re going to de-activate s2Member on this particular Blog, you can turn OFF the Safeguards below, so that s2Member will completely erase itself.</em></p>' . "\n" : '<p>By default, s2Member will cleanup ( erase ) all of it\'s Roles, Capabilities, and your Configuration Options when/if you deactivate it from the Plugins Menu in WordPress®. If you would like to Safeguard all of this information, in case s2Member is deactivated inadvertently, please choose Yes ( safeguard all s2Member data/options ).</p>' . "\n";
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_during_deactivation", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws-plugin--s2member-run-deactivation-routines">' . "\n";
		echo 'Safeguard s2Member Data/Options?' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<select name="ws_plugin__s2member_run_deactivation_routines" id="ws-plugin--s2member-run-deactivation-routines">' . "\n";
		echo '<option value="1"' . ( ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' selected="selected"' : '') . '></option>' . "\n";
		echo '<option value="0"' . ( (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"]) ? ' selected="selected"' : '') . '>Yes ( safeguard all data/options )</option>' . "\n";
		echo '</select><br />' . "\n";
		echo 'Recommended setting: ( <code>Yes, safeguard all data/options</code> )' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_options_page_during_left_sections_after_deactivation", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_options_page_after_left_sections", get_defined_vars ());
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
do_action ("ws_plugin__s2member_during_options_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_options_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>