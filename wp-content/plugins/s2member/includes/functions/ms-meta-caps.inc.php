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
Alters `map_meta_cap()` on a Multisite Blog Farm.
Attach to: add_action("map_meta_cap");
*/
if (!function_exists ("ws_plugin__s2member_ms_map_meta_cap"))
	{
		function ws_plugin__s2member_ms_map_meta_cap ($caps = FALSE, $cap = FALSE, $user_id = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ms_map_meta_cap", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_super_admin ())
					{
						if (in_array ($cap, array_keys ($map = array ("edit_user" => "edit_users", "edit_users" => "edit_users"))))
							{
								if (is_object ($user = new WP_User ($user_id)) && $user->allcaps["administrator"])
									$caps = array ($map[$cap]);
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_ms_map_meta_cap", $caps, get_defined_vars ());
			}
	}
/*
Alters this Filter inside `/wp-admin/user-edit.php`.
Attach to: add_filter("enable_edit_any_user_configuration");
*/
if (!function_exists ("ws_plugin__s2member_ms_allow_edits"))
	{
		function ws_plugin__s2member_ms_allow_edits ($allow = FALSE)
			{
				global $user_id; /* Available inside `/wp-admin/user-edit.php`. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ms_allow_edits", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && (is_super_admin () || is_user_member_of_blog ($user_id)))
					{
						$allow = true; /* Yes, allow editing. */
					}
				/**/
				return apply_filters ("ws_plugin__s2member_ms_allow_edits", $allow, get_defined_vars ());
			}
	}
?>