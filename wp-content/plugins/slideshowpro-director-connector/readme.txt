=== SlideShowPro Director Connector ===
Contributors: rdp
Donate link: http://rdp-photo.net/development/sspdc/#donate
Tags: gallery, slideshowpro, image, images, director, photos, media
Requires at least: 2.7
Tested up to: 2.8
Stable tag: 1.0.4b

SlideShowPro Director Connector integrates images and videos from Slideshow Pro Director into your WordPress blog.

== Description ==

This WordPress plugin helps you to add pictures and albums from [SlideShowPro Director](http://slideshowpro.net/products/slideshowpro_director/slideshowpro_director) to your WordPress blog by either choosing them from the media tab or by inserting some shortcode directly into your post. The images are served from Director, so no image is saved or loaded into your Blog.

Features:

*   Media tab for comfortable album and image browsing.
*	Add one or more images to your post.
*	Supports video with included JW Player.
*	Show album with one preview image and the others as in lightbox.
*	Show album in matrix mode. All images on a page or post.
*	Add a photostrip as template tag.
*	Widget for displaying thumbnail in your sidebar.
*  	Uses the [Lightview-Plus](http://wordpress.org/extend/plugins/lightview-plus/) plugin by Puzich or [Lightbox 2](http://wordpress.org/extend/plugins/lightbox-2/) plugin by Rupert Morris for displaying 'fullsize' images.
*   Admin interface for easy setup.
*   Uses WordPresses' easy and fast shortcode API.
*	Official Director API from SlideShowPro included.

Known Issues:

* 	I should write a decent documentation some day, especially for shortcodes...
*	The plugin's CSS file is not overriden by the theme as it is loaded aferwards. For now you'll have make appearance changes to the plugin's css file. Be careful. The file will be overwritten by the next update.


== Installation ==

1. Upload the 'sspdc_connector' directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the SSP Director API key and API Path to the plugin configuration page.
4. Install [Lightview-Plus](http://wordpress.org/extend/plugins/lightview-plus/) and [Lightview](http://www.nickstakenburg.com/projects/lightview/) 
or
4. Install [Lightbox 2](http://wordpress.org/extend/plugins/lightbox-2/) 
5. Change the plugins CSS file (sspdc.css) as you wish and make a backup.
6. Add a new post.
7. Click the symbol that looks like a sun in WP 2.5/2.6 or the 'Add Media' Button  in 2.7 and choose the SSPD Connector menu.
8. Select an album 
9. Choose an image 
10. Save your post


== Frequently Asked Questions ==

= Can I change the look and feel by adapting CSS =

Yes, you can. Take a look at the 'sspdc.css' file. You can override the classes in you themes' CSS file.

= The plugin seems to work but my Director album dropdown list is empty =

The DirectorPHP API relies on php_curl for communicating with Director. Connector won't work without it and checks if php_curl is available and gives instructions. Have a look at your plugin configuration page.

== Screenshots ==

1. SlideShowPro Director API configuration page.
2. SlideShowPro Director API format options page.
3. Album matrix view.
4. Image on post/page with photostrip below the header.
5. Lightbox fullsize view.

== Shortcodes ==
= Add one image by its director content id =
[sspdc content=(content_id) link=(default:lightbox|post|director|url:) format=(format_name|default:post)] 

= BETA(be careful): Pass flashvars to mediaplayer =
If your content_id is a movie you can pass flashvars by adding the mediaplayer shortcode:

[sspdc content=(content_id) mediaplayer="autostart=false&backcolor=#000"]

You can get a list of valid flashvars at [longtailvideo](http://developer.longtailvideo.com/trac/wiki/FlashVars)

= Add one album =
[sspdc album=(album_id) style=(default:matrix|preview) description=default:false|true]


== Photostrip ==

A photostrip can be added to your theme by using a template tag:

<?php sspdc_photostrip(album_id, image_count) ?> 

Where'album_id' is the SlideShowPro Director album number and 'image_count' how many images should be shown.

== Additional notes ==

Thanx to Alex Rabe & the NextGEN DEV-Team: their NextGEN Gallery Code helped me understand many aspects of the WordPress API. [Checkout the best WordPress gallery plugin](http://alexrabe.boelinger.com/wordpress-plugins/nextgen-gallery).

