<?php echo S2MEMBER_VERSION; ?>
This may output something like: 3.0.x
( or whatever the current version number is )
Use PHP's version_compare() function to test this.

---- s2member Shortcode Equivalent ----

[s2Get constant="S2MEMBER_VERSION" /]