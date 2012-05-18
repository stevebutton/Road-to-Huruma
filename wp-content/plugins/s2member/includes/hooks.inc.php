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
Add the plugin actions/filters here.
*/
add_action ("pre_get_posts", /* WP Query. */
"ws_plugin__s2member_security_gate_query", 20);
/* Priority matches `/api-functions.inc.php`.
/**/
add_action ("init", "ws_plugin__s2member_nocache");
add_action ("init", "ws_plugin__s2member_constants");
add_action ("init", "ws_plugin__s2member_register");
add_action ("init", "ws_plugin__s2member_css");
add_action ("init", "ws_plugin__s2member_js_w_globals");
add_action ("init", "ws_plugin__s2member_menu_pages_js");
add_action ("init", "ws_plugin__s2member_menu_pages_css");
add_action ("init", "ws_plugin__s2member_paypal_return");
add_action ("init", "ws_plugin__s2member_paypal_notify");
add_action ("init", "ws_plugin__s2member_check_file_download_access");
add_action ("init", "ws_plugin__s2member_handle_profile_modifications");
add_action ("init", "ws_plugin__s2member_delete_signup_tracking_cookie");
add_action ("init", "ws_plugin__s2member_delete_sp_tracking_cookie");
add_action ("init", "ws_plugin__s2member_auto_eot_system_via_cron");
/**/
add_action ("template_redirect", "ws_plugin__s2member_check_force_ssl", 1);
add_action ("template_redirect", "ws_plugin__s2member_security_gate", 1);
add_action ("template_redirect", "ws_plugin__s2member_membership_options_page");
add_action ("template_redirect", "ws_plugin__s2member_profile");
/**/
add_filter ("widget_text", "do_shortcode"); /* Shortcodes in widgets. */
/**/
add_action ("wp_print_styles", "ws_plugin__s2member_add_css");
add_action ("wp_print_scripts", "ws_plugin__s2member_add_js_w_globals");
add_filter ("gettext", "ws_plugin__s2member_translation_mangler", 10, 3);
/**/
add_action ("delete_user", "ws_plugin__s2member_handle_user_deletions");
add_action ("wpmu_delete_user", "ws_plugin__s2member_handle_ms_user_deletions");
add_action ("remove_user_from_blog", "ws_plugin__s2member_handle_ms_user_deletions", 10, 2);
/**/
add_filter ("enable_edit_any_user_configuration", "ws_plugin__s2member_ms_allow_edits");
add_filter ("map_meta_cap", "ws_plugin__s2member_ms_map_meta_cap", 10, 3);
/**/
add_filter ("pre_option_default_role", "ws_plugin__s2member_force_default_role");
add_filter ("pre_site_option_default_user_role", "ws_plugin__s2member_force_mms_default_role");
add_filter ("pre_site_option_add_new_users", "ws_plugin__s2member_mms_allow_new_users");
add_filter ("pre_site_option_dashboard_blog", "ws_plugin__s2member_mms_dashboard_blog");
add_filter ("pre_option_users_can_register", "ws_plugin__s2member_check_register_access");
add_filter ("pre_site_option_registration", "ws_plugin__s2member_check_mms_register_access");
add_filter ("bp_core_get_site_options", "ws_plugin__s2member_check_bp_mms_register_access");
/**/
add_action ("user_register", "ws_plugin__s2member_configure_user_registration");
add_action ("register_form", "ws_plugin__s2member_custom_registration_fields");
add_action ("bp_before_registration_submit_buttons", "ws_plugin__s2member_opt_in_4bp");
/**/
add_filter ("add_signup_meta", "ws_plugin__s2member_ms_process_signup_meta");
add_filter ("bp_signup_usermeta", "ws_plugin__s2member_ms_process_signup_meta");
add_action ("signup_hidden_fields", "ws_plugin__s2member_ms_process_signup_hidden_fields");
add_filter ("wpmu_signup_user_notification_email", "ws_plugin__s2member_ms_nice_email_roles", 11);
add_action ("wpmu_activate_user", "ws_plugin__s2member_configure_user_on_ms_user_activation", 10, 3);
add_action ("wpmu_activate_blog", "ws_plugin__s2member_configure_user_on_ms_blog_activation", 10, 5);
add_action ("signup_extra_fields", "ws_plugin__s2member_ms_custom_registration_fields");
/**/
add_action ("wp_login", "ws_plugin__s2member_login_redirect");
add_action ("login_head", "ws_plugin__s2member_login_header_styles");
add_filter ("login_headerurl", "ws_plugin__s2member_login_header_url");
add_filter ("login_headertitle", "ws_plugin__s2member_login_header_title");
add_action ("login_form_register", "ws_plugin__s2member_display_signup_tracking_codes");
add_action ("login_form_login", "ws_plugin__s2member_display_signup_tracking_codes");
add_action ("wp_footer", "ws_plugin__s2member_display_signup_tracking_codes");
add_action ("wp_footer", "ws_plugin__s2member_display_sp_tracking_codes");
/**/
add_action ("admin_init", "ws_plugin__s2member_admin_lockout");
add_action ("admin_init", "ws_plugin__s2member_check_activation");
add_action ("admin_init", "ws_plugin__s2member_general_ops_notice");
add_action ("admin_init", "ws_plugin__s2member_multisite_ops_notice");
add_action ("admin_init", "ws_plugin__s2member_admin_user_new_fields");
add_action ("admin_notices", "ws_plugin__s2member_admin_notices");
add_action ("admin_menu", "ws_plugin__s2member_add_meta_boxes");
add_action ("save_post", "ws_plugin__s2member_save_meta_boxes");
add_action ("admin_menu", "ws_plugin__s2member_add_admin_options");
add_action ("admin_print_scripts", "ws_plugin__s2member_add_admin_scripts");
add_action ("admin_print_styles", "ws_plugin__s2member_add_admin_styles");
/**/
add_action ("pre_user_search", "ws_plugin__s2member_users_list_search");
add_filter ("manage_users_columns", "ws_plugin__s2member_users_list_cols");
add_filter ("manage_users_custom_column", "ws_plugin__s2member_users_list_display_cols", 10, 3);
add_action ("edit_user_profile", "ws_plugin__s2member_users_list_edit_cols");
add_action ("show_user_profile", "ws_plugin__s2member_users_list_edit_cols");
add_action ("edit_user_profile_update", "ws_plugin__s2member_users_list_update_cols");
add_action ("personal_options_update", "ws_plugin__s2member_users_list_update_cols");
add_action ("set_user_role", "ws_plugin__s2member_synchronize_paid_reg_times", 10, 2);
add_filter ("show_password_fields", "ws_plugin__s2member_demo_hide_password_fields", 10, 2);
/**/
add_filter ("cron_schedules", "ws_plugin__s2member_extend_cron_schedules");
add_action ("ws_plugin__s2member_auto_eot_system__schedule", "ws_plugin__s2member_auto_eot_system");
/**/
add_action ("wp_ajax_ws_plugin__s2member_sp_access_link_via_ajax", "ws_plugin__s2member_sp_access_link_via_ajax");
add_action ("wp_ajax_ws_plugin__s2member_reset_ip_restrictions_via_ajax", "ws_plugin__s2member_reset_ip_restrictions_via_ajax");
/*
Register the activation | de-activation routines.
*/
register_activation_hook ($GLOBALS["WS_PLUGIN__"]["s2member"]["l"], "ws_plugin__s2member_activate");
register_deactivation_hook ($GLOBALS["WS_PLUGIN__"]["s2member"]["l"], "ws_plugin__s2member_deactivate");
?>