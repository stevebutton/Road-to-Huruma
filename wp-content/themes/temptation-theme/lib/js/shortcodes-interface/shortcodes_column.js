(function(){
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_column.png';
	tinymce.create('tinymce.plugins.shortcodes_column', {
		createControl : function(id, controlManager) {
			if (id == 'shortcodes_column') {
				var button = controlManager.createButton('shortcodes_column', {
					title : 'Insert Layout Column',
					image :  icon_url,
					onclick : function() {
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Layout Column Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=shortcodes-column-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	tinymce.PluginManager.add('shortcodes_column', tinymce.plugins.shortcodes_column);
	
	jQuery(function(){
		var form = jQuery('\
			<div id="shortcodes-column-form">\
				<div id="shortcodes-column-container" class="shortcodes-container">\
					<div class="left">\
						<label for="celta_column_size">Select Column Size</label>\
						<select name="celta_column_size" id="celta_column_size">\
							<option value="one-third">One Third</option>\
							<option value="two-third">Two Thirds</option>\
							<option value="one-half">One Half</option>\
						</select>\
						<small>Select the size of the column that you want to include.</small>\
					</div>\
					<div class="right">\
						<label for="celta_column_last">Last Column</label>\
						<select id="celta_column_last" name="celta_column_last">\
							<option value="false">False</option>\
							<option value="true">True</option>\
						</select>\
						<small>If you are including the last column, indicate it here.</small>\
					</div>\
					<div class="clear"></div>\
					<div class="full">\
						<p class="submit">\
							<input type="button" id="shortcodes-column-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
						</p>\
		</div></div></div>');
		
		var table = form.find('#shortcodes-column-container');
		form.appendTo('body').hide();
		
		form.find('#shortcodes-column-submit').click(function(){
			var options = { 
				'size' : '',
				'last' : 'false'
			};
			var shortcode = '[column ';
			
			for( var index in options ) {
				var value = table.find( '#celta_column_' + index ).val();

				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += '][/column]';

			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			tb_remove();
		});
	});
})()