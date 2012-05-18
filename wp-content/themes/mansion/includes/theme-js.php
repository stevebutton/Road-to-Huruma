<?php

// Load Base Javascripts
if (!is_admin()) add_action( 'init', 'load_base_js' );
function load_base_js( ) {
	wp_enqueue_script('jquery');
	wp_enqueue_script('search', get_bloginfo('template_directory').'/includes/js/search.js', array( 'jquery' ) );
	wp_enqueue_script('swfobject');
}

// Load Conditional Javascripts
function load_conditional_js() {	
	if(!is_single() && !is_page() || is_page_template('page-blog.php'))
		wp_enqueue_script('masonry', get_bloginfo('template_directory').'/includes/js/jquery.masonry.min.js', array('jquery'));
}

// Load Dom Ready Javascripts
function load_dom_ready_js() {

	if(!is_single() && !is_page() || is_page_template('page-blog.php')) {
	
	$doc_ready_script = '
	<script type="text/javascript">
	
		// apply masonry on load
      	jQuery(window).load(function() {
	 		jQuery("#container").masonry({animate: true});
	 		jQuery("#footer").adjustFooterWidth();
	 	});

		jQuery(document).ready(function(){
			
			// adjust menu height
			var menuheight = parseInt(jQuery("div.menu").height());';
			

	if(is_archive()){
		$doc_ready_script .= '
	      	if(menuheight < 150) { jQuery("#nav").height(170); }
	      	if(menuheight > 150) { jQuery("#nav").height(212); }';
	}


	if(!is_archive()) {
	   $doc_ready_script .= '
	      	if(menuheight < 150) { jQuery("#nav").height(100); }
	      	if(menuheight > 150) { jQuery("#nav").height(251); }';
	}

	$doc_ready_script .= '		
			
	      	// apply masonry on resize
	      	jQuery(window).resize(function() {
		 		jQuery("#footer").adjustFooterWidth();
		 	});		

		 	// apply opacity on hover
		 	jQuery(".box, #footer").css({opacity: 0}); 	// Initial opacity 0
		 	jQuery("#footer").fadeTo(900, 1.0); 	// fade #footer opacity to 1.0
			jQuery(".box").fadeTo(900, 0.8); 	// fade box opacity to 0.8
			jQuery(".gpplogo, .wplogo").fadeTo(900, 0.6); 	// fade logos opacity to 0.4
			jQuery(".box").hover(function(){
				jQuery(this).fadeTo("fast", 1.0); 	// fade to 1.0
			},function(){
   				jQuery(this).fadeTo("fast", 0.8); 	// fade back to 0.8
			});	

			jQuery(".gpplogo, .wplogo").hover(function(){
				jQuery(this).fadeTo("fast", 1.0); 	// fade to 1.0
			},function(){
   				jQuery(this).fadeTo("fast", 0.6); 	// fade back to 0.8
			});

		});

		jQuery.fn.adjustFooterWidth = function() {
   			var noOfColumns = jQuery("#container").data("masonry").colCount;
			var totalWidth = noOfColumns * (jQuery(".box").width() + 1 ) ;
			jQuery(this).width(totalWidth - 40);
		};

	</script>';
	
	echo $doc_ready_script;
	}
	
}

// Add Javascripts

add_action('template_redirect', 'load_conditional_js');
add_action('wp_head', 'load_dom_ready_js');