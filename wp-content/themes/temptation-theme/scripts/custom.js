jQuery(document).ready(function() {

//ANYTHING SLIDER
	jQuery('#slider ul').anythingSlider({
		width : 610,          // Override the default CSS width
		height: 224,
		delay: 4000,
		animationTime: 600,
		autoPlay: true,
		buildNavigation: false,
		hashTags: false, 
		easing: 'easeInExpo'
	});	

//CYCLE SLIDER
	jQuery('#slider-cycle').cycle({ 
		fx:      'growY', // transition type
		speed:    600, 
		timeout:  5000,
		cleartype: false,   //  Fixes the issue with IE6+
		startingSlide: 0,
		next: '#cycle-next',
		prev: '#cycle-prev'
	});

//REMOVES JAVASCRIPT FIX CLASSES
	jQuery('#portfolio-content').removeClass("js-off-overflow");
	jQuery('.portfolio-thumbs').removeClass("js-off-position");
	
//INITIALIZES PRETTYPHOTO PLUGIN

	jQuery("a[rel^='prettyPhoto']").prettyPhoto({overlay_gallery: false});

//ANYTHING SLIDER NAVIGATION BUTTONS
	
	var q = ["#prev-button", "#next-button", ".arrow", ".forward", ".back"];
	var buttons = q.join(", ");
	
	jQuery(".featured").hover( function() {
		jQuery(buttons).stop().show()
	}).mouseleave( function() {
		jQuery(buttons).stop().hide()
	});
	
	
//NAVIGATION
	
	jQuery('#navigation').localScroll();
	jQuery('#navigation li a').click( function () {
		jQuery('#navigation li a').removeClass("active");
		jQuery(this).addClass("active");
	});

	jQuery('#logo h1 a').click(function(){ 		
		jQuery('#navigation li a').removeClass("active");
		jQuery('#navigation li:first a').addClass("active");
		jQuery('html, body').animate({scrollTop: 0});
		
	});


// PORTFOLIO HOVER EFFECT	

 jQuery('ul.portfolio-thumbs li').hover(function(){  
         jQuery(".overlay", this).stop().animate({top:'0px'},{queue:false,duration:300});  
     }, function() {  
        jQuery(".overlay", this).stop().animate({top:'190px'},{queue:false,duration:300});  
    });  

	
//TOGGLE PANELS

	jQuery('.toggle-content').hide();  //hides the toggled content, if the javascript is disabled the content is visible

	jQuery('.toggle-link').click(function () {
		if (jQuery(this).is('.toggle-close')) {
			jQuery(this).removeClass('toggle-close').addClass('toggle-open').parent().next('.toggle-content').slideToggle(300);
			return false;
		} 
		
		else {
			jQuery(this).removeClass('toggle-open').addClass('toggle-close').parent().next('.toggle-content').slideToggle(300);
			return false;
		}
	});
	
	jQuery('#posts-navigation a').live('click', function(e){
		e.preventDefault();
		var link = jQuery(this).attr('href');
		var height = jQuery('#ajax-container').height();
		jQuery('#blog-page').css('min-height', height + 'px');
		jQuery('#ajax-container').fadeOut(500).load(link + ' #ajax-inner', function(){ jQuery('#ajax-container').fadeIn(500); });
	});

});	//END of jQuery