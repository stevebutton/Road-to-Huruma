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
Function that forces SSL on specific Posts/Pages.
Attach to: add_action("template_redirect");

Triggered by Custom Field:
	s2member_force_ssl = yes
		( i.e. https://www.example.com/ )

Or with a specific port number:
	s2member_force_ssl = 443 ( or whatever port you require )
		( i.e. https://www.example.com:443/ )
*/
if (!function_exists ("ws_plugin__s2member_check_force_ssl"))
	{
		function ws_plugin__s2member_check_force_ssl () /* Forces SSL. */
			{
				global $post; /* We need the global $post variable here. */
				/**/
				do_action ("ws_plugin__s2member_before_check_force_ssl", get_defined_vars ());
				/**/
				$force_ssl = apply_filters ("ws_plugin__s2member_check_force_ssl", false, get_defined_vars ());
				/**/
				if (($force_ssl || (is_singular () && is_object ($post) && ($__id = $post->ID))) && strtolower ($force_ssl) !== "no")
					/**/
					if (($force_ssl || ($force_ssl = get_post_meta ($__id, "s2member_force_ssl", true))) && strtolower ($force_ssl) !== "no")
						{
							if (!is_ssl ()) /* SSL must be enabled here. Redirect to the equivalent https:// scheme. */
								{
									$ssl_host = preg_replace ("/\:[0-9]+$/", "", $_SERVER["HTTP_HOST"]);
									$ssl_port = (is_numeric ($force_ssl) && $force_ssl > 1) ? $force_ssl : 0;
									$ssl_host_port = $ssl_host . (($ssl_port) ? ":" . $ssl_port : "");
									/**/
									wp_redirect ("https://" . $ssl_host_port . $_SERVER["REQUEST_URI"]);
									exit (); /* ^ So let's redirect to the SSL enabled version. */
								}
							else /* Otherwise, we buffer all output, and switch all content over to https. */
								{
									add_filter("redirect_canonical", "__return_false");
									/**/
									$ssl_host = preg_replace ("/\:[0-9]+$/", "", $_SERVER["HTTP_HOST"]);
									$ssl_port = (is_numeric ($force_ssl) && $force_ssl > 1) ? $force_ssl : 0;
									$ssl_host_port = $ssl_host . (($ssl_port) ? ":" . $ssl_port : "");
									/**/
									define ("_ws_plugin__s2member_force_ssl_host", $ssl_host);
									define ("_ws_plugin__s2member_force_ssl_port", $ssl_port);
									define ("_ws_plugin__s2member_force_ssl_host_port", $ssl_host_port);
									/**/
									/* Except these. We do NOT want to create a sitewide https conversion! */
									add_filter ("home_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
									add_filter ("network_home_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
									add_filter ("site_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
									add_filter ("network_site_url", "_ws_plugin__s2member_force_non_ssl_scheme", 10, 3);
									/**/
									function _ws_plugin__s2member_force_non_ssl_scheme ($url = FALSE, $path = FALSE, $scheme = FALSE)
										{
											return ($scheme) ? $url : preg_replace ("/^https\:\/\//i", "http://", $url);
										}
									/**/
									function _ws_plugin__s2member_force_ssl_buffer ($buffer = FALSE)
										{
											$o_pcre = ini_get ("pcre.backtrack_limit");
											/**/
											ini_set ("pcre.backtrack_limit", 10000000);
											/**/
											$tags = "script|style|link|img|input|iframe|object|embed"; /* Specific tags. */
											/**/
											$tags = apply_filters ("_ws_plugin__s2member_force_ssl_buffer_tags", $tags, get_defined_vars ());
											/**/
											$buffer = preg_replace_callback ("/\<(" . $tags . ")[^\>]+\>/i", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer);
											$buffer = preg_replace_callback ("/\<style[^\>]*\>(.+?)\<\/style\>/is", "_ws_plugin__s2member_force_ssl_buffer_callback", $buffer);
											/**/
											ini_set ("pcre.backtrack_limit", $o_pcre);
											/**/
											return apply_filters ("_ws_plugin__s2member_force_ssl_buffer", $buffer, get_defined_vars ());
										}
									/**/
									function _ws_plugin__s2member_force_ssl_buffer_callback ($m = FALSE)
										{
											$c = preg_replace ("/http\:\/\//i", "https://", $m[0]);
											/**/
											if (_ws_plugin__s2member_force_ssl_port && _ws_plugin__s2member_force_ssl_host && _ws_plugin__s2member_force_ssl_host_port) /* Do we ALSO need port conversions? */
												$c = preg_replace ("/\/" . preg_quote (_ws_plugin__s2member_force_ssl_host, "/") . "(\:[0-9]+)?\//i", "/" . _ws_plugin__s2member_force_ssl_host_port . "/", $c);
											/**/
											return (strtolower ($m[1]) === "link" && preg_match ("/['\"]alternate['\"]/i", $m[0])) ? $m[0] : $c; /* Return string with conversions. */
										}
									/**/
									ob_start ("_ws_plugin__s2member_force_ssl_buffer");
								}
						}
				/**/
				do_action ("ws_plugin__s2member_after_check_force_ssl", get_defined_vars ());
				/**/
				return;
			}
	}
?>