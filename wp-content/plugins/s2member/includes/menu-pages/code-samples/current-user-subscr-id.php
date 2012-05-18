<?php echo S2MEMBER_CURRENT_USER_SUBSCR_ID; ?>
This may output something like: S-82234JD0923423
( this is the Paid Subscription ID associated with their account )
( if the User is a Free Subscriber, this is their Free Subscriber ID )
( for Lifetime subscriptions sold through Buy Now buttons, this will hold the Paid Transaction ID associated with their purchase )

---- s2member Shortcode Equivalent ----

[s2Get constant="S2MEMBER_CURRENT_USER_SUBSCR_ID" /]