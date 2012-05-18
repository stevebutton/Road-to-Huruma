<?php
/*
* Template Name: Portfolio
*
* **************************************************************************************************
* DO NOT REMOVE THIS PAGE!
* Allows the use of page templates when adding/editing pages.
* Used in format different types of pages on page-custom-single.php
* **************************************************************************************************
*/
get_header(); 

// The items below are not used in this single-page template but more as a fallback in case the page ID is loaded directly.
// This can happen when editing posts and clicking view through the admin vs. just using your site's navigation.
// The template: page-custom-single.php file includes the file below, make any edits in the layouts folder since they share the same file.
?>
<div class="section clearfix default">
	<div class="container_12">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<?php include('layouts/page-custom-portfolio.php'); ?>		
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>