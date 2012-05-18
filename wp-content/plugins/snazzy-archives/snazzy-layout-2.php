<div class="sz_cont <?php echo ( ( $post->post_type=='page' ) ? "sz_page" : "sz_post" ) ?>" >
	<a class="sz_title" href="<?php echo $url ?>"><?php echo $title ?></a>					
    <?php $imageurl = $this->getImageUrl($imageurl, 110); ?>
	<?php if ($imageurl) : ?>	
		<div class="sz_img" style="background: transparent url('<?php echo $imageurl ?>') no-repeat  center;" ></div>
		<div class="sz_excerpt"><?php echo ($comcount ? "<strong>$comcount comments</strong>" : "") ?></div>						
	<?php elseif ($excerpt)  : ?>	
		<div class="sz_excerpt">&#8220;<?php echo $excerpt ?>&#8221; <?php echo ($comcount ? "<br/><strong>$comcount comments</strong>" : "") ?></div>
	<?php endif; ?>				
</div> 