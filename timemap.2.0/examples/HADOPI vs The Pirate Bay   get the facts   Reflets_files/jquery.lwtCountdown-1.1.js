/*!
 * jQuery Countdown plugin v1.1
 * http://www.twinpictures.de/t-countdown-widget
 * http://www.littlewebthings.com/projects/countdown/
 *
 * Copyright 2010, Twinpictures, Vassilis Dourdounis
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, blend, trade,
 * bake, hack, scramble, difiburlate, digest and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

(function($){

	$.fn.countDown = function (options) {
		config = {};

		$.extend(config, options);

		diffSecs = this.setCountDown(config);
		
	    style = config.style;
		$.data($(this)[0], 'style', config.style);
		
		if (config.onComplete){
			$.data($(this)[0], 'callback', config.onComplete);
		}
		if (config.omitWeeks){
			$.data($(this)[0], 'omitWeeks', config.omitWeeks);
		}
		
		$('#' + $(this).attr('id') + ' .' + style + '-digit').html('<div class="top"></div><div class="bottom"></div>');
		$(this).doCountDown($(this).attr('id'), diffSecs, 500);
		
		return this;
	};

	$.fn.stopCountDown = function () {
		clearTimeout($.data(this[0], 'timer'));
	};

	$.fn.startCountDown = function () {
		this.doCountDown($(this).attr('id'),$.data(this[0], 'diffSecs'), 500);
	};

	$.fn.setCountDown = function (options) {
		var targetTime = new Date();

		if (options.targetDate){
			targetTime = new Date(options.targetDate.month + '/' + options.targetDate.day + '/' + options.targetDate.year + ' ' + options.targetDate.hour + ':' + options.targetDate.min + ':' + options.targetDate.sec + (options.targetDate.utc ? ' UTC' : ''));
		}
		else if (options.targetOffset){
			targetTime.setFullYear(options.targetOffset.year + targetTime.getFullYear());
			targetTime.setMonth(options.targetOffset.month + targetTime.getMonth());
			targetTime.setDate(options.targetOffset.day + targetTime.getDate());
			targetTime.setHours(options.targetOffset.hour + targetTime.getHours());
			targetTime.setMinutes(options.targetOffset.min + targetTime.getMinutes());
			targetTime.setSeconds(options.targetOffset.sec + targetTime.getSeconds());
		}
		
		//alert(options.targetDate.localtime);
		var nowTime = new Date(options.targetDate.localtime);
		
		diffSecs = Math.floor((targetTime.valueOf()-nowTime.valueOf())/1000);

		$.data(this[0], 'diffSecs', diffSecs);

		return diffSecs;
	};

	$.fn.doCountDown = function (id, diffSecs, duration) {
		$this = $('#' + id);
		if (diffSecs <= 0){
			diffSecs = 0;
			if ($.data($this[0], 'timer')){
				clearTimeout($.data($this[0], 'timer'));
			}
		}

		secs = diffSecs % 60;
		mins = Math.floor(diffSecs/60)%60;
		hours = Math.floor(diffSecs/60/60)%24;
		
		if ($.data($this[0], 'omitWeeks') == true){
			days = Math.floor(diffSecs/60/60/24);
			weeks = Math.floor(diffSecs/60/60/24/7);
		}
		else{
			days = Math.floor(diffSecs/60/60/24)%7;
			weeks = Math.floor(diffSecs/60/60/24/7);
		}
		
		style = $.data($this[0], 'style');
		$this.dashChangeTo(id, style + '-seconds_dash', secs, duration ? duration : 500);
		$this.dashChangeTo(id, style + '-minutes_dash', mins, duration ? duration : 1000);
		$this.dashChangeTo(id, style + '-hours_dash', hours, duration ? duration : 1000);
		$this.dashChangeTo(id, style + '-days_dash', days, duration ? duration : 1000);
		$this.dashChangeTo(id, style + '-days_trip_dash', days, duration ? duration : 1000);
		$this.dashChangeTo(id, style + '-weeks_dash', weeks, duration ? duration : 1000);
		$this.dashChangeTo(id, style + '-weeks_trip_dash', weeks, duration ? duration : 1000);

		$.data($this[0], 'diffSecs', diffSecs);
		if (diffSecs > 0){
			e = $this;
			t = setTimeout(function() { e.doCountDown(id, diffSecs-1) } , 1000);
			$.data(e[0], 'timer', t);
		} 
		else if (cb = $.data($this[0], 'callback')){
			$.data($this[0], 'callback')();
		}

	};

        
	$.fn.dashChangeTo = function(id, dash, n, duration) {
		$this = $('#' + id);
		style = $.data($this[0], 'style');
		
		//loop through each digit and chage that dude
		for (var i=($this.find('.' + dash + ' .' + style + '-digit').length-1); i>=0; i--){
			var d = n%10;
			n = (n - d) / 10;
			$this.digitChangeTo('#' + $this.attr('id') + ' .' + dash + ' .' + style + '-digit:eq('+i+')', d, duration);
		}
	};
	
	$.fn.digitChangeTo = function (digit, n, duration) {
		if (!duration){
			duration = 500;
		}
		if ($(digit + ' div.top').html() != n + ''){
			$(digit + ' div.top').css({'display': 'none'});
			// $(digit + ' div.bottom').css({'border-top': '1px solid #666'});
			$(digit + ' div.top').html((n ? n : '0')).slideDown(duration);

			$(digit + ' div.bottom').animate({'height': ''}, duration, function() {
				$(digit + ' div.bottom').html($(digit + ' div.top').html());
				$(digit + ' div.bottom').css({'display': 'block', 'height': ''});
				// $(digit + ' div.bottom').css({'border-top': 'none'});
				$(digit + ' div.top').hide().slideUp(10);
			});
		}
	};

})(jQuery);


