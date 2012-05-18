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
Function that displays the Profile Modification Form.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_profile"))
	{
		function ws_plugin__s2member_profile ()
			{
				do_action ("ws_plugin__s2member_before_profile", get_defined_vars ());
				/**/
				if ($_GET["s2member_profile"] && is_user_logged_in ()) /* Logged in? */
					{
						include_once dirname (dirname (__FILE__)) . "/profile.inc.php";
						/* Additional Hooks/Filters inside profile.inc.php. */
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_profile", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function for handling profile modifications.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_handle_profile_modifications"))
	{
		function ws_plugin__s2member_handle_profile_modifications ()
			{
				do_action ("ws_plugin__s2member_before_handle_profile_modifications", get_defined_vars ());
				/**/
				if ($_GET["s2member_profile"] && ($current_user = (is_user_logged_in ()) ? wp_get_current_user () : false))
					{
						if (($nonce = $_POST["ws_plugin__s2member_profile_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-profile-save"))
							{
								$_POST = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST)); /* Clean POST vars. */
								/**/
								$userdata["ID"] = $user_id = $current_user->ID;
								/**/
								include_once ABSPATH . WPINC . "/registration.php";
								/**/
								if (is_email ($_POST["ws_plugin__s2member_profile_email"]))
									if (!email_exists ($_POST["ws_plugin__s2member_profile_email"]))
										$userdata["user_email"] = $_POST["ws_plugin__s2member_profile_email"];
								/**/
								if ($_POST["ws_plugin__s2member_profile_password"])
									if ($current_user->user_login !== "demo") /* No pass change on demo. */
										$userdata["user_pass"] = $_POST["ws_plugin__s2member_profile_password"];
								/**/
								if ($_POST["ws_plugin__s2member_profile_first_name"])
									$userdata["first_name"] = $_POST["ws_plugin__s2member_profile_first_name"];
								/**/
								if ($_POST["ws_plugin__s2member_profile_display_name"])
									$userdata["display_name"] = $_POST["ws_plugin__s2member_profile_display_name"];
								/**/
								if ($_POST["ws_plugin__s2member_profile_last_name"])
									$userdata["last_name"] = $_POST["ws_plugin__s2member_profile_last_name"];
								/**/
								wp_update_user ($userdata); /* OK. Now send this array for an update. */
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_fields"])
									if ($fields_applicable = ws_plugin__s2member_custom_fields_configured_at_level ("auto-detection"))
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
								do_action ("ws_plugin__s2member_during_handle_profile_modifications", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								echo '<script type="text/javascript">' . "\n";
								echo "if(window.parent && window.parent != window) { try{ window.parent.Shadowbox.close(); } catch(e){} try{ window.parent.tb_remove(); } catch(e){} window.parent.alert('Profile updated successfully!'); window.parent.location = '" . esc_js (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) . "'; }";
								echo "else if(window.opener) { window.close(); window.opener.alert('Profile updated successfully!'); window.opener.location = '" . esc_js (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) . "'; }";
								echo "else { alert('Profile updated successfully!'); window.location = '" . esc_js (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])) . "'; }";
								echo '</script>' . "\n";
								/**/
								exit ();
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_handle_profile_modifications", get_defined_vars ());
				/**/
				return;
			}
	}
?>