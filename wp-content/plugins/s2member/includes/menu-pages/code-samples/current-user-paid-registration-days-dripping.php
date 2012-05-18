<?php if(S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER){ ?>

	This is some content that will be displayed to all paying Members.
	
	<?php if(S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS >= 30){ ?>
		Drip content to Members that started paying you at least 30 days ago.
	<?php } ?>
	
	<?php if(S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS >= 60){ ?>
		Drip content to Members that started paying you at least 60 days ago.
	<?php } ?>
	
	<?php if(S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS >= 90){ ?>
		Drip content to Members that started paying you at least 90 days ago.
	<?php } ?>

<?php } ?>

---- s2member Shortcode Equivalent ----

[s2Get constant="S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS" /]

There is NO Shortcode equivalent for this logic yet. Coming soon.