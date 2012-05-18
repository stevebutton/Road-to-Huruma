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
This can filter all WordPress® Post/Page queries.
	( based on s2Member's configuration )

s2Member respects the query var: `suppress_filters`. 
If you need to make a query without it being filtered,
	$wp_query->set ("suppress_filters", true);

WordPress® 3.0+ Menus set: `suppress_filters`.
	So this will NOT affect WP Menus.
		( intended behavior )

Don't call this function directly, use one of these API functions:
	
	Attach query filters:
	- attach_s2member_query_filters();
	
	Detach query filters:
	- detach_s2member_query_filters();

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("ws_plugin__s2member_query_level_access"))
	{
		function ws_plugin__s2member_query_level_access (&$wp_query = FALSE, $force = FALSE)
			{
				static $initial_query = true; /* Tracks initial query filtering. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_query_level_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (($o = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["filter_wp_query"]) !== "none" || $force) /* If `none`, the ONLY way to filter is with $force. */
					if ($force /* Forcing this routine bypasses all of these conditions. This works with the API function `attach_s2member_query_filters()`. */
					|| ($initial_query && preg_match ("/^(all|searches,feeds|searches)$/", $o) && is_search ()) /* Initial query; filter search results? */
					|| ($initial_query && preg_match ("/^(all|searches,feeds|feeds)$/", $o) && is_feed ()) /* Initital query; filter feed listings? */
					|| ($o === "all" && ! ($initial_query && is_singular ())) /* << do NOT create 404's. Allow the Security Gate to handle these. */)
						{
							if (!is_admin () && is_object ($wp_query) && !$wp_query->get ("suppress_filters")) /* These are ALWAYS requirements. */
								{
									$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false; /* Get the current User's object. */
									/*
									Filter all Posts/Pages requiring Custom Capabilities that the current User does NOT have access to.
									*/
									if (is_array ($ccaps = ws_plugin__s2member_get_singular_ids_with_ccaps_req ($current_user)) && !empty ($ccaps))
										$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $ccaps)));
									/*
									Filter all Posts/Pages requiring Specific Post/Page Access that the current Visitor does NOT have access to.
									*/
									if (is_array ($sps = ws_plugin__s2member_get_singular_ids_with_sp_req ()) && !empty ($sps))
										$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $sps)));
									/**/
									for ($i = 0; $i <= 4; $i++) /* Category Level Restrictions. Go through each Membership Level. */
										{
											if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] === "all" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$wp_query->set ("category__not_in", ws_plugin__s2member_get_all_category_ids ());
													break; /* All Categories will be locked down. */
												}
											else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"] && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$catgs = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_catgs"]);
													$wp_query->set ("category__not_in", array_unique (array_merge ((array)$wp_query->get ("category__not_in"), $catgs)));
												}
										}
									/**/
									for ($i = 0; $i <= 4; $i++) /* Tag Level Restrictions. Go through each Membership Level. */
										{
											if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] === "all" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$wp_query->set ("tag__not_in", ws_plugin__s2member_get_all_tag_ids ());
													break; /* ALL Tags will be locked down. */
												}
											else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"] && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$tags = ws_plugin__s2member_convert_tags_2_ids ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_ptags"]);
													$wp_query->set ("tag__not_in", array_unique (array_merge ((array)$wp_query->get ("tag__not_in"), $tags)));
												}
										}
									/**/
									for ($i = 0; $i <= 4; $i++) /* Post Level Restrictions. Go through each Membership Level. */
										{
											if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"] === "all" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$wp_query->set ("post__not_in", ws_plugin__s2member_get_all_post_ids ());
													break; /* ALL Posts will be locked down. */
												}
											else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"] && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$posts = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_posts"]);
													$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $posts)));
												}
										}
									/**/
									for ($i = 0; $i <= 4; $i++) /* Page Level Restrictions. Go through each Membership Level. */
										{
											if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_pages"] === "all" && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$wp_query->set ("post__not_in", ws_plugin__s2member_get_all_page_ids ());
													break; /* ALL Pages will be locked down. */
												}
											else if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_pages"] && (!$current_user || !current_user_can ("access_s2member_level" . $i)))
												{
													$pages = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_pages"]);
													$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $pages)));
												}
										}
									/**/
									eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
									do_action ("ws_plugin__s2member_during_query_level_access", get_defined_vars ());
									unset ($__refs, $__v); /* Unset defined __refs, __v. */
								}
						}
				/**/
				if ($initial_query && !is_admin ()) /* Systematics. */
					_ws_plugin__s2member_query_level_access_sys($wp_query);
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_query_level_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$initial_query = false; /* No longer. */
				/**/
				return; /* For uniformity. */
			}
	}
/*
This filters Systematics in search results & feeds.

	Specifically, these 3 Pages:
	- Membership Options
	- Login Welcome
	- Download Limit Exceeded

s2Member respects the query var: `suppress_filters`. 
If you need to make a query without it being filtered,
	$wp_query->set ("suppress_filters", true);

Don't call this function directly, use one of these API functions:
	
	Attach query filters:
	- attach_s2member_query_filters();
	
	Detach query filters:
	- detach_s2member_query_filters();

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("_ws_plugin__s2member_query_level_access_sys"))
	{
		function _ws_plugin__s2member_query_level_access_sys (&$wp_query = FALSE)
			{
				static $initial_query = true; /* Tracks initial query filtering. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_before_query_level_access_sys", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($initial_query && !is_admin () && (is_search () || is_feed ())) /* Searches/feeds. */
					/**/
					if (is_object ($wp_query) && !$wp_query->get ("suppress_filters")) /* Respect. */
						{
							$s[] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"];
							$s[] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"];
							$s[] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"];
							/**/
							$wp_query->set ("post__not_in", array_unique (array_merge ((array)$wp_query->get ("post__not_in"), $s)));
							/**/
							eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
							do_action ("_ws_plugin__s2member_during_query_level_access_sys", get_defined_vars ());
							unset ($__refs, $__v); /* Unset defined __refs, __v. */
						}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("_ws_plugin__s2member_after_query_level_access_sys", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				$initial_query = false; /* No longer. */
				/**/
				return; /* For uniformity. */
			}
	}
/*
Forces query filters ( on-demand ).
But still respects: `suppress_filters`.

s2Member respects the query var: `suppress_filters`. 
If you need to make a query without it being filtered,
	$wp_query->set ("suppress_filters", true);

Don't call this function directly, use one of these API functions:
	
	Attach query filters:
	- attach_s2member_query_filters();
	
	Detach query filters:
	- detach_s2member_query_filters();

see: `/s2member/includes/functions/api-functions.inc.php`.
*/
if (!function_exists ("ws_plugin__s2member_force_query_level_access"))
	{
		function ws_plugin__s2member_force_query_level_access (&$wp_query = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_force_query_level_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				ws_plugin__s2member_query_level_access ($wp_query, "force-filters");
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_force_query_level_access", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return; /* For uniformity. */
			}
	}
?>