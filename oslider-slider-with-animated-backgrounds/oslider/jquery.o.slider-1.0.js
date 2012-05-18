(function($){  
  
	$.fn.oSlider = function(options){
		$.fn.oSlider.defaults = {
			animSpeed:1000,
			liquidLayout: true,
			
			autoStart: false,
			pauseTime:3000,
			
			arrowsNav:true,
			arrowsNavHide:false,
			
			listNav:true,
			listNavThumbs:false,
			listNavThumbName:'_thumb',
			
			pauseOnHover: false,
			
			layers: false
		};
		var settings = $.extend({}, $.fn.oSlider.defaults, options);
		
		var blocks = {
			frame: '<div class="o-slider-frame">',
			images: '<div class="o-slider-images">',
			image_outer: '<div class="o-slider-image-outer">',
			image: '<div class="o-slider-image">'
		};
		
		var $previous = $('<div class="o-slider-arrows previous"></div>');
        var $next = $('<div class="o-slider-arrows next"></div>');
		var $switcher = $('<ul class="switcher"></ul>');
		
        var $this = $(this);
        
        var init = {
        	height: $this.height(),
            width: $this.width(),
            images_total: $this.find('img').length,
            images_amount: $this.find('img').length
        };
        
        if(settings.layers){
        	var layers = settings.layers;
        }
        
        var current_image = 1;
                
		var make = function()
        {
			var images = $('img', $this);
			
			$.each(images, function(key, value) {
				if($(value).parent('a').length > 0){
					$(value).parent('a').addClass('img_holder').wrap(blocks.image);
				} 
				else {
					$(value).wrap(blocks.image);
				}
				
				var img_rel = $(value).attr('rel');
				if(img_rel && $('div#'+img_rel).length > 0){
					$('div#'+img_rel).addClass('o-slider-caption');
					
					if($(value).parent('a').length > 0){
						$(value).parent('a').parent('div').append($('div#'+img_rel));
					}
					else {
						$(value).parent('div').append($('div#'+img_rel));
					}
				}
				img_rel = 0;
			});
			
			$('div.o-slider-image', $this).wrap(blocks.image_outer);
			$this.addClass('o-slider-external').wrapInner(blocks.frame);
			$('div.o-slider-frame',$this).wrapInner(blocks.images).append($switcher);
           
			if(settings.arrowsNav){
        		$('div.o-slider-frame',$this).append($previous).append($next);
        		if(settings.arrowsNavHide){
        			$('div.o-slider-arrows',$this).hide();
        		}
			}
           
            if(settings.listNav){
	           if(settings.listNavThumbs){
	        	   $switcher.addClass('o-slider-listNavThumbs');
	        	   $.each(images, function(key, value) {
	        		   var img_src = $(value).attr('src');
	        		   var img_src_parts = img_src.split(".")  ;
	        		   var img_thumb = img_src_parts[0]+settings.listNavThumbName+'.'+img_src_parts[1];
	        		   $switcher.append('<li><img src="'+img_thumb+'" /></li>');
	        	   });
	           }
	           else {
	        	   $switcher.addClass('o-slider-listNav');
	        	   for(t=0;t<init.images_total;t++){
		        	   $switcher.append('<li></li>');
		           } 
	           }
	           $('li:first-child',$switcher).addClass('active');
	           $switcher.css('left', ($('div.o-slider-frame', this).width() - $switcher.width())/2 );
           }
           
           $('div.o-slider-images', $this).width( init.width * init.images_total);
           $('div.o-slider-image-outer', $this).width( init.width );
 
           if(layers){
	           $.each(layers, function(key, value) { 
	        	   var layerClass;
	        	   var o,c,d;
	          	   	$.each(value, function(key, value) { 
	          		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	          		   if(key == 'className') { c = value; }
	          		   if(key == 'direction') { d = value; }
	          	   	});
	          	   	
	          	   	$this.append('<div class="o-slider-layer '+c+'"></div>');
	          	   	$('div.'+c, $this).width(init.width*init.images_total).height(init.height);
	          	   	
	          	   	if(d == 'ltr') {
					   $('div.'+c, $this).css('left','0');
	          	   	} 
	          	   	if(d == 'rtl'){
					   var rtl_offset = init.width*(init.images_total-1)*o/100;
					   $('div.'+c, $this).css('left','-'+rtl_offset+'px');
	          	   	}
	          	   	
	          	   	o = c = d = 0;
	           });
            }
        };
        
        if(settings.liquidLayout){
        	$(window).resize(function() {
	        	init.width = $this.width();
	        	
	        	$('div.o-slider-images', $this).width( init.width * init.images_total );
	            $('div.o-slider-image-outer', $this).width( init.width );
	            
	            if(layers){
		            $.each(layers, function(key, value) { 
		            	var o,c,d;
		           	   	$.each(value, function(key, value) { 
		           		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
		           		   if(key == 'className') { c = value; }
		           		   if(key == 'direction') { d = value; }
		           	   	});
		           	   	
		           	   	$('div.'+c, $this).width(init.width*init.images_total);
		           	 
		           	   	if(d == 'rtl'){
			           	   	$('div.'+c, $this).css('left', '0px');
				            $('div.'+c, $this).css('left', '-'+init.width*(init.images_total-current_image)*o/100+'px');
		           	   	}
		           	   	if(d == 'ltr') {
				            $('div.'+c, $this).css('left', '0px');
				            $('div.'+c, $this).css('left', '-'+init.width*(current_image-1)*o/100+'px');
		           	   	}
		           	   	
		           	   	o = c = d = 0;
		            });
	            }
	            
	            $('div.o-slider-images', $this).css('left', '0px');
	            $('div.o-slider-images', $this).css('left', '-'+init.width*(current_image-1)+'px');
	        });
        }
        
        $previous.bind('click', function(){
     	   if(init.images_amount < init.images_total){
     		   $this.find('div.o-slider-images').animate({
        		   left: '+='+init.width
        	   }, settings.animSpeed);
        	  
     		   if(layers){
	        	   $.each(layers, function(key, value) { 
	        		   var o,c,d;
	            	   $.each(value, function(key, value) { 
	            		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	            		   if(key == 'className') { c = value; }
	            		   if(key == 'direction') { d = value; }
	            	   });
	            	   
	            	   $this.find('div.'+c).animate({
	            		   left: (d && d == 'rtl') ? '-='+Math.floor(init.width*o/100) : '+='+Math.floor(init.width*o/100)
		        	   }, settings.animSpeed);
	            	   
	            	   o = c = d = 0;
	               });
     		   }
     		  
        	   init.images_amount++;
        	   $switcher.find('li').removeClass('active');
        	   var switcher_position = init.images_total - init.images_amount;
        	   $switcher.find('li:eq('+switcher_position+')').addClass('active');
        	   current_image--; //!!!
     	   } else {
     		   return false;
     	   }
        });
        
        $next.bind('click', function(){ 
     	   if(init.images_amount > 1){
     		   $this.find('div.o-slider-images').animate({
        		   left: '-='+init.width
        	   }, settings.animSpeed);
        	  
     		   if(layers){
	        	   $.each(layers, function(key, value) { 
	        		   var o,c,d;
	            	   $.each(value, function(key, value) { 
	            		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	            		   if(key == 'className') { c = value; }
	            		   if(key == 'direction') { d = value; }
	            	   });
	            	   
	            	   Math.floor(init.width*o/100);
	            	   
	            	   $this.find('div.'+c).animate({
		        		   left: (d && d == 'rtl') ? '+='+Math.floor(init.width*o/100) : '-='+Math.floor(init.width*o/100)
		        	   }, settings.animSpeed);
	            	   
	            	   o = c = d = 0;
	               });
     		   }
     		   
        	   init.images_amount--;
        	   current_image++; //!!!
        	   $switcher.find('li').removeClass('active');
        	   var switcher_position = init.images_total - init.images_amount;
        	   $switcher.find('li:eq('+switcher_position+')').addClass('active');
     	   } else {
     		   if(settings.autoStart){
     			  $('ul.switcher li:first', $this).trigger('click');
     		   }
     		   return false;
     	   }
        });
        
        var timer = '';
        
        if(settings.autoStart){
        	timer = setInterval( function(){ $next.trigger('click') }, settings.pauseTime );
        }
        if(settings.pauseOnHover && settings.autoStart){
			$this.hover(function(){
				clearInterval(timer);
				timer = '';
			}, function(){
				if(timer == ''){
					timer = setInterval( function(){ $next.trigger('click') }, settings.pauseTime );
				}
			});
		}
        
        if(settings.arrowsNav && settings.arrowsNavHide){
        	$this.hover(function(){
				$('div.o-slider-arrows',$this).show();
			}, function(){
				$('div.o-slider-arrows',$this).hide();
			});
        }
        
        $('ul.switcher li', this).live('click', function(){
        	var selected_position = $(this).prevAll().length + 1;
        	var current_position = init.images_total - init.images_amount + 1;
        	
        	$(this).parent('ul').find('li').removeClass('active');
        	$(this).addClass('active');
        	
        	var offset = current_position - selected_position;
        	
        	if(offset<0){
        		$('div.o-slider-images', $this).animate({
	      		   left: '-='+init.width*Math.abs(offset)
	      	   	}, settings.animSpeed);
        		if(layers){
		        	$.each(layers, function(key, value) { 
	        		   var o,c,d;
	            	   $.each(value, function(key, value) { 
	            		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	            		   if(key == 'className') { c = value; }
	            		   if(key == 'direction') { d = value; }
	            	   });
	            	   
	            	   $('div.'+c, $this).animate({
	            		   left: (d && d == 'rtl') ? '+='+Math.floor(init.width*o/100)*Math.abs(offset) : '-='+Math.floor(init.width*o/100)*Math.abs(offset)
		        	   }, settings.animSpeed);
	            	   
	            	   o = c = d = 0;
		        	});
        		}
        	} else {
        		$('div.o-slider-images', $this).animate({
 	      		   left: '+='+init.width*Math.abs(offset)
 	      	   	}, settings.animSpeed);
        		if(layers){
	        		$.each(layers, function(key, value) { 
	         		   var o,c,d;
	             	   $.each(value, function(key, value) { 
	             		   if(key == 'offset') { o = value; if(o > 100) {o = 100;} if(o < 0) {o = 0;} }
	             		   if(key == 'className') c = value;
	             		   if(key == 'direction') d = value;
	             	   });
	             	   
	             	   $('div.'+c, $this).animate({
	 	        		   left: (d && d == 'rtl') ? '-='+Math.floor(init.width*o/100)*Math.abs(offset) : '+='+Math.floor(init.width*o/100)*Math.abs(offset)
	 	        	   }, settings.animSpeed);
	             	   
	             	   o = c = d = 0;
	                });
        		}
        	}
        	init.images_amount = init.images_total - selected_position + 1;
        	current_image = selected_position;//!!!
        });
        
        return this.each(make);
       
    };
    
})(jQuery);  