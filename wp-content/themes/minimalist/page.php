<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="wrapper" class="clearfix" > 
<div id="maincol" >



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h2 class="contentheader"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<?php the_content('<p class="serif">Read more &raquo;</p>'); ?>
<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
<?php edit_post_link('Edit this page','<p>','</p>'); ?>

<?php comments_template(); ?>

<?php endwhile; endif; ?>



</div>
</div>

<?php get_footer(); ?>
<div><?php stl_simile_timeline(); ?></div>