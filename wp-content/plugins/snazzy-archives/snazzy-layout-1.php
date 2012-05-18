<div <?php echo (!$first_for_day) ? 'class="sz_clr"' : '' ?> >
<?php $imageurl = $this->getImageUrl($imageurl, 110); ?>
<div  class="sz_cont sz_img <?php echo ( ( $post->post_type=='page' ) ? "sz_page" : "sz_post" ) ?>" <?php echo $imageurl ? 'style="background: transparent url('.$imageurl.') no-repeat  center;"' : '' ?>  >
	<a href="<?php echo $url ?>" title="<?php echo ($comcount ? "$comcount comments" : "") ?>" class="<?php echo $imageurl ? "sz_titleon" : "sz_title" ?>"><?php echo $title ?></a>
	<?php if ($excerpt && !$imageurl) : ?>
		<div class="sz_excerpt">&#8220;<?php echo $excerpt ?>&#8221;</div>
	<?php endif;?>	
	</div>
</div>

