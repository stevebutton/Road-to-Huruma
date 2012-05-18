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

			<div class="post">
				<h2 class="archive-title"><?php _e( 'Error', 'basicmaths' ) ?> <span class="error"><?php _e( '404', 'basicmaths' ) ?></span></h2>
				<div class="single-entry-meta">
					<span class="meta-item meta-description"><span class="label"><?php _e( 'Description', 'basicmaths' ) ?></span> <span class="meta-content error"><?php _e( 'File not found', 'basicmaths' ) ?></span></span>
					<span class="meta-item meta-message"><span class="label"><?php _e( 'Message', 'basicmaths' ) ?></span> <span class="meta-content"><?php _e( 'Sorry, the page that you were looking for could not be found. If you want to find something else, you can search for it here:', 'basicmaths' ) ?></span></span>
					<span class="meta-item meta-search"><label class="label" for="s"><?php _e( 'Search', 'basicmaths' ) ?></label>
						<span class="meta-content">
							<form id="searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
								<div>
									<input id="s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="30" tabindex="1" />
									<input type="submit" class="button" value="<?php _e( 'Go', 'basicmaths' ) ?>" tabindex="2" />
								</div>
							</form>
						</span>
					</span>
				</div>
				
				<div class="entry-content">
<?php basic_404_link(); ?>

				</div>

			</div><!-- .post -->
				
		</div><!-- #content -->
	
<?php get_sidebar(); ?>

	</div><!-- #container -->

<?php get_footer(); ?>