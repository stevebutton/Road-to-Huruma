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
Function that handles the Shortcode for:
[s2Get constant="S2MEMBER_CURRENT_USER_DISPLAY_NAME" /]
[s2Get user_field="a_custom_registration_field_id" /]
[s2Get user_option="s2member_subscr_id" /]

Attach to: add_shortcode("s2Get");
*/
if (!function_exists ("ws_plugin__s2member_sc_get_details"))
	{
		function ws_plugin__s2member_sc_get_details ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
			{
				static $current_user; /* Optimizes this routine a bit. */
				$current_user = (!isset ($current_user)) ? wp_get_current_user () : $current_user;
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_sc_get_details", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$attr = ws_plugin__s2member_trim_quot_deep ((array)$attr); /* Force array, and fix &quot;. */
				/**/
				$attr = shortcode_atts (array ("constant" => "", "user_field" => "", "user_option" => ""), $attr);
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_sc_get_details_after_shortcode_atts", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($attr["constant"] && defined ($attr["constant"])) /* Security check here. It must start with S2MEMBER_ on a Blog Farm. */
					{
						if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site () || preg_match ("/^S2MEMBER_/i", $attr["constant"]))
							$get = constant ($attr["constant"]);
					}
				/**/
				else if ($attr["user_field"] && $current_user)
					$get = ws_plugin__s2member_get_user_field ($attr["user_field"]);
				/**/
				else if ($attr["user_option"] && $current_user)
					$get = get_user_option ($attr["user_option"]);
				/**/
				return apply_filters ("ws_plugin__s2member_sc_get_details", $get, get_defined_vars ());
			}
	}
?>