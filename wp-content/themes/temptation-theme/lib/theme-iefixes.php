<?php
function celta_render_ie() {
	global $theme_path;
	echo '
	<!--[if lte IE 8]>
	<style>
	.team-member-img, .team-member-img img, #pager li, #pager a, #pager span {
		behavior: url( "' . $theme_path . '/scripts/pie/PIE.php" );
	}
	</style>
	<![endif]-->';
	}
?>