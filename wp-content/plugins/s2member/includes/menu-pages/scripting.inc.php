<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
API Scripting page.
*/
echo '<div class="wrap ws-menu-page">' . "\n";
/**/
echo '<div id="icon-plugins" class="icon32"><br /></div>' . "\n";
echo '<h2><div>Developed by <a href="' . ws_plugin__s2member_parse_readme_value ("Plugin URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-light.png" alt="." /></a></div>s2Member API / Scripting</h2>' . "\n";
/**/
echo '<div class="ws-menu-page-hr"></div>' . "\n";
/**/
echo '<table class="ws-menu-page-table">' . "\n";
echo '<tbody class="ws-menu-page-table-tbody">' . "\n";
echo '<tr class="ws-menu-page-table-tr">' . "\n";
echo '<td class="ws-menu-page-table-l">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_scripting_page_before_left_sections", get_defined_vars ());
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_easy_way", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_easy_way", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="The Extremely Easy Way">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-easy-way-section">' . "\n";
		echo '<h3>The Extremely Easy Way ( no scripting required )</h3>' . "\n";
		echo '<p>From your s2Member General Options Panel, you may restrict access to certain Posts, Pages, Tags, Categories, and/or URIs based on a Member\'s Level. The s2Member Options Panel makes it easy for you. All you do is type in the basics of what you want to restrict access to, and those sections of your site will be off limits to non-Members. That being said, there are times when you might need to have greater control over which portions of your site can be viewed by non-Members, or Members at different Levels; with different Capabilities. This is where API Scripting with Conditionals comes in.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_easy_way", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_easy_way", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_simple_way", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_simple_way", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Using Simple Conditionals">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-simple-way-section">' . "\n";
		echo '<h3>Simple Conditionals ( via WordPress® Shortcodes )</h3>' . "\n";
		echo '<p>In an effort to give you even more control over access restrictions, s2Member makes Simple Conditionals available to you from within WordPress®, using Shortcodes that are fully compatible with both the Visual Editor, and also the HTML Tab in WordPress®. In this section, we\'ll demonstrate several functions that are possible using Shortcodes: <strong><code>is_user_logged_in()</code></strong>, <strong><code>is_user_not_logged_in()</code></strong>, <strong><code>current_user_is(role)</code></strong>, <strong><code>current_user_is_not(role)</code></strong>, <strong><code>current_user_can(capability)</code></strong>, <strong><code>current_user_cannot(capability)</code></strong>, <strong><code>current_user_is_for_blog(blog_id,role)</code></strong>, <strong><code>current_user_is_not_for_blog(blog_id,role)</code></strong>, <strong><code>current_user_can_for_blog(blog_id,capability)</code></strong>, <strong><code>current_user_cannot_for_blog(blog_id,capability)</code></strong>. To make use of these functions, please follow our code samples below. Using Shortcodes, it\'s easy to build Simple Conditionals within your content; based on a Member\'s Level, or even based on Custom Capabilities. s2Member\'s Shortcodes can be used inside a Post/Page, and also inside Text Widgets.</p>' . "\n";
		echo '<p><em>There are <strong>two different Shortcodes</strong> being demonstrated here:<br /><strong>1. <code>s2If</code></strong> ( for testing simple conditional expressions ).<br /><strong>2. <code>s2Get</code></strong> ( to get an API Constant value, a Custom Field, or meta key ).</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_simple_way", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #1:</strong> Full access for anyone that is logged in.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-is-user-logged-in.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #2:</strong> Full access for any Member with a Level >= 1.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-current-user-can-full-access.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #3:</strong> Specific content for each different Member Level.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-current-user-is-specific-content.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #4:</strong> Using s2Member API Conditionals, supplementing WordPress® core functions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-s2-conditional-supplements-1.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #5:</strong> Using multiple Conditionals together, and even nesting other Shortcodes.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-s2-conditional-supplements-2.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #6:</strong> Using multiple Conditionals together, and even nesting Conditionals.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-s2-conditional-supplements-3.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Membership Levels provide incremental access:</strong></p>' . "\n";
		echo '<p>* A Member with Level 4 access, will also be able to access Levels 0, 1, 2 &amp; 3.<br />* A Member with Level 3 access, will also be able to access Levels 0, 1 &amp; 2.<br />* A Member with Level 2 access, will also be able to access Levels 0 &amp; 1.<br />* A Member with Level 1 access, will also be able to access Level 0.<br />* A Subscriber with Level 0 access, will ONLY be able to access Level 0.</p>' . "\n";
		echo '<p><em>* WordPress® Subscribers are at Membership Level 0. If you\'re allowing Open Registration, Subscribers will be at Level 0 ( a Free Subscriber ). WordPress® Administrators, Editors, Authors, and Contributors have Level 4 access, with respect to s2Member. All of their other Roles/Capabilities are left untouched.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><em><strong>s2Member supports ALL <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank" rel="external">Conditional Tags</a> in WordPress®.</strong> Including, but not limited to: <strong><code>is_multisite()</code></strong>, <strong><code>is_main_site()</code></strong>, <strong><code>is_super_admin()</code></strong>, <strong><code>is_admin()</code></strong>, <strong><code>is_404()</code></strong>, <strong><code>is_home()</code></strong>, <strong><code>is_front_page()</code></strong>, <strong><code>is_comments_popup()</code></strong>, <strong><code>is_singular(ID|slug|{slug,ID})"</code></strong>, <strong><code>is_single(ID|slug|{slug,ID})</code></strong>, <strong><code>is_page(ID|slug|{slug,ID})</code></strong>, <strong><code>is_page_template(file.php)</code></strong>, <strong><code>is_attachment()</code></strong>, <strong><code>is_feed()</code></strong>, <strong><code>is_trackback()</code></strong>, <strong><code>is_archive()</code></strong>, <strong><code>is_search()</code></strong>, <strong><code>is_category(ID|slug|{slug,ID})</code></strong>, <strong><code>is_tax(taxonomy,term)</code></strong>, <strong><code>is_tag(slug|{slug,slug})"</code></strong>, <strong><code>has_tag(slug|{slug,slug})"</code></strong>, <strong><code>is_author(ID|slug|{slug,ID})</code></strong>, <strong><code>is_date()</code></strong>, <strong><code>is_day()</code></strong>, <strong><code>is_month()</code></strong>, <strong><code>is_time()</code></strong>, <strong><code>is_year()</code></strong>, <strong><code>is_sticky(ID)</code></strong>, <strong><code>is_paged()</code></strong>, <strong><code>is_preview()</code></strong>, <strong><code>comments_open()</code></strong>, <strong><code>pings_open()</code></strong>, <strong><code>has_excerpt(ID)</code></strong>, <strong><code>in_the_loop()</code></strong>, <strong><code>is_active_sidebar(ID|number)</code></strong>.</em></p>' . "\n";
		/**/
		echo '<p><em><strong>Passing arguments into a Simple Conditional:</strong></em></p>' . "\n";
		echo '<p><em>1. True/false -> ex: <code>current_user_can()</code> / <code>!current_user_can()</code><br />2. False explicitly -> ex: <code>current_user_cannot()</code><br />3. Passing an ID -> ex: <code>is_page(24)</code><br />4. Passing a Slug -> ex: <code>is_page(my-cool-page)</code><br />5. Passing an Array -> ex: <code>is_page({my-cool-page,24,about,contact-form})</code></em></p>' . "\n";
		echo '<p><em>*Tip: do NOT use spaces inside Conditionals.<br /> <strong class="ws-menu-page-error-hilite">BAD</strong> <code>is_page(My Membership Options Page)</code><br />- use slugs or IDs instead, no spaces.</em></p>' . "\n";
		/**/
		echo '<p><em><strong>Implementing AND/OR Conditional expressions:</strong></em></p>' . "\n";
		echo '<p><em>*Tip: do NOT mix AND/OR expressions.<br /> <strong class="ws-menu-page-error-hilite">BAD</strong> <code>is_user_logged_in() AND is_page(1) OR is_page(2)</code><br />- use one or the other; do NOT mix AND/OR together.</em></p>' . "\n";
		echo '<p><em><strong class="ws-menu-page-hilite">If you need to have both types of logic, use nesting:</strong></em></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/sc-s2-conditional-nesting.php")) . '</p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_simple_way", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_advanced_way", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_advanced_way", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Using Advanced Conditionals">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-advanced-way-section">' . "\n";
		echo '<h3>The Advanced Way ( some PHP scripting required )</h3>' . "\n";
		echo '<p>In an effort to give you even more control over access restrictions, s2Member makes some PHP functions, and also some PHP Constants, available to you from within WordPress®. In this section, we\'ll demonstrate several functions: <strong><code>is_user_logged_in()</code></strong>, <strong><code>is_user_not_logged_in()</code></strong>, <strong><code>current_user_is("role")</code></strong>, <strong><code>current_user_is_not("role")</code></strong>, <strong><code>current_user_can("capability")</code></strong>, <strong><code>current_user_cannot("capability")</code></strong>, <strong><code>current_user_is_for_blog($blog_id,"role")</code></strong>, <strong><code>current_user_is_not_for_blog($blog_id,"role")</code></strong>, <strong><code>current_user_can_for_blog($blog_id,"capability")</code></strong>, &amp; <strong><code>current_user_cannot_for_blog($blog_id,"capability")</code></strong>. To make use of these functions, please follow our PHP code samples below. Using PHP, is a very powerful way to build Advanced Conditionals within your content; based on a Member\'s Level, Custom Capabilities, and/or other factors. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/php-execution-plugin/" target="_blank" rel="external">PHP Execution</a> ).</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_advanced_way", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #1:</strong> Full access for anyone that is logged in.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/is-user-logged-in.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #2:</strong> Full access for any Member with a Level >= 1.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-full-access.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #3:</strong> Specific content for each different Member Level.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-is-specific-content.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #4:</strong> Using s2Member API Conditionals, supplementing WordPress® core functions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/s2-conditional-supplements-1.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #5:</strong> Using s2Member API Conditionals, supplementing WordPress® core functions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/s2-conditional-supplements-2.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #6:</strong> Using multiple Conditionals together, and even nesting Conditionals.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/s2-conditional-supplements-3.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #7:</strong> Using s2Member API Constants, instead of conditional functions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-constants-1.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #8:</strong> Using s2Member API Constants, instead of conditional functions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-constants-2.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Membership Levels provide incremental access:</strong></p>' . "\n";
		echo '<p>* A Member with Level 4 access, will also be able to access Levels 0, 1, 2 &amp; 3.<br />* A Member with Level 3 access, will also be able to access Levels 0, 1 &amp; 2.<br />* A Member with Level 2 access, will also be able to access Levels 0 &amp; 1.<br />* A Member with Level 1 access, will also be able to access Level 0.<br />* A Subscriber with Level 0 access, will ONLY be able to access Level 0.</p>' . "\n";
		echo '<p><em>* WordPress® Subscribers are at Membership Level 0. If you\'re allowing Open Registration, Subscribers will be at Level 0 ( a Free Subscriber ). WordPress® Administrators, Editors, Authors, and Contributors have Level 4 access, with respect to s2Member. All of their other Roles/Capabilities are left untouched.</em></p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_advanced_way", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_queries", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_queries", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Advanced Query Conditionals">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-advanced-way-section">' . "\n";
		echo '<h3>Advanced Query Conditionals ( some PHP scripting required )</h3>' . "\n";
		echo '<p>s2Member provides several built-in API Functions that are tailored to meet the needs of developers integrating s2Member into their themes. Such as: <strong><code>is_protected_by_s2member($id, "[category,tag,post,page,singular,uri]")</code></strong>, <strong><code>is_permitted_by_s2member($id, "[category,tag,post,page,singular,uri]")</code></strong>, <strong><code>is_category_protected_by_s2member($cat_id)</code></strong>, <strong><code>is_category_permitted_by_s2member($cat_id)</code></strong>, <strong><code>is_tag_protected_by_s2member($tag_id [slug or tag name])</code></strong>, <strong><code>is_tag_permitted_by_s2member($tag_id [slug or tag name])</code></strong>, <strong><code>is_post_protected_by_s2member($post_id)</code></strong>, <strong><code>is_post_permitted_by_s2member($post_id)</code></strong>, <strong><code>is_page_protected_by_s2member($page_id)</code></strong>, <strong><code>is_page_permitted_by_s2member($page_id)</code></strong>, <strong><code>is_uri_protected_by_s2member($uri [or full url])</code></strong>, <strong><code>is_uri_permitted_by_s2member($uri [ or full url])</code></strong>.</p>' . "\n";
		echo '<p>In addition, there are two special functions that can be applied by theme authors before making custom queries: <strong><code>attach_s2member_query_filters()</code></strong>, <strong><code>detach_s2member_query_filters()</code></strong>. These can be used before and after a call to <strong><code>query_posts()</code></strong> for example. s2Member will automatically filter all protected content ( not available to the current User/Member ).</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_queries", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #1:</strong> Pre-filtering custom queries in WordPress®.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/custom-queries.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #2:</strong> OR, instead of pre-filtering; check Access Restrictions in The Loop.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/custom-queries-loop.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #3:</strong> Checking Tag Restrictions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/specific-tag-restrictions.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #4:</strong> Checking Category Restrictions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/specific-category-restrictions.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #5:</strong> Checking Page Restrictions.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/specific-page-restrictions.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Example #6:</strong> Checking Post Restrictions, including Custom Post Types.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/specific-post-restrictions.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Additional examples:</strong> documentation on these function calls.</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/query-conditional-examples.php")) . '</p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_queries", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_custom_capabilities", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_custom_capabilities", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Custom Capabilities ( Packages )">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-custom-capabilities-section">' . "\n";
		echo '<h3>Packaging Together Custom Capabilities w/ Membership</h3>' . "\n";
		echo '<p>Using one of s2Member\'s Payment Button and/or Form Generators, you can add Custom Capabilities in comma delimited format. s2Member builds upon existing functionality offered by WordPress® Roles/Capabilities. s2Member supports Free Subscribers ( at Level #0 ), and up to four Primary Roles ( i.e. s2Member Levels 1-4 ). Each s2Member Level provides <code>current_user_can("access_s2member_level0"), 1, 2, 3, 4</code>. These are the default Capabilities that come with each Membership Level. Now... If you\'d like to package together some variations of each Membership Level that you\'re selling, you can! All you do is add some Custom Capabilities whenever you create your Payment Button and/or Form Shortcode ( <em>there is a field in the Button &amp; Form Generators where you can enter Custom Capabilities</em> ). You can sell membership packages that come with Custom Capabilities, and even with custom prices.</p>' . "\n";
		echo '<p>Custom Capabilities are an extension to a feature that already exists in WordPress®. The <code>current_user_can()</code> function, can be used to test for these additional Capabilities that you allow. Whenever a Member completes the checkout process, after having purchased a Membership from you ( one that included Custom Capabilities ), s2Member will add those Custom Capabilities to the account for that specific Member.</p>' . "\n";
		echo '<p>Custom Capabilities are always prepended with <code>access_s2member_ccap_</code>. You fill in the last part, with ONLY lowercase alpha-numerics and/or underscores. For example, let\'s say you want to sell Membership Level #1, as is. But, you also want to sell a slight variation of Membership Level #1, that includes the ability to access the Music &amp; Video sections of your site. So, instead of selling this additional access under a whole new Membership Level, you could just sell a modified version of Membership Level #1. Add the the Custom Capabilities: <code>music,videos</code>. Once a Member has these Capabilities, you can test for these Capabilities using <code>current_user_can("access_s2member_ccap_music")</code> and <code>current_user_can("access_s2member_ccap_videos")</code>.</p>' . "\n";
		echo '<p>The important thing to realize, is that Custom Capabilities, are just that. They\'re custom. s2Member only deals with the default Capabilities that it uses. If you start using Custom Capabilities, you MUST use Simple or Advanced Conditionals ( <em>i.e. <code>current_user_can</code> logic</em> ) to test for them. Either in your theme files with PHP, or in Posts/Pages using Simple Conditionals ( powered by Shortcodes ).</p>' . "\n";
		echo '<p><em class="ws-menu-page-hilite"><strong>*Tip*</strong> Starting with s2Member v3.2+, you can now tell s2Member to require certain Custom Capabilities on a per Post/Page basis. So now, s2Member ( if you prefer ) CAN handle Custom Capabilities for you automatically! Whenever you edit a Post/Page, you can tell s2Member ( i.e. there is a Meta Box for s2Member in your Post/Page editing station )... you can tell s2Member to require certain Custom Capabilities that you type in, using comma-delimited format. In other words, you will need to type in some of the trigger words that you used whenever you created your Payment Buttons/Forms. This way paying Members will have the Custom Capabilities to view different kinds of content that you offer.</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_custom_capabilities", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Custom Capabilities:</strong> ( music,videos ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-ccaps-1.php")) . '</p>' . "\n";
		/**/
		echo '<p><strong>Custom Capabilities:</strong> ( ebooks,reports,tips ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-can-ccaps-2.php")) . '</p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_custom_capabilities", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_custom_capability_files", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_custom_capability_files", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Custom Capability &amp; Member Level Files">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-custom-capability-files-section">' . "\n";
		echo '<h3>Restricting Files, Based On Custom Capabilities</h3>' . "\n";
		echo '<p>If you\'re NOT familiar with Custom Capabilities yet, please read the section above, titled: `Custom Capability Packages`, and also see: `s2Member -> Download Options`, both as primers; BEFORE you read this section. Once you understand the basic concept of Custom Capabilities &amp; Protected File Downloads, you\'ll see that ( by default ) s2Member does NOT handle File Download Protection with respect to Custom Capabilities. That\'s where Custom Capability Sub-directories come in.</p>' . "\n";
		echo '<p>You can create Custom Capability Sub-directories under: <code>/plugins/s2member-files/</code>. For instance, if you have a Custom Capability <code>music</code>, you can place protected files that should ONLY be accessible to Members with <code>access_s2member_ccap_music</code>, inside: <code>/s2member-files/access-s2member-ccap-music/</code>. Some examples are provided below.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_custom_capability_files", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Custom Capabilities:</strong> ( music,videos )</p>' . "\n";
		echo '<p>Sub-Directory: <code>/s2member-files/access-s2member-ccap-music</code><br />Sub-Directory: <code>/s2member-files/access-s2member-ccap-videos</code></p>' . "\n";
		echo '<p>Protected File: <code>/s2member-files/access-s2member-ccap-music/file.mp3</code><br />Protected File: <code>/s2member-files/access-s2member-ccap-videos/file.avi</code></p>' . "\n";
		echo '<p>Now, here are some link examples, using Custom Capability Sub-directories:</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/ccap-file-downloads.php")) . '</p>' . "\n";
		echo '<p><em>These links will ONLY work for Members who are logged-in, with the proper Capabilities.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Membership Levels:</strong> ( this also works fine )</p>' . "\n";
		echo '<p>Sub-Directory: <code>/s2member-files/access-s2member-level0</code><br />Sub-Directory: <code>/s2member-files/access-s2member-level1</code><br />Sub-Directory: <code>/s2member-files/access-s2member-level2</code><br />Sub-Directory: <code>/s2member-files/access-s2member-level3</code><br />Sub-Directory: <code>/s2member-files/access-s2member-level4</code></p>' . "\n";
		echo '<p>Protected File: <code>/s2member-files/access-s2member-level0/tiger.doc</code><br />Protected File: <code>/s2member-files/access-s2member-level1/zebra.pdf</code><br />Protected File: <code>/s2member-files/access-s2member-level2/elephant.doc</code><br />Protected File: <code>/s2member-files/access-s2member-level3/rhino.pdf</code><br />Protected File: <code>/s2member-files/access-s2member-level4/lion.doc</code></p>' . "\n";
		echo '<p>Now, here are some link examples, using Member Level Sub-directories:</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level-file-downloads.php")) . '</p>' . "\n";
		echo '<p><em>These links will ONLY work for Members who are logged-in, with an adequate Membership Level.</em></p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_custom_capability_files", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_advanced_dripping", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_advanced_dripping", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="s2Member Content Dripping">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-advanced-dripping-section">' . "\n";
		echo '<h3>Dripping Content ( some PHP scripting required )</h3>' . "\n";
		echo '<p>Content Dripping is the gradual, pre-scheduled release of premium website content to paying Members. This has become increasingly popular, because it allows older Members; those who have paid you more, due to recurring charges; to acquire access to more content progressively; based on their original paid registration time. It also gives you ( as the site owner ), the ability to launch multiple membership site portals, operating on autopilot, without any direct day-to-day involvement in a content release process. This requires some PHP scripting. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/php-execution-plugin/" target="_blank" rel="external">PHP Execution</a> ).</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_advanced_dripping", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>To drip content using <code>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS</code>:</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-paid-registration-days-dripping.php")) . '</p>' . "\n";
		/**/
		echo '<p><em>There are more examples on this page, under the sub-section "s2Member PHP/API Constants". You\'ll see that s2Member provides you with access to several PHP/API Constants, which will assist you in dripping content. Some of the most relevant API Constants include: <code>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME</code>, <code>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS</code>, <code>S2MEMBER_CURRENT_USER_REGISTRATION_TIME</code>, <code>S2MEMBER_CURRENT_USER_REGISTRATION_DAYS</code>; and there are many others.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<h3>Very Advanced Content Dripping ( some PHP required )</h3>' . "\n";
		echo '<p>If you plan on dripping content in VERY advanced ways, you can tap into s2Member\'s recorded history of all Paid Registration Times. ( i.e. <code>' . esc_html ('<?php $time = s2member_paid_registration_time("level1"); ?>') . '</code> ) will give you a timestamp at which a Member first paid for Level#1 access. If they\'ve never paid for Level#1 access, the function will return 0. s2Member keeps a recorded history of timestamps associated with each Level that a Member gains access to, throughout the lifetime of their account. * NOTE: This requires s2Member v3.3+. Previous versions of s2Member did NOT record this information. If you implement this functionality on an upgraded installation of s2Member, please remember that s2Member will have NO Paid Registration Time for any Member you acquired prior to installing s2Member v3.3+. <em>Check the forums for work-arounds.</em></p>' . "\n";
		echo '<p><strong>Here is the function documentation for PHP/WordPress® developers:</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/s2member-paid-registration-time.php")) . '</p>' . "\n";
		echo '<p><strong>Here are some actual examples that should give you some ideas:</strong></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/s2member-paid-registration-time-examples.php")) . '</p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_advanced_dripping", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_profile_modifications", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_profile_modifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="Member Profile Modifications">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-profile-modifications-section">' . "\n";
		echo '<h3>Giving Members The Ability To Modify Their Profile</h3>' . "\n";
		echo '<p>s2Member can be configured to redirect Members away from the <a href="profile.php" target="_blank" rel="external">default Profile Editing Panel</a> that is built into WordPress®. <em>See: <code>s2Member -> General Options -> Profile Modifications</code>.</em> When/if a Member attempts to access the default Profile Editing Panel, they\'ll instead, be redirected to the Login Welcome Page that you\'ve configured through s2Member. <strong>Why would I redirect?</strong> Unless you\'ve made some drastic modifications to your WordPress® installation, the default Profile Editing Panel that ships with WordPress®, is NOT really suited for public access, even by a Member.</p>' . "\n";
		echo '<p>So instead of using this default Profile Editing Panel; s2Member creates an added layer of functionality, on top of WordPress®. It does this by providing you ( as the site owner ), with the ability to send your Members to a <a href="' . get_bloginfo ("wpurl") . '/?s2member_profile=1" target="_blank" rel="external">special Stand-Alone page</a>, where your Members can modify their entire Profile, including all Custom Fields, and their Password. This special Stand-Alone Editing Panel, has been designed ( with a bare-bones format ), intentionally. This makes it possible for you to <a href="#" onclick="if(!window.open(\'' . get_bloginfo ("wpurl") . '/?s2member_profile=1\', \'_popup\', \'height=350,width=400,left=100,screenX=100,top=100,screenY=100, location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1\')) alert(\'Please disable popup blockers and try again!\'); return false;" rel="external">open it up in a popup window</a>, or embed it into your Login Welcome Page using an IFRAME. Code samples are provided below.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_profile_modifications", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL</strong> = URL to a Stand-Alone Profile Editing Panel.</p>' . "\n";
		echo '<p>Copy &amp; Paste one of the code snippets below, into your Login Welcome Page, so Members can click a link to Edit their Profile. This requires some PHP scripting. In order to use PHP scripting inside your Posts/Pages, you\'ll need to install this handy plugin ( <a href="http://wordpress.org/extend/plugins/php-execution-plugin/" target="_blank" rel="external">PHP Execution</a> ).</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>Code Sample #1</strong> ( standard link tag ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-1.php")) . '</p>' . "\n";
		/**/
		echo '<p><strong>Code Sample #2</strong> ( open the link in a popup window ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2.php")) . '</p>' . "\n";
		/**/
		echo '<p><strong>Code Sample #3</strong> ( embed the form into a Post/Page using an IFRAME tag ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-3.php")) . '</p>' . "\n";
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_profile_modifications", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_constants", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_constants", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="s2Member PHP/API Constants">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-constants-section">' . "\n";
		echo '<h3>You Have Access To PHP Constants ( some PHP scripting required )</h3>' . "\n";
		echo '<p>A Constant, is an identifier ( name ) for a simple value in PHP scripting. Below is a comprehensive list that includes all of the PHP defined Constants available to you. All of these Constants are also available through JavaScript as Global Variables. Example code has been provided in the documentation below. If you\'re a web developer, we suggest using some of these Constants in the creation of your Login Welcome Page; which is described in the s2Member General Options Panel. It is not required mind you, but you can get pretty creative with the Login Welcome Page, if you know a little PHP.</p>' . "\n";
		echo '<p>For example, you might use `S2MEMBER_CURRENT_USER_ACCESS_LABEL` to display the type of Membership a Customer has. Or, you could use `S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL` to provide Customers\' with an easy way to update their Membership Profile. If you get stuck on this, you might want to check out Elance.com. You can hire a freelancer to do this for you. It\'s about a $100 job. There are many other possibilities; <em>limitless actually!</em></p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_constants", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p>Before you read any further, you should install this handy plugin: <a href="http://wordpress.org/extend/plugins/php-execution-plugin/" target="_blank" rel="external">PHP Execution</a>.<br />' . "\n";
		echo 'You\'ll need to have this plugin installed to use PHP code in Posts/Pages.</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_VERSION</strong><br />This will always be a (string) with the current s2Member version. Available since s2Member 3.0.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/version.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_IS_LOGGED_IN</strong><br />This will always be (bool) true or false. True if a User/Member is currently logged in with an Access Level >= 0.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-is-logged-in.php")) . '</p>' . "\n";
		echo '<p><em>See <code>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</code> below for a full explanation.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_IS_LOGGED_IN_AS_MEMBER</strong><br />This will always be (bool) true or false. True if a Member is currently logged in with an Access Level >= 1.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-is-logged-in-as-member.php")) . '</p>' . "\n";
		echo '<p><em>See <code>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</code> below for a full explanation.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</strong><br />This will always be (int) -1 thru 4. -1 if not logged in. 0 if logged in as a Free Subscriber.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-access-level.php")) . '</p>' . "\n";
		echo '<p><strong>Membership Levels provide incremental access:</strong></p>' . "\n";
		echo '<p>* A Member with Level 4 access, will also be able to access Levels 0, 1, 2 &amp; 3.<br />* A Member with Level 3 access, will also be able to access Levels 0, 1 &amp; 2.<br />* A Member with Level 2 access, will also be able to access Levels 0 &amp; 1.<br />* A Member with Level 1 access, will also be able to access Level 0.<br />* A Subscriber with Level 0 access, will ONLY be able to access Level 0.</p>' . "\n";
		echo '<p><em>* WordPress® Subscribers are at Membership Level 0. If you\'re allowing Open Registration, Subscribers will be at Level 0 ( a Free Subscriber ). WordPress® Administrators, Editors, Authors, and Contributors have Level 4 access, with respect to s2Member. All of their other Roles/Capabilities are left untouched.</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_ACCESS_LABEL</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-access-label.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_SUBSCR_ID</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-subscr-id.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_CUSTOM</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-custom.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_REGISTRATION_TIME</strong><br />This will always be an (int); in the form of a Unix timestamp. 0 if not logged in. This holds the recorded time at which the User originally registered their Username for access to your site; for free or otherwise. This is useful if you want to drip content over an extended period of time, based on how long someone has been registered (period); regardless of whether they are/were paying you. <strong>* Note:</strong> this is NOT the same as <code>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME</code>, which could be used as an alternative, depending on your intended usage.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-registration-time.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_REGISTRATION_DAYS</strong><br />This will always be an (int). 0 if not logged in. This is the number of days that have passed since the User originally registered their Username for access to your site; for free or otherwise. This is useful if you want to drip content over an extended period of time, based on how long someone has been registered (period); regardless of whether they are/were paying you. <strong>* Note:</strong> this is NOT the same as <code>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS</code>, which could be used as an alternative, depending on your intended usage.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-registration-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_TIME</strong><br />This will always be an (int); in the form of a Unix timestamp. However, this will be 0 if they\'re not logged in; or if they\'ve never paid you at all <em>( e.g. if they\'re still a Free Subscriber )</em>. This holds the recorded time at which the Member originally registered their Username (or upgraded for) any type of "paid" access to your site. This value is preserved for the lifetime of their account, even if they upgrade, and even if they\'re demoted at some point. Once this value is recorded, it never changes under any circumstance. This is useful if you want to drip content over an extended period of time, based on how long someone has been a "paying" Member (period); regardless of their original or existing Membership Level. <strong>* Note:</strong> this is NOT the same as <code>S2MEMBER_CURRENT_USER_REGISTRATION_TIME</code>, which could be used as an alternative, depending on your intended usage.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-paid-registration-time.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_PAID_REGISTRATION_DAYS</strong><br />This will always be an (int); in the form of a Unix timestamp. However, this will be 0 if they\'re not logged in; or if they\'ve never paid you at all <em>( e.g. if they\'re still a Free Subscriber )</em>. This is the number of days that have passed since the Member originally registered their Username (or upgraded for) any type of "paid" access to your site. The underlying timestamp behind this value is preserved for the lifetime of their account, even if they upgrade, and even if they\'re demoted at some point. Once the underlying timestamp behind this value is recorded, it never changes under any circumstance. This is useful if you want to drip content over an extended period of time, based on how long someone has been a "paying" Member (period); regardless of their original or existing Membership Level. <strong>* Note:</strong> this is NOT the same as <code>S2MEMBER_CURRENT_USER_REGISTRATION_DAYS</code>, which could be used as an alternative, depending on your intended usage.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-paid-registration-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_DISPLAY_NAME</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-display-name.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_FIRST_NAME</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-first-name.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_LAST_NAME</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-last-name.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_LOGIN</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-login.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_EMAIL</strong><br />This will always be a (string). Empty if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-email.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_IP</strong><br />This will always be a (string). Empty if browsing anonymously.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-ip.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_ID</strong><br />This will always be an (int). However, it will be 0 if not logged in.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-id.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_FIELDS</strong><br />This will always be a JSON encoded array, in (string) format. An empty JSON encoded array, in (string) format, if not logged in. This JSON encoded array will contain the following fields: <code>id, ip, email, login, first_name, last_name, display_name, subscr_id, custom</code>. If you\'ve configured additional Custom Fields, those Custom Fields will also be added to this array. For example, if you configured the Custom Field: <code>Street Address</code>, it would be included in this array as: <code>street_address</code>. Custom Field references are converted to lowercase format, and spaces are replaced by underscores. You can do <code>print_r(json_decode(S2MEMBER_CURRENT_USER_FIELDS, true));</code> to get a full list for testing.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-fields.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED</strong><br />This will always be an (int) value >= 0 where 0 means no access.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-allowed.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED</strong><br />This will always be (bool) true or false. A value of true means their allowed downloads are >= 999999999, and false means it is not. This is useful if you are allowing unlimited ( 999999999 ) downloads on some membership levels. You can display `Unlimited` instead of a number.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-allowed-is-unlimited.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY</strong><br />This will always be an (int) value >= 0 where 0 means none.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-currently.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS</strong><br />This will always be an (int) value >= 0 where 0 means no access.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-downloads-allowed-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_PROFILE_MODIFICATION_PAGE_URL</strong><br />This is where a Member can modify their Profile.</p>' . "\n";
		echo '<p><strong>Code Sample #1</strong> ( standard link ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-1.php")) . '</p>' . "\n";
		echo '<p><strong>Code Sample #2</strong> ( open the link in a popup window ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-2.php")) . '</p>' . "\n";
		echo '<p><strong>Code Sample #3</strong> ( embed the form into a Post/Page using an IFRAME tag ):</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-profile-modification-page-url-3.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_URL</strong><br />This is the full URL to the Limit Exceeded Page ( informational ).</p>' . "\n";
		echo '<p><strong>S2MEMBER_FILE_DOWNLOAD_LIMIT_EXCEEDED_PAGE_ID</strong><br />This is the Page ID that was used to generate the full URL.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/file-download-limit-exceeded-page-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_URL</strong><br />This is the full URL to the Membership Options Page ( the signup page ).</p>' . "\n";
		echo '<p><strong>S2MEMBER_MEMBERSHIP_OPTIONS_PAGE_ID</strong><br />This is the Page ID that was used to generate the full URL.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/membership-options-page-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LOGIN_WELCOME_PAGE_URL</strong><br />This is the full URL to the Login Welcome Page ( the User\'s account page ). * This could also be the full URL to a Special Redirection URL ( if you configured one ). See <code>s2Member -> General Options -> Login Welcome Page</code>.</p>' . "\n";
		echo '<p><strong>S2MEMBER_LOGIN_WELCOME_PAGE_ID</strong><br />This is the Page ID that was used to generate the full URL. * In the case of a Special Redirection URL, this ID is not really applicable.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/login-welcome-page-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LOGIN_PAGE_URL</strong><br />This is the full URL to the Membership Login Page ( the WordPress® login page ).</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/login-page-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LOGOUT_PAGE_URL</strong><br />This is the full URL to the Membership Logout Page ( the WordPress® logout page ).</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/logout-page-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL0_LABEL</strong><br />This is the (string) Label that you created for Membership Level 0.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level0-label.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL1_LABEL</strong><br />This is the (string) Label that you created for Membership Level 1.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level1-label.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL2_LABEL</strong><br />This is the (string) Label that you created for Membership Level 2.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level2-label.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL3_LABEL</strong><br />This is the (string) Label that you created for Membership Level 3.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level3-label.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL4_LABEL</strong><br />This is the (string) Label that you created for Membership Level 4.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level4-label.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 0.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level0-file-downloads-allowed.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 1.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level1-file-downloads-allowed.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 2.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level2-file-downloads-allowed.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 3.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level3-file-downloads-allowed.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED</strong><br />This is the (int) allowed downloads for Level 4.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level4-file-downloads-allowed.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL0_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 0.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level0-file-downloads-allowed-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL1_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 1.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level1-file-downloads-allowed-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL2_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 2.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level2-file-downloads-allowed-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL3_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 3.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level3-file-downloads-allowed-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_LEVEL4_FILE_DOWNLOADS_ALLOWED_DAYS</strong><br />This is the (int) allowed download days for Level 4.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/level4-file-downloads-allowed-days.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_FILE_DOWNLOAD_INLINE_EXTENSIONS</strong><br />This is the (string) list of extensions to display inline.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/file-download-inline-extensions.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_REG_EMAIL_FROM_NAME</strong><br />This is the Name that outgoing email messages are sent by.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/reg-email-from-name.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_REG_EMAIL_FROM_EMAIL</strong><br />This is the Email Address that outgoing messages are sent by.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/reg-email-from-email.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_PAYPAL_NOTIFY_URL</strong><br />This is the URL on your system that receives PayPal® IPN responses.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-notify-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_PAYPAL_RETURN_URL</strong><br />This is the URL on your system that receives PayPal® return variables.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-return-url.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_PAYPAL_ENDPOINT</strong><br />This is the Endpoint Domain to the PayPal® server.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-endpoint.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_PAYPAL_BUSINESS</strong><br />This is the Email Address that identifies your PayPal® Business.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-business.php")) . '</p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		echo '<p><strong>S2MEMBER_PAYPAL_PDT_IDENTITY_TOKEN</strong><br />This is the PDT Identity Token associated with your PayPal® Business.</p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/paypal-pdt-identity-token.php")) . '</p>' . "\n";
		echo '<p><em>* For security purposes, this is NOT included in the JS/API (JavaSript API).</em></p>' . "\n";
		/**/
		echo '<div class="ws-menu-page-hr"></div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_list_of_api_constants", get_defined_vars ());
		/**/
		echo '<p><strong>S2MEMBER_CURRENT_USER_VALUE_FOR_PP_ON0</strong><br />This auto-fills the <code>on0</code> value in PayPal® Button Codes.<br />If a Button Code is presented to a logged-in Member, this will auto-fill the value for the <code>on0</code> input variable, with the string: <code>"Updating Subscr. ID"</code>. Otherwise, it will be an empty string.</p>' . "\n";
		echo '<p><strong>S2MEMBER_CURRENT_USER_VALUE_FOR_PP_OS0</strong><br />This auto-fills the <code>os0</code> value in PayPal® Button Codes.<br />If a Button Code is presented to a logged-in Member, this will auto-fill the value for the <code>os0</code> input variable, with the value of <code>S2MEMBER_CURRENT_USER_SUBSCR_ID</code>. Otherwise, it will be an empty string.</p>' . "\n";
		echo '<p>These two Constants are special. They are used by the PayPal® Button Generator for s2Member. This is how s2Member identifies an existing Member ( and/or a Free Subscriber ), who is already logged in when they click a PayPal® Modification Button that was generated for you by s2Member. Instead of forcing a Member ( and/or a Free Subscriber ) to re-register for a new account, s2Member can identify their existing account, and update it, according to the modified terms in your Button Code. These three Button Code parameters: <code>on0, os0, modify</code>, work together in harmony. If you\'re using the Shortcode Format for PayPal® Buttons ( recommended ), you won\'t even see these, because they\'re added internally by the Shortcode processor. Anyway, they\'re just documented here for clarity; you probably won\'t use these directly; the Button Code Generator pops them in.</p>' . "\n";
		echo '<p><em>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-value-for-pp-on0-os0.php")) . '</em></p>' . "\n";
		echo '<p>If you\'d like to give your Members ( and/or your Free Subscribers ) the ability to modify their billing plan, by switching to a more expensive option, or a less expensive option; generate a new PayPal® Modification Button, using the s2Member PayPal® Button Generator. Configure the updated Level, pricing, terms, etc. Then, make that new Modification Button available to Members who are logged into their existing account with you. For example, you might want to insert a "Level #2" Upgrade Button into your Login Welcome Page, which would up-sell existing Level #1 Members to a more expensive plan that you offer.</p>' . "\n";
		echo '<p><em><strong>*Modification Process*</strong> When you send a Member to PayPal® using a Subscription Modification Button, PayPal® will ask them to login. Once they\'re logged in, instead of being able to signup for a new membership, PayPal® will provide them with the ability to upgrade and/or downgrade their existing membership with you, by allowing them to switch to the Membership Plan that was specified in the Subscription Modification Button. PayPal® handles this nicely, and you\'ll be happy to know that s2Member has been pre-configured to deal with this scenario as well, so that everything remains automated. Their Membership Access Level will either be promoted, or demoted, based on the actions they took at PayPal® during the modification process. Once an existing Member completes their Subscription Modification at PayPal®, they\'ll be brought back to their Login Welcome Page, instead of the registration screen.</em></p>' . "\n";
		echo '<p><em><strong>*Also Works For Free Subscribers*</strong> Although a Free Subscriber does not have an existing PayPal® Subscription, s2Member is capable of adapting to this scenario gracefully. Just make sure that your existing Free Subscribers ( the ones who wish to upgrade ) pay for their Membership through a Modification Button generated by s2Member. That will allow them to continue using their existing account with you. In other words, they can keep their existing Username ( and anything already associated with that Username ), rather than being forced to re-register after checkout.</em></p>' . "\n";
		echo '<p><em><strong>*Make It More User-Friendly*</strong> You can make the Subscription Modification Process, more user-friendly, by setting up a <a href="#" onclick="alert(\'Optional. This can be configured inside your PayPal® account. PayPal® allows you to create Custom Page Styles, and assign a unique name to them. You can add your own header image and color selection to the checkout form. Once you\\\'ve created a Custom Page Style at PayPal®, you can tell s2Member to use that Page Style whenever you generate your Button Code. See: s2Member® -> PayPal Buttons.\'); return false;">Custom Page Style at PayPal®</a>, specifically for Subscription Modification Buttons. Use a custom header image, with a brief explanation to the Customer. Something like, "Log into PayPal®", "You can Modify your Subscription!".</em></p>' . "\n";
		echo '<p><em><strong>*Conditional Upgrades*</strong> You could also use the API Constant <code>S2MEMBER_CURRENT_USER_ACCESS_LEVEL</code> to build Conditionals that display a specific Modification Button, based on the Membership Level of the currently logged-in Member. This can help you maximize your marketing efforts. In other words, instead of just throwing a single Modification Button out there to everyone, get specific if you need to!</em></p>' . "\n";
		echo '<p>' . ws_plugin__s2member_highlight_php (file_get_contents (dirname (__FILE__) . "/code-samples/current-user-access-level-conditional-upgrades.php")) . '</p>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_constants", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_js_globals", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_js_globals", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="s2Member JS/API Globals">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-js-globals-section">' . "\n";
		echo '<h3>You Also Have Access To JS Globals ( some JavaScript knowledge required )</h3>' . "\n";
		echo '<p>Unless noted otherwise, all of the PHP Constants, are also available through JavaScript, as Global Variables ( with the exact same names/types as their PHP counterparts ). s2Member automatically loads it\'s compressed JavaScript API ( only 2kbs ) into your theme for WordPress®. s2Member is very intelligent about the way it loads ( and maintains ) it\'s JavaScript API. You can rely on the JavaScript Globals, the same way you rely on PHP Constants. The only exceptions are related to security. Variables that include private server-side details, like Identity Tokens and other API service credentials, will be excluded automatically.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_js_globals", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_js_globals", get_defined_vars ());
	}
/**/
if (apply_filters ("ws_plugin__s2member_during_scripting_page_during_left_sections_display_api_hooks", true, get_defined_vars ()))
	{
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_before_api_hooks", get_defined_vars ());
		/**/
		echo '<div class="ws-menu-page-group" title="s2Member API / WP® Hooks &amp; Filters">' . "\n";
		/**/
		echo '<div class="ws-menu-page-section ws-plugin--s2member-api-hooks-section">' . "\n";
		echo '<h3>WP® Hooks For Theme/Plugin Developers ( scripting required )</h3>' . "\n";
		echo '<p>In addition to its API Constants, s2Member also makes several Hooks/Filters available throughout its framework. This makes it possible to build onto ( or even modify ) s2Member in lots of different ways. If you need to add custom processing routines, modify the behavior of existing processing routines, or tinker with things otherwise; you should use API Hooks/Filters. API Hooks &amp; Filters, give you the ability to "hook into", and/or "filter" processing routines, with files/functions of your own; instead of editing the s2Member plugin files directly. If you don\'t use a Hook/Filter, and instead, you edit the plugin files for s2Member, you\'ll have to merge all of your changes every time a new version of s2Member is released. If you create custom processing routines, you could place those routines into a PHP file here: <code>/wp-content/mu-plugins/my-s2member-hacks.php</code>. If you don\'t have an /mu-plugins/ directory, please create one. These are (mu) MUST USE plugins, which are loaded into WordPress® automatically; that\'s what you want!</p>' . "\n";
		echo '<p>Un-documented. There are simply too many Hooks/Filters spread throughout s2Member\'s framework. Rather than documenting each Hook/Filter, it is easier to browse through the files inside: <code>/s2member/includes/functions/</code>. Inspecting Hooks/Filters in this way, also leads you to a better understanding of how they work. One way to save time, is to run a search for <code>do_action</code> and/or <code>apply_filters</code>.</p>' . "\n";
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_during_api_hooks", get_defined_vars ());
		echo '</div>' . "\n";
		/**/
		echo '</div>' . "\n";
		/**/
		do_action ("ws_plugin__s2member_during_scripting_page_during_left_sections_after_api_hooks", get_defined_vars ());
	}
/**/
do_action ("ws_plugin__s2member_during_scripting_page_after_left_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '<td class="ws-menu-page-table-r">' . "\n";
/**/
do_action ("ws_plugin__s2member_during_scripting_page_before_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
/**/
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"]) ? '<div class="ws-menu-page-others"><a href="' . ws_plugin__s2member_parse_readme_value ("Pro Module / Prices") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-upsell-pro.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"]) ? '<div class="ws-menu-page-installation"><a href="' . ws_plugin__s2member_parse_readme_value ("Professional Installation URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-installation.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"]) ? '<div class="ws-menu-page-tools"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-tools.png" alt="." /></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"]) ? '<div class="ws-menu-page-support"><a href="' . ws_plugin__s2member_parse_readme_value ("Forum URI") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-support.png" alt="." /></a></div>' . "\n" : '';
echo ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"]) ? '<div class="ws-menu-page-donations"><a href="' . ws_plugin__s2member_parse_readme_value ("Donate link") . '" target="_blank"><img src="' . $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"] . '/images/brand-donations.jpg" alt="." /></a></div>' . "\n" : '';
/**/
do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
do_action ("ws_plugin__s2member_during_scripting_page_after_right_sections", get_defined_vars ());
/**/
echo '</td>' . "\n";
/**/
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";
/**/
echo '</div>' . "\n";
?>