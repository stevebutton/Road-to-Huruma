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
Function that handles a remote request.
This extends wp_remote_request() through the `WP_Http` class.
*/
if (!function_exists ("ws_plugin__s2member_remote"))
	{
		function ws_plugin__s2member_remote ($url = FALSE, $post_vars = FALSE, $args = array ())
			{
				static $http_response_filtered = false; /* Filter once. */
				/**/
				$args = (!is_array ($args)) ? array (): $args;
				/**/
				if (!$http_response_filtered && ($http_response_filtered = true))
					add_filter ("http_response", "_ws_plugin__s2member_remote_gz_variations");
				/**/
				if ($url) /* Obviously, we must have a URL to do anything. */
					{
						if (preg_match ("/^https/i", $url) && strtolower (substr (PHP_OS, 0, 3)) === "win")
							add_filter ("use_curl_transport", "_ws_plugin__s2member_remote_disable_curl");
						/**/
						if ((is_array ($post_vars) || is_string ($post_vars)) && !empty ($post_vars))
							{
								$args["method"] = "POST";
								$args["body"] = $post_vars;
							}
						/**/
						$body = wp_remote_retrieve_body (wp_remote_request ($url, $args));
						/**/
						remove_filter ("use_curl_transport", "_ws_plugin__s2member_remote_disable_curl");
						/**/
						return $body; /* The body content received. */
					}
				/**/
				return false;
			}
	}
/*
A sort of callback function that disables the WP_Http cURL transport option.
This is ONLY necessary on a Windows OS; and ONLY when processing https requests.
Attach to: add_filter("use_curl_transport");

If you're going to process SSL requests over https, Windows servers should set `allow_url_fopen = on` inside their php.ini file.
*/
if (!function_exists ("_ws_plugin__s2member_remote_disable_curl"))
	{
		function _ws_plugin__s2member_remote_disable_curl ($use_curl_transport = TRUE)
			{
				return ($use_curl_transport = FALSE);
			}
	}
/*
A sort of callback function that filters the WP_Http response for additional gzinflate variations.
Attach to: add_filter("http_response");
*/
if (!function_exists ("_ws_plugin__s2member_remote_gz_variations"))
	{
		function _ws_plugin__s2member_remote_gz_variations ($response = array ())
			{
				if (!isset ($response["ws__gz_variations"]) && ($response["ws__gz_variations"] = 1))
					{
						if ($response["headers"]["content-encoding"])
							if (substr ($response["body"], 0, 2) === "\x78\x9c")
								if (($gz = @gzinflate (substr ($response["body"], 2))))
									$response["body"] = $gz;
					}
				/**/
				return $response;
			}
	}
/*
Function that extends array_unique to
support multi-dimensional arrays.
*/
if (!function_exists ("ws_plugin__s2member_array_unique"))
	{
		function ws_plugin__s2member_array_unique ($array = FALSE)
			{
				if (!is_array ($array))
					{
						return array ($array);
					}
				else /* Serialized array_unique. */
					{
						foreach ($array as &$value)
							{
								$value = serialize ($value);
							}
						/**/
						$array = array_unique ($array);
						/**/
						foreach ($array as &$value)
							{
								$value = unserialize ($value);
							}
						/**/
						return $array;
					}
			}
	}
/*
Function that searches a multi-dimensional array
using a regular expression match against array values.
*/
if (!function_exists ("ws_plugin__s2member_regex_in_array"))
	{
		function ws_plugin__s2member_regex_in_array ($regex = FALSE, $array = FALSE)
			{
				if ($regex && is_array ($array))
					{
						foreach ($array as $value)
							{
								if (is_array ($value)) /* Recursive function call. */
									{
										if (ws_plugin__s2member_regex_in_array ($regex, $value))
											return true;
									}
								/**/
								else if (is_string ($value)) /* Must be a string. */
									{
										if (@preg_match ($regex, $value))
											return true;
									}
							}
						/**/
						return false;
					}
				else /* False. */
					return false;
			}
	}
/*
Function that buffers ( gets ) function output.
*/
if (!function_exists ("ws_plugin__s2member_get"))
	{
		function ws_plugin__s2member_get ($function = FALSE)
			{
				$args = func_get_args ();
				$function = array_shift ($args);
				/**/
				if (is_string ($function) && $function)
					{
						ob_start ();
						/**/
						if (is_array ($args) && !empty ($args))
							{
								$return = call_user_func_array ($function, $args);
							}
						else /* There are no additional arguments to pass. */
							{
								$return = call_user_func ($function);
							}
						/**/
						$echo = ob_get_clean ();
						/**/
						return (!strlen ($echo) && strlen ($return)) ? $return : $echo;
					}
				else /* Else return null. */
					return;
			}
	}
/*
Function evaluates PHP code, and returns the output afterward.
*/
if (!function_exists ("ws_plugin__s2member_eval"))
	{
		function ws_plugin__s2member_eval ($code = FALSE)
			{
				ob_start (); /* Output buffer. */
				/**/
				eval ("?>" . trim ($code));
				/**/
				return ob_get_clean ();
			}
	}
/*
Function escapes double quotes.
*/
if (!function_exists ("ws_plugin__s2member_esc_dq"))
	{
		function ws_plugin__s2member_esc_dq ($string = FALSE)
			{
				return preg_replace ('/"/', '\"', $string);
			}
	}
/*
Function escapes single quotes.
*/
if (!function_exists ("ws_plugin__s2member_esc_sq"))
	{
		function ws_plugin__s2member_esc_sq ($string = FALSE)
			{
				return preg_replace ("/'/", "\'", $string);
			}
	}
/*
Function escapes single quotes.
*/
if (!function_exists ("ws_plugin__s2member_esc_ds"))
	{
		function ws_plugin__s2member_esc_ds ($string = FALSE)
			{
				return preg_replace ('/\$/', '\\\$', $string);
			}
	}
/*
Function that trims deeply.
*/
if (!function_exists ("ws_plugin__s2member_trim_deep"))
	{
		function ws_plugin__s2member_trim_deep ($value = FALSE)
			{
				return is_array ($value) ? array_map ('ws_plugin__s2member_trim_deep', $value) : trim ($value);
			}
	}
/*
Function that trims &quot; entities deeply.
This is useful on Shortcode attributes mangled by a Visual Editor.
*/
if (!function_exists ("ws_plugin__s2member_trim_quot_deep"))
	{
		function ws_plugin__s2member_trim_quot_deep ($value = FALSE)
			{
				return is_array ($value) ? array_map ('ws_plugin__s2member_trim_quot_deep', $value) : preg_replace ("(^(&quot;)+|(&quot;)+$)", "", $value);
			}
	}
/*
Determines whether or not this is a Multisite Farm.
With s2Member, this option may also indicate a Multisite Blog Farm.
$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup"
*/
if (!function_exists ("ws_plugin__s2member_is_multisite_farm"))
	{
		function ws_plugin__s2member_is_multisite_farm ()
			{
				return (is_multisite () && ( (is_main_site () && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mms_registration_file"] === "wp-signup") || (defined ("MULTISITE_FARM") && MULTISITE_FARM)));
			}
	}
/*
Determines whether or not this is a Multisite Dashboard blog.
*/
if (!function_exists ("ws_plugin__s2member_is_main_dashboard"))
	{
		function ws_plugin__s2member_is_main_dashboard ()
			{
				global $current_blog; /* Needed for comparison to the Dashboard Blog. */
				/**/
				return (is_multisite () && $current_blog->blog_id == get_site_option ("dashboard_blog"));
			}
	}
/*
Function checks if a post is in a child category.
*/
if (!function_exists ("ws_plugin__s2member_in_descendant_category"))
	{
		function ws_plugin__s2member_in_descendant_category ($cats = FALSE, $post_id = FALSE)
			{
				foreach ((array)$cats as $cat)
					{
						$descendants = get_term_children ((int)$cat, "category");
						if ($descendants && in_category ($descendants, $post_id))
							return true;
					}
				/**/
				return false;
			}
	}
/*
Function retrieves a list of all Category IDs from the database.
*/
if (!function_exists ("ws_plugin__s2member_get_all_category_ids"))
	{
		function ws_plugin__s2member_get_all_category_ids ()
			{
				$ids = get_all_category_ids ();
				/**/
				return (array)$ids;
			}
	}
/*
Function retrieves a list of all Tag IDs from the database.
*/
if (!function_exists ("ws_plugin__s2member_get_all_tag_ids"))
	{
		function ws_plugin__s2member_get_all_tag_ids ()
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				foreach ((array)get_tags () as $tag)
					$ids[] = $tag->term_id;
				/**/
				return (array)$ids;
			}
	}
/*
Function retrieves a list of all Post IDs from the database.
	- Includes Custom Post Types.
*/
if (!function_exists ("ws_plugin__s2member_get_all_post_ids"))
	{
		function ws_plugin__s2member_get_all_post_ids ()
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				$ids = $wpdb->get_col ("SELECT `ID` FROM `" . $wpdb->posts . "` WHERE `post_status` = 'publish' AND `post_type` NOT IN('page','attachment','revision')");
				/**/
				return (array)$ids;
			}
	}
/*
Function retrieves a list of all Page IDs from the database.
*/
if (!function_exists ("ws_plugin__s2member_get_all_page_ids"))
	{
		function ws_plugin__s2member_get_all_page_ids ()
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				$ids = $wpdb->get_col ("SELECT `ID` FROM `" . $wpdb->posts . "` WHERE `post_status` = 'publish' AND `post_type` = 'page'");
				/**/
				return (array)$ids;
			}
	}
/*
Function converts a comma-delimited list of:
	Tag slugs/names/ids - into all IDs.
*/
if (!function_exists ("ws_plugin__s2member_convert_tags_2_ids"))
	{
		function ws_plugin__s2member_convert_tags_2_ids ($tags = FALSE)
			{
				foreach (preg_split ("/[\r\n\t;,]+/", $tags) as $tag)
					{
						if (($tag = trim ($tag)) && is_numeric ($tag))
							{
								$ids[] = $tag;
							}
						else if ($tag && is_string ($tag))
							{
								if (is_object ($term = get_term_by ("name", $tag, "post_tag")))
									{
										$ids[] = $term->term_id;
									}
								else if (is_object ($term = get_term_by ("slug", $tag, "post_tag")))
									{
										$ids[] = $term->term_id;
									}
							}
					}
				/**/
				return (array)$ids;
			}
	}
/*
Function retrieves a list of singular IDs from the database.
- Only returns Posts that require Custom Capabilities.
and ONLY those which are NOT satisfied by $user.
*/
if (!function_exists ("ws_plugin__s2member_get_singular_ids_with_ccaps_req"))
	{
		function ws_plugin__s2member_get_singular_ids_with_ccaps_req ($user = FALSE)
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				if (is_array ($results = $wpdb->get_results ("SELECT `post_id`, `meta_value` FROM `" . $wpdb->postmeta . "` WHERE `meta_key` = 's2member_ccaps_req' AND `meta_value` != ''")))
					{
						foreach ($results as $result) /* Now we need to check Custom Capabilities against $user. */
							{
								if (!$user) /* Optimization. Saves time when NOT even logged into the site. */
									$ids[] = $result->post_id; /* There's no way to satisfy anything here. */
								/**/
								else if (is_array ($ccaps = @unserialize ($result->meta_value)))
									/**/
									foreach ($ccaps as $ccap) /* Test all Custom Capability requirements. */
										if (strlen ($ccap)) /* Quick (empty) check here. */
											if (!$user->has_cap ("access_s2member_ccap_" . $ccap))
												{
													$ids[] = $result->post_id;
													break;
												}
							}
					}
				/**/
				return (array)$ids;
			}
	}
/*
Function retrieves a list of singular IDs from the database.
- Only returns Posts that require Specific Post/Page Access.
& ONLY those which are NOT satisfied by the current Visitor.
*/
if (!function_exists ("ws_plugin__s2member_get_singular_ids_with_sp_req"))
	{
		function ws_plugin__s2member_get_singular_ids_with_sp_req ()
			{
				global $wpdb; /* Need global DB obj. */
				/**/
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"] && is_array ($sps = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])))
					{
						foreach ($sps as $sp) /* Now we need to check access against the current Visitor. */
							{
								if ($sp && !ws_plugin__s2member_sp_access ($sp, "read-only"))
									$ids[] = $sp;
							}
					}
				/**/
				return (array)$ids;
			}
	}
/*
RIJNDAEL 256: two-way encryption/decryption, with a url-safe base64 wrapper.
Includes a built-in fallback on XOR encryption when mcrypt is not available.
*/
if (!function_exists ("ws_plugin__s2member_encrypt"))
	{
		function ws_plugin__s2member_encrypt ($string = FALSE, $key = FALSE)
			{
				$string = (is_string ($string)) ? $string : "";
				/**/
				$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
				$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
				$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
				/**/
				if (function_exists ("mcrypt_encrypt") && in_array ("rijndael-256", mcrypt_list_algorithms ()) && in_array ("cbc", mcrypt_list_modes ()))
					{
						$string = (strlen ($string)) ? "~r2|" . $string : "";
						$key = substr ($key, 0, mcrypt_get_key_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
						$iv = ws_plugin__s2member_random_str_gen (mcrypt_get_iv_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), false);
						$encrypted = mcrypt_encrypt (MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv);
						$encrypted = (strlen ($encrypted)) ? "~r2:" . $iv . "|" . $encrypted : "";
						/**/
						return ($base64 = str_replace (array ("+", "/", "="), array ("-", "_", "."), base64_encode ($encrypted)));
					}
				else /* Fallback on XOR encryption. */
					return ws_plugin__s2member_xencrypt ($string, $key);
			}
	}
/*
RIJNDAEL 256: two-way encryption/decryption, with a url-safe base64 wrapper.
Includes a built-in fallback on XOR encryption when mcrypt is not available.
*/
if (!function_exists ("ws_plugin__s2member_decrypt"))
	{
		function ws_plugin__s2member_decrypt ($base64 = FALSE, $key = FALSE)
			{
				$base64 = (is_string ($base64)) ? $base64 : "";
				/**/
				$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
				$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
				$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
				/**/
				$encrypted = base64_decode (str_replace (array ("-", "_", "."), array ("+", "/", "="), $base64));
				/**/
				if (function_exists ("mcrypt_decrypt") && in_array ("rijndael-256", mcrypt_list_algorithms ()) && in_array ("cbc", mcrypt_list_modes ())/**/
				&& preg_match ("/^~r2\:(.+?)\|/", $encrypted, $v1)) /* Check validity. */
					{
						$encrypted = preg_replace ("/^~r2\:(.+?)\|/", "", $encrypted);
						$key = substr ($key, 0, mcrypt_get_key_size (MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
						$decrypted = mcrypt_decrypt (MCRYPT_RIJNDAEL_256, $key, $encrypted, MCRYPT_MODE_CBC, $v1[1]);
						$decrypted = preg_replace ("/^~r2\|/", "", $decrypted, 1, $v2);
						$decrypted = ($v2) ? $decrypted : ""; /* Check validity. */
						$decrypted = rtrim ($decrypted, "\0\4"); /* Nulls/EOTs. */
						/**/
						return ($string = $decrypted);
					}
				else /* Fallback on XOR decryption. */
					return ws_plugin__s2member_xdecrypt ($base64, $key);
			}
	}
/*
XOR two-way encryption/decryption, with a base64 wrapper.
*/
if (!function_exists ("ws_plugin__s2member_xencrypt"))
	{
		function ws_plugin__s2member_xencrypt ($string = FALSE, $key = FALSE)
			{
				$string = (is_string ($string)) ? $string : "";
				/**/
				$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
				$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
				$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
				/**/
				$string = (strlen ($string)) ? "~xe|" . $string : "";
				/**/
				for ($i = 1, $encrypted = ""; $i <= strlen ($string); $i++)
					{
						$char = substr ($string, $i - 1, 1);
						$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
						$encrypted .= chr (ord ($char) + ord ($keychar));
					}
				/**/
				$encrypted = (strlen ($encrypted)) ? "~xe|" . $encrypted : "";
				/**/
				return ($base64 = str_replace (array ("+", "/", "="), array ("-", "_", "."), base64_encode ($encrypted)));
			}
	}
/*
XOR two-way encryption/decryption, with a base64 wrapper.
*/
if (!function_exists ("ws_plugin__s2member_xdecrypt"))
	{
		function ws_plugin__s2member_xdecrypt ($base64 = FALSE, $key = FALSE)
			{
				$base64 = (is_string ($base64)) ? $base64 : "";
				/**/
				$key = (!is_string ($key) || !strlen ($key)) ? /* For security. */
				$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sec_encryption_key"] : $key;
				$key = (!is_string ($key) || !strlen ($key)) ? wp_salt () : $key;
				/**/
				$encrypted = base64_decode (str_replace (array ("-", "_", "."), array ("+", "/", "="), $base64));
				/**/
				$encrypted = preg_replace ("/^~xe\|/", "", $encrypted, 1, $v1);
				$encrypted = ($v1) ? $encrypted : ""; /* Check validity. */
				/**/
				for ($i = 1, $decrypted = ""; $i <= strlen ($encrypted); $i++)
					{
						$char = substr ($encrypted, $i - 1, 1);
						$keychar = substr ($key, ($i % strlen ($key)) - 1, 1);
						$decrypted .= chr (ord ($char) - ord ($keychar));
					}
				/**/
				$decrypted = preg_replace ("/^~xe\|/", "", $decrypted, 1, $v2);
				$decrypted = ($v2) ? $decrypted : ""; /* Check validity. */
				/**/
				return ($string = $decrypted);
			}
	}
/*
Function generates a random string with letters/numbers/symbols.
*/
if (!function_exists ("ws_plugin__s2member_random_str_gen"))
	{
		function ws_plugin__s2member_random_str_gen ($length = 12, $special_chars = TRUE)
			{
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$chars .= ($special_chars) ? "!@#$%^&*()" : "";
				/**/
				for ($i = 0, $random_str = ""; $i < $length; $i++)
					$random_str .= substr ($chars, mt_rand (0, strlen ($chars) - 1), 1);
				/**/
				return $random_str;
			}
	}
/*
Function that determines the difference between two timestamps. Returns the difference in a human readable format.
Supports: minutes, hours, days, weeks, months, and years. This is an improvement on WordPress® human_time_diff().
This returns an "approximate" time difference. Rounded to the nearest minute, hour, day, week, month, year.
*/
if (!function_exists ("ws_plugin__s2member_approx_time_difference"))
	{
		function ws_plugin__s2member_approx_time_difference ($from = FALSE, $to = FALSE)
			{
				$from = (!$from) ? strtotime ("now") : (int)$from;
				$to = (!$to) ? strtotime ("now") : (int)$to;
				/**/
				if (($difference = abs ($to - $from)) < 3600)
					{
						$m = (int)round ($difference / 60);
						/**/
						$since = ($m < 1) ? "less than a minute" : $since;
						$since = ($m === 1) ? "1 minute" : $since;
						$since = ($m > 1) ? $m . " minutes" : $since;
						$since = ($m >= 60) ? "about 1 hour" : $since;
					}
				else if ($difference >= 3600 && $difference < 86400)
					{
						$h = (int)round ($difference / 3600);
						/**/
						$since = ($h === 1) ? "1 hour" : $since;
						$since = ($h > 1) ? $h . " hours" : $since;
						$since = ($h >= 24) ? "about 1 day" : $since;
					}
				else if ($difference >= 86400 && $difference < 604800)
					{
						$d = (int)round ($difference / 86400);
						/**/
						$since = ($d === 1) ? "1 day" : $since;
						$since = ($d > 1) ? $d . " days" : $since;
						$since = ($d >= 7) ? "about 1 week" : $since;
					}
				else if ($difference >= 604800 && $difference < 2592000)
					{
						$w = (int)round ($difference / 604800);
						/**/
						$since = ($w === 1) ? "1 week" : $since;
						$since = ($w > 1) ? $w . " weeks" : $since;
						$since = ($w >= 4) ? "about 1 month" : $since;
					}
				else if ($difference >= 2592000 && $difference < 31556926)
					{
						$m = (int)round ($difference / 2592000);
						/**/
						$since = ($m === 1) ? "1 month" : $since;
						$since = ($m > 1) ? $m . " months" : $since;
						$since = ($m >= 12) ? "about 1 year" : $since;
					}
				else if ($difference >= 31556926) /* Years. */
					{
						$y = (int)round ($difference / 31556926);
						/**/
						$since = ($y === 1) ? "1 year" : $since;
						$since = ($y > 1) ? $y . " years" : $since;
					}
				/**/
				return $since;
			}
	}
/*
Function converts a form with hidden inputs into a URL.
*/
if (!function_exists ("ws_plugin__s2member_form_whips_2_url"))
	{
		function ws_plugin__s2member_form_whips_2_url ($form = FALSE)
			{
				if (preg_match ("/\<form(.+?)\>/is", $form, $form_attr_m))
					{
						if (preg_match ("/(\s)(action)( ?)(\=)( ?)(['\"])(.+?)(['\"])/i", $form_attr_m[1], $form_action_m))
							{
								if (($url = trim ($form_action_m[7]))) /* Set URL value dynamically. Now we add values. */
									{
										if (preg_match_all ("/(?<!\<\!--)\<input(.+?)\>/is", $form, $input_attr_ms, PREG_SET_ORDER))
											/* Negative look-behind prevents inclusion of commented fields in PayPal® Button Codes. */
											{
												foreach ($input_attr_ms as $input_attr_m) /* Go through each input variable. */
													{
														if (preg_match ("/(\s)(type)( ?)(\=)( ?)(['\"])(hidden)(['\"])/", $input_attr_m[1]))
															{
																if (preg_match ("/(\s)(name)( ?)(\=)( ?)(['\"])(.+?)(['\"])/", $input_attr_m[1], $input_name_m))
																	{
																		if (preg_match ("/(\s)(value)( ?)(\=)( ?)(['\"])(.+?)(['\"])/", $input_attr_m[1], $input_value_m))
																			{
																				$name = trim ($input_name_m[7]);
																				$value = trim (wp_specialchars_decode ($input_value_m[7], ENT_QUOTES));
																				$value = (preg_match ("/^http(s)?\:\/\//i", $value)) ? rawurlencode ($value) : urlencode ($value);
																				$url = add_query_arg ($name, $value, $url);
																			}
																	}
															}
													}
											}
										/**/
										return $url;
									}
							}
					}
				/**/
				return false;
			}
	}
/*
Functions that handles CSS compression routines.
*/
if (!function_exists ("ws_plugin__s2member_compress_css"))
	{
		function ws_plugin__s2member_compress_css ($css = FALSE)
			{
				$c6 = "/(\:#| #)([A-Z0-9]{6})/i";
				$css = preg_replace ("/\/\*(.*?)\*\//s", "", $css);
				$css = preg_replace ("/[\r\n\t]+/", "", $css);
				$css = preg_replace ("/ {2,}/", " ", $css);
				$css = preg_replace ("/ , | ,|, /", ",", $css);
				$css = preg_replace ("/ \> | \>|\> /", ">", $css);
				$css = preg_replace ("/\[ /", "[", $css);
				$css = preg_replace ("/ \]/", "]", $css);
				$css = preg_replace ("/ \!\= | \!\=|\!\= /", "!=", $css);
				$css = preg_replace ("/ \|\= | \|\=|\|\= /", "|=", $css);
				$css = preg_replace ("/ \^\= | \^\=|\^\= /", "^=", $css);
				$css = preg_replace ("/ \$\= | \$\=|\$\= /", "$=", $css);
				$css = preg_replace ("/ \*\= | \*\=|\*\= /", "*=", $css);
				$css = preg_replace ("/ ~\= | ~\=|~\= /", "~=", $css);
				$css = preg_replace ("/ \= | \=|\= /", "=", $css);
				$css = preg_replace ("/ \+ | \+|\+ /", "+", $css);
				$css = preg_replace ("/ ~ | ~|~ /", "~", $css);
				$css = preg_replace ("/ \{ | \{|\{ /", "{", $css);
				$css = preg_replace ("/ \} | \}|\} /", "}", $css);
				$css = preg_replace ("/ \: | \:|\: /", ":", $css);
				$css = preg_replace ("/ ; | ;|; /", ";", $css);
				$css = preg_replace ("/;\}/", "}", $css);
				/**/
				return preg_replace_callback ($c6, "ws_plugin__s2member_compress_css_c3", $css);
			}
	}
if (!function_exists ("ws_plugin__s2member_compress_css_c3"))
	{
		function ws_plugin__s2member_compress_css_c3 ($m = FALSE)
			{
				if ($m[2][0] === $m[2][1] && $m[2][2] === $m[2][3] && $m[2][4] === $m[2][5])
					return $m[1] . $m[2][0] . $m[2][2] . $m[2][4];
				return $m[0];
			}
	}
/*
Functions that highlights PHP, and also Shortcodes.
*/
if (!function_exists ("ws_plugin__s2member_highlight_php"))
	{
		function ws_plugin__s2member_highlight_php ($str = FALSE)
			{
				$str = highlight_string ($str, true); /* Start with PHP syntax highlighting first. */
				/**/
				return preg_replace_callback ("/(\[)(\/?)(_*s2If|s2Get|s2Member-[A-z_0-9\-]+)(.*?)(\])/i", "_ws_plugin__s2member_highlight_php", $str);
			}
		function _ws_plugin__s2member_highlight_php ($m = FALSE)
			{
				return '<span style="color:#164A61;">' . $m[0] . '</span>';
			}
	}
/*
Retrieves a field value. Also supports Custom Fields.
*/
if (!function_exists ("ws_plugin__s2member_get_user_field"))
	{
		function ws_plugin__s2member_get_user_field ($field_id = FALSE, $user_id = FALSE)
			{
				if (is_object ($user = ($user_id) ? new WP_User ($user_id) : wp_get_current_user ()) && ($user_id = $user->ID))
					{
						if (preg_match ("/^(first_name|First Name)$/i", $field_id))
							return $user->first_name;
						/**/
						else if (preg_match ("/^(last_name|Last Name)$/i", $field_id))
							return $user->last_name;
						/**/
						else if (preg_match ("/^(email|E-mail|Email Address|E-mail Address)$/i", $field_id))
							return $user->user_email;
						/**/
						else if (isset ($user->$field_id))
							return $user->$field_id;
						/**/
						else if (is_array ($fields = get_user_option ("s2member_custom_fields", $user_id)))
							return $fields[preg_replace ("/[^a-z0-9]/i", "_", strtolower ($field_id))];
					}
				/**/
				return false;
			}
	}
?>