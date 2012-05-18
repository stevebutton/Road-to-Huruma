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
Function for determing the Access Level of a User/Member.

If $user is NOT passed in, check the current User/Member.
Returns -1 thru 4, according to the User/Member's Access Level.
	Negative (-1) if a User/Member is NOT logged in.

If $user IS passed in, this function will check a specific $user.
Returns -1 thru 4, according to the User/Member's Access Level.
	Negative (-1) if $user is passed in, but NOT an object.
*/
if (!function_exists ("ws_plugin__s2member_user_access_level"))
	{
		function ws_plugin__s2member_user_access_level ($user = FALSE)
			{
				$user = (func_num_args () && is_object ($user)) ? $user : false;
				/**/
				if ((func_num_args () && !$user) || (!$user && ! ( (is_user_logged_in ()) ? wp_get_current_user () : false)))
					{
						return apply_filters ("ws_plugin__s2member_user_access_level", -1, get_defined_vars ());
					/* Return of -1, means $user was passed in but is NOT an object; or nobody is logged in. */
					}
				else if (($user && $user->has_cap ("access_s2member_level4")) || (!$user && current_user_can ("access_s2member_level4")))
					{
						return apply_filters ("ws_plugin__s2member_user_access_level", 4, get_defined_vars ());
					/* The $user has; or a Member is logged in with Level 4 Access. */
					}
				else if (($user && $user->has_cap ("access_s2member_level3")) || (!$user && current_user_can ("access_s2member_level3")))
					{
						return apply_filters ("ws_plugin__s2member_user_access_level", 3, get_defined_vars ());
					/* The $user has; or a Member is logged in with Level 3 Access. */
					}
				else if (($user && $user->has_cap ("access_s2member_level2")) || (!$user && current_user_can ("access_s2member_level2")))
					{
						return apply_filters ("ws_plugin__s2member_user_access_level", 2, get_defined_vars ());
					/* The $user has; or a Member is logged in with Level 2 Access. */
					}
				else if (($user && $user->has_cap ("access_s2member_level1")) || (!$user && current_user_can ("access_s2member_level1")))
					{
						return apply_filters ("ws_plugin__s2member_user_access_level", 1, get_defined_vars ());
					/* The $user has; or a Member is logged in with Level 1 Access. */
					}
				else if (($user && $user->has_cap ("access_s2member_level0")) || (!$user && current_user_can ("access_s2member_level0")))
					{
						return apply_filters ("ws_plugin__s2member_user_access_level", 0, get_defined_vars ());
					/* The $user has; or a Free Subscriber is logged in with Level 0 Access. */
					}
				else /* Else we assume this is a User ( a Free Subscriber with a level of 0. ). */
					return apply_filters ("ws_plugin__s2member_user_access_level", 0, get_defined_vars ());
			}
	}
?>