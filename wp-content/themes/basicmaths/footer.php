<?php
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_settings( $value['id'] ); }
    }
?>
		<div id="footer">
				<p><?php echo stripslashes($bm_footer_text); ?> <a href="<?php bloginfo('rss2_url'); ?>" rel="rss feed" class="rss-feed"><?php _e('RSS feed', 'basicmaths') ?></a>. <?php /*?><?php _e('This site uses the <a href="http://basicmaths.subtraction.com/" target="_blank">Basic Maths</a> theme for <a href="http://wordpress.org">WordPress</a>, designed by <a href="http://subtraction.com" rel="designer" class="designer">Khoi Vinh</a> &amp; <a href="http://fthrwght.com" rel="developer" class="developer">Allan Cole</a>.', 'basicmaths') ?><?php */?></p>
		</div>

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>