<?php get_header(); 
/* Single portfolio template, not normally used unless someone got a link directly to this custom post type (portfolio) */
?>
<div class="section clearfix default">
	<div class="container_12">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<?php include('layouts/page-custom-portfolio.php'); ?>		
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>