<?php /* This is not a true page template but a snippet that is shared between page templates. */ ?>
<div class="grid_12">
	<div class="section-heading clearfix">
		<?php edit_post_link(null, "<small class='right'>", '</small>'); ?>
		<h2><?php the_title() ?></h2>
	</div><!--//section-heading-->
	<?php the_content(); ?>
</div><!--//grid_12-->