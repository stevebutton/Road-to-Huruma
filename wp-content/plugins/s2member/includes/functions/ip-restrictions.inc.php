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
Function for handling IP Restrictions.
IP address details are stored in Transient fields.
*/
if (!function_exists ("ws_plugin__s2member_ip_restrictions_ok"))
	{
		function ws_plugin__s2member_ip_restrictions_ok ($ip = FALSE, $restriction = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_ip_restrictions_ok", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"] && $restriction)
					{
						$prefix = "s2m_ipr_"; /* s2Member Transient prefix for all IP Restrictions. */
						/**/
						$transient_entries = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_entries");
						$transient_security_breach = $prefix . md5 ("s2member_ip_restrictions_" . $restriction . "_security_breach");
						/**/
						$conc_filter = "ws_plugin__s2member_ip_restrictions__concurrency_time_per_ip";
						$concurrency = apply_filters ($conc_filter, "30 days");
						/**/
						$entries = (is_array ($entries = get_transient ($transient_entries))) ? $entries : array ();
						/**/
						foreach ($entries as $_entry => $_time) /* Auto-expire entries. */
							if ($_time < strtotime ("-" . $concurrency))
								unset ($entries[$_entry]);
						/**/
						$ip = ($ip) ? $ip : "empty"; /* Allow empty IPs. */
						$entries[$ip] = strtotime ("now"); /* Log this entry. */
						set_transient ($transient_entries, $entries, 2 * (strtotime ("+" . $concurrency) - strtotime ("now")));
						/**/
						if (get_transient ($transient_security_breach)) /* Has this restriction already been breached? */
							{
								ws_plugin__s2member_nocache_constants(true) . wp_clear_auth_cookie ();
								/**/
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
								/**/
								header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Sends a status header. */
								/**/
								echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
								echo 'Too many IP addresses accessing one secure area<em>!</em><br />' . "\n";
								echo 'Please contact Support if you require assistance.';
								/**/
								exit ();
							}
						else if (count ($entries) > $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction"])
							{
								ws_plugin__s2member_nocache_constants(true) . wp_clear_auth_cookie ();
								/**/
								set_transient ($transient_security_breach, 1, /* Lock down. */
								$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["max_ip_restriction_time"]);
								/**/
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_no", get_defined_vars ());
								/**/
								header ("HTTP/1.0 503 Service Temporarily Unavailable"); /* Sends a status header. */
								/**/
								echo '<strong>503: Service Temporarily Unavailable</strong><br />' . "\n";
								echo 'Too many IP addresses accessing one secure area<em>!</em><br />' . "\n";
								echo 'Please contact Support if you require assistance.';
								/**/
								exit ();
							}
						else /* OK, this looks legitimate. Apply Filters here and return true. */
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_ip_restrictions_ok_yes", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
							}
					}
				/**/
				return apply_filters ("ws_plugin__s2member_ip_restrictions_ok", true, get_defined_vars ());
			}
	}
/*
Function resets/deletes all IP Restrictions.
*/
if (!function_exists ("ws_plugin__s2member_delete_reset_all_ip_restrictions"))
	{
		function ws_plugin__s2member_delete_reset_all_ip_restrictions ()
			{
				global $wpdb; /* Need global database object. */
				/**/
				do_action ("ws_plugin__s2member_before_delete_reset_all_ip_restrictions", get_defined_vars ());
				/**/
				$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '\_transient\_s2m\_ipr\_%'");
				$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '\_transient\_timeout\_s2m\_ipr\_%'");
				/**/
				do_action ("ws_plugin__s2member_after_delete_reset_all_ip_restrictions", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Function resets/deletes all IP Restrictions.
Attach to: add_action("wp_ajax_ws_plugin__s2member_reset_ip_restrictions_via_ajax");
*/
if (!function_exists ("ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax"))
	{
		function ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax ()
			{
				do_action ("ws_plugin__s2member_before_delete_reset_all_ip_restrictions_via_ajax", get_defined_vars ());
				/**/
				if (current_user_can ("create_users")) /* Check priveledges as well. */
					if (($nonce = $_POST["ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-delete-reset-all-ip-restrictions-via-ajax"))
						if (ws_plugin__s2member_delete_reset_all_ip_restrictions () !== "nill") /* Delete/reset IP Restrictions, and return 1 ( success ). */
							echo apply_filters ("ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax", 1, get_defined_vars ());
				/**/
				exit ();
			}
	}
?>