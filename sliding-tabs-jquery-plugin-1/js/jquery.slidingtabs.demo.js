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
		},																
		
		
		/* 
		 * Methods for customizing the tabs (FOR DEMO PURPOSES, NOT NEEDED FOR THE SLIDING TABS TO WORK)
		 */										
		$optsBox = $container.find('div#options_box'),
		$addBtn = $container.find('ul.customize li a#add').click(function() { customize.addTab(); return false; }),
		$removeBtn = $container.find('ul.customize li a#remove').click(function() { customize.removeTab(); return false; }),
		$optsBtn = $container.find('ul.customize li a#options').click(function() { customize.toggleBox(); return false; }),		
		$saveBtn = $optsBox.find('a#save').click(function() { customize.saveOptions();	return false; }),
		length, totSize,				
		
		customize = {																					
			addTab: function() {
				length = ($tabs.children('li').length + 1);									
				
				if ($(tabs.animated).length || length == 31) { return false; }
				
				// Enable/disable links			
				if (length == 2) { $container.find('ul.customize li a#remove').removeClass().addClass('btn_enabled'); }
				if (length == 30) { $addBtn.removeClass().addClass('btn_disabled'); }																									
			
				if (conf.orientation == 'horizontal') {	customize.appendContent('content_', 'Horizontal Tab #', ''); } 
				else { customize.appendContent('v_content_', 'Vertical Tab #', '<span>Lorem ipsum dolor sit amet</span>');	}
				
				// Show the appended tab
				customize.showAppended();
				
				// Bind click event to the appended tab
				$tabs.find('li a:last').click(function() {
					tabs.click(this); return false;
				});				
								
				$prev.removeClass(conf.btnDisabledClass);				
				$next.addClass(conf.btnDisabledClass);																	
				
				$content.children('div.tab_view:last').css({'position': 'absolute', 'display': 'none'});										
			},
			
			appendContent: function(id, text, span) {
				$tabs.append('<li><a href="#'+id+length+'" id="tab_'+length+'" class="tab">'+text+length+span+'</a></li>');																									
				$content.append('<div id="'+id+length+'" class="tab_view"><h2>'+text+length+'</h2><div class="text">'+$content.children('#'+id+'1').find('div.text').html()+'</div></div>');	
				
			},
			
			showAppended: function() {
				totSize = customize.totLength();												
							
				if (totSize > conf.slideLength - conf.offsetBR) {
					// Show the prev/next buttons
					$prev.show(); $next.show();
											
					margin = totSize - conf.slideLength + conf.offsetBR;										
					
					// Animate with the new value
					customize.animate();						
				}
			},
			
			totLength: function() {
				totSize = 0;
			
				$tabs.children('li').each(function() {						
					totSize += $(this)[val.func](true);
				});
				
				return totSize;	
			},
			
			animate: function() {
				if (conf.orientation == 'horizontal') {	$tabs.animate({'marginLeft': -+margin}, 300); } 
				else { $tabs.animate({'marginTop': -+margin}, 300); }
			},
			
			removeTab: function() {
				length = $tabs.children('li').length;		
				
				if ($(content.animated).length || length == 1) { return false; }
				
				// Enable/disable links					
				if (length == 30) { $container.find('ul.customize li a#add').removeClass().addClass('btn_enabled'); }
				if (length == 2) { $removeBtn.removeClass().addClass('btn_disabled'); }										
																			
				$li = $tabs.children('li:last');			
															
				if ($li.children('a').hasClass(conf.tabActiveClass)) {											
					var prevLink = $li.prev().children('a'),						
						tabLink = prevLink.attr('hash');
														
					// Add active class
					prevLink.addClass(conf.tabActiveClass);
								
					// Show the previous tab's content												
					$content.children(tabLink).css({'top': '0px', 'left': '0px', 'display': 'block'}).addClass(conf.viewActiveClass);
				}
				
				$li.remove();	// Remove the last tab		
				$content.children('div:last').remove(); // Remove the last content
												
				totSize = customize.totLength(); // Get the total size of the tabs
				
				// Get the new position
				if (totSize > conf.slideLength - conf.offsetBR) {						
					margin = totSize - conf.slideLength + conf.offsetBR;												
																	
					// Add/remove active classes
					$prev.removeClass(conf.btnDisabledClass);						
					$next.addClass(conf.btnDisabledClass);
				} else {
					margin = 0;																			
					
					// Hide the prev/next buttons 
					$prev.hide(); $next.hide();																			
				}								
								
				// Animate with the new value
				customize.animate();
			},
			
			toggleBox: function() {				
				$optsBox.toggleClass('show'); 												
				$optsBtn.toggleClass('active');			
			},
			
			saveOptions: function() {
				// Set new options		
				if ($optsBox.find('input#orientation').val() == 'horizontal') {
					conf.tabsAnimTime = parseInt($optsBox.find('input[name="tab_dur"]:checked').val());
					conf.contentAnimTime = parseInt($optsBox.find('input[name="cont_dur"]:checked').val());				
					conf.tabsScroll = $optsBox.find('input[name="scroll"]:checked').val();
				} else {
					conf.tabsAnimTime = parseInt($optsBox.find('input[name="v_tab_dur"]:checked').val());
					conf.contentAnimTime = parseInt($optsBox.find('input[name="v_cont_dur"]:checked').val());				
					conf.tabsScroll = $optsBox.find('input[name="v_scroll"]:checked').val();
				} 								 													
				conf.tabsEasing = $optsBox.find('select#tab_fx option:selected').val();			
				conf.contentAnim = $optsBox.find('select#cont_anim option:selected').val();
				conf.contentEasing = $optsBox.find('select#cont_fx option:selected').val();						
				
				if (conf.contentAnim == 'fade') { conf.contentAnimTime = (conf.contentAnimTime - 200); }
				
				// Set/unset scrolling 
				if (conf.tabsScroll == 'true') {
					$tabs.mousewheel(function(event, delta) {
						(delta > 0) ? tabs.prev(val) : tabs.next(val);						
						return false;
					});
				} else { 
					$tabs.unmousewheel();
				}						
												
				$content.children('div').css('position', 'absolute');								
				
				// Set the content div styles according to the new content animation option
				switch(conf.contentAnim) {
					case 'slideH': $content.children('div:not(.'+conf.viewActiveClass+')').css('top', '0px'); break;
					case 'slideV': $content.children('div:not(.'+conf.viewActiveClass+')').css('left', '0px'); break;					
					default: $content.children('div:not(.'+conf.viewActiveClass+')').css({'top': '0px', 'left': '0px', 'display': 'none'});
				}										
																		
				$optsBox.removeClass('show');
				$optsBtn.removeClass('active');
			}
		};								
	};

})(jQuery);