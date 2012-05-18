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
Check existing installations that have not been re-activated.
Attach to: add_action("admin_init");
*/
if (!function_exists ("ws_plugin__s2member_check_activation"))
	{
		function ws_plugin__s2member_check_activation () /* Up-to-date? */
			{
				$v = get_option ("ws_plugin__s2member_activated_version");
				/**/
				if (!$v || !version_compare ($v, WS_PLUGIN__S2MEMBER_VERSION, ">="))
					{
						ws_plugin__s2member_activate ();
					}
				/**/
				else if (is_multisite () && is_main_site ())
					{
						$mms_v = get_option ("ws_plugin__s2member_activated_mms_version");
						/**/
						if (!$mms_v || !version_compare ($mms_v, WS_PLUGIN__S2MEMBER_VERSION, ">="))
							{
								ws_plugin__s2member_activate ();
							}
					}
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Function for handling activation routines.
This function should match the array key for this plugin:
ws_plugin__$plugin_key_activate() is called by our themes.

We also initialize some option values here.
Initializing these options will force them to be
autoloaded into WordPress® instead of generating
extra queries before they are set.
*/
if (!function_exists ("ws_plugin__s2member_activate"))
	{
		function ws_plugin__s2member_activate ()
			{
				global $wpdb; /* To update points of origin on a Multisite Network. */
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				do_action ("ws_plugin__s2member_before_activation", get_defined_vars ());
				/**/
				add_role ("subscriber", "Subscriber");
				add_role ("s2member_level1", "s2Member Level 1");
				add_role ("s2member_level2", "s2Member Level 2");
				add_role ("s2member_level3", "s2Member Level 3");
				add_role ("s2member_level4", "s2Member Level 4");
				/**/
				if ($role = &get_role ("subscriber"))
					{
						$role->add_cap ("read");
						$role->add_cap ("access_s2member_level0");
					}
				/**/
				if ($role = &get_role ("s2member_level1"))
					{
						$role->add_cap ("read");
						$role->add_cap ("level_0");
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
					}
				/**/
				if ($role = &get_role ("s2member_level2"))
					{
						$role->add_cap ("read");
						$role->add_cap ("level_0");
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
					}
				/**/
				if ($role = &get_role ("s2member_level3"))
					{
						$role->add_cap ("read");
						$role->add_cap ("level_0");
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
						$role->add_cap ("access_s2member_level3");
					}
				/**/
				if ($role = &get_role ("s2member_level4"))
					{
						$role->add_cap ("read");
						$role->add_cap ("level_0");
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
						$role->add_cap ("access_s2member_level3");
						$role->add_cap ("access_s2member_level4");
					}
				/**/
				if ($role = &get_role ("administrator"))
					{
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
						$role->add_cap ("access_s2member_level3");
						$role->add_cap ("access_s2member_level4");
					}
				/**/
				if ($role = &get_role ("editor"))
					{
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
						$role->add_cap ("access_s2member_level3");
						$role->add_cap ("access_s2member_level4");
					}
				/**/
				if ($role = &get_role ("author"))
					{
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
						$role->add_cap ("access_s2member_level3");
						$role->add_cap ("access_s2member_level4");
					}
				/**/
				if ($role = &get_role ("contributor"))
					{
						$role->add_cap ("access_s2member_level0");
						$role->add_cap ("access_s2member_level1");
						$role->add_cap ("access_s2member_level2");
						$role->add_cap ("access_s2member_level3");
						$role->add_cap ("access_s2member_level4");
					}
				/**/
				if (!is_dir ($files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]))
					if (is_writable (dirname ($files_dir)))
						mkdir ($files_dir, 0777);
				/**/
				if (is_dir ($files_dir) && is_writable ($files_dir))
					if (!file_exists ($htaccess = $files_dir . "/.htaccess"))
						file_put_contents ($htaccess, "deny from all");
				/**/
				if (!is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
					if (is_writable (dirname ($logs_dir)))
						mkdir ($logs_dir, 0777);
				/**/
				if (is_dir ($logs_dir) && is_writable ($logs_dir))
					if (!file_exists ($htaccess = $logs_dir . "/.htaccess"))
						file_put_contents ($htaccess, "deny from all");
				/**/
				(!is_array (get_option ("ws_plugin__s2member_cache"))) ? update_option ("ws_plugin__s2member_cache", array ()) : null;
				(!is_array (get_option ("ws_plugin__s2member_notices"))) ? update_option ("ws_plugin__s2member_notices", array ()) : null;
				(!is_array (get_option ("ws_plugin__s2member_options"))) ? update_option ("ws_plugin__s2member_options", array ()) : null;
				(!is_numeric (get_option ("ws_plugin__s2member_configured"))) ? update_option ("ws_plugin__s2member_configured", "0") : null;
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["configured"]) /* If already configured, we are re-activating. */
					{
						$v = get_option ("ws_plugin__s2member_activated_version");
						/**/
						if (!$v || !version_compare ($v, "3.2", ">=")) /* Needs to be upgraded? */
							/* Version 3.2 is where `meta_key` names were changed. They're prefixed now. */
							{
								$like = "`meta_key` LIKE 's2member\_%' AND `meta_key` NOT LIKE '%s2member\_originating\_blog%'";
								$wpdb->query ("UPDATE `" . $wpdb->usermeta . "` SET `meta_key` = CONCAT('" . $wpdb->prefix . "', `meta_key`) WHERE " . $like);
							}
						/**/
						if (!$v || !version_compare ($v, "3.2.5", ">=")) /* Needs to be upgraded? */
							/* Version 3.2.5 is where transient names were changed. They're prefixed now. */
							{
								$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '\_transient\_%'");
							}
						/**/
						if (!$v || !version_compare ($v, "3.2.6", ">=")) /* Needs to be upgraded? */
							/* Version 3.2.6 fixed `s2member_ccaps_req` being stored empty and/or w/ one empty element in the array. */
							{
								$wpdb->query ("DELETE FROM `" . $wpdb->postmeta . "` WHERE `meta_key` = 's2member_ccaps_req' AND `meta_value` IN('','a:0:{}','a:1:{i:0;s:0:\"\";}')");
							}
						/**/
						$notice = '<strong>s2Member</strong> has been <strong>re-activated</strong>, with the latest version.<br />';
						$notice .= 'You now have version ' . WS_PLUGIN__S2MEMBER_VERSION . '. Your existing configuration remains.';
						/**/
						if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ()) /* No Changelog on a Multisite Farm. */
							$notice .= '<br />Have fun, <a href="admin.php?page=ws-plugin--s2member-info#rm-changelog">read the Changelog</a>, and make some money! :-)';
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice, array ("plugins.php", "ws-plugin--s2member-options"));
					}
				else /* Otherwise, (initial activation); we'll help the Site Owner out by giving them a link to the Quick Start Guide. */
					{
						$notice = '<strong>s2Member</strong> v' . WS_PLUGIN__S2MEMBER_VERSION . ' has been <strong>activated</strong>. Nice work!<br />';
						$notice .= 'Have fun, <a href="admin.php?page=ws-plugin--s2member-start">read the Quick Start Guide</a>, and make some money! :-)';
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice, array ("plugins.php", "ws-plugin--s2member-options"));
					}
				/**/
				update_option ("ws_plugin__s2member_activated_version", WS_PLUGIN__S2MEMBER_VERSION); /* Mark version. */
				/**/
				if (is_multisite () && is_main_site ()) /* Network activation routines. A few quick adjustments. */
					{
						foreach ((array) ($users = $wpdb->get_results ("SELECT `ID` FROM `" . $wpdb->users . "`")) as $user)
							{
								/* Here we convert everyone already in the system; without a point of origin.
									This will set their point of origin to the Main Site ( Dashboard Blog ). */
								if (! ($originating_blog = get_user_meta ($user->ID, "s2member_originating_blog", true)))
									update_user_meta ($user->ID, "s2member_originating_blog", $current_site->blog_id);
							}
						/**/
						$notice = '<strong>Multisite Network</strong> updated automatically by <strong>s2Member</strong> v' . WS_PLUGIN__S2MEMBER_VERSION . '.<br />';
						$notice .= 'You\'ll want to configure s2Member\'s Multisite options now.<br />';
						$notice .= 'In the Dashboard for your Main Site, see:<br /><code>s2Member -> Multisite ( Config )</code>.';
						/**/
						ws_plugin__s2member_enqueue_admin_notice ($notice, array ("plugins.php", "ws-plugin--s2member-options"));
						/**/
						update_option ("ws_plugin__s2member_activated_mms_version", WS_PLUGIN__S2MEMBER_VERSION);
					}
				/**/
				do_action ("ws_plugin__s2member_after_activation", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
/*
Function for handling de-activation cleanup routines.
This function should match the array key for this plugin:
ws_plugin__$plugin_key_deactivate() is called by our themes.
*/
if (!function_exists ("ws_plugin__s2member_deactivate"))
	{
		function ws_plugin__s2member_deactivate ()
			{
				global $wpdb; /* May need this for database cleaning. */
				global $current_site, $current_blog; /* For Multisite support. */
				/**/
				do_action ("ws_plugin__s2member_before_deactivation", get_defined_vars ());
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["run_deactivation_routines"])
					{
						remove_role ("s2member_level1");
						remove_role ("s2member_level2");
						remove_role ("s2member_level3");
						remove_role ("s2member_level4");
						/**/
						if ($role = &get_role ("subscriber"))
							{
								$role->remove_cap ("access_s2member_level0");
							}
						/**/
						if ($role = &get_role ("administrator"))
							{
								$role->remove_cap ("access_s2member_level0");
								$role->remove_cap ("access_s2member_level1");
								$role->remove_cap ("access_s2member_level2");
								$role->remove_cap ("access_s2member_level3");
								$role->remove_cap ("access_s2member_level4");
							}
						/**/
						if ($role = &get_role ("editor"))
							{
								$role->remove_cap ("access_s2member_level0");
								$role->remove_cap ("access_s2member_level1");
								$role->remove_cap ("access_s2member_level2");
								$role->remove_cap ("access_s2member_level3");
								$role->remove_cap ("access_s2member_level4");
							}
						/**/
						if ($role = &get_role ("author"))
							{
								$role->remove_cap ("access_s2member_level0");
								$role->remove_cap ("access_s2member_level1");
								$role->remove_cap ("access_s2member_level2");
								$role->remove_cap ("access_s2member_level3");
								$role->remove_cap ("access_s2member_level4");
							}
						/**/
						if ($role = &get_role ("contributor"))
							{
								$role->remove_cap ("access_s2member_level0");
								$role->remove_cap ("access_s2member_level1");
								$role->remove_cap ("access_s2member_level2");
								$role->remove_cap ("access_s2member_level3");
								$role->remove_cap ("access_s2member_level4");
							}
						/**/
						if (is_dir ($files_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"]))
							{
								if (file_exists ($htaccess = $files_dir . "/.htaccess"))
									if (is_writable ($htaccess))
										unlink($htaccess);
								/**/
								@rmdir($files_dir);
							}
						/**/
						if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
							{
								foreach (scandir ($logs_dir) as $log_file)
									if (is_file ($log_file = $logs_dir . "/" . $log_file))
										if (is_writable ($log_file))
											unlink($log_file);
								/**/
								@rmdir($logs_dir);
							}
						/**/
						delete_option ("ws_plugin__s2member_cache");
						delete_option ("ws_plugin__s2member_notices");
						delete_option ("ws_plugin__s2member_options");
						delete_option ("ws_plugin__s2member_configured");
						delete_option ("ws_plugin__s2member_activated_version");
						delete_option ("ws_plugin__s2member_activated_mms_version");
						/**/
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '%s2member\_%'");
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '\_transient\_s2m\_%'");
						$wpdb->query ("DELETE FROM `" . $wpdb->options . "` WHERE `option_name` LIKE '\_transient\_timeout\_s2m\_%'");
						$wpdb->query ("DELETE FROM `" . $wpdb->postmeta . "` WHERE `meta_key` LIKE '%s2member\_%'");
						$wpdb->query ("DELETE FROM `" . $wpdb->usermeta . "` WHERE `meta_key` LIKE '%s2member\_%'");
						/**/
						do_action ("ws_plugin__s2member_during_deactivation", get_defined_vars ());
					}
				/**/
				do_action ("ws_plugin__s2member_after_deactivation", get_defined_vars ());
				/**/
				return; /* Return for uniformity. */
			}
	}
?>