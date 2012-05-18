	<ul id="sidebar2">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>

		<li class="widget">
			<h2 class="widgettitle">Category</h2>
			<ul>
				<?php wp_list_categories('show_count=1&hierarchical=1&title_li='); ?>
			</ul>
		</li>
		<li class="widget">
			<h2 class="widgettitle">Pages</h2>
			<ul>
				<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
			</ul>
		</li>
		<li class="widget">
			<h2 class="widgettitle">Search</h2>
			<?php get_search_form(); ?>
		</li>

<?php endif; ?>

	</ul><!-- /sidebar2 -->
