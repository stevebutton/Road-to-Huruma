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
Function that adds custom fields to `/wp-admin/user-new.php`.
We have to buffer output because `/user-new.php` has NO Hooks.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_admin_user_new_fields"))
	{
		function ws_plugin__s2member_admin_user_new_fields ()
			{
				global $pagenow; /* The current admin page file name. */
				/**/
				do_action ("ws_plugin__s2member_before_admin_user_new_fields", get_defined_vars ());
				/**/
				if (is_admin () && $pagenow === "user-new.php" && current_user_can ("create_users"))
					{
						ob_start ("_ws_plugin__s2member_admin_user_new_fields"); /* No Hooks, so we buffer. */
						/**/
						do_action ("ws_plugin__s2member_during_admin_user_new_fields", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_admin_user_new_fields", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Callback that adds custom fields to `/wp-admin/user-new.php`.
We have to buffer output because `/user-new.php` has NO Hooks.
Attach to: ob_start("_ws_plugin__s2member_admin_user_new_fields");
*/
if (!function_exists ("_ws_plugin__s2member_admin_user_new_fields"))
	{
		function _ws_plugin__s2member_admin_user_new_fields ($buffer = FALSE)
			{
				global $pagenow; /* The current admin page file name. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_before_admin_user_new_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_admin () && $pagenow === "user-new.php" && current_user_can ("create_users"))
					{
						$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST));
						/**/
						$unfs = '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
						/**/
						$unfs .= '<h3 style="position:relative;"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/large-icon.png" title="s2Member ( a Membership management system for WordPress® )" alt="" style="position:absolute; top:-15px; right:0; border:0;" />s2Member Configuration &amp; Profile Fields' . ( (is_multisite ()) ? ' ( for this Blog )' : '') . '</h3>' . "\n";
						/**/
						$unfs .= '<table class="form-table">' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite ()) /* Multisite Networking is currently lacking these fields; we pop them in. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_first_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>First Name:</label></th>' . "\n";
								$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_first_name" id="ws-plugin--s2member-user-new-first-name" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_first_name"]) . '" class="regular-text" /></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_first_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_last_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>Last Name:</label></th>' . "\n";
								$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_last_name" id="ws-plugin--s2member-user-new-last-name" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_last_name"]) . '" class="regular-text" /></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_last_name", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_subscr_id", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Paid Subscr. ID:</label> <a href="#" onclick="alert(\'A Paid Subscr. ID is only valid for paid Members. Under normal circumstances, this is filled automatically by s2Member. This field is ONLY here for Customer Service purposes; just in case you ever need to enter a Paid Subscr. ID manually.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
						$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_subscr_id" id="ws-plugin--s2member-user-new-s2member-subscr-id" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_subscr_id"]) . '" class="regular-text" /></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_subscr_id", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_custom", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Custom Value:</label> <a href="#" onclick="alert(\'A Paid Subscription is always associated with a Custom String that is passed through the custom=\\\'\\\'' . ws_plugin__s2member_esc_sq ($_SERVER["HTTP_HOST"]) . '\\\'\\\' attribute of your Shortcode. This Custom Value, MUST always start with your domain name. However, you can also pipe delimit additional values after your domain, if you need to.\\n\\nFor example:\n' . ws_plugin__s2member_esc_sq ($_SERVER["HTTP_HOST"]) . '|cv1|cv2|cv3\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
						$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_custom" id="ws-plugin--s2member-user-new-s2member-custom" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_custom"]) . '" class="regular-text" /></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_custom", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ())
							/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_ccaps", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>Custom Capabilities:</label> <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.' . ( (is_multisite ()) ? '\\n\\nCustom Capabilities are assigned on a per-Blog basis. So having a set of Custom Capabilities for one Blog, and having NO Custom Capabilities on another Blog - is very common. This is how permissions are designed to work.' : '') . '\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
								$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_ccaps" id="ws-plugin--s2member-user-new-s2member-ccaps" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_ccaps"]) . '" class="regular-text" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" /></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_ccaps", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_auto_eot_time", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Automatic EOT Time:</label> <a href="#" onclick="alert(\'EOT = End Of Term. ( i.e. Account Expiration / Termination. ).\\n\\nIf you leave this empty, s2Member will configure an EOT Time automatically, based on the paid Subscription associated with this account. In other words, if a paid Subscription expires, is cancelled, terminated, refunded, reversed, or charged back to you; s2Member will deal with the EOT automatically.\\n\\nThat being said, if you would rather take control over this, you can. If you type in a date manually, s2Member will obey the Auto-EOT Time that you\\\'ve given, no matter what. In other words, you can force certain Members to expire automatically, at a time that you specify. s2Member will obey.\\n\\nValid formats for Automatic EOT Time:\\n\\nmm/dd/yyyy\\nyyyy-mm-dd\\n+1 year\\n+2 weeks\\n+2 months\\n+10 minutes\\nnext thursday\\ntomorrow\\ntoday\\n\\n* anything compatible with PHP\\\'s strtotime() function.\'); return false;" tabindex="-1">[?]</a>' . (($auto_eot_time) ? '<br /><small>( based on server time )</small>' : '') . '</th>' . "\n";
						$unfs .= '<td><input type="text" name="ws_plugin__s2member_user_new_s2member_auto_eot_time" id="ws-plugin--s2member-user-new-auto-eot-time" value="' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_auto_eot_time"]) . '" class="regular-text" /></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_auto_eot_time", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (ws_plugin__s2member_list_servers_integrated ()) /* Only if integrated with s2Member. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<th><label>Process List Servers:</label> <a href="#" onclick="alert(\'You have at least one List Server integrated with s2Member. Would you like to process a confirmation request for this new User? If not, just leave the box un-checked.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
								$unfs .= '<td><label><input type="checkbox" name="ws_plugin__s2member_user_new_opt_in" id="ws-plugin--s2member-user-new-opt-in" value="1"' . ( ($_POST["ws_plugin__s2member_user_new_opt_in"]) ? ' checked="checked"' : '') . ' /> Yes, send a mailing list confirmation email to this new User.</label></td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Only if configured. */
							{
								$unfs .= '<tr>' . "\n";
								$unfs .= '<td colspan="2">' . "\n";
								$unfs .= '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
								$unfs .= '</td>' . "\n";
								$unfs .= '</tr>' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("_ws_plugin__s2member_during_admin_user_new_fields_during_custom_fields_before", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
										$field_id_class = preg_replace ("/_/", "-", $field_var);
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										if (apply_filters ("_ws_plugin__s2member_during_admin_user_new_fields_during_custom_fields_display", true, get_defined_vars ()))
											{
												$unfs .= '<tr>' . "\n";
												$unfs .= '<th><label>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ucwords (preg_replace ("/_/", " ", $field_var)) : $field["label"]) . ':</label></th>' . "\n";
												$unfs .= '<td>' . ws_plugin__s2member_custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_user_new_", "ws-plugin--s2member-user-new-", "", ( (preg_match ("/^(text|textarea|select|selects)$/", $field["type"])) ? "width:99%;" : ""), "", "", $_POST, $_POST["ws_plugin__s2member_user_new_" . $field_var]) . '</td>' . "\n";
												$unfs .= '</tr>' . "\n";
											}
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("_ws_plugin__s2member_during_admin_user_new_fields_during_custom_fields_after", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								$unfs .= '<tr>' . "\n";
								$unfs .= '<td colspan="2">' . "\n";
								$unfs .= '<div style="height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
								$unfs .= '</td>' . "\n";
								$unfs .= '</tr>' . "\n";
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_before_notes", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '<tr>' . "\n";
						$unfs .= '<th><label>Administrative<br />Notations:</label> <a href="#" onclick="alert(\'This is for Administrative purposes. You can keep a list of Notations about this account. These Notations are private; Users/Members will never see these.\\n\\n*Note* The s2Member software may `append` Notes to this field occassionaly, under special circumstances. For example, when/if s2Member demotes a paid Member to a Free Subscriber, s2Member will leave a Note in this field.\'); return false;" tabindex="-1">[?]</a></th>' . "\n";
						$unfs .= '<td><textarea name="ws_plugin__s2member_user_new_s2member_notes" id="ws-plugin--s2member-user-new-s2member-notes" rows="5" wrap="off" spellcheck="false" style="width:99%;">' . format_to_edit ($_POST["ws_plugin__s2member_user_new_s2member_notes"]) . '</textarea></td>' . "\n";
						$unfs .= '</tr>' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after_notes", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_during_admin_user_new_fields_after", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$unfs .= '</table>' . "\n";
						/**/
						$unfs .= '<div style="margin:25px 0 25px 0; height:1px; line-height:1px; background:#CCCCCC;"></div>' . "\n";
						/**/
						$buffer = preg_replace ("/(\<\/table\>)([\r\n\t\s ]*)(\<p class\=\"submit\"\>)/", "$1$2" . $unfs . "$3", $buffer);
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_after_admin_user_new_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return apply_filters ("_ws_plugin__s2member_admin_user_new_fields", $buffer, get_defined_vars ());
			}
	}
?>