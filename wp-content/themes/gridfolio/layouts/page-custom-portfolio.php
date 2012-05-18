<?php /* This is not a true page template but a snippet that is shared between page templates. */ ?>
<div class="grid_12">
	<div class="section-heading clearfix">
		<?php edit_post_link(null, "<small class='right'>", '</small>'); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	</div><!--//section-heading-->
</div><!--//grid_12-->

	<?php
	$custom_query_args = array(
			'posts_per_page' => -1,
			'post_type'	=> 'portfolio',
			'orderby' => 'menu_order',
			'order'=> 'ASC',
		);
		
		$portfolio_query = null;
		$portfolio_query = new WP_Query($custom_query_args);
		
		if( $portfolio_query->have_posts() ) 
		{
			while ($portfolio_query->have_posts())
			{
				$portfolio_query->the_post(); // Get things going
				$slider_id = "slider_" . $portfolio_query->post->ID;
				
				// Custom Inputs
				$custom = get_post_custom($portfolio_query->post->ID);
				$subheading = $custom["custom_subheading"][0]; 
				
				?>
				<div class="clear"></div>
				<div class="portfolio-large clearfix">
				<div class="grid_8">
						<div id="<?php echo $slider_id; ?>" class="slider">
							<?php
								$arr_of_attachments = $get_attachment_options = $arr_slider_options = array(); // Reset Arrays
								
								// Get Attachment function options
								$get_attachment_options["id"] = $portfolio_query->post->ID;
								$get_attachment_options["linkto"] = "attachment";
								
								// Get array of attachments using the get_attachment_options array
								$arr_of_attachments = cudazi_get_attachment_files( $get_attachment_options );
								
								// Slider Settings
								$arr_slider_options["class"] = "clean";
							?>
                            
                            <?php if( count($arr_of_attachments) > 1 ){ ?>
                                <a class="prev shadow"><span>&laquo;</span></a>
                                <a class="next shadow"><span>&raquo;</span></a>
                            <?php } ?>
                            
                            <?php
								if( $arr_of_attachments ){
									echo cudazi_create_slider( $arr_of_attachments, $arr_slider_options );
								}else{
									echo __('No image attachments for this portfolio item.','cudazi');
								}
							?>
						</div>
						<?php if( count($arr_of_attachments) > 1 ){ ?>
							<script type="text/javascript">
								//jQuery(window).load(function($) {
								jQuery(document).ready(function($){
									var sliderID = "#<?php echo $slider_id; ?>";
									$(sliderID).jCarouselLite({
										btnNext: sliderID + " .next",
										btnPrev: sliderID + " .prev",
										visible: 1
									});
								});
							</script>
						<?php } ?>
				</div><!--//grid_8-->
				<div class="grid_4">
					<?php if($subheading){ echo "<p class='meta'>" . $subheading . "</p>"; }; ?>
					<h3><?php the_title(); ?></h3>
					<?php the_content(); ?>
					<?php edit_post_link(null, '<p><small>', '</small></p>'); ?>
				</div><!--//grid_4-->
			</div>
			<?php	
		}//endwhile;
		
	}else{
		// No Posts
	}// if have posts
	
	wp_reset_query();  // Restore global post variable
?>