(function() {
	src = jQuery("#theme-options-css").attr('href');
	var script_url = src.split( '/styles/' );
	var icon_url = script_url[0] + '/styles/images/shortcodes_social.png';
    tinymce.create('tinymce.plugins.shortcodes_social', {
        init : function(ed, url) {
            ed.addButton('shortcodes_social_button', {
                title : 'Social Profiles',
                image : icon_url,
                onclick : function() {
                     ed.selection.setContent('[socialProfiles]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('shortcodes_social', tinymce.plugins.shortcodes_social);
})();