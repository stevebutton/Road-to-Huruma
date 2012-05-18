Is a specific [Category, Tag, Post, Page, or URI] protected by s2Member?
<?php is_protected_by_s2member ($__id, $__type, $check_user); ?>
 ( * This ignores the current User/Member status.
 	Just "is it protected" by s2Member at all? )

If true, returns a non-empty array containing one of these elements.
	["s2member_level_req"] = Level required for access.
	["s2member_ccap_req"] = Custom Capability required.
	["s2member_sp_req"] = "Specific Post/Page ID" required.
Otherwise returns false.

$__id - optional argument. Defaults to current $post->ID in The Loop.
$__type - optional argument. One of: `category`, `tag`, `post`, `page`, `singular`, `uri`. Defaults to: `singular`.
$check_user - optional ( consider the current User? ) defaults to: false.

-----------------------------------------------------------------------------

Is the current User permitted to access this  [Category, Tag, Post, Page, or URI]?
<?php is_permitted_by_s2member ($__id, $__type); ?>

Returns true or false.

Similar to:
<?php is_protected_by_s2member ($__id, $__type, $check_user = TRUE); ?>
- BUT `is_permitted_by_s2member()` does NOT return an array.

$__id - optional argument. Defaults to current $post->ID in The Loop.
$__type - optional argument. One of: `category`, `tag`, `post`, `page`, `singular`, `uri`. Defaults to: `singular`.

-----------------------------------------------------------------------------

Further details and additional functions can be found inside:
/s2member/includes/functions/api-functions.inc.php