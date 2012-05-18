<?php
/*
* The template for displaying the footer.
*/
global $custom_settings;
?>

		<div class="end"><!-- used to give extra space, to allow the last slide to fully rise to the browser top --></div>
        
		<?php if(!$custom_settings["disable_footer"]) { ?>
		<div id="footer" class="shadow">
            <div class="container_12">
            	<div class="grid_8">
                	<?php wp_nav_menu( array( 'menu_class' => 'social', 'theme_location' => 'footer-left', 'fallback_cb' => '', 'depth' => 1 ) ); ?>
                </div>
                <div class="grid_4">
                    <?php wp_nav_menu( array( 'menu_class' => 'social right', 'theme_location' => 'footer-right', 'fallback_cb' => '', 'depth' => 1 ) ); ?>
                </div>
            </div>
        </div><!--//footer-->
		<?php } ?>

	</div><!--//outer-->
	<?php echo $custom_settings["additional_js"]; ?>
<?php wp_footer(); ?>
</body>
</html>