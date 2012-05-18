jQuery(document).ready(function($) {

 	
snazzy_mini=parseInt(SnazzySettings.snazzy_mini);
snazzy_fx=parseInt(SnazzySettings.snazzy_fx);
snazzy_corners=parseInt(SnazzySettings.snazzy_corners);


if (snazzy_mini)
{ 
	$('.sz_day').hide();
}

if (snazzy_fx==1)
{
	$(".sz_carousel").jCarouselLite({
        btnNext: "#szright",
        btnPrev: "#szleft",
       // mouseWheel: true, // scrolling left - right with mouse wheel. you need to uncomment  mousewheel.js in the code
        visible:4,	// number of visible elements
        circular:false, //is it circular
        def_width:116,	// width + padding width
        def_height:0
    });
    
	$('.sz_month').css('width','100px');
}

if (snazzy_corners)
{
	$('.sz_img').corner();
}

	$('#toggle_pages').click(function(){     
 	    $('.sz_page').toggle();
  });
  
  $('#toggle_posts').click(function(){     
 	    $('.sz_post').toggle();
  });

  $('#toggle_all').click(function(){     
 	    $('.sz_day').toggle();
  });
  
  $('.sz_date_day').click(function(){     
 	    $(this).next('.sz_day').slideToggle();
  });

  $('.sz_date_mon').click(function(){     	    
 	    		$(this).next('.sz_month').children('.sz_day').toggle();	    
  });


});