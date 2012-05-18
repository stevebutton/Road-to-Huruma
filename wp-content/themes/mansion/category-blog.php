<?php get_header(); ?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); $count++; ?>
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
		<?php endwhile; ?>

	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		get_search_form();

	endif;
?>

<?php get_footer(); ?>
