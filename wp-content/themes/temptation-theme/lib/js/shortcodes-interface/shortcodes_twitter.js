(function(){
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_twitter.png';
	tinymce.create('tinymce.plugins.shortcodes_twitter', {
		createControl : function(id, controlManager) {
			if (id == 'shortcodes_twitter') {
				var button = controlManager.createButton('shortcodes_twitter', {
					title : 'Insert Twitter Feed',
					image :  icon_url,
					onclick : function() {
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Twitter Feed Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes-twitter-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	tinymce.PluginManager.add('shortcodes_twitter', tinymce.plugins.shortcodes_twitter);
	
	jQuery(function(){
		var form = jQuery('\
			<div id="shortcodes-twitter-form">\
				<div id="shortcodes-twitter-container" class="shortcodes-container">\
					<div class="left">\
						<label for="celta_twitter_user">Twitter Username</label>\
						<input type="text" id="celta_twitter_user" name="celta_twitter_user" value="" />\
						<small>Write the username of your Twitter account.</small>\
					</div>\
					<div class="right">\
						<label for="celta_twitter_count">Twitter Count</label>\
						<input type="text" id="celta_twitter_count" name="celta_twitter_count" value="" />\
						<small>Select how many tweets you want to display.</small>\
					</div>\
					<div class="clear"></div>\
					<div class="full">\
						<p class="submit">\
							<input type="button" id="shortcodes-twitter-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
						</p>\
		</div></div></div>');
		
		var table = form.find('#shortcodes-twitter-container');
		form.appendTo('body').hide();
		
		form.find('#shortcodes-twitter-submit').click(function(){
			var options = { 
				'user' : '',
				'count' : 2
			};
			var shortcode = '[twitter ';
			
			for( var index in options ) {
				var value = table.find( '#celta_twitter_' + index ).val();

				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';

			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			tb_remove();
		});
	});
})()