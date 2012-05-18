<?php
/*
Version: 1.0.2
Stable tag: 1.0.2
Framework: WS-BB-DIP-1.0

Tested up to: 1.0.2
Requires at least: 1.0.2
Requires: s2Member 3.2+, bbPress® 1.0.2+

Copyright: © 2009 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks, PriMoThemes
Author URI: http://www.primothemes.com/
Author: PriMoThemes.com / WebSharks, Inc.
Donate link: http://www.primothemes.com/donate/

Plugin Name: s2Member Bridge
Pro Module / Prices: http://www.s2member.com/prices/
Forum URI: http://www.primothemes.com/forums/viewforum.php?f=4
Professional Installation URI: http://www.primothemes.com/forums/viewtopic.php?f=4&t=107
Plugin URI: http://www.primothemes.com/post/product/s2member-membership-plugin-with-paypal/
Description: Blocks all non-Member access to bbPress® forums. Only the login-page is available. Forum registration is redirected to your Membership Options Page for s2Member ( on your main WordPress® installation ). This way, a visitor can signup on your site, and gain Membership Access to your forums. This plugin will NOT work, until you've successfully integrated WordPress® into bbPress®. See: `bbPress® -> Settings -> WordPress® Integration`.
Tags: membership, members, member, register, signup, paypal, pay pal, s2member, subscriber, members only, bbpress, bb press, forums, forum, buddypress, buddy press, buddy press compatible, shopping cart, checkout, api, options panel included, websharks framework, w3c validated code, multi widget support, includes extensive documentation, highly extensible
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
Filled by the s2Member installer. Or you can set this manually.
- If this is NOT set, it defaults to 0 = ( Free Subscribers ).
*/
define ("WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_MIN_LEVEL", "%%min%%");
/*
Convert s2Member Roles into bbPress® "Members" on-the-fly.
	- Only when no bbPress® Role has been assigned yet.
		- This way a site owner can still modify Roles.
*/
add_action ("bb_init", "ws_plugin__s2member_bridge_bbpress_roles");
/**/
function ws_plugin__s2member_bridge_bbpress_roles () /* On-the-fly. */
	{
		$wp_capabilities = bb_get_option ("wp_table_prefix") . "capabilities";
		/**/
		if (is_object ($user = bb_get_current_user ()) && $user->ID) /* Logged in? */
			/**/
			if (empty ($user->roles)) /* Only if/when no bbPress® Role is assigned. */
				/**/
				bb_give_user_default_role($user); /* Assign a default Role. */
	}
/*
Deny all access to the bbPress® registration page.
This will leave the bbPress® login page available, as it should be.
	- Also deny all access to anyone that does NOT have permission to participate.
		In other words, anyone who is NOT at least a bbPress® Member Role.
	- Also deny access to s2Member Roles that are NOT at a high enough Level.
*/
add_action ("bb_init", "ws_plugin__s2member_bridge_bbpress_access");
/**/
function ws_plugin__s2member_bridge_bbpress_access () /* Check Access. */
	{
		$min = (int)WS_PLUGIN__S2MEMBER_BRIDGE_BBPRESS_MIN_LEVEL; /* Or 0. */
		/**/
		$location = bb_get_location (); /* The current navigation location. */
		/**/
		$wp_capabilities = bb_get_option ("wp_table_prefix") . "capabilities";
		/**/
		if (!in_array ($location, array ("login-page", "register-page")))
			{
				if (!bb_is_user_logged_in () || !bb_current_user_can ("participate"))
					{
						if ($url = bb_get_option ("wp_siteurl")) /* WordPress® is integrated? */
							{
								$bbPress = bb_get_option ("uri"); /* bbPress® location. */
								/**/
								if (preg_match ("/^" . preg_quote ($bbPress, "/") . "/", $_SERVER["HTTP_REFERER"]))
									wp_redirect ($url, apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
								/**/
								else /* Otherwise, trigger the Membership Options Page + s2member_level_req = $min. */
									wp_redirect ($url . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
								/**/
								exit ();
							}
					}
				/**/
				else if (is_object ($user = bb_get_current_user ()) && $user->ID) /* Logged in? / Got User object? */
					/**/
					foreach ($user->$wp_capabilities as $wp_cap => $v) /* Looking for ^(subscriber|s2member_level[0-4])$. */
						/**/
						if (preg_match ("/^(subscriber|s2member_level[0-4])$/", $wp_cap)) /* Subscribers and/or s2Member Roles. */
							/**/
							if (($wp_cap === "subscriber" && $min > 0) || ($level = preg_replace ("/^s2member_level/", "", $wp_cap)) < $min)
								/**/
								if ($url = bb_get_option ("wp_siteurl")) /* Only if WordPress® is fully integrated? */
									{
										$bbPress = bb_get_option ("uri"); /* bbPress® location. */
										/**/
										if (preg_match ("/^" . preg_quote ($bbPress, "/") . "/", $_SERVER["HTTP_REFERER"]))
											wp_redirect ($url, apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
										/**/
										else /* Otherwise, trigger the Membership Options Page + s2member_level_req = $min. */
											wp_redirect ($url . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
										/**/
										exit ();
									}
			}
		/**/
		else if (in_array ($location, array ("register-page"))) /* Send registration requests through WP. */
			{
				if ($url = bb_get_option ("wp_siteurl")) /* The Front Page on the WordPress® installation. */
					{
						wp_redirect ($url . "/?s2member_membership_options_page=1&s2member_seeking=bbpress&s2member_level_req=" . urlencode ($min), apply_filters ("ws_plugin__s2member_content_redirect_status", 301, get_defined_vars ()));
						exit (); /* Membership Options Page + s2member_level_req = $min. */
					}
			}
	}
?>