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
Function for handling admin lockouts.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_admin_lockout"))
	{
		function ws_plugin__s2member_admin_lockout () /* Prevents admin access. */
			{
				do_action ("ws_plugin__s2member_before_admin_lockouts", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["force_admin_lockouts"] && (!defined ("DOING_AJAX") || !DOING_AJAX) && !current_user_can ("edit_posts"))
					if (apply_filters ("ws_plugin__s2member_admin_lockout", true, get_defined_vars ())) /* Give Filters a chance. */
						{
							if ($special_redirection_url = ws_plugin__s2member_login_redirection_url ())
								wp_redirect($special_redirection_url); /* Special Redirection. */
							/**/
							else /* Else we use the Login Welcome Page configured for s2Member. */
								wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
							/**/
							exit (); /* Clean exit. */
						}
				/**/
				do_action ("ws_plugin__s2member_after_admin_lockouts", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
?>