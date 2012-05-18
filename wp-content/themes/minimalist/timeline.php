<?php

/*

Single Page Template: [MAIN TIMELINE]

Description: This part is optional, but helpful for describing the Post Template

*/

?>



<?php get_header(); ?>
<?php /*?><?php get_sidebar(); ?><?php */?>

<div id="wrapper" class="clearfix" > 
<?php /*?><div id="maincol" ><?php */?>


<?php /*?><?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>

<h2 class="contentheader"><?php the_title(); ?></h2>
<div class="content">
<div class="permalink"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">Permanent Link</a></div>
<?php the_content('Read more &raquo;'); ?>


<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
<div id="postinfotext">
Posted: <?php the_time('F jS, Y') ?><br/>
Categories: <?php the_category(', ') ?><br/>
Tags: <?php the_tags(''); ?><br/>
Comments: <a href="<?php comments_link(); ?>"><?php comments_number('No Comments','1 Comment','% Comments'); ?></a>.
</div>

</div>	
<?php endwhile; ?>
<?php */?>
<?php /*?><div class="navigation">
<span class="prevlink"><?php next_posts_link('Previous entries') ?></span>
<span class="nextlink"><?php previous_posts_link('Next entries') ?></span>
</div>
		
<?php else : ?>
<h2 class="contentheader">Not found!</h2>
<p>Could not find the requested page. Use the navigation menu to find your target, or use the search box below:</p>
<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>
<?php */?>
<div><?php stl_simile_timeline(); ?></div>
<img src="/gfx/chronmenu.jpg" width="1000" height="20" />
<div id="vox">
  <object width="100%" height="200">
  <param name="allowFullScreen" value="true" /><param name="flashvars" value="showMenu=false"/><param value="showHeader=false&showMenu=false" name="FlashVars"/><param name="movie" value="http://www.vuvox.com/collage_express/collage.swf?collageID=02c794175c"/>
  <param name="wmode" value="transparent" />
  <embed src="http://www.vuvox.com/collage_express/collage.swf?collageID=02c794175c" width="100%" height="200" flashvars="showMenu=false" allowFullScreen="true" type="application/x-shockwave-flash" FlashVars="showHeader=false&showMenu=false" movie="http://www.vuvox.com/collage_express/collage.swf?collageID=02c794175c" wmode="transparent"></embed></object>
</div>
<img src="/gfx/visualmenu.jpg" width="1000" height="20" />
<?php /*?></div><?php */?>
</div>

<?php /*?><?php get_footer(); ?><?php */?>


