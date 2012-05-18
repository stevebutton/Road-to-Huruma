<?php /* This is not a true page template but a snippet that is shared between page templates. */ ?>
<div class="grid_12">
	<div class="section-heading clearfix">
		<?php edit_post_link(null, "<small class='right'>", '</small>'); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	</div><!--//section-heading-->
</div><!--//grid_12-->

<?php
	//print_r_pre($custom_settings);
	
	$custom_query_args = array(
		'cat' => $custom_settings['blog_summary']['category_id'],
		'posts_per_page' => $custom_settings['blog_summary']['max']
	);
	
	$blog_query = null;
	$blog_query = new WP_Query($custom_query_args);
	
	if( $blog_query->have_posts() ) 
	{
		while ($blog_query->have_posts())
		{
			$blog_query->the_post(); // Get things going
			global $more; $more = 0; // Used to keep the "more" link showing
			?>
			<div class="clear"></div>
			<div class="post clearfix">
				<div class="grid_2">
					<p class="fancydate">
						<span class="m"><?php the_time('M'); ?></span>
						<span class="d"><?php the_time('d'); ?></span>
						<span class="y"><?php the_time('Y'); ?></span>
						<?php edit_post_link(null, '<br /><small>', '</small>'); ?>
					</p>
				</div><!--//grid_2-->
				<div class="grid_10">
					<h3 class="posttitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="meta"><?php _e('Posted by','cudazi'); ?> <?php the_author_posts_link(); ?> <?php _e('in','cudazi'); ?> <?php the_category(', '); ?> <?php _e('with','cudazi'); ?> <?php comments_number( __('0 Comments','cudazi'), __('1 Comment','cudazi'), __('% Comments','cudazi') ); ?></p>
					<div class="excerpt">
						<?php the_content( __('Continue Reading...','cudazi') ); ?>
					</div><!--//excerpt-->
				</div><!--//grid_10-->
			</div>
			<?php	
		}//endwhile;
		
	}else{
		// No Posts
	}// if have posts
	
	wp_reset_query();  // Restore global post variable
	
	// Only show the posts page link (blog) if not disabled in theme settings
	if(!$custom_settings["disable_blog_link_summary"])
	{
		if($custom_settings["page_for_posts"] > 0 && $custom_settings["show_on_front"] == 'page')
		{
			echo "<p class='page-for-posts'><a href='" . get_permalink($custom_settings["page_for_posts"]) . "'>". __('View All Posts','cudazi') . "</a>";
		}else{
			?><!-- Page for posts not set. --><?php
		}
	}
	
	
?>