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
Function that displays Signup Tracking Codes.
These are stored inside s2Member's Transient Queue by the IPN processor.

Attach to: add_action("login_form_register");
Attach to: add_action("login_form_login");
Attach to: add_action("wp_footer");

Tracking Codes are only displayed/processed one time.
s2Member will display Tracking Codes in (1) of these 3 locations:
1. If possible, on the Registration Form, after returning from PayPal®.
2. Otherwise, if possible, on the Login Form after Registration is completed.
3. Otherwise, in the footer of your theme, after both Registration and Login.
*/
if (!function_exists ("ws_plugin__s2member_display_signup_tracking_codes"))
	{
		function ws_plugin__s2member_display_signup_tracking_codes ()
			{
				do_action ("ws_plugin__s2member_before_display_signup_tracking_codes", get_defined_vars ());
				/**/
				if (($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_subscr_id"])) || ($subscr_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_signup_tracking"])))
					{
						if (($code = get_transient ($transient = md5 ("s2member_transient_signup_tracking_codes_" . $subscr_id))))
							{
								delete_transient ($transient); /* Only display this ONE time. Delete transient immediately. */
								/**/
								echo '<img src="' . add_query_arg ("s2member_delete_signup_tracking_cookie", urlencode ("1"), get_bloginfo ("wpurl")) . '" alt="." style="width:1px; height:1px; border:0;" />' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_display_signup_tracking_codes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ())
									{
										echo $code . "\n"; /* No PHP here. */
									}
								else /* Otherwise, it's safe to allow PHP code. */
									{
										eval ("?>" . $code);
									}
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_display_signup_tracking_codes", get_defined_vars ());
			}
	}
/*
Deletes s2Member's temporary tracking cookie.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_delete_signup_tracking_cookie"))
	{
		function ws_plugin__s2member_delete_signup_tracking_cookie ()
			{
				do_action ("ws_plugin__s2member_before_delete_signup_tracking_cookie", get_defined_vars ());
				/**/
				if ($_GET["s2member_delete_signup_tracking_cookie"]) /* Deletes cookie. */
					{
						setcookie ("s2member_signup_tracking", "", time () + 31556926, "/");
						/**/
						do_action ("ws_plugin__s2member_during_delete_signup_tracking_cookie", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_delete_signup_tracking_cookie", get_defined_vars ());
			}
	}
/*
Function that displays Specific Post/Page Tracking Codes.
These are stored inside s2Member's Transient Queue,
by BOTH the IPN & Return-Data processors.

Attach to: add_action("wp_footer");

Specific Post/Page Tracking Codes are only displayed/processed one time.
s2Member will display Tracking Codes in the footer of your theme.
*/
if (!function_exists ("ws_plugin__s2member_display_sp_tracking_codes"))
	{
		function ws_plugin__s2member_display_sp_tracking_codes ()
			{
				do_action ("ws_plugin__s2member_before_display_sp_tracking_codes", get_defined_vars ());
				/**/
				if (($txn_id = ws_plugin__s2member_decrypt ($_COOKIE["s2member_sp_tracking"])))
					{
						if (($code = get_transient ($transient = md5 ("s2member_transient_sp_tracking_codes_" . $txn_id))))
							{
								delete_transient ($transient); /* Only display this ONE time. Delete transient immediately. */
								/**/
								echo '<img src="' . add_query_arg ("s2member_delete_sp_tracking_cookie", urlencode ("1"), get_bloginfo ("wpurl")) . '" alt="." style="width:1px; height:1px; border:0;" />' . "\n";
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_display_sp_tracking_codes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ())
									{
										echo $code . "\n"; /* No PHP here. */
									}
								else /* Otherwise, it's safe to allow PHP code. */
									{
										eval ("?>" . $code);
									}
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_display_sp_tracking_codes", get_defined_vars ());
			}
	}
/*
Deletes s2Member's temporary tracking cookie.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_delete_sp_tracking_cookie"))
	{
		function ws_plugin__s2member_delete_sp_tracking_cookie ()
			{
				do_action ("ws_plugin__s2member_before_delete_sp_tracking_cookie", get_defined_vars ());
				/**/
				if ($_GET["s2member_delete_sp_tracking_cookie"]) /* Deletes cookie. */
					{
						setcookie ("s2member_sp_tracking", "", time () + 31556926, "/");
						/**/
						do_action ("ws_plugin__s2member_during_delete_sp_tracking_cookie", get_defined_vars ());
						/**/
						exit ();
					}
				/**/
				do_action ("ws_plugin__s2member_after_delete_sp_tracking_cookie", get_defined_vars ());
			}
	}
?>