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
Extends the WP-Cron schedules to support 10 minute intervals.
Attach to: add_filter("cron_schedules");
*/
if (!function_exists ("ws_plugin__s2member_extend_cron_schedules"))
	{
		function ws_plugin__s2member_extend_cron_schedules ($schedules = array ())
			{
				eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_extend_cron_schedules", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$array = array ("every10m" => array ("interval" => 600, "display" => "Every 10 Minutes"));
				/**/
				return apply_filters ("ws_plugin__s2member_extend_cron_schedules", array_merge ($array, $schedules), get_defined_vars ());
			}
	}
?>