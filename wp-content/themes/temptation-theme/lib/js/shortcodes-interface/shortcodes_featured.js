(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_featured.png';
    tinymce.create('tinymce.plugins.shortcodes_featured', {
        init : function(ed, url) {
            ed.addButton('shortcodes_featured_button', {
                title : 'Featured Paragraph',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[featured]' + ed.selection.getContent() + '[/featured]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_featured', tinymce.plugins.shortcodes_featured);
})();