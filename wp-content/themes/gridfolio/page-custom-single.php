<?php 
/*
* Template Name: Display All Pages
*/

//
//	Create a page using this template
// 	It will pull in all pages except the current and the page for posts (blog)
//

get_header(); ?>
<?php global $custom_settings; ?>
	
	<?php
		$the_page_id = $post->ID; // Current page id, used to exclude from the loop below
		
		$custom_query_args = array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order'=> 'ASC',
			'posts_per_page' => -1
		);
		$my_query = null;
		$my_query = new WP_Query($custom_query_args);
		
		if( $my_query->have_posts() ) 
		{
			
			while ($my_query->have_posts())
			{
				
				$my_query->the_post(); // Get things going
				if($my_query->post->ID != $the_page_id) // Do not include self (current page)
				{
					
					if($my_query->post->ID != $custom_settings["page_for_posts"])
					{
						?>
						<a name="go-<?php echo $my_query->post->post_name; ?>" id="go-<?php echo $my_query->post->post_name; ?>"></a><!--//scroll to anchor-->
						<div class="section clearfix default">
							<div class="container_12">
								<?php
								$page_template = "";
								$page_template = get_post_meta($my_query->post->ID,'_wp_page_template',true); 
								$page_template = str_replace(".php", "", $page_template); 
								include('layouts/' . $page_template . ".php");
								?>
							</div><!--//container_12-->
						</div><!--//section-->
						<?php	
					} // End if - not page for posts
					
				}// End if - current page check
			
			}//endwhile;
			
		}else{
			echo cudazi_admin_message("No pages! Add some using the Pages > Add New in the WordPress admin.", 'error', '');
		}// if have posts
		
		wp_reset_query();  // Restore global post variable
		
	?>
<?php get_footer(); ?>