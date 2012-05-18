<!-- Source: loop.php -->
<?php
/*
* The loop that displays posts.
*/
	global $custom_settings; 
?>

	
	<?php /* If there are no posts to display, such as an empty archive page */ ?>
	<?php if ( ! have_posts() ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post clearfix'); ?>>
			<h3 class="posttitle"><?php _e( 'Not Found', 'cudazi' ); ?></h3>
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'cudazi' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
	
	
	<?php /* Start the Loop. */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
			
			<div id="post-<?php the_ID(); ?>" <?php post_class('post clearfix'); ?>>
				<div class="grid_2 alpha">
					<p class="fancydate">
						<span class="m"><?php the_time('M'); ?></span>
						<span class="d"><?php the_time('d'); ?></span>
						<span class="y"><?php the_time('Y'); ?></span>
						<?php edit_post_link(null, '<br /><small>', '</small>'); ?>
					</p>
				</div><!--//grid_2-->
				<div class="grid_8 omega">
					<h3 class="posttitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="meta"><?php _e('Posted by','cudazi'); ?> <?php the_author_posts_link(); ?> <?php _e('in','cudazi'); ?> <?php the_category(', '); ?> <?php _e('with','cudazi'); ?> <?php comments_number( __('0 Comments','cudazi'), __('1 Comment','cudazi'), __('% Comments','cudazi') ); ?></p>
					<?php if(is_search()){ ?>
						<?php the_excerpt( ); ?>
					<?php }else{ ?>
						<?php the_content( __( 'Read More...', 'cudazi' ) ); ?>
					<?php } ?>
				</div><!--//grid_8-->
			</div>
			<div class="clear"></div>
			
	<?php endwhile; // End the loop ?>
	
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
		<div id="nav-below" class="navigation clearfix">
			<div class="nav-previous left"><?php next_posts_link( __( '&lt;&nbsp;&nbsp;Older posts', 'cudazi' ) ); ?></div>
			<div class="nav-next right"><?php previous_posts_link( __( 'Newer posts&nbsp;&nbsp;&gt;', 'cudazi' ) ); ?></div>
		</div><!-- #nav-below -->
	<?php endif; ?>