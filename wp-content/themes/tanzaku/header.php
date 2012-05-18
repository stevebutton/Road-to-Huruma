<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<!--meta name="keywords" content="" /-->
<!--meta name="description" content="" /-->

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="Shortcut Icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" type="image/x-icon" />	

<?php 
wp_enqueue_script('jquery');
if (is_singular()) wp_enqueue_script('comment-reply');
wp_head();
?>

<script src="<?php bloginfo('template_directory'); ?>/js/jquery.easing.1.3.js" type="text/javascript" charset="UTF-8"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.vgrid.0.1.4-mod.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
//<![CDATA[

function debug(text) {
  ((window.console && console.log) ||
   (window.opera && opera.postError) ||
   window.alert).call(this, text);
}
jQuery.noConflict();

(function($){
	$(function(){
		
		$('#header').css("visibility", "hidden");
		var setGrid = function () {
			return $("#grid-wrapper").vgrid({
				easeing: "easeOutQuint",
				time: 800,
				delay: 60,
				selRefGrid: "#grid-wrapper div.x1",
				selFitWidth: ["#container", "#footer"],
				gridDefWidth: 290 + 15 + 15 + 5,
				forceAnim: <?php echo (is_singular()) ? 0 : 1; ?>
			});
		};
		
		setTimeout(setGrid, 300);
		setTimeout(function() {
			$('#header').hide().css("visibility", "visible").fadeIn(500);
		}, 500);
		
		$(window).load(function(e){
			setTimeout(function(){ 
				// prevent flicker in grid area - see also style.css
				$("#grid-wrapper").css("paddingTop", "0px");
<?php if (is_singular()) : ?>
				var anim_msec = $("#single-wrapper").height();
				if (anim_msec < 1000) anim_msec = 1000;
				if (anim_msec > 3000) anim_msec = 3000;
				$("#single-wrapper").css("paddingTop", "0px").hide().slideDown(anim_msec);
<?php endif; ?>
			}, 1000);
		});

	}); // end of document ready
})(jQuery); // end of jQuery name space 

//]]>
</script>

</head>

<body <?php body_class();?>>

<noscript><p class="caution aligncenter">Enable Javascript to browse this site, please.</p></noscript>


<div id="container">
	<div id="header">
		<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
		<p><?php bloginfo('description'); ?></p>
	</div>
<?php stl_simile_timeline(); ?>