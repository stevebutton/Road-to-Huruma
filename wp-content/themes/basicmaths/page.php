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

<?php the_post() ?>
		
		<div class="post">
			<h2 class="entry-title single-page-title"><?php the_title(); ?></h2>
			
			<div class="entry-content">
				<?php the_content(); ?>

<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'basicmaths' ) . '&after=</div>') ?>
			</div>
			
			<?php edit_post_link(__( 'Edit', 'basicmaths' ), '<div class="single-entry-meta"><span class="edit">', '</span></div><!-- .entry-meta -->'); ?> 

		</div><!-- .post -->
	
<?php if ( get_post_custom_values('comments') ) comments_template('', true); ?>

	</div><!-- #content -->

</div><!-- #container -->

<?php get_footer(); ?>