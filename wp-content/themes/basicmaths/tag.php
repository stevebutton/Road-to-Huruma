<?php get_header() ?>

	<div id="container">

		<div id="toptags">
			<h3><?php _e( 'Top Tags', 'basicmaths' ) ?></h3>
			<ul>
				<?php basic_tags(); ?>
			</ul>
		</div>

		<h2 class="archive-title"><?php _e( 'Tag', 'basicmaths' ) ?> <span><?php single_tag_title() ?></span></h2>
		<div class="single-entry-meta archive-meta">
			<span class="meta-item">
				<span class="label"><?php _e( 'Entries', 'basicmaths' ) ?> </span>
				<span class="post-count meta-content"><?php echo bm_tag_count(); ?><?php _e(' Total', 'basicmaths') ?></span>
				<?php $tagdesc = tag_description(); if ( !empty($tagdesc) ) echo apply_filters( 'archive_meta', '<span class="tag-description meta-item"><span class="label">' . __('Description', 'basicmaths') . '</span>' . $tagdesc . '</span>' ); ?>
			</span>
		</div>

		<div id="content">

<?php while ( have_posts() ) : the_post() ?>

			<div class="hentry post">
				<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<div class="entry-date">
					<abbr class="date published" title="<?php the_time('Y-m-d') ?>"><?php the_time('M j, ’y'); ?></abbr>
					<abbr class="time published" title="<?php the_time('TH:i:sO') ?>"><?php the_time('g:i A'); ?></abbr>
				</div>
				
				<div class="entry-content entry-summary">
					<?php the_excerpt(__( 'Read More <span class="meta-nav">&raquo;</span>', 'basicmaths' )) ?>
				</div>
				
				<div class="entry-meta">
					<span class="continue-link"><a href="<?php the_permalink() ?>"><?php _e( 'Continue Reading&hellip;', 'basicmaths' ) ?></a></span>
					<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'basicmaths' ), __( 'Comments (1)', 'basicmaths' ), __( 'Comments (%)', 'basicmaths' ) ) ?></span>
					<?php edit_post_link(__( 'Edit', 'basicmaths' ), '<span class="edit">', '</span>'); ?> 
				</div><!-- .entry-meta -->
			</div><!-- .post -->

<?php endwhile; ?>

			<div class="nextprev pagination">
				<div class="nav-previous"><span class="nextprev-arrow">&lsaquo;</span><?php next_posts_link(__( '<span class="nextprev-link-title">Older posts</span>', 'basicmaths' )) ?></div>
				<div class="nav-next"><?php previous_posts_link(__( '<span class="nextprev-link-title">Newer posts</span>', 'basicmaths' )) ?><span class="nextprev-arrow">&rsaquo;</span></div>
			</div><!-- .nextprev -->
		
	</div><!-- #content -->

<?php get_sidebar(); ?>

</div><!-- #container -->

<?php get_footer(); ?>