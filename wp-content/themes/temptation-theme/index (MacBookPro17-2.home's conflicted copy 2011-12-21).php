<?php require( CELTA_LIB . "theme-options-vars.php" ); ?>

<?php get_header(); ?>

<div id="container">
<?php get_template_part( 'include-left' ); ?>

<div id="right" class="<?php echo strtolower( str_replace( ' ', '-', $celta_pattern_right ) ); ?>">
	
	<!-- BEGIN: pages -->
	<?php 
		$pages = get_pages( 'sort_order=asc&sort_column=menu_order&depth=1' );
		foreach ( $pages as $pag ) {
			setup_postdata( $pag );
			$new_title = str_replace( " ", "", strtolower( $pag->post_name ) );
			echo '<div class="page" id="' . $new_title . '">';
				echo '<h2>';
				echo ( get_post_meta( $pag->ID, 'celta_page_title', true ) ) ? get_post_meta( $pag->ID, 'celta_page_title', true ) : $pag->post_title;
				echo '</h2>';
				echo '<p class="sub-title">' . get_post_meta( $pag->ID, 'celta_page_subtitle', true ) . '</p>';
				$page_type = str_replace( ' ', '', strtolower( get_post_meta( $pag->ID, 'celta_page_type', true ) ) );
				if ( $page_type == 'portfoliopage' ) {
					echo '<div id="portfolio-content" class="js-off-overflow">';
					echo '<ul id="page1" class="portfolio-thumbs js-off-position">';
					if ( get_post_meta( $pag->ID, 'celta_portfolio_category', true ) != 'All' ) {
						$portfolio_cat = get_post_meta( $pag->ID, 'celta_portfolio_category', true );
						$loop = new WP_Query( array( 'post_type' => 'portfolio_item', 'posts_per_page' => -1, 'tax_query' => array( array( 'taxonomy' => 'portfolio_category', 'field' => 'slug', 'terms' => $portfolio_cat ) ) ) );
					} else {
						$loop = new WP_Query( array( 'post_type' => 'portfolio_item', 'posts_per_page' => -1 ) );
					}
					while ( $loop->have_posts() ) : $loop->the_post(); 
						$thumb = get_post_thumbnail_id(); $image = celta_resize( $thumb, '', 190, 190, true );
						$item_name = str_replace( ' ', '', strtolower( $post->post_name ) ) ?>
						<li>
							<a href="#"><img src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" alt="<?php the_title_attribute(); ?>" /></a>
							<div class="overlay">
								<h5><?php the_title(); ?></h5>
								<?php the_content(); ?>
								<a class="zoom-btn" href="<?php echo get_post_meta( $post->ID, 'celta_full_img_1', true ); ?>" rel="prettyPhoto[<?php echo $item_name; ?>]" title="<?php the_title_attribute(); ?>"></a>
							</div>
							<div class="extra_lightbox" style="display: none">
								<?php
									for ($i = 2; $i <= 5; $i++) {
										if ( get_post_meta( $post->ID, 'celta_full_img_' . $i, true ) ) { ?>
											<a href="<?php echo get_post_meta( $post->ID, 'celta_full_img_' . $i, true ); ?>" title="<?php the_title_attribute(); ?>" rel="prettyPhoto[<?php echo $item_name; ?>]"><?php the_title_attribute(); ?></a>
										<?php }
									}
									
								?>
							</div>
						</li>
					<?php endwhile;
					echo '</ul>';
					echo '</div>';
				} elseif ( $page_type == 'blogpage' ) {
					$loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'paged' => $paged ) );
					echo '<div id="blog-page"><div id="ajax-container"><div id="ajax-inner">';
					while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<div class="blog-post">
							<div class="post-title">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="post-metadata">
									<p><?php 
										$post_categories = get_the_category();
										$c = array_shift ( $post_categories );
										$cats =  $c->cat_name;
										if ( count( $post_categories ) > 0 ) {
											foreach( $post_categories as $c ) {
												$cats .=  ', ' . $c->cat_name;
											}
										}
										printf( __( 'Posted on %1$s in %2$s with ', LANGUAGE ), get_the_time( 'F jS, Y' ), $cats );?>
										<a href="<?php the_permalink(); ?>"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a>
									</p>
								</div>								
							</div>
							<div class="post-content">
								<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'full', array( 'class' => "image-left", ) ); ?>
								<?php the_excerpt(); ?>
								<a class="post-more-link" href="<?php the_permalink(); ?>"><?php _e ( 'Continue reading', LANGUAGE ); ?></a>
							</div>
						</div>
						<div class="separator-line"></div>
					<?php endwhile; ?>
					<div id="posts-navigation">	
						<div class="alignleft"><?php next_posts_link( '&laquo; Older Entries', $loop->max_num_pages ) ?></div>
						<div class="alignright"><?php previous_posts_link( 'Newer Entries &raquo;' ) ?></div>
					</div>
					<?php echo '</div></div></div>';
				} else {
					the_content();
				} 
			echo '</div>';
		}
	?>
	<!-- END: pages -->
	
</div>
<?php get_template_part( 'include-right' ); ?>
</div>
<?php wp_footer(); ?>


<!--------------SITE TRANSITIONS AND EFFECTS--------------->

 <script>
 
<!-- XXXXXXXXCURSORSXXXXXXXXXXX-->

	$("#goopen").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#gosite").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#gomap").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#gostory").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#gologin").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	
	$("#titlelanding").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	
	$("#gomonths").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#goweeks").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#godays").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#gotoday").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	$("#gozoom").hover(function() {
		$(this).css('cursor','pointer');
	}, function() {
 		$(this).css('cursor','auto');
	});
	
	
   /**********ENTERSITE**************/


	$( "#gosite" ).click(function(){
	$('#iframeholder').fadeOut(1000);
	$("#fullmap").fadeOut(1000);
	$( "#titlelanding" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "75px" }, 1000 )
	$( "#left" ).delay(600).fadeIn(1000);
		$( "#right" ).delay(600).fadeIn(1000);
		
		
	});
	
	$( "#titlelanding" ).click(function(){
	$( "#titlelanding" ).fadeOut(1000);
	$( "#titlebook" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "75px" }, 1000 )
	
		$( "#left" ).delay(600).fadeIn(1000);
		$( "#right" ).delay(600).fadeIn(1000);
		$( "#controlbox" ).delay(1400).fadeIn(1000);
	});

	$( "#goopen" ).click(function(){
	$('#iframeholder').fadeOut(1000);
		$( "#right" ).fadeOut(1000);
		$( "#left" ).fadeOut(1000);
		$( "#controlbox" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "100%" }, 1000 )
		$( "#titlelanding" ).delay(2000).fadeIn(1000);
		
	});
	
	$( "#gostory" ).click(function(){
		$( "#right" ).fadeOut(1000);
		$( "#left" ).fadeOut(1000);
		$("#fullmap").fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "100%" }, 1000 )
		$( "#titlelanding" ).delay(1000).fadeIn(1000).animate({ top: "0px" }, 1000 )
		$( "#application" ).delay(1000).animate({ top: "500px" }, 1000 )
		$('#iframeholder').fadeIn(1000).animate({ top: "100px" }, 1000 );
	});
	
	$( "#gomap" ).click(function(){
		zoomToToday();
		$( "#right" ).fadeOut(1000);
		$( "#left" ).fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "100%" }, 1000 )
		$( "#titlelanding" ).delay(1000).fadeOut(1000).animate({ top: "0px" }, 1000 )
		$("#application").delay(1000).fadeOut(1000);
		$('#iframeholder').animate({ top: "900px" }, 1000 ).fadeOut(1000);
		$("#fullmap").fadeIn(1000).animate({ top: "0px" }, 1000 )
	});
	
	$( "#gologin" ).click(function(){
		$( "#right" ).fadeOut(1000);
		$( "#left" ).fadeOut(1000);
		$("#fullmap").fadeOut(1000);
		$( "#farright" ).delay(1000).animate({ width: "100%" }, 1000 )
		$( "#titlelanding" ).delay(1000).fadeIn(1000).animate({ top: "0px" }, 1000 )
		$('#iframeholder').delay(3000).fadeOut(1000);
		$( "#application" ).delay(1000).fadeIn(1000).animate({ top: "500px" }, 1000 )
	});
	
	
	$("#mapfooterlib").click(function(){
	$( "#my-library" ).fadeIn(500);
	$( "#my-mdgselect" ).fadeOut(500);
    $( "#mapcontainer" ).animate({ bottom: "400px" }, 1000 )
	 $( "#timelinecontainer" ).animate({ height: "400px" }, 1000 )
	  $( "#my-timeline" ).delay(1000).animate({ height: "185px" }, 1000 )
	  $( "#mapfooterlib" ).fadeOut(500);
	  $( "#mapfooterlibhide" ).fadeIn(500);
	});
	
	
	$("#mapfooterlibhide").click(function(){
    $( "#mapcontainer" ).animate({ bottom: "200px" }, 1000 )
	 $( "#timelinecontainer" ).animate({ height: "200px" }, 1000 )
	  $( "#my-timeline" ).delay(1000).animate({ height: "100%" }, 1000 )
	  $( "#mapfooterlibhide" ).fadeOut(500);
	  $( "#mapfooterlib" ).fadeIn(500);
	});


$("#mapfootergoals").click(function(){
$( "#my-library" ).fadeOut(500);
$( "#my-mdgselect" ).fadeIn(500);
    $( "#mapcontainer" ).animate({ bottom: "400px" }, 1000 )
	 $( "#timelinecontainer" ).animate({ height: "400px" }, 1000 )
	  $( "#my-timeline" ).delay(1000).animate({ height: "185px" }, 1000 )
	  $( "#mapfooterlib" ).fadeOut(500);
	   
	  $( "#mapfooterlibhide" ).fadeIn(500);
	});
	
function zoomToPosition()
{
var point = tm.getSelected();
if (!point) { return; } 
point = point.placemark.location;
tm.map.setZoom(16);
tm.map.setCenter(point);
}	
	

$("#goarrowleft").click(function(){
    slideToLeft();
});

$("#goarrowright").click(function(){
    slideToRight();
});

$("#gomonths").click(function(){
    zoomToMonths();
});
$("#goweeks").click(function(){
    zoomToWeeks();
	
	$( "#mapcontainer" ).animate({ bottom: "200px" }, 1000 )
	 $( "#timelinecontainer" ).animate({ height: "200px" }, 1000 )
	  $( "#my-timeline" ).delay(1000).animate({ height: "100%" }, 1000 )
	  $( "#mapfooterlibhide" ).fadeOut(300);
	  $( "#mapfooterlib" ).fadeIn(300);
});
$("#godays").click(function(){
    zoomToDays();
});
$("#gotoday").click(function(){
    zoomToToday();
});
$("#gozoom").click(function(){
    zoomToPosition();
});




	
</script>



</body>
</html>