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
	exit("Do not access this file directly.");
/*
Function handles security/access routines.
	~ s2Member's Security Gate.
		Highly optimized.
Attach to: add_action("pre_get_posts");
*/
if (!function_exists ("ws_plugin__s2member_security_gate_query"))
	{
		function ws_plugin__s2member_security_gate_query (&$wp_query = FALSE)
			{
				do_action ("ws_plugin__s2member_before_security_gate_query", get_defined_vars ());
				/**/
				ws_plugin__s2member_query_level_access($wp_query); /* By reference. */
				/**/
				do_action ("ws_plugin__s2member_after_security_gate_query", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function handles security/access routines.
	~ s2Member's Security Gate.
		Highly optimized.
Attach to: add_action("template_redirect");
*/
if (!function_exists ("ws_plugin__s2member_security_gate"))
	{
		function ws_plugin__s2member_security_gate () /* s2Member's Security Gate. */
			{
				do_action ("ws_plugin__s2member_before_security_gate", get_defined_vars ());
				/*
				Category Level Restrictions ( inclusively ).
				- Including URI protections too.
				*/
				if (is_category ()) /* Categories. */
					ws_plugin__s2member_check_catg_level_access ();
				/*
				Tag Level Restrictions ( inclusively ).
				- Including URI protections too.
				*/
				else if (is_tag ()) /* Tags. */
					ws_plugin__s2member_check_ptag_level_access ();
				/*
				Post Level Restrictions ( inclusively, even Custom Post Types ).
				- Including Category, Tag, URI, Capability, and Specifics too.
				*/
				else if (is_single ()) /* Posts & Custom Types. */
					ws_plugin__s2member_check_post_level_access ();
				/*
				Page Level Restrictions ( inclusively ).
				- Including Category, Tag, URI, Capability, and Specifics too.
				*/
				else if (is_page ()) /* Pages. */
					ws_plugin__s2member_check_page_level_access ();
				/*
				Else just apply URI Level Restrictions ( only URIs ).
				*/
				else /* This optimizes things nicely. */
					ws_plugin__s2member_check_ruri_level_access ();
				/*
				Hook after Security Gate.
				*/
				do_action ("ws_plugin__s2member_after_security_gate", get_defined_vars ());
				/**/
				return;
			}
	}
?>