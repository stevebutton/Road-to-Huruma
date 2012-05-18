<?php $fields = json_decode(S2MEMBER_CURRENT_USER_FIELDS, true); ?>
<?php echo $fields["first_name"]; ?> <?php echo $fields["last_name"]; ?>
This would output the first and last name for the current user.

Custom Fields are also included in the JSON decoded array.
<?php print_r(json_decode(S2MEMBER_CURRENT_USER_FIELDS, true)); ?>
( Displays a full list of all associative array elements. )

---- s2member Shortcode Equivalents ----

[s2Get user_field="first_name" /]
[s2Get user_field="last_name" /]
[s2Get user_field="Website URL" /]
[s2Get user_field="My Custom Field Name" /]
[s2Get user_field="my_custom_field_name" /]
[s2Get user_field="any other WP_User property" /]

You can also pull details from the meta table.
[s2Get user_option="s2member_custom" /]
[s2Get user_option="s2member_subscr_id" /]
[s2Get user_option="s2member_last_payment_time" /]
[s2Get user_option="s2member_auto_eot_time" /]
[s2Get user_option="any other meta_key" /]