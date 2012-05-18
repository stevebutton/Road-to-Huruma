(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_pika.png';
    tinymce.create('tinymce.plugins.shortcodes_cycle', {
        init : function(ed, url) {
            ed.addButton('shortcodes_cycle_button', {
                title : 'Insert Images Slider',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[imagesSlider category=""]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_cycle', tinymce.plugins.shortcodes_cycle);
})();