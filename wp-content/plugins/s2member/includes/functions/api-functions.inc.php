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
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `is_user_logged_in()` already exists in WordPress® core.
*/
if (!function_exists ("is_user_not_logged_in"))
	{
		function is_user_not_logged_in ()
			{
				return (!is_user_logged_in ());
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can()` already exists in WordPress® core.

$role - required argument.
*/
if (!function_exists ("current_user_is"))
	{
		function current_user_is ($role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return current_user_can (preg_replace ("/^access_/i", "", $role));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can()` already exists in WordPress® core.

$role - required argument.
*/
if (!function_exists ("current_user_is_not"))
	{
		function current_user_is_not ($role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return (!current_user_can (preg_replace ("/^access_/i", "", $role)));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can_for_blog()` already exists in WordPress® core.

$blog_id - required argument.
$role - required argument.
*/
if (!function_exists ("current_user_is_for_blog"))
	{
		function current_user_is_for_blog ($blog_id = FALSE, $role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return current_user_can_for_blog ($blog_id, preg_replace ("/^access_/i", "", $role));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can_for_blog()` already exists in WordPress® core.

$blog_id - required argument.
$role - required argument.
*/
if (!function_exists ("current_user_is_not_for_blog"))
	{
		function current_user_is_not_for_blog ($blog_id = FALSE, $role = FALSE)
			{
				$role = ($role === "s2member_level0") ? "subscriber" : $role;
				return (!current_user_can_for_blog ($blog_id, preg_replace ("/^access_/i", "", $role)));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can()` already exists in WordPress® core.

$capability - required argument.
*/
if (!function_exists ("current_user_cannot"))
	{
		function current_user_cannot ($capability = FALSE)
			{
				return (!current_user_can ($capability));
			}
	}
/*
API function for Conditionals.
This matches up with a Simple Conditional made available through a Shortcode.
Function `current_user_can_for_blog()` already exists in WordPress® core.

$blog_id - required argument.
$capability - required argument.
*/
if (!function_exists ("current_user_cannot_for_blog"))
	{
		function current_user_cannot_for_blog ($blog_id = FALSE, $capability = FALSE)
			{
				return (!current_user_can_for_blog ($blog_id, $capability));
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is a specific [Category, Tag, Post, Page, or URI] protected by s2Member?

$__id - optional argument. Defaults to current $post->ID in The Loop.
$__type - optional argument. One of: `category`, `tag`, `post`, `page`, `singular`, `uri`. Defaults to: `singular`.
$check_user - optional ( consider the current User? ) defaults to: false.
*/
if (!function_exists ("is_protected_by_s2member"))
	{
		function is_protected_by_s2member ($__id = FALSE, $__type = FALSE, $check_user = FALSE)
			{
				global $post; /* Global reference to $post in The Loop. */
				/**/
				$__id = ($__id) ? $__id : ( (is_object ($post)) ? $post->ID : false);
				$__type = ($__type) ? strtolower ($__type) : "singular";
				/**/
				if ($__type === "category" && ($array = ws_plugin__s2member_check_specific_catg_level_access ($__id, $check_user)))
					return $array; /* A non-empty array with ["s2member_level_req"]. */
				/**/
				else if ($__type === "tag" && ($array = ws_plugin__s2member_check_specific_ptag_level_access ($__id, $check_user)))
					return $array; /* A non-empty array with ["s2member_level_req"]. */
				/**/
				else if (($__type === "post" || $__type === "singular") && ($array = ws_plugin__s2member_check_specific_post_level_access ($__id, $check_user)))
					return $array; /* A non-empty array with ["s2member_(level|sp|ccap)_req"]. */
				/**/
				else if (($__type === "page" || $__type === "singular") && ($array = ws_plugin__s2member_check_specific_page_level_access ($__id, $check_user)))
					return $array; /* A non-empty array with ["s2member_(level|sp|ccap)_req"]. */
				/**/
				else if ($__type === "uri" && ($array = ws_plugin__s2member_check_specific_ruri_level_access ($__id, $check_user)))
					return $array; /* A non-empty array with ["s2member_level_req"]. */
				/**/
				return false;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is the current User permitted to access this  [Category, Tag, Post, Page, or URI]?

$__id - optional argument. Defaults to current $post->ID in The Loop.
$__type - optional argument. One of: `category`, `tag`, `post`, `page`, `singular`, `uri`. Defaults to: `singular`.
*/
if (!function_exists ("is_permitted_by_s2member"))
	{
		function is_permitted_by_s2member ($__id = FALSE, $__type = FALSE)
			{
				global $post; /* Global reference to $post in The Loop. */
				/**/
				$__id = ($__id) ? $__id : ( (is_object ($post)) ? $post->ID : false);
				$__type = ($__type) ? strtolower ($__type) : "singular";
				/**/
				if ($__type === "category" && ws_plugin__s2member_check_specific_catg_level_access ($__id, true))
					return false;
				/**/
				else if ($__type === "tag" && ws_plugin__s2member_check_specific_ptag_level_access ($__id, true))
					return false;
				/**/
				else if (($__type === "post" || $__type === "singular") && ws_plugin__s2member_check_specific_post_level_access ($__id, true))
					return false;
				/**/
				else if (($__type === "page" || $__type === "singular") && ws_plugin__s2member_check_specific_page_level_access ($__id, true))
					return false;
				/**/
				else if ($__type === "uri" && ws_plugin__s2member_check_specific_ruri_level_access ($__id, true))
					return false;
				/**/
				return true;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is a specific Category protected by s2Member?

$cat_id - required argument.
$check_user - optional ( consider the current User? ) defaults to: false.
*/
if (!function_exists ("is_category_protected_by_s2member"))
	{
		function is_category_protected_by_s2member ($cat_id = FALSE, $check_user = FALSE)
			{
				if ($cat_id && ($array = ws_plugin__s2member_check_specific_catg_level_access ($cat_id, $check_user)))
					return $array; /* A non-empty array with ["s2member_level_req"]. */
				/**/
				return false;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is the current User permitted to access this Category?

$cat_id - required argument.
*/
if (!function_exists ("is_category_permitted_by_s2member"))
	{
		function is_category_permitted_by_s2member ($cat_id = FALSE)
			{
				if ($cat_id && ws_plugin__s2member_check_specific_catg_level_access ($cat_id, true))
					return false;
				/**/
				return true;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is a specific Tag protected by s2Member?

$tag_id_slug_or_name - required argument.
$check_user - optional ( consider the current User? ) defaults to: false.
*/
if (!function_exists ("is_tag_protected_by_s2member"))
	{
		function is_tag_protected_by_s2member ($tag_id_slug_or_name = FALSE, $check_user = FALSE)
			{
				if ($tag_id_slug_or_name && ($array = ws_plugin__s2member_check_specific_ptag_level_access ($tag_id_slug_or_name, $check_user)))
					return $array; /* A non-empty array with ["s2member_level_req"]. */
				/**/
				return false;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is the current User permitted to access this Tag?

$tag_id_slug_or_name - required argument.
*/
if (!function_exists ("is_tag_permitted_by_s2member"))
	{
		function is_tag_permitted_by_s2member ($tag_id_slug_or_name = FALSE)
			{
				if ($tag_id_slug_or_name && ws_plugin__s2member_check_specific_ptag_level_access ($tag_id_slug_or_name, true))
					return false;
				/**/
				return true;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is a specific Post protected by s2Member?

$post_id - required argument.
$check_user - optional ( consider the current User? ) defaults to: false.
*/
if (!function_exists ("is_post_protected_by_s2member"))
	{
		function is_post_protected_by_s2member ($post_id = FALSE, $check_user = FALSE)
			{
				if ($post_id && ($array = ws_plugin__s2member_check_specific_post_level_access ($post_id, $check_user)))
					return $array; /* A non-empty array with ["s2member_(level|sp|ccap)_req"]. */
				/**/
				return false;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is the current User permitted to access this Post?

$post_id - required argument.
*/
if (!function_exists ("is_post_permitted_by_s2member"))
	{
		function is_post_permitted_by_s2member ($post_id = FALSE)
			{
				if ($post_id && ws_plugin__s2member_check_specific_post_level_access ($post_id, true))
					return false;
				/**/
				return true;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is a specific Page protected by s2Member?

$page_id - required argument.
$check_user - optional ( consider the current User? ) defaults to: false.
*/
if (!function_exists ("is_page_protected_by_s2member"))
	{
		function is_page_protected_by_s2member ($page_id = FALSE, $check_user = FALSE)
			{
				if ($page_id && ($array = ws_plugin__s2member_check_specific_page_level_access ($page_id, $check_user)))
					return $array; /* A non-empty array with ["s2member_(level|sp|ccap)_req"]. */
				/**/
				return false;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is the current User permitted to access this Page?

$page_id - required argument.
*/
if (!function_exists ("is_page_permitted_by_s2member"))
	{
		function is_page_permitted_by_s2member ($page_id = FALSE)
			{
				if ($page_id && ws_plugin__s2member_check_specific_page_level_access ($page_id, true))
					return false;
				/**/
				return true;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is a specific URI/URL protected by s2Member?

NOTE: This will ONLY check s2Member's URI Level Access restrictions.
	- So unlike s2Member's other Query Conditionals,
		this will NOT check everything.

Use of this function is usually NOT required, because all of these
other Conditionals already check URI restrictions inclusively:
	- is_category_protected_by_s2member($cat_id);
	- is_tag_protected_by_s2member($tag_id [ or slug ]);
	- is_post_protected_by_s2member($post_id);
	- is_page_protected_by_s2member($page_id);

$uri_or_full_url - required argument.
$check_user - optional ( consider the current User? ) defaults to: false.
*/
if (!function_exists ("is_uri_protected_by_s2member"))
	{
		function is_uri_protected_by_s2member ($uri_or_full_url = FALSE, $check_user = FALSE)
			{
				if ($uri_or_full_url && ($array = ws_plugin__s2member_check_specific_ruri_level_access ($uri_or_full_url, $check_user)))
					return $array; /* A non-empty array with ["s2member_level_req"]. */
				/**/
				return false;
			}
	}
/*
API function for Conditionals.
Allows developers to integrate s2Member ( via Themes ).
Is the current URI/URL permitted to access this Page?

NOTE: This will ONLY check s2Member's URI Level Access restrictions.
	- So unlike s2Member's other Query Conditionals,
		this will NOT check everything.

Use of this function is usually NOT required, because all of these
other Conditionals already check URI restrictions inclusively:
	- is_category_permitted_by_s2member($cat_id);
	- is_tag_permitted_by_s2member($tag_id [ or slug ]);
	- is_post_permitted_by_s2member($post_id);
	- is_page_permitted_by_s2member($page_id);

$uri_or_full_url - required argument.
*/
if (!function_exists ("is_uri_permitted_by_s2member"))
	{
		function is_uri_permitted_by_s2member ($uri_or_full_url = FALSE)
			{
				if ($uri_or_full_url && ws_plugin__s2member_check_specific_ruri_level_access ($uri_or_full_url, true))
					return false;
				/**/
				return true;
			}
	}
/*
API function for custom queries.
Allows developers to integrate s2Member ( via Themes ).
Attaches s2Member's query filters; hiding protected content.
Don't forget to call: `detach_s2member_query_filters()`.
*/
if (!function_exists ("attach_s2member_query_filters"))
	{
		function attach_s2member_query_filters ()
			{
				remove_action ("pre_get_posts", "ws_plugin__s2member_security_gate_query", 20);
				add_action ("pre_get_posts", "ws_plugin__s2member_force_query_level_access", 20);
			}
	}
/*
API function for custom queries.
Allows developers to integrate s2Member ( via Themes ).
Detaches filters applied by: `attach_s2member_query_filters()`.
*/
if (!function_exists ("detach_s2member_query_filters"))
	{
		function detach_s2member_query_filters ()
			{
				remove_action ("pre_get_posts", "ws_plugin__s2member_force_query_level_access", 20);
				add_action ("pre_get_posts", "ws_plugin__s2member_security_gate_query", 20);
			}
	}
/*
Alias function for API Scripting usage.
Function creates a special File Download Key.
Uses: date("Y-m-d") . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $file.

The optional second argument can be passed in for compatiblity with Quick Cache / WP Super Cache.
When $cache_compatible is passed in, the salt is reduced to only the $file value.
	- which is NOT as secure. So use that with caution.

$file - required argument.
*/
if (!function_exists ("s2member_file_download_key"))
	{
		function s2member_file_download_key ($file = FALSE, $cache_compatible = FALSE)
			{
				return ws_plugin__s2member_file_download_key ($file, $cache_compatible);
			}
	}
/*
Retrieves a Registration Time.
$user_id defaults to the current user; if logged in.
*/
if (!function_exists ("s2member_registration_time"))
	{
		function s2member_registration_time ($user_id = FALSE)
			{
				return ws_plugin__s2member_registration_time ($user_id);
			}
	}
/*
Retrieves a Paid Registration Time.

The $level argument is optional. It defaults to the first/initial Paid Registration Time, regardless of Level#.
Or you could do this: s2member_paid_registration_time("level1"); which will give you the Registration Time at Level #1.
If a User/Member has never paid for Level #1 ( i.e. they signed up at Level#2 ), the function will return 0.

Here are some other examples:
$time = s2member_registration_time (); // ... first registration time ( free or otherwise ).
$time = s2member_paid_registration_time (); // ... first "paid" registration and/or upgrade time.
$time = s2member_paid_registration_time ("level1"); // ... first "paid" registration or upgrade time at Level#1.
$time = s2member_paid_registration_time ("level2"); // ... first "paid" registration or upgrade time at Level#2.
$time = s2member_paid_registration_time ("level3"); // ... first "paid" registration or upgrade time at Level#3.
$time = s2member_paid_registration_time ("level4"); // ... first "paid" registration or upgrade time at Level#4.

The argument $user_id defaults to the current user; if logged in.
*/
if (!function_exists ("s2member_paid_registration_time"))
	{
		function s2member_paid_registration_time ($level = FALSE, $user_id = FALSE)
			{
				return ws_plugin__s2member_paid_registration_time ($level, $user_id);
			}
	}
/*
Retrieves a Custom Field value.
$field_id - required argument.
$user_id - defaults to current user.
*/
if (!function_exists ("get_user_field"))
	{
		function get_user_field ($field_id = FALSE, $user_id = FALSE)
			{
				return ws_plugin__s2member_get_user_field ($field_id, $user_id);
			}
	}
?>