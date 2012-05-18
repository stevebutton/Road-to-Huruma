<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
			<div class="navigation">			
				<div class="prev"><?php previous_post_link('%link', 'Previous', TRUE); ?></div>
				<div class="next"><?php next_post_link('%link', 'Next', TRUE); ?></div>
			</div>
			
			<h2 class="posttitle"><?php the_title(); ?></h2>
			<span class="posted">Posted on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?></span>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php the_tags( '<p class="tags">Tags: ', ', ', '</p>'); ?>

				<p class="postmetadata alt">
					Filed under <?php the_category(', ') ?>.
						<?php edit_post_link('Edit this entry','','.'); ?>
				</p>

			</div>
		</div>
		

		<div class="clear"></div>
		

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>
