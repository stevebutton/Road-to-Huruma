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
Get POST vars from PayPal®, verify and return array.
*/
if (!function_exists ("ws_plugin__s2member_paypal_postvars"))
	{
		function ws_plugin__s2member_paypal_postvars ()
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_postvars", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/*
				Custom conditionals can be applied by filters.
				*/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				if (! ($postvars = apply_filters ("ws_plugin__s2member_during_paypal_postvars_conditionals", array (), get_defined_vars ())))
					{
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($_GET["tx"] && !$_GET["s2member_paypal_proxy"]) /* Auto-Return w/PDT. */
							{
								$postback["tx"] = $_GET["tx"];
								$postback["cmd"] = "_notify-synch";
								$postback["at"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"];
								/**/
								$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
								/**/
								if (preg_match ("/^SUCCESS/i", ($response = trim (ws_plugin__s2member_remote ("https://" . $endpoint . "/cgi-bin/webscr", $postback, array ("timeout" => 20))))))
									{
										foreach (preg_split ("/[\r\n]+/", preg_replace ("/^SUCCESS/i", "", $response)) as $varline)
											{
												list ($key, $value) = preg_split ("/\=/", $varline, 2);
												if (strlen ($key = trim ($key)) && strlen ($value = trim ($value)))
													$postvars[$key] = trim (stripslashes (urldecode ($value)));
											}
										/**/
										return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
									}
								else /* Nope. */
									return false;
							}
						else if (is_array ($postvars = stripslashes_deep ($_REQUEST)))
							{
								foreach ($postvars as $key => $value)
									if (preg_match ("/^s2member_/", $key))
										unset ($postvars[$key]);
								/**/
								$postback = $postvars; /* Copy. */
								$postback["cmd"] = "_notify-validate";
								/**/
								$postvars = ws_plugin__s2member_trim_deep ($postvars);
								/**/
								$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
								/**/
								if ($_GET["s2member_paypal_proxy"] && $_GET["s2member_paypal_proxy_verification"] === ws_plugin__s2member_paypal_proxy_key_gen ())
									return apply_filters ("ws_plugin__s2member_paypal_postvars", array_merge ($postvars, array ("proxy_verified" => $_GET["s2member_paypal_proxy"])), get_defined_vars ());
								/**/
								else if (strtolower (trim (ws_plugin__s2member_remote ("https://" . $endpoint . "/cgi-bin/webscr", $postback, array ("timeout" => 20)))) === "verified")
									return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
								/**/
								else /* Nope. */
									return false;
							}
						else /* Nope. */
							return false;
					}
				else /* Else a custom conditional has been applied by filters. */
					{
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
					}
			}
	}
/*
Function generated a PayPal® Proxy Key, for simulated IPN responses.
*/
if (!function_exists ("ws_plugin__s2member_paypal_proxy_key_gen"))
	{
		function ws_plugin__s2member_paypal_proxy_key_gen () /* Generate Key. */
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_proxy_key_gen", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (!is_multisite () || is_main_site ())
					$key = md5 (ws_plugin__s2member_xencrypt (preg_replace ("/\:[0-9]+$/", "", $_SERVER["HTTP_HOST"])));
				/**/
				else if (is_multisite ())
					$key = md5 (ws_plugin__s2member_xencrypt ($current_blog->domain . $current_blog->path));
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_proxy_key_gen", $key, get_defined_vars ());
			}
	}
/*
Get the custom value for an existing Member, referenced by a Subscr. ID.
A second lookup parameter can be provided, which will trigger some additional routines.
The $os0 value comes from advanced update vars, pertaining to subscription modifications.
*/
if (!function_exists ("ws_plugin__s2member_paypal_custom"))
	{
		function ws_plugin__s2member_paypal_custom ($subscr_id = FALSE, $os0 = FALSE)
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_custom", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
					{
						if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
						|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
							if (($custom = get_user_option ("s2member_custom", $q->user_id)))
								return apply_filters ("ws_plugin__s2member_paypal_custom", $custom, get_defined_vars ());
					}
				else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
					{
						if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
							if (($custom = get_user_option ("s2member_custom", $q->user_id)))
								return apply_filters ("ws_plugin__s2member_paypal_custom", $custom, get_defined_vars ());
					}
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_custom", false, get_defined_vars ());
			}
	}
/*
Get the user ID for an existing Member, referenced by a Subscr. ID.
A second lookup parameter can be provided, which will trigger some additional routines.
The $os0 value comes from advanced update vars, pertaining to subscription modifications.
*/
if (!function_exists ("ws_plugin__s2member_paypal_user_id"))
	{
		function ws_plugin__s2member_paypal_user_id ($subscr_id = FALSE, $os0 = FALSE)
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_user_id", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
					{
						if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
						|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
							return apply_filters ("ws_plugin__s2member_paypal_user_id", $q->user_id, get_defined_vars ());
					}
				else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
					{
						if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
							return apply_filters ("ws_plugin__s2member_paypal_user_id", $q->user_id, get_defined_vars ());
					}
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_user_id", false, get_defined_vars ());
			}
	}
/*
Get the email value for an existing Member, referenced by a Subscr. ID.
A second lookup parameter can be provided, which will trigger some additional routines.
The $os0 value comes from advanced update vars, pertaining to subscription modifications.
*/
if (!function_exists ("ws_plugin__s2member_paypal_email"))
	{
		function ws_plugin__s2member_paypal_email ($subscr_id = FALSE, $os0 = FALSE)
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_email", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($subscr_id && $os0) /* This case includes some additional routines that can use the $os0 value. */
					{
						if (($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND (`meta_value` = '" . $wpdb->escape ($subscr_id) . "' OR `meta_value` = '" . $wpdb->escape ($os0) . "') LIMIT 1"))/**/
						|| ($q = $wpdb->get_row ("SELECT `ID` AS `user_id` FROM `" . $wpdb->users . "` WHERE `ID` = '" . $wpdb->escape ($os0) . "' LIMIT 1")))
							if (is_object ($user = new WP_User ($q->user_id)) && ($email = $user->user_email))
								return apply_filters ("ws_plugin__s2member_paypal_email", $email, get_defined_vars ());
					}
				else if ($subscr_id) /* Otherwise, if all we have is a Subscr. ID value. */
					{
						if ($q = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))
							if (is_object ($user = new WP_User ($q->user_id)) && ($email = $user->user_email))
								return apply_filters ("ws_plugin__s2member_paypal_email", $email, get_defined_vars ());
					}
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_email", false, get_defined_vars ());
			}
	}
/*
Calculate Auto-EOT Time, based on last_payment_time, period1, and period3.
Used by s2Member's built-in Auto-EOT System, and also by its IPN routines.
	last_payment_time can be forced w/ $lpt ( i.e. for delayed eots )
*/
if (!function_exists ("ws_plugin__s2member_paypal_auto_eot_time"))
	{
		function ws_plugin__s2member_paypal_auto_eot_time ($user_id = FALSE, $period1 = FALSE, $period3 = FALSE, $eotper = FALSE, $lpt = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_auto_eot_time", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($user_id && ($user = new WP_User ($user_id)) && $user->ID) /* Valid user_id? */
					{
						$registration_time = strtotime ($user->user_registered);
						$last_payment_time = (int)get_user_option ("s2member_last_payment_time", $user_id);
						$last_payment_time = ((int)$lpt) ? (int)$lpt : (int)$last_payment_time;
						/**/
						if (! ($p1_time = 0) && ($period1 = trim (strtoupper ($period1))))
							{
								list ($num, $span) = preg_split ("/ /", $period1, 2);
								/**/
								$days = 0; /* Days start at 0. */
								/**/
								if (is_numeric ($num) && !is_numeric ($span))
									{
										$days = ($span === "D") ? 1 : $days;
										$days = ($span === "W") ? 7 : $days;
										$days = ($span === "M") ? 30 : $days;
										$days = ($span === "Y") ? 365 : $days;
									}
								/**/
								$p1_days = (int)$num * (int)$days;
								$p1_time = $p1_days * 86400;
							}
						/**/
						if (! ($p3_time = 0) && ($period3 = trim (strtoupper ($period3))))
							{
								list ($num, $span) = preg_split ("/ /", $period3, 2);
								/**/
								$days = 0; /* Days start at 0. */
								/**/
								if (is_numeric ($num) && !is_numeric ($span))
									{
										$days = ($span === "D") ? 1 : $days;
										$days = ($span === "W") ? 7 : $days;
										$days = ($span === "M") ? 30 : $days;
										$days = ($span === "Y") ? 365 : $days;
									}
								/**/
								$p3_days = (int)$num * (int)$days;
								$p3_time = $p3_days * 86400;
							}
						/**/
						if (!$last_payment_time) /* If there's been no payment yet.
						After p1, if there was a p1. Otherwise, reg. time + 1 day grace. */
							{
								$auto_eot_time = $registration_time + $p1_time + 86400;
							}
						/* Else if p1, and last payment within p1, last + p1 + 1 day grace. */
						else if ($p1_time && $last_payment_time <= $registration_time + $p1_time)
							{
								$auto_eot_time = $last_payment_time + $p1_time + 86400;
							}
						else /* Otherwise, after last payment + p3 + 1 day grace. */
							{
								$auto_eot_time = $last_payment_time + $p3_time + 86400;
							}
					}
				/**/
				else if ($eotper) /* Otherwise, if we have a specific EOT period; calculate from today. */
					{
						if (! ($eot_time = 0) && ($eotper = trim (strtoupper ($eotper))))
							{
								list ($num, $span) = preg_split ("/ /", $eotper, 2);
								/**/
								$days = 0; /* Days start at 0. */
								/**/
								if (is_numeric ($num) && !is_numeric ($span))
									{
										$days = ($span === "D") ? 1 : $days;
										$days = ($span === "W") ? 7 : $days;
										$days = ($span === "M") ? 30 : $days;
										$days = ($span === "Y") ? 365 : $days;
									}
								/**/
								$eot_days = (int)$num * (int)$days;
								$eot_time = $eot_days * 86400;
							}
						/**/
						$auto_eot_time = strtotime ("now") + $eot_time + 86400;
					}
				/**/
				$auto_eot_time = ($auto_eot_time <= 0) ? strtotime ("now") : $auto_eot_time;
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_auto_eot_time", $auto_eot_time, get_defined_vars ());
			}
	}
/*
Function converts a term [DWMY] into PayPal® Pro format.
*/
if (!function_exists ("ws_plugin__s2member_paypal_pro_term"))
	{
		function ws_plugin__s2member_paypal_pro_term ($term = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_pro_term", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$paypal_pro_terms = array ("D" => "Day", "W" => "Week", "M" => "Month", "Y" => "Year");
				/**/
				$pro_term = $paypal_pro_terms[strtoupper ($term)];
				return apply_filters ("ws_plugin__s2member_paypal_pro_term", $pro_term, get_defined_vars ());
			}
	}
/*
Function converts a term [Day,Week,Month,Year] into PayPal® Standard format.
*/
if (!function_exists ("ws_plugin__s2member_paypal_std_term"))
	{
		function ws_plugin__s2member_paypal_std_term ($term = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_std_term", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$paypal_std_terms = array ("DAY" => "D", "WEEK" => "W", "MONTH" => "M", "YEAR" => "Y");
				/**/
				$std_term = $paypal_std_terms[strtoupper ($term)];
				return apply_filters ("ws_plugin__s2member_paypal_std_term", $std_term, get_defined_vars ());
			}
	}
/*
Function converts a term [D,W,M,Y,L,Day,Week,Month,Year,Lifetime] into Daily, Weekly, Monthly, Yearly, Lifetime.
This function can also handle "Period Term" combinations. Where the Period will be stripped automatically before conversion.
For example, "1 D", would become, just "Daily". Another example, "3 Y" would become "Yearly"; and "1 L", would become "Lifetime".
	Recurring examples: "2 W", becomes "Bi-Weekly", "3 M" becomes Quarterly, and "2 M" becomes "Bi-Monthly".
*/
if (!function_exists ("ws_plugin__s2member_paypal_term_cycle"))
	{
		function ws_plugin__s2member_paypal_term_cycle ($term_or_period_term = FALSE, $directive = "recurring")
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_term_cycle", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($directive === "recurring") /* recurring = Daily, Weekly, Bi-Weekly, Monthly, Bi-Monthly, Quarterly, Yearly, Lifetime. */
					{
						$paypal_term_cycles = array ("D" => "Daily", "W" => "Weekly", "M" => "Monthly", "Y" => "Yearly", "L" => "Lifetime", "DAY" => "Daily", "WEEK" => "Weekly", "MONTH" => "Monthly", "YEAR" => "Yearly", "Lifetime" => "Lifetime");
						$term_cycle = $paypal_term_cycles[strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term))];
						$term_cycle = (strtoupper ($term_or_period_term) === "2 W") ? "Bi-Weekly" : $term_cycle;
						$term_cycle = (strtoupper ($term_or_period_term) === "2 M") ? "Bi-Monthly" : $term_cycle;
						$term_cycle = (strtoupper ($term_or_period_term) === "3 M") ? "Quarterly" : $term_cycle;
					}
				else if ($directive === "singular") /* singular = Day, Week, Month, Year, Lifetime. */
					{
						$paypal_term_cycles = array ("D" => "Day", "W" => "Week", "M" => "Month", "Y" => "Year", "L" => "Lifetime", "DAY" => "Day", "WEEK" => "Week", "MONTH" => "Month", "YEAR" => "Year", "Lifetime" => "Lifetime");
						$term_cycle = $paypal_term_cycles[strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term))];
					}
				else if ($directive === "plural") /* plural = Days, Weeks, Months, Years, Lifetimes. */
					{
						$paypal_term_cycles = array ("D" => "Days", "W" => "Weeks", "M" => "Months", "Y" => "Years", "L" => "Lifetimes", "DAY" => "Days", "WEEK" => "Weeks", "MONTH" => "Months", "YEAR" => "Years", "Lifetime" => "Lifetimes");
						$term_cycle = $paypal_term_cycles[strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term))];
					}
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_term_cycle", $term_cycle, get_defined_vars ());
			}
	}
/*
Function accepts a period, term, and recurring flag.
Returns a full term explanation.
Example: 2 months.
*/
if (!function_exists ("ws_plugin__s2member_paypal_period_term"))
	{
		function ws_plugin__s2member_paypal_period_term ($period_term = FALSE, $recurring = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_period_term", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				list ($period, $term) = preg_split ("/ /", ($period_term = strtoupper ($period_term)), 2);
				$recurring = (strtoupper ($recurring) === "BN") ? (int)0 : (int)$recurring;
				/**/
				$cycle_recurring = ws_plugin__s2member_paypal_term_cycle ($period_term, "recurring");
				$cycle_singular = ws_plugin__s2member_paypal_term_cycle ($period_term, "singular");
				$cycle_plural = ws_plugin__s2member_paypal_term_cycle ($period_term, "plural");
				/**/
				if ($recurring && in_array ($period_term, array ("1 D", "1 W", "2 W", "1 M", "2 M", "3 M", "1 Y")))
					$period_term = strtolower ($cycle_recurring); /* Results in an "ly" ending. */
				/**/
				else if ($recurring) /* Otherwise, it's recurring; but NOT an "ly" ending. */
					$period_term = strtolower ("every " . $period . " " . $cycle_plural);
				/**/
				else if (strtoupper ($term) === "L") /* One-payment for lifetime access. */
					$period_term = "lifetime"; /* Lifetime only. */
				/**/
				else /* Otherwise, this is NOT recurring. Results in X days/weeks/months/years/lifetime. */
					$period_term = strtolower ($period . " " . ( ($period <> 1) ? $cycle_plural : $cycle_singular));
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_period_term", $period_term, get_defined_vars ());
			}
	}
/*
Function accepts a billing amount, period, term, and recurring flag.
Returns a full billing term explanation.
Example: 1.00 for 2 months.
*/
if (!function_exists ("ws_plugin__s2member_paypal_amount_period_term"))
	{
		function ws_plugin__s2member_paypal_amount_period_term ($amount = FALSE, $period_term = FALSE, $recurring = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_amount_period_term", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				list ($period, $term) = preg_split ("/ /", ($period_term = strtoupper ($period_term)), 2);
				$recurring = (strtoupper ($recurring) === "BN") ? (int)0 : (int)$recurring;
				/**/
				$cycle_recurring = ws_plugin__s2member_paypal_term_cycle ($period_term, "recurring");
				$cycle_singular = ws_plugin__s2member_paypal_term_cycle ($period_term, "singular");
				$cycle_plural = ws_plugin__s2member_paypal_term_cycle ($period_term, "plural");
				/**/
				if ($recurring && in_array ($period_term, array ("1 D", "1 W", "2 W", "1 M", "2 M", "3 M", "1 Y")))
					$amount_period_term = number_format ($amount, 2, ".", "") . " / " . strtolower ($cycle_recurring);
				/**/
				else if ($recurring) /* Otherwise, it's recurring; but NOT an "ly" ending. */
					$amount_period_term = number_format ($amount, 2, ".", "") . " " . strtolower ("every " . $period . " " . $cycle_plural);
				/**/
				else if (strtoupper ($term) === "L") /* One-payment for lifetime access. */
					$amount_period_term = number_format ($amount, 2, ".", ""); /* Price only. */
				/**/
				else /* Otherwise, this is NOT recurring. Results in 0.00 for X days/weeks/months/years/lifetime. */
					$amount_period_term = number_format ($amount, 2, ".", "") . " for " . strtolower ($period . " " . ( ($period <> 1) ? $cycle_plural : $cycle_singular));
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_amount_period_term", $amount_period_term, get_defined_vars ());
			}
	}
/*
Parse/validate item_name from either an array with recurring_payment_id, or use an existing string.
*/
if (!function_exists ("ws_plugin__s2member_paypal_pro_subscr_id"))
	{
		function ws_plugin__s2member_paypal_pro_subscr_id ($array_or_string = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_pro_subscr_id", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_array ($array = $array_or_string) && $array["recurring_payment_id"])
					{
						$subscr_id = $array["recurring_payment_id"];
					}
				else if (is_string ($string = $array_or_string))
					$subscr_id = $string;
				/**/
				if ($subscr_id) /* Were we able to get an subscr_id string parsed out? */
					return apply_filters ("ws_plugin__s2member_paypal_pro_subscr_id", $subscr_id, get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_pro_subscr_id", false, get_defined_vars ());
			}
	}
/*
Parse/validate item_number from either an array with:
item_number1|PROFILEREFERENCE|rp_invoice_id, or parse/validate an existing string
to make sure it is a valid "level:ccaps:eotper" combination.
*/
if (!function_exists ("ws_plugin__s2member_paypal_pro_item_number"))
	{
		function ws_plugin__s2member_paypal_pro_item_number ($array_or_string = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_pro_item_number", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_array ($array = $array_or_string) && $array["item_number1"])
					{
						$item_number = $array["item_number1"];
					}
				else if (is_array ($array = $array_or_string))
					{
						$r = (!$r && $array["PROFILEREFERENCE"]) ? $array["PROFILEREFERENCE"] : $r;
						$r = (!$r && $array["rp_invoice_id"]) ? $array["rp_invoice_id"] : $r;
						/**/
						list ($reference, $domain, $item_number) = preg_split ("/~/", $r, 3);
					}
				else if (is_string ($string = $array_or_string))
					$item_number = $string;
				/**/
				if ($item_number) /* Were we able to get an item_number string parsed out? */
					/**/
					if (preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", $item_number))
						return apply_filters ("ws_plugin__s2member_paypal_pro_item_number", $item_number, get_defined_vars ());
					/**/
					else if (preg_match ("/^sp\:[0-9,]+\:[0-9]+$/", $item_number))
						return apply_filters ("ws_plugin__s2member_paypal_pro_item_number", $item_number, get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_pro_item_number", false, get_defined_vars ());
			}
	}
/*
Parse/validate item_name from either an array with: item_name1|product_name, or use an existing string.
*/
if (!function_exists ("ws_plugin__s2member_paypal_pro_item_name"))
	{
		function ws_plugin__s2member_paypal_pro_item_name ($array_or_string = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_pro_item_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_array ($array = $array_or_string) && $array["item_name1"])
					{
						$item_name = $array["item_name1"];
					}
				else if (is_array ($array = $array_or_string) && $array["product_name"])
					{
						$item_name = $array["product_name"];
					}
				else if (is_string ($string = $array_or_string))
					$item_name = $string;
				/**/
				if ($item_name) /* Were we able to get an item_name string parsed out? */
					return apply_filters ("ws_plugin__s2member_paypal_pro_item_name", $item_name, get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_paypal_pro_item_name", false, get_defined_vars ());
			}
	}
/*
Parse/validate period1 from either a return array coming from the
Pro API with PROFILEREFERENCE|rp_invoice_id, or parse/validate an existing string
to make sure it is a valid "period term" combination.

Note: This will also convert "1 Day", into "1 D".
Note: This will also convert "1 SemiMonth", into "2 W".
*/
if (!function_exists ("ws_plugin__s2member_paypal_pro_period1"))
	{
		function ws_plugin__s2member_paypal_pro_period1 ($array_or_string = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_pro_period1", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_array ($array = $array_or_string))
					{
						$r = (!$r && $array["PROFILEREFERENCE"]) ? $array["PROFILEREFERENCE"] : $r;
						$r = (!$r && $array["rp_invoice_id"]) ? $array["rp_invoice_id"] : $r;
						/**/
						list ($reference, $domain, $item_number) = preg_split ("/~/", $r, 3);
						list ($start_time, $period1, $period3) = preg_split ("/\:/", $reference, 3);
					}
				/**/
				else if (is_string ($string = $array_or_string))
					$period1 = $string; /* A string was passed in for validation. */
				/**/
				if ($period1) /* Were we able to get a period1 string parsed out? */
					{
						list ($num, $span) = preg_split ("/ /", $period1, 2);
						/**/
						if (strtoupper ($span) === "SEMIMONTH")
							if (is_numeric ($num) && $num >= 1)
								eval ('$num = "2"; $span = "W";');
						/**/
						if (strlen ($span) !== 1) /* Convert to Standard format. */
							$span = ws_plugin__s2member_paypal_std_term ($span);
						/**/
						$span = (preg_match ("/^[DWMY]$/i", $span)) ? $span : "";
						$num = ($span && is_numeric ($num) && $num >= 0) ? $num : "";
						/**/
						$period1 = ($num && $span) ? $num . " " . strtoupper ($span) : "0 D";
						return apply_filters ("ws_plugin__s2member_paypal_pro_period1", $period1, get_defined_vars ());
					}
				else /* Default. */
					return apply_filters ("ws_plugin__s2member_paypal_pro_period1", "0 D", get_defined_vars ());
			}
	}
/*
Parse/validate period3 from either a return array coming from the
Pro API with PROFILEREFERENCE|rp_invoice_id, or parse/validate an existing string
to make sure it is a valid "period term" combination.

Note: This will also convert "1 Day", into "1 D".
Note: This will also convert "1 SemiMonth", into "2 W".
Note: The Regular Period can never be less than 1 day ( 1 D ).
*/
if (!function_exists ("ws_plugin__s2member_paypal_pro_period3"))
	{
		function ws_plugin__s2member_paypal_pro_period3 ($array_or_string = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_paypal_pro_period3", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_array ($array = $array_or_string))
					{
						$r = (!$r && $array["PROFILEREFERENCE"]) ? $array["PROFILEREFERENCE"] : $r;
						$r = (!$r && $array["rp_invoice_id"]) ? $array["rp_invoice_id"] : $r;
						/**/
						list ($reference, $domain, $item_number) = preg_split ("/~/", $r, 3);
						list ($start_time, $period1, $period3) = preg_split ("/\:/", $reference, 3);
					}
				/**/
				else if (is_string ($string = $array_or_string))
					$period3 = $string; /* A string was passed in for validation. */
				/**/
				if ($period3) /* Were we able to get a period3 string parsed out? */
					{
						list ($num, $span) = preg_split ("/ /", $period3, 2);
						/**/
						if (strtoupper ($span) === "SEMIMONTH")
							if (is_numeric ($num) && $num >= 1)
								eval ('$num = "2"; $span = "W";');
						/**/
						if (strlen ($span) !== 1) /* Convert to Standard format. */
							$span = ws_plugin__s2member_paypal_std_term ($span);
						/**/
						$span = (preg_match ("/^[DWMY]$/i", $span)) ? $span : "";
						$num = ($span && is_numeric ($num) && $num >= 0) ? $num : "";
						/**/
						$period3 = ($num && $span) ? $num . " " . strtoupper ($span) : "1 D";
						return apply_filters ("ws_plugin__s2member_paypal_pro_period3", $period3, get_defined_vars ());
					}
				else /* Default. */
					return apply_filters ("ws_plugin__s2member_paypal_pro_period3", "1 D", get_defined_vars ());
			}
	}
?>