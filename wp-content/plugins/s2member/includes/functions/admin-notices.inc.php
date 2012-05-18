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
Function displays an admin notice immediately.
*/
if (!function_exists ("ws_plugin__s2member_display_admin_notice"))
	{
		function ws_plugin__s2member_display_admin_notice ($notice = FALSE, $error = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_display_admin_notice", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($notice && $error) /* Special format for errors. */
					{
						echo '<div class="error fade"><p>' . $notice . '</p></div>';
					}
				else if ($notice) /* Otherwise, we just send it as an update notice. */
					{
						echo '<div class="updated fade"><p>' . $notice . '</p></div>';
					}
				/**/
				do_action ("ws_plugin__s2member_after_display_admin_notice", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that enqueues admin notices.
*/
if (!function_exists ("ws_plugin__s2member_enqueue_admin_notice"))
	{
		function ws_plugin__s2member_enqueue_admin_notice ($notice = FALSE, $on_pages = FALSE, $error = FALSE, $time = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_enqueue_admin_notice", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($notice && is_string ($notice)) /* If we have a valid string. */
					{
						$notices = (array)get_option ("ws_plugin__s2member_notices");
						/**/
						array_push ($notices, array ("notice" => $notice, "on_pages" => $on_pages, "error" => $error, "time" => $time));
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_enqueue_admin_notice", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						update_option ("ws_plugin__s2member_notices", ws_plugin__s2member_array_unique ($notices));
					}
				/**/
				do_action ("ws_plugin__s2member_after_enqueue_admin_notice", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function that displays admin notices.
Attach to: add_action("admin_notices");
*/
if (!function_exists ("ws_plugin__s2member_admin_notices"))
	{
		function ws_plugin__s2member_admin_notices ()
			{
				global $pagenow; /* This holds the current page filename. */
				/**/
				do_action ("ws_plugin__s2member_before_admin_notices", get_defined_vars ());
				/**/
				if (is_array ($notices = get_option ("ws_plugin__s2member_notices")) && !empty ($notices))
					{
						foreach ($notices as $key => $notice) /* Check time on each notice. */
							{
								if (empty ($notice["on_pages"]) || $pagenow === $notice["on_pages"] || in_array ($pagenow, (array)$notice["on_pages"]) || $_GET["page"] === $notice["on_pages"] || in_array ($_GET["page"], (array)$notice["on_pages"]))
									{
										if (strtotime ("now") >= $notice["time"]) /* Time to show it? */
											{
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_admin_notices_before_display", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												unset ($notices[$key]); /* Clear this notice & display it. */
												/**/
												ws_plugin__s2member_display_admin_notice ($notice["notice"], $notice["error"]);
												/**/
												do_action ("ws_plugin__s2member_during_admin_notices_after_display", get_defined_vars ());
											}
									}
							}
						/**/
						$notices = array_merge ($notices); /* Re-index. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_admin_notices", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						update_option ("ws_plugin__s2member_notices", $notices);
					}
				/**/
				do_action ("ws_plugin__s2member_after_admin_notices", get_defined_vars ());
				/**/
				return;
			}
	}
?>