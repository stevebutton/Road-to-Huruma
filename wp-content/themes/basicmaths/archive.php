<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>
<?php get_header(); ?>
		
	<div id="container">

		<div id="basic-maths-calendar">
		<?php get_calendar(false); ?>
		</div>	

<?php the_post() ?>

<?php if ( is_day() ) : ?>
			<h2 class="archive-title"><?php printf(__('Day <span>%s</span>', 'basicmaths'), get_the_time(get_option('date_format'))) ?></h2>

<?php elseif ( is_month() ) : ?>
			<h2 class="archive-title"><?php printf(__('Month <span>%s</span>', 'basicmaths'), get_the_time('F Y')) ?></h2>

<?php elseif ( is_year() ) : ?>
			<h2 class="archive-title"><?php printf(__('Year <span>%s</span>', 'basicmaths'), get_the_time('Y')) ?></h2>

<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
			<h2 class="archive-title"><?php _e('Archives', 'basicmaths') ?></h2>

<?php endif; ?>
			<div class="single-entry-meta archive-meta">
				<span class="author meta-item"><span class="label"><?php _e( 'Entries', 'basicmaths' ) ?></span> <span class="post-count meta-content"><?php echo $wp_query->post_count; ?><?php _e(' Total', 'basicmaths') ?></span></span>
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