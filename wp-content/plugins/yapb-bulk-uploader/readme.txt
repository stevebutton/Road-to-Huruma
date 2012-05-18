=== YAPB Bulk Uploader ===

Contributors: reuzel
Tags: yapb, upload, image, bulk, flash
Requires at least: 2.5?
Tested up to: 2.9.1
Stable tag: 1.4

This plugin adds the possibility to mass upload images to a YAPB-enabled blog using the WordPress flash-uploader.

== Description ==

This plugin adds the possibility to mass upload images to a [YAPB](http://wordpress.org/extend/plugins/yet-another-photoblog/ "Yet Another Photoblog")-enabled blog using the WordPress flash-uploader.

When this plugin is enabled, a new page name 'YAPB Bulk' is added to the Posts menu. From here you can select multiple images which will be then uploaded to your blog. A few options can be set before each upload:

* Use the image EXIF date, or your own date as post date,
* Use IPTC information to fill the post's title, content and tags. If not set, the image filename will be used as post title,
* Set the post status (draft or published),
* Define the category to post in,
* Set the author to post as.

_Note:_ Your blog must have [YAPB](http://wordpress.org/extend/plugins/yet-another-photoblog/ "Yet Another Photoblog"). installed and enabled for this plugin to work correctly.

== Installation ==

Installation of YAPB Bulk Uploader is straightforward:

1. Extract the zip-file in your plugins directory (typically '/wp-content/plugins/'). Or through the automatic install functions of WordPress.
1. Activate the plugin through the 'Plugins' menu in WordPress

_Note:_ Your blog must have [YAPB](http://wordpress.org/extend/plugins/yet-another-photoblog/ "Yet Another Photoblog"). installed and enabled for this plugin to work correctly.

== Frequently Asked Questions == 

= Is it secure? =
Only registered users can use this wizard. The plugin reuses Wordpress' security/login mechanisms, so basically if a user is allowed to post, he or she is allowed to use this publish wizard.

= Hey, no image is uploaded! = 
For some reason there are many issues regarding image upload. Here some hints on why no image seems to be uploaded:

* Make sure that [YAPB](http://wordpress.org/extend/plugins/yet-another-photoblog/ "Yet Another Photoblog") is installed, because this plugin only works in combination with that plugin.
* Make sure you have enough memory. Memory problems occur often when processing the images. This may lead to situations that the image is uploaded, but not displayed. 
* Make sure that the image is not too large, resulting in a timeouts or file-upload-size refusals

== Screenshots ==

1. This screenshot shows the upload page, and the file selection window.

== Changelog ==

= 1.4 =
* Improved security:
** Posts are linked to currently logged-in user only
** Authentication is refined to use sign-on cookies only (solves compatebility issue with Absolute Privacy plugin)
** Check if user is actually allowed to create posts
** If users are not allowed to publish, post state is automatically set to pending when publish is requested 

= 1.3 = 
* Added support for multiple categories
* fixed error in handling cancel and stop actions
* post slug is now also replaced with IPTC title

= 1.2 = 
* Added post status selection
* Added date field to set publish date

= 1.1 =
* UI improvements
* Some major improvements to the error handling
* Solved issues related to using the uploader on a Mac (Many thanks to Cody Bennett for testing.)

= 1.0 =
* Initial version