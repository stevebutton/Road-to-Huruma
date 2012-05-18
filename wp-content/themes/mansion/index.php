<?php get_header(); ?>
	<?php 
	// grab grid design settings
	$options = get_option('mansion_theme_options');
	$gd = $options['griddesign'];

	query_posts("cat=&paged=$paged");
	$count = 0; if (have_posts()) :  ?>

		<?php while (have_posts()) : the_post(); $count++; ?>
		
		
		<?php if($gd == "one" || $gd == "") : // show one image per post  ?>
			<?php if(checkimage()): ?>
			<div class="box">
			<?php if(has_tag('featured') && ($count == 1) ) : 			
					get_the_image( array( 'custom_key' => array( 'featured' ), 'default_size' => 'featured', 'width' => '401', 'height' => '301', 'image_class' => 'featured' ) ); 			
				else : 			
					get_the_image( array( 'custom_key' => array( 'thumbnail' ), 'width' => '200', 'height' => '', 'image_class' => 'thumbnail' ) ); 				
				endif; ?>
			</div>
			<?php endif; ?>
		<?php endif; // end $gd condition ?>
		
		<?php if($gd == "all") : // show all images from post ?>
			<?php if(has_tag('featured') && ($count == 1) ) : ?>
				<?php postimages('featured'); ?>
			<?php else : ?>
				<?php if(checkimage('thumbnail')) :
					postimages('thumbnail'); 
				else : ?>
					<div class="box"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/default-thumb.jpg" class="attachment-thumbnail" alt="<?php the_title(); ?>" width="200" height="150" /></a></div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; // end $gd condition ?>
		
		
		<?php endwhile; ?>
		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php get_search_form(); ?>

	<?php endif; ?>


<?php get_footer(); ?>
