/*
 * Sliding Tabs 1.1.0 jQuery Plugin - http://codecanyon.net/item/sliding-tabs-jquery-plugin/141774
 * 
 * Copyright 2011, Christian André
 * All rights reserved.
 *
 * You need to purchase a license if you want to use this script.
 * http://codecanyon.net/wiki/buying/howto-buying/licensing/
 *
 */

(function($) { 
 	
	$.fn.slideTabs = function(client_config) {	
        var default_config = {
            tabsList: 'ul.tabs',					
			viewContainer: 'div.view_container',		
			btnNext: 'a.next',
			btnPrev: 'a.prev',
			tabClass: 'tab',
			tabActiveClass: 'active',
			viewActiveClass: 'active_view',
			btnDisabledClass: 'disabled',
			orientation: 'horizontal',
			slideLength: 694,
			offsetTL: 0,
			offsetBR: 0,	
			tabsEasing: '',
			tabsAnimTime: 300,
			tabsScroll: true,
			tabSaveState: false,
			contentAnim: 'slideH',
			contentEasing: 'easeInOutExpo',		
			contentAnimTime: 600,
			autoHeight: false,
			autoHeightTime: 0,
			autoplay: false,
			autoplayInterval: 4000	
        },
        		
		conf = $.extend(true, {}, default_config, client_config);
        
		return this.each(function() {
            var tabs = new SlideTabs($(this), conf);
            tabs.init();			
        });
    };
	
	function SlideTabs($container, conf) {							
		var $tabs = $container.find(conf.tabsList),
			$a = $tabs.children('li').find('a'),
			$content = $container.find(conf.viewContainer).css('overflow', 'hidden'), // Hide the overflowing content
			$prev = $container.find(conf.btnPrev).click(function() { tabs.prev(val); return false; }), // Bind the prev button click event
			$next = $container.find(conf.btnNext).click(function() { tabs.next(val); return false; }), // Bind the next button click event					
			$tab, $activeTab, $li, $lastElem, $view, $activeView, 
			val = {}, margin = 0;																													
					
		this.init = function() {			
			// Set the correct function and object names
			if (conf.orientation == 'horizontal') {										
				val.func = 'outerWidth';
				val.obj = 'left';				
				val.attr = 'marginLeft';											
			} else {
				val.func = 'outerHeight';										
				val.obj = 'top';													
				val.attr = 'marginTop';											
			}					
						
			tabs.init();			
			if (conf.autoplay == true) { autoplay.init(); } // Set intervals if autoplay is enabled						
		};						
											
		/* 
		 * Tab methods
		 */			 
		var tabs = {												
			animated: '#'+$container.attr('id')+' '+conf.tabsList+':animated',
			
			init: function() {				
				tabs.posActive(); // Position the active tab			
				tabs.bind(); // Bind tab events	
			},
			
			bind: function() {
				// Delegate the tabs click event
				$tabs.delegate('li a.'+conf.tabClass, 'click', function() {
					tabs.click(this);
					return false;
				});														
		
				// Mouse scroll wheel event				
				if ($.fn.mousewheel && conf.tabsScroll == true) {	
					$tabs.mousewheel(function(event, delta) {
						(delta > 0) ? tabs.prev(val) : tabs.next(val);					
						return false; // Prevents default scrolling
					});
				}			
			},								
			
			posActive: function() {
				// Get the active tab
				tabs.getActive();				
				
				// Show the active tab's content
				content.showActive();
				
				$lastElem = $tabs.children('li:last');
				$activeTab = $activeTab.parent('li');
			
				if (($lastElem[val.func](true) + $lastElem.position()[val.obj]) > conf.slideLength) {					
					// Get the values needed to get the total width/height of the tabs
					val.elemD = $activeTab[val.func](true);
					val.elemP = $activeTab.position()[val.obj];	
					
					// Find the active element's position
					if (val.elemP > conf.slideLength) {
						margin += (val.elemD + (val.elemP - conf.slideLength));							
						margin = (margin + conf.offsetBR);						
					} else if ((val.elemP + val.elemD) > conf.slideLength) {
						margin += (val.elemD - (conf.slideLength - val.elemP));						
						margin = (margin + conf.offsetBR);
					} else {
						margin = (margin - conf.offsetTL);
					}								
																																	
					// Set the active element's position					
					$tabs.css(val.attr, -+margin);
					
					// Show the directional buttons after the position has been set
					tabs.showButtons();
				}								
			},
			
			showButtons: function() {
				// Deactivate the arrow button if the tab element is at the beginning or end of the list								
				if ($tabs.children("li:first").position()[val.obj] == (0 + conf.offsetTL)) {				
					$prev.addClass(conf.btnDisabledClass);	
				} else if (($lastElem.position()[val.obj] + $lastElem[val.func](true)) == (conf.slideLength - conf.offsetBR)) {
					$next.addClass(conf.btnDisabledClass);
				}
												
				// Show the directional buttons
				$prev.show(); $next.show();
			},						
			
			click: function(tab) {				
				$tab = $(tab);								
				
				// Return false if an animation is running				
				if ($(content.animated).length || $tab.hasClass(conf.tabActiveClass)) { return false; }								
				
				$li = $tab.parent('li');				
				
				// Set the new active state
				tabs.setActive();
												
				if (conf.autoplay == true) { 					
					val.index = $tab.parent().index(); // Set the clicked tab's index			
					autoplay.setInterval(); // Set new interval
				}
								
				// Get the element's position
				val.elemP = $li.position();
				val.activeElemP = $activeTab.position();								
				
				// Slide partially hidden tab into view
				tabs.slideClicked(val);												
											
				// Set the content vars and remove/add the active class
				$activeView = $content.children('div.'+conf.viewActiveClass).removeClass(conf.viewActiveClass);				
				$view = $content.children('div#'+$tab.attr('hash')).addClass(conf.viewActiveClass);																							
								
				if (conf.autoHeight == true) { content.adjustHeight(); }								
				
				// Show/animate the clicked tab's content into view	
				if (conf.contentAnim.length > 0) {			
					content[conf.contentAnim](val);
				} else {
					$activeView.hide();	$view.show();		
				}								
			},
			
			getActive: function() {																								
				if ($.cookie) { var savedTab = $.cookie($container.attr('id')); }									
												
				if (savedTab) {						
					// Remove the static active class
					$tabs.children('li').find('.'+conf.tabActiveClass).removeClass(conf.tabActiveClass);
					// Set the active class on the saved tab
					$activeTab = $tabs.find('a#'+savedTab).addClass(conf.tabActiveClass);
				} else {					
					$activeTab = $tabs.children('li').find('.'+conf.tabActiveClass);					
			
					// Set the first tab element to 'active' if no tab element has the active class
					if ( ! $activeTab.length) { $activeTab = $tabs.find('a:first').addClass(conf.tabActiveClass); }
			
					tabs.saveActive($activeTab);	
				}
			},
			
			setActive: function() {
				// Set new active states		
				$activeTab = $tabs.children('li').find('a.'+conf.tabActiveClass).removeClass(conf.tabActiveClass);
				$tab.addClass(conf.tabActiveClass);								
				tabs.saveActive($tab);
			},
			
			saveActive: function($tab) {
				// Save the active tab's ID in a cookie
				if (conf.tabSaveState == true) { $.cookie($container.attr('id'), $tab.attr('id')); }				
			},
			
			slideClicked: function(val) {
				val.elemP = val.elemP[val.obj];
				val.elemD = $li[val.func](true);					
				val.nextElemPos = ($li.next().length == 1) ? $li.next().position()[val.obj] : 0;
				
				if (val.elemP < (0 + conf.offsetTL)) {															
					val.elemHidden = (val.elemD - val.nextElemPos);						
					margin = (margin - (val.elemHidden + conf.offsetTL));
					
					$next.removeClass(conf.btnDisabledClass); 		
				} else if ((val.elemD + val.elemP) > (conf.slideLength - conf.offsetBR)) {						
					margin += (val.elemD - (conf.slideLength - (val.elemP + conf.offsetBR)));
																	
					$prev.removeClass(conf.btnDisabledClass); 	
				}																															
				
				tabs.animate();
			},
			
			prev: function(val) {
				// Return false if an animation is running
				if ($(tabs.animated).length) { return false; }	
				
				// Find the element and set the margin 			
				$tabs.children('li').each(function() {	
					$li = $(this);										
					val.elemP = $li.position()[val.obj];												
					
					if (val.elemP >= (0 + conf.offsetTL)) {																			
						val.elemHidden = ($li.prev()[val.func](true) - val.elemP);																		
						margin = ((margin - val.elemHidden) - conf.offsetTL);							
						
						$li = $li.prev(); // Set the $li variable to the first visible element
						
						tabs.animate();
						
						return false;
					}																									
				});
				
				// Enable the next link				
				$next.removeClass(conf.btnDisabledClass);  	
			},
			
			next: function(val) {									
				// Return false if an animation is running
				if ($(tabs.animated).length) { return false; }								
				
				// Find the element and set the margin					
				$tabs.children('li').each(function() {						
					$li = $(this);
					val.elemD = $li[val.func](true);
					val.elemP = $li.position()[val.obj];																																																																		
													
					if ((val.elemD + val.elemP) > (conf.slideLength - conf.offsetBR)) {																																																		
						val.elemHidden = (conf.slideLength - val.elemP);																																																				
						margin += ((val.elemD - val.elemHidden) + conf.offsetBR);														
													
						tabs.animate();																					
						
						return false;
					}																							
				});
				
				// Enable the prev link								
				$prev.removeClass(conf.btnDisabledClass);   											
			},
			
			animate: function() {					
				// Animate tabs with the new value					
				if (conf.orientation == 'horizontal') { $tabs.animate({'marginLeft': -+margin}, conf.tabsAnimTime, conf.tabsEasing); } 
				else { $tabs.animate({'marginTop': -+margin}, conf.tabsAnimTime, conf.tabsEasing); }
									
				tabs.setButtonState();
			},
			
			setButtonState: function() {					
				if ($li.is(':first-child')) {	$prev.addClass(conf.btnDisabledClass); } 
				else if ($li.is(':last-child')) { $next.addClass(conf.btnDisabledClass); }
			}
		},
		
		/* 
		 * Content methods
		 */	
		content = {
			animated: '#'+$container.attr('id')+' :animated',
			
			showActive: function() {				
				// Show the active tab's content
				$view = $content.children($activeTab.attr('href')).addClass(conf.viewActiveClass);
				
				 // Set the content div's to absolute and hide the 'inactive' content		
				$content.children('div').css('position', 'absolute').not('div.'+conf.viewActiveClass).hide();
				
				// Set the content container's height if autoHeight is set to: true
				if (conf.autoHeight == true) { $content.css('height', $view.height()).parent().css('height', 'auto'); }
			},
			
			adjustHeight: function() {				
				// Set the content's height
				if (conf.autoHeightTime > 0) { $content.animate({'height': $view.height()}, conf.autoHeightTime); } 
				else { $content.css('height', $view.height()); }		
			},
			
			fade: function() {
				$activeView.fadeOut(conf.contentAnimTime, function() {														
					$view.fadeIn(conf.contentAnimTime);														
				});												
			},								
			
			slideH: function(val) {								
				val.wh = $container.outerWidth(true);															
				content.setSlideValues(val);										
				
				$activeView.animate({'left': val.animVal}, conf.contentAnimTime, conf.contentEasing);												
							
				$view.css({'display': 'block', 'left': val.cssVal}).animate({'left': '0px'}, conf.contentAnimTime, conf.contentEasing, function() {				
					$activeView.css('display', 'none');				
				});																												
			},
			
			slideV: function(val) {
				val.wh = $container.outerHeight(true);					
				content.setSlideValues(val);										
				
				$activeView.animate({'top': val.animVal}, conf.contentAnimTime, conf.contentEasing);
											
				$view.css({'display': 'block', 'top': val.cssVal}).animate({'top': '0px'}, conf.contentAnimTime, conf.contentEasing, function() {				
					$activeView.css('display', 'none');												
				});		
			},
			
			setSlideValues: function(val) {									
				if (val.elemP > val.activeElemP[val.obj]) {	val.animVal = -val.wh; val.cssVal = val.wh;	} 
				else { val.animVal = val.wh; val.cssVal = -val.wh; }	
			}
		},
		
		/* 
		 * Autoplay methods
		 */	
		autoplay = {
			init: function() {
				val.index = 0;
				autoplay.setInterval(); // Set the autoplay interval
			},
			
			setInterval: function() {
				// Clear any previous interval
				clearInterval(val.intervalId);
				// Set the new interval
				val.intervalId = setInterval(function() { autoplay.play(); }, conf.autoplayInterval);
			},
			
			play: function() {
				// Set the next tab's index				
				val.index++; if (val.index == $a.length) { val.index = 0; }				
				// Trigger the click event for the next tab				
				$($a[val.index]).trigger('click');				
			}
		};												
	};

})(jQuery);