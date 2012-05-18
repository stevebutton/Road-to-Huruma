(function(){
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_toggle.png';
	tinymce.create('tinymce.plugins.shortcodes_toggle', {
		createControl : function(id, controlManager) {
			if (id == 'shortcodes_toggle_button') {
				var button = controlManager.createButton('shortcodes_toggle_button', {
					title : 'Insert Toggle Shortcode',
					image :  icon_url,
					onclick : function() {
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Insert Toggle Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes-toggle-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	tinymce.PluginManager.add('shortcodes_toggle', tinymce.plugins.shortcodes_toggle);
	
	jQuery(function(){
		var form = jQuery('\
			<div id="shortcodes-toggle-form">\
				<div id="shortcodes-toggle-container" class="shortcodes-container">\
					<div class="left">\
						<label for="celta_toggle_title">Toggle Title</label>\
						<input type="text" id="celta_toggle_title" name="celta_toggle_title" value="" />\
						<small>Insert the title of the toggle box.</small>\
					</div>\
					<div class="clear"></div>\
					<div class="full">\
						<label for="celta_toggle_content">Toggle Content</label>\
						<textarea id="celta_toggle_content" name="celta_toggle_content" rows="5">Content of the Toggle Box</textarea>\
						<small>Insert the content of the toggle box.</small>\
					</div>\
					<div class="full">\
						<p class="submit">\
							<input type="button" id="shortcodes-toggle-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
						</p>\
		</div></div></div>');
		
		var table = form.find('#shortcodes-toggle-form');
		form.appendTo('body').hide();
		
		form.find('#shortcodes-toggle-submit').click(function(){

			var shortcode = '[toggle] ';
			
			shortcode += '[toggleTitle]'+jQuery('#celta_toggle_title').val()+'[/toggleTitle] ';
	
			shortcode += '[toggleBox]'+jQuery('#celta_toggle_content').val()+'[/toggleBox] ';
			
			shortcode += '[/toggle] ';
			
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			tb_remove();
		});
	});
})()