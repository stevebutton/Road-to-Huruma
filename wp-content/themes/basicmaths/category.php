<?php get_header(); ?>
		
	<div id="container">

		<div id="toptags">
			<h3><?php _e( 'Categories', 'basicmaths' ) ?></h3>
			<ul>
				<?php basic_categories(); ?>
			</ul>
		</div>

			<h2 class="archive-title"><?php _e( 'Category', 'basicmaths' ) ?> <span><?php single_cat_title() ?></span></h2>
			<div class="single-entry-meta archive-meta">
				<span class="meta-item"><span class="label"><?php _e( 'Entries', 'basicmaths' ) ?></span> <span class="post-count meta-content"><?php echo bm_cat_count(); ?><?php _e(' Total', 'basicmaths') ?></span></span>
				<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<span class="category-description meta-item"><span class="label">' . __('Description', 'basicmaths') . '</span>' . $categorydesc . '</span>' ); ?>
			</div>

		<div id="content">

<?php while ( have_posts() ) : the_post(); ?>

			<div class="hentry post">
				<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<div class="entry-date">
					<abbr class="date published" title="<?php the_time('Y-m-d') ?>"><?php the_time('M j, ’y'); ?></abbr>
					<abbr class="time published" title="<?php the_time('TH:i:sO') ?>"><?php the_time('g:i A'); ?></abbr>
				</div>
				
				<div class="entry-content entry-summary">
<?php the_excerpt(); ?>
				</div>
				
				<div class="entry-meta">
					<span class="continue-link"><a href="<?php the_permalink() ?>"><?php _e( 'Continue Reading&hellip;', 'basicmaths' ) ?></a></span>
					<?php /*?><span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'basicmaths' ), __( 'Comments (1)', 'basicmaths' ), __( 'Comments (%)', 'basicmaths' ) ) ?></span><?php */?>
					<?php edit_post_link(__( 'Edit', 'basicmaths' ), '<span class="edit">', '</span>'); ?> 
				</div><!-- .entry-meta -->
			</div><!-- .post -->

<?php endwhile ?>

			<div class="nextprev pagination">
				<div class="nav-previous"><span class="nextprev-arrow">&lsaquo;</span><?php next_posts_link(__( '<span class="nextprev-link-title">Older posts</span>', 'basicmaths' )) ?></div>
				<div class="nav-next"><?php previous_posts_link(__( '<span class="nextprev-link-title">Newer posts</span>', 'basicmaths' )) ?><span class="nextprev-arrow">&rsaquo;</span></div>
			</div><!-- .nextprev -->

		</div><!-- #content -->
	
<?php get_sidebar(); ?>

	</div><!-- #container -->

<?php get_footer(); ?>