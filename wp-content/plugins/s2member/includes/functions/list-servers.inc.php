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
Function that determines whether or not any list
servers have been integrated into the s2Member options.
*/
if (!function_exists ("ws_plugin__s2member_list_servers_integrated"))
	{
		function ws_plugin__s2member_list_servers_integrated ()
			{
				do_action ("ws_plugin__s2member_before_list_servers_integrated", get_defined_vars ());
				/**/
				for ($i = 0; $i <= 4; $i++)
					if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_mailchimp_list_ids"] || $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $i . "_aweber_list_ids"])
						return apply_filters ("ws_plugin__s2member_list_servers_integrated", true, get_defined_vars ());
				/**/
				return apply_filters ("ws_plugin__s2member_list_servers_integrated", false, get_defined_vars ());
			}
	}
/*
Function that process list server integrations for s2Member.
*/
if (!function_exists ("ws_plugin__s2member_process_list_servers"))
	{
		function ws_plugin__s2member_process_list_servers ($role = FALSE, $level = FALSE, $email = FALSE, $fname = FALSE, $lname = FALSE, $ip = FALSE, $opt_in = FALSE, $user_id = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_process_list_servers", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (strlen ($level) && is_email ($email) && $opt_in) /* Must have these. */
					{
						$email_configs_were_on = ws_plugin__s2member_email_config_status (0);
						ws_plugin__s2member_email_config_release (); /* Release Filters. */
						/**/
						if (($mailchimp_api_key = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]))
							if (($mailchimp_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_mailchimp_list_ids"]))
								{
									if (!class_exists ("NC_MCAPI"))
										include_once dirname (dirname (__FILE__)) . "/mailchimp/nc-mcapi.inc.php";
									/**/
									$MCAPI = new NC_MCAPI ($mailchimp_api_key); /* MailChimp® API class. */
									/**/
									foreach (preg_split ("/[\r\n\t\s;,]+/", $mailchimp_list_ids) as $mailchimp_list_id)
										$MCAPI->listSubscribe ($mailchimp_list_id, $email, apply_filters ("ws_plugin__s2member_mailchimp_array", array ("FNAME" => $fname, "LNAME" => $lname, "OPTINIP" => $ip), get_defined_vars ()));
								}
						/**/
						if (($aweber_list_ids = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level" . $level . "_aweber_list_ids"]))
							{
								foreach (preg_split ("/[\r\n\t\s;,]+/", $aweber_list_ids) as $aweber_list_id)
									wp_mail ($aweber_list_id . "@aweber.com", apply_filters ("ws_plugin__s2member_aweber_sbj", "s2Member Subscription Request", get_defined_vars ()), apply_filters ("ws_plugin__s2member_aweber_msg", "s2Member Subscription Request\ns2Member w/ PayPal Email ID\nEMail Address: " . $email . "\nBuyer: " . $fname . " " . $lname . "\nFull Name: " . $fname . " " . $lname . "\nFirst Name: " . $fname . "\nLast Name: " . $lname . "\nIP Address: " . $ip . "\nUser ID: " . $user_id . "\nRole: " . $role . "\nLevel: " . $level . "\n - end.", get_defined_vars ()), "From: \"" . preg_replace ("/\"/", "", $fname . " " . $lname) . "\" <" . $email . ">\r\nContent-Type: text/plain; charset=utf-8");
							}
						/**/
						if ($email_configs_were_on) /* Back on? */
							ws_plugin__s2member_email_config ();
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_during_process_list_servers", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
					}
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_after_process_list_servers", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				return;
			}
	}
?>