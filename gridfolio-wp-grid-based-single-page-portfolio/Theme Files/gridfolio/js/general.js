jQuery.noConflict();
jQuery(document).ready(function($){
   
   /*
   *	Used to scroll to a specific position.
   *	Edit the variables below to adjust speed and positioning
   */
	var scrollDuration = 500; // 1000 = 1 second
	var scrollGap = 0; // in Pixels, the gap left above the scroll to point
	
	$('a[href*=#go-]').click(function() 
	{
		if (
			location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && 
			location.hostname == this.hostname
			) 
		{
			var $target = $(this.hash);
			$target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
			if ($target.length) 
			{
				var targetOffset = $target.offset().top - scrollGap;
				$('html,body').animate
					(
					{scrollTop: targetOffset}, 
					scrollDuration
					);
				
				// Remove all "active" classes
				$("a").removeClass("active");
				
				// Set "active" class on clicked item
				$(this).addClass("active");
								
				return false;
			}
		}
	});
	
	
	
	
	
	// Click to remove text feature
	$('#cf_name,#cf_email,#cf_message,#s').each(function() {
		var original_txt = this.value;
		
		$(this).focus(function() 
		{
			if(this.value == original_txt) { this.value = ''; }
		});
		$(this).blur(function() 
		{
			if(this.value == '') { this.value = original_txt; }
		});
	});
	
	
	// Slider navigation expand and contract
	var extraPadding = '15px';
	$('.slider a.prev').hover(function() {
		$(this).animate({ paddingLeft : "+="+extraPadding }, 100);        
	}, function() {
		$(this).animate({ paddingLeft : "-="+extraPadding }, 100);
	});
	$('.slider a.next').hover(function() {
		$(this).animate({ paddingRight : "+="+extraPadding }, 100);       
	}, function() {
		$(this).animate({ paddingRight : "-="+extraPadding }, 100);  
	});
	
	
	// Thumbnail hover
	$(".gallery .thumb").hover(function(){
		$(this).stop().animate({ opacity: '0.8'}, 100);
	}, function() {
		$(this).stop().animate({ opacity: '1'}, 200);
	});
	//
	
	
	// contact form validation
	var hasChecked = false;
	$("#cf_submit").click(function () { 
		hasChecked = true;
		return checkForm();
	});
	$("#cf_name,#cf_email,#cf_message").live('change click', function(){
		if(hasChecked == true)
		{
			return checkForm();
		}
	});
	function checkForm()
	{
		var hasError = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if($("#cf_name").val() == '') {
			hasError = true;
		}
		if($("#cf_email").val() == '') {
			hasError = true;
		}else if(!emailReg.test( $("#cf_email").val() )) {
			hasError = true;
		}
		if($("#cf_message").val() == '') {
			hasError = true;
		}
		if(hasError == true)
		{
			$("#contact-form-errror").fadeIn();
			return false;
		}else{
			return true;
		}
	}
	// end contact form validation
	

	//	********************************
	//	Add additional functions here...
	//	********************************
	
	
}); // end document.ready


	
