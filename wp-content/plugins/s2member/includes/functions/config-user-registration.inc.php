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
Function that adds hidden fields to POST vars on signup.
Attach to: add_filter("signup_hidden_fields");

This can ONLY be fired through wp-signup.php on the front-side.
	Or through `/register` via BuddyPress.
*/
if (!function_exists ("ws_plugin__s2member_ms_process_signup_hidden_fields"))
	{
		function ws_plugin__s2member_ms_process_signup_hidden_fields ()
			{
				do_action ("ws_plugin__s2member_before_ms_process_signup_hidden_fields", get_defined_vars ());
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking, on a Blog Farm. */
					if (ws_plugin__s2member_is_multisite_farm () && is_main_site () && ( (preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"]) && $_POST["stage"] === "validate-user-signup") || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_REGISTER_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]))))
						{
							foreach ((array)ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST)) as $key => $value)
								if (preg_match ("/^ws_plugin__s2member_(custom_reg_field|user_new)_/", $key))
									if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
										echo '<input type="hidden" name="' . esc_attr ($key) . '" value="' . esc_attr (maybe_serialize ($value)) . '" />' . "\n";
							/**/
							do_action ("ws_plugin__s2member_during_ms_process_signup_hidden_fields", get_defined_vars ());
						}
				/**/
				do_action ("ws_plugin__s2member_after_ms_process_signup_hidden_fields", get_defined_vars ());
			}
	}
/*
Function that adds customs fields to $meta on signup.
Attach to: add_filter("add_signup_meta");
Attach to: add_filter("bp_signup_usermeta");

This can be fired through wp-signup.php on the front-side,
	or possibly through user-new.php in the admin.
*/
if (!function_exists ("ws_plugin__s2member_ms_process_signup_meta"))
	{
		function ws_plugin__s2member_ms_process_signup_meta ($meta = FALSE)
			{
				global $pagenow; /* Need this to detect the current admin page. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ms_process_signup_meta", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. Either in the admin, or on a Blog Farm through wp-signup.php. */
					if ((is_admin () && $pagenow === "user-new.php") || (ws_plugin__s2member_is_multisite_farm () && is_main_site () && ( (preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"]) && preg_match ("/^validate-(user|blog)-signup$/", $_POST["stage"])) || (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_REGISTER_SLUG, "/") . "/", $_SERVER["REQUEST_URI"])))))
						{
							ws_plugin__s2member_email_config (); /* Configures From: header that will be used in notifications. */
							/**/
							foreach ((array)ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST)) as $key => $value)
								if (preg_match ("/^ws_plugin__s2member_(custom_reg_field|user_new)_/", $key))
									if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
										$meta["s2member_ms_signup_meta"][$key] = maybe_unserialize ($value);
						}
				/**/
				return apply_filters ("ws_plugin__s2member_ms_process_signup_meta", $meta, get_defined_vars ());
			}
	}
/*
Function for configuring new users.
Attach to: add_action("wpmu_activate_user");

This does NOT fire for a Super Admin managing Network Users.
Which is good. A Super Admin will NOT trigger this event.
~ They fire wpmu_create_user(), bypassing activation.
	- through ms-edit.php.

However, a Super Admin CAN trigger this event by adding a new User through the Users -> Add New menu.
~ If they choose to bypass activation; an activation IS fired immediately. Otherwise, it's delayed.
	- via user-new.php.

So this function may get fired inside the admin panel ( `user-new.php` ).
Or also during an actual activation; through `wp-activate.php`.
Or also during an actual activation; through `/activate` via BuddyPress.
*/
if (!function_exists ("ws_plugin__s2member_configure_user_on_ms_user_activation"))
	{
		function ws_plugin__s2member_configure_user_on_ms_user_activation ($user_id = FALSE, $password = FALSE, $meta = FALSE)
			{
				global $pagenow; /* Need this to detect the current admin page. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_on_ms_user_activation", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
					if ((is_admin () && $pagenow === "user-new.php") || (!is_admin () && preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])) || (!is_admin () && defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"])))
						{
							ws_plugin__s2member_configure_user_registration ($user_id, $password, $meta["s2member_ms_signup_meta"]);
							delete_user_meta ($user_id, "s2member_ms_signup_meta");
						}
				/**/
				do_action ("ws_plugin__s2member_after_configure_user_on_ms_user_activation", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Function for configuring new users.
Attach to: add_action("wpmu_activate_blog");

This does NOT fire for a Super Admin managing Network Blogs.
~ Actually they do; BUT it's blocked by the routine below.
Which is good. A Super Admin should NOT trigger this event.

This function should ONLY be fired through `wp-activate.php`.
	Or also through `/activate` via BuddyPress.
*/
if (!function_exists ("ws_plugin__s2member_configure_user_on_ms_blog_activation"))
	{
		function ws_plugin__s2member_configure_user_on_ms_blog_activation ($blog_id = FALSE, $user_id = FALSE, $password = FALSE, $title = FALSE, $meta = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_on_ms_blog_activation", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite ()) /* This event should ONLY be processed with Multisite Networking. */
					if ((!is_admin () && preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"])) || (!is_admin () && defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"])))
						{
							ws_plugin__s2member_configure_user_registration ($user_id, $password, $meta["s2member_ms_signup_meta"]);
							delete_user_meta ($user_id, "s2member_ms_signup_meta");
						}
				/**/
				do_action ("ws_plugin__s2member_after_configure_user_on_ms_blog_activation", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Function for configuring new users.
Attach to: add_action("user_register");

This also receives Multisite events.
Attach to: add_action("wpmu_activate_user");
Attach to: add_action("wpmu_activate_blog");

The Hook `user_register` is also fired by calling:
		wpmu_create_user()

This function also receives simulated events from s2Member Pro.
*/
if (!function_exists ("ws_plugin__s2member_configure_user_registration"))
	{
		function ws_plugin__s2member_configure_user_registration ($user_id = FALSE, $password = FALSE, $meta = FALSE)
			{
				global $wpdb; /* Global database object may be required for this routine. */
				global $pagenow; /* Need this to detect the current admin page. */
				global $current_site, $current_blog; /* Multisite Networking. */
				static $email_config, $processed; /* No duplicate processing. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_configure_user_registration", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				/* With Multisite Networking, we need this to run on `user_register` ahead of `wpmu_activate_user|blog`. */
				if (!$email_config && ($email_config = true)) /* Anytime this routine is fired; we config email; no exceptions. */
					ws_plugin__s2member_email_config (); /* Configures From: header that will be used in new user notifications. */
				/**/
				if (!$processed /* Process only once. Safeguard this routine against duplicate processing via plugins ( or even WordPress® itself ). */
				&& (is_array ($_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST))) || is_array (ws_plugin__s2member_trim_deep (stripslashes_deep ($meta))))/**/
				/**/
				/* These negative matches are designed to prevent this routine from running under certain conditions; where we need to wait for `wpmu_activate_user|blog` instead. */
				&& ! (is_admin () && is_multisite () && $pagenow === "user-new.php" && isset ($_POST["noconfirmation"]) && is_super_admin () && func_num_args () !== 3)/**/
				&& ! (preg_match ("/\/wp-activate\.php/", $_SERVER["REQUEST_URI"]) && func_num_args () !== 3) /* If activating; we MUST have a $meta arg to proceed. */
				&& ! (defined ("BP_VERSION") && preg_match ("/\/" . preg_quote (BP_ACTIVATION_SLUG, "/") . "/", $_SERVER["REQUEST_URI"]) && func_num_args () !== 3)
				/* The $meta argument is ONLY passed in by hand-offs from `wpmu_activate_user|blog`. So this is how we check for these events. */
				/**/
				&& $user_id && is_object ($user = new WP_User ($user_id)) && $user->ID && ($processed = true)) /* Process only once. */
					{
						foreach ((array)$_POST as $key => $value) /* Scan $_POST vars; adding `custom_reg_field` uniformity keys. */
							if (preg_match ("/^ws_plugin__s2member_user_new_/", $key)) /* Looking for `user_new` keys here. */
								if ($key = preg_replace ("/_user_new_/", "_custom_reg_field_", $key))
									$_POST[$key] = $value; /* Add these keys for uniformity. */
						unset ($key, $value); /* Prevents bleeding vars into Hooks/Filters. */
						/**/
						if (!is_admin () && ($_POST["ws_plugin__s2member_custom_reg_field_s2member_custom"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_ccaps"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"] || $_POST["ws_plugin__s2member_custom_reg_field_s2member_notes"]))
							exit ("s2Member security violation. You attempted to POST variables that will NOT be trusted!");
						/**/
						$_pm = array_merge ((array)$_POST, (array)$meta); /* Merge these two data sources together now; ALWAYS after the security routine above ^. */
						/**/
						if (!is_admin () /* Only run this particular routine whenever a Member [1-4] is registering themselves with cookies. */
						&& ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"])))/**/
						&& (!$usermeta = $wpdb->get_row ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1")))
							/* ^ This is for security ^ It checks the database to make sure the User/Member has not already registered in the past, with the same Paid Subscr. ID. */
							{ /*
								This routine could be processed through `wp-login.php?action=register`, `wp-activate.php`, or `/activate` via BuddyPress`.
								This may also be processed through a standard BuddyPress installation, or another plugin calling `user_register`.
								If processed through `wp-activate.php`, it could've originated inside the admin, via `user-new.php`.
								*/
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
								/**/
								list ($level, $ccaps, $eotper) = preg_split ("/\:/", $level, 3);
								$role = "s2member_level" . $level; /* Level 1-4. */
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = $_SERVER["REMOTE_ADDR"];
								$cv = preg_split ("/\|/", $custom);
								/**/
								if ($eotper) /* If a specific EOT Period has been attached; calculate that now. */
									$auto_eot_time = ws_plugin__s2member_paypal_auto_eot_time ("", "", "", $eotper);
								/**/
								$notes = $_pm["ws_plugin__s2member_custom_reg_field_s2member_notes"];
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
								$opt_in = (!$opt_in && $_pm["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
								/**/
								if (! ($fname = $user->first_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_first_name"])
										$fname = $_pm["ws_plugin__s2member_custom_reg_field_first_name"];
								/**/
								if (!$fname) /* Also try BuddyPress. */
									if ($_pm["field_1"]) /* BuddyPress. */
										$fname = trim (preg_replace ("/ (.*)$/", "", $_pm["field_1"]));
								/**/
								if (! ($lname = $user->last_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_last_name"])
										$lname = $_pm["ws_plugin__s2member_custom_reg_field_last_name"];
								/**/
								if (!$lname) /* Also try BuddyPress. */
									if ($_pm["field_1"] && preg_match ("/^(.+?) (.+)$/", $_pm["field_1"]))
										$lname = trim (preg_replace ("/^(.+?) (.+)$/", "$2", $_pm["field_1"]));
								/**/
								$name = trim ($fname . " " . $lname); /* Both names. */
								/**/
								if (! ($pass = $password)) /* Try s2Member's generator. */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try BuddyPress password. */
									if ($_pm["signup_password"]) /* BuddyPress. */
										$pass = $_pm["signup_password"];
								/**/
								if ($pass) /* No password nag. Update this globally. */
									{
										delete_user_setting ("default_password_nag"); /* setcookie() */
										update_user_option ($user_id, "default_password_nag", false, true);
									}
								/**/
								update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
								update_user_option ($user_id, "s2member_subscr_id", $subscr_id);
								update_user_option ($user_id, "s2member_custom", $custom);
								update_user_option ($user_id, "s2member_notes", $notes);
								/**/
								if (!$user->first_name && $fname)
									update_user_meta ($user_id, "first_name", $fname) ./**/
									wp_update_user (array ("ID" => $user_id, "display_name" => $fname));
								/**/
								if (!$user->last_name && $lname)
									update_user_meta ($user_id, "last_name", $lname);
								/**/
								if (is_multisite ()) /* Originating Blog ID#, and adjust Main Site permissions. */
									{
										(!is_main_site ()) ? remove_user_from_blog ($user_id, $current_site->blog_id) : null;
										update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
									}
								/**/
								$user->set_role ($role); /* s2Member. */
								/**/
								if ($ccaps) /* Add Custom Capabilities. */
									foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
										if (strlen ($ccap)) /* Don't add empty capabilities. */
											$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
									foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
										{
											$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
											$field_id_class = preg_replace ("/_/", "-", $field_var);
											/**/
											if (isset ($_pm["ws_plugin__s2member_custom_reg_field_" . $field_var]))
												$fields[$field_var] = $_pm["ws_plugin__s2member_custom_reg_field_" . $field_var];
										}
								/**/
								update_user_option ($user_id, "s2member_custom_fields", $fields);
								/**/
								if (($transient = md5 ("s2member_transient_ipn_subscr_payment_" . $subscr_id)) && is_array ($subscr_payment = get_transient ($transient)))
									{
										$proxy = array ("s2member_paypal_notify" => "1", "s2member_paypal_proxy" => "s2member_transient_ipn_subscr_payment", "s2member_paypal_proxy_verification" => ws_plugin__s2member_paypal_proxy_key_gen ());
										ws_plugin__s2member_remote (add_query_arg (urlencode_deep ($proxy), get_bloginfo ("wpurl")), stripslashes_deep ($subscr_payment), array ("timeout" => 20));
										delete_transient($transient);
									}
								/**/
								setcookie ("s2member_signup_tracking", ws_plugin__s2member_encrypt ($subscr_id), time () + 31556926, "/");
								/**/
								if ($level > 0) /* We ONLY process this if they are higher than Level#0. */
									{
										$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
										$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
										$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
										update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side_paid", get_defined_vars ());
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						else if (!is_admin ()) /* Otherwise, if we are NOT inside the Dashboard during the creation of this account. */
							{ /*
								This routine could be processed through `wp-login.php?action=register`, `wp-activate.php`, or `/activate` via BuddyPress`.
								This may also be processed through a standard BuddyPress installation, or another plugin calling `user_register`.
								If processed through `wp-activate.php`, it could've originated inside the admin, via `user-new.php`.
								*/
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
								/**/
								$role = $role = $user->roles[0]; /* If they already have a Role, we can use it. */
								$role = (!$role && is_multisite () && is_main_site ()) ? get_site_option ("default_user_role") : $role;
								$role = (!$role) ? get_option ("default_role") : $role; /* Otherwise, the default role. */
								/**/
								$level = (preg_match ("/^(administrator|editor|author|contributor)$/i", $role)) ? "4" : $level;
								$level = (!$level && preg_match ("/^s2member_level[1-4]$/i", $role)) ? preg_replace ("/^s2member_level/", "", $role) : $level;
								$level = (!$level && preg_match ("/^subscriber$/i", $role)) ? "0" : $level;
								$level = (!$level) ? "0" : $level;
								/**/
								$ccaps = $_pm["ws_plugin__s2member_custom_reg_field_s2member_ccaps"];
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = $_SERVER["REMOTE_ADDR"];
								$custom = $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"];
								$subscr_id = $_pm["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"];
								$cv = preg_split ("/\|/", $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"]);
								/**/
								$auto_eot_time = ($eot = $_pm["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
								$notes = $_pm["ws_plugin__s2member_custom_reg_field_s2member_notes"];
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
								$opt_in = (!$opt_in && $_pm["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
								/**/
								if (! ($fname = $user->first_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_first_name"])
										$fname = $_pm["ws_plugin__s2member_custom_reg_field_first_name"];
								/**/
								if (!$fname) /* Also try BuddyPress. */
									if ($_pm["field_1"]) /* BuddyPress. */
										$fname = trim (preg_replace ("/ (.*)$/", "", $_pm["field_1"]));
								/**/
								if (! ($lname = $user->last_name))
									if ($_pm["ws_plugin__s2member_custom_reg_field_last_name"])
										$lname = $_pm["ws_plugin__s2member_custom_reg_field_last_name"];
								/**/
								if (!$lname) /* Also try BuddyPress. */
									if ($_pm["field_1"] && preg_match ("/^(.+?) (.+)$/", $_pm["field_1"]))
										$lname = trim (preg_replace ("/^(.+?) (.+)$/", "$2", $_pm["field_1"]));
								/**/
								$name = trim ($fname . " " . $lname); /* Both names. */
								/**/
								if (! ($pass = $password)) /* Try s2Member's generator. */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try BuddyPress password. */
									if ($_pm["signup_password"]) /* BuddyPress. */
										$pass = $_pm["signup_password"];
								/**/
								if ($pass) /* No password nag. Update this globally. */
									{
										delete_user_setting ("default_password_nag"); /* setcookie() */
										update_user_option ($user_id, "default_password_nag", false, true);
									}
								/**/
								update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
								update_user_option ($user_id, "s2member_subscr_id", $subscr_id);
								update_user_option ($user_id, "s2member_custom", $custom);
								update_user_option ($user_id, "s2member_notes", $notes);
								/**/
								if (!$user->first_name && $fname)
									update_user_meta ($user_id, "first_name", $fname) ./**/
									wp_update_user (array ("ID" => $user_id, "display_name" => $fname));
								/**/
								if (!$user->last_name && $lname)
									update_user_meta ($user_id, "last_name", $lname);
								/**/
								if (is_multisite ()) /* Originating Blog ID#, and adjust Main Site permissions. */
									{
										(!is_main_site ()) ? remove_user_from_blog ($user_id, $current_site->blog_id) : null;
										update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
									}
								/**/
								$user->set_role ($role); /* s2Member. */
								/**/
								if ($ccaps) /* Add Custom Capabilities. */
									foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
										if (strlen ($ccap)) /* Don't add empty capabilities. */
											$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
									foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
										{
											$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
											$field_id_class = preg_replace ("/_/", "-", $field_var);
											/**/
											if (isset ($_pm["ws_plugin__s2member_custom_reg_field_" . $field_var]))
												$fields[$field_var] = $_pm["ws_plugin__s2member_custom_reg_field_" . $field_var];
										}
								/**/
								update_user_option ($user_id, "s2member_custom_fields", $fields);
								/**/
								if ($level > 0) /* We ONLY process this if they are higher than Level#0. */
									{
										$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
										$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
										$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
										update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side_free", get_defined_vars ());
								do_action ("ws_plugin__s2member_during_configure_user_registration_front_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						else if (is_admin () && $pagenow === "user-new.php") /* Else, if we're on this page. */
							{ /*
								This routine can ONLY be processed through `user-new.php` inside the backend Dashboard.
								*/
								$processed = "yes"; /* Mark this as yes, to indicate that a routine was processed. */
								/**/
								$role = $role = $user->roles[0]; /* If they already have a Role, we can use it. */
								$role = (!$role && is_multisite () && is_main_site ()) ? get_site_option ("default_user_role") : $role;
								$role = (!$role) ? get_option ("default_role") : $role; /* Otherwise, the default role. */
								/**/
								$level = (preg_match ("/^(administrator|editor|author|contributor)$/i", $role)) ? "4" : $level;
								$level = (!$level && preg_match ("/^s2member_level[1-4]$/i", $role)) ? preg_replace ("/^s2member_level/", "", $role) : $level;
								$level = (!$level && preg_match ("/^subscriber$/i", $role)) ? "0" : $level;
								$level = (!$level) ? "0" : $level;
								/**/
								$ccaps = $_pm["ws_plugin__s2member_custom_reg_field_s2member_ccaps"];
								/**/
								$email = $user->user_email;
								$login = $user->user_login;
								$ip = ""; /* N/Applicable. */
								$custom = $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"];
								$subscr_id = $_pm["ws_plugin__s2member_custom_reg_field_s2member_subscr_id"];
								$cv = preg_split ("/\|/", $_pm["ws_plugin__s2member_custom_reg_field_s2member_custom"]);
								/**/
								$auto_eot_time = ($eot = $_pm["ws_plugin__s2member_custom_reg_field_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
								$notes = $_pm["ws_plugin__s2member_custom_reg_field_s2member_notes"];
								/**/
								$opt_in = (!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? true : false;
								$opt_in = (!$opt_in && $_pm["ws_plugin__s2member_custom_reg_field_opt_in"]) ? true : $opt_in;
								/**/
								if (! ($fname = $user->first_name)) /* `Users -> Add New`. */
									if ($_pm["ws_plugin__s2member_custom_reg_field_first_name"])
										$fname = $_pm["ws_plugin__s2member_custom_reg_field_first_name"];
								/**/
								if (! ($lname = $user->last_name)) /* `Users -> Add New`. */
									if ($_pm["ws_plugin__s2member_custom_reg_field_last_name"])
										$lname = $_pm["ws_plugin__s2member_custom_reg_field_last_name"];
								/**/
								$name = trim ($fname . " " . $lname); /* Both names. */
								/**/
								if (! ($pass = $password)) /* Try s2Member's generator. */
									if ($GLOBALS["ws_plugin__s2member_generate_password_return"])
										$pass = $GLOBALS["ws_plugin__s2member_generate_password_return"];
								/**/
								if (!$pass) /* Also try the `Users -> Add New` form. */
									if ($_pm["pass1"]) /* Field in user-new.php. */
										$pass = $_pm["pass1"];
								/**/
								if ($pass) /* No password nag. Update this globally. */
									{
										delete_user_setting ("default_password_nag"); /* setcookie() */
										update_user_option ($user_id, "default_password_nag", false, true);
									}
								/**/
								update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
								update_user_option ($user_id, "s2member_subscr_id", $subscr_id);
								update_user_option ($user_id, "s2member_custom", $custom);
								update_user_option ($user_id, "s2member_notes", $notes);
								/**/
								if (!$user->first_name && $fname)
									update_user_meta ($user_id, "first_name", $fname) ./**/
									wp_update_user (array ("ID" => $user_id, "display_name" => $fname));
								/**/
								if (!$user->last_name && $lname)
									update_user_meta ($user_id, "last_name", $lname);
								/**/
								if (is_multisite ()) /* Originating Blog ID#, and adjust Main Site permissions. */
									{
										(!is_main_site ()) ? remove_user_from_blog ($user_id, $current_site->blog_id) : null;
										update_user_meta ($user_id, "s2member_originating_blog", $current_blog->blog_id);
									}
								/**/
								$user->set_role ($role); /* s2Member. */
								/**/
								foreach (preg_split ("/[\r\n\t\s;,]+/", $ccaps) as $ccap)
									if (strlen ($ccap)) /* Don't add empty capabilities. */
										$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
									foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
										{
											$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
											$field_id_class = preg_replace ("/_/", "-", $field_var);
											/**/
											if (isset ($_pm["ws_plugin__s2member_custom_reg_field_" . $field_var]))
												$fields[$field_var] = $_pm["ws_plugin__s2member_custom_reg_field_" . $field_var];
										}
								/**/
								update_user_option ($user_id, "s2member_custom_fields", $fields);
								/**/
								if ($level > 0) /* We ONLY process this if they are higher than Level#0. */
									{
										$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
										$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
										$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
										update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration_admin_side", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						if ($processed === "yes") /* If registration was processed by one of the routines above. */
							{
								if ($urls = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_urls"])
									/**/
									foreach (preg_split ("/[\r\n\t]+/", $urls) as $url) /* Notify each of the urls. */
										/**/
										if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
											if (($url = preg_replace ("/%%role%%/i", ws_plugin__s2member_esc_ds (urlencode ($role)), $url)))
												if (($url = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds (urlencode ($level)), $url)))
													if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($fname)), $url)))
														if (($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($lname)), $url)))
															if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($name)), $url)))
																if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($email)), $url)))
																	if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($login)), $url)))
																		if (($url = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds (urlencode ($pass)), $url)))
																			if (($url = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds (urlencode ($user_id)), $url)))
																				{
																					if (is_array ($fields) && !empty ($fields))
																						foreach ($fields as $var => $val) /* Custom Registration Fields. */
																							if (! ($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", ws_plugin__s2member_esc_ds (urlencode (maybe_serialize ($val))), $url)))
																								break;
																					/**/
																					if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																						ws_plugin__s2member_remote($url);
																				}
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_recipients"])
									{
										$msg = $sbj = "( s2Member / API Notification Email ) - Registration";
										$msg .= "\n\n"; /* Spacing in the message body. */
										/**/
										$msg .= "role: %%role%%\n";
										$msg .= "level: %%level%%\n";
										$msg .= "user_first_name: %%user_first_name%%\n";
										$msg .= "user_last_name: %%user_last_name%%\n";
										$msg .= "user_full_name: %%user_full_name%%\n";
										$msg .= "user_email: %%user_email%%\n";
										$msg .= "user_login: %%user_login%%\n";
										$msg .= "user_pass: %%user_pass%%\n";
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
										if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)))
											if (($msg = preg_replace ("/%%role%%/i", ws_plugin__s2member_esc_ds ($role), $msg)))
												if (($msg = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds ($level), $msg)))
													if (($msg = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds ($fname), $msg)))
														if (($msg = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds ($lname), $msg)))
															if (($msg = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds ($name), $msg)))
																if (($msg = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds ($email), $msg)))
																	if (($msg = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds ($login), $msg)))
																		if (($msg = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds ($pass), $msg)))
																			if (($msg = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds ($user_id), $msg)))
																				{
																					if (is_array ($fields) && !empty ($fields))
																						foreach ($fields as $var => $val) /* Custom Registration Fields. */
																							if (! ($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", ws_plugin__s2member_esc_ds (maybe_serialize ($val)), $msg)))
																								break;
																					/**/
																					if (($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																						foreach (ws_plugin__s2member_trim_deep (preg_split ("/;+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["registration_notification_recipients"])) as $recipient)
																							($recipient) ? wp_mail ($recipient, apply_filters ("ws_plugin__s2member_registration_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_registration_notification_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") : null;
																				}
									}
								/**/
								if ($url = $GLOBALS["ws_plugin__s2member_registration_return_url"])
									/**/
									if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)))
										if (($url = preg_replace ("/%%role%%/i", ws_plugin__s2member_esc_ds (urlencode ($role)), $url)))
											if (($url = preg_replace ("/%%level%%/i", ws_plugin__s2member_esc_ds (urlencode ($level)), $url)))
												if (($url = preg_replace ("/%%user_first_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($fname)), $url)))
													if (($url = preg_replace ("/%%user_last_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($lname)), $url)))
														if (($url = preg_replace ("/%%user_full_name%%/i", ws_plugin__s2member_esc_ds (urlencode ($name)), $url)))
															if (($url = preg_replace ("/%%user_email%%/i", ws_plugin__s2member_esc_ds (urlencode ($email)), $url)))
																if (($url = preg_replace ("/%%user_login%%/i", ws_plugin__s2member_esc_ds (urlencode ($login)), $url)))
																	if (($url = preg_replace ("/%%user_pass%%/i", ws_plugin__s2member_esc_ds (urlencode ($pass)), $url)))
																		if (($url = preg_replace ("/%%user_id%%/i", ws_plugin__s2member_esc_ds (urlencode ($user_id)), $url)))
																			{
																				if (is_array ($fields) && !empty ($fields))
																					foreach ($fields as $var => $val) /* Custom Registration Fields. */
																						if (! ($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", ws_plugin__s2member_esc_ds (urlencode (maybe_serialize ($val))), $url)))
																							break;
																				/**/
																				if (($url = trim ($url))) /* Preserve remaining Replacements. */
																					/* Because the parent routine may perform replacements too. */
																					$GLOBALS["ws_plugin__s2member_registration_return_url"] = $url;
																			}
								/**/
								ws_plugin__s2member_process_list_servers ($role, $level, $email, $fname, $lname, $ip, $opt_in, $user_id);
								/**/
								setcookie ("s2member_subscr_id", "", time () + 31556926, "/");
								setcookie ("s2member_custom", "", time () + 31556926, "/");
								setcookie ("s2member_level", "", time () + 31556926, "/");
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_configure_user_registration", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_configure_user_registration", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return; /* Return for uniformity. */
			}
	}
?>