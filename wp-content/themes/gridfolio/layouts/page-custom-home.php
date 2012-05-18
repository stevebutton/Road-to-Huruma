<?php /* This is not a true page template but a snippet that is shared between page templates. */ ?>
<div class="grid_12">
	<!-- title removed -->
	<?php the_content(); ?>
</div><!--//grid_12-->	

<div class="clear"></div>

<div class="clearfix homewidgets">
	
	<div class="grid_3">
		<?php dynamic_sidebar( 'home-column-a' ); ?>
	</div>
	<div class="grid_3">
		<?php dynamic_sidebar( 'home-column-b' ); ?>
	</div>
	<div class="grid_3">
		<?php dynamic_sidebar( 'home-column-c' ); ?>
	</div>
	<div class="grid_3">
		<?php dynamic_sidebar( 'home-column-d' ); ?>
	</div>
	
	<?php
	/*
	
	Alternate layout, 3 columns:
		<div class="grid_4">Add content.</div>
		<div class="grid_4">Add content.</div>
		<div class="grid_4">Add content.</div>
	
	Alternate layout, 2 columns:
		<div class="grid_6">Add content.</div>
		<div class="grid_6">Add content.</div>
		
	Alternate layout, 1 column:
		<div class="grid_12">Add content.</div>
	*/
	?>
	<?php edit_post_link(null, '<div class="clear"></div><p class="grid_12">', '</p>'); ?>
</div><!--//homewidgets-->