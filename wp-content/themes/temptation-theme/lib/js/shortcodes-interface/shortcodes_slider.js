(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_slider.png';
    tinymce.create('tinymce.plugins.shortcodes_slider', {
        init : function(ed, url) {
            ed.addButton('shortcodes_slider_button', {
                title : 'Insert Content Slider',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[contentSlider category=""]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_slider', tinymce.plugins.shortcodes_slider);
})();