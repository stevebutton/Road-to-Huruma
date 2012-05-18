<?php /* This is not a true page template but a snippet that is shared between page templates. */ ?>
<div class="grid_12">
	<div class="section-heading clearfix">
		<?php edit_post_link(null, "<small class='right'>", '</small>'); ?>
		<h2><?php the_title(); ?></h2>
	</div><!--//section-heading-->
</div><!--//grid_12-->

<div class="clear"></div>

<div class="grid_6">
	<?php the_content(); ?>
</div>
<div class="grid_6">
    <?php echo do_shortcode('[cudazi_contact]'); ?>   
</div>
