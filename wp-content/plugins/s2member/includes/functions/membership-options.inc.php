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
This forces a redirection to the Membership Options Page for s2Member.
This can be used by 3rd party applications that are not aware of which
Page is currently set as the Membership Options Page.

This is used by s2Member's bbPress Bridge integration.

Attach to: add_action("template_redirect");
Example usage: http://example.com/?s2member_membership_options_page=1
*/
if (!function_exists ("ws_plugin__s2member_membership_options_page"))
	{
		function ws_plugin__s2member_membership_options_page () /* Force a redirection. */
			{
				do_action ("ws_plugin__s2member_before_membership_options_page", get_defined_vars ());
				/**/
				if ($_GET["s2member_membership_options_page"] && !is_page ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"]))
					{
						$query_args = array (); /* Initialize array. */
						foreach ($_GET as $var => $val) /* Include any s2member_ vars. */
							if (preg_match ("/^s2member_/", $var) && $var !== "s2member_membership_options_page")
								$query_args[$var] = $val;
						/**/
						wp_redirect (add_query_arg (urlencode_deep ($query_args), get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])), 301);
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_membership_options_page", get_defined_vars ());
			}
	}
?>