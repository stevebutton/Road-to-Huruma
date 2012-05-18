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
Version: 3.3.2
Stable tag: 3.3.2
Framework: WS-P-3.1

SSL Compatible: yes
bbPress Compatible: yes
WordPress Compatible: yes
BuddyPress Compatible: yes
WP Multisite Compatible: yes
Multisite Blog Farm Compatible: yes

PayPal® Standard Compatible: yes
PayPal® Pro Compatible: w/ s2Member Pro
Google® Checkout Compatible: w/ s2Member Pro
ClickBank® Compatible: w/ s2Member Pro
AliPay® Compatible: w/ s2Member Pro

Tested up to: 3.0.3
Requires at least: 3.0
Requires: WordPress® 3.0+, PHP 5.2+

Copyright: © 2009 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks, PriMoThemes
Author URI: http://www.primothemes.com/
Author: PriMoThemes.com / WebSharks, Inc.
Donate link: http://www.primothemes.com/donate/

Plugin Name: s2Member
Pro Module / Prices: http://www.s2member.com/prices/
Forum URI: http://www.primothemes.com/forums/viewforum.php?f=4
PayPal Pro Integration: http://www.primothemes.com/forums/viewtopic.php?f=4&t=304
Professional Installation URI: http://www.primothemes.com/forums/viewtopic.php?f=4&t=107
Plugin URI: http://www.primothemes.com/post/product/s2member-membership-plugin-with-paypal/
Description: Empowers WordPress® with membership capabilities. Integrates seamlessly with PayPal®. Also compatible with Multisite Networking, and even with BuddyPress if you like.
Tags: membership, members, member, register, signup, paypal, pay pal, s2member, subscriber, members only, buddypress, buddy press, buddy press compatible, shopping cart, checkout, api, options panel included, websharks framework, w3c validated code, includes extensive documentation, highly extensible
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
Define versions.
*/
define ("WS_PLUGIN__S2MEMBER_VERSION", "3.3.2");
define ("WS_PLUGIN__S2MEMBER_MIN_PHP_VERSION", "5.2");
define ("WS_PLUGIN__S2MEMBER_MIN_WP_VERSION", "3.0");
define ("WS_PLUGIN__S2MEMBER_MIN_PRO_VERSION", "1.3.2");
/*
Compatibility checks.
*/
if (version_compare (PHP_VERSION, WS_PLUGIN__S2MEMBER_MIN_PHP_VERSION, ">=") && version_compare (get_bloginfo ("version"), WS_PLUGIN__S2MEMBER_MIN_WP_VERSION, ">=") && !isset ($GLOBALS["WS_PLUGIN__"]["s2member"]))
	{
		$GLOBALS["WS_PLUGIN__"]["s2member"]["l"] = __FILE__;
		/*
		Hook before loaded.
		*/
		do_action ("ws_plugin__s2member_before_loaded");
		/*
		System configuraton.
		*/
		include_once dirname (__FILE__) . "/includes/syscon.inc.php";
		/*
		Hooks and filters.
		*/
		include_once dirname (__FILE__) . "/includes/hooks.inc.php";
		/*
		Hook after system config & hooks are loaded.
		*/
		do_action ("ws_plugin__s2member_config_hooks_loaded");
		/*
		Load a possible Pro module, if/when available.
		*/
		@include_once dirname (__FILE__) . "-pro/pro-module.php";
		/*
		Function includes.
		*/
		include_once dirname (__FILE__) . "/includes/funcs.inc.php";
		/*
		Include shortcodes.
		*/
		include_once dirname (__FILE__) . "/includes/codes.inc.php";
		/*
		Hook after loaded.
		*/
		do_action ("ws_plugin__s2member_after_loaded");
	}
else if (is_admin ()) /* Admin compatibility errors. */
	{
		if (!version_compare (PHP_VERSION, WS_PLUGIN__S2MEMBER_MIN_PHP_VERSION, ">="))
			{
				add_action ("admin_notices", create_function ('', 'echo \'<div class="error fade"><p>You need PHP v\' . WS_PLUGIN__S2MEMBER_MIN_PHP_VERSION . \'+ to use the s2Member plugin.</p></div>\';'));
			}
		else if (!version_compare (get_bloginfo ("version"), WS_PLUGIN__S2MEMBER_MIN_WP_VERSION, ">="))
			{
				add_action ("admin_notices", create_function ('', 'echo \'<div class="error fade"><p>You need WordPress® v\' . WS_PLUGIN__S2MEMBER_MIN_WP_VERSION . \'+ to use the s2Member plugin.</p></div>\';'));
			}
	}
?>