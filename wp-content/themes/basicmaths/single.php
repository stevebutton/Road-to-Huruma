<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>
<?php get_header(); ?>
		
	<div id="container">

<?php if($bm_cats_or_tags == 'true') { ?>
		<div id="toptags">
			<h3><?php _e( 'Categories', 'basicmaths' ) ?></h3>
			<ul>
				<?php basic_categories(); ?>
			</ul>
		</div>
<?php } else { ?>
		<div id="toptags">
			<h3><?php _e( 'Top Tags', 'basicmaths' ) ?></h3>
			<ul>
				<?php basic_tags(); ?>
			</ul>
		</div>
<?php } ?>

		<div id="content">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<div class="hentry post">
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<div class="entry-date">
				<abbr class="date published" title="<?php the_time('Y-m-d') ?>"><?php the_time('M j, ’y'); ?></abbr>
				<abbr class="time published" title="<?php the_time('TH:i:sO') ?>"><?php the_time('g:i A'); ?></abbr>
			</div>

			<div class="single-entry-meta">
				<span class="author meta-item">
					<span class="label"><?php _e( 'Author', 'basicmaths' ) ?></span>
					<span class="meta-content"><?php the_author_posts_link(); ?></span>
				</span>
				<span class="post-tags meta-item">
					<?php printf(__('<span class="label">Categories</span> <span class="meta-content">%s</span>', 'basicmaths'), get_the_category_list(', ', '</span>')) ?>
					<?php printf(__('%s', 'basicmaths'), get_the_tag_list('<span class="label">Tags</span> <span class="meta-content">', ', ', '</span>')) ?>
				</span>
				<?php edit_post_link(__( 'Edit', 'basicmaths' ), '<span class="edit">', '</span>'); ?> 
			</div><!-- .entry-meta -->
			
			<div class="entry-content">
				<?php the_content(); ?>

				<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'basicmaths' ) . '&after=</div>') ?>
			</div>
			
		</div><!-- .post -->

		<div class="nextprev nextprev-single">
			<div class="nav-previous"><?php previous_post_link( __('<span class="nextprev-arrow">&lsaquo;</span>%link', 'basicmaths'), __('<span class="nextprev-post">Previous Post</span> <span class="nextprev-single-link-title">%title</span>', 'basicmaths') ) ?></div>
			<div class="nav-next"><?php next_post_link( __('%link<span class="nextprev-arrow">&rsaquo;</span>', 'basicmaths'), __('<span class="nextprev-post">Next Post</span> <span class="nextprev-single-link-title">%title</span>', 'basicmaths') ) ?></div>
		</div>
	
<?php comments_template('', true); ?>

<?php endwhile; ?>

<?php endif; ?>
			
	</div><!-- #content -->
	
<?php get_sidebar(); ?>

</div><!-- #container -->

<?php get_footer(); ?>