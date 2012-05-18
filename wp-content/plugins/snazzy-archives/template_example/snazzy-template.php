<?php
/*
Template Name: Snazzy Archives
*/

?>

<?php get_header(); ?>


	<p align="center">
		<?php if (isset($SnazzyArchives)) echo $SnazzyArchives->display(""); ?>
	</p>

<?php get_footer(); ?>
