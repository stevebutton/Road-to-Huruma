		<div id="primary" class="sidebar">
		
			<ul class="xoxo">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('left-sidebar') ) : ?>  
				<li id="basic-maths-recent-posts" class="widget widget_basic_maths_recent_posts">
					<h3><?php _e( 'Recent Posts', 'basicmaths' ) ?></h3>
					<ul>
<?php
global $post;
$myposts = get_posts('post_type=post&showposts=5');
foreach($myposts as $post) :
?>
						<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><span class="recent-post-date"><?php the_time('M j, ’y'); ?></span> <?php the_title(); ?></a></li>
<?php endforeach; ?>
					</ul>
				</li>
	
				<li id="basic-maths-more-info" class="widget widget_basic_maths_more_info">
					<h3><?php _e( 'More Info', 'basicmaths' ) ?></h3>
					<ul>
						<li class="entries-rss"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e( 'RSS Feed for Entries', 'basicmaths' ) ?></a></li>
						<li class="comments-rss"><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e( 'RSS Feed for Comments', 'basicmaths' ) ?></a></li>
<?php /*?>						<li class="wordpress-link"><a href="http://wordpress.org" target="_blank"><?php _e( 'Powered by WordPress', 'basicmaths' ) ?></a></li>
<?php */?>					</ul>
				</li>
<?php endif; ?>  
			</ul>
			
		</div><!-- #primary -->
	
		<div id="secondary" class="sidebar">

			<ul class="xoxo">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('right-sidebar') ) : ?>  
				<li id="basic-maths-archives" class="widget widget_basic_maths_archives">
					<h3><?php _e( 'Archives', 'basicmaths' ) ?></h3>
					<ul>
<?php abbr_basic_date_arhives(); ?>
					</ul>
				</li>
<?php endif; ?>
			</ul>
			
		</div><!-- #secondary -->
		