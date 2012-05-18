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
Function hides password fields for demo users.

Demo accounts ( where the Username MUST be "demo" ), will NOT be allowed to change their password.
Any other restrictions you need to impose must be done through custom programming, using s2Member's Conditionals.
See `s2Member -> API Scripting`.

Attach to: add_filter("show_password_fields");
*/
if (!function_exists ("ws_plugin__s2member_demo_hide_password_fields"))
	{
		function ws_plugin__s2member_demo_hide_password_fields ($show = TRUE, $profileuser = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_demo_hide_password_fields", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($profileuser->user_login === "demo")
					return ($show = false);
				/**/
				return $show;
			}
	}
?>