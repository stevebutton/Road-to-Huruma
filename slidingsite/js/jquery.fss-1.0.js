/**
*
* FSS - Full Screen Sliding Website Plugin
* URL: http://www.codecanyon.net/user/lydian
* Version: 1.0
* Author: Lydian
* Author URL: http://www.codecanyon.net/user/lydian
*
*/

(function($) {
    /**
     * Preloads an array of images.
     *
     * Example usage;
     *
     * $(['images/music.png',
     *    'images/download.png',
     *    'images/favorites.png',
     *    'images/ideas.png',
     *    'images/charts.png']).preload();
     */
    $.fn.preload = function() {
        this.each(function() {
            var img = new Image();
            img.src = this;
        });
    }


    $.fn.fss = function(options) {
        
        // Default settings for the plug-in
        var settings = {
            homeButton: '.home-button',
            prevButton: '.prev-button',
            nextButton: '.next-button',
            transition: 'vertical-slide',
            transitionSpeed: 600,
            autoplay: false,
            loop: true,
            slideDuration: 2,
            easing: 'swing',
            preloadSlides: true,
            enableKeyboardNavigation: true
        };

        // Merge options with the default settings
        if (options) {
            $.extend(settings, options);
        }

        // Support for multiple sliders
        if (this.length > 1) {
            this.each(function() {
                $(this).fss(options)
            });
            return this;
        }

        // jQuery caches
        var self = this;
        var slider = $(self);
        var slideContainer = slider.children('div.slides');
        var slides = slideContainer.children('div.slide');
        var resources = slider.children('.resources');
        var listItems = resources.find('li');

        // Number of the total slides (Equals to listItems.size() if there is a list under the .resources)
        var numItems = listItems.size() > 0 ? listItems.size() : slides.size();

        // Indicates whether the intro animation is played yet
        var introAnimationPlayed = false;

        // Interval id for cross-fade
        var intervalID = 0;

        // The main initialization function
        var init = function() {

            // Initialize the full screen
            initFullScreen();

            // Get the dimensions of the slider
            height = $(window).height();
            width = $(window).width();

            slider.css({
                height: height,
                width: width,
                position: 'relative',
                overflow: 'hidden'
            });

            // Create dynamic slides
            createDynamicSlides();

            // Change position type for the container
            slideContainer.css('position', 'absolute');

            // Set the width, height and overflow type of the slides
            slides.css({
                position: 'relative',
                width: width,
                height: height,
                overflow: 'auto'
            });

            if (settings.transition == 'horizontal-slide') {
                // Custom settings for the horizontal transition
                slideContainer.css('width', numItems * width);
                slides.css('float', 'left');
            }

            // Initialize the keyboard navigation
            initKeyboardNavigation();

            // Initialize the address plugin
            initAddressPlugin();

            // Initialize the special anchors
            initSpecialAnchors(slider);

            // Initialize the previous, next, home buttons
            initSpecialButtons(slider);

            // Start autoplay
            startAutoplay();

            // Preload all of the slides if desired
            if (settings.preloadSlides) {
                loadNext();
            }

        }


        // Initializes the address plugin
        var initAddressPlugin = function() {

            $.address.init(function(event) {
                $.address.autoUpdate(false);
            }).change(function(event) {

                var id = event.value;

                // Prepare the address to be handled for IE 7.x
                if (isIE7()) {
                    // Remove the prefix
                    if (id.indexOf('#') != -1) {
                        id = id.split('#')[1];
                    } else if (id.indexOf('/') != -1) {
                        id = id.split('/')[1];
                    }
                } else {
                    // Remove the prefix
                    id = event.value.substring(1);
                }

                // Go to home if the id is null
                if (id != '' && typeof(id) != 'undefined') {
                    // Check the type of the target, it could be a slide or
                    // an anchor inside a slide.
                    if (slides.filter('#' + id).size() > 0) {
                        self.selectById(id);
                    } else {
                        // Go to first slide
                        self.gotoHome();
                    }
                } else {
                    // Go to first slide
                    self.gotoHome();
                }

            });

        }


        // Initializes the fullscreen mode
        var initFullScreen = function() {

            // Update the html and body css
            $('html, body').css({
                margin: 0,
                padding: 0,
                overflow: 'hidden'
            });

            // Change to overflow type to 'auto' for IE 7+
            if (isIE7()) {
                // Update the html and body css
                $('html, body').css({
                    overflow: 'auto'
                });
            }

            // The resize listener for the main window
            $(window).resize(function() {
                // Get the dimensions of the window
                height = $(window).height();
                width = $(window).width();

                // Update the slider frame and slide dimensions.
                slider.css({
                    width: width,
                    height: height
                });
                slides.css({
                    width: width,
                    height: height
                });

                // Get the current slide's index
                var currentSlideIndex = getCurrentSlide().index();

                // Update the container position if necessary
                if (currentSlideIndex != -1) {
                    if (settings.transition == 'horizontal-slide') {
                        slideContainer.css({
                            width: numItems * width
                        });
                        slider.stop().scrollLeft(currentSlideIndex * width);
                    } else if (settings.transition == 'vertical-slide') {
                        slider.stop().scrollTop(currentSlideIndex * height);
                    }
                }
            });

        }


        // Returns true if the current browser version is IE 7.X
        function isIE7() {

            if (parseFloat(navigator.appVersion.split('MSIE')[1]) == 7) {
                return true;
            }

            return false;

        }


        // Initializes the special anchors within the given jQuery context
        var initSpecialAnchors = function(context) {

            context.find('.special-anchor').not('.prev-button, .next-button, .home-button').click(function(evt) {
                // Get the hyperlink
                var href = $(this).attr('href');

                // It should be done this way for IE 7.X
                if (isIE7()) {
                    href = href.split('#')[1];
                }

                href = href.replace(/^#/, '')

                // Update the address
                $.address.value(href);
                $.address.update();

                return false;
            });

        }


        // Initializes the previous, next, home buttons
        var initSpecialButtons = function(context) {

            // Bind the click event to the home button
            context.find(settings.homeButton + ".special-anchor").bind('click', function(event) {
                event.preventDefault();
                self.gotoHome();
            });

            // Bind the click event to the previous button
            context.find(settings.prevButton + ".special-anchor").bind('click', function(event) {
                event.preventDefault();
                self.selectPrevious();
            });

            // Bind the click event to the next button
            context.find(settings.nextButton + ".special-anchor").bind('click', function(event) {
                event.preventDefault();
                self.selectNext();
            });

        }


        // Initializes the keyboard navigation
        var initKeyboardNavigation = function() {

            if (settings.enableKeyboardNavigation) {
                $(document).keydown(function(event) {
                    // Check the source of the event
                    if (event.target.type !== 'textarea' &&
                        event.target.type !== 'text') {

                        // The keycode needs to be checked this way for cross-browser compatibility
                        var keyCode = event.keyCode || event.which;

                        switch (keyCode) {
                            case 37: // Left arrow
                            case 38: // Up arrow
                                self.selectPrevious();
                                break;
                            case 39: // Right arrow
                            case 40: // Down arrow
                                self.selectNext();
                                break;
                            default:
                                break;
                        }
                    }
                });
            }

        }


        // Starts autoplay
        var startAutoplay = function() {

            if (settings.autoplay) {
                // If it's not being loaded, clear the interval and reset
                if (!getCurrentSlide().hasClass('loading')) {
                    // Clear the previous interval if there is any
                    clearInterval(intervalID);

                    // Return if the end of the slideshow has been reached
                    if (!settings.loop) {
                        if (getCurrentSlide().index() == numItems - 1) {
                            return false;
                        }
                    }

                    intervalID = setInterval(self.selectNext, settings.slideDuration * 1000);
                }
            }

            return true;

        }


        // Selects the slide with the given id
        this.selectById  = function(id, callback) {

            var index = slides.filter("#" + id).index();
            selectByIndex(index, callback);

        }


        // Goes to the first slide
        this.gotoHome = function(callback) {

            $.address.value(slides.eq(0).attr('id'));
            $.address.update();

            if (callback) {
                callback();
            }

        }


        // Selects the next slide
        this.selectNext = function(callback) {

            // Get the index for the current slide
            var index = getCurrentSlide().index();

            // Return back to first index if the last index has been reached
            if (++index == numItems) {
                index = 0;
            }

            $.address.value(slides.eq(index).attr('id'));
            $.address.update();

            if (callback) {
                callback();
            }

        }


        // Selects the previous slide
        this.selectPrevious = function(callback) {

            // Get the index for the current slide
            var index = getCurrentSlide().index();

            // Go to last index if the first index has been reached
            if (--index < 0) {
                index = numItems - 1;
            }

            $.address.value(slides.eq(index).attr('id'));
            $.address.update();

            if (callback) {
                callback();
            }

        }


        // Selects the slide at the given index
        var selectByIndex = function(index, callback) {

            // Get the current slide
            var current = getCurrentSlide();

            // Check to see if it is already selected
            if (index != current.index() && index != -1) {

                // Clear interval to make sure the manually selected slide stays
                // enough time before passing to the next slide.
                clearInterval(intervalID);

                // Remove .current class from the previous slide and add it to the new slide
                getPrevSlide().removeClass('prev');
                current.removeClass('current').addClass('prev');
                slides.eq(index).addClass('current');

                // Start loading the slide if it is loadable
                if (isLoadable(index)) {
                    loadSlide(index);
                }

                // Check to see if it's the first page visit (This avoids the animations at startups)
                if (!introAnimationPlayed) {
                    var speedBuffer = settings.transitionSpeed;
                    settings.transitionSpeed = 0;
                    introAnimationPlayed = true;
                }

                // Call appropriate transition function
                switch (settings.transition) {
                    case 'vertical-slide': // Slide vertically to the current slide
                        slideVertical(callback);
                        break;
                    default:
                    case 'none':
                    case 'horizontal-slide': // Slide horizontally to the current slide
                        slideHorizontal(callback);
                        break;
                }

                // Set it back to the original value
		if (typeof(speedBuffer) != 'undefined') {
                    settings.transitionSpeed = speedBuffer;
		}

            } else {
                // Call the callback function if there is any
                if (callback) {
                    callback();
                }
            }

        }


        // Horizontal slide
        var slideHorizontal = function(callback) {

            // Stop the previous animation and immediately start the new one
            slider.stop().animate({
                scrollLeft: getCurrentSlide().index() * width
            }, settings.transitionSpeed, settings.easing, function() {
                startAutoplay();

                // Call the callback function if there is any
                if (callback) {
                    callback();
                }
            });

        }


        // Vertical slide
        var slideVertical = function(callback) {

            // Stop the previous animation and immediately start the new one
            slider.stop().animate({
                scrollTop: getCurrentSlide().index() * height
            }, settings.transitionSpeed, settings.easing, function() {
                startAutoplay();

                // Call the callback function if there is any
                if (callback) {
                    callback();
                }
            });

        }


        // Loads all of the slides one by one
        var loadNext = function() {

            for (var i = 0; i < listItems.length; i++) {
                if (isLoadable(i)) {
                    loadSlide(i, loadNext);
                    return false;
                }
            }

            return false;

        }


        // Loads the slide at the given index
        var loadSlide = function(index, callback) {

            // Get the address and the target slide
            var href = listItems.eq(index).children('a').attr('href');
            var slide = slides.eq(index);
            var onLoaded = function() {
                // Remove the class loading and add loaded
                slide.removeClass('loading').addClass('loaded');

                // Initialize the special anchors within the loaded context
                initSpecialAnchors(slide);

                // Initialize the special buttons within the loaded context
                initSpecialButtons(slide);

                // Reset the timer if the slide is the current one
                if (slide.index() == getCurrentSlide().index()) {
                    startAutoplay();
                }

                // Call the callback function if there is any
                if (callback) {
                    callback();
                }
            };

            // Check to see if the slide is loadable
            if (isLoadable(index)) {
                // Load the page into the given slide
                slide.addClass('loading').load(href, onLoaded);
            }

        }


        // Appends empty divs for the dynamic slides
        var createDynamicSlides = function() {

            var slideStr = "";

            // Append empty slides into the slide container
            for (var i = 0; i < numItems; i++) {
                var id = listItems.eq(i).children('a').attr('id');
                slideStr += "<div id='" + id + "' class='slide'></div>";
            }

            // Append to the slide container
            slideContainer.append(slideStr);

            // Update the selection for the slides
            slides = slideContainer.children('div.slide');

        }


        // Returns the current slide
        var getCurrentSlide = function() {

            return slides.filter('div.current');

        }


        // Returns the previous slide
        var getPrevSlide = function() {

            return slides.filter('div.prev');

        }


        // Returns true if the slide at the given index has not been loaded yet
        var isLoadable = function(index) {

            // Get the address and the target slide
            var href = listItems.eq(index).children('a').attr('href');
            var slide = slides.eq(index);

            // Check to see if the slide has a valid link
            if (typeof(href) != 'undefined' && href != '#' && href != ' ' && href != '') {
                // Check to see if it's been loaded or loading
                if (!slide.hasClass('loaded') && !slide.hasClass('loading')) {
                    return true;
                }
            }

            return false;

        }

        init();
        
        return this;
        
    };
})(jQuery);