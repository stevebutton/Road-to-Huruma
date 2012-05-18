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
Handles PayPal® IPN URL processing.
These same routines also handle s2Member Pro/PayPal® Pro operations;
giving you the ability ( as needed ) to Hook into these routines using
WordPress® Hooks/Filters; as seen in the source code below.

Please do NOT modify the source code directly.
Instead, use WordPress® Hooks/Filters.

For example, if you'd like to add your own custom conditionals, use:
add_filter ("ws_plugin__s2member_during_paypal_notify_conditionals", "your_function");

Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_paypal_notify"))
	{
		function ws_plugin__s2member_paypal_notify ()
			{
				if ($_GET["s2member_paypal_notify"]) /* Loads separate function handler. */
					{
						include_once dirname (__FILE__) . "/separates/paypal-notify.inc.php";
						/**/
						s__ws_plugin__s2member_paypal_notify (); /* Process. */
					}
			}
	}
?>