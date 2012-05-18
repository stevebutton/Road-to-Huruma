<?php get_header(); ?>
<div class="section clearfix default">
    <div class="container_12">
        
        <div class="grid_12">
            <?php if($custom_settings["page_for_posts"] > 0) { ?>
                <div class="section-heading clearfix">
                    <?php $blog_page = get_post($custom_settings["page_for_posts"]); ?>
                    <h2><?php echo $blog_page->post_title; ?></h2>
                    <?php echo apply_filters("the_content", $blog_page->post_content); ?>
                </div><!--//section-heading-->
            <?php } ?>
        </div>
        
        <div class="clear"></div>
    
        <div class="grid_10">
            <?php get_template_part( 'loop', 'index' ); ?>
        </div>
        <div class="grid_2">
            <?php get_sidebar(); ?>
        </div>
        
    </div><!--//container_12-->
</div><!--//section-->
<?php get_footer(); ?>