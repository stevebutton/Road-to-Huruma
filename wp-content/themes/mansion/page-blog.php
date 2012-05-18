<?php
/*
Template Name: Blog
*/
?>

<?php
	// grab blog category from settings
	$options = get_option('mansion_theme_options');
	$category = $options['blog'];
?>

<?php get_header(); ?>

		<?php 
		$wp_query = new WP_Query('cat='.$category.'&paged='.$paged);
		while ($wp_query->have_posts()) : $wp_query->the_post(); $count++; ?>
			<?php if(has_tag('featured') && ($count == 1) ) : ?>
				<div class="box col2 blog">
				 <a href="<?php the_permalink(); ?>">				    
					<?php postimage('featured'); ?>
					<div class="datediv">
						<span class="day"><?php the_time('d'); ?></span>
				    	<span class="monthyear"><?php the_time('M y'); ?></span>
				    </div>
					<h2 class="posttitle"><?php the_title(); ?></h2>
					<?php the_excerpt(); ?>
				 </a>
				</div>
			<?php else : ?>
				<div class="box col1 blog">
				 <a href="<?php the_permalink(); ?>">
					<?php postimage('thumbnail'); ?>
					<div class="datediv">
						<span class="day"><?php the_time('d'); ?></span>
				    	<span class="monthyear"><?php the_time('M y'); ?></span>
				    </div>
					<h2 class="posttitle"><?php the_title(); ?></h2>
					<?php the_excerpt(); ?>
				 </a>
				</div>
			<?php endif; ?>
		<?php endwhile; wp_reset_query();  ?>


<?php get_footer(); ?>
