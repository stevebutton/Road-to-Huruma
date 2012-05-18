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

<?php if ( have_posts() ) : ?>

			<h2 class="archive-title"><?php _e( 'Search term:', 'basicmaths' ) ?> <span class="search-term"><?php the_search_query() ?></span></h2>
			<div class="single-entry-meta archive-meta">
				<span class="meta-item">
					<span class="label"><?php _e( 'Entries', 'basicmaths' ) ?></span>
					<span class="post-count meta-content"><?php $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; echo $count . ' '; wp_reset_query(); ?><?php _e(' Total', 'basicmaths') ?></span>
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
<?php the_excerpt(); ?>
				</div>
				
<?php if ( $post->post_type == 'post' ) { ?>
				<div class="entry-meta">
					<span class="continue-link"><a href="<?php the_permalink() ?>"><?php _e( 'Continue Reading&hellip;', 'basicmaths' ) ?></a></span>
					<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'basicmaths' ), __( 'Comments (1)', 'basicmaths' ), __( 'Comments (%)', 'basicmaths' ) ) ?></span>
					<?php edit_post_link(__( 'Edit', 'basicmaths' ), '<span class="edit">', '</span>'); ?> 
				</div><!-- .entry-meta -->
<?php } ?>
			</div><!-- .post -->

<?php endwhile ?>

			<div class="nextprev pagination">
				<div class="nav-previous"><span class="nextprev-arrow">&lsaquo;</span><?php next_posts_link(__( '<span class="nextprev-link-title">Older posts</span>', 'basicmaths' )) ?></div>
				<div class="nav-next"><?php previous_posts_link(__( '<span class="nextprev-link-title">Newer posts</span>', 'basicmaths' )) ?><span class="nextprev-arrow">&rsaquo;</span></div>
			</div><!-- .nextprev -->

<?php else : ?>

		<div id="content">
			<div class="post">
				<h2 class="archive-title"><?php _e( 'Woops', 'basicmaths' ) ?> <span class="error"><?php _e( 'Nothing found', 'basicmaths' ) ?></span></h2>
				<div class="single-entry-meta">
					<span class="meta-item meta-message">
						<span class="label"><?php _e( 'Message', 'basicmaths' ) ?></span>
						<span class="meta-content"><?php _e( 'Sorry, but nothing matched your search criteria.<br />Please try another search term here:', 'basicmaths' ) ?></span>
					</span>

					<span class="meta-item meta-search">
						<label class="label" for="s"><?php _e( 'Search', 'basicmaths' ) ?></label>
						<span class="meta-content">
							<form id="searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
								<div>
									<input id="s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="30" tabindex="1" />
									<input type="submit" class="button" value="<?php _e( 'Go', 'basicmaths' ) ?>" tabindex="2" />
								</div>
							</form>
						</span>
					</span>

				</div><!-- .single-entry-meta -->

				<div class="entry-content">
<?php basic_404_link(); ?>

				</div><!-- .entry-content -->

			</div><!-- .post -->

<?php endif; ?>

		</div><!-- #content -->
	
<?php get_sidebar(); ?>

	</div><!-- #container -->

<?php get_footer(); ?>