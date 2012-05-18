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
Generates registration links.
*/
if (!function_exists ("ws_plugin__s2member_register_link_gen"))
	{
		function ws_plugin__s2member_register_link_gen ($subscr_id = FALSE, $custom = FALSE, $item_number = FALSE, $shrink = TRUE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_register_link_gen", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($subscr_id && $custom && $item_number) /* Must have all of these. */
					{
						$register = ws_plugin__s2member_encrypt ("subscr_id_custom_item_number_time:.:|:.:" . $subscr_id . ":.:|:.:" . $custom . ":.:|:.:" . $item_number . ":.:|:.:" . strtotime ("now"));
						$register_link = add_query_arg ("s2member_register", urlencode ($register), get_bloginfo ("wpurl") . "/");
						/**/
						if ($shrink && ($tinyurl = ws_plugin__s2member_remote ("http://tinyurl.com/api-create.php?url=" . rawurlencode ($register_link))))
							return apply_filters ("ws_plugin__s2member_register_link_gen", $tinyurl, get_defined_vars ()); /* tinyURL is easier to work with. */
						else /* Else use the long one; tinyURL will fail when/if their server is down periodically. */
							return apply_filters ("ws_plugin__s2member_register_link_gen", $register_link, get_defined_vars ());
					}
				/**/
				return false;
			}
	}
/*
Handles registration links.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_register"))
	{
		function ws_plugin__s2member_register ()
			{
				do_action ("ws_plugin__s2member_before_register", get_defined_vars ());
				/**/
				if ($_GET["s2member_register"]) /* If they're attempting to access the registration system. */
					{
						if (is_array ($register = preg_split ("/\:\.\:\|\:\.\:/", ws_plugin__s2member_decrypt ($_GET["s2member_register"]))))
							{
								if (count ($register) === 5 && $register[0] === "subscr_id_custom_item_number_time" && $register[1] && $register[2] && $register[3] && $register[4])
									{
										if ($register[4] <= strtotime ("now") && $register[4] >= strtotime ("-2 days")) /* Customers have 2 days to register. */
											{
												setcookie ("s2member_subscr_id", ws_plugin__s2member_encrypt ($register[1]), time () + 31556926, "/");
												setcookie ("s2member_custom", ws_plugin__s2member_encrypt ($register[2]), time () + 31556926, "/");
												setcookie ("s2member_level", ws_plugin__s2member_encrypt ($register[3]), time () + 31556926, "/");
												/**/
												do_action ("ws_plugin__s2member_during_register", get_defined_vars ());
												/**/
												if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ())
													{
														echo '<script type="text/javascript">' . "\n";
														echo "window.location = '" . esc_js (apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php")) . "';";
														echo '</script>' . "\n";
													}
												else /* Otherwise, this is NOT a Multisite install. Or it is, but the Super Administrator is NOT selling Blog creation. */
													{
														echo '<script type="text/javascript">' . "\n";
														echo "window.location = '" . esc_js (add_query_arg ("action", urlencode ("register"), wp_login_url ())) . "';";
														echo '</script>' . "\n";
													}
											}
									}
							}
						/**/
						echo '<strong>Your Link Expired:</strong><br />Please contact Support if you need assistance.';
						/**/
						exit (); /* $_GET["s2member_register"] has expired. Or it is simply invalid. */
					}
				/**/
				do_action ("ws_plugin__s2member_after_register", get_defined_vars ());
			}
	}
?>