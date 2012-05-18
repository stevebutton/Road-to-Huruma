<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }

$authordata = get_userdata(intval($author));

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

		<h2 class="archive-title"><?php _e( 'Author', 'basicmaths' ) ?> <span><?php echo get_the_author(); ?></span></h2> 
		<div class="single-entry-meta archive-meta">
			<span class="meta-item"><span class="label"><?php _e( 'Entries', 'basicmaths' ) ?></span> <span class="post-count meta-content"><?php echo get_usernumposts($authordata->ID); ?><?php _e(' Total', 'basicmaths') ?></span></span>
			<span class="meta-item author-bio"><span class="label"><?php _e( 'Bio', 'basicmaths' ) ?></span> <p><?php the_author_meta('user_description', $authordata->ID); ?>&nbsp;</p></span>
			<span class="meta-item author-contact"><span class="label"><?php _e( 'Contact', 'basicmaths' ) ?></span> <span class="email-address meta-content"><a class="email" title="<?php echo antispambot($authordata->user_email); ?>" href="mailto:<?php echo antispambot($authordata->user_email); ?>"><span class="fn n"><?php _e('Email ', 'basicmaths') ?><span class="given-name"><?php echo $authordata->first_name; ?></span> <span class="family-name"><?php echo $authordata->last_name; ?></span></span></a></span></span>
		</div>

		<div id="content">
			
<?php rewind_posts() ?>

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
					<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'basicmaths' ), __( 'Comments (1)', 'basicmaths' ), __( 'Comments (%)', 'basicmaths' ) ) ?></span>
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