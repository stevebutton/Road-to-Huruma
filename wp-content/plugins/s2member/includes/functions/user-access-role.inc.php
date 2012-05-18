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
Function for determing the Access Role of a User/Member.
If $user is NOT passed in, check the current User/Member.
If $user IS passed in, this function will check a specific $user.
*/
if (!function_exists ("ws_plugin__s2member_user_access_role"))
	{
		function ws_plugin__s2member_user_access_role ($user = FALSE)
			{
				$user = (func_num_args () && is_object ($user)) ? $user : false;
				/**/
				if ((func_num_args () && !$user) || (!$user && (! ($user = (is_user_logged_in ()) ? wp_get_current_user () : false) || !$user->roles[0])))
					{
						return apply_filters ("ws_plugin__s2member_user_access_role", "", get_defined_vars ());
					/* Return of "", means $user was passed in but is NOT an object; or nobody is logged in, or they have to Role. */
					}
				else /* Else we return the first role in their array of assigned WordPress Roles. */
					return apply_filters ("ws_plugin__s2member_user_access_role", $user->roles[0], get_defined_vars ());
			}
	}
?>