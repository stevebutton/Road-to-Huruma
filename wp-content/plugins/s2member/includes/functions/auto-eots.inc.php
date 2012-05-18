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
Function processed by WP-Cron. This handles Auto-EOTs.

If you have a HUGE userbase, increase the max EOTS per process.
	~ But NOTE, this runs $per_process ( per Blog ) on a Multisite Network.
To increase, use: add_filter ("ws_plugin__s2member_auto_eot_system_per_process");

s2Member v3.2 ( VERY IMPORTANT ).
	AND `meta_value` != ''
Because update_user_option() may NOT always delete the key.
*/
if (!function_exists ("ws_plugin__s2member_auto_eot_system"))
	{
		function ws_plugin__s2member_auto_eot_system ($per_process = 10)
			{
				global $wpdb; /* Need global DB obj. */
				global $current_site, $current_blog; /* Multisite. */
				/**/
				include_once ABSPATH . "wp-admin/includes/admin.php";
				/**/
				do_action ("ws_plugin__s2member_before_auto_eot_system", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"]) /* Enabled? */
					{
						$per_process = apply_filters ("ws_plugin__s2member_auto_eot_system_per_process", $per_process, get_defined_vars ());
						/**/
						if (is_array ($eots = $wpdb->get_results ("SELECT `user_id` AS `ID` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_auto_eot_time' AND `meta_value` != '' AND `meta_value` <= '" . $wpdb->escape (strtotime ("now")) . "' LIMIT " . $per_process)))
							{
								foreach ($eots as $eot) /* Go through the array of EOTS. We need to (demote|delete) each of them. */
									{
										if (($user_id = $eot->ID) && is_object ($user = new WP_User ($user_id)) && $user->ID)
											{
												delete_user_option ($user_id, "s2member_auto_eot_time"); /* ALWAYS delete this. */
												/**/
												if (!$user->has_cap ("administrator")) /* Do NOT process Administrator accounts. */
													{
														if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "demote")
															{
																$custom = get_user_option ("s2member_custom", $user_id);
																$subscr_id = get_user_option ("s2member_subscr_id", $user_id);
																$fields = get_user_option ("s2member_custom_fields", $user_id);
																/**/
																$demotion_role = ws_plugin__s2member_force_demotion_role ("subscriber");
																$user->set_role ($demotion_role); /* Defaults to Free Subscriber. */
																/**/
																foreach ($user->allcaps as $cap => $cap_enabled)
																	if (preg_match ("/^access_s2member_ccap_/", $cap))
																		$user->remove_cap ($ccap = $cap);
																/**/
																delete_user_option ($user_id, "s2member_custom");
																delete_user_option ($user_id, "s2member_subscr_id");
																/**/
																if (!apply_filters ("ws_plugin__s2member_preserve_paid_registration_times", true, get_defined_vars ()))
																	delete_user_option ($user_id, "s2member_paid_registration_times");
																/**/
																delete_user_option ($user_id, "s2member_last_payment_time");
																delete_user_option ($user_id, "s2member_auto_eot_time");
																/**/
																delete_user_option ($user_id, "s2member_file_download_access_arc");
																delete_user_option ($user_id, "s2member_file_download_access_log");
																/**/
																ws_plugin__s2member_append_user_notes ($user_id, "Demoted by s2Member: " . date ("D M j, Y g:i a T"));
																/**/
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"] && is_array ($cv = preg_split ("/\|/", $custom)))
																	{
																		foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_urls"]) as $url) /* Handle EOT Notifications. */
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
																if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_del_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $custom)))
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
																do_action ("ws_plugin__s2member_during_auto_eot_system_during_demote", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_eot_behavior"] === "delete")
															{
																if (is_multisite ()) /* Multisite does NOT actually delete; ONLY removes. */
																	{
																		remove_user_from_blog ($user_id, $current_blog->blog_id);
																		/* This will automatically trigger `eot_del_notification_urls` as well. */
																		ws_plugin__s2member_handle_ms_user_deletions ($user_id, $current_blog->blog_id, "s2says");
																	}
																/**/
																else /* Otherwise, we can actually delete them. */
																	/* This will automatically trigger `eot_del_notification_urls` as well. */
																	wp_delete_user ($user_id); /* `ws_plugin__s2member_handle_user_deletions()` */
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_auto_eot_system_during_delete", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_auto_eot_system", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
											}
									}
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_auto_eot_system", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
This function allows the Auto-EOT Sytem to be
processed through a server-side Cron Job.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_auto_eot_system_via_cron"))
	{
		function ws_plugin__s2member_auto_eot_system_via_cron ()
			{
				do_action ("ws_plugin__s2member_before_auto_eot_system_via_cron", get_defined_vars ());
				/**/
				if ($_GET["s2member_auto_eot_system_via_cron"]) /* Being called through HTTP? */
					{
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["auto_eot_system_enabled"])
							{
								ws_plugin__s2member_auto_eot_system ();
								/**/
								do_action ("ws_plugin__s2member_during_auto_eot_system_via_cron", get_defined_vars ());
							}
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_auto_eot_system_via_cron", get_defined_vars ());
			}
	}
/*
Adds a scheduled task for s2Member's Auto-EOT System.
*/
if (!function_exists ("ws_plugin__s2member_add_auto_eot_system"))
	{
		function ws_plugin__s2member_add_auto_eot_system ()
			{
				do_action ("ws_plugin__s2member_before_add_auto_eot_system", get_defined_vars ());
				/**/
				if (!ws_plugin__s2member_delete_auto_eot_system ())
					{
						return apply_filters ("ws_plugin__s2member_add_auto_eot_system", false, get_defined_vars ());
					}
				else if (function_exists ("wp_cron")) /* Otherwise, we can schedule. */
					{
						wp_schedule_event (time (), "every10m", "ws_plugin__s2member_auto_eot_system__schedule");
						/**/
						return apply_filters ("ws_plugin__s2member_add_auto_eot_system", true, get_defined_vars ());
					}
				else /* Otherwise, it would appear that WP-Cron is not available. */
					{
						return apply_filters ("ws_plugin__s2member_add_auto_eot_system", false, get_defined_vars ());
					}
			}
	}
/*
Delete scheduled tasks for s2Member's Auto-EOT System.
*/
if (!function_exists ("ws_plugin__s2member_delete_auto_eot_system"))
	{
		function ws_plugin__s2member_delete_auto_eot_system ()
			{
				do_action ("ws_plugin__s2member_before_delete_auto_eot_system", get_defined_vars ());
				/**/
				if (function_exists ("wp_cron"))
					{
						wp_clear_scheduled_hook ("s2member_auto_eot_system"); /* This is for backward compatibility. */
						wp_clear_scheduled_hook ("ws_plugin__s2member_auto_eot_system__schedule"); /* Since v3.0.3. */
						/**/
						return apply_filters ("ws_plugin__s2member_delete_auto_eot_system", true, get_defined_vars ());
					}
				else /* Otherwise, it would appear that WP-Cron is not available. */
					{
						return apply_filters ("ws_plugin__s2member_delete_auto_eot_system", false, get_defined_vars ());
					}
			}
	}
?>