<?php get_header(); ?>
<div class="section clearfix default">
	<div class="container_12">
		<div class="grid_10">
			
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
					<h3 class="posttitle"><?php the_title(); ?></h3>
					<p class="meta"><?php _e('Posted by','cudazi'); ?> <?php the_author_posts_link(); ?> <?php _e('in','cudazi'); ?> <?php the_category(', '); ?> <?php _e('with','cudazi'); ?> <?php comments_number( __('0 Comments','cudazi'), __('1 Comment','cudazi'), __('% Comments','cudazi') ); ?></p>
					<?php the_content( __( 'Read More...', 'cudazi' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-link">' . __( 'Pages:', 'cudazi' ), 'after' => '</p>' ) ); ?>
				</div><!--//post-->
				
				<div id="nav-below" class="navigation clearfix">
					<div class="nav-previous left"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&lt;&nbsp;', 'Previous post link', 'cudazi' ) . '</span> %title', true ); ?></div>
					<div class="nav-next right"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&nbsp;&gt;', 'Next post link', 'cudazi' ) . '</span>', true ); ?></div>
				</div><!-- #nav-below -->
				
				<div id="comments"><?php comments_template( '', true ); ?></div>
				
			<?php endwhile; ?>

		</div>
		<div class="grid_2">
			<?php get_sidebar(); ?>
			<?php dynamic_sidebar( 'single-post' ); ?>
		</div>
			
	</div><!--//container_12-->
</div><!--//section-->
<?php get_footer(); ?>