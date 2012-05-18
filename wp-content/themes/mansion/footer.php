</div>
<div id="footer">
	<?php stl_simile_timeline(); ?>
	<div class="copyright">
	<?php /*?>	&copy; All rights reserved by <?php bloginfo('name'); ?>.<?php */?>
	</div>
	
	<div class="powered">
		<?php /*?><a href="http://graphpaperpress.com" title="Designed by Graph Paper Press" class="gpplogo">Graph Paper Press</a>
		<a href="http://wordpress.com" title="Powered by WordPress" class="wplogo">WordPress</a><?php */?>
	</div>
	<?php if(is_home() || is_archive()): ?>
	<div class="navigation">		
		<div class="prev"><?php previous_posts_link(__('Previous &raquo;')); ?></div>
		<div class="next"><?php next_posts_link(__('&laquo; Next')); ?></div>
	</div>
	<?php endif; ?>
	
</div>
<?php wp_footer(); ?>
</body>
</html>
