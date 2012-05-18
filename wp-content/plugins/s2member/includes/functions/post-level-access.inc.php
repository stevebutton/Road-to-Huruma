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
Function for handling Post Level Access restrictions.

Don't call this function directly, use one of these API functions:
	
	Is it protected by s2Member at all?
	- is_post_protected_by_s2member($post_id);
	- is_protected_by_s2member($post_id, "post");
	
	Is the current User permitted/authorized?
	- is_post_permitted_by_s2member($post_id);
	- is_permitted_by_s2member($post_id, "post");

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("ws_plugin__s2member_check_post_level_access"))
	{
		function ws_plugin__s2member_check_post_level_access ()
			{
				global $post; /* get_the_ID() unavailable outside The Loop. */
				/**/
				do_action ("ws_plugin__s2member_before_check_post_level_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_post_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && is_single () && is_object ($post) && ($post_id = $post->ID) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					{
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = ws_plugin__s2member_login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level0")))
							{
								wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => "0")), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
								exit ();
							}
						else if (!ws_plugin__s2member_is_systematic_use_page ()) /* Do NOT protect Systematics. However, there is 1 exception above ^. */
							{
								for ($i = 0; $i <= 4; $i++) /* Post Level restrictions ( including Custom Post Types ). Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
											{
												wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												exit ();
											}
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"] && in_array ($post_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"])) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
											{
												wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												exit ();
											}
									}
								/**/
								for ($i = 0; $i <= 4; $i++) /* Category Level restrictions. Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
											{
												wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												exit ();
											}
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] && (in_category (($catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"])), $post_id) || ws_plugin__s2member_in_descendant_category ($catgs, $post_id)) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
											{
												wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												exit ();
											}
									}
								/**/
								if (has_tag ()) /* Here we take a look to see if this Post has any Tags. If so, we need to run the full set of routines against Tags also. */
									{
										for ($i = 0; $i <= 4; $i++) /* Tag Level restrictions. Go through each Membership Level. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] === "all" && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
												/**/
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"])) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
											}
									}
								/**/
								for ($i = 0; $i <= 4; $i++) /* URIs. Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"])
											foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"], $current_user)) as $str)
												if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $_SERVER["REQUEST_URI"]) && ws_plugin__s2member_nocache_constants (true) !== "nill" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
													{
														wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_level_req" => $i)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
														exit ();
													}
									}
								/**/
								if (is_array ($ccaps_req = get_post_meta ($post_id, "s2member_ccaps_req", true)) && !empty ($ccaps_req) && ws_plugin__s2member_nocache_constants (true) !== "nill")
									foreach ($ccaps_req as $ccap) /* The $current_user MUST satisfy ALL Custom Capability requirements. Stored as a serialized array. */
										if (strlen ($ccap) && (!$current_user || !$current_user->has_cap ("access_s2member_ccap_" . $ccap)))
											{
												wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_ccap_req" => $ccap)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
												exit ();
											}
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && in_array ($post_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])) && ws_plugin__s2member_nocache_constants (true) !== "nill" && !ws_plugin__s2member_sp_access ($post_id))
									{
										wp_redirect (add_query_arg (urlencode_deep (array ("s2member_seeking" => "post-" . $post_id, "s2member_sp_req" => $post_id)), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
										exit ();
									}
							}
						/**/
						do_action ("ws_plugin__s2member_during_check_post_level_access", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_check_post_level_access", get_defined_vars ());
				/**/
				return; /* For uniformity. */
			}
	}
/*
Function checks Post Level Access restrictions - for a specific Post.

Don't call this function directly, use one of these API functions:
	
	Is it protected by s2Member at all?
	- is_post_protected_by_s2member($post_id);
	- is_protected_by_s2member($post_id, "post");
	
	Is the current User permitted/authorized?
	- is_post_permitted_by_s2member($post_id);
	- is_permitted_by_s2member($post_id, "post");

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("ws_plugin__s2member_check_specific_post_level_access"))
	{
		function ws_plugin__s2member_check_specific_post_level_access ($post_id = FALSE, $check_user = TRUE)
			{
				do_action ("ws_plugin__s2member_before_check_specific_post_level_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_check_specific_post_level_access_excluded", false, get_defined_vars ());
				/**/
				if (!$excluded && $post_id && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]) /* Check? */
					{
						$post_link = get_permalink ($post_id); /* Determine link to this Post. */
						$post_path = parse_url ($post_link, PHP_URL_PATH); /* Parse req path. */
						$post_query = parse_url ($post_link, PHP_URL_QUERY); /* Parse query. */
						$post_uri = ($post_query) ? $post_path . "?" . $post_query : $post_path;
						/**/
						$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] && ($login_redirection_uri = ws_plugin__s2member_login_redirection_uri ($current_user)) && preg_match ("/^" . preg_quote ($login_redirection_uri, "/") . "$/", $post_uri) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level0")))
							return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => 0), get_defined_vars ());
						/**/
						else if (!ws_plugin__s2member_is_systematic_use_specific_page (null, $post_uri)) /* Never restrict Systematic Use Pages. However, there is 1 exception above ^. */
							{
								for ($i = 0; $i <= 4; $i++) /* Post Level restrictions ( including Custom Post Types ). Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"] === "all" && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
											return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"] && in_array ($post_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"])) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
											return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
									}
								/**/
								for ($i = 0; $i <= 4; $i++) /* Category Level Access against this Post. Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] === "all" && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
											return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
										/**/
										else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] && (in_category (($catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"])), $post_id) || ws_plugin__s2member_in_descendant_category ($catgs, $post_id)) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
											return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
									}
								/**/
								if (has_tag ("", $post_id)) /* Here we take a look to see if this Post has any Tags. If so, we need to run the full set of routines against Tags also. */
									{
										for ($i = 0; $i <= 4; $i++) /* Tag Level restrictions now. Go through each Membership Level. */
											{
												if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] === "all" && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
													return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
												/**/
												else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] && has_tag (preg_split ("/[\r\n\t;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"]), $post_id) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
													return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
											}
									}
								/**/
								for ($i = 0; $i <= 4; $i++) /* URIs. Go through each Membership Level. */
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"])
											foreach (preg_split ("/[\r\n\t]+/", ws_plugin__s2member_fill_ruri_level_access_rc_vars ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ruris"], $current_user)) as $str)
												if ($str && preg_match ("/" . preg_quote ($str, "/") . "/", $post_uri) && (!$check_user || !$current_user || !current_user_can ("access_s2member_level" . $i)))
													return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_level_req" => $i), get_defined_vars ());
									}
								/**/
								if (is_array ($ccaps_req = get_post_meta ($post_id, "s2member_ccaps_req", true)) && !empty ($ccaps_req))
									foreach ($ccaps_req as $ccap) /* The $current_user MUST satisfy ALL Custom Capabilities. Serialized array. */
										if (strlen ($ccap) && (!$check_user || !$current_user || !$current_user->has_cap ("access_s2member_ccap_" . $ccap)))
											return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_ccap_req" => $ccap), get_defined_vars ());
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && in_array ($post_id, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])) && (!$check_user || !ws_plugin__s2member_sp_access ($post_id, "read-only")))
									return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", array ("s2member_sp_req" => $post_id), get_defined_vars ());
							}
						/**/
						do_action ("ws_plugin__s2member_during_check_specific_post_level_access", get_defined_vars ());
					}
				/**/
				return apply_filters ("ws_plugin__s2member_check_specific_post_level_access", null, get_defined_vars ());
			}
	}
?>