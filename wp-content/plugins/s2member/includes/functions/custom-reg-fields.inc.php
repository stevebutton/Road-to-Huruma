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
Handles the creation of Custom Fields.
*/
if (!function_exists ("ws_plugin__s2member_custom_field_gen"))
	{
		function ws_plugin__s2member_custom_field_gen ($_function = FALSE, $_field = FALSE, $_name_prefix = FALSE, $_id_prefix = FALSE, $_classes = FALSE, $_styles = FALSE, $_tabindex = FALSE, $_attrs = FALSE, $_submission = FALSE, $_value = FALSE, $_lock_uneditables = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_custom_field_gen", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($_function && is_array ($field = $_field) && $field["type"] && $field["id"] && $_name_prefix && $_id_prefix)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_field_gen_before", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
						$field_id_class = preg_replace ("/_/", "-", $field_var);
						/**/
						$name_suffix = (preg_match ("/\[$/", $_name_prefix)) ? ']' : '';
						$field_name = trim ($_name_prefix . $field_var . $name_suffix);
						/**/
						$common = ''; /* Common attribute configuration. */
						$common .= ' name="' . esc_attr ($field_name) . '"';
						$common .= ' id="' . esc_attr ($_id_prefix . $field_id_class) . '"';
						$common .= ( ($field["required"] === "yes") ? ' aria-required="true"' : '');
						$common .= ( (strlen ($_tabindex)) ? ' tabindex="' . esc_attr ($_tabindex) . '"' : '');
						$common .= ( ($field["expected"]) ? ' data-expected="' . esc_attr ($field["expected"]) . '"' : '');
						$common .= ( (preg_match ("/^no/", $field["editable"]) && $_lock_uneditables) ? ' disabled="disabled"' : '');
						$common .= ( ($_classes || $field["classes"]) ? ' class="' . esc_attr (trim ($_classes . ( ($field["classes"]) ? ' ' . $field["classes"] : ''))) . '"' : '');
						$common .= ( ($_styles || $field["styles"]) ? ' style="' . esc_attr (trim ($_styles . ( ($field["styles"]) ? ' ' . $field["styles"] : ''))) . '"' : '');
						$common .= ( ($_attrs || $field["attrs"]) ? ' ' . trim ($_attrs . ( ($field["attrs"]) ? ' ' . $field["attrs"] : '')) : '');
						/**/
						if ($field["type"] === "text")
							{
								$gen = '<input type="text" maxlength="100"';
								$gen .= ' value="' . format_to_edit ((string)$_value) . '"';
								$gen .= $common . ' />';
							}
						/**/
						else if ($field["type"] === "textarea")
							{
								$gen = '<textarea rows="3"' . $common . '>';
								$gen .= format_to_edit ((string)$_value);
								$gen .= '</textarea>';
							}
						/**/
						else if ($field["type"] === "select" && $field["options"])
							{
								$gen = '<select' . $common . '>';
								foreach (preg_split ("/[\r\n\t]+/", $field["options"]) as $option_line)
									{
										list ($option_value, $option_label, $option_default) = ws_plugin__s2member_trim_deep (preg_split ("/\|/", trim ($option_line)));
										$gen .= '<option value="' . esc_attr ($option_value) . '"' . ( ( ($option_default && !$_submission) || $option_value === (string)$_value) ? ' selected="selected"' : '') . '>' . $option_label . '</option>';
									}
								$gen .= '</select>';
							}
						/**/
						else if ($field["type"] === "selects" && $field["options"])
							{
								$common = preg_replace ('/ name\="(.+?)"/', ' name="$1[]"', $common);
								$common = preg_replace ('/ style\="(.+?)"/', ' style="height:auto; $1"', $common);
								/**/
								$gen = '<select multiple="multiple" size="3"' . $common . '>';
								foreach (preg_split ("/[\r\n\t]+/", $field["options"]) as $option_line)
									{
										list ($option_value, $option_label, $option_default) = ws_plugin__s2member_trim_deep (preg_split ("/\|/", trim ($option_line)));
										$gen .= '<option value="' . esc_attr ($option_value) . '"' . ( ( ($option_default && !$_submission) || in_array ($option_value, (array)$_value)) ? ' selected="selected"' : '') . '>' . $option_label . '</option>';
									}
								$gen .= '</select>';
							}
						/**/
						else if ($field["type"] === "checkbox")
							{
								$gen = '<input type="checkbox" value="1"';
								$gen .= ( ((string)$_value) ? ' checked="checked"' : '');
								$gen .= $common . ' /><label for="' . esc_attr ($_id_prefix . $field_id_class) . '" style="display:inline;">' . $field["label"] . '</label>';
							}
						/**/
						else if ($field["type"] === "pre_checkbox")
							{
								$gen = '<input type="checkbox" value="1"';
								$gen .= ( (!$_submission || (string)$_value) ? ' checked="checked"' : '');
								$gen .= $common . ' /><label for="' . esc_attr ($_id_prefix . $field_id_class) . '" style="display:inline;">' . $field["label"] . '</label>';
							}
						/**/
						else if ($field["type"] === "checkboxes" && $field["options"])
							{
								$gen = ""; /* Initialize generated field. */
								/**/
								$common = preg_replace ('/ name\="(.+?)"/', ' name="$1[]"', $common);
								/**/
								$sep = apply_filters ("ws_plugin__s2member_custom_field_gen_" . $field["type"] . "_sep", "&nbsp;&nbsp;", get_defined_vars ());
								$opl = apply_filters ("ws_plugin__s2member_custom_field_gen_" . $field["type"] . "_opl", "ws-plugin--s2member-custom-reg-field-op-l", get_defined_vars ());
								/**/
								foreach (preg_split ("/[\r\n\t]+/", $field["options"]) as $i => $option_line)
									{
										$common_i = preg_replace ('/ id\="(.+?)"/', ' id="$1-' . ($i) . '"', $common);
										/**/
										list ($option_value, $option_label, $option_default) = ws_plugin__s2member_trim_deep (preg_split ("/\|/", trim ($option_line)));
										/**/
										$gen .= ($i > 0) ? $sep : ''; /* Separators can be filtered above. */
										$gen .= '<input type="checkbox" value="' . esc_attr ($option_value) . '"';
										$gen .= ( ( ($option_default && !$_submission) || in_array ($option_value, (array)$_value)) ? ' checked="checked"' : '');
										$gen .= $common_i . ' /><label for="' . esc_attr ($_id_prefix . $field_id_class . "-" . $i) . '" class="' . esc_attr ($opl) . '" style="display:inline;">' . $option_label . '</label>';
									}
							}
						/**/
						else if ($field["type"] === "radios" && $field["options"])
							{
								$gen = ""; /* Initialize generated field. */
								/**/
								$sep = apply_filters ("ws_plugin__s2member_custom_field_gen_" . $field["type"] . "_sep", "&nbsp;&nbsp;", get_defined_vars ());
								$opl = apply_filters ("ws_plugin__s2member_custom_field_gen_" . $field["type"] . "_opl", "ws-plugin--s2member-custom-reg-field-op-l", get_defined_vars ());
								/**/
								foreach (preg_split ("/[\r\n\t]+/", $field["options"]) as $i => $option_line)
									{
										$common_i = preg_replace ('/ id\="(.+?)"/', ' id="$1-' . ($i) . '"', $common);
										/**/
										list ($option_value, $option_label, $option_default) = ws_plugin__s2member_trim_deep (preg_split ("/\|/", trim ($option_line)));
										/**/
										$gen .= ($i > 0) ? $sep : ''; /* Separators can be filtered above. */
										$gen .= '<input type="radio" value="' . esc_attr ($option_value) . '"';
										$gen .= ( ( ($option_default && !$_submission) || $option_value === (string)$_value) ? ' checked="checked"' : '');
										$gen .= $common_i . ' /><label for="' . esc_attr ($_id_prefix . $field_id_class . "-" . $i) . '" class="' . esc_attr ($opl) . '" style="display:inline;">' . $option_label . '</label>';
									}
							}
						else /* Otherwise, we use a default text field. */
							{
								$gen = '<input type="text" maxlength="100"';
								$gen .= ' value="' . format_to_edit ((string)$_value) . '"';
								$gen .= $common . ' />';
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_field_gen_after", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				return apply_filters ("ws_plugin__s2member_custom_field_gen", $gen, get_defined_vars ());
			}
	}
/*
Function determines whether or not Custom Fields apply to a specific Level.
The $level parameter defaults to the current User's Access Level number.
	$level MUST be numeric >= 0.
*/
if (!function_exists ("ws_plugin__s2member_custom_fields_configured_at_level"))
	{
		function ws_plugin__s2member_custom_fields_configured_at_level ($_level = "auto-detection")
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_custom_fields_configured_at_level", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$level = ($_level === "auto-detection") ? ws_plugin__s2member_user_access_level () : $_level;
				if ($_level === "auto-detection" && $level < 0 && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($cookie = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))))
					list ($level) = preg_split ("/\:/", $cookie, 3);
				/**/
				$level = (!is_numeric ($level) || $level < 0) ? 0 : $level; /* Always default to Level #0. */
				/**/
				if (is_numeric ($level) && $level >= 0 && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
					{
						foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
							if ($field["levels"] === "all" || in_array ($level, preg_split ("/[;,]+/", preg_replace ("/[^0-9,]/", "", $field["levels"]))))
								$configured[] = $field["id"]; /* Add this to the array. */
					}
				/**/
				return apply_filters ("ws_plugin__s2member_custom_fields_configured_at_level", $configured, get_defined_vars ());
			}
	}
/*
This adds custom fields to `wp-signup.php`.
Attach to: add_action("signup_extra_fields");
~ For Multisite Blog Farms.
*/
if (!function_exists ("ws_plugin__s2member_ms_custom_registration_fields"))
	{
		function ws_plugin__s2member_ms_custom_registration_fields ()
			{
				do_action ("ws_plugin__s2member_before_ms_custom_registration_fields", get_defined_vars ());
				/**/
				if (is_multisite () && is_main_site ()) /* Must be Multisite / Main Site. */
					{
						$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST));
						/**/
						echo '<input type="hidden" name="ws_plugin__s2member_registration" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-registration")) . '" />' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_first_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<label for="ws-plugin--s2member-custom-reg-field-first-name">First Name *</label>' . "\n";
						echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) . '" />' . "\n";
						echo '<br />' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_first_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_last_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<label for="ws-plugin--s2member-custom-reg-field-last-name">Last Name *</label>' . "\n";
						echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) . '" />' . "\n";
						echo '<br />' . "\n";
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_last_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
							if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ("auto-detection"))
								foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
									{
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_custom_fields", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
										/**/
										if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
											{
												$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
												$field_id_class = preg_replace ("/_/", "-", $field_var);
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												if (apply_filters ("ws_plugin__s2member_during_ms_custom_registration_fields_during_custom_fields_display", true, get_defined_vars ()))
													{
														echo '<label for="ws-plugin--s2member-custom-reg-field-' . $field_id_class . '"' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ' style="display:none;"' : '') . '>' . $field["label"] . ( ($field["required"] === "yes") ? ' *' : '') . '</label>' . "\n";
														echo ws_plugin__s2member_custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_custom_reg_field_", "ws-plugin--s2member-custom-reg-field-", "ws-plugin--s2member-custom-reg-field", "", "", "", $_POST, $_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]);
														echo '<br />' . "\n";
													}
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_custom_fields", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_before_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '<label for="ws-plugin--s2member-custom-reg-field-opt-in">' . "\n";
								echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" class="ws-plugin--s2member-custom-reg-field" value="1"' . ( ( (empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' />' . "\n";
								echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
								echo '</label>' . "\n";
								echo '<br />' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after_opt_in", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
						/**/
						echo '<br />' . "\n"; /* Toss in one extra line break ( extra margin ). */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_ms_custom_registration_fields_after", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_ms_custom_registration_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
This adds custom fields to `wp-login.php?action=register`.
Attach to: add_action("register_form");
*/
if (!function_exists ("ws_plugin__s2member_custom_registration_fields"))
	{
		function ws_plugin__s2member_custom_registration_fields ()
			{
				do_action ("ws_plugin__s2member_before_custom_registration_fields", get_defined_vars ());
				/**/
				$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST));
				/**/
				echo '<input type="hidden" name="ws_plugin__s2member_registration" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-registration")) . '" />' . "\n";
				/**/
				$tabindex = 20; /* Incremented tabindex starting with 20. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_before", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"] && function_exists ("ws_plugin__s2member_generate_password"))
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_before_user_pass", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo '<span>Password *</span><br />' . "\n";
						echo '<input aria-required="true" type="password" maxlength="100" autocomplete="off" name="ws_plugin__s2member_custom_reg_field_user_pass" id="ws-plugin--s2member-custom-reg-field-user-pass" class="ws-plugin--s2member-custom-reg-field" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
						echo '</label>' . "\n";
						echo '</p>';
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_after_user_pass", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_before_first_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo '<span>First Name *</span><br />' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_first_name" id="ws-plugin--s2member-custom-reg-field-first-name" class="ws-plugin--s2member-custom-reg-field" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_first_name"]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_after_first_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_before_last_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				echo '<p>' . "\n";
				echo '<label>' . "\n";
				echo '<span>Last Name *</span><br />' . "\n";
				echo '<input aria-required="true" type="text" maxlength="100" name="ws_plugin__s2member_custom_reg_field_last_name" id="ws-plugin--s2member-custom-reg-field-last-name" class="ws-plugin--s2member-custom-reg-field" value="' . format_to_edit ($_POST["ws_plugin__s2member_custom_reg_field_last_name"]) . '" tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
				echo '</label>' . "\n";
				echo '</p>';
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_after_last_name", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
					if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ("auto-detection"))
						foreach (json_decode ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"], true) as $field)
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_custom_registration_fields_before_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (in_array ($field["id"], $fields_applicable)) /* Field applicable? */
									{
										$field_var = preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field["id"]));
										$field_id_class = preg_replace ("/_/", "-", $field_var);
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										if (apply_filters ("ws_plugin__s2member_during_custom_registration_fields_during_custom_fields_display", true, get_defined_vars ()))
											{
												echo '<p>' . "\n";
												echo '<label>' . "\n";
												echo '<span' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? ' style="display:none;"' : '') . '>' . $field["label"] . ( ($field["required"] === "yes") ? ' *' : '') . '</span>' . ( (preg_match ("/^(checkbox|pre_checkbox)$/", $field["type"])) ? '' : '<br />') . "\n";
												echo ws_plugin__s2member_custom_field_gen (__FUNCTION__, $field, "ws_plugin__s2member_custom_reg_field_", "ws-plugin--s2member-custom-reg-field-", "ws-plugin--s2member-custom-reg-field", "", ($tabindex = $tabindex + 10), "", $_POST, $_POST["ws_plugin__s2member_custom_reg_field_" . $field_var]);
												echo '</label>' . "\n";
												echo '</p>';
											}
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_custom_registration_fields_after_custom_fields", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
							}
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_before_opt_in", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" class="ws-plugin--s2member-custom-reg-field" value="1"' . ( ( (empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' tabindex="' . esc_attr (($tabindex = $tabindex + 10)) . '" />' . "\n";
						echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
						echo '</label>' . "\n";
						echo '</p>';
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_custom_registration_fields_after_opt_in", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_custom_registration_fields_after", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_custom_registration_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
/*
This adds an opt-in checkbox to the BuddyPress signup form.
Attach to: add_action("bp_before_registration_submit_buttons");
*/
if (!function_exists ("ws_plugin__s2member_opt_in_4bp"))
	{
		function ws_plugin__s2member_opt_in_4bp ()
			{
				do_action ("ws_plugin__s2member_before_opt_in_4bp", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] && ws_plugin__s2member_list_servers_integrated ())
					{
						do_action ("ws_plugin__s2member_during_opt_in_4bp_before", get_defined_vars ());
						/**/
						echo '<div class="s2member-opt-in-4bp" style="' . apply_filters ("ws_plugin__s2member_opt_in_4bp_styles", "clear:both; padding-top:10px; margin-left:-3px;", get_defined_vars ()) . '">' . "\n";
						/**/
						echo '<p>' . "\n";
						echo '<label>' . "\n";
						echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_field_opt_in" id="ws-plugin--s2member-custom-reg-field-opt-in" class="ws-plugin--s2member-custom-reg-field" value="1"' . ( ( (empty ($_POST) && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) || $_POST["ws_plugin__s2member_custom_reg_field_opt_in"]) ? ' checked="checked"' : '') . ' />' . "\n";
						echo $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"] . "\n";
						echo '</label>' . "\n";
						echo '</p>';
						/**/
						echo '</div>' . "\n";
						/**/
						do_action ("ws_plugin__s2member_during_opt_in_4bp_after", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_opt_in_4bp", get_defined_vars ());
				/**/
				return;
			}
	}
?>