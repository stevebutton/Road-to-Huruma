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
Mangles internal translations.
Attach to: add_filter("gettext");
*/
if (!function_exists ("ws_plugin__s2member_translation_mangler"))
	{
		function ws_plugin__s2member_translation_mangler ($translated = FALSE, $original = FALSE, $domain = FALSE)
			{
				global $current_site, $current_blog; /* In support of Multisite Networking. */
				static $is_admin_media_upload, $is_wp_signup, $is_wp_login; /* Optimizes this routine. */
				/**/
				if (!isset ($is_admin_media_upload) || $is_admin_media_upload)
					{
						if ($is_admin_media_upload || (is_admin () && preg_match ("/\/(async-upload|media-upload)\.php/", $_SERVER["REQUEST_URI"])))
							{
								$is_admin_media_upload = true; /* Yes, we are in this area. */
								/**/
								if ($translated === "Insert into Post") /* Give filters a chance here. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Insert", get_defined_vars ());
									}
							}
						else /* Otherwise, false. */
							$is_admin_media_upload = false;
					}
				/**/
				if (!isset ($is_wp_signup) || $is_wp_signup)
					{
						if ($is_wp_signup || (is_multisite () && is_main_site () && preg_match ("/\/wp-signup\.php/", $_SERVER["REQUEST_URI"])))
							{
								$is_wp_signup = true; /* Yes, we are in this area. */
								/**/
								if ($translated === "If you&#8217;re not going to use a great site domain, leave it for a new user. Now have at it!")
									$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "", get_defined_vars ());
								/**/
								else if ($translated === "Welcome back, %s. By filling out the form below, you can <strong>add another site to your account</strong>. There is no limit to the number of sites you can have, so create to your heart&#8217;s content, but write responsibly!")
									{
										if (is_user_logged_in () && is_object ($current_user = wp_get_current_user ())) /* Must have a User obj. */
											{
												$blogs_allowed = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_blogs_level" . ws_plugin__s2member_user_access_level ()];
												$current_user_blogs = (is_array ($blogs = get_blogs_of_user ($current_user->ID))) ? count ($blogs) - 1 : 0;
												$current_user_blogs = ($current_user_blogs >= 0) ? $current_user_blogs : 0;
												/**/
												if ($current_user_blogs >= 1) /* So here they already have at least 1 Blog. This message works fine. */
													$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "By filling out the form below, you can <strong>add another site to your account</strong>." . ( ($blogs_allowed > 1) ? "<br />You may create up to " . $blogs_allowed . " site" . ( ($blogs_allowed < 1 || $blogs_allowed > 1) ? "s" : "") . "." : ""), get_defined_vars ());
												/**/
												else /* Otherwise, we need a different message. One that is NOT confusing to a new Customer. */
													$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "By filling out the form below, you can <strong>add a site to your account</strong>." . ( ($blogs_allowed > 1) ? "<br />You may create up to " . $blogs_allowed . " site" . ( ($blogs_allowed < 1 || $blogs_allowed > 1) ? "s" : "") . "." : ""), get_defined_vars ());
											}
									}
							}
						else /* Otherwise, false. */
							$is_wp_signup = false;
					}
				/**/
				if (!isset ($is_wp_login) || $is_wp_login)
					{
						if ($is_wp_login || preg_match ("/\/wp-login\.php/", $_SERVER["REQUEST_URI"]))
							{
								$is_wp_login = true; /* Yes, we are in this area. */
								/**/
								if ($translated === "Username") /* Give filters a chance here. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Username *", get_defined_vars ());
									}
								else if ($translated === "E-mail") /* Give filters a chance here. */
									{
										$translated = apply_filters ("ws_plugin__s2member_translation_mangler", "Email Address *", get_defined_vars ());
									}
								else if ($translated === "Registration complete. Please check your e-mail.")
									{
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"] && function_exists ("ws_plugin__s2member_generate_password"))
											$translated = "Registration complete. Please log in.";
									}
							}
						else /* Otherwise, false. */
							$is_wp_login = false;
					}
				/**/
				return $translated;
			}
	}
?>