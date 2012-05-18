<?php get_header(); 
	
	// [grid column setting] 
	$col_w = 290; // width of grid column
	$gap_w = 35;  // padding + margin-right (15+15+5)
	$max_col = 2; // max column size (style div.x1 ~ xN)
	
	// * additional info *
	// check also "style.css" and "header.php" if you change $col_w and $gap_w.
	// - style.css:
	//   div.x1 ~ xN
	//   div.grid-item
	//   div.single-item
	//   ... and maybe #sidebar2 li.widget.
	// - header.php:
	//   gridDefWidth in javascript code.
	//
	// if you want to show small images in main page always, set $max_col = 1.
	
	// [grid image link setting]
	$flg_img_forcelink = true;   // add/overwrite a link which links to a single post (permalink).
	$flg_img_extract = false;    // in single post page, extract thumbnail link to an original image.
	$flg_obj_fit = 'large-fit';  // none | small-fit | large-fit ... how to fit size of object tag.
	
	// * additional info *
	// if you use image popup utility (like Lightbox) on main index, set $flg_img_forcelink = false;
?>

<?php if (is_singular()) : $is_top_single = true; /* wide column for single post */ ?>

	<div id="single-wrapper">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class('single-item'); ?> id="post-<?php the_ID(); ?>">
			<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="post-body">
				<?php
					if ($flg_img_extract) {
						$content = get_the_content();
						$content = apply_filters('the_content', $content);
						$content = adjust_single_image($content);
						echo $content;
					}
					else {
						the_content();
					}
				?>
			</div>
			<?php wp_link_pages('before=<p class="pagination" id="post-pagination"><span class="prefix">' . __('Pages:') . '</span>'); ?>
			<p class="post-meta">
			Published on <?php the_time( get_option('date_format') ); ?> <?php the_time(); ?>.<br />
			Filed under: <?php the_category(', ') ?> <?php the_tags('Tags: ', ', '); ?>
			<?php edit_post_link(__("Edit This"), '(', ')'); ?>
			</p>
		</div>
		
<?php comments_template(); ?>

<?php endwhile; else : ?>

		<div class="single-item">
			<h2>Not Found</h2>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		</div>

<?php endif; ?>

	</div><!-- /single-wrapper -->

<?php /* make a new query for grid items (in single page) */
	$new_query_arg = 'paged='.$paged;
	
	// use this code if you want filter items by category.
	/* $arr_catID = array();
	foreach( get_the_category() as $cat) $arr_catID[] = $cat->cat_ID;
	if ( count($arr_catID) ) $new_query_arg .= '&cat=' . join(',', $arr_catID);
	*/
	
	query_posts($new_query_arg); 
?>

<?php endif; /* end of if is_singular() */ ?>

<?php get_sidebar(); ?>

	<div id="grid-wrapper">

<?php if (have_posts()) : 
	if ( $is_top_single ) $GLOBALS['more'] = false; //important
	while (have_posts()) : the_post(); ?>
<?php 
	$content = get_the_content('Details &raquo;');
	$content = apply_filters('the_content', $content);
	list($col_class, $grid_img) = adjust_grid_image(
		$content, 
		$col_w, 
		$gap_w, 
		$max_col, 
		$flg_img_forcelink, 
		$flg_obj_fit
	);
?>
		<div <?php post_class('grid-item ' . $col_class); ?> id="post-<?php the_ID(); ?>">
			<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php if ($grid_img) echo '<div class="grid-image">' . $grid_img . '</div>'; ?>
			<div class="post-body">
<?php 
	$content = preg_replace('/<img(?:[^>]+?)>/', '', $content); // remove img tags
	$content = preg_replace('/<a([^>]+?)><\/a>/', '', $content); // remove empty a tags
	$content = preg_replace('/<p([^>]*?)><\/p>/', '', $content); // remove empty p tags
	$content = preg_replace('/<object(.+?)<\/object>/', '', $content); // remove object tags
	echo $content; 
?>
			</div>
			<p class="post-meta">
			Published on <?php the_time( get_option('date_format') ); ?> <?php the_time(); ?>.<br />
			Filed under: <?php the_category(', ') ?> <?php the_tags('Tags: ', ', '); ?>
			<?php edit_post_link(__("Edit This"), '(', ')'); ?><br />
			<?php /*comments_popup_link();*/ ?>
			</p>
		</div>

<?php endwhile; else : ?>

		<div class="grid-item x1">
			<h2>Not Found</h2>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		</div>

<?php endif; ?>

	</div><!-- /grid-wrapper -->
	
	<div class="pagination" id="grid-pagination">
		<?php paginate_links2($is_top_single); ?>
	</div>

<?php /* reset the query */
	wp_reset_query();
?>

<?php get_sidebar('2'); ?>

</div><!-- /container -->

<?php get_footer(); ?>
