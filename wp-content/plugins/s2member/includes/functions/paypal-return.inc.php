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
Handles PayPal® Return URL processing.
This is used ONLY in PayPal® Standard Integration.
Attach to: add_action("init");
*/
if (!function_exists ("ws_plugin__s2member_paypal_return"))
	{
		function ws_plugin__s2member_paypal_return ()
			{
				if ($_GET["s2member_paypal_return"]) /* Loads separate function handler. */
					{
						include_once dirname (__FILE__) . "/separates/paypal-return.inc.php";
						/**/
						s__ws_plugin__s2member_paypal_return (); /* Process. */
					}
			}
	}
?>