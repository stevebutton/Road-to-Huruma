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
Adds CSS files.
Attach to: add_action("wp_print_styles");
*/
if (!function_exists ("ws_plugin__s2member_add_css"))
	{
		function ws_plugin__s2member_add_css ()
			{
				do_action ("ws_plugin__s2member_before_add_css", get_defined_vars ());
				/**/
				if (!is_admin ()) /* Not in the admin. */
					{
						wp_enqueue_style ("ws-plugin--s2member", get_bloginfo ("wpurl") . "/?ws_plugin__s2member_css=1&qcABC=1", array (), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"], "all");
						/**/
						do_action ("ws_plugin__s2member_during_add_css", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_css", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Builds CSS files.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_css"))
	{
		function ws_plugin__s2member_css ()
			{
				do_action ("ws_plugin__s2member_before_css", get_defined_vars ());
				/**/
				if ($_GET["ws_plugin__s2member_css"])
					{
						header ("Content-Type: text/css; charset=utf-8");
						header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("+1 week")) . " GMT");
						header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header ("Cache-Control: max-age=604800");
						header ("Pragma: public");
						/**/
						$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
						$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
						/**/
						ob_start ("ws_plugin__s2member_compress_css"); /* Compress. */
						/**/
						include_once dirname (dirname (__FILE__)) . "/s2member.css";
						/**/
						do_action ("ws_plugin__s2member_during_css", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_css", get_defined_vars ());
			}
	}
/*
Adds JavaScript files.
Attach to: add_action("wp_print_scripts");
*/
if (!function_exists ("ws_plugin__s2member_add_js_w_globals"))
	{
		function ws_plugin__s2member_add_js_w_globals ()
			{
				global $pagenow; /* Need this for comparisons. */
				/**/
				do_action ("ws_plugin__s2member_before_add_js_w_globals", get_defined_vars ());
				/**/
				if (!is_admin () || ($pagenow === "profile.php" && !current_user_can ("edit_users")))
					{
						if (is_user_logged_in ()) /* Separate version for logged-in Users/Members. */
							{
								$md5 = WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5; /* An MD5 hash based on global key => values. */
								/* The MD5 hash allows the script to be cached in the browser until the globals happen to change. */
								/* For instance, the global variables may change when a User who is logged-in changes their Profile. */
								wp_enqueue_script ("ws-plugin--s2member", get_bloginfo ("wpurl") . "/?ws_plugin__s2member_js_w_globals=1&qcABC=1&" . $md5, array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
							}
						else /* Else if they are not logged in, we distinguish the JavaScript file by NOT including $md5. */
							{ /* This essentially creates 2 versions of the script. One while logged in & another when not. */
								wp_enqueue_script ("ws-plugin--s2member", get_bloginfo ("wpurl") . "/?ws_plugin__s2member_js_w_globals=1&qcABC=1", array ("jquery"), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["filemtime"]);
							}
						/**/
						do_action ("ws_plugin__s2member_during_add_js_w_globals", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_add_js_w_globals", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Builds JavaScript files.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_js_w_globals"))
	{
		function ws_plugin__s2member_js_w_globals ()
			{
				do_action ("ws_plugin__s2member_before_js_w_globals", get_defined_vars ());
				/**/
				if ($_GET["ws_plugin__s2member_js_w_globals"])
					{
						header ("Content-Type: text/javascript; charset=utf-8");
						header ("Expires: " . gmdate ("D, d M Y H:i:s", strtotime ("+1 week")) . " GMT");
						header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
						header ("Cache-Control: max-age=604800");
						header ("Pragma: public");
						/**/
						$g = "var S2MEMBER_VERSION = '" . ws_plugin__s2member_esc_sq (S2MEMBER_VERSION) . "',"; /* Since 3.0. */
						/**/
						$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN) ? "true" : "false") . ",";
						$g .= "S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER = " . ((S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER) ? "true" : "false") . ",";
						$g .= "S2MEMBER_CURRENT_USER_ACCESS_LEVEL = " . S2MEMBER_CURRENT_USER_ACCESS_LEVEL . ",";
						$g .= "S2MEMBER_CURRENT_USER_ACCESS_LABEL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_ACCESS_LABEL) . "',";
						$g .= "S2MEMBER_CURRENT_USER_SUBSCR_ID = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_SUBSCR_ID) . "',";
						$g .= "S2MEMBER_CURRENT_USER_CUSTOM = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_CUSTOM) . "',";
						$g .= "S2MEMBER_CURRENT_USER_REGISTRATION_TIME = " . S2MEMBER_CURRENT_USER_REGISTRATION_TIME . ",";
						$g .= "S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME = " . S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME . ",";
						$g .= "S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS = " . S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS . ",";
						$g .= "S2MEMBER_CURRENT_USER_REGISTRATION_DAYS = " . S2MEMBER_CURRENT_USER_REGISTRATION_DAYS . ",";
						$g .= "S2MEMBER_CURRENT_USER_DISPLAY_NAME = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_DISPLAY_NAME) . "',";
						$g .= "S2MEMBER_CURRENT_USER_FIRST_NAME = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_FIRST_NAME) . "',";
						$g .= "S2MEMBER_CURRENT_USER_LAST_NAME = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_LAST_NAME) . "',";
						$g .= "S2MEMBER_CURRENT_USER_LOGIN = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_LOGIN) . "',";
						$g .= "S2MEMBER_CURRENT_USER_EMAIL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_EMAIL) . "',";
						$g .= "S2MEMBER_CURRENT_USER_IP = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_IP) . "',";
						$g .= "S2MEMBER_CURRENT_USER_ID = " . S2MEMBER_CURRENT_USER_ID . ",";
						$g .= "S2MEMBER_CURRENT_USER_FIELDS = " . S2MEMBER_CURRENT_USER_FIELDS . ",";
						/**/
						$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED = " . S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED . ",";
						$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED = " . ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED) ? "true" : "false") . ",";
						$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY = " . S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY . ",";
						$g .= "S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS . ",";
						/**/
						$g .= "S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID = " . S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID . ",";
						$g .= "S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID = " . S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID . ",";
						$g .= "S2MEMBER_LOGIN_WELCOME_PAGE_ID = " . S2MEMBER_LOGIN_WELCOME_PAGE_ID . ",";
						/**/
						$g .= "S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL) . "',";
						$g .= "S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL) . "',";
						$g .= "S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL) . "',";
						$g .= "S2MEMBER_LOGIN_WELCOME_PAGE_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LOGIN_WELCOME_PAGE_URL) . "',";
						$g .= "S2MEMBER_LOGOUT_PAGE_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LOGOUT_PAGE_URL) . "',";
						$g .= "S2MEMBER_LOGIN_PAGE_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LOGIN_PAGE_URL) . "',";
						/**/
						$g .= "S2MEMBER_LEVEL0_LABEL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LEVEL0_LABEL) . "',";
						$g .= "S2MEMBER_LEVEL1_LABEL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LEVEL1_LABEL) . "',";
						$g .= "S2MEMBER_LEVEL2_LABEL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LEVEL2_LABEL) . "',";
						$g .= "S2MEMBER_LEVEL3_LABEL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LEVEL3_LABEL) . "',";
						$g .= "S2MEMBER_LEVEL4_LABEL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_LEVEL4_LABEL) . "',";
						/**/
						$g .= "S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED . ",";
						$g .= "S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED . ",";
						$g .= "S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED . ",";
						$g .= "S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED . ",";
						$g .= "S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED = " . S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED . ",";
						/**/
						$g .= "S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
						$g .= "S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
						$g .= "S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
						$g .= "S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
						$g .= "S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS = " . S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS . ",";
						/**/
						$g .= "S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS = '" . ws_plugin__s2member_esc_sq (S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS) . "',";
						/**/
						$g .= "S2MEMBER_REG_EMAIL_FROM_NAME = '" . ws_plugin__s2member_esc_sq (S2MEMBER_REG_EMAIL_FROM_NAME) . "',";
						$g .= "S2MEMBER_REG_EMAIL_FROM_EMAIL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_REG_EMAIL_FROM_EMAIL) . "',";
						/**/
						$g .= "S2MEMBER_PAYPAL_NOTIFY_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_PAYPAL_NOTIFY_URL) . "',";
						$g .= "S2MEMBER_PAYPAL_RETURN_URL = '" . ws_plugin__s2member_esc_sq (S2MEMBER_PAYPAL_RETURN_URL) . "',";
						$g .= "S2MEMBER_PAYPAL_ENDPOINT = '" . ws_plugin__s2member_esc_sq (S2MEMBER_PAYPAL_ENDPOINT) . "',";
						$g .= "S2MEMBER_PAYPAL_BUSINESS = '" . ws_plugin__s2member_esc_sq (S2MEMBER_PAYPAL_BUSINESS) . "',";
						/**/
						$g .= "S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0 = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0) . "',";
						$g .= "S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0 = '" . ws_plugin__s2member_esc_sq (S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0) . "',";
						/**/
						$g = trim ($g, " ,") . ";"; /* Trim & add semicolon. */
						/**/
						$u = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"];
						$i = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images";
						/**/
						echo $g . "\n"; /* Add a line break before inclusion. */
						/**/
						include_once dirname (dirname (__FILE__)) . "/s2member-min.js";
						/**/
						do_action ("ws_plugin__s2member_during_js_w_globals", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_js_w_globals", get_defined_vars ());
			}
	}
?>