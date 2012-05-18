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
Generates Specific Post/Page Access links.
*/
if (!function_exists ("ws_plugin__s2member_sp_access_link_gen"))
	{
		function ws_plugin__s2member_sp_access_link_gen ($sp_ids = FALSE, $hours = 72, $shrink = TRUE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_sp_access_link_gen", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (($sp_ids = preg_replace ("/[^0-9;,]/", "", $sp_ids)) && ($leading_id = preg_replace ("/^([0-9]+)(.*?)$/", "$1", $sp_ids)) && $hours)
					{
						$sp_access = ws_plugin__s2member_encrypt ("sp_time_hours:.:|:.:" . $sp_ids . ":.:|:.:" . strtotime ("now") . ":.:|:.:" . $hours);
						$sp_access_link = add_query_arg ("s2member_sp_access", urlencode ($sp_access), get_permalink ($leading_id));
						/**/
						if ($shrink && ($tinyurl = ws_plugin__s2member_remote ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($sp_access_link))))
							return apply_filters ("ws_plugin__s2member_sp_access_link_gen", $tinyurl, get_defined_vars ()); /* tinyURL is recommended. */
						/**/
						else /* Else use the long one; tinyURL will fail when/if their server is down periodically. */
							return apply_filters ("ws_plugin__s2member_sp_access_link_gen", $sp_access_link, get_defined_vars ());
					}
				/**/
				return false;
			}
	}
/*
Generates Specific Post/Page Access links via ajax tools.
Attach to: add_action("wp_ajax_ws_plugin__s2member_sp_access_link_via_ajax");
*/
if (!function_exists ("ws_plugin__s2member_sp_access_link_via_ajax"))
	{
		function ws_plugin__s2member_sp_access_link_via_ajax ()
			{
				do_action ("ws_plugin__s2member_before_sp_access_link_via_ajax", get_defined_vars ());
				/**/
				if (current_user_can ("create_users")) /* Check priveledges as well. */
					if (($nonce = $_POST["ws_plugin__s2member_sp_access_link_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-sp-access-link-via-ajax"))
						echo apply_filters ("ws_plugin__s2member_sp_access_link_via_ajax", ws_plugin__s2member_sp_access_link_gen ($_POST["s2member_sp_access_link_ids"], $_POST["s2member_sp_access_link_hours"]), get_defined_vars ());
				/**/
				exit ();
			}
	}
/*
Handles Specific Post/Page Access authentication.
*/
if (!function_exists ("ws_plugin__s2member_sp_access"))
	{
		function ws_plugin__s2member_sp_access ($sp_id = FALSE, $read_only = FALSE)
			{
				do_action ("ws_plugin__s2member_before_sp_access", get_defined_vars ());
				/**/
				$excluded = apply_filters ("ws_plugin__s2member_sp_access_excluded", false, get_defined_vars ());
				/**/
				if ($excluded || current_user_can ("edit_posts")) /* Apply Filter here as well. */
					return apply_filters ("ws_plugin__s2member_sp_access", true, get_defined_vars ());
				/**/
				else if ($sp_id && ( ($_GET["s2member_sp_access"] && is_array ($sp_access_values = (array)$_GET["s2member_sp_access"])) || (is_array ($sp_access_values = ws_plugin__s2member_sp_access_session ()) && !empty ($sp_access_values))))
					{
						foreach ($sp_access_values as $sp_access_value) /* Supports multiple access values in a session. */
							{
								if (is_array ($sp_access = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_decrypt ($sp_access_value))))
									{
										if (count ($sp_access) === 4 && $sp_access[0] === "sp_time_hours" && in_array ($sp_id, preg_split ("/[\r\n\t\s;,]+/", $sp_access[1])))
											{
												if ($sp_access[2] <= strtotime ("now") && ($sp_access[2] + ($sp_access[3] * 3600)) >= strtotime ("now"))
													{
														if (!$read_only && $_GET["s2member_sp_access"]) /* Store request in a session. */
															ws_plugin__s2member_sp_access_session ($_GET["s2member_sp_access"]);
														/**/
														if ($read_only || ws_plugin__s2member_ip_restrictions_ok ($_SERVER["REMOTE_ADDR"], $sp_access_value))
															return apply_filters ("ws_plugin__s2member_sp_access", true, get_defined_vars ());
													}
											}
									}
							}
						/**/
						if (!$read_only && $_GET["s2member_sp_access"]) /* If this is a Specific Post/Page Link, fail with expiration. */
							{
								echo '<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.';
								/**/
								exit (); /* $_GET["s2member_sp_access"] has expired. Or it is simply invalid. */
							}
						/**/
						return apply_filters ("ws_plugin__s2member_sp_access", false, get_defined_vars ());
					}
				/**/
				else
					return apply_filters ("ws_plugin__s2member_sp_access", false, get_defined_vars ());
			}
	}
/*
Handles Specific Post/Page sessions, by writing access values into a cookie.
This function can be used to add a new value into the session, and/or to return the current set of values in the session.
*/
if (!function_exists ("ws_plugin__s2member_sp_access_session"))
	{
		function ws_plugin__s2member_sp_access_session ($add_sp_access_value = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_sp_access_session", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$sp_access_values = ($_COOKIE["s2member_sp_access"]) ? preg_split ("/\:\.\:\|\:\.\:/", $_COOKIE["s2member_sp_access"]) : array ();
				/**/
				if ($add_sp_access_value && !in_array ($add_sp_access_value, $sp_access_values)) /* If it's not in the session already. */
					{
						$sp_access_values[] = $add_sp_access_value; /* Add an access value, and update the delimited session cookie. */
						$sp_access_values = array_unique ($sp_access_values); /* Keep this array unique; disallow double-stacking. */
						/**/
						$cookie = implode (":.:|:.:", $sp_access_values); /* Implode the access values into a delimited string. */
						$cookie = (strlen ($cookie) >= 4096) ? $add_sp_access_value : $cookie; /* Max cookie size is 4kbs. */
						/**/
						setcookie ("s2member_sp_access", $cookie, time () + 31556926, "/");
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_sp_access_session", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				return apply_filters ("ws_plugin__s2member_sp_access_session", $sp_access_values, get_defined_vars ());
			}
	}
?>