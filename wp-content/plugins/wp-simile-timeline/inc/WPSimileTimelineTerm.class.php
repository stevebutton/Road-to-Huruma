<?php
/**
 * SIMILE Timeline functions for terms (categories)
 * @author Tim Isenheim
 * @link http://wordpress.org/extend/plugins/wp-simile-timeline/
 * @package wp-simile-timeline
 * 
	===========================================================================
	SIMILE Timeline for WordPress
	Copyright (C) 2009 Tim Isenheim
	
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
class WPSimileTimelineTerm{
	
	
	function WPSimileTimelineTerm(){
		
    }
    
    function getTableName(){
    	global $wpdb;
    	return $wpdb->prefix . "stl_timeline_terms";
    }

	/**
	 * Installs table for timeline term relations and attributes
	 */
	function createTable(){
			
		global $wpdb;
	
		$table_name = WPSimileTimelineTerm::getTableName();
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	
			$sql = "CREATE TABLE " . $table_name . " (
				  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  term_id INT NOT NULL,
				  color VARCHAR( 7 ) NOT NULL DEFAULT '#58A0DC',
				  active INT NOT NULL DEFAULT 0
				);";
	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			// copy all category-terms to the new table
			$sql2 = "SELECT * FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' OR taxonomy = 'link_category' OR taxonomy = 'post_tag'";
	
			$res = $wpdb->get_results($sql2);
	
			foreach($res as $term){
				WPSimileTimelineTerm::addTerm($term->term_id);
			}
	   }
	}
	
	/**
	 * Adds a single term to timeline relationship table
	 */
	function addTerm($term_id) {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$insert = "INSERT INTO " . WPSimileTimelineTerm::getTableName() . " (term_id, color, active) VALUES ($term_id, '#58A0DC', 0)";
		$wpdb->query($insert);
	}
	
	/**
	 * Saves the category active attribute into database
	 */
	function updateTermStatus($cID, $status){
		global $wpdb;
		$wpdb->query($wpdb->prepare("UPDATE " . WPSimileTimelineTerm::getTableName()." SET active = '$status' WHERE term_id = $cID"));
	}
	
	/**
	 * Save the category color into database
	 */
	function updateTermColor($cID, $color){
		global $wpdb;
		// TODO: Escape query with $wpdb->escape or $wpdb->prepare (messes up color value with #!)
		$wpdb->query("UPDATE " . WPSimileTimelineTerm::getTableName() . " SET color = '$color' WHERE term_id = $cID");
	}
	
	/**
	 * Syncs WordPress' term table with stl_timeline_terms
	 */
	function syncTerms(){
		
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
		// copy diff of term table to timeline-terms
		$sql = "SELECT term_id FROM " . WPSimileTimelineTerm::getTableName();
		$res = $wpdb->get_results($sql, ARRAY_A);
	
		$terms = get_terms(array('category', 'link_category'));
		
		$cmp = array();
		// copy categories to stl_timeline term relationship table
		foreach($res as $stl_term){
			array_push($cmp, $stl_term['term_id']);
		}
		// loop all available valid terms
		foreach($terms as $term){		
			// add to database if not already exist in the timeline terms 
			if(!in_array($term->term_id, $cmp)){
				WPSimileTimelineTerm::addTerm($term->term_id);
			}
			else{
				// already exists.. do nothing
			}
		}
	}
	
	/**
	 * Gets a term from timeline table for specific term ID
	 */
	function readTerm($term_id, $fields=array('*')) {
		global $wpdb;
		$get = 'SELECT '.implode(',', $fields).' FROM ' . WPSimileTimelineTerm::getTableName() . " WHERE term_id = $term_id";
		return $wpdb->get_row($get);
	}
	
	/**
	 * Gets term(s) from WordPress table for specific post ID
	 */
	function getTermForPost($post_id) {
		global $wpdb;
		$query = "SELECT term_id FROM $wpdb->term_taxonomy " .
				"INNER JOIN $wpdb->term_relationships ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id AND
				$wpdb->term_relationships.object_id = $post_id)";
		// TODO: Fix if more than one category for post_id exists. First result is only read now.
		$term_id = $wpdb->get_var($query);
		return $this->readTerm($term_id);
	}
	
	function getAllTerms(){
		global $wpdb;

		return $wpdb->get_results("SELECT * FROM ". WPSimileTimelineTerm::getTableName());
	}
   
    /**
     * Returns a comma separated string of active terms that should appear on the timeline
     */
    function getActiveTerms(){
    	global $wpdb;
	
		$get = "SELECT term_id FROM " . WPSimileTimelineTerm::getTableName() . " WHERE active=1";
		$results = $wpdb->get_results($get);
		$csv = '';
		foreach($results as $r){
			$csv .= $r->term_id . ',';
		}
		return substr($csv, 0, strlen($csv)-1);
    }
    
	/**
	 * Removes term from timeline database if the category is deleted
	 */
	function deleteTerm($term_id) {
		global $wpdb;
		
		$query = "DELETE FROM " . WPSimileTimelineTerm::getTableName() . " WHERE term_id= " . $term_id . "";
		$results = $wpdb->query($wpdb->prepare($query));
	}
	
	/* ---------------------------------------------------------------------------------
	 * output category ids, names and checkboxes
	 * --------------------------------------------------------------------------------*/
	function outputCategoryRows($term_type, $parent = 0, $level = 0, $categories = 0, $termdata=null) {
	    global $class;
	
		// read all categories from database if none is set in the parameter
		if(!$termdata){
			$terms = get_terms($term_type, array('hide_empty'=>false));
		}
		else{
			$terms = $termdata;
		}
	
		if ($terms) {
			$index = 1;
			$i=0;
			foreach ($terms as $category) {
				if ($category->parent == $parent) {
					$category->name = esc_html($category->name);
					$pad = str_repeat('&#8212; ', $level);
					$catid = $category->term_id;
					$cat = $this->readTerm($catid, array('active','color'));

					$checked = $cat->active ? 'checked="checked"' : '';
					$label  = '<label for="timelined_' . $catid . '">'.__('enable', 'stl_timeline').'</label> ';
					$checkbox = '<input name="stl_timeline[categories]['.$catid.'][status]" id="timelined_' . $catid . '" class="edit" type="checkbox"'. $checked . ' />&nbsp;&nbsp;';
					$input = $label . $checkbox;
					$colorpicker = WPSimileTimelineAdmin::buildColorpickInput('stl_timeline[categories][' . $catid . '][color]', $catid, 'pick'.$catid, $cat->color);
					$class = ('alternate' == $class) ? '' : 'alternate';
					
					echo "<tr class='$class'>";
					echo '<th style="text-align: center;" class="">'.$input.'</th>';
					echo '<th scope="row">'.$category->term_id.'</th>';
					echo '<th class="row-title">'. $pad . ' ' .$category->name.'</th>';
					echo '<th style="text-align: center;">' . $colorpicker . '</th>';
					echo '</tr>' . "\n";
					$this->outputCategoryRows($term_type, $catid, $level + 1, $categories, $terms);
					$index += 2;
				}
				$i++;
			}
		} else {
			return false;
		}
	}
}
?>