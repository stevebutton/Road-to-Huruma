	<ul id="sidebar">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
<?php if (false) : /* default sidebar contents are off now. */ ?>

		<li class="widget">
			<ul>
				<?php wp_list_categories('show_count=1&hierarchical=0&title_li='); ?>
			</ul>
		</li>
		<li class="widget">
			<?php get_search_form(); ?>
		</li>

<?php endif; ?>
<?php endif; ?>

	</ul><!-- /sidebar -->
