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
Pluggable function that handles password generation.
Taken from: /wp-includes/pluggable.php
*/
if (!function_exists ("wp_generate_password"))
	{
		if (!function_exists ("ws_plugin__s2member_generate_password"))
			{
				function wp_generate_password ($length = 12, $special_chars = TRUE)
					{
						return ws_plugin__s2member_generate_password ($length, $special_chars);
					}
				/**/
				function ws_plugin__s2member_generate_password ($length = 12, $special_chars = TRUE)
					{
						$password = ws_plugin__s2member_random_str_gen ($length, $special_chars);
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_generate_password", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
							if ($custom = trim (stripslashes ($_POST["ws_plugin__s2member_custom_reg_field_user_pass"])))
								{
									$password = $custom; /* Use custom password. */
								}
						/**/
						return ($GLOBALS["ws_plugin__s2member_generate_password_return"] = $password);
					}
			}
	}
?>