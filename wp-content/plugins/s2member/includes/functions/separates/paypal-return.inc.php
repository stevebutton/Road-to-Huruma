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
Handles PayPal® Return URL processing.
This is used ONLY in PayPal® Standard Integration.
Attach to: add_action("init");
*/
if (!function_exists ("s__ws_plugin__s2member_paypal_return"))
	{
		function s__ws_plugin__s2member_paypal_return ()
			{
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				do_action ("ws_plugin__s2member_before_paypal_return", get_defined_vars ());
				/**/
				if ($_GET["s2member_paypal_return"] && ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"] || $_GET["s2member_paypal_proxy"]))
					{
						if (is_array ($paypal = ws_plugin__s2member_paypal_postvars ()) && ($_paypal = $paypal)) /* Verify POST vars. */
							{
								$paypal["s2member_log"][] = "Return-Data received on: " . date ("D M j, Y g:i:s a T");
								$paypal["s2member_log"][] = "s2Member POST vars verified " . /* Indicate Proxy Key. */
								( ($postvars["proxy_verified"]) ? "with a Proxy Key" : "through a POST back to PayPal®.");
								/**/
								$payment_status_issues = "/^(failed|denied|expired|refunded|partially_refunded|reversed|reversal|canceled_reversal|voided)$/i";
								/**/
								if (preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", $paypal["custom"]))
									{ /* The business address validation was removed from this routine, because PayPal® always fills that with the primary
											email address. In cases where an alternate PayPal® address is being paid, validation was not possible. */
										$paypal["s2member_log"][] = "s2Member originating domain ( _SERVER[HTTP_HOST] ) validated.";
										/*
										Custom conditionals can be applied by filters.
										*/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										if (!apply_filters ("ws_plugin__s2member_during_paypal_return_conditionals", false, get_defined_vars ()))
											{
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/*
												Specific Post/Page Access ~ Sales.
												*/
												if (/**/(preg_match ("/^web_accept$/i", $paypal["txn_type"]))/**/
												&& (preg_match ("/^sp\:[0-9,]+\:[0-9]+$/", $paypal["item_number"]))/**/
												&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
												&& ($paypal["txn_id"])/**/)
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_return_before_sp_access", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept) for Specific Post/Page Access.";
														/**/
														list (, $paypal["sp_ids"], $paypal["hours"]) = preg_split ("/\:/", $paypal["item_number"], 3);
														/**/
														if (($sp_access_url = ws_plugin__s2member_sp_access_link_gen ($paypal["sp_ids"], $paypal["hours"], false)))
															{
																$processing = $during = true; /* Yes, we ARE processing this. */
																/**/
																setcookie ("s2member_sp_tracking", ws_plugin__s2member_encrypt ($paypal["txn_id"]), time () + 31556926, "/");
																/**/
																$paypal["s2member_log"][] = "Transient Tracking Cookie set on (web_accept) for Specific Post/Page Access.";
																/**/
																if ($processing && ($code = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_tracking_codes"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
																	{
																		if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%amount%%/i", ws_plugin__s2member_esc_ds ($paypal["mc_gross"]), $code)) && ($code = preg_replace ("/%%txn_id%%/i", ws_plugin__s2member_esc_ds ($paypal["txn_id"]), $code)))
																			if (($code = preg_replace ("/%%item_number%%/i", ws_plugin__s2member_esc_ds ($paypal["item_number"]), $code)) && ($code = preg_replace ("/%%item_name%%/i", ws_plugin__s2member_esc_ds ($paypal["item_name"]), $code)))
																				if (($code = preg_replace ("/%%first_name%%/i", ws_plugin__s2member_esc_ds ($paypal["first_name"]), $code)) && ($code = preg_replace ("/%%last_name%%/i", ws_plugin__s2member_esc_ds ($paypal["last_name"]), $code)))
																					if (($code = preg_replace ("/%%full_name%%/i", ws_plugin__s2member_esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $code)))
																						if (($code = preg_replace ("/%%payer_email%%/i", ws_plugin__s2member_esc_ds ($paypal["payer_email"]), $code)))
																							/**/
																							if (($code = trim (preg_replace ("/%%(.+?)%%/i", "", $code)))) /* This gets stored into a Transient Queue. */
																								{
																									$paypal["s2member_log"][] = "Storing Specific Post/Page Tracking Codes into a Transient Queue for s2Member. These will be processed on-site.";
																									set_transient (md5 ("s2member_transient_sp_tracking_codes_" . $paypal["txn_id"]), $code, 43200);
																								}
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_return_during_sp_access", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "Redirecting Customer to the Specific Post/Page.";
																/**/
																wp_redirect($sp_access_url); /* Redirect Customer immediately. */
															}
														else /* Otherwise, the ID must have been invalid. Or the Post/Page was deleted. */
															{
																$paypal["s2member_log"][] = "Unable to generate Specific Post/Page Access Link. Does your Leading Post/Page still exist?";
																/**/
																$paypal["s2member_log"][] = "Redirecting Customer to the Home Page, due to an error that occurred.";
																/**/
																echo '<script type="text/javascript">' . "\n";
																echo "alert('ERROR: Unable to generate Access Link. Please contact Support for assistance.');" . "\n";
																echo "window.location = '" . esc_js (get_bloginfo ("url")) . "';";
																echo '</script>' . "\n";
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_return_after_sp_access", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												New Subscriptions.
												Possibly containing advanced update vars
												( option_name1, option_selection1 ); which allow account modifications.
												*/
												else if (/**/(preg_match ("/^(web_accept|subscr_signup|subscr_payment)$/i", $paypal["txn_type"]))/**/
												&& (preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]))/**/
												&& ($paypal["subscr_id"] || ($paypal["subscr_id"] = $paypal["txn_id"]))/**/
												&& (!preg_match ($payment_status_issues, $paypal["payment_status"]))/**/)
													{ /* With Auto-Return/PDT, PayPal will send subscr_payment instead of subscr_signup to the return URL.
															So we need to look for (web_accept|subscr_signup|subscr_payment), and treat them as the same. */
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_return_before_subscr_signup", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup|subscr_payment).";
														/**/
														list ($paypal["level"], $paypal["ccaps"], $paypal["eotper"]) = preg_split ("/\:/", $paypal["item_number"], 3);
														/*
														New Subscription with advanced update vars ( option_name1, option_selection1 ).
														*/
														if (preg_match ("/(updat|upgrad)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* Advanced Subscription update modifications. */
															/* This advanced method is required whenever a Subscription that is already completed, or was never setup to recur in the first place needs to be modified. PayPal® will not allow the
																		modify=2 parameter to be used in those scenarios, because technically there is nothing to update. The only thing to be updated is the account. */
															{
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_return_before_subscr_signup_w_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup|subscr_payment) w/ update vars.";
																/**/
																/* Check for both the old & new subscr_id's, just in case the IPN routine already changed it. */
																if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
																	{
																		if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																			{
																				$processing = $during = true; /* Yes, we ARE processing this. */
																				/**/
																				$user->set_role ("s2member_level" . $paypal["level"]);
																				/**/
																				foreach ($user->allcaps as $cap => $cap_enabled)
																					if (preg_match ("/^access_s2member_ccap_/", $cap))
																						$user->remove_cap ($ccap = $cap);
																				/**/
																				foreach (preg_split ("/[\r\n\t\s;,]+/", $paypal["ccaps"]) as $ccap)
																					if (strlen ($ccap)) /* Don't add empty capabilities. */
																						$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
																				/**/
																				update_user_option ($user_id, "s2member_subscr_id", $paypal["subscr_id"]);
																				update_user_option ($user_id, "s2member_custom", $paypal["custom"]);
																				/**/
																				delete_user_option ($user_id, "s2member_file_download_access_arc");
																				delete_user_option ($user_id, "s2member_file_download_access_log");
																				/**/
																				if (preg_match ("/^web_accept$/i", $paypal["txn_type"]) && $paypal["eotper"])
																					update_user_option ($user_id, "s2member_auto_eot_time", ws_plugin__s2member_paypal_auto_eot_time ("", "", "", $paypal["eotper"]));
																				else /* Otherwise, we need to clear the Auto-EOT Time. */
																					delete_user_option ($user_id, "s2member_auto_eot_time");
																				/**/
																				$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
																				$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
																				$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
																				update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
																				/**/
																				ws_plugin__s2member_clear_user_note_lines ($user_id, "/^Demoted by s2Member\:/");
																				/**/
																				$paypal["s2member_log"][] = "s2Member Level/Capabilities updated w/ advanced update routines.";
																				/**/
																				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																				do_action ("ws_plugin__s2member_during_paypal_return_during_subscr_signup_w_update_vars", get_defined_vars ());
																				unset ($__refs, $__v); /* Unset defined __refs, __v. */
																				/**/
																				$paypal["s2member_log"][] = "Redirecting Customer to the Login Page. They need to log back in after this modification.";
																				/**/
																				echo '<script type="text/javascript">' . "\n";
																				echo "alert('Thank you! You\\'ve been updated to:\\n\\n" . esc_js ($paypal["item_name"]) . "\\n\\nPlease log back in now.');" . "\n";
																				echo "window.location = '" . esc_js (wp_login_url ()) . "';" . "\n";
																				echo '</script>' . "\n";
																			}
																		else
																			{
																				$paypal["s2member_log"][] = "Unable to modify Subscription. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																				/**/
																				$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
																				/**/
																				echo '<script type="text/javascript">' . "\n";
																				echo "alert('ERROR: Unable to modify Subscription. Please contact Support for assistance.\\n\\nThe existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access. Please make sure that you are NOT logged in as an Administrator while testing.');" . "\n";
																				echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																				echo '</script>' . "\n";
																			}
																	}
																else
																	{
																		$paypal["s2member_log"][] = "Unable to modify Subscription. Could not get the existing User ID from the DB. Please check the on0 and os0 variables in your Button Code.";
																		/**/
																		$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
																		/**/
																		echo '<script type="text/javascript">' . "\n";
																		echo "alert('ERROR: Unable to modify Subscription. Please contact Support for assistance.\\n\\nCould not get the existing User ID from the DB.');" . "\n";
																		echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																		echo '</script>' . "\n";
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_return_after_subscr_signup_w_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/*
														New Subscription. Normal Subscription signup, we are not updating anything for a past Subscription.
														*/
														else /* Else this is a normal Subscription signup, we are not updating an existing Subscription. */
															{
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_return_before_subscr_signup_wo_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$processing = $during = true; /* Yes, we ARE processing this new Subscription request. */
																/**/
																$paypal["s2member_log"][] = "s2Member txn_type identified as (web_accept|subscr_signup|subscr_payment) w/o update vars.";
																/**/
																setcookie ("s2member_subscr_id", ws_plugin__s2member_encrypt ($paypal["subscr_id"]), time () + 31556926, "/");
																setcookie ("s2member_custom", ws_plugin__s2member_encrypt ($paypal["custom"]), time () + 31556926, "/");
																setcookie ("s2member_level", ws_plugin__s2member_encrypt ($paypal["item_number"]), time () + 31556926, "/");
																/**/
																$paypal["s2member_log"][] = "Registration Cookies set on (web_accept|subscr_signup|subscr_payment) w/o update vars.";
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_return_during_subscr_signup_wo_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
																/**/
																$paypal["s2member_log"][] = "Redirecting Customer to Registration Page. They need to Register now.";
																/**/
																if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ())
																	{
																		echo '<script type="text/javascript">' . "\n";
																		echo "alert('Thank you! Your account has been approved.\\nThe next step is to Register.\\n\\nPlease click OK to Register now.');" . "\n";/**/
																		echo "window.location = '" . esc_js (apply_filters ("wp_signup_location", get_bloginfo ("wpurl") . "/wp-signup.php")) . "';" . "\n";
																		echo '</script>' . "\n";
																	}
																else /* Otherwise, this is NOT a Multisite install. Or it is, but the Super Administrator is NOT selling Blog creation. */
																	{
																		echo '<script type="text/javascript">' . "\n";
																		echo "alert('Thank you! Your account has been approved.\\nThe next step is to Register a Username.\\n\\nPlease click OK to Register now.');" . "\n";/**/
																		echo "window.location = '" . esc_js (add_query_arg ("action", urlencode ("register"), wp_login_url ())) . "';" . "\n";
																		echo '</script>' . "\n";
																	}
																/**/
																eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																do_action ("ws_plugin__s2member_during_paypal_return_after_subscr_signup_wo_update_vars", get_defined_vars ());
																unset ($__refs, $__v); /* Unset defined __refs, __v. */
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_return_after_subscr_signup", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												/*
												Subscription modifications.
												*/
												else if (/**/(preg_match ("/^subscr_modify$/i", $paypal["txn_type"]))/**/
												&& (preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $paypal["item_number"]))/**/
												&& ($paypal["subscr_id"])/**/)
													{
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_return_before_subscr_modify", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
														/**/
														$paypal["s2member_log"][] = "s2Member txn_type identified as subscr_modify.";
														/**/
														list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
														/**/
														if (($user_id = ws_plugin__s2member_paypal_user_id ($paypal["subscr_id"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
															{
																if (!$user->has_cap ("administrator")) /* Do NOT process this routine on Administrators. */
																	{
																		$processing = $during = true; /* Yes, we ARE processing this. */
																		/**/
																		$user->set_role ("s2member_level" . $paypal["level"]);
																		/**/
																		foreach ($user->allcaps as $cap => $cap_enabled)
																			if (preg_match ("/^access_s2member_ccap_/", $cap))
																				$user->remove_cap ($ccap = $cap);
																		/**/
																		foreach (preg_split ("/[\r\n\t\s;,]+/", $paypal["ccaps"]) as $ccap)
																			if (strlen ($ccap)) /* Don't add empty capabilities. */
																				$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
																		/**/
																		update_user_option ($user_id, "s2member_subscr_id", $paypal["subscr_id"]);
																		update_user_option ($user_id, "s2member_custom", $paypal["custom"]);
																		/**/
																		delete_user_option ($user_id, "s2member_file_download_access_arc");
																		delete_user_option ($user_id, "s2member_file_download_access_log");
																		/**/
																		delete_user_option ($user_id, "s2member_auto_eot_time");
																		/**/
																		$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
																		$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
																		$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
																		update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
																		/**/
																		ws_plugin__s2member_clear_user_note_lines ($user_id, "/^Demoted by s2Member\:/");
																		/**/
																		$paypal["s2member_log"][] = "s2Member Level/Capabilities updated on Subscription modification.";
																		/**/
																		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																		do_action ("ws_plugin__s2member_during_paypal_return_during_subscr_modify", get_defined_vars ());
																		unset ($__refs, $__v); /* Unset defined __refs, __v. */
																		/**/
																		$paypal["s2member_log"][] = "Redirecting Customer to the Login Page. They need to log back in after this modification.";
																		/**/
																		echo '<script type="text/javascript">' . "\n";
																		echo "alert('Thank you! You\\'ve been updated to:\\n\\n" . esc_js ($paypal["item_name"]) . "\\n\\nPlease log back in now.');" . "\n";
																		echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																		echo '</script>' . "\n";
																	}
																else
																	{
																		$paypal["s2member_log"][] = "Unable to modify Subscription. The existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access.";
																		/**/
																		$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
																		/**/
																		echo '<script type="text/javascript">' . "\n";
																		echo "alert('ERROR: Unable to modify Subscription. Please contact Support for assistance.\\n\\nThe existing User ID is associated with an Administrator. Stopping here. Otherwise, an Administrator could lose access. Please make sure that you are NOT logged in as an Administrator while testing.');" . "\n";
																		echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																		echo '</script>' . "\n";
																	}
															}
														else
															{
																$paypal["s2member_log"][] = "Unable to modify Subscription. Could not get the existing User ID from the DB.";
																/**/
																$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
																/**/
																echo '<script type="text/javascript">' . "\n";
																echo "alert('ERROR: Unable to modify Subscription. Please contact Support for assistance.\\n\\nCould not get the existing User ID from the DB.');" . "\n";
																echo "window.location = '" . esc_js (wp_login_url ()) . "';";
																echo '</script>' . "\n";
															}
														/**/
														eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
														do_action ("ws_plugin__s2member_during_paypal_return_after_subscr_modify", get_defined_vars ());
														unset ($__refs, $__v); /* Unset defined __refs, __v. */
													}
												else
													{
														$paypal["s2member_log"][] = "Unexpected txn_type. The PayPal® txn_type/status did not match a required action.";
														/**/
														$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
														/**/
														echo '<script type="text/javascript">' . "\n";
														echo "alert('ERROR: Unexpected txn_type/status. Please contact Support for assistance.\\n\\nThe PayPal® txn_type/status did not match a required action.');" . "\n";
														echo "window.location = '" . esc_js (wp_login_url ()) . "';";
														echo '</script>' . "\n";
													}
											}
										else /* Else a custom conditional has been applied by filters. */
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								else
									{
										$paypal["s2member_log"][] = "Unable to verify _SERVER[HTTP_HOST]. Please check the `custom` value in your Button Code. It MUST start with your domain name.";
										/**/
										$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
										/**/
										echo '<script type="text/javascript">' . "\n";
										echo "alert('ERROR: Unable to verify _SERVER[HTTP_HOST]. Please contact Support for assistance.\\n\\nIf you are the site owner, please check the `custom` value in your Button Code. It MUST start with your domain name.');" . "\n";
										echo "window.location = '" . esc_js (wp_login_url ()) . "';";
										echo '</script>' . "\n";
									}
							}
						else if ((!isset ($_GET["tx"]) && (empty ($_POST) || $_POST["auth"])) || preg_match ("/ty-email/", $_GET["s2member_paypal_proxy_use"]))
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_return_before_no_return_data", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$paypal["s2member_log"][] = "No Return-Data from PayPal®. Customer must wait for Email Confirmation.";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_return_during_no_return_data", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$paypal["s2member_log"][] = "Redirecting Customer to the Home Page.";
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "alert('Thank you! ( please check your email ).\\n\\n* Note: It can take ( up to 15 minutes ) for Email Confirmation. If you don\'t receive email confirmation in the next 15 minutes, please contact Support.');" . "\n";
								echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "alert('** Sandbox Mode ** You will probably NOT receive this Email Confirmation in Sandbox Mode. Sandbox addresses are usually bogus ( for testing ).');" . "\n" : "";
								echo "window.location = '" . esc_js (get_bloginfo ("url")) . "';";
								echo '</script>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_return_after_no_return_data", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						else /* Extensive log reporting here. This is an area where many site owners find trouble. Depending on server configuration; remote HTTPS connections may fail. */
							{
								$paypal["s2member_log"][] = "Unable to verify POST vars. This is most likely related to an invalid PayPal® configuration. Please check: s2Member -> PayPal® Options.";
								$paypal["s2member_log"][] = "If you're absolutely SURE that your PayPal® configuration is valid, you may want to run some tests on your server, just to be sure \$_POST variables are populated, and that your server is able to connect to PayPal® over an HTTPS connection.";
								$paypal["s2member_log"][] = "s2Member uses the WP_Http class for remote connections; which will try to use cURL first, and then fall back on the FOPEN method when cURL is not available. On a Windows® server, you may have to disable your cURL extension. Instead, set allow_url_fopen = yes in your php.ini file. The cURL extension (usually) does NOT support SSL connections on a Windows® server.";
								$paypal["s2member_log"][] = var_export ($_REQUEST, true); /* Recording _POST + _GET vars for analysis and debugging. */
								/**/
								$paypal["s2member_log"][] = "Redirecting Customer to the Login Page, due to an error that occurred.";
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "alert('ERROR: Unable to verify POST vars. Please contact Support for assistance.\\n\\nThis is most likely related to an invalid PayPal® configuration. If you are the site owner, please check: s2Member -> PayPal® Options.');" . "\n";
								echo "window.location = '" . esc_js (wp_login_url ()) . "';";
								echo '</script>' . "\n";
							}
						/*
						Add RTN proxy ( when available ) to the $paypal array.
						*/
						if ($_GET["s2member_paypal_proxy"]) /* For proxy identification. */
							$paypal["s2member_paypal_proxy"] = $_GET["s2member_paypal_proxy"];
						/*
						Add IPN proxy use vars ( when available ) to the $paypal array.
						*/
						if ($_GET["s2member_paypal_proxy_use"]) /* For proxy specifications. */
							$paypal["s2member_paypal_proxy_use"] = $_GET["s2member_paypal_proxy_use"];
						/*
						Also add RTN proxy self-verification ( when available ) to the $paypal array.
						*/
						if ($_GET["s2member_paypal_proxy_verification"]) /* Proxy identification w/verification. */
							$paypal["s2member_paypal_proxy_verification"] = $_GET["s2member_paypal_proxy_verification"];
						/*
						If debugging/logging is enabled; we need to append $paypal to the log file.
							Logging now supports Multisite Networking as well.
						*/
						$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
						$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
						$log2 = (is_multisite () && !is_main_site ()) ? "paypal-rtn-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "paypal-rtn.log";
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"]) /* Append to log? */
							if (is_dir ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"])) /* Dir exists? */
								if (is_writable ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
									file_put_contents ($logs_dir . "/" . $log2, $log4 . "\n" . var_export ($paypal, true) . "\n\n", FILE_APPEND);
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_paypal_return", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						exit ();
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_paypal_return", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
			}
	}
?>