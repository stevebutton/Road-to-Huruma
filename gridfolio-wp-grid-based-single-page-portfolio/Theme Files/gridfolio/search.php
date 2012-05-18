<?php
/*
 * The template for displaying Search Results pages.
*/
get_header(); ?>
<div class="section clearfix default">
	<div class="container_12">
		
        <div class="grid_12">
            <div class="section-heading clearfix">
                <h2><?php _e('Search','cudazi'); ?></h2>
            </div><!--//section-heading-->
        </div>
        <div class="clear"></div>
        
		<div class="grid_10">
			<?php if ( have_posts() ) : ?>
				<p><strong><?php _e("Search results for:","cudazi"); ?></strong> <?php echo get_search_query(); ?></p>
				<?php get_template_part( 'loop', 'search' ); ?>
			<?php else : ?>
			
				<h2><?php _e( 'Nothing Found', 'cudazi' ); ?></h2>
				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'cudazi' ); ?></p>
				<div class="grid_4 alpha">
					<?php get_search_form(); ?>
				</div>
				<div class="clear"></div>
			<?php endif; ?>
		</div>
		<div class="grid_2">
			<?php get_sidebar(); ?>
			<?php dynamic_sidebar( 'search' ); ?>
		</div>
		
	</div>
</div>
<?php get_footer(); ?>