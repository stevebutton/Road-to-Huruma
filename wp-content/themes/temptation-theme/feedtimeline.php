<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */

global $more;
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true); 
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>


<data>
                                                                                  
	<?php while( have_posts()) : the_post(); $more = 0; ?>           
  <?php if ( is_category($_GET['cat']) ) { ?>

  <event
  <?php $date = mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?>
    start="<?php echo $date; ?>"
    end="<?php echo $date; ?>"
    title="<?php the_title_rss() ?>"
    image="http://crash-box.fr.s14582.gridserver.com/countdown/php/countdown.php?type=min&#38;timestamp=<?php echo strtotime($date); ?>">
    <![CDATA[<?php $content = get_the_content('[..]'); echo $content; ?>]]>                                     
	</event>
	<?php } ?>
	<?php endwhile; ?>

</data>
