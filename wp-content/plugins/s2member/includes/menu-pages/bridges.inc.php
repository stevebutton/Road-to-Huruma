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
API Scripting page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member Bridge Integrations</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_bridges_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_bridges_page_during_left_sections_display_bbpress", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_bridges_page_during_left_sections_before_bbpress", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="bbPress® Bridge Integration">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-bbpress-section">' . "\n";
		echo '<h3>bbPress® Bridge Integration ( install/uninstall )</h3>' . "\n";
		echo '<p>If you\'re running <a href="http://bbpress.org/" target="_blank" rel="external">bbPress® forums</a>, you can protect them with the s2Member plugin. BUT, you will need to install this Bridge/plugin first. This bbPress® Bridge/plugin will block all non-Member access to your forums. Only the bbPress® login-page will be available. Forum registration will be redirected to your Membership Options Page for s2Member ( on your main WordPress® installation ). This way, a visitor can signup on your site, and gain Membership Access to your forums.</p>' . "\n";
		echo '<p><em>* This Bridge/plugin will NOT work, until you\'ve successfully integrated WordPress® into bbPress®. For more information, log into your bbPress® Dashboard, and go to: <code>bbPress® -> Settings -> WordPress® Integration</code>. Once you have WordPress® integrated ( <a href="http://wordpress.org/extend/plugins/bbpress-integration/" target="_blank" rel="external">install this plugin</a> ) and follow the instructions regarding your <code>/wp-config.php</code> file. Then, come back here, and install the s2Member Bridge/plugin. * This Bridge Integration could also be installed manually. You\'ll find the bbPress® Bridge/plugin inside <code>/s2member/includes/dropins/bridges/_s2member-bbpress-bridge.php</code>. Pop that file into the `my-plugins/` directory for bbPress®, or just click the Install button below; s2Member will do this part for you automatically.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_bridges_page_during_left_sections_during_api_easy_way", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th>' . "\n";
		echo '<label for="ws_plugin--s2member-bridge-bbpress-plugins-dir">' . "\n";
		echo 'Server path to your bbPress® plugins directory:' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form method="post" name="ws_plugin__s2member_bridge_bbpress_form" id="ws-plugin--s2member-bridge-bbpress-form">' . "\n";
		echo '<input type="hidden" name="ws_plugin__s2member_bridge_bbpress" id="ws-plugin--s2member-bridge-bbpress" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-bridge-bbpress")) . '" />' . "\n";
		/**/
		echo '<input type="text" name="ws_plugin__s2member_bridge_bbpress_plugins_dir" id="ws_plugin--s2member-bridge-bbpress-plugins-dir" value="' . format_to_edit (trim (stripslashes ($_POST["ws_plugin__s2member_bridge_bbpress_plugins_dir"]))) . '" style="width:99%;" /><br />' . "\n";
		echo 'Best guess: <code>' . esc_html ($_bridge_bbpress_plugins_dir_guess) . '</code><br /><br />' . "\n";
		/**/
		echo 'Minimum Level required for access to your bbPress® forums.<br />' . "\n";
		echo '<select name="ws_plugin__s2member_bridge_bbpress_min_level" id="ws-plugin--s2member-bbpress-min-level" style="width:99%;">' . "\n";
		echo '<option value=""' . ( (!strlen ($_POST["ws_plugin__s2member_bridge_bbpress_min_level"])) ? ' selected="selected"' : '') . '></option>' . "\n";
		echo '<option value="0"' . ( ($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "0") ? ' selected="selected"' : '') . '>s2Member Level 0</option>' . "\n";
		echo '<option value="1"' . ( ($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "1") ? ' selected="selected"' : '') . '>s2Member Level 1</option>' . "\n";
		echo '<option value="2"' . ( ($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "2") ? ' selected="selected"' : '') . '>s2Member Level 2</option>' . "\n";
		echo '<option value="3"' . ( ($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "3") ? ' selected="selected"' : '') . '>s2Member Level 3</option>' . "\n";
		echo '<option value="4"' . ( ($_POST["ws_plugin__s2member_bridge_bbpress_min_level"] === "4") ? ' selected="selected"' : '') . '>s2Member Level 4</option>' . "\n";
		echo '</select><br /><br />' . "\n";
		/**/
		echo '<p class="submit"><input type="submit" name="ws_plugin__s2member_bridge_bbpress_action" class="button-primary" value="Install / Re-Install" /> &nbsp;&nbsp; <input type="submit" name="ws_plugin__s2member_bridge_bbpress_action" class="button-primary" value="Un-Install" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_bridges_page_during_left_sections_after_bbpress", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_bridges_page_after_left_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_bridges_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_bridges_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>