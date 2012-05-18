<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
*/
get_header(); ?>
<div class="section clearfix default">
	<div class="container_12">
    
        <div class="grid_12">
            <div class="section-heading clearfix">
                <h2><?php _e('Not Found!','cudazi'); ?></h2>
                <p><?php _e( 'Apologies, but the item you requested could not be found. Perhaps searching will help.', 'cudazi' ); ?></p>
                <div class="grid_4 alpha"><?php get_search_form(); ?></div>
            </div><!--//section-heading-->
        </div>
		
	</div>
</div>
<?php get_footer(); ?>