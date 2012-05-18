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
Forces a default Role for new registrations, NOT tied to an incoming payment.
Attach to: add_filter("pre_option_default_role");
*/
if (!function_exists ("ws_plugin__s2member_force_default_role"))
	{
		function ws_plugin__s2member_force_default_role ($default_role = FALSE)
			{
				do_action ("ws_plugin__s2member_before_force_default_role", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_force_default_role", ($default_role = "subscriber"), get_defined_vars ());
			}
	}
/*
Forces a default Role for new Multisite registrations ( on the Main Site ) NOT tied to an incoming payment.
Attach to: add_filter("pre_site_option_default_user_role");
*/
if (!function_exists ("ws_plugin__s2member_force_mms_default_role"))
	{
		function ws_plugin__s2member_force_mms_default_role ($default_role = FALSE)
			{
				do_action ("ws_plugin__s2member_before_force_mms_default_role", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_force_mms_default_role", ($default_role = "subscriber"), get_defined_vars ());
			}
	}
/*
Forces a specific Role to demote to; whenever a Member is demoted in one way or another.
Use by PayPal® IPN routines, and also by the Auto-EOT system.
*/
if (!function_exists ("ws_plugin__s2member_force_demotion_role"))
	{
		function ws_plugin__s2member_force_demotion_role ($demotion_role = FALSE)
			{
				do_action ("ws_plugin__s2member_before_force_demotion_role", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_force_demotion_role", ($demotion_role = "subscriber"), get_defined_vars ());
			}
	}
/*
Allows new Users to be created on a Multisite Network.
Attach to: add_filter("pre_site_option_add_new_users");
*/
if (!function_exists ("ws_plugin__s2member_mms_allow_new_users"))
	{
		function ws_plugin__s2member_mms_allow_new_users ($allow = FALSE)
			{
				do_action ("ws_plugin__s2member_before_mms_allow_new_users", get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_mms_allow_new_users", ($allow = "1"), get_defined_vars ());
			}
	}
/*
Forces a Multisite Dashboard Blog to be the Main Site.
Attach to: add_filter("pre_site_option_dashboard_blog");
*/
if (!function_exists ("ws_plugin__s2member_mms_dashboard_blog"))
	{
		function ws_plugin__s2member_mms_dashboard_blog ($dashboard_blog = FALSE)
			{
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				do_action ("ws_plugin__s2member_before_mms_dashboard_blog", get_defined_vars ());
				/**/
				$main_site = ( (is_multisite ()) ? $current_site->blog_id : "1"); /* Forces the Main Site. */
				/**/
				return apply_filters ("ws_plugin__s2member_mms_dashboard_blog", ($dashboard_blog = $main_site), get_defined_vars ());
			}
	}
/*
Function for allowing access to the Registration Form.
This function has been further optimized to reduce DB queries.
Attach to: add_filter("pre_option_users_can_register");
*/
if (!function_exists ("ws_plugin__s2member_check_register_access"))
	{
		function ws_plugin__s2member_check_register_access ($users_can_register = FALSE)
			{
				global $wpdb; /* Global database object reference */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_check_register_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$by_default = $users_can_register = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["allow_subscribers_in"];
				/**/
				if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && is_main_site ())
					return apply_filters ("ws_plugin__s2member_check_register_access", ($users_can_register = "0"), get_defined_vars ());
				/**/
				else if (!is_admin () && !$users_can_register) /* Do NOT run these security checks on option pages; it's confusing to a site owner. */
					if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || !is_main_site () || is_super_admin () || current_user_can ("create_users"))
						{
							if ((is_multisite () && is_super_admin ()) || current_user_can ("create_users") || ( ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))) && ! ($exists = $wpdb->get_var ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))))
								{
									return apply_filters ("ws_plugin__s2member_check_register_access", ($users_can_register = "1"), get_defined_vars ());
								}
						}
				/**/
				return apply_filters ("ws_plugin__s2member_check_register_access", $users_can_register, get_defined_vars ());
			}
	}
/*
Function for allowing access to the main Multisite Registration Form.
This function has been further optimized to reduce DB queries.
Attach to: add_filter("pre_site_option_registration");
*/
if (!function_exists ("ws_plugin__s2member_check_mms_register_access"))
	{
		function ws_plugin__s2member_check_mms_register_access ($users_can_register = FALSE)
			{
				global $wpdb; /* Global database object reference */
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_check_register_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$by_default = $users_can_register = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_grants"];
				/**/
				if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || !is_main_site ()) /* NOT a Blog Farm. */
					return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "none"), get_defined_vars ());
				/**/
				else if (!is_admin () && $users_can_register !== "all") /* Do NOT run these security checks on option pages; it's confusing to a site owner. */
					{
						if (is_super_admin () || current_user_can ("create_users") || ( ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) && preg_match ("/^" . preg_quote (preg_replace ("/\:([0-9]+)$/", "", $_SERVER["HTTP_HOST"]), "/") . "/i", ($custom = ws_plugin__s2member_decrypt ($_COOKIE["s2member_custom"]))) && preg_match ("/^[1-4](\:|$)([a-z_0-9,]+)?(\:)?([0-9]+ [A-Z])?$/", ($level = ws_plugin__s2member_decrypt ($_COOKIE["s2member_level"]))) && ! ($exists = $wpdb->get_var ("SELECT `user_id` FROM `" . $wpdb->usermeta . "` WHERE `meta_key` = '" . $wpdb->prefix . "s2member_subscr_id' AND `meta_value` = '" . $wpdb->escape ($subscr_id) . "' LIMIT 1"))))
							{
								if (is_super_admin () || current_user_can ("create_users"))
									{
										return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "all"), get_defined_vars ());
									}
								else if ($subscr_id && $custom && $level) /* A paying Customer? Cookies have already been authenticated above. */
									{
										list ($level) = preg_split ("/\:/", $level, 1); /* Parse out the level now. */
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . $level])
											{
												return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "all"), get_defined_vars ());
											}
										else /* Otherwise, we MUST allow them to create an account; they paid for it! */
											{
												return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "user"), get_defined_vars ());
											}
									}
							}
						/* --------------------> $users_can_register !== "all", so exclude Level #0. */
						else if (is_user_logged_in () && current_user_can ("access_s2member_level1") && is_object ($current_user = wp_get_current_user ()))
							{
								$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . ws_plugin__s2member_user_access_level ()];
								$current_user_blogs = (is_array ($blogs = get_blogs_of_user ($current_user->ID))) ? count ($blogs) - 1 : 0;
								$current_user_blogs = ($current_user_blogs >= 0) ? $current_user_blogs : 0;
								$blogs_allowed = ($blogs_allowed >= 0) ? $blogs_allowed : 0;
								/**/
								if ($current_user_blogs < $blogs_allowed) /* Are they within their limit? */
									{
										return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "all"), get_defined_vars ());
									}
							}
					}
				/**/
				else if (!is_admin () && $users_can_register === "all") /* Do NOT run these security checks on option pages; it's confusing to a site owner. */
					{
						if (is_user_logged_in () && is_object ($current_user = wp_get_current_user ()))
							{
								$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . ws_plugin__s2member_user_access_level ()];
								$current_user_blogs = (is_array ($blogs = get_blogs_of_user ($current_user->ID))) ? count ($blogs) - 1 : 0;
								$current_user_blogs = ($current_user_blogs >= 0) ? $current_user_blogs : 0;
								$blogs_allowed = ($blogs_allowed >= 0) ? $blogs_allowed : 0;
								/**/
								if ($current_user_blogs >= $blogs_allowed) /* Are they at their limit? */
									{
										return apply_filters ("ws_plugin__s2member_check_mms_register_access", ($users_can_register = "none"), get_defined_vars ());
									}
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_check_mms_register_access", $users_can_register, get_defined_vars ());
			}
	}
/*
This handles register access in BuddyPress - for Multisite compatibility.
Attach to: add_filter("bp_core_get_site_options");

BuddyPress bypasses the default Filter ( `pre_site_option_registration` )
and instead, it uses: bp_core_get_site_options()
*/
if (!function_exists ("ws_plugin__s2member_check_bp_mms_register_access"))
	{
		function ws_plugin__s2member_check_bp_mms_register_access ($site_options = FALSE)
			{
				if (is_multisite ()) /* Only if Multisite Networking is enabled. Pointless otherwise. */
					$site_options["registration"] = ws_plugin__s2member_check_mms_register_access ($site_options["registration"]);
				/**/
				return apply_filters ("ws_plugin__s2member_check_bp_mms_register_access", $site_options, get_defined_vars ());
			}
	}
/*
Function that describes the General Option overrides for clarity.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_general_ops_notice"))
	{
		function ws_plugin__s2member_general_ops_notice ()
			{
				global $pagenow; /* Need this. */
				/**/
				do_action ("ws_plugin__s2member_before_general_ops_notice", get_defined_vars ());
				/**/
				if (is_admin () && $pagenow === "options-general.php" && !isset ($_GET["page"]) && !is_multisite ()) /* Multisite does NOT provide these options. */
					{
						$notice = "<em>* Note: The s2Member plugin has control over two options on this page.<br /><code>Allow Open Registration = " . esc_html (get_option ("users_can_register")) . "</code>, and <code>Default Role = " . esc_html (get_option ("default_role")) . "</code>.<br />For further details, see: <code>s2Member -> General Options -> Open Registration</code>.";
						/**/
						$js = '<script type="text/javascript">';
						$js .= "jQuery('input#users_can_register, select#default_role').attr('disabled', 'disabled');";
						$js .= '</script>';
						/**/
						do_action ("ws_plugin__s2member_during_general_ops_notice", get_defined_vars ());
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice . $js, $pagenow);
					}
				/**/
				do_action ("ws_plugin__s2member_after_general_ops_notice", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that describes the Multisite Option overrides for clarity.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_multisite_ops_notice"))
	{
		function ws_plugin__s2member_multisite_ops_notice ()
			{
				global $pagenow; /* Need this. */
				/**/
				do_action ("ws_plugin__s2member_before_multisite_ops_notice", get_defined_vars ());
				/**/
				if (is_admin () && $pagenow === "ms-options.php" && !isset ($_GET["page"]) && is_multisite ()) /* Only with Multisite Networking enabled. */
					{
						$notice = "<em>* Note: The s2Member plugin has control over four options on this page.<br /><code>Dashboard Blog = " . esc_html (get_site_option ("dashboard_blog")) . " / Main Site</code>, <code>Default Role = " . esc_html (get_site_option ("default_user_role")) . "</code>, <code>Allow Open Registration = " . esc_html (get_site_option ("registration")) . "</code>, and <code>Add New Users = " . esc_html (get_site_option ("add_new_users")) . "</code>.<br />In your Dashboard ( on the Main Site ), see: <code>s2Member -> Multisite ( Config )</code>.";
						/**/
						$js = '<script type="text/javascript">';
						$js .= "jQuery('input#dashboard_blog, select#default_user_role, input[name=registration], input#add_new_users').attr('disabled', 'disabled');";
						$js .= '</script>';
						/**/
						do_action ("ws_plugin__s2member_during_multisite_ops_notice", get_defined_vars ());
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice . $js, $pagenow);
					}
				/**/
				do_action ("ws_plugin__s2member_after_multisite_ops_notice", get_defined_vars ());
				/**/
				return;
			}
	}
?>