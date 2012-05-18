=== Snazzy Archives ===
Contributors: freediver
Donate link: https://www.networkforgood.org/donation/MakeDonation.aspx?ORGID2=510144434
Tags:  archives, jquery, post, archive, image, jquery, post list, thumbnail, snazzy
Requires at least: 2.3
Tested up to: 3.0.1
Stable tag: trunk

Snazzy Archives is a visualization plugin for your WordPress site featuring an unique way to display all your posts. Your archive page will never be boring again!


== Description == 

Snazzy Archives is a visualization plugin for your WordPress site featuring an unique way to display all your posts. Your archive page will never be boring again!

Snazzy archives simply lets you express yourself and your blog. You can select different layouts and special effects, Snazzy archives will make sure your blog and your content stand out.

<p><img src="http://www.prelovac.com/plugin/snazzy-screenshot-1.png" /></p>

Main features of Snazzy Archives are:

* Unique visual presentation of blog posts
* Will work out of the box with all features
* Posts are scanned for images and youtube videos and shown together with number of comments
* Different editable layouts (HTML and CSS)
* Special effects using jQuery
* Small, only loads external libraries on archive page and does not clutter your blog
* Caching available for faster access


Plugin by Vladimir Prelovac. Need a <a href="http://www.prelovac.com/vladimir/services">WordPress Expert</a>?


== Changelog ==

= 1.6.1 =
* Fixed a bug where it would display display posts with date set in future 

= 1.6
* New option to exclude categories from archives

= 1.5.2 = 
* Display localized abbrev of the month name (credits Yassen Yotov)

= 1.5 = 
* Made mkdir() bug that sometimed appeared more transparent
* Updated for WP 3.0

= 1.4 =
* display archives by year using [snazzy-archive filteryear="2008"] shortcode. Thanks to [Brian Enigma](http://netninja.com/archives/)

= 1.3.2 =
* fixes the mkdir issue

= 1.3 =
* added image resizing and caching, an excellent contribution by Amit Badkas

= 1.2.3 =
* added code to remove '[]' shortcode text in excerpts (thainks Craig)

= 1.2.2 =
* removed htmlspecialchars for title and excerpt (problem with posts in other languages)

= 1.2 =
* Includes jQuery and Flash effects

== Installation ==

1. Upload the whole plugin folder to your /wp-content/plugins/ folder.
2. Go to the Plugins page and activate the plugin.
3. Use the Options page to change your options
4. Use the code [snazzy-archive] in a post or page where you want to display the archive

You may want to edit the CSS file immediately to adjust the look for your blog. Please read the FAQ for explanation how.


== Screenshots ==

1. Snazzy Archives 
2. Snazzy layout 1 in use

== License ==

This file is part of Snazzy Archives.

Snazzy archives is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

Snazzy archives is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Snazzy archives. If not, see <http://www.gnu.org/licenses/>.


== Credits ==

* [Projectionist](http://project.ioni.st/archives  "Projectionist ") for their fancy looking archives which were the inspiration for Snazzy Archives	
* [WP Cumulous plugin](http://www.roytanck.com/2008/03/15/wp-cumulus-released/ "WP Cumulous plugin") for Flash tag cloud
* [jQuery rotator](http://www.willjessup.com/sandbox/jquery/rotator/rotator.html  "jQuery Rotator") for rotator.js JavaScript

Thanks.

== Frequently Asked Questions ==

=  How can I change default size of archive? =

Open style-archive.css for editing. This is  the main file for styling information. First element .snazzy describes the main container.

Height attribute is the height of archive, remove the line if you want full height. Same applies to width. If the archive can not fit in the container, scrollbars will be shown like on the picture.

Also you can enable special effect 1 in your plugin options, this will create a so called carousel effect that will further save space.

=  How do I change the height and width of the posts and pictures? =

Just edit the width of .sz_cont element and height of .sz_img element and notice the change immediately.

= How can I show archives full screen like you do? =

You can create a new template file, for example snazzy.php, just include header and Snazzy archive call, not the sidebar.Then upload snazzy.php to your theme folder and create a new page on your blog using this template (write page and select this template instead of the default; the option for template is found below the post).

Here is how can one such file look like:

<?php
/*
Template Name: Snazzy Archives
*/

?>

<?php get_header(); ?>


	<p align="center">
		<?php if (isset($SnazzyArchives)) echo $SnazzyArchives->display(); ?>
	</p>

<?php get_footer(); ?>


=  How do I edit and add layouts? =

Layouts are stored in files snazzy-layout-1.php, snazzy-layout-2.php and so on.. Edit these fles or make your own using the available variables

    * $first_for_day - is the comment first for given day, used usually for additional clearance
    * $title - post title
    * $excerpt - post excerpt
    * $comcount - number of comments
    * $imageurl - url of the post image
    * $youtubeurl - url of the video (without http://)
    * $day, $month, $year - date of post

=  How do I set carousel options? =

Options for carousel (special effect #1) can be found in snazzy-archives.js file. You can set how many elements are visible at once (visible) and if you change width of the items in your CSS file, do not forget to change it here as well - option def_width (add 16px for default padding).

= How can I contribute? =

You can create your own custom layouts and special effects send me for inclusion in future versions. Also you can send your feedback, bug reports and suggestions.

= Can I suggest an feature for the plugin? =

Of course, visit <a href="http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives#comments">Snazzy Archives Home Page</a>

= I love your work, are you available for hire? =

Yes I am, visit my <a href="http://www.prelovac.com/vladimir/services">WordPress Services</a> page to find out more.