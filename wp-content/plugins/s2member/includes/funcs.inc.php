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
Include all of the functions that came with this plugin.
*/
if (is_dir (dirname (__FILE__) . "/functions"))
	if ($ws_plugin__s2member_temp_r = opendir (dirname (__FILE__) . "/functions"))
		while (($ws_plugin__s2member_temp_s = readdir ($ws_plugin__s2member_temp_r)) !== false)
			if (preg_match ("/\.php$/", $ws_plugin__s2member_temp_s) && !preg_match ("/^index\.php$/i", $ws_plugin__s2member_temp_s))
				include_once dirname (__FILE__) . "/functions/" . $ws_plugin__s2member_temp_s;
?>