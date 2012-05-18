<?php

// Use this file to test content of emails generated by MemberWing upon new user signup.
// -------------------------------------------------------------------------------------
//
// 1. Change email addresses below - make sure they are real for you - so that you'd actually receive email notifications:
//       $_inputs['payer_email']
//       $_inputs['receiver_email']
// 2. Edit '$testing_what' array values - set ONLY ONE of desired values to '1', others to '0'.
// 3. Comment out this line before testing:

//exit ('<html><hr /><h1 align="center"><a href="http://www.memberwing.com/">MemberWing-X - Wordpress Membership Plugin</a></h1><h2>Please uncomment exit() line from mwx-notify-test.php file</h2><hr /></html>');

// 4. Access this file via browser like this (adjust it for your setup):
//    http://www.YOUR-WEBSITE-NAME.com/wp-content/plugins/MEMBERWING-X-DIRECTORY/notify_test.php
// 5. Email should be received shortly. Test you SPAM folder if you cannot find any emails in your inbox.
// 6. Check __log.php file here: ../MEMBERWING-X-DIRECTORY/__log.php
// 7. If you want to re-test - remove created account from wordpress admin->Users panel and repeat step #2.
// 8. Uncomment 'exit()' line back at step 3


include (dirname(__FILE__) . '/mwx-include-all.php');

// Set only one of them to 1, the rest to 0.
$testing_what = array (
   'new_recurring_subscription_signup'       => 1,    // Testing creation of new recurring subscription
   'recurring_payment_made'                  => 0,    // Testing recurring payment
   'recurring_payment_refunded'              => 0,    // Testing refund of recurring payment.
   'existing_subscription_cancellation'      => 0,    // Testing cancellation of new subscription
   'existing_subscription_end_of_term'       => 0,    // Testing case when subscription reached end of term normally.
   'new_one_time_payment_product_purchase'   => 0,    // Testing purchase of one time payment product (Buy Now)
   'one_time_payment_refunded'               => 0,    // Testing refund for one time payment product
   );

   //---------------------------------------
   // Sanitize posted variables into '$_inputs' array
   //
   $_inputs = array ();
   $_inputs['first_name']       = 'John';                   // Buyer
   $_inputs['last_name']        = 'Smith';                  // Buyer
   $_inputs['payer_email']      = 'justwantapodcast@yahoo.com';         // Buyer  (test buyer - your other email)
   $_inputs['receiver_email']   = 'daniel@danielwatrous.com';     // Seller (you, webmaster, website owner)
   $_inputs['desired_username'] = 'johntest';               // Buyer's username (optional)
   $_inputs['desired_password'] = 'pass123';                // Buyer's password (optional)
   $_inputs['U_txn_date']       = date ('Y-m-d H:i:s', strtotime ("now")); // Normalize it for database usage.
   $_inputs['txn_id']           = "";

   $membership_name = 'Super Gold Membership';
   if ($testing_what['new_recurring_subscription_signup'])
      {
      $_inputs['txn_type']         = 'subscr_signup';

      $_inputs['item_name']        = $membership_name;
      $_inputs['mc_amount3_gross'] = "12.99";                  // Amount paid
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['subscr_id']        = 'SUBSCR-046';             // Unique subscription ID issued by shopping cart (Paypal)

      MWX__Product_Purchased ();  // Single item or subscription purchased. Enter product in user's metadata.
      }
   else if ($testing_what['recurring_payment_made'])
      {
      $_inputs['txn_type']         = 'subscr_payment';

      $_inputs['item_name']        = $membership_name;
      $_inputs['mc_amount3_gross'] = "12.99";                  // Amount paid
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['txn_id']           = 'TXN-001';                // Unique transaction ID issued by payment processor (Paypal)
      $_inputs['subscr_id']        = 'SUBSCR-045';             // Unique subscriber's ID issued by shopping cart (Paypal)

      MWX__Payment_Received ();   // Track payment for affiliate purposes;
      }
   else if ($testing_what['recurring_payment_refunded'])
      {
      $_inputs['txn_type']         = "";
      $_inputs['payment_status']   = 'refunded';

      $_inputs['item_name']        = $membership_name;
      $_inputs['mc_amount3_gross'] = "12.99";                  // Amount paid
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['txn_id']           = 'TXN-002';                // Unique transaction ID issued by payment processor (Paypal)
      $_inputs['parent_txn_id']    = 'TXN-001';                // Unique transaction ID issued by payment processor (Paypal)
      $_inputs['subscr_id']        = 'SUBSCR-045';             // Unique subscriber's ID issued by shopping cart (Paypal)

      MWX__Payment_Cancelled ();
      }
   else if ($testing_what['existing_subscription_cancellation'])
      {
      $_inputs['txn_type']         = "subscr_cancel";

      $_inputs['item_name']        = $membership_name;
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['subscr_id']        = 'SUBSCR-045';             // Unique subscriber's ID issued by shopping cart (Paypal)

      MWX__Subscription_Cancelled ();
      }
   else if ($testing_what['existing_subscription_end_of_term'])
      {
      $_inputs['txn_type']         = "subscr_eot";

      $_inputs['item_name']        = $membership_name;
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['subscr_id']        = 'SUBSCR-045';             // Unique subscriber's ID issued by shopping cart (Paypal)

      MWX__Subscription_Ended ();  // Subscription ended normally.
      }
   else if ($testing_what['new_one_time_payment_product_purchase'])
      {
      $_inputs['txn_type']         = 'web_accept';

      $_inputs['item_name']        = 'Article: How to live fully(id:3)';
      $_inputs['mc_amount3_gross'] = "4.95";                   // Amount paid
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['txn_id']           = 'TXN-201';                // Unique transaction ID issued by payment processor (Paypal)

      MWX__Product_Purchased ();  // Single item or subscription purchased. Enter product in user's metadata.
      }
   else if ($testing_what['one_time_payment_refunded'])
      {
      $_inputs['txn_type']         = "";
      $_inputs['payment_status']   = 'refunded';

      $_inputs['item_name']        = 'Article: How to live fully(id:3)';
      $_inputs['mc_amount3_gross'] = "4.95";                   // Amount paid
      $_inputs['customer_ip']      = "123.45.6.78";            // Buyer's IP address
      $_inputs['txn_id']           = 'TXN-202';                // Unique transaction ID issued by payment processor (Paypal)
      $_inputs['parent_txn_id']    = 'TXN-201';                // Unique transaction ID issued by payment processor (Paypal)

      MWX__Payment_Cancelled ();
      }


   echo '<hr />';
   echo '<h1>Test finished.</h1>';
   echo '<hr />';

?>