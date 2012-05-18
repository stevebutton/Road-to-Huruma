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
Function that saves all options from any page.
Options can also be passed in directly.
	Can also be self-verified.
*/
if (!function_exists ("ws_plugin__s2member_update_all_options"))
	{
		function ws_plugin__s2member_update_all_options ($new_options = FALSE, $verified = FALSE, $update_other = TRUE, $display_notices = TRUE, $enqueue_notices = FALSE, $request_refresh = FALSE)
			{
				do_action ("ws_plugin__s2member_before_update_all_options", get_defined_vars ()); /* If you use this Hook, be sure to use `wp_verify_nonce()`. */
				/**/
				if ($verified || ( ($nonce = $_POST["ws_plugin__s2member_options_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-options-save")))
					{
						$options = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]; /* Here we get all of the existing options. */
						$new_options = (is_array ($new_options)) ? $new_options : (array)$_POST; /* Force array. */
						$new_options = ws_plugin__s2member_trim_deep (stripslashes_deep ($new_options));
						/**/
						foreach ((array)$new_options as $key => $value) /* Looking for relevant keys. */
							if (preg_match ("/^" . preg_quote ("ws_plugin__s2member_", "/") . "/", $key))
								/**/
								if ($key === "ws_plugin__s2member_configured") /* Configured. */
									{
										update_option ("ws_plugin__s2member_configured", $value);
										$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["configured"] = $value;
									}
								else /* Place this option into the array. Remove ws_plugin__s2member_. */
									{
										(is_array ($value)) ? array_shift ($value) : null; /* Arrays should be padded. */
										$key = preg_replace ("/^" . preg_quote ("ws_plugin__s2member_", "/") . "/", "", $key);
										$options[$key] = $value; /* Overriding a possible existing option. */
									}
						/**/
						$options["options_version"] = $options["options_version"] + 0.001;
						$options = ws_plugin__s2member_configure_options_and_their_defaults ($options);
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_update_all_options", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						update_option ("ws_plugin__s2member_options", $options) . update_option ("ws_plugin__s2member_cache", array ());
						/**/
						if ($update_other === true || in_array ("auto_eot_system", (array)$update_other)) /* Handle the Auto-EOT System now ( enable/disable ). */
							($options["auto_eot_system_enabled"] == 1) ? ws_plugin__s2member_add_auto_eot_system () : ws_plugin__s2member_delete_auto_eot_system ();
						/**/
						if (($display_notices === true || in_array ("success", (array)$display_notices)) && ($notice = '<strong>Options saved.' . (($request_refresh) ? ' Please <a href="' . esc_attr ($_SERVER["REQUEST_URI"]) . '">refresh</a>.' : '') . '</strong>'))
							($enqueue_notices === true || in_array ("success", (array)$enqueue_notices)) ? ws_plugin__s2member_enqueue_admin_notice ($notice) : ws_plugin__s2member_display_admin_notice ($notice);
						/**/
						if (!$options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>NOTE:</strong> s2Member security restrictions will NOT be enforced until you\'ve configured a Membership Options Page. See: <code>s2Member -> General Options -> Membership Options Page</code>.'))
							($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? ws_plugin__s2member_enqueue_admin_notice ($notice, false, true) : ws_plugin__s2member_display_admin_notice ($notice, true);
						/**/
						if ($options["login_welcome_page"] && $options["login_welcome_page"] === $options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>NOTE:</strong> Your Login Welcome Page is the same as your Membership Options Page. Please correct this. See: <code>s2Member -> General Options -> Login Welcome Page</code>.'))
							($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? ws_plugin__s2member_enqueue_admin_notice ($notice, false, true) : ws_plugin__s2member_display_admin_notice ($notice, true);
						/**/
						if ($options["file_download_limit_exceeded_page"] && $options["file_download_limit_exceeded_page"] === $options["membership_options_page"] && ($display_notices === true || in_array ("page-conflict-warnings", (array)$display_notices)) && ($notice = '<strong>NOTE:</strong> Your Download Limit Exceeded Page is the same as your Membership Options Page. Please correct this. See: <code>s2Member -> Download Options</code>.'))
							($enqueue_notices === true || in_array ("page-conflict-warnings", (array)$enqueue_notices)) ? ws_plugin__s2member_enqueue_admin_notice ($notice, false, true) : ws_plugin__s2member_display_admin_notice ($notice, true);
					}
				/**/
				do_action ("ws_plugin__s2member_after_update_all_options", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Add the options menus & sub-menus.
Attach to: add_action("admin_menu");
*/
if (!function_exists ("ws_plugin__s2member_add_admin_options"))
	{
		function ws_plugin__s2member_add_admin_options ()
			{
				do_action ("ws_plugin__s2member_before_add_admin_options", get_defined_vars ());
				/**/
				add_filter ("plugin_action_links", "_ws_plugin__s2member_add_settings_link", 10, 2);
				/**/
				if (apply_filters ("ws_plugin__s2member_during_add_admin_options_create_menu_items", true, get_defined_vars ()))
					{
						if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ())
							$GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"] = array (); /* Clear right side. */
						/**/
						if (is_multisite () && is_main_site ()) /* Re-organize menu whenever Multisite Networking is enabled; and we're on the Main Site. */
							{
								$menu = "ws-plugin--s2member-mms-options"; /* Used below for nesting additional sub-menu pages. */
								/**/
								add_menu_page ("s2Member Options", "s2Member", "create_users", $menu, "ws_plugin__s2member_mms_options_page", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images/brand-favicon.png");
								/**/
								add_submenu_page ($menu, "s2Member Multisite ( Main Site Configuration )", "Multisite (Config)", "create_users", "ws-plugin--s2member-mms-options", "ws_plugin__s2member_mms_options_page");
								add_submenu_page ($menu, "s2Member General Options", "General Options", "create_users", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
							}
						else /* Otherwise, we use the standard menu configuration here. The parent menu is the General Options for s2Member in this case. */
							{
								$menu = "ws-plugin--s2member-options"; /* Used below for nesting additional sub-menu pages. */
								/**/
								add_menu_page ("s2Member Options", "s2Member", "create_users", $menu, "ws_plugin__s2member_options_page", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images/brand-favicon.png");
								/**/
								add_submenu_page ($menu, "s2Member General Options", "General Options", "create_users", "ws-plugin--s2member-options", "ws_plugin__s2member_options_page");
								(!is_multisite ()) ? add_submenu_page ($menu, "s2Member Multisite ( NOT enabled )", "Multisite Config", "create_users", "ws-plugin--s2member-mms-options", "ws_plugin__s2member_mms_options_page") : null;
							}
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_new_user_page", true, get_defined_vars ())) /* Shortcut. */
							add_submenu_page ($menu, "s2Member / Add A Member", "Add A Member", "create_users", "user-new.php"); /* Shortcut to user-new.php. */
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_paypal_ops_page", true, get_defined_vars ()))
							add_submenu_page ($menu, "s2Member PayPal Options", "PayPal® Options", "create_users", "ws-plugin--s2member-paypal-ops", "ws_plugin__s2member_paypal_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_paypal_buttons_page", true, get_defined_vars ()))
							add_submenu_page ($menu, "s2Member PayPal® Buttons", "PayPal® Buttons", "create_users", "ws-plugin--s2member-paypal-buttons", "ws_plugin__s2member_paypal_buttons_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_down_ops_page", (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()), get_defined_vars ()))
							add_submenu_page ($menu, "s2Member File Download Options", "Download Options", "create_users", "ws-plugin--s2member-down-ops", "ws_plugin__s2member_down_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_trk_ops_page", true, get_defined_vars ()))
							add_submenu_page ($menu, "s2Member API / Tracking", "API / Tracking", "create_users", "ws-plugin--s2member-trk-ops", "ws_plugin__s2member_trk_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_els_ops_page", true, get_defined_vars ()))
							add_submenu_page ($menu, "s2Member API / List Servers", "API / List Servers", "create_users", "ws-plugin--s2member-els-ops", "ws_plugin__s2member_els_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_api_ops_page", true, get_defined_vars ()))
							add_submenu_page ($menu, "s2Member API / Notifications", "API / Notifications", "create_users", "ws-plugin--s2member-api-ops", "ws_plugin__s2member_api_ops_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_scripting_page", (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()), get_defined_vars ()))
							add_submenu_page ($menu, "s2Member API / Scripting", "API / Scripting", "create_users", "ws-plugin--s2member-scripting", "ws_plugin__s2member_scripting_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_bridges_page", (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()), get_defined_vars ()))
							add_submenu_page ($menu, "s2Member Bridge Integrations", "API / Bridges", "create_users", "ws-plugin--s2member-bridges", "ws_plugin__s2member_bridges_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_info_page", (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()), get_defined_vars ()))
							add_submenu_page ($menu, "s2Member Information", "s2Member Info", "create_users", "ws-plugin--s2member-info", "ws_plugin__s2member_info_page");
						/**/
						if (apply_filters ("ws_plugin__s2member_during_add_admin_options_add_start_page", true, get_defined_vars ()))
							add_submenu_page ($menu, "s2Member Quick-Start Guide", "Quick-Start Guide", "create_users", "ws-plugin--s2member-start", "ws_plugin__s2member_start_page");
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_admin_options", get_defined_vars ());
				/**/
				return;
			}
	}
/*
A sort of callback function to add the settings link.
*/
if (!function_exists ("_ws_plugin__s2member_add_settings_link"))
	{
		function _ws_plugin__s2member_add_settings_link ($links = array (), $file = "")
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_before_add_settings_link", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (preg_match ("/" . preg_quote ($file, "/") . "$/", $GLOBALS["WS_PLUGIN__"]["s2member"]["l"]) && is_array ($links))
					{
						$settings = '<a href="admin.php?page=ws-plugin--s2member-options">Settings</a>';
						array_unshift ($links, apply_filters ("ws_plugin__s2member_add_settings_link", $settings, get_defined_vars ()));
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_add_settings_link", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				return apply_filters ("_ws_plugin__s2member_add_settings_link", $links, get_defined_vars ());
			}
	}
/*
Add scripts to admin panels.
Attach to: add_action("admin_print_scripts");
*/
if (!function_exists ("ws_plugin__s2member_add_admin_scripts"))
	{
		function ws_plugin__s2member_add_admin_scripts ()
			{
				do_action ("ws_plugin__s2member_before_add_admin_scripts", get_defined_vars ());
				/**/
				if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
					{
						wp_enqueue_script ("jquery");
						wp_enqueue_script ("thickbox");
						wp_enqueue_script ("media-upload");
						wp_enqueue_script ("jquery-ui-core");
						wp_enqueue_script ("jquery-json-ps", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/includes/menu-pages/jquery-json-ps-min.js", array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
						wp_enqueue_script ("jquery-ui-effects", $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/includes/menu-pages/jquery-ui-effects.js", array ("jquery", "jquery-ui-core"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
						wp_enqueue_script ("ws-plugin--s2member-menu-pages", get_bloginfo ("wpurl") . "/?ws_plugin__s2member_menu_pages_js=1", array ("jquery", "thickbox", "media-upload", "jquery-json-ps", "jquery-ui-core", "jquery-ui-effects"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
						/**/
						do_action ("ws_plugin__s2member_during_add_admin_scripts", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_admin_scripts", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Add styles to admin panels.
Attach to: add_action("admin_print_styles");
*/
if (!function_exists ("ws_plugin__s2member_add_admin_styles"))
	{
		function ws_plugin__s2member_add_admin_styles ()
			{
				do_action ("ws_plugin__s2member_before_add_admin_styles", get_defined_vars ());
				/**/
				if ($_GET["page"] && preg_match ("/ws-plugin--s2member-/", $_GET["page"]))
					{
						wp_enqueue_style ("thickbox");
						wp_enqueue_style ("ws-plugin--s2member-menu-pages", get_bloginfo ("wpurl") . "/?ws_plugin__s2member_menu_pages_css=1", array ("thickbox"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"], "all");
						/**/
						do_action ("ws_plugin__s2member_during_add_admin_styles", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_admin_styles", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that outputs the JS for menu pages.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_menu_pages_js"))
	{
		function ws_plugin__s2member_menu_pages_js ()
			{
				do_action ("ws_plugin__s2member_before_menu_pages_js", get_defined_vars ());
				/**/
				if ($_GET["ws_plugin__s2member_menu_pages_js"] && is_user_logged_in () && current_user_can ("create_users"))
					{
						header ("Content-Type: text/javascript; charset=utf-8");
						header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
						header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header ("Cache-Control: no-cache, must-revalidate, max-age=0");
						header ("Pragma: no-cache");
						/**/
						$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
						$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages-min.js";
						/**/
						echo "\n"; /* Add a line break before inclusion of this file. */
						/**/
						@include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages-s-min.js";
						/**/
						do_action ("ws_plugin__s2member_during_menu_pages_js", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_menu_pages_js", get_defined_vars ());
			}
	}
/*
Function that outputs the CSS for menu pages.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_menu_pages_css"))
	{
		function ws_plugin__s2member_menu_pages_css ()
			{
				do_action ("ws_plugin__s2member_before_menu_pages_css", get_defined_vars ());
				/**/
				if ($_GET["ws_plugin__s2member_menu_pages_css"] && is_user_logged_in () && current_user_can ("create_users"))
					{
						header ("Content-Type: text/css; charset=utf-8");
						header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("-1 week")) . " GMT");
						header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header ("Cache-Control: no-cache, must-revalidate, max-age=0");
						header ("Pragma: no-cache");
						/**/
						$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
						$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
						/**/
						ob_start ("ws_plugin__s2member_compress_css"); /* Compress. */
						/**/
						include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages.css";
						/**/
						echo "\n"; /* Add a line break before inclusion of this file. */
						/**/
						@include_once dirname (dirname (__FILE__)) . "/menu-pages/menu-pages-s.css";
						/**/
						do_action ("ws_plugin__s2member_during_menu_pages_css", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_menu_pages_css", get_defined_vars ());
			}
	}
/*
Function for building and handling the Main Multisite Options page.
*/
if (!function_exists ("ws_plugin__s2member_mms_options_page"))
	{
		function ws_plugin__s2member_mms_options_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_mms_options_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				if (($nonce = $_POST["ws_plugin__s2member_mms_options_patch_files"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-mms-options-patch-files"))
					{
						$wp_login_file = ABSPATH . "wp-login.php";
						$wp_login_section = "/([\r\n\t\s ]+)(wp_redirect( *?)\(( *?)apply_filters( *?)\(( *?)['\"]wp_signup_location['\"],( *?)get_bloginfo( *?)\(['\"]wpurl['\"]\)( *?)\.( *?)['\"]\/wp-signup\.php['\"]( *?)\)( *?)\);)([\r\n\t\s ]+)(exit;)/";
						$wp_login_replace = "\n\t\t// Modified for full plugin compatiblity.\n\t\t//wp_redirect( apply_filters( 'wp_signup_location', get_bloginfo('wpurl') . '/wp-signup.php' ) );\n\t\t//exit;";
						/**/
						if (file_exists ($wp_login_file) && is_writable ($wp_login_file) && ($wp_login = file_get_contents ($wp_login_file)) && file_put_contents ($wp_login_file, preg_replace ($wp_login_section, $wp_login_replace, $wp_login)))
							ws_plugin__s2member_display_admin_notice ('Your <code>/wp-login.php</code> file was patched successfully.');
						else /* Otherwise, we need to report that /wp-login.php could NOT be updated. Possibly a permissions error. */
							ws_plugin__s2member_display_admin_notice ('Your <code>wp-login.php</code> file could NOT be patched. File NOT writable.', true);
						/**/
						$load_file = ABSPATH . WPINC . "/load.php";
						$load_section = "/([\r\n\t\s ]+)(if( *?)\(( *?)empty( *?)\(( *?)\\\$active_plugins( *?)\)( *?)\|\|( *?)defined( *?)\(( *?)['\"]WP_INSTALLING['\"]( *?)\)( *?)\))/";
						$load_replace = "\n\n\t// Modified for full plugin compatiblity.\n\t//if ( empty( \$active_plugins ) || defined( 'WP_INSTALLING' ) )\n\tif ( empty( \$active_plugins ) || ( defined( 'WP_INSTALLING' ) && !preg_match(\"/\/wp-activate\.php/\", \$_SERVER[\"REQUEST_URI\"]) ) )";
						/**/
						if (file_exists ($load_file) && is_writable ($load_file) && ($load = file_get_contents ($load_file)) && file_put_contents ($load_file, preg_replace ($load_section, $load_replace, $load)))
							ws_plugin__s2member_display_admin_notice ('Your <code>/wp-includes/load.php</code> file was patched successfully.');
						else /* Otherwise, we need to report that /wp-includes/load.php could NOT be updated. Possibly a permissions error. */
							ws_plugin__s2member_display_admin_notice ('Your <code>/wp-includes/load.php</code> file could NOT be patched. File NOT writable.', true);
						/**/
						$user_new_file = ABSPATH . "wp-admin/user-new.php";
						$user_new_section = "/([\r\n\t\s ]+)(wpmu_signup_user( *?)\(( *?)\\\$new_user_login,( *?)\\\$_REQUEST\[( *?)'email'( *?)\],( *?)array( *?)\(( *?)'add_to_blog'( *?)\=\>( *?)\\\$wpdb->blogid,( *?)'new_role'( *?)\=\>( *?)\\\$_REQUEST\[( *?)'role'( *?)\]( *?)\)( *?)\);)/";
						$user_new_replace = "\n\t\t\t\t// Modified for full plugin compatiblity.\n\t\t\t\t//wpmu_signup_user( \$new_user_login, \$_REQUEST[ 'email' ], array( 'add_to_blog' => \$wpdb->blogid, 'new_role' => \$_REQUEST[ 'role' ] ) );\n\t\t\t\twpmu_signup_user( \$new_user_login, \$_REQUEST[ 'email' ], apply_filters( 'add_signup_meta', array( 'add_to_blog' => \$wpdb->blogid, 'new_role' => \$_REQUEST[ 'role' ] ) ) );";
						/**/
						if (file_exists ($user_new_file) && is_writable ($user_new_file) && ($user_new = file_get_contents ($user_new_file)) && file_put_contents ($user_new_file, preg_replace ($user_new_section, $user_new_replace, $user_new)))
							ws_plugin__s2member_display_admin_notice ('Your <code>/wp-admin/user-new.php</code> file was patched successfully.');
						else /* Otherwise, we need to report that /wp-admin/user-new.php could NOT be updated. Possibly a permissions error. */
							ws_plugin__s2member_display_admin_notice ('Your <code>/wp-admin/user-new.php</code> file could NOT be patched. File NOT writable.', true);
					}
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/mms-options.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_mms_options_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the General Options page.
*/
if (!function_exists ("ws_plugin__s2member_options_page"))
	{
		function ws_plugin__s2member_options_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_options_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/options.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_options_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the Paypal Options page.
*/
if (!function_exists ("ws_plugin__s2member_paypal_ops_page"))
	{
		function ws_plugin__s2member_paypal_ops_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_paypal_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				$logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"];
				/**/
				if (!is_dir ($logs_dir) && is_writable (dirname ($logs_dir)))
					mkdir ($logs_dir, 0777) . clearstatcache ();
				/**/
				$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"] . "/.htaccess";
				/**/
				if (is_dir ($logs_dir) && is_writable ($logs_dir) && !file_exists ($htaccess))
					file_put_contents ($htaccess, "deny from all") . clearstatcache ();
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"]) /* Logging enabled? */
					{
						if (!is_dir ($logs_dir)) /* If the security-enabled logs directory does not exist yet. */
							ws_plugin__s2member_display_admin_notice ("The security-enabled logs directory ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $logs_dir) . "</code> ) does not exist. Please create this directory manually &amp; make it writable ( chmod 777 ).", true);
						/**/
						else if (!is_writable ($logs_dir)) /* If the logs directory is not writable yet. */
							ws_plugin__s2member_display_admin_notice ("Permissions error. The security-enabled logs directory ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $logs_dir) . "</code> ) is not writable. Please make this directory writable ( chmod 777 ).", true);
						/**/
						if (!file_exists ($htaccess)) /* If the .htaccess file has not been created yet. */
							ws_plugin__s2member_display_admin_notice ("The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not exist. Please create this file manually. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
						/**/
						else if (!preg_match ("/deny from all/i", file_get_contents ($htaccess))) /* Else if the .htaccess file does not offer the required protection. */
							ws_plugin__s2member_display_admin_notice ("Unprotected. The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not contain <code>deny from all</code>. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
					}
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/paypal-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_paypal_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the Download Options page.
*/
if (!function_exists ("ws_plugin__s2member_down_ops_page"))
	{
		function ws_plugin__s2member_down_ops_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_down_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				$files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"];
				/**/
				if (!is_dir ($files_dir) && is_writable (dirname ($files_dir)))
					mkdir ($files_dir, 0777) . clearstatcache ();
				/**/
				$htaccess = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"] . "/.htaccess";
				/**/
				if (is_dir ($files_dir) && is_writable ($files_dir) && !file_exists ($htaccess))
					file_put_contents ($htaccess, "deny from all") . clearstatcache ();
				/**/
				if (!is_dir ($files_dir)) /* If the security-enabled files directory does not exist yet. */
					ws_plugin__s2member_display_admin_notice ("The security-enabled files directory ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $files_dir) . "</code> ) does not exist. Please create this directory manually.", true);
				/**/
				if (!file_exists ($htaccess)) /* If the .htaccess file has not been created yet. */
					ws_plugin__s2member_display_admin_notice ("The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not exist. Please create this file manually. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
				/**/
				else if (!preg_match ("/deny from all/i", file_get_contents ($htaccess))) /* Else if the .htaccess file does not offer the required protection. */
					ws_plugin__s2member_display_admin_notice ("Unprotected. The .htaccess protection file ( <code>" . preg_replace ("/^" . preg_quote ($_SERVER["DOCUMENT_ROOT"], "/") . "/", "", $htaccess) . "</code> ) does not contain <code>deny from all</code>. Inside your .htaccess file, add this one line: <code>deny from all</code>.", true);
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/down-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_down_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the API Tracking options page.
*/
if (!function_exists ("ws_plugin__s2member_trk_ops_page"))
	{
		function ws_plugin__s2member_trk_ops_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_trk_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/trk-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_trk_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the API List Server options page.
*/
if (!function_exists ("ws_plugin__s2member_els_ops_page"))
	{
		function ws_plugin__s2member_els_ops_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_els_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/els-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_els_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the API Notifications page.
*/
if (!function_exists ("ws_plugin__s2member_api_ops_page"))
	{
		function ws_plugin__s2member_api_ops_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_api_ops_page", get_defined_vars ());
				/**/
				ws_plugin__s2member_update_all_options ();
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/api-ops.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_api_ops_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the PayPal Button Generator page.
*/
if (!function_exists ("ws_plugin__s2member_paypal_buttons_page"))
	{
		function ws_plugin__s2member_paypal_buttons_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_paypal_buttons_page", get_defined_vars ());
				/**/
				if (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"]) /* Report error if PayPal® Options are not yet configured. */
					ws_plugin__s2member_display_admin_notice ('Please configure <code>s2Member -> PayPal® Options</code> first. Once all of your PayPal® Options have been configured, return to this page &amp; generate your PayPal® Button(s).', true);
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/paypal-buttons.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_paypal_buttons_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the API Scripting page.
*/
if (!function_exists ("ws_plugin__s2member_scripting_page"))
	{
		function ws_plugin__s2member_scripting_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_scripting_page", get_defined_vars ());
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/scripting.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_scripting_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the Bridge Integrations page.
*/
if (!function_exists ("ws_plugin__s2member_bridges_page"))
	{
		function ws_plugin__s2member_bridges_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_bridges_page", get_defined_vars ());
				/**/
				if (($nonce = $_POST["ws_plugin__s2member_bridge_bbpress"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-bridge-bbpress"))
					{
						$post = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST)); /* Trim/stripslashes on all _POST vars. */
						/**/
						if (($plugins_dir = rtrim ($post["ws_plugin__s2member_bridge_bbpress_plugins_dir"], "/")) && is_dir ($plugins_dir))
							{
								if (is_writable ($plugins_dir)) /* This directory MUST be writable. Otherwise, we cannot continue. */
									{
										if (preg_match ("/^Install/i", $post["ws_plugin__s2member_bridge_bbpress_action"]))
											{
												$min = (string)$post["ws_plugin__s2member_bridge_bbpress_min_level"];
												/**/
												if (($file = file_get_contents (dirname (dirname (__FILE__)) . "/dropins/bridges/_s2member-bbpress-bridge.php")) && ($file = preg_replace ("/%%min%%/i", ws_plugin__s2member_esc_dq ($min), $file)) && file_put_contents ($plugins_dir . "/_s2member-bbpress-bridge.php", $file))
													ws_plugin__s2member_display_admin_notice ("The bbPress® Bridge/plugin has been <strong>installed successfully</strong>.");
												/**/
												else /* Otherwise, something unexpected. The site owner will need to install the bbPress® plugin manually. */
													ws_plugin__s2member_display_admin_notice ("Unknown error. Please try again, or install manually.", true);
											}
										/**/
										else if (preg_match ("/^Un-Install/i", $post["ws_plugin__s2member_bridge_bbpress_action"]))
											{
												if (file_exists ($plugins_dir . "/_s2member-bbpress-bridge.php"))
													{
														if (!unlink ($plugins_dir . "/_s2member-bbpress-bridge.php")) /* Test return value of unlink. */
															ws_plugin__s2member_display_admin_notice ("Unknown error. Please try again, or un-install manually.", true);
														/**/
														else /* Otherwise, everything looks good. The plugin file has been removed successfully. */
															ws_plugin__s2member_display_admin_notice ("The bbPress® Bridge/plugin has been successfully <strong>un-installed</strong>.");
													}
												else
													ws_plugin__s2member_display_admin_notice ("The bbPress® Bridge/plugin is already un-installed.", true);
											}
									}
								else
									ws_plugin__s2member_display_admin_notice ("The directory you specified is NOT writable. Please try again, or install manually.", true);
							}
						else
							ws_plugin__s2member_display_admin_notice ("The directory you specified does NOT exist. Please try again, or install manually.", true);
					}
				/**/
				if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/bbpress/my-plugins"))
					if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/forums/my-plugins"))
						if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/bbpress/bb-plugins"))
							if (!is_dir ($plugins_dir_guess = $_SERVER["DOCUMENT_ROOT"] . "/forums/bb-plugins"))
								$plugins_dir_guess = ($plugins_dir) ? $plugins_dir : $plugins_dir_guess;
				/**/
				$_bridge_bbpress_plugins_dir_guess = ($plugins_dir) ? $plugins_dir : $plugins_dir_guess;
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/bridges.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_bridges_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building the s2Member Info page.
*/
if (!function_exists ("ws_plugin__s2member_info_page"))
	{
		function ws_plugin__s2member_info_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_info_page", get_defined_vars ());
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/info.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_info_page", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for building and handling the Quick Start page.
*/
if (!function_exists ("ws_plugin__s2member_start_page"))
	{
		function ws_plugin__s2member_start_page ()
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				do_action ("ws_plugin__s2member_before_start_page", get_defined_vars ());
				/**/
				include_once dirname (dirname (__FILE__)) . "/menu-pages/start.inc.php";
				/**/
				do_action ("ws_plugin__s2member_after_start_page", get_defined_vars ());
				/**/
				return;
			}
	}
?>