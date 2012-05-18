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
Referenced by: /?s2member_profile=1
See: s2Member -> API Scripting -> PHP Constants
	S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL
*/
$tabindex = 0; /* Incremented tabindex starting with 0. */
$current_user = wp_get_current_user (); /* Current user. */
/**/
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
/**/
echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
echo '<head>' . "\n";
/**/
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
echo '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>' . "\n";
echo '<script type="text/javascript" src="' . get_bloginfo ("wpurl") . '/?ws_plugin__s2member_js_w_globals=1&amp;no-cache=' . urlencode (md5 (mt_rand ())) . '"></script>' . "\n";
/**/
echo '<title>My Profile</title>' . "\n";
/**/
eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
do_action ("ws_plugin__s2member_during_profile_head", get_defined_vars ());
unset ($__refs, $__v); /* Unset defined __refs, __v. */
/**/
echo '</head>' . "\n";
/**/
echo '<body style="background:#FFFFFF; color:#333333; font-family:\'Verdana\', sans-serif; font-size:13px;">' . "\n";
/**/
echo '<form method="post" name="ws_plugin__s2member_profile" id="ws-plugin--s2member-profile">' . "\n";
/**/
echo '<input type="hidden" name="ws_plugin__s2member_profile_save" id="ws-plugin--s2member-profile-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-profile-save")) . '" />' . "\n";
/**/
eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
do_action ("ws_plugin__s2member_during_profile_before_table", get_defined_vars ());
unset ($__refs, $__v); /* Unset defined __refs, __v. */
/**/
echo '<table cellpadding="5" cellspacing="5" style="width:100%; border:0;">' . "\n";
echo '<tbody>' . "\n";
/**/
eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
do_action ("ws_plugin__s2member_during_profile_before_fields", get_defined_vars ());
unset ($__refs, $__v); /* Unset defined __refs, __v. */
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_username", true, get_defined_vars ()))
	{
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_before_username", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		echo '<tr>' . "\n";
		echo '<td>' . "\n";
		echo '<label>' . "\n";
		echo '<strong>Username *</strong> ( cannot be changed )<br />' . "\n";
		echo '<input aria-required="true" type="text" maxlength="60" name="ws_plugin__s2member_profile_login" id="ws-plugin--s2member-profile-login" style="width:99%;" value="' . format_to_edit ($current_user->user_login) . '" disabled="disabled" />' . "\n";
		echo '</label>' . "\n";
		echo '</td>' . "\n";
		echo '</tr>' . "\n";
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_after_username", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_email", true, get_defined_vars ()))
	{
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_before_email", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		echo '<tr>' . "\n";
		echo '<td>' . "\n";
		echo '<label>' . "\n";
		echo '<strong>Email Address *</strong><br />' . "\n";
		echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_email" id="ws-plugin--s2member-profile-email" style="width:99%;" value="' . format_to_edit ($current_user->user_email) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
		echo '</label>' . "\n";
		echo '</td>' . "\n";
		echo '</tr>' . "\n";
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_after_email", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_first_name", true, get_defined_vars ()))
	{
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_before_first_name", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		echo '<tr>' . "\n";
		echo '<td>' . "\n";
		echo '<label>' . "\n";
		echo '<strong>First Name *</strong><br />' . "\n";
		echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_first_name" id="ws-plugin--s2member-profile-first-name" style="width:99%;" value="' . format_to_edit ($current_user->first_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
		echo '</label>' . "\n";
		echo '</td>' . "\n";
		echo '</tr>' . "\n";
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_after_first_name", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_last_name", true, get_defined_vars ()))
	{
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_before_last_name", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		echo '<tr>' . "\n";
		echo '<td>' . "\n";
		echo '<label>' . "\n";
		echo '<strong>Last Name *</strong><br />' . "\n";
		echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_last_name" id="ws-plugin--s2member-profile-last-name" style="width:99%;" value="' . format_to_edit ($current_user->last_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
		echo '</label>' . "\n";
		echo '</td>' . "\n";
		echo '</tr>' . "\n";
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_after_last_name", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_display_name", true, get_defined_vars ()))
	{
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_before_display_name", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		echo '<tr>' . "\n";
		echo '<td>' . "\n";
		echo '<label>' . "\n";
		echo '<strong>Display Name *</strong><br />' . "\n";
		echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_profile_display_name" id="ws-plugin--s2member-profile-display-name" style="width:99%;" value="' . format_to_edit ($current_user->display_name) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
		echo '</label>' . "\n";
		echo '</td>' . "\n";
		echo '</tr>' . "\n";
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_after_last_name", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_custom_fields", true, get_defined_vars ()))
	{
		if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"]) /* Now, do we have Custom Fields? */
			if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ("auto-detection"))
				{
					$fields = get_user_option ("s2member_custom_fields", $current_user->ID); /* Existing fields. */
					/**/
					eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
					do_action ("ws_plugin__s2member_during_profile_during_fields_before_custom_fields", get_defined_vars ());
					unset ($__refs, $__v); /* Unset defined __refs, __v. */
					/**/
					foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
						{
							eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
							do_action ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_before", get_defined_vars ());
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
											if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_display", true, get_defined_vars ()))
												{
													echo '<tr>' . "\n";
													echo '<td>' . "\n";
													echo '<label>' . "\n";
													echo '<strong' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ' style="display:none;"' : '') . '>' . $field["label"] . ( ($field["required"] === "yes") ? ' *' : '') . '</strong>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? '' : '<br />') . "\n";
													echo ws_plugin__s2member_custom_field_gen ("ws_plugin__s2member_profile", $field, "ws_plugin__s2member_profile_", "ws-plugin--s2member-profile-", "", ( (preg_match ("/^(select|selects)$/", $field["type"])) ? "width:100%;" : ( (preg_match ("/^(text|textarea)$/", $field["type"])) ? "width:99%;" : "")), ($tabindex = $tabindex + 10), "", $fields, $fields[$field_var], true);
													echo '</label>' . "\n";
													echo '</td>' . "\n";
													echo '</tr>' . "\n";
												}
											unset ($__refs, $__v); /* Unset defined __refs, __v. */
										}
								}
							/**/
							eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
							do_action ("ws_plugin__s2member_during_profile_during_fields_during_custom_fields_after", get_defined_vars ());
							unset ($__refs, $__v); /* Unset defined __refs, __v. */
						}
					/**/
					eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
					do_action ("ws_plugin__s2member_during_profile_during_fields_after_custom_fields", get_defined_vars ());
					unset ($__refs, $__v); /* Unset defined __refs, __v. */
				}
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_profile_during_fields_display_password", true, get_defined_vars ()))
	{
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_before_password", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
		/**/
		echo '<tr>' . "\n";
		echo '<td>' . "\n";
		/**/
		echo '<label title="Please type your Password twice to confirm.">' . "\n";
		echo '<strong>New Password</strong> ( only if you want to change it )<br />' . "\n";
		echo '<input type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_profile_password" id="ws-plugin--s2member-profile-password" style="width:99%;" value="" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '"' . ( ($current_user->user_login === "demo") ? ' disabled="disabled"' : '') . ' />' . "\n";
		echo '</label>' . "\n";
		/**/
		echo '<label title="Please type your Password twice to confirm.">' . "\n";
		echo '<input type="password" maxlength="100" autocomplete="off" id="ws-plugin--s2member-profile-password-confirmation" style="width:99%;" value="" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '"' . ( ($current_user->user_login === "demo") ? ' disabled="disabled"' : '') . ' />' . "\n";
		echo '</label>' . "\n";
		/**/
		echo '</td>' . "\n";
		echo '</tr>' . "\n";
		/**/
		eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
		do_action ("ws_plugin__s2member_during_profile_during_fields_after_password", get_defined_vars ());
		unset ($__refs, $__v); /* Unset defined __refs, __v. */
	}
/**/
eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
do_action ("ws_plugin__s2member_during_profile_after_fields", get_defined_vars ());
unset ($__refs, $__v); /* Unset defined __refs, __v. */
/**/
echo '<tr>' . "\n";
echo '<td>' . "\n";
echo '<input type="submit" value="Save Changes" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
echo '</td>' . "\n";
echo '</tr>' . "\n";
/**/
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
do_action ("ws_plugin__s2member_during_profile_after_table", get_defined_vars ());
unset ($__refs, $__v); /* Unset defined __refs, __v. */
/**/
echo '</form>' . "\n";
/**/
echo '</form>' . "\n";
/**/
echo '</body>' . "\n";
echo '</html>';
?>