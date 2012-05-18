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
Handles no-cache headers and compatible constants for s2Member.
This is compatible with Quick Cache and also with WP Super Cache.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_nocache"))
	{
		function ws_plugin__s2member_nocache ()
			{
				do_action ("ws_plugin__s2member_before_nocache", get_defined_vars ());
				/**/
				ws_plugin__s2member_nocache_constants () . ws_plugin__s2member_nocache_headers ();
				/**/
				do_action ("ws_plugin__s2member_after_nocache", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Define compatible nocache constants for s2Member.
This is compatible with Quick Cache and also with WP Super Cache.
Quick Cache uses: QUICK_CACHE_ALLOWED, and Super Cache uses: DONOTCACHEPAGE.
Actually, Quick Cache is compatible with either of these defined constants.

Always disallow caching for logged in users and GET requests with /?s2member systematic use.
For clarity on the systematic use with s2member in the request, see: is-systematic.inc.php.
- Also disallow caching if the $nocache param is passed in as true by other routines.
* BUT, always obey the qcAC param that specifically allows caching.

This function is also called upon by other routines that protect members-only content areas.
Members-only content areas should never be cached. In other words, there are some important supplemental
routines that occur outside the scope of this single function. This function is called upon by those other
targeted routines, to handle the nocache constants when they are required.

These additional supplemental routines, include:
- ws_plugin__s2member_check_ruri_level_access()
- ws_plugin__s2member_check_catg_level_access()
- ws_plugin__s2member_check_ptag_level_access()
- ws_plugin__s2member_check_post_level_access()
- ws_plugin__s2member_check_page_level_access()
- ws_plugin__s2member_ip_restrictions_ok()
- ws_plugin__s2member_file_download_key()
- Button/Shortcode Generators also call this.
*/
if (!function_exists ("ws_plugin__s2member_nocache_constants"))
	{
		function ws_plugin__s2member_nocache_constants ($nocache = FALSE)
			{
				static $once; /* We only need to set these Constants once. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_nocache_constants", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (!$once && !$_GET["qcAC"] && ($nocache || is_user_logged_in () || (preg_match ("/^s2member/", $_SERVER["QUERY_STRING"]) && (parse_url ($_SERVER["REQUEST_URI"], PHP_URL_PATH) === "/" || parse_url (rtrim ($_SERVER["REQUEST_URI"], "/"), PHP_URL_PATH) === parse_url (rtrim (get_bloginfo ("wpurl"), "/"), PHP_URL_PATH)))))
					{
						define ("QUICK_CACHE_ALLOWED", false) . define ("DONOTCACHEPAGE", true);
						/**/
						$once = true; /* Only need to set these Constants one time. */
						/**/
						do_action ("ws_plugin__s2member_during_nocache_constants", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_nocache_constants", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Sends Cache-Control ( no-cache ) headers.
This uses the nocache_headers() function provided by WordPress®.
This is compatible with the Quick Cache parameter ?qcABC=1 as well.
* Always obey the qcABC param that specifically allows browser caching.
*/
if (!function_exists ("ws_plugin__s2member_nocache_headers"))
	{
		function ws_plugin__s2member_nocache_headers () /* Cache-Control header. */
			{
				static $once; /* We only need to set these headers one time. */
				/**/
				do_action ("ws_plugin__s2member_before_nocache_headers", get_defined_vars ());
				/**/
				if (!$once && !$_GET["qcABC"]) /* Obey Quick Cache. */
					{
						if (is_array ($headers = headers_list ()))
							foreach ($headers as $k => $header)
								if (preg_match ("/no-cache/i", $header))
									$no_cache_already_sent = true;
						/**/
						if (!$no_cache_already_sent)
							nocache_headers ();
						/**/
						$once = true; /* Only need to set these headers once. */
						/**/
						do_action ("ws_plugin__s2member_during_nocache_headers", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_nocache_headers", get_defined_vars ());
				/**/
				return;
			}
	}
?>