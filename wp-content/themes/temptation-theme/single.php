<?php require( CELTA_LIB . "theme-options-vars.php" ); ?>

<?php get_header(); ?>

<?php get_template_part( 'include-left' ); ?>

<div id="right" class="<?php echo strtolower( str_replace( ' ', '-', $celta_pattern_right ) ); ?>">
	<div id="blog" class="page">
	<!-- BEGIN: single post -->
	<?php 
		$blog_page = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE meta_value = 'Blog Page'" );
		$blog_page_id = $blog_page->post_id;
		$blog_subtitle = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'celta_page_subtitle' AND post_id = '$blog_page->post_id'" );
		$blog_page_post = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE id = '$blog_page_id'" );
		echo '<h2>' . $blog_page_post->post_title . '</h2>';
		if ( $blog_subtitle ) {
			echo '<p class="sub-title">' . $blog_subtitle->meta_value . '</p>';
		}
		if(have_posts()) : while(have_posts()) : the_post();?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="blog-post">
					<div class="post-title">
						<h3><?php the_title(); ?></h3>
						<div class="post-metadata">
							<p><?php 
								$post_categories = get_the_category();
								$c = array_shift ( $post_categories );
								$cats =  $c->cat_name;
								if ( count( $post_categories ) > 0 ) {
									foreach( $post_categories as $c ) {
										$cats .=  ', ' . $c->cat_name;
									}
								}
								printf( __( 'Posted on %1$s in %2$s with ', LANGUAGE ), get_the_time( 'F jS, Y' ), $cats );?>
								<a href="<?php the_permalink(); ?>"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a>
							</p>
						</div>		
					</div>
					<div class="post-content">
						<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'full', array( 'class' => "image-left", ) ); ?>
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
                        
						<a href="<?php echo home_url(); ?>#<?php echo $blog_page_post->post_name; ?>">&laquo; <?php _e( 'Back to Blog', LANGUAGE ); ?></a>
					</div>
					<div class="separator-line"></div>
					<?php comments_template(); ?>
				</div>
			</div>
		<?php endwhile;
		endif;
	?>
	<!-- END: single post -->
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>