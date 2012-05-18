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
Function for handling Request URI Level Access restrictions.

Don't call this function directly, use one of these API functions:
	
	Is it protected by s2Member at all?
	- is_uri_protected_by_s2member($uri [ or full url ]);
	- is_protected_by_s2member($uri [ or full url ], "uri");
	
	Is the current User permitted/authorized?
	- is_uri_permitted_by_s2member($uri [ or full url ]);
	- is_permitted_by_s2member($uri [ or full url ], "uri");

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("ws_plugin__s2member_check_ruri_level_access"))
	{
		function ws_plugin__s2member_check_ruri_level_access ()
			{
				do_action ("ws_plugin__s2member_before_check_ruri_level_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_ruri_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Has it been excluded? */
					{
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = ws_plugin__s2member_login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")))
							{
								wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ruri-" . base64_encode ($_SERVER["REQUEST_URI"]), "s2member_level_req" => "0")), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
								exit ();
							}
						else if (!ws_plugin__s2member_is_systematic_use_page ()) /* Do NOT protect Systematics. However, there is 1 exception above ^. */
							{
								for ($i = 0; $i <= 4; $i++) /* URIs. Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"])
											foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"], $current_user)) as $str)
												if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "ruri-" . base64_encode ($_SERVER["REQUEST_URI"]), "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
									}
							}
						/**/
						do_action ("ws_plugin__s2member_during_check_ruri_level_access", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_check_ruri_level_access", get_defined_vars ());
				/**/
				return; /* For uniformity. */
			}
	}
/*
Function checks Request URI Level Access restrictions - for a specific URI/URL.

Don't call this function directly, use one of these API functions:
	
	Is it protected by s2Member at all?
	- is_uri_protected_by_s2member($uri [ or full url ]);
	- is_protected_by_s2member($uri [ or full url ], "uri");
	
	Is the current User permitted/authorized?
	- is_uri_permitted_by_s2member($uri [ or full url ]);
	- is_permitted_by_s2member($uri [ or full url ], "uri");

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("ws_plugin__s2member_check_specific_ruri_level_access"))
	{
		function ws_plugin__s2member_check_specific_ruri_level_access ($__uri = FALSE, $check_user = TRUE)
			{
				do_action ("ws_plugin__s2member_before_check_specific_ruri_level_access", get_defined_vars ());
				/**/
				if ($__uri && is_string ($__uri)) /* We need to parse a URI. A full URL can be passed in. */
					{
						$path = parse_url ($__uri, PHP_URL_PATH); /* Parse req path. */
						$query = parse_url ($__uri, PHP_URL_QUERY); /* Parse query. */
						$uri = ($query) ? $path . "?" . $query : $path;
					}
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_specific_ruri_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && $uri && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Has it been excluded? */
					{
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = ws_plugin__s2member_login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $uri) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level0")))
							return apply_filters ("ws_plugin__s2member_check_specific_ruri_level_access", array ("s2member_level_req" => 0), get_defined_vars ());
						/**/
						else if (!ws_plugin__s2member_is_systematic_use_specific_page (null, $uri)) /* Never restrict Systematic Use Pages. However, there is 1 exception above ^. */
							{
								for ($i = 0; $i <= 4; $i++) /* URIs. Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"])
											foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"], $current_user)) as $str)
												if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $uri) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
													return apply_filters ("ws_plugin__s2member_check_specific_ruri_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
									}
							}
						/**/
						do_action ("ws_plugin__s2member_during_check_specific_ruri_level_access", get_defined_vars ());
					}
				/**/
				return apply_filters ("ws_plugin__s2member_check_specific_ruri_level_access", null, get_defined_vars ());
			}
	}
/*
Function that fills replacement code variables in URIs; collectively.
*/
if (!function_exists ("ws_plugin__s2member_fill_ruri_level_access_rc_vars"))
	{
		function ws_plugin__s2member_fill_ruri_level_access_rc_vars ($uris = FALSE, $user = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_fill_ruri_level_access_rc_vars", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$user = (is_object ($user)) ? $user : wp_get_current_user ();
				$user_login = (is_object ($user)) ? strtolower ($user->user_login) : "";
				$user_id = (is_object ($user)) ? (string)$user->ID : "";
				$user_level = (string)ws_plugin__s2member_user_access_level ($user);
				$user_role = (string)ws_plugin__s2member_user_access_role ($user);
				/**/
				$uris = preg_replace ("/%%current_user_login%%/i", ws_plugin__s2member_esc_ds ($user_login), $uris);
				$uris = preg_replace ("/%%current_user_id%%/i", ws_plugin__s2member_esc_ds ($user_id), $uris);
				$uris = preg_replace ("/%%current_user_level%%/i", ws_plugin__s2member_esc_ds ($user_level), $uris);
				$uris = preg_replace ("/%%current_user_role%%/i", ws_plugin__s2member_esc_ds ($user_role), $uris);
				/**/
				return apply_filters ("ws_plugin__s2member_fill_ruri_level_access_rc_vars", $uris, get_defined_vars ());
			}
	}
?>