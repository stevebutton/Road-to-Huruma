<?php get_header(); ?>
<?php
	if ( have_posts() )
		the_post();
?>
<div class="section clearfix default">
	<div class="container_12">
    
    	<div class="grid_12">
            <div class="section-heading clearfix">
                <h2><?php _e('Archives','cudazi'); ?></h2>
            </div><!--//section-heading-->
        </div>
        <div class="clear"></div>


		<div class="grid_10">
			
			<?php if ( is_day() ) : ?>
				<p><?php printf('<strong>%s</strong> %s', __("Daily Archives:","cudazi"), get_the_date()); ?></p>
			<?php elseif ( is_month() ) : ?>
				<p><?php printf('<strong>%s</strong> %s', __("Monthly Archives:","cudazi"), get_the_date('F Y')); ?></p>
			<?php elseif ( is_year() ) : ?>
				<p><?php printf('<strong>%s</strong> %s', __("Yearly Archives:","cudazi"), get_the_date('Y')); ?></p>
			<?php elseif ( is_author()  ) : ?>
				<p><?php printf('<strong>%s</strong> %s', __("Posts by:","cudazi"), get_the_author()); ?></p>
			<?php elseif ( is_tag()  ) : ?>
				<p><?php printf('<strong>%s</strong> %s', __("Posts tagged:","cudazi"), single_tag_title(null, false)); ?></p>
			<?php elseif ( is_category()  ) : ?>
				<?php 
					printf('<p><strong>%s</strong> %s</p>', __("Category:","cudazi"), single_cat_title(null, false)); 
					$category_description = category_description();
					if ( ! empty( $category_description ) )
					{
						echo $category_description;
					}
				?>
			<?php else : ?>
				<strong><?php _e( 'Archives', 'cudazi' ); ?></strong>
			<?php endif; ?>
		<?php
			rewind_posts();
			get_template_part( 'loop', 'archive' );
		?>
		</div>
		<div class="grid_2">
			<?php get_sidebar(); ?>
			<?php dynamic_sidebar( 'archive' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>