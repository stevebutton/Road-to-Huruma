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
Append a note onto a specific User/Member's account.
*/
if (!function_exists ("ws_plugin__s2member_append_user_notes"))
	{
		function ws_plugin__s2member_append_user_notes ($user_id = FALSE, $notes = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_append_user_notes", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($user_id && $notes && is_string ($notes)) /* Must have these. */
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_append_user_notes", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$notes = trim (get_user_option ("s2member_notes", $user_id) . "\n" . $notes);
						/**/
						update_user_option ($user_id, "s2member_notes", $notes);
					}
				/**/
				return apply_filters ("ws_plugin__s2member_append_user_notes", $notes, get_defined_vars ());
			}
	}
/*
Clear specific notes from a User/Member's account; based on line-by-line regex.
*/
if (!function_exists ("ws_plugin__s2member_clear_user_note_lines"))
	{
		function ws_plugin__s2member_clear_user_note_lines ($user_id = FALSE, $regex = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_clear_user_note_lines", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($user_id && $regex && is_string ($regex) && ($lines = array ()))
					{
						/* Careful here to preserve empty lines. */
						$notes = trim (get_user_option ("s2member_notes", $user_id));
						foreach (preg_split ("/\n/", $notes) as $line)
							if (!preg_match ($regex, $line))
								$lines[] = $line;
						/**/
						$notes = trim (implode ("\n", $lines));
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_clear_user_note_lines", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						update_user_option ($user_id, "s2member_notes", $notes);
					}
				/**/
				return apply_filters ("ws_plugin__s2member_clear_user_note_lines", $notes, get_defined_vars ());
			}
	}
?>