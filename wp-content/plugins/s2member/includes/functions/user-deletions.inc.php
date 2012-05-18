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
Function for handling user deletions.
Attach to: add_action("remove_user_from_blog");
*/
if (!function_exists ("ws_plugin__s2member_handle_ms_user_deletions"))
	{
		function ws_plugin__s2member_handle_ms_user_deletions ($user_id = FALSE, $blog_id = FALSE, $s2says = FALSE)
			{
				static $processed = array (); /* No duplicate processing. */
				global $pagenow; /* Need this to detect the current admin page. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_handle_ms_user_deletions", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite () && !$processed[$user_id]) /* Safeguard this routine against duplicate processing via plugins ( or even WordPress® itself ). */
					{
						if (($s2says || (is_admin () && $pagenow === "users.php")) && ($processed[$user_id] = true)) /* If s2Member says, or on users.php. */
							/* We don't react on this event globally, because there are many routines that remove Users from a Blog; w/ harmless reasons. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_handle_ms_user_deletions_before", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								ws_plugin__s2member_handle_user_deletions ($user_id); /* Now hand this over. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_handle_ms_user_deletions_after", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_handle_ms_user_deletions", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
Function for handling user deletions.
Attach to: add_action("delete_user");
Attach to: add_action("wpmu_delete_user");

This also handles Multisite removal hand-offs.
ws_plugin__s2member_handle_ms_user_deletions().
*/
if (!function_exists ("ws_plugin__s2member_handle_user_deletions"))
	{
		function ws_plugin__s2member_handle_user_deletions ($user_id = FALSE)
			{
				static $processed = array (); /* No duplicate processing. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_handle_user_deletions", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (!$processed[$user_id] && ($processed[$user_id] = true)) /* Safeguard this routine against duplicate processing via plugins ( or even WordPress® itself ). */
					{
						$custom = get_user_option ("s2member_custom", $user_id); /* An EOT Notification is triggered, EVEN if this is empty. */
						$subscr_id = get_user_option ("s2member_subscr_id", $user_id); /* And also, EVEN if this is empty. */
						$fields = get_user_option ("s2member_custom_fields", $user_id); /* Used in API Notifications. */
						/**/
						delete_user_option ($user_id, "s2member_custom"); /* Now we can remove these User options ( for this Blog ). */
						delete_user_option ($user_id, "s2member_subscr_id"); /* The `wpmu_delete_user` Hook also handles this. */
						/**/
						delete_user_option ($user_id, "s2member_paid_registration_times");
						delete_user_option ($user_id, "s2member_last_payment_time");
						delete_user_option ($user_id, "s2member_auto_eot_time");
						delete_user_option ($user_id, "s2member_notes");
						/**/
						delete_user_option ($user_id, "s2member_file_download_access_arc");
						delete_user_option ($user_id, "s2member_file_download_access_log");
						/**/
						if (is_object ($user = new WP_User ($user_id)) && $user->ID && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $custom)))
							{
								foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle EOT Notifications on user deletion. */
									/**/
									if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", ws_plugin__s2member_esc_ds (urlencode ($subscr_id)), $url)))
										if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($user->last_name)), $url)))
											if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
												if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($user->user_email)), $url)))
													if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($user->user_login)), $url)))
														if (($url = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds (urlencode ($user_id)), $url)))
															{
																if (is_array ($fields) && !empty ($fields))
																	foreach ($fields as $var => $val) /* Custom Registration Fields. */
																		if (! ($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", ws_plugin__s2member_esc_ds (urlencode (maybe_serialize ($val))), $url)))
																			break;
																/**/
																if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																	ws_plugin__s2member_remote ($url);
															}
							}
						/**/
						if (is_object ($user = new WP_User ($user_id)) && $user->ID && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $custom)))
							{
								ws_plugin__s2member_email_config_release (); /* Release all Filters applied to wp_mail() From: headers. */
								/**/
								$msg = $sbj = "( s2Member / API Notification Email ) - EOT/Deletion";
								$msg .= "\n\n"; /* Spacing in the message body. */
								/**/
								$msg .= "subscr_id: %%subscr_id%%\n";
								$msg .= "user_first_name: %%user_first_name%%\n";
								$msg .= "user_last_name: %%user_last_name%%\n";
								$msg .= "user_full_name: %%user_full_name%%\n";
								$msg .= "user_email: %%user_email%%\n";
								$msg .= "user_login: %%user_login%%\n";
								$msg .= "user_id: %%user_id%%\n";
								/**/
								if (is_array ($fields) && !empty ($fields))
									foreach ($fields as $var => $val)
										$msg .= $var . ": %%" . $var . "%%\n";
								/**/
								$msg .= "cv0: %%cv0%%\n";
								$msg .= "cv1: %%cv1%%\n";
								$msg .= "cv2: %%cv2%%\n";
								$msg .= "cv3: %%cv3%%\n";
								$msg .= "cv4: %%cv4%%\n";
								$msg .= "cv5: %%cv5%%\n";
								$msg .= "cv6: %%cv6%%\n";
								$msg .= "cv7: %%cv7%%\n";
								$msg .= "cv8: %%cv8%%\n";
								$msg .= "cv9: %%cv9%%";
								/**/
								if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", ws_plugin__s2member_esc_ds ($subscr_id), $msg)))
									if (($msg = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds ($user->last_name), $msg)))
										if (($msg = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
											if (($msg = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds ($user->user_email), $msg)))
												if (($msg = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds ($user->user_login), $msg)))
													if (($msg = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds ($user_id), $msg)))
														{
															if (is_array ($fields) && !empty ($fields))
																foreach ($fields as $var => $val) /* Custom Registration Fields. */
																	if (! ($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", ws_plugin__s2member_esc_ds (maybe_serialize ($val)), $msg)))
																		break;
															/**/
															if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																foreach (ws_plugin__s2member_trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"])) as $recipient)
																	($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_eot_del_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_eot_del_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
														}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_handle_user_deletions", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_handle_user_deletions", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
?>