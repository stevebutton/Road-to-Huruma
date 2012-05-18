<?php

//	Link Color Options
function bm_color_options() {
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
} ?>
	<style type="text/css">
	a, a:link, a:visited, #basic-maths-calendar #wp-calendar tfoot a, .paged #nav li.current_page_item a {color:#<?php echo $bm_link_color; ?>;}
	a:hover, a:active, #nav li ul li.page_item a, #nav li.current_page_item ul li.page_item a, .sidebar #recentcomments a:hover, .sidebar .textwidget a:hover, .edit-link a:hover, #content a.post-edit-link:hover {color:#<?php echo $bm_hover_color; ?>;}
	#toptags, #alltags, #toptags ul li .description, #nav, .archive-meta, .page #content .entry-content .topcolumn, #wp-calendar tbody a, #wp-calendar, #header h1, #footer {border-color:#<?php echo $bm_link_color; ?>;}
	#nav li:hover a, #nav li ul, #nav li.page_item ul li ul, .paged #nav li.current_page_item:hover, .paged #nav li.current_page_item:hover a, #alltags ul li .description, #basic-maths-calendar #wp-calendar a:hover{border-color:#<?php echo $bm_hover_color; ?>;}
	#nav {border-bottom-color:#AAA}
	#nav li ul li.page_item a, .nav-previous a {border-color:#AAA;}
	.edit-link a, #content a.post-edit-link {color:red;}
	#skip, #basic-maths-calendar #wp-calendar a {background-color:#<?php echo $bm_link_color; ?>;}
	#skip:hover, #header h1:hover, .paged #nav li.current_page_item:hover, .paged #nav li.current_page_item:hover a, #alltags ul li:hover, #toptags ul li:hover, #datearchives ul li:hover, #allcategories ul li:hover, #alltags ul li:hover a span, #toptags ul li:hover a span, #allcategories ul li:hover a span, #datearchives ul li:hover a span, #nav li:hover, .nextprev a:hover, .sidebar ul li a:hover, .sidebar #basic-maths-recent-posts ul li a:hover, .sidebar #basic-maths-archives ul li a:hover, #basic-maths-calendar #wp-calendar a:hover {background-color:#<?php echo $bm_hover_color; ?>;}
	#basic-maths-calendar #wp-calendar tfoot a {background:transparent;}
	</style>

<?php }
add_action('wp_head', 'bm_color_options');

// Page Paragraph column short code
// Right
function bm_rightcolumn($atts, $content = null) {
	return '<div class="rightcolumn"><p>' . $content . '</p></div>';
}
add_shortcode("rightcolumn", "bm_rightcolumn");

// Top
function bm_topcolumn($atts, $content = null) {
	return '<div class="topcolumn"><p>' . $content . '</p></div> ';
}
add_shortcode("topcolumn", "bm_topcolumn");

// Left
function bm_leftcolumn($atts, $content = null) {
	return '<div class="leftcolumn"><p>' . $content . '</p></div> ';
}
add_shortcode("leftcolumn", "bm_leftcolumn");

//	Reset Widgets
//update_option( 'sidebars_widgets', $null );

//	Count Posts
function bm_post_count() {
    global $wpdb;
	echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_date_gmt < '" . gmdate("Y-m-d H:i:s",time()) . "'");
}

//	Count Tags
function bm_tag_count() {
    global $wpdb, $post;
    $current_tag = get_query_var('tag_id');
	$mytags = get_terms( 'post_tag', array ('include' => $current_tag) );
	echo $mytags[0]->count;
}

//	Count Categories
function bm_cat_count() {
    global $wpdb, $post;
    $current_cat = get_query_var('cat');
	$mycats = get_terms( 'category', array ('include' => $current_cat) );
	echo $mycats[0]->count;
}

//	All Tags Count
function all_tags_count() {
	$alltags = get_tags();
	$count = count($alltags);
	echo $count;
}

//	Top Tags List w/ Count
function basic_tags() {
	global $options;
	foreach ($options as $value) {
	    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}
	
	$toptags = get_terms( 'post_tag', array ('fields' => 'ids', 'orderby' => 'count', 'order' => 'DESC', 'number' => $bm_top_tag_count, 'hierarchical' => false ) );
	$alltags = get_tags();
	$count = count($alltags);
	
	// Remeber the top tags
	// Thanks to the Extended Category Widget http://blog.avirtualhome.com/wordpress-plugins
	$included_tags = implode( ",", $toptags );

	// Only include the top categories
	$bm_listtags = get_tags( array('include' => $included_tags, 'orderby' => 'name', 'order' => 'ASC') );

	foreach ( (array) $bm_listtags as $tag ) {
		echo '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag"><span>' . $tag->name . '</span> <span class="postcount">' . $tag->count . '</span></a></li>';
		echo "\n\t\t\t\t";
	}
	if($bm_archives_link == '') { 
		echo '<li class="all-tags-link"><span>' . __('All Tags', 'basicmaths') . '</span> <span class="postcount">';
		echo $count;
		echo "</span></li>\n";
	} else {
		$alltags_archives_link = '<a href="' . get_option(home) . '/' . $bm_archives_link . '">';
		echo '<li>' . $alltags_archives_link . '<span>' . __('All Tags', 'basicmaths') . '</span> <span class="postcount">';
		echo $count;
		echo "</span></a></li>\n";
	}
}

//	All Tags List w/ Count ' . $tag->tag_description . '
function all_basic_tags() {
	$tags = get_tags( array('orderby' => 'name', 'order' => 'ASC', 'number' => 0) );
	foreach ( (array) $tags as $tag ) {
		echo '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag"><span>' . $tag->name . '</span> <span class="postcount">' . $tag->count . '</span></a></li>';
		echo "\n\t\t\t\t";
	}
}

//	All Categories Count
function all_categories_count() {
	$allcategories = get_categories();
	$count = count($allcategories);
	echo $count;
}

//	Top Categories List w/ Count
function basic_categories() {
	global $options;
	foreach ($options as $value) {
	    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}
	
	$topcats = get_terms( 'category', array ('fields' => 'ids', 'orderby' => 'count', 'order' => 'DESC', 'number' => $bm_top_tag_count, 'hierarchical' => false ) );
	$allcats = get_categories();
	$count = count($allcats);
	
	// Remeber the top categories
	// Thanks to the Extended Category Widget http://blog.avirtualhome.com/wordpress-plugins
	$included_cats = implode( ",", $topcats );

	// Only include the top categories
	$bm_listcats = get_categories( array('include' => $included_cats, 'orderby' => 'name', 'order' => 'ASC') );

	foreach ( (array) $bm_listcats as $cat ) {
		echo '<li><a href="' . get_category_link ($cat->term_id) . '" rel="tag"><span>' . $cat->name . '</span> <span class="postcount">' . $cat->count . '</span></a></li>';
		echo "\n\t\t\t\t";
	}
	if($bm_archives_link == '') { 
		echo '<li class="all-tags-link"><span>' . __('All Categories', 'basicmaths') . '</span> <span class="postcount">';
		echo $count;
		echo "</span></li>\n";
	} else {
		$allcats_archives_link = '<a href="' . get_option(home) . '/' . $bm_archives_link . '">';
		echo '<li>' . $allcats_archives_link . '<span>' . __('All Categories', 'basicmaths') . '</span> <span class="postcount">';
		echo $count;
		echo "</span></a></li>\n";
	}
}

//	All Categories List w/ Count 
function all_basic_categories() {
	$cats = get_categories(array('orderby' => 'name', 'order' => 'ASC', 'number' => 0) );
	foreach ( (array) $cats as $cat ) {
		echo '<li><a href="' . get_category_link ($cat->term_id) . '" rel="tag"><span>' . $cat->name . '</span> <span class="postcount">' . $cat->count . '</span></a>';
		$desc = $cat->description;
		if ($desc!='') { // The description is not empty
			echo ' <span class="description">' . $desc . '</span></li>';
		} else {
			echo ' <span class="description">' . __('No description entered yet.', 'basicmaths') . '</span></li>';
    	}
		echo "\n\t\t\t\t";
	}
}

//	Archive Count
function _category_count($input = '') {
	echo _get_category_count($input);
}
function _get_category_count($input = '') {
	global $wpdb;
	if($input == '')
	{
		$category = get_the_category();
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
	}
}

//	Basic Date Archives 
//	http://wordpress.org/support/topic/227818
function basic_date_archives() { ?>
<?php global $wpdb; ?>
<?php $years = $wpdb->get_col("SELECT DISTINCT YEAR( post_date ) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC"); foreach($years as $year) : ?>
		<div class="archive-year">
			<h3><a href="<?php bloginfo('url') ?>/?m=<?php echo $year; ?>"><?php echo $year; ?></a></h3>
			<ul>
<?php $months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month , YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' GROUP BY month , year ORDER BY post_date DESC");
foreach($months as $month) : ?>
				<li><a href="<?php bloginfo('url') ?>/?m=<?php echo $month->year; ?><?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"><?php echo date("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?> <span class="archiveyear"><?php echo $month->year ?></span> <span class="postcount"><?php echo $month->post_count; if ($month->post_count> 1 ) { echo __( ' entries', 'basicmaths' ); } else { echo __( ' entry', 'basicmaths' ); }?></span></a></li>
			
<?php endforeach;?>
			</ul>
		</div>
<?php endforeach; ?>

<?php
}

//	Basic Date Archives
//	http://wordpress.org/support/topic/227818
function abbr_basic_date_arhives() { ?>
<?php global $wpdb; ?>
<?php $years = $wpdb->get_col("SELECT DISTINCT YEAR( post_date ) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC"); foreach($years as $year) : ?>
		<div class="archive-year">
			<ul>
<?php $months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month , YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' GROUP BY month , year ORDER BY post_date DESC");
foreach($months as $month) : ?>
				<li><a href="<?php bloginfo('url') ?>/?m=<?php echo $month->year; ?><?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"><?php echo date("M", mktime(0, 0, 0, $month->month, 1, $month->year)) ?> <span class="archiveyear"><?php echo $month->year ?></span> <span class="postcount"><?php echo $month->post_count; if ($month->post_count> 1 ) { echo __( ' entries', 'basicmaths' ); } else { echo __( ' entry', 'basicmaths' ); }?></span></a></li>
			
<?php endforeach;?>
			</ul>
		</div>
<?php endforeach; ?>

<?php
}

//	Basic Maths 404 Archive and email links
function basic_404_link() {
	global $options;
	foreach ($options as $value) {
	    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}

	if($bm_archives_link == '') {
		echo '<p>' . __('Still can’t find what you’re looking for? ', 'basicmaths') . ' <a href="mailto:' . antispambot(get_bloginfo('admin_email')) . '">' . __( 'Email me', 'basicmaths' ) . '</a>.' . __( 'Thanks!', 'basicmaths' ) . '</p>';

	} else {
		echo '<p>' . __( 'Still can’t find what you’re looking for? Try ', 'basicmaths' ) . '<a href="' . get_bloginfo ( 'url' ) . '/' . $bm_archives_link . '">' . __( 'browsing the archives', 'basicmaths' ) . '</a>, ' . __( 'or you can', 'basicmaths' ) . ' <a href="mailto:' . antispambot(get_bloginfo('admin_email')) . '">' . __( 'email me', 'basicmaths' ) . '</a>.' . __( 'Thanks!', 'basicmaths' ) . '</p>';

	}
}

//	Basic Maths Recent Posts Widget
function widget_basic_maths_recent_posts($args) {
    extract($args);
	$title = __( 'Recent Posts', 'basicmaths' );
?>
        <?php echo $before_widget; ?>
            <?php echo $before_title
                . $title
                . $after_title; ?>
				<ul>
<?php
global $post;
$myposts = get_posts('post_type=post&showposts=5');
foreach($myposts as $post) :
?>
					<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><span class="recent-post-date"><?php the_time('M j, ’y'); ?></span> <?php the_title(); ?></a></li>
<?php endforeach; ?>
				</ul>
				
        <?php echo $after_widget; ?>
<?php
}
register_sidebar_widget('Basic Maths Recent Posts', 'widget_basic_maths_recent_posts');

//	Basic Maths More Info Widget
function widget_basic_maths_more_info($args) {
    extract($args);
	$title = __( 'More Info', 'basicmaths' );
?>
        <?php echo $before_widget; ?>
            <?php echo $before_title
                . $title
                . $after_title; ?>
				<ul>
					<li class="entries-rss"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e( 'RSS Feed for Entries', 'basicmaths' ) ?></a></li>
					<li class="comments-rss"><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e( 'RSS Feed for Comments', 'basicmaths' ) ?></a></li>
					<li class="wordpress-link"><a href="http://wordpress.org" target="_blank"><?php _e( 'Powered by WordPress', 'basicmaths' ) ?></a></li>
				</ul>
				
        <?php echo $after_widget; ?>
<?php
}
register_sidebar_widget('Basic Maths More Info', 'widget_basic_maths_more_info');

//	Basic Maths Custom Archives Widget
function widget_basic_maths_archives($args) {
    extract($args);
	$title = __( 'Archives', 'basicmaths' );
?>
        <?php echo $before_widget; ?>
            <?php echo $before_title
                . $title
                . $after_title; ?>
<?php abbr_basic_date_arhives(); ?>
				
        <?php echo $after_widget; ?>
<?php
}
register_sidebar_widget('Basic Maths Archives', 'widget_basic_maths_archives');

//	Basic Maths Search Form
function basic_search_form($form) {
		$value = __('To search, type and hit enter', 'basicmaths');
		$search_form .= '';
		$form = '<form id="searchform" method="get" action="' . get_bloginfo('home') .'">
		<div><label class="hidden" for="s">' . __('Search for:', 'basicmaths') . '</label>
		<input id="s" name="s" type="text" value="' . $value . '" onfocus="if (this.value == \'' . $value . '\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'' . $value . '\';}" size="24" tabindex="1" />
		<input id="searchsubmit" name="searchsubmit" type="submit" value="' . __('Go', 'basicmaths') . '" tabindex="2" />
		</div>
		</form>';
		return $form;
	}
add_filter('get_search_form', 'basic_search_form');

// Preset Widgets
$preset_basicmaths_widgets = array (
	'left-sidebar'  => array( 'widget_basic_maths_recent_posts', 'widget_basic_maths_more_info' ),
	'right-sidebar'  => array( 'widget_basic_maths_archives' ),
);

// Custom Settings initiated at activation
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	update_option('thumbnail_size_h', '170');
	update_option('thumbnail_size_w', '170');
	update_option('thumbnail_crop', '1');

	update_option('medium_size_h', '440');
	update_option('medium_size_w', '440');
	update_option('medium_crop', '0');

	update_option('large_size_h', '620');
	update_option('large_size_w', '620');
	update_option('large_crop', '0');

	update_option('thread_comments', '1');
	update_option('thread_comments_depth', '3');

	update_option('sidebars_widgets', $preset_basicmaths_widgets);
}

//	Translations
load_theme_textdomain('basicmaths');
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);

// Custom callback to list comments in Basic Maths style
function basic_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li id="li-comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar($comment,$size='48',$default='' ); ?>

				<?php printf(__('<cite class="fn">%s</cite>, '), get_comment_author_link()) ?>
				
			</div>
<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.') ?></em>
			<br />
<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('<span class="comment-date">%1$s</span> at <span class="comment-time">%2$s</span>'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('Edit', 'basicmaths'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>') ?>
			</div>

			<?php comment_text() ?>

			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				
			</div>
		</div>
<?php }

// Custom callback to list pings in Basic Maths style
function basic_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
    		<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
    			<div class="comment-author"><?php printf(__('<span class="trackback-date">%2$s</span> %1$s', 'basicmaths'),
    					get_comment_author_link(),
    					get_comment_date() );
    					edit_comment_link(__('Edit', 'basicmaths'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'basicmaths') ?>
<?php }

//	Allowed tags in comments 
define('CUSTOM_TAGS', true);
global $allowedtags;
	$allowedtags = array(
		'a' => array(
			'href' => array (),
			'title' => array ()),
		'abbr' => array(
			'title' => array ()),
		'acronym' => array(
			'title' => array ()),
		'b' => array(),
		'blockquote' => array(
			'cite' => array ()),
		//	'br' => array(),
		'cite' => array (),
		'code' => array(),
		'del' => array(
			'datetime' => array ()),
		//	'dd' => array(),
		//	'dl' => array(),
		//	'dt' => array(),
		'em' => array (), 'i' => array (),
		//	'ins' => array('datetime' => array(), 'cite' => array()),
		'ol' => array(),
		'ul' => array(),
		'li' => array(),
		//	'p' => array(),
		//	'q' => array('cite' => array ()),
		//'strike' => array(),
		'strong' => array(),
		//	'sub' => array(),
		//	'sup' => array(),
		//	'u' => array(),
	);

//	Basic Maths Options
//	------------------------------------------------------------------------------

$themename = "Basic Maths";
$shortname = "bm";
$options = array (

				array(	"name" => __('Link Color','basicmaths'),
						"desc" => __('Change the color of links, backgrounds and borders by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">003333</span>)','basicmaths'),
						"id" => $shortname."_link_color",
						"std" => "000033",
						"type" => "text"),

				array(	"name" => __('Hover Color','basicmaths'),
						"desc" => __('Change the color of hover links by entering a HEX color number. (ie: <span style="font-family:Monaco,Lucida Console,Courier,monospace;">FF6600</span>)','basicmaths'),
						"id" => $shortname."_hover_color",
						"std" => "FF6600",
						"type" => "text"),

				array(	"name" => __('Top Tag Count','basicmaths'),
						"desc" => __('Choose the number of &lsquo;Top Tags&rsquo; to display in the header (Set to <span style="font-family:Monaco,Lucida Console,Courier,monospace;">0</span> to show all tags).','basicmaths'),
						"id" => $shortname."_top_tag_count",
						"std" => "11",
						"type" => "text"),

				array(	"name" => __('Show Categories','basicmaths'),
						"desc" => __("Check here to display a list of Categories in the header instead of Tags.",'basicmaths'),
						"id" => $shortname."_cats_or_tags",
						"std" => "false",
						"type" => "checkbox"),

				array(	"name" => __('Archives Link','basicmaths'),
						"desc" => __('Insert the slug of the page using the Archives template. (example: For a page Titled “History” that uses the Archives template, insert the slug <span style="font-family:Monaco,Lucida Console,Courier,monospace;font-weight:600">history</span> so that the “All Tags” link points to the correct page).','basicmaths'),
						"id" => $shortname."_archives_link",
						"std" => "",
						"type" => "text"),

				array(	"name" => __('Footer Text','basicmaths'),
						"desc" => __('Type in the HTML text that will appear in the bottom of your footer. (example: &copy;2008 < a href="http://basicmaths.subtraction.com" >Your Copyright Info< /a >. All rights reserved.','basicmaths'),
						"id" => $shortname."_footer_text",
						"std" => "&copy;2008 <a href=\"http://basicmaths.subtraction.com\">Your Copyright Info</a>. All rights reserved.",
						"type" => "textarea",
						"options" => array(	"rows" => "3", "cols" => "94") ),

		);

function basicmaths_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "Basic Maths Options", 'edit_themes', basename(__FILE__), 'basicmaths_admin');

}

function basicmaths_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
<h2><?php echo $themename; ?> Options</h2>

<form method="post" action="">

	<table class="form-table">

<?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
		case 'text':
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'basicmaths'); ?></label></th>
			<td>
				<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
				<?php echo __($value['desc'],'basicmaths'); ?>

			</td>
		</tr>
		<?php
		break;
		
		case 'select':
		?>
		<tr valign="top">
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'basicmaths'); ?></label></th>
				<td>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php foreach ($value['options'] as $option) { ?>
					<option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<?php
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		?>
		<tr valign="top"> 
			<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo __($value['name'],'basicmaths'); ?></label></th>
			<td><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="<?php echo $ta_options['rows']; ?>"><?php 
				if( get_option($value['id']) != "") {
						echo __(stripslashes(get_option($value['id'])),'basicmaths');
					}else{
						echo __($value['std'],'basicmaths');
				}?></textarea><br /><?php echo __($value['desc'],'basicmaths'); ?></td>
		</tr>
		<?php
		break;

		case 'radio':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'basicmaths'); ?></th>
			<td>
				<?php foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_option($value['id']);
				if($radio_setting != ''){
					if ($key == get_option($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label><br />
				<?php } ?>
			</td>
		</tr>
		<?php
		break;
		
		case 'checkbox':
		?>
		<tr valign="top"> 
			<th scope="row"><?php echo __($value['name'],'basicmaths'); ?></th>
			<td>
				<?php
					if(get_option($value['id'])){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				?>
				<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
				<label for="<?php echo $value['id']; ?>"><?php echo __($value['desc'],'basicmaths'); ?></label>
			</td>
		</tr>
		<?php
		break;

		default:

		break;
		
	}
}
?>

	</table>

	<p class="submit">
		<input name="save" type="submit" value="<?php _e('Save changes','basicmaths'); ?>" />    
		<input type="hidden" name="action" value="save" />
	</p>
</form>
<form method="post" action="">
	<p class="submit">
		<input name="reset" type="submit" value="<?php _e('Reset','basicmaths'); ?>" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

<p><?php _e('For more information about this theme, visit the <a href="http://basicmaths.subtraction.com/" target="_blank">Basic Maths Theme Page</a>.', 'basicmaths'); ?></p>
</div>
<?php
}

add_action('admin_menu' , 'basicmaths_add_admin'); 

//	Body Browser Classes
function browser_body_class($classes) {

	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];
	
	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ){
			$classes[] = 'mac';
		
	} elseif ( preg_match( "/Windows/", $browser ) ){
			$classes[] = 'windows';
		
	} elseif ( preg_match( "/Linux/", $browser ) ) {
			$classes[] = 'linux';

	} else {
			$classes[] = 'unknown-os';
	}
	
	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Chrome/", $browser ) ) {
			$classes[] = 'chrome';

			preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
			$ch_version = 'ch' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $ch_version;

	} elseif ( preg_match( "/Safari/", $browser ) ) {
			$classes[] = 'safari';
			
			preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
			$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $sf_version;
			
	} elseif ( preg_match( "/Opera/", $browser ) ) {
			$classes[] = 'opera';
			
			preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
			$op_version = 'op' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $op_version;
			
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
			$classes[] = 'msie';
			
			if( preg_match( "/MSIE 6.0/", $browser ) ) {
					$classes[] = 'ie6';
			} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
					$classes[] = 'ie7';
			} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
					$classes[] = 'ie8';
			}
			
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
			$classes[] = 'firefox';
			
			preg_match( "/Firefox\/(\d)/si", $browser, $matches);
			$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );      
			$classes[] = $ff_version;
			
	} else {
			$classes[] = 'unknown-browser';
	}

	return $classes;
}
add_filter('body_class','browser_body_class');

//	Register Side Bars
if ( function_exists('register_sidebar') )
	register_sidebar(array(
        'name' => 'Left Sidebar',
        'id' => 'left-sidebar',
		'before_widget'  =>   "\n\t\t\t" . '<li id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "\n\t\t\t</li>\n",
		'before_title'   =>   "\n\t\t\t\t". '<h3 class="widgettitle">',
		'after_title'    =>   "</h3>\n"
    ));
	register_sidebar(array(
        'name' => 'Right Sidebar',
        'id' => 'right-sidebar',
		'before_widget'  =>   "\n\t\t\t" . '<li id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "\n\t\t\t</li>\n",
		'before_title'   =>   "\n\t\t\t\t". '<h3 class="widgettitle">',
		'after_title'    =>   "</h3>\n"
    ));

// Load Grid Layout - Custom script by Erin Sparling
function basic_maths_js() { ?>
	<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo bloginfo('stylesheet_directory') ?>/js/jquery.hotkeys-0.7.9.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo bloginfo('stylesheet_directory') ?>/js/robustcolumns.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			// Top Tags JS
			$('#toptags ul').makeacolumnlists({cols: 4, colWidth: 0, equalHeight: 'ul', startN: 1});
			$('#alltags ul').makeacolumnlists({cols: 4, colWidth: 0, equalHeight: 'ul', startN: 1});
			$('#allcategories ul').makeacolumnlists({cols: 4, colWidth: 0, equalHeight: 'ul', startN: 1});
			
			// Grid JS
			$(document).bind('keydown', 'Alt+Shift+g', function(){
				$("body").toggleClass("gridSystem");
			});
		});
	</script>
<?php }
add_action('wp_head','basic_maths_js');

?>