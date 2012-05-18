<?php
/*
Template Name: Archives Page
*/
?>
<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>
<?php get_header(); ?>


	<div id="container">

<?php if($bm_cats_or_tags == 'true') { ?>
		<div id="allcategories" class="toptaxonomy">
			<h3><?php _e( 'All Categories', 'basicmaths' ) ?><br /><span class="count"><?php all_categories_count() ?><?php _e(' total', 'basicmaths') ?></span></h3>
			<ul>
				<?php all_basic_categories(); ?>
			</ul>
		</div>
		<div id="alltags" class="bottomtaxonomy">
			<h3><?php _e( 'All Tags', 'basicmaths' ) ?><br /><span class="count"><?php all_tags_count() ?><?php _e(' total', 'basicmaths') ?></span></h3>
			<ul>
				<?php all_basic_tags(); ?>

			</ul>
		</div>
<?php } else { ?>
		<div id="alltags" class="toptaxonomy">
			<h3><?php _e( 'All Tags', 'basicmaths' ) ?><br /><span class="count"><?php all_tags_count() ?><?php _e(' total', 'basicmaths') ?></span></h3>
			<ul>
				<?php all_basic_tags(); ?>

			</ul>
		</div>
		<div id="allcategories" class="bottomtaxonomy">
			<h3><?php _e( 'All Categories', 'basicmaths' ) ?><br /><span class="count"><?php all_categories_count() ?><?php _e(' total', 'basicmaths') ?></span></h3>
			<ul>
				<?php all_basic_categories(); ?>
			</ul>
		</div>
<?php } ?>

		<div id="datearchives">

<?php basic_date_archives() ?>

		</div>

	</div><!-- #container -->

<?php get_footer(); ?>