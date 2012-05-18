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
Function that modifies the email From: "Name" <address>.
( these filters are only needed during registration )
*/
if (!function_exists ("ws_plugin__s2member_email_config"))
	{
		function ws_plugin__s2member_email_config ()
			{
				do_action ("ws_plugin__s2member_before_email_config", get_defined_vars ());
				/**/
				ws_plugin__s2member_email_config_release (); /* Release all Filters. */
				/**/
				add_filter ("wp_mail_from", "_ws_plugin__s2member_email_config_email");
				add_filter ("wp_mail_from_name", "_ws_plugin__s2member_email_config_name");
				/**/
				do_action ("ws_plugin__s2member_after_email_config", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
A sort of callback function that applies the email filter.
*/
if (!function_exists ("_ws_plugin__s2member_email_config_email"))
	{
		function _ws_plugin__s2member_email_config_email ($email = FALSE)
			{
				do_action ("_ws_plugin__s2member_before_email_config_email", get_defined_vars ());
				/**/
				return apply_filters ("_ws_plugin__s2member_email_config_email", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"], get_defined_vars ());
			}
	}
/*
A sort of callback function that applies the name filter.
*/
if (!function_exists ("_ws_plugin__s2member_email_config_name"))
	{
		function _ws_plugin__s2member_email_config_name ($name = FALSE)
			{
				do_action ("_ws_plugin__s2member_before_email_config_name", get_defined_vars ());
				/**/
				return apply_filters ("_ws_plugin__s2member_email_config_name", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"], get_defined_vars ());
			}
	}
/*
Checks the status of filters on the email From: "Name" <address>.
*/
if (!function_exists ("ws_plugin__s2member_email_config_status"))
	{
		function ws_plugin__s2member_email_config_status ($any = TRUE)
			{
				do_action ("ws_plugin__s2member_before_email_config_status", get_defined_vars ());
				/**/
				if (has_filter ("wp_mail_from", "_ws_plugin__s2member_email_config_email") || has_filter ("wp_mail_from_name", "_ws_plugin__s2member_email_config_name"))
					return apply_filters ("ws_plugin__s2member_email_config_status", true, get_defined_vars ());
				/**/
				else if ($any && (has_filter ("wp_mail_from") || has_filter ("wp_mail_from_name")))
					return apply_filters ("ws_plugin__s2member_email_config_status", true, get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_email_config_status", false, get_defined_vars ());
			}
	}
/*
Release functions that modify the email From: "Name" <address>.
*/
if (!function_exists ("ws_plugin__s2member_email_config_release"))
	{
		function ws_plugin__s2member_email_config_release ($all = TRUE)
			{
				do_action ("ws_plugin__s2member_before_email_config_release", get_defined_vars ());
				/**/
				remove_filter ("wp_mail_from", "_ws_plugin__s2member_email_config_email");
				remove_filter ("wp_mail_from_name", "_ws_plugin__s2member_email_config_name");
				/**/
				if ($all) /* If $all is true, then we remove all attached WordPress® Filters. */
					remove_all_filters ("wp_mail_from") . remove_all_filters ("wp_mail_from_name");
				/**/
				do_action ("ws_plugin__s2member_after_email_config_release", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Convert primitive Role names in emails sent by WordPress®.
Attach to: add_filter("wpmu_signup_user_notification_email");
	~ Only necessary with this particular email.
*/
if (!function_exists ("ws_plugin__s2member_ms_nice_email_roles"))
	{
		function ws_plugin__s2member_ms_nice_email_roles ($message = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ms_nice_email_roles", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$message = preg_replace ("/ as a (subscriber|s2member_level[1-4])/i", " as a Member", $message);
				/**/
				return apply_filters ("ws_plugin__s2member_ms_nice_email_roles", $message, get_defined_vars ());
			}
	}
?>