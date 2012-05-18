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
PayPal® Button Generating page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member / PayPal® Buttons</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_paypal_buttons_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_level1_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_level1_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #1 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-level1-buttons-section">' . "\n";
		echo '<h3>Button Code Generator For Level #1 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level1_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level1-shortcode">' . "\n";
		echo 'Button Code<br />For Level #1:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level1-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p id="ws-plugin--s2member-level1-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level1-trial-period" value="0" size="6" /> <select id="ws-plugin--s2member-level1-trial-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-trial-terms.html") . '</select> @ $<input type="text" id="ws-plugin--s2member-level1-trial-amount" value="0.00" size="4" /></p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level1-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level1-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level1-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-regular-terms.html") . '</select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\\n\\nIn addition. The Shortcode below, provided by s2Member; supports an image attribute: image=\\\'\\\'default\\\'\\\'. This can be changed to a full URL, pointing to a custom image of your own; instead of the default PayPal® Button image.\'); return false;" tabindex="-1">[?]</a>: <input type="text" id="ws-plugin--s2member-level1-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level1-currency">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-currencies.html") . '</select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level1\');" class="button-primary" /></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-level1-desc" value="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]) . ' description and pricing details here." size="73" /></p>' . "\n";
		echo '<p' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;" tabindex="-1">[?]</a> <input type="text" id="ws-plugin--s2member-level1-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level1_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-checkout-button-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level1-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level1-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-checkout-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("url"))), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_return=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_level1_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_level2_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_level2_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #2 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-level2-buttons-section">' . "\n";
		echo '<h3>Button Code Generator For Level #2 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level2_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level2-shortcode">' . "\n";
		echo 'Button Code<br />For Level #2:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level2-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p id="ws-plugin--s2member-level2-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level2-trial-period" value="0" size="6" /> <select id="ws-plugin--s2member-level2-trial-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-trial-terms.html") . '</select> @ $<input type="text" id="ws-plugin--s2member-level2-trial-amount" value="0.00" size="4" /></p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level2-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level2-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level2-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-regular-terms.html") . '</select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\\n\\nIn addition. The Shortcode below, provided by s2Member; supports an image attribute: image=\\\'\\\'default\\\'\\\'. This can be changed to a full URL, pointing to a custom image of your own; instead of the default PayPal® Button image.\'); return false;" tabindex="-1">[?]</a>: <input type="text" id="ws-plugin--s2member-level2-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level2-currency">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-currencies.html") . '</select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level2\');" class="button-primary" /></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-level2-desc" value="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]) . ' description and pricing details here." size="73" /></p>' . "\n";
		echo '<p' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;" tabindex="-1">[?]</a> <input type="text" id="ws-plugin--s2member-level2-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level2_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-checkout-button-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("2")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level2-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level2-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-checkout-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("2")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("url"))), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_return=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_level2_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_level3_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_level3_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #3 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-level3-buttons-section">' . "\n";
		echo '<h3>Button Code Generator For Level #3 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level3_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level3-shortcode">' . "\n";
		echo 'Button Code<br />For Level #3:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level3-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p id="ws-plugin--s2member-level3-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level3-trial-period" value="0" size="6" /> <select id="ws-plugin--s2member-level3-trial-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-trial-terms.html") . '</select> @ $<input type="text" id="ws-plugin--s2member-level3-trial-amount" value="0.00" size="4" /></p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level3-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level3-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level3-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-regular-terms.html") . '</select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\\n\\nIn addition. The Shortcode below, provided by s2Member; supports an image attribute: image=\\\'\\\'default\\\'\\\'. This can be changed to a full URL, pointing to a custom image of your own; instead of the default PayPal® Button image.\'); return false;" tabindex="-1">[?]</a>: <input type="text" id="ws-plugin--s2member-level3-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level3-currency">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-currencies.html") . '</select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level3\');" class="button-primary" /></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-level3-desc" value="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]) . ' description and pricing details here." size="73" /></p>' . "\n";
		echo '<p' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;" tabindex="-1">[?]</a> <input type="text" id="ws-plugin--s2member-level3-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level3_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-checkout-button-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("3")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level3-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level3-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-checkout-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("3")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("url"))), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_return=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_level3_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_level4_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_level4_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Buttons For Level #4 Access">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-level4-buttons-section">' . "\n";
		echo '<h3>Button Code Generator For Level #4 Access</h3>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Membership Level that you plan to offer. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. Member accounts will be activated instantly, in an automated fashion. When you, or a Member, cancels their membership, or fails to make payments on time, s2Member will automatically terminate their membership privileges. s2Member makes extensive use of the PayPal® IPN service. s2Member receives updates from PayPal® behind-the-scene.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Membership Options Page. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level4_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-level4-shortcode">' . "\n";
		echo 'Button Code<br />For Level #4:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-level4-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p id="ws-plugin--s2member-level4-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-level4-trial-period" value="0" size="6" /> <select id="ws-plugin--s2member-level4-trial-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-trial-terms.html") . '</select> @ $<input type="text" id="ws-plugin--s2member-level4-trial-amount" value="0.00" size="4" /></p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-level4-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-level4-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-level4-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-regular-terms.html") . '</select></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\\n\\nIn addition. The Shortcode below, provided by s2Member; supports an image attribute: image=\\\'\\\'default\\\'\\\'. This can be changed to a full URL, pointing to a custom image of your own; instead of the default PayPal® Button image.\'); return false;" tabindex="-1">[?]</a>: <input type="text" id="ws-plugin--s2member-level4-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-level4-currency">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-currencies.html") . '</select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'level4\');" class="button-primary" /></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-level4-desc" value="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]) . ' description and pricing details here." size="73" /></p>' . "\n";
		echo '<p' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;" tabindex="-1">[?]</a> <input type="text" id="ws-plugin--s2member-level4-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_level4_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-checkout-button-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("4")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-level4-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-level4-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-checkout-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("4")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("url"))), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_return=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_level4_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_modification_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_modification_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Subscr Modification Buttons">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-modification-buttons-section">' . "\n";
		echo '<h3>Button Code Generator For Subscription Modifications</h3>' . "\n";
		echo '<p>If you\'d like to give your Members ( and/or your Free Subscribers ) the ability to modify their billing plan, by switching to a more expensive option, or a less expensive option; generate a new PayPal® Modification Button here. Configure the updated Level, pricing, terms, etc. Then, make that new Modification Button available to Members who are logged into their existing account with you. For example, you might want to insert a "Level #2" Upgrade Button into your Login Welcome Page, which would up-sell existing Level #1 Members to a more expensive plan that you offer.</p>' . "\n";
		echo '<p><em><strong>*Modification Process*</strong> When you send a Member to PayPal® using a Subscription Modification Button, PayPal® will ask them to login. Once they\'re logged in, instead of being able to signup for a new membership, PayPal® will provide them with the ability to upgrade and/or downgrade their existing membership with you, by allowing them to switch to the Membership Plan that was specified in the Subscription Modification Button. PayPal® handles this nicely, and you\'ll be happy to know that s2Member has been pre-configured to deal with this scenario as well, so that everything remains automated. Their Membership Access Level will either be promoted, or demoted, based on the actions they took at PayPal® during the modification process. Once an existing Member completes their Subscription Modification at PayPal®, they\'ll be brought back to their Login Welcome Page, instead of the registration screen.</em></p>' . "\n";
		echo '<p><em><strong>*Also Works For Free Subscribers*</strong> Although a Free Subscriber does not have an existing PayPal® Subscription, s2Member is capable of adapting to this scenario gracefully. Just make sure that your existing Free Subscribers ( the ones who wish to upgrade ) pay for their Membership through a Modification Button generated by s2Member. That will allow them to continue using their existing account with you. In other words, they can keep their existing Username ( and anything already associated with that Username ), rather than being forced to re-register after checkout.</em></p>' . "\n";
		echo '<p><em><strong>*Make It More User-Friendly*</strong> You can make the Subscription Modification Process, more user-friendly, by setting up a <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can tell s2Member to use that Page Style whenever you generate your Button Code.\'); return false;">Custom Page Style at PayPal®</a>, specifically for Subscription Modification Buttons. Use a custom header image, with a brief explanation to the Customer. Something like, "Log into PayPal®", "You can Modify your Subscription!".</em></p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your Login Welcome Page, or wherever you feel it would be most appropriate. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_modification_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-modification-shortcode">' . "\n";
		echo 'Button Code<br />For Modifications:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-modification-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p>Modification: <select id="ws-plugin--s2member-modification-level">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-modification-levels.html") . '</select></p>' . "\n";
		echo '<p id="ws-plugin--s2member-modification-trial-line">I\'ll offer the first <input type="text" id="ws-plugin--s2member-modification-trial-period" value="0" size="6" /> <select id="ws-plugin--s2member-modification-trial-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-trial-terms.html") . '</select> @ $<input type="text" id="ws-plugin--s2member-modification-trial-amount" value="0.00" size="4" /></p>' . "\n";
		echo '<p><span id="ws-plugin--s2member-modification-trial-then">Then, </span>I want to charge: $<input type="text" id="ws-plugin--s2member-modification-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-modification-term">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-membership-regular-terms.html") . '</select><span id="ws-plugin--s2member-modification-20p-rule"><br /><small>** Watch out for <a href="https://www.x.com/thread/41748" target="_blank" rel="external">the 20% rule</a>. Additional details on the 20% rule are <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_WPRecurringPayments#id086530108PM__id08653060UE6" target="_blank" rel="external">documented here</a>.</small></span></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\\n\\nIn addition. The Shortcode below, provided by s2Member; supports an image attribute: image=\\\'\\\'default\\\'\\\'. This can be changed to a full URL, pointing to a custom image of your own; instead of the default PayPal® Button image.\'); return false;" tabindex="-1">[?]</a>: <input type="text" id="ws-plugin--s2member-modification-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-modification-currency">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-currencies.html") . '</select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalButtonGenerate(\'modification\');" class="button-primary" /></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-modification-desc" value="Description and pricing details here." size="73" /></p>' . "\n";
		echo '<p' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '>Custom Capabilities ( comma delimited ) <a href="#" onclick="alert(\'Optional. This is VERY advanced. For full details, see:\\ns2Member -> API Scripting -> Custom Capabilities.\'); return false;" tabindex="-1">[?]</a> <input type="text" id="ws-plugin--s2member-modification-ccaps" size="40" maxlength="125" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_modification_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-checkout-button-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("2")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%% /", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/\/]$/", 'modify="1" /]', $ws_plugin__s2member_temp_s); /* Adds modify="1" to the end of the Shortcode. */
		echo '<input id="ws-plugin--s2member-modification-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-modification-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-checkout-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ('/name\="modify" value\="(.*?)"/', 'name="modify" value="1"', $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level%%/", ws_plugin__s2member_esc_ds (esc_attr ("2")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%level_label%% /", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("url"))), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_return=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_modification_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_cancellation_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_cancellation_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Subscr Cancellation Buttons">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-cancellation-buttons-section">' . "\n";
		echo '<h3>One Button Does It All For Cancellations ( copy/paste )</h3>' . "\n";
		echo '<p>Since all recurring charges are associated with a PayPal® Subscription; and every PayPal® Subscription is associated with a PayPal® Account; your Members will always have a PayPal® Account of their own, which is tied to their Membership with you. So... a Member can simply log into their own PayPal® account and cancel their Subscription(s) with you at anytime, all on their own. However, some Customers do not realize this. So, if you would like to make it clearer ( easier ) for Members to cancel their own Subscription(s), you can provide this Cancellation Button for them on your Login Welcome Page, or somewhere in the support section of your website. Note... you don\'t have to use this Cancellation Button at all, if you don\'t want to. It\'s completely optional.</p>' . "\n";
		echo '<p><em><strong>*Cancellation Process*</strong> Very simple. A Member clicks the Cancellation Button. PayPal® asks them to log into their PayPal® account. Once they\'re logged in, PayPal® will display a list of all active Subscriptions they have with you. They choose which ones they want to cancel, and s2Member is notified silently behind-the-scene, through the PayPal® IPN service.</em></p>' . "\n";
		echo '<p><em><strong>*Understanding Cancellations*</strong> It\'s important to realize that a Cancellation is not an EOT ( End Of Term ). All that happens during a Cancellation event, is that billing is stopped, and it\'s understood that the Customer is going to lose access, at some point in the future. This does NOT mean, that access will be revoked immediately. A separate EOT event will automatically handle a (demotion or deletion) later, at the appropriate time; which could be several days, or even a year after the Cancellation took place.</em></p>' . "\n";
		echo '<p><em><strong>*Some Hairy Details*</strong> There might be times whenever you notice that a Member\'s Subscription has been cancelled through PayPal®... but, s2Member continues allowing the User access to your site as a paid Member. Please don\'t be confused by this... in 99.9% of these cases, the reason for this is legitimate. s2Member will only remove the User\'s Membership privileges when an EOT ( End Of Term ) is processed, a refund occurs, a chargeback occurs, or when a cancellation occurs - which would later result in a delayed Auto-EOT by s2Member. s2Member will not process an EOT ( End Of Term ) until the User has completely used up the time they paid for. In other words, if a User signs up for a monthly Subscription on Jan 1st, and then cancels their Subscription on Jan 15th; technically, they should still be allowed to access the site for another 15 days, and then on Feb 1st, the time they paid for has completely elapsed. At that time, s2Member will remove their Membership privileges; by either demoting them to a Free Subscriber, or deleting their account from the system ( based on your configuration ). s2Member also calculates one extra day ( 24 hours ) into its equation, just to make sure access is not removed sooner than a Customer might expect.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_cancellation_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-cancellation-shortcode">' . "\n";
		echo 'Button Code<br />For Cancellations:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-cancellation-button-prev">' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-cancellation-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo preg_replace ("/\<a/", '<a target="_blank"', $ws_plugin__s2member_temp_s);
		echo '</div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p>No configuration necessary.</p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_cancellation_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-cancellation-button-shortcode.html"));
		echo '<input id="ws-plugin--s2member-cancellation-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-cancellation-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-cancellation-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_cancellation_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_sp_buttons", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_sp_buttons", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Specific Post/Page (Buy Now) Buttons">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-buttons-section">' . "\n";
		echo '<h3>Button Code Generator For Specific Post/Page Buttons</h3>' . "\n";
		echo '<p>s2Member now supports an additional layer of functionality ( very powerful ), which allows you to sell access to specific Posts/Pages that you\'ve created in WordPress®. Specific Post/Page Access works independently from Member Level Access. That is, you can sell an unlimited number of Posts/Pages using "Buy Now" Buttons, and your Customers will NOT be required to have a Membership Account with your site in order to receive access. If they are already a Member, that\'s fine, but they won\'t need to be.</p>' . "\n";
		echo '<p>In other words, Customers will NOT need to login, just to receive access to the Specific Post/Page they purchased access to. s2Member will immediately redirect the Customer to the Specific Post/Page after checkout is completed successfully. An email is also sent to the Customer with a link ( see: <code>s2Member -> PayPal® Options -> Specific Post/Page Email</code> ). Authentication is handled automatically through self-expiring links, good for 72 hours by default.</p>' . "\n";
		echo '<p>Specific Post/Page Access, is sort of like selling a product. Only, instead of shipping anything to the Customer, you just give them access to a specific Post/Page on your site; one that you created in WordPress®. A Specific Post/Page that is protected by s2Member, might contain a download link for your eBook, access to file &amp; music downloads, access to additional support services, and the list goes on and on. The possibilities with this are endless; as long as your digital product can be delivered through access to a WordPress® Post/Page that you\'ve created. To protect Specific Posts/Pages, please see: <code>s2Member -> General Options -> Specific Post/Page Access Restrictions</code>. Once you\'ve configured your Specific Post/Page Restrictions, those Posts/Pages will be available in the menus below.</p>' . "\n";
		echo '<p>Very simple. All you do is customize the form fields provided, for each Post/Page that you plan to sell. Then press (Generate Button Code). These special PayPal® Buttons are customized to work with s2Member seamlessly. You can even Package Additional Posts/Pages together into one transaction.</p>' . "\n";
		echo '<p><em>* Buttons are NOT saved here. This is only a Button Generator. Once you\'ve generated your Button, copy/paste it into your WordPress® Editor, wherever you feel it would be most appropriate. If you lose your Button Code, you\'ll need to come back &amp; re-generate a new one. If you\'re in Sandbox Test-Mode, and you\'re NOT using the Shortcode Format, please remember to come back and re-generate your Buttons before you go live.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_sp_buttons", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-sp-shortcode">' . "\n";
		echo 'Button Code<br />Specific Posts/Pages:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-sp-button-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p><select id="ws-plugin--s2member-sp-leading-id">' . "\n";
		echo '<option value="">&mdash; Select a Leading Post/Page that you\'ve protected &mdash;</option>' . "\n";
		$ws_plugin__s2member_temp_a_pp = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"]) ?/**/
		array_merge ((array)get_posts ("include=" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"]),/**/
		(array)get_pages ("include=" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["specific_ids"])) : array ();
		foreach (($ws_plugin__s2member_temp_a = $ws_plugin__s2member_temp_a_pp) as $ws_plugin__s2member_temp_o)
			if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
				if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
						if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])))
							if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])))
								if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])))
									if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])))
										echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '">' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		/**/
		echo '</select> <a href="#" onclick="alert(\'Required. The Leading Post/Page, is what your Customers will land on after checkout.\n\n*Tip* If there are no Posts/Pages in the menu, it\\\'s because you\\\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.\'); return false;" tabindex="-1">[?]</a></p>' . "\n";
		/**/
		echo '<p><select id="ws-plugin--s2member-sp-additional-ids" multiple="multiple" style="height:100px;">' . "\n";
		echo '<optgroup label="&mdash; Package Additional Posts/Pages that you\'ve protected &mdash;">' . "\n";
		foreach (($ws_plugin__s2member_temp_a = $ws_plugin__s2member_temp_a_pp) as $ws_plugin__s2member_temp_o)
			if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
				if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
						if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])))
							if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])))
								if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])))
									if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])))
										echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '">' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		/**/
		echo '</optgroup></select> <a href="#" onclick="alert(\'Hold down your `Ctrl` key to select multiples.\\n\\nOptional. If you include Additional Posts/Pages, Customers will still land on your Leading Post/Page; BUT, they\\\'ll ALSO have access to some Additional Posts/Pages that you\\\'ve protected. This gives you the ability to create Post/Page Packages.\\n\\nIn other words, a Customer is sold a Specific Post/Page ( they\\\'ll land on your Leading Post/Page after checkout ), which might contain links to some other Posts/Pages that you\\\'ve packaged together under one transaction.\\n\\nBundling Additional Posts/Pages into one Package, authenticates the Customer for access to the Additional Posts/Pages automatically ( e.g. only one Access Link is needed, and s2Member generates this automatically ). However, you will STILL need to design your Leading Post/Page ( which is what a Customer will actually land on ), with links pointing to the other Posts/Pages. This way your Customers will have clickable links to everything they\\\'ve paid for.\\n\\n*Quick Summary* s2Member sends Customers to your Leading Post/Page, and also authenticates them for access to any Additional Posts/Pages automatically. You handle it from there.\\n\\n*Tip* If there are no Posts/Pages in this menu, it\\\'s because you\\\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.\'); return false;" tabindex="-1">[?]</a></p>' . "\n";
		/**/
		echo '<p>I want to charge: $<input type="text" id="ws-plugin--s2member-sp-amount" value="0.01" size="4" /> / <select id="ws-plugin--s2member-sp-hours">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-sp-hours.html") . '</select></p>' . "\n";
		echo '<p>Description: <input type="text" id="ws-plugin--s2member-sp-desc" value="Description and pricing details here." size="68" /></p>' . "\n";
		echo '<p>Checkout Page Style <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can enter that Page Style here.\\n\\nIn addition. The Shortcode below, provided by s2Member; supports an image attribute: image=\\\'\\\'default\\\'\\\'. This can be changed to a full URL, pointing to a custom image of your own; instead of the default PayPal® Button image.\'); return false;" tabindex="-1">[?]</a>: <input type="text" id="ws-plugin--s2member-sp-page-style" value="paypal" size="18" /> <select id="ws-plugin--s2member-sp-currency">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-currencies.html") . '</select> <input type="button" value="Generate Button Code" onclick="ws_plugin__s2member_paypalSpButtonGenerate();" class="button-primary" /></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<td colspan="2">' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_sp_buttons_before_shortcode", get_defined_vars ());
		echo '<strong>WordPress® Shortcode:</strong> ( recommended for both the WordPress® Visual &amp; HTML Editors )<br />' . "\n";
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/shortcodes/paypal-sp-checkout-button-shortcode.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		echo '<input id="ws-plugin--s2member-sp-shortcode" type="text" value="' . format_to_edit ($ws_plugin__s2member_temp_s) . '" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;" />' . "\n";
		/**/
		echo '<div' . ( (is_multisite () && ws_plugin__s2member_is_multisite_farm () && !is_main_site ()) ? ' style="display:none;"' : '') . '><br />' . "\n";
		echo '<strong>Resulting PayPal® Button Code:</strong> ( ultimately, your Shortcode will produce this snippet )<br />' . "\n";
		echo '<textarea id="ws-plugin--s2member-sp-button" rows="8" wrap="off" onclick="this.select ();" style="font-family:Consolas, monospace; width:99%;">';
		$ws_plugin__s2member_temp_s = trim (file_get_contents (dirname (dirname (__FILE__)) . "/templates/buttons/paypal-sp-checkout-button.html"));
		$ws_plugin__s2member_temp_s = preg_replace ("/%%endpoint%%/", ws_plugin__s2member_esc_ds (esc_attr (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%paypal_business%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_business"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%cancel_return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("url"))), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%notify_url%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_notify=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%return%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl") . "/?s2member_paypal_return=1")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%custom%%/", ws_plugin__s2member_esc_ds (esc_attr ($_SERVER["HTTP_HOST"])), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%images%%/", ws_plugin__s2member_esc_ds (esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . "/images")), $ws_plugin__s2member_temp_s);
		$ws_plugin__s2member_temp_s = preg_replace ("/%%wpurl%%/", ws_plugin__s2member_esc_ds (esc_attr (get_bloginfo ("wpurl"))), $ws_plugin__s2member_temp_s);
		echo format_to_edit ($ws_plugin__s2member_temp_s);
		echo '</textarea><br />' . "\n";
		echo '&uarr; Use this more advanced Code if you\'re building a theme or plugin that integrates with s2Member.<br />' . "\n";
		echo '&uarr; <em>This <span class="ws-menu-page-hilite">may contain PHP code too</span>; so be careful if you use this.</em>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_sp_buttons", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_sp_links", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_sp_links", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="PayPal® Specific Post/Page Access Links">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-sp-links-section">' . "\n";
		echo '<h3>Specific Post/Page Link Generator ( for Customer Service )</h3>' . "\n";
		echo '<p>s2Member automatically generates Specific Post/Page Links for your Customers after checkout, and also sends them a link in a Confirmation Email. However, if you ever need to deal with a Customer Service issue that requires a new Specific Post/Page Link to be created manually, you can use this tool for that.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_sp_links", get_defined_vars ());
		/**/
		echo '<table class="form-table">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr>' . "\n";
		/**/
		echo '<th class="ws-menu-page-th-side">' . "\n";
		echo '<label for="ws-plugin--s2member-sp-link-leading-id">' . "\n";
		echo 'Access Link<br />For Customer Service:<br /><br />' . "\n";
		echo '<div id="ws-plugin--s2member-sp-link-prev"></div>' . "\n";
		echo '</label>' . "\n";
		echo '</th>' . "\n";
		/**/
		echo '<td>' . "\n";
		echo '<form onsubmit="return false;">' . "\n";
		echo '<p><select id="ws-plugin--s2member-sp-link-leading-id">' . "\n";
		echo '<option value="">&mdash; Select a Leading Post/Page that you\'ve protected &mdash;</option>' . "\n";
		foreach (($ws_plugin__s2member_temp_a = $ws_plugin__s2member_temp_a_pp) as $ws_plugin__s2member_temp_o)
			if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
				if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
						if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])))
							if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])))
								if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])))
									if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])))
										echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '">' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		/**/
		echo '</select> <a href="#" onclick="alert(\'Required. The Leading Post/Page, is what your Customers will land on after checkout.\n\n*Tip* If there are no Posts/Pages in the menu, it\\\'s because you\\\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.\'); return false;" tabindex="-1">[?]</a></p>' . "\n";
		/**/
		echo '<p><select id="ws-plugin--s2member-sp-link-additional-ids" multiple="multiple" style="height:100px;">' . "\n";
		echo '<optgroup label="&mdash; Package Additional Posts/Pages that you\'ve protected &mdash;">' . "\n";
		foreach (($ws_plugin__s2member_temp_a = $ws_plugin__s2member_temp_a_pp) as $ws_plugin__s2member_temp_o)
			if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
				if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
					if ($ws_plugin__s2member_temp_o->ID != $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
						if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"])))
							if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"])))
								if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"])))
									if (!in_array ($ws_plugin__s2member_temp_o->ID, preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"])))
										echo '<option value="' . esc_attr ($ws_plugin__s2member_temp_o->ID) . '">' . esc_html ($ws_plugin__s2member_temp_o->post_title) . '</option>' . "\n";
		/**/
		echo '</optgroup></select> <a href="#" onclick="alert(\'Hold down your `Ctrl` key to select multiples.\\n\\nOptional. If you include Additional Posts/Pages, Customers will still land on your Leading Post/Page; BUT, they\\\'ll ALSO have access to some Additional Posts/Pages that you\\\'ve protected. This gives you the ability to create Post/Page Packages.\\n\\nIn other words, a Customer is sold a Specific Post/Page ( they\\\'ll land on your Leading Post/Page after checkout ), which might contain links to some other Posts/Pages that you\\\'ve packaged together under one transaction.\\n\\nBundling Additional Posts/Pages into one Package, authenticates the Customer for access to the Additional Posts/Pages automatically ( e.g. only one Access Link is needed, and s2Member generates this automatically ). However, you will STILL need to design your Leading Post/Page ( which is what a Customer will actually land on ), with links pointing to the other Posts/Pages. This way your Customers will have clickable links to everything they\\\'ve paid for.\\n\\n*Quick Summary* s2Member sends Customers to your Leading Post/Page, and also authenticates them for access to any Additional Posts/Pages automatically. You handle it from there.\\n\\n*Tip* If there are no Posts/Pages in this menu, it\\\'s because you\\\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.\'); return false;" tabindex="-1">[?]</a></p>' . "\n";
		/**/
		echo '<p><select id="ws-plugin--s2member-sp-link-hours">' . file_get_contents (dirname (dirname (__FILE__)) . "/templates/options/paypal-sp-hours.html") . '</select> <input type="button" value="Generate Access Link" onclick="ws_plugin__s2member_paypalSpLinkGenerate();" class="button-primary" /> <img id="ws-plugin--s2member-sp-link-loading" src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/ajax-loader.gif" alt="" style="display:none;" /></p>' . "\n";
		echo '<p id="ws-plugin--s2member-sp-link" style="font-family:Consolas, monospace; display:none;"></p>' . "\n";
		echo '</form>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_sp_links", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_display_shortcode_attrs", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_before_shortcode_attrs", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Shortcode Attributes ( Explained )">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-shortcode-attrs-section">' . "\n";
		echo '<h3>Shortcode Attributes ( Explained In Full Detail )</h3>' . "\n";
		echo '<p>When you generate a Button Code, s2Member will make a <a href="http://codex.wordpress.org/Shortcode_API#Overview" target="_blank" rel="external">Shortcode</a> available to you. Like most Shortcodes for WordPress®, s2Member reads Attributes in your Shortcode. These Attributes will be pre-configured by one of s2Member\'s Button Generators automatically; so there really is nothing more you need to do. However, many site owners like to know exactly how these Shortcode Attributes work. Below, is a brief overview of each possible Shortcode Attribute.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_during_shortcode_attrs", get_defined_vars ());
		/**/
		echo '<table class="form-table" style="margin-top:0;">' . "\n";
		echo '<tbody>' . "\n";
		echo '<tr style="padding-top:0;">' . "\n";
		/**/
		echo '<td style="padding-top:0;">' . "\n";
		echo '<ul>' . "\n";
		echo '<li><code>image="default"</code> Button Image Location. Possible values: <code>default</code> = use the default PayPal® Button, <code>http://...</code> = location of your custom Image.</li>' . "\n";
		echo '<li><code>output="button"</code> Output Type. Possible values: <code>button</code> = PayPal® Button w/hidden inputs, <code>anchor</code> = PayPal® Button (  &lt;a&gt; anchor tag ) URL w/ ?query string, <code>url</code> = raw URL w/ ?query string.</li>' . "\n";
		echo '<li><code>level="1"</code> Membership Level [1-4]. Only valid for Buttons providing Membership Level [1-4] Access.</li>' . "\n";
		echo '<li><code>ccaps="music,videos"</code> A comma-delimited list of Custom Capabilities. Only valid w/ Membership Level Access.</li>' . "\n";
		echo '<li><code>desc="Gold Membership"</code> A brief purchase Description. Not valid when <code>cancel="1"</code>.</li>' . "\n";
		echo '<li><code>ps="paypal"</code> PayPal® checkout Page Style. Not valid when <code>cancel="1"</code>.</li>' . "\n";
		echo '<li><code>cc="USD"</code> 3 character Currency Code. Not valid when <code>cancel="1"</code>.</li>' . "\n";
		echo '<li><code>ns="1"</code> The <em>no_shipping</em> directive. Possible values: <code>0</code> = prompt for an address, but do not require one, <code>1</code> = do not prompt for a shipping address, <code>2</code> = prompt for an address, and require one. Not valid when <code>cancel="1"</code>.</li>' . "\n";
		echo '<li><code>custom="' . $_SERVER["HTTP_HOST"] . '"</code> must start with your domain. Additional values can be piped in ( ex: <code>custom="' . $_SERVER["HTTP_HOST"] . '|cv1|cv2|cv3|etc"</code> ). Not valid when <code>cancel="1"</code>.</li>' . "\n";
		echo '<li><code>ta="0.00"</code> Trial Amount. Only valid w/ Membership Level Access. Must be <code>0</code> when <code>rt="L"</code> or when <code>rr="BN"</code>.</li>' . "\n";
		echo '<li><code>tp="0"</code> Trial Period. Only valid w/ Membership Level Access. Must be <code>0</code> when <code>rt="L"</code> or when <code>rr="BN"</code>.</li>' . "\n";
		echo '<li><code>tt="D"</code> Trial Term. Only valid w/ Membership Level Access. Possible values: <code>D</code> = Days, <code>W</code> = Weeks, <code>M</code> = Months, <code>Y</code> = Years.</li>' . "\n";
		echo '<li><code>ra="0.01"</code> Regular, Buy Now, and/or Recurring Amount. Must be >= <code>0.01</code>. Not valid when <code>cancel="1"</code>.</li>' . "\n";
		echo '<li><code>rp="1"</code> Regular Period. Only valid w/ Membership Level Access. Must be >= <code>1</code> ( ex: <code>1</code> Week, <code>2</code> Months, <code>1</code> Month, <code>3</code> Days ).</li>' . "\n";
		echo '<li><code>rt="M"</code> Regular Term. Only valid w/ Membership Level Access. Possible values: <code>D</code> = Days, <code>W</code> = Weeks, <code>M</code> = Months, <code>Y</code> = Years, <code>L</code> = Lifetime.</li>' . "\n";
		echo '<li><code>rr="1"</code> Recurring directive. Only valid w/ Membership Level Access. Possible values: <code>0</code> = non-recurring "Subscription" with possible Trial Period for free, or at a different Trial Amount; <code>1</code> = recurring "Subscription" with possible Trial Period for free, or at a different Trial Amount; <code>BN</code> = non-recurring "Buy Now" functionality, no Trial Period possible.</li>' . "\n";
		echo '<li><code>modify="0"</code> Modification directive. Only valid w/ Membership Level Access. Possible values: <code>0</code> = allows Customers to only create a new Subscription, <code>1</code> = allows Customers to modify their current Subscription or sign up for a new one, <code>2</code> = allows Customers to only modify their current Subscription.</li>' . "\n";
		echo '<li><code>cancel="0"</code> Cancellation Button. Only valid w/ Membership Level Access. Possible values: <code>0</code> = this is NOT a Cancellation Button, <code>1</code> = this IS a Cancellation Button.</li>' . "\n";
		echo '<li><code>sp="0"</code> Specific Post/Page Button. Possible values: <code>0</code> = this is NOT a Specific Post/Page Access Button, <code>1</code> = this IS a Specific Post/Page Access Button.</li>' . "\n";
		echo '<li><code>ids="14"</code> A Post/Page ID#, or a comma-delimited list of IDs. Only valid when <code>sp="1"</code> for Specific Post/Page Access.</li>' . "\n";
		echo '<li><code>exp="72"</code> Access Expires ( in hours ). Only valid when <code>sp="1"</code> for Specific Post/Page Access.</li>' . "\n";
		echo '</ul>' . "\n";
		echo '</td>' . "\n";
		/**/
		echo '</tr>' . "\n";
		echo '</tbody>' . "\n";
		echo '</table>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_paypal_buttons_page_during_left_sections_after_shortcode_attrs", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_paypal_buttons_page_after_left_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_paypal_buttons_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_paypal_buttons_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>