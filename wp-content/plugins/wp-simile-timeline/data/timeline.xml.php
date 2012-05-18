<?php
/*
 * timeline.xml.php
 * Description: XML data for the SIMILE Timline Plugin. 
 * This file fetches the posts from the database and outputs them in the loop
 * Plugin URI: http://www.freshlabs.de/journal/archives/2006/10/wordpress-plugin-simile-timeline/
 * Author: Tim Isenheim
 * 
	===========================================================================
	SIMILE Timeline for WordPress
	Copyright (C) 2006 Tim Isenheim
	
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	===========================================================================
*/
// load WordPress environment
include_once('../../../../wp-load.php');
define('WP_USE_THEMES', false);
// explicit HTTP header 200
header("HTTP/1.1 200 OK");
header("Status: 200 All rosy");
/* =========================================================================
 * get post data
 * =========================================================================
 */
// get category IDs from Ajax post parameters (probably comma separated)
$cat = -1;
if(isset($_GET['cat'])){
	$cat = $_GET['cat'];
} 
// Sanitize query string. Allow numeric IDs and ',' only 
$cat=preg_replace('/[^0-9.,]/','',$cat);
$cat=esc_js($cat);

// RSS config
$rss_links = get_bookmarks("category=$cat");
// Include WP RSS library, catching WP 3.0 version
if(strstr($wp_version, '3.0') === FALSE){
	require_once(ABSPATH . WPINC . '/rss.php');
}

// Get posts from the timeline categories (if $cat is not set, all posts will be fetched)
$poststatus = "publish";
if(get_option('stl_timeline_showfutureposts') == '1') $poststatus .= ",future";
query_posts("cat=$cat&post_status=$poststatus&showposts=-1");

// init classes needed
$wpst_term = new WPSimileTimelineTerm();

/* =========================================================================
 * begin XML document
 * =========================================================================
 */
header('Content-type: text/xml; charset=UTF-8');
header("Pragma: no-cache");
@ob_end_flush(); // flush and end output buffer to prevent SimplePie from sending new headers
echo '<?xml version="1.0" encoding="UTF-8"?'.'>' . "\n\r";
echo '<data>' . "\n\r";

/* =========================================================================
 * BEGIN the LOOP for post data ********************************************
 * =========================================================================
 */
$use_image_attachments = get_option('stl_timeline_useattachments');

while (have_posts()) : the_post();

	$stl_icon = get_post_meta($post->ID, 'stl-icon', true);
	$stl_image = get_post_meta($post->ID, 'stl-image', true);
	$stl_link = get_post_meta($post->ID, 'stl-link', true);
	$stl_tapeImage = get_post_meta($post->ID, 'stl-tapeImage', true);
	$stl_caption = get_post_meta($post->ID, 'stl-caption', true);
	$stl_classname = get_post_meta($post->ID, 'stl-classname', true);

	// TODO: try to get image attachement when custom field is empty
	// if backend option is not set to ignore and v
	if($use_image_attachments != 0 && (empty($stl_icon) || empty($stl_image)) ){
		$args = array(
			'post_type' => 'attachment',
			'post_parent' => $post->ID
		);
		//retrieve image attachments (experimental)
		$attachments = get_posts($args);
		if(!empty($attachments)){
			$i = wp_get_attachment_image_src($attachments[0]->ID);
			if($use_image_attachments == 1){ // if option is set to show images in timeline
				$stl_icon = $i[0];
			}
			else{ // option is set to show image in bubble
				$stl_image = $i[0];
			}	
		}
	}

	echo '<event ';
	/* =========================================================================
	 * time information
	 * =========================================================================
	 */
	// use event start date if explicitly set
	if($post->stl_timeline_event_start != '0000-00-00 00:00:00' && $post->stl_timeline_event_start != null):
		echo 'start="' . adodb_date2('r', $post->stl_timeline_event_start)  .'"';
	// ...otherwise use the post publish date
	else:
		echo 'start="' . get_the_time('r') . '"';  // or get_the_time('D M Y H:i:s') . " GMT".date('O')
	endif;
	
	if($post->stl_timeline_event_latest_start != '0000-00-00 00:00:00' && $post->stl_timeline_event_latest_start != null)
		echo ' latestStart="' . adodb_date2('r', $post->stl_timeline_event_latest_start)  .'"';
	
	// event has a duration if the end date is set for the current post
	if($post->stl_timeline_event_end != '0000-00-00 00:00:00' && $post->stl_timeline_event_end != null):
		echo ' end="' . adodb_date2('r', $post->stl_timeline_event_end) .'"';
		// is there an earliestEnd?
		if($post->stl_timeline_event_earliest_end != '0000-00-00 00:00:00' && $post->stl_timeline_event_earliest_end != null){
			echo ' earliestEnd="' . adodb_date2('r', $post->stl_timeline_event_earliest_end) .'"';
			echo ' durationEvent="true"'; 
		}
		echo ' durationEvent="true"'; // in every case true, when earliestStart AND end are set
	else:
		echo ' durationEvent="false"';
	endif;
	/* =========================================================================
	 * title information
	 * =========================================================================
	 */
	echo ' title="';
	the_title_rss();
	echo '"';
	/* =========================================================================
	 * link information
	 * =========================================================================
	 */
	if($stl_link != '') $titlelink = $stl_link;
	else $titlelink = get_permalink($post->ID);
	echo ' link="' . $titlelink . '"';
	/* =========================================================================
	 * category color
	 * =========================================================================
	 */
	$stl_term = $wpst_term->getTermForPost($post->ID);

	echo ' color="'.$stl_term->color . '"';
	/* =========================================================================
	 * custom field values
	 * =========================================================================
	 */
	if($stl_icon != '') echo " icon=\"$stl_icon\"";
	if($stl_image != '') echo " image=\"$stl_image\"";
	if($stl_tapeImage != '') echo " tapeImage=\"$stl_tapeImage\"";
	if($stl_caption != '') echo " caption=\"$stl_caption\"";
	if($stl_classname != '') echo " classname=\"$stl_classname\"";
	echo ">\n\r";
	/* =========================================================================
	 * custom filtering for content. keep but encode html elements
	 * =========================================================================
	 */
	$content = apply_filters('the_content', get_the_content()); // apply default WP content filters
	echo WPSimileTimelineToolbox::filterHtml($content);
	// =========================================================================
	echo '</event>';
	echo "\n\r";
endwhile;
/* =============================================================================
 * begin loop for RSS links ****************************************************
 * TODO: remove fetch_rss branch (deprecated since WP 2.8)
 * =============================================================================
 */
foreach($rss_links as $link){
	// Trying to use deprecated method
	if(function_exists('fetch_rss')){
		$feedContent = fetch_rss($link->link_rss);
		$feedItems = $feedContent->items;
		$term = $wpst_term->readTerm($link->term_id);
	}
	// SimplePie method used since WP 3.0
	else{
		$feedContent = fetch_feed($link->link_rss);
		// Figure out how many total items there are, but limit it to 100 
		$maxitems = $feedContent->get_item_quantity(100); 
		$feedItems = $feedContent->get_items(0, $maxitems);
		$term = $wpst_term->readTerm($link->term_id);
	}
	if(!empty($feedItems)){
		foreach($feedItems as $feedItem){
			echo "<event";
			$pubdate = date('r');
			if(is_array($feedItem)){
				// catch multiple possible index names
				if(isset($feedItem['published'])){
					$pubdate = $feedItem['published'];
				}
				else if(isset($feedItem['pubdate'])){
					$pubdate = $feedItem['pubdate'];
				}
				$title = $feedItem['title'];
				$permalink = $feedItem['link'];
				$summary = $feedItem['summary'];
			}
			else{
				$pubdate = $feedItem->get_date('r');
				$title = $feedItem->get_title();
				$permalink = $feedItem->get_permalink();
				$summary = $feedItem->get_description();
			}
			$link_image = $link->link_image;
			
			echo " start=\"" . date('r', strtotime($pubdate)) . "\"";
			echo " title=\"" . WPSimileTimelineToolbox::filterHtml($title) . "\"";
			echo " link=\"" . WPSimileTimelineToolbox::filterHtml($permalink) . "\"";
			echo " icon=\"" . $link_image . "\"";
			echo " color=\"" . $term->color . "\"";
			echo ">";
			echo WPSimileTimelineToolbox::filterHtml($summary) . "\n";
			echo "</event>" . "\n\r";
		}
	}
}
// =============================================================================
echo '</data>';
?>