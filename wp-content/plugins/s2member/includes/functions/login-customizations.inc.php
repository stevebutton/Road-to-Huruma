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
Function for filtering the login logo url.
Attach to: add_filter("login_headerurl");
*/
if (!function_exists ("ws_plugin__s2member_login_header_url"))
	{
		function ws_plugin__s2member_login_header_url ($url = FALSE)
			{
				do_action ("ws_plugin__s2member_before_login_header_url", get_defined_vars ());
				/**/
				$url = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_url"];
				/**/
				return apply_filters ("ws_plugin__s2member_login_header_url", $url, get_defined_vars ());
			}
	}
/*
Function for filtering the login logo title.
Attach to: add_filter("login_headertitle");
*/
if (!function_exists ("ws_plugin__s2member_login_header_title"))
	{
		function ws_plugin__s2member_login_header_title ($title = FALSE)
			{
				do_action ("ws_plugin__s2member_before_login_header_title", get_defined_vars ());
				/**/
				$title = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_title"];
				/**/
				return apply_filters ("ws_plugin__s2member_login_header_title", $title, get_defined_vars ());
			}
	}
/*
Function for creating the styles for the login panel.
Attach to: add_action("login_head");
*/
if (!function_exists ("ws_plugin__s2member_login_header_styles"))
	{
		function ws_plugin__s2member_login_header_styles ()
			{
				$s = ""; /* Initialize here to give hooks a chance. */
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_login_header_styles", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				/* The !important declarations can be disabled here if you need to apply other hard-coded styles. */
				$important = $i = apply_filters ("ws_plugin__s2member_login_header_styles_important", " !important", get_defined_vars ());
				/**/
				$s .= "\n" . '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>' . "\n";
				$s .= '<script type="text/javascript" src="' . get_bloginfo ("wpurl") . '/?ws_plugin__s2member_js_w_globals=1&amp;no-cache=' . urlencode (md5 (mt_rand ())) . '"></script>' . "\n";
				/**/
				$s .= "\n" . '<style type="text/css">' . "\n";
				/**/
				$s .= 'html, body { border: 0' . $i . '; background: none' . $i . '; }' . "\n"; /* Clear existing. */
				$s .= 'html { background-color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . $i . '; }' . "\n";
				$s .= 'html { background-image: url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image"] . ')' . $i . '; }' . "\n";
				$s .= 'html { background-repeat: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_image_repeat"] . $i . '; }' . "\n";
				/**/
				$s .= 'body, body * { font-size: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_size"] . $i . '; }' . "\n";
				$s .= 'body, body * { font-family: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_family"] . $i . '; }' . "\n";
				/**/
				$s .= 'p#backtoblog a, p#backtoblog a:hover, p#backtoblog a:active, p#backtoblog a:focus { color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_color"] . $i . '; text-shadow: 1px 1px 3px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_shadow_color"] . $i . '; top: 15px' . $i . '; left: 15px' . $i . '; padding: 10px' . $i . '; border:1px solid #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . $i . '; background-color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_color"] . $i . '; -moz-border-radius:3px' . $i . '; -webkit-border-radius:3px' . $i . '; border-radius:3px' . $i . '; }' . "\n";
				/**/
				$s .= 'div#login { width: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_width"] . 'px' . $i . '; }' . "\n";
				$s .= 'div#login h1 a { background: url(' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src"] . ') no-repeat top center' . $i . '; }' . "\n";
				$s .= 'div#login h1 a { display: block' . $i . '; width: 100%' . $i . '; height: ' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_logo_src_height"] . 'px' . $i . '; }' . "\n";
				/**/
				$s .= 'div#login form { -moz-box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . $i . '; -webkit-box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . $i . '; box-shadow: 1px 1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . ', -1px -1px 5px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_box_shadow_color"] . $i . '; }' . "\n";
				/**/
				$s .= 'div#login p#nav, div#login p#nav a, div#login p#nav a:hover, div#login p#nav a:active, div#login p#nav a:focus { color: #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_color"] . $i . '; text-shadow: 1px 1px 3px #' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_background_text_shadow_color"] . $i . '; }' . "\n";
				/**/
				$s .= 'div#login form p { margin: 2px 0 16px 0' . $i . '; }' . "\n"; /* Handle margins. */
				$s .= 'div#login form input[type="text"].input, div#login form input[type="password"].input, div#login form input[type="text"].ws-plugin--s2member-custom-reg-field, div#login form input[type="password"].ws-plugin--s2member-custom-reg-field, div#login form textarea.ws-plugin--s2member-custom-reg-field, div#login form select.ws-plugin--s2member-custom-reg-field { font-weight:normal' . $i . '; color:#333333' . $i . '; background:none repeat scroll 0 0 #FBFBFB' . $i . '; border:1px solid #E5E5E5' . $i . '; font-size:' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_field_size"] . $i . '; margin: 0 2% 0 0' . $i . '; padding:3px' . $i . '; width:98%' . $i . '; }' . "\n";
				$s .= 'div#login form input[type="checkbox"].ws-plugin--s2member-custom-reg-field, div#login form input[type="radio"].ws-plugin--s2member-custom-reg-field { vertical-align:middle' . $i . '; }' . "\n";
				$s .= 'div#login form select.ws-plugin--s2member-custom-reg-field > option { font-size:' . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_reg_font_field_size"] . $i . '; }' . "\n";
				$s .= 'div#login form label.ws-plugin--s2member-custom-reg-field-op-l { vertical-align:middle' . $i . '; font-size:90%' . $i . '; }' . "\n";
				$s .= 'div#login form select.ws-plugin--s2member-custom-reg-field { width:100%' . $i . '; }' . "\n";
				/**/
				$s .= 'div#login form p.submit { margin-bottom: 0' . $i . '; }' . "\n";
				$s .= 'div#login form input[type="submit"], div#login form input[type="submit"]:hover, div#login form input[type="submit"]:active, div#login form input[type="submit"]:focus { color: #666666' . $i . '; text-shadow: 2px 2px 5px #EEEEEE' . $i . '; border: 1px solid #999999' . $i . '; background: #FBFBFB' . $i . '; padding: 5px' . $i . '; -moz-border-radius: 3px' . $i . '; -webkit-border-radius: 3px' . $i . '; border-radius: 3px' . $i . '; }' . "\n";
				$s .= 'div#login form input[type="submit"]:hover, div#login form input[type="submit"]:active, div#login form input[type="submit"]:focus { color: #000000' . $i . '; text-shadow: 2px 2px 5px #CCCCCC' . $i . '; border-color: #000000' . $i . '; }' . "\n";
				$s .= 'div#login form#lostpasswordform { padding-bottom: 16px' . $i . '; } div#login form#lostpasswordform p.submit { float: none' . $i . '; } div#login form#lostpasswordform input[type="submit"] { width: 100%' . $i . '; }' . "\n";
				$s .= 'div#login form#registerform { padding-bottom: 16px' . $i . '; } div#login form#registerform p.submit { float: none' . $i . '; margin-top: -10px' . $i . '; } div#login form#registerform input[type="submit"] { width: 100%' . $i . '; }' . "\n";
				/**/
				$s .= 'div#login form#registerform p#reg_passmail { font-style: italic' . $i . '; }' . "\n";
				if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"])
					$s .= 'p#reg_passmail { display: none' . $i . '; }' . "\n";
				/**/
				$s .= '</style>' . "\n\n";
				/**/
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_during_login_header_styles", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				echo apply_filters ("ws_plugin__s2member_login_header_styles", $s, get_defined_vars ());
				/**/
				do_action ("ws_plugin__s2member_after_login_header_styles", get_defined_vars ());
				/**/
				return;
			}
	}
?>