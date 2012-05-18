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
Function that adds columns to the list of Users.
Attach to: add_filter ("manage_users_columns");
*/
if (!function_exists ("ws_plugin__s2member_users_list_cols"))
	{
		function ws_plugin__s2member_users_list_cols ($cols = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_users_list_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$cols["s2member_registration_time"] = "Registration Date"; /* Date they signed up. */
				$cols["s2member_paid_registration_times"] = "Paid Registr. Date"; /* Payment Times. */
				$cols["s2member_subscr_id"] = "Paid Subscr. ID"; /* Special field that is always applied. */
				/**/
				if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ())
					/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
					$cols["s2member_ccaps"] = "Custom Capabilities"; /* Custom Capabilities. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
					foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
						{
							$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
							$field_id_class = preg_replace ("/_/", "-", $field_var);
							/**/
							$field_title = ucwords (preg_replace ("/_/", " ", $field_var));
							$cols["s2member_custom_field_" . $field_var] = $field_title;
						}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_users_list_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return apply_filters ("ws_plugin__s2member_users_list_cols", $cols, get_defined_vars ());
			}
	}
/*
Function that displays column data in the row of details.
Attach to: add_filter ("manage_users_custom_column");
*/
if (!function_exists ("ws_plugin__s2member_users_list_display_cols"))
	{
		function ws_plugin__s2member_users_list_display_cols ($val = FALSE, $col = FALSE, $user_id = FALSE)
			{
				global $user_object; /* Already in global scope inside users.php. */
				$user = $user_object; /* Shorter reference to the $user_object var. */
				static $fields, $fields_4_user_id; /* Used for optimization. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_users_list_display_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($col === "s2member_registration_time")
					$val = ($v = $user->user_registered) ? date ("D M jS, Y", strtotime ($v)) . '<br /><small>@ precisely ' . date ("g:i a", strtotime ($v)) . '</small>' : "—";
				/**/
				else if ($col === "s2member_paid_registration_times")
					{
						$val = ""; /* Initialize $val before we begin. */
						if (is_array ($v = get_user_option ("s2member_paid_registration_times", $user_id)))
							foreach ($v as $level => $time) /* Go through each Paid Registration Time. */
								{
									if ($level === "level") /* First Payment Time, regardless of Level. */
										$val .= (($val) ? "<br />" : "") . '<span title="' . esc_attr (date ("D M jS, Y", $time)) . ' @ precisely ' . esc_attr (date ("g:i a", $time)) . '">' . date ("D M jS, Y", $time) . '</span>';
									else if (preg_match ("/^level([0-9]+)$/i", $level) && ($level = preg_replace ("/^level/", "", $level)))
										$val .= (($val) ? "<br />" : "") . '<small><em>@Level ' . $level . ': <span title="' . esc_attr (date ("D M jS, Y", $time)) . ' @ precisely ' . esc_attr (date ("g:i a", $time)) . '">' . date ("D M jS, Y", $time) . '</span></em></small>';
								}
					}
				/**/
				else if ($col === "s2member_subscr_id")
					$val = ($v = get_user_option ("s2member_subscr_id", $user_id)) ? esc_html ($v) : "—";
				/**/
				else if ($col === "s2member_ccaps") /* Custom Capabilities. */
					{
						foreach ($user->allcaps as $cap => $cap_enabled)
							if (preg_match ("/^access_s2member_ccap_/", $cap))
								$ccaps[] = preg_replace ("/^access_s2member_ccap_/", "", $cap);
						/**/
						$val = (!empty ($ccaps)) ? implode ("<br />", $ccaps) : "—";
					}
				/**/
				else if (preg_match ("/^s2member_custom_field_/", $col)) /* Custom Fields. */
					{
						if ((!isset ($fields) || $fields_4_user_id !== $user_id) && ($fields_4_user_id = $user_id))
							$fields = get_user_option ("s2member_custom_fields", $user_id);
						/**/
						$field_var = preg_replace ("/^s2member_custom_field_/", "", $col);
						/**/
						if (is_string ($fields[$field_var]) && preg_match ("/^http(s?)\:/i", $fields[$field_var]))
							$val = '<a href="' . esc_attr ($fields[$field_var]) . '" target="_blank">' . esc_html (substr ($fields[$field_var], strpos ($fields[$field_var], ":") + 3, 25) . "...") . '</a>';
						/**/
						else if (is_array ($fields[$field_var]) && !empty ($fields[$field_var]))
							$val = preg_replace ("/-\|br\|-/", "<br />", esc_html (implode ("-|br|-", $fields[$field_var])));
						/**/
						else if (is_string ($fields[$field_var]) && strlen ($fields[$field_var]))
							$val = esc_html ($fields[$field_var]);
					}
				/**/
				return apply_filters ("ws_plugin__s2member_users_list_display_cols", ( (strlen ($val)) ? $val : "—"), get_defined_vars ());
			}
	}
/*
Function that modifies the search query.
Affects searches performed in the list of Users.
Attach to: add_action("pre_user_search");
*/
function ws_plugin__s2member_users_list_search (&$search = FALSE)
	{
		global $wpdb; /* Need this global object reference. */
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_before_users_list_search", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		if ($search->search_term && ($s = "%" . esc_sql (like_escape ($search->search_term)) . "%")) /* Only when executing an actual search query. */
			{
				$search->query_from = " FROM `" . $wpdb->users . "` INNER JOIN `" . $wpdb->usermeta . "` ON `" . $wpdb->users . "`.`ID` = `" . $wpdb->usermeta . "`.`user_id`";
				/**/
				$search->query_where = " WHERE '1' = '1' AND (" . apply_filters ("ws_plugin__s2member_before_users_list_search_where_or_before", "", get_defined_vars ());
				$search->query_where .= " (`" . $wpdb->usermeta . "`.`meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `" . $wpdb->usermeta . "`.`meta_value` LIKE '" . $s . "')";
				$search->query_where .= " OR (`" . $wpdb->usermeta . "`.`meta_key` = '" . $wpdb->prefix . "s2member_custom' AND `" . $wpdb->usermeta . "`.`meta_value` LIKE '" . $s . "')";
				$search->query_where .= " OR (`" . $wpdb->usermeta . "`.`meta_key` = '" . $wpdb->prefix . "s2member_custom_fields' AND `" . $wpdb->usermeta . "`.`meta_value` LIKE '" . $s . "')";
				$search->query_where .= " OR `user_login` LIKE '" . $s . "' OR `user_nicename` LIKE '" . $s . "' OR `user_email` LIKE '" . $s . "' OR `user_url` LIKE '" . $s . "' OR `display_name` LIKE '" . $s . "'";
				$search->query_where .= apply_filters ("ws_plugin__s2member_before_users_list_search_where_or_after", "", get_defined_vars ()) . ")"; /* Leaving room for additional searches here. */
				$search->query_where .= " AND `" . $wpdb->users . "`.`ID` IN(SELECT DISTINCT(`user_id`) FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "capabilities'" ./**/
				(($search->role) ? " AND `meta_value` LIKE '%" . esc_sql (like_escape ($search->role)) . "%'" : "") . ")";
				/**/
				$search->query_from = apply_filters ("ws_plugin__s2member_before_users_list_search_from", $search->query_from, get_defined_vars ());
				$search->query_where = apply_filters ("ws_plugin__s2member_before_users_list_search_where", $search->query_where, get_defined_vars ());
			}
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_after_users_list_search", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		return;
	}
/*
Function adds Custom Fields to the admin profile editing page.
	
	Attach to: add_action("edit_user_profile");
	Attach to: add_action("show_user_profile");
		w/ the Contant available:
		IS_PROFILE_PAGE

Conditionals here need to match those in the function below:
	ws_plugin__s2member_users_list_update_cols()
*/
if (!function_exists ("ws_plugin__s2member_users_list_edit_cols"))
	{
		function ws_plugin__s2member_users_list_edit_cols ($user = FALSE)
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_users_list_edit_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
				/**/
				if ($user && $user->ID && $current_user && $current_user->ID) /* Validate both of these User objects beforehand. */
					{
						$level = ws_plugin__s2member_user_access_level ($user); /* This User's Access Level for s2Member; needed below. */
						/**/
						if (current_user_can ("edit_users") && (!is_multisite () || is_super_admin () || is_user_member_of_blog ($user->ID)))
							{
								echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
								/**/
								echo '<h3 style="position:relative;"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="position:absolute; top:-15px; right:0; border:0;" />s2Member Configuration &amp; Profile Fields' . ( (is_multisite ()) ? ' ( for this Blog )' : '') . '</h3>' . "\n";
								/**/
								echo '<table class="form-table">' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_users_list_edit_cols_before", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (is_multisite () && is_super_admin ()) /* MUST be a Super Admin. */
									/* On a Multisite Network, the Super Administrator can ALWAYS edit this. */
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_originating_blog", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Originating Blog ID#:</label> <a href="#" onclick="alert(\'On a Multisite Network, this is how s2Member keeps track of which Blog each User/Member originated from. So this ID#, is automatically associated with a Blog in your Network, matching the User\\\'s point of origin. ~ ONLY a Super Admin can modify this.\\n\\nOn a Multisite Blog Farm, the Originating Blog ID# for your own Customers, will ALWAYS be associated with your ( Main Site ). It is NOT likely that you\\\'ll need to modify this manually, but s2Member makes it available; just in case.\\n\\n*Tip* - If you add Users ( and/or Blogs ) with the `Super Admin` panel inside WordPress® ( via: ms-users.php / ms-sites.php ), then you WILL need to set everything manually. s2Member does NOT tamper with any automation routines whenever YOU ( as a Super Administrator ) are working with that special panel in WordPress®.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_originating_blog" id="ws-plugin--s2member-profile-s2member-originating-blog" value="' . format_to_edit (get_user_meta ($user->ID, "s2member_originating_blog", true)) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_originating_blog", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (!$user->has_cap ("administrator")) /* Do NOT present these details for Administrator accounts. */
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_subscr_id", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Paid Subscr. ID:</label> <a href="#" onclick="alert(\'A Paid Subscr. ID is only valid for paid Members. This will be filled automatically by s2Member. This field will be empty for Free Subscribers, and/or anyone who is NOT paying you. This field is ONLY editable for Customer Service purposes; just in case you ever need to update the Paid Subscr. ID manually. You are not likely to need this, but s2Member makes it editable, just in case.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_subscr_id" id="ws-plugin--s2member-profile-s2member-subscr-id" value="' . format_to_edit (get_user_option ("s2member_subscr_id", $user->ID)) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_subscr_id", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_custom", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Custom Value:</label> <a href="#" onclick="alert(\'A Paid Subscription is always associated with a Custom String that is passed through the custom=\\\'\\\'' . ws_plugin__s2member_esc_sq ($_SERVER["HTTP_HOST"]) . '\\\'\\\' attribute of your Shortcode. This Custom Value, MUST always start with your domain name. However, you can also pipe delimit additional values after your domain, if you need to.\\n\\nFor example:\n' . ws_plugin__s2member_esc_sq ($_SERVER["HTTP_HOST"]) . '|cv1|cv2|cv3\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_custom" id="ws-plugin--s2member-profile-s2member-custom" value="' . format_to_edit (get_user_option ("s2member_custom", $user->ID)) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_custom", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ())
									/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
									{
										foreach ($user->allcaps as $cap => $cap_enabled)
											if (preg_match ("/^access_s2member_ccap_/", $cap))
												$ccaps[] = preg_replace ("/^access_s2member_ccap_/", "", $cap);
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_ccaps", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Custom Capabilities:</label> <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.' . ( (is_multisite ()) ? '\\n\\nCustom Capabilities are assigned on a per-Blog basis. So having a set of Custom Capabilities for one Blog, and having NO Custom Capabilities on another Blog - is very common. This is how permissions are designed to work.' : '') . '\'); return false;" tabindex="-1">[?]</a>' . ( (is_multisite ()) ? '<br /><small>( for this Blog )</small>' : '') . '</th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_ccaps" id="ws-plugin--s2member-profile-s2member-ccaps" value="' . format_to_edit (( (!empty ($ccaps)) ? implode (",", $ccaps) : "")) . '" class="regular-text" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_ccaps", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (!$user->has_cap ("administrator")) /* Do NOT present these details for Administrator accounts. */
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_auto_eot_time", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										$auto_eot_time = get_user_option ("s2member_auto_eot_time", $user->ID);
										$auto_eot_time = ($auto_eot_time) ? date ("D M j, Y g:i a T", $auto_eot_time) : "";
										echo '<th><label>Automatic EOT Time:</label> <a href="#" onclick="alert(\'EOT = End Of Term. ( i.e. Account Expiration / Termination. ).\\n\\nIf you leave this empty, s2Member will configure an EOT Time automatically, based on the paid Subscription associated with this account. In other words, if a paid Subscription expires, is cancelled, terminated, refunded, reversed, or charged back to you; s2Member will deal with the EOT automatically.\\n\\nThat being said, if you would rather take control over this, you can. If you type in a date manually, s2Member will obey the Auto-EOT Time that you\\\'ve given, no matter what. In other words, you can force certain Members to expire automatically, at a time that you specify. s2Member will obey.\\n\\nValid formats for Automatic EOT Time:\\n\\nmm/dd/yyyy\\nyyyy-mm-dd\\n+1 year\\n+2 weeks\\n+2 months\\n+10 minutes\\nnext thursday\\ntomorrow\\ntoday\\n\\n* anything compatible with PHP\\\'s strtotime() function.\'); return false;" tabindex="-1">[?]</a>' . (($auto_eot_time) ? '<br /><small>( based on server time )</small>' : '') . '</th>' . "\n";
										echo '<td><input type="text" name="ws_plugin__s2member_profile_s2member_auto_eot_time" id="ws-plugin--s2member-profile-s2member-auto-eot-time" value="' . format_to_edit ($auto_eot_time) . '" class="regular-text" /></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_auto_eot_time", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if (ws_plugin__s2member_list_servers_integrated ()) /* Only if integrated with s2Member. */
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_opt_in", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										echo '<tr>' . "\n";
										echo '<th><label>Process List Servers:</label> <a href="#" onclick="alert(\'You have at least one List Server integrated with s2Member. Would you like to process a confirmation request for this User? If not, just leave the box un-checked.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
										echo '<td><label><input type="checkbox" name="ws_plugin__s2member_profile_opt_in" id="ws-plugin--s2member-profile-opt-in" value="1" /> Yes, send a mailing list confirmation email to this User.</label></td>' . "\n";
										echo '</tr>' . "\n";
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_opt_in", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Only if configured. */
									if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ($level))
										{
											echo '<tr>' . "\n";
											echo '<td colspan="2">' . "\n";
											echo '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
											echo '</td>' . "\n";
											echo '</tr>' . "\n";
											/**/
											$fields = get_user_option ("s2member_custom_fields", $user->ID); /* Existing fields. */
											/**/
											eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_custom_fields", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
												{
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_before", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
														{
															$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
															$field_id_class = preg_replace ("/_/", "-", $field_var);
															/**/
															eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
															if (apply_filters ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_display", true, get_defined_vars ()))
																{
																	echo '<tr>' . "\n";
																	echo '<th><label>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ucwords (preg_replace ("/_/", " ", $field_var)) : $field["label"]) . ':</label></th>' . "\n";
																	echo '<td>' . ws_plugin__s2member_custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "", ( (preg_match ("/^(text|textarea|select|selects)$/", $field["type"])) ? "width:99%;" : ""), "", "", $fields, $fields[$field_var]) . '</td>' . "\n";
																	echo '</tr>' . "\n";
																}
															unset ($__refs, $__v); /* Unset defined __refs, __v. */
														}
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_after", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
												}
											/**/
											eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_custom_fields", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											echo '<tr>' . "\n";
											echo '<td colspan="2">' . "\n";
											echo '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
											echo '</td>' . "\n";
											echo '</tr>' . "\n";
										}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_notes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '<tr>' . "\n";
								echo '<th><label>Administrative<br />Notations:</label> <a href="#" onclick="alert(\'This is for Administrative purposes. You can keep a list of Notations about this account. These Notations are private; Users/Members will never see these.\\n\\n*Note* The s2Member software may `append` Notes to this field occassionaly, under special circumstances. For example, when/if s2Member demotes a paid Member to a Free Subscriber, s2Member will leave a Note in this field.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
								echo '<td><textarea name="ws_plugin__s2member_profile_s2member_notes" id="ws-plugin--s2member-profile-s2member-notes" rows="5" wrap="off" spellcheck="false" style="width:99%;">' . format_to_edit (get_user_option ("s2member_notes", $user->ID)) . '</textarea></td>' . "\n";
								echo '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_notes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_users_list_edit_cols_after", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '</table>' . "\n";
								/**/
								echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
							}
						/**/
						else if ($current_user->ID === $user->ID) /* Otherwise, a User can always edit their own Profile. */
							{
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Only if configured. */
									if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ($level))
										{
											echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
											/**/
											echo '<h3>Additional Profile Fields' . ( (is_multisite ()) ? ' ( for this Blog )' : '') . '</h3>' . "\n";
											/**/
											echo '<table class="form-table">' . "\n";
											/**/
											eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_users_list_edit_cols_before", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											$fields = get_user_option ("s2member_custom_fields", $user->ID); /* Existing fields. */
											/**/
											eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_users_list_edit_cols_before_custom_fields", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
												{
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_before", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
														{
															if ($field["editable"] !== "no-invisible") /* Uneditable/invisible? */
																{
																	$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
																	$field_id_class = preg_replace ("/_/", "-", $field_var);
																	/**/
																	eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
																	if (apply_filters ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_display", true, get_defined_vars ()))
																		{
																			echo '<tr>' . "\n";
																			echo '<th><label>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ucwords (preg_replace ("/_/", " ", $field_var)) : $field["label"]) . ':</label></th>' . "\n";
																			echo '<td>' . ws_plugin__s2member_custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "", ( (preg_match ("/^(text|textarea|select|selects)$/", $field["type"])) ? "width:99%;" : ""), "", "", $fields, $fields[$field_var], true) . '</td>' . "\n";
																			echo '</tr>' . "\n";
																		}
																	unset ($__refs, $__v); /* Unset defined __refs, __v. */
																}
														}
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_users_list_edit_cols_during_custom_fields_after", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
												}
											/**/
											eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_users_list_edit_cols_after_custom_fields", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
											do_action ("ws_plugin__s2member_during_users_list_edit_cols_after", get_defined_vars ());
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
											/**/
											echo '</table>' . "\n";
											/**/
											echo '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
										}
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_users_list_edit_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
Function that saves custom fields after an admin updates profile.
	
	Attach to: add_action("edit_user_profile_update");
	Attach to: add_action("personal_options_update");
		w/ the Contant available:
		IS_PROFILE_PAGE

Conditionals here need to match those in the function above:
	ws_plugin__s2member_users_list_edit_cols()
*/
if (!function_exists ("ws_plugin__s2member_users_list_update_cols"))
	{
		function ws_plugin__s2member_users_list_update_cols ($user_id = FALSE)
			{
				global $current_site, $current_blog; /* Multisite Networking. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_users_list_update_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$user = new WP_User ($user_id); /* We need both. The $user and $current_user. */
				$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
				/**/
				if ($user && $user->ID && $current_user && $current_user->ID) /* Validate both of these User objects before we even begin. */
					{
						$level = ws_plugin__s2member_user_access_level ($user); /* This User's Access Level for s2Member; needed below. */
						/**/
						if (current_user_can ("edit_users") && (!is_multisite () || is_super_admin () || is_user_member_of_blog ($user->ID)))
							{
								if (is_array ($_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST))) && !empty ($_POST))
									{
										if (isset ($_POST["ws_plugin__s2member_profile_s2member_originating_blog"]) && is_multisite () && is_super_admin ())
											update_user_meta ($user_id, "s2member_originating_blog", $_POST["ws_plugin__s2member_profile_s2member_originating_blog"]);
										/**/
										if (isset ($_POST["ws_plugin__s2member_profile_s2member_custom"]))
											update_user_option ($user_id, "s2member_custom", $_POST["ws_plugin__s2member_profile_s2member_custom"]);
										/**/
										if (isset ($_POST["ws_plugin__s2member_profile_s2member_subscr_id"]))
											update_user_option ($user_id, "s2member_subscr_id", $_POST["ws_plugin__s2member_profile_s2member_subscr_id"]);
										/**/
										if (isset ($_POST["ws_plugin__s2member_profile_s2member_notes"]))
											update_user_option ($user_id, "s2member_notes", $_POST["ws_plugin__s2member_profile_s2member_notes"]);
										/**/
										$auto_eot_time = ($eot = $_POST["ws_plugin__s2member_profile_s2member_auto_eot_time"]) ? strtotime ($eot) : "";
										if (isset ($_POST["ws_plugin__s2member_profile_s2member_auto_eot_time"])) /* Then check if set. */
											update_user_option ($user_id, "s2member_auto_eot_time", $auto_eot_time);
										/**/
										if (isset ($_POST["ws_plugin__s2member_profile_s2member_ccaps"]))
											{
												foreach ($user->allcaps as $cap => $cap_enabled)
													if (preg_match ("/^access_s2member_ccap_/", $cap))
														$user->remove_cap ($ccap = $cap);
												/**/
												foreach (preg_split ("/[\r\n\t\s;,]+/", $_POST["ws_plugin__s2member_profile_s2member_ccaps"]) as $ccap)
													if (strlen ($ccap)) /* Don't add empty capabilities. */
														$user->add_cap ("access_s2member_ccap_" . trim (strtolower ($ccap)));
											}
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
											{
												foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
													{
														$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
														$field_id_class = preg_replace ("/_/", "-", $field_var);
														/**/
														$fields[$field_var] = $_POST["ws_plugin__s2member_profile_" . $field_var];
													}
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
										if ($_POST["ws_plugin__s2member_profile_opt_in"]) /* Process list servers for this User? Only if current_user_can ("edit_users"). */
											ws_plugin__s2member_process_list_servers (ws_plugin__s2member_user_access_role ($user), ws_plugin__s2member_user_access_level ($user), $user->user_email, $user->first_name, $user->last_name, "", true, $user_id);
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_update_cols", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
							}
						/**/
						else if ($current_user->ID === $user->ID) /* Otherwise, a User can always edit their own Profile. */
							{
								if (is_array ($_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST))) && !empty ($_POST))
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
											if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ($level))
												{
													$_existing_fields = get_user_option ("s2member_custom_fields", $user_id);
													/**/
													foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
														{
															$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
															$field_id_class = preg_replace ("/_/", "-", $field_var);
															/**/
															if (!in_array ($field["id"], $fields_applicable) || preg_match ("/^no/", $field["editable"]))
																$fields[$field_var] = $_existing_fields[$field_var];
															/**/
															else if ($field["required"] === "yes" && empty ($_POST["ws_plugin__s2member_profile_" . $field_var])/**/
															&& $_POST["ws_plugin__s2member_profile_" . $field_var] !== "0") /* Allow zeros. */
																$fields[$field_var] = $_existing_fields[$field_var];
															/**/
															else /* Otherwise, we can use the newly updated value. */
																$fields[$field_var] = $_POST["ws_plugin__s2member_profile_" . $field_var];
														}
													/**/
													update_user_option ($user_id, "s2member_custom_fields", $fields);
												}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_users_list_update_cols", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
							}
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_users_list_update_cols", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
Function that synchronizes Paid Registration Times with Role assignments.
Attach to: add_action("set_user_role");
*/
function ws_plugin__s2member_synchronize_paid_reg_times ($user_id = FALSE, $role = FALSE)
	{
		if ($user_id && is_object ($user = new WP_User ($user_id)) && $user->ID)
			if (($level = ws_plugin__s2member_user_access_level ($user)) > 0)
				{
					$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
					$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserve. */
					$pr_times["level" . $level] = (!$pr_times["level" . $level]) ? time () : $pr_times["level" . $level];
					update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
				}
		/**/
		return;
	}
?>