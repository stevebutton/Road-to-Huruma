<!-- Source: searchform.php -->
<form id="searchform" class="clearfix standardForm" method="get" action="<?php echo home_url( '/' ); ?>">
	<?php
		if(get_search_query())
		{
			$searchquery = get_search_query();
		}else{
			$searchquery = __("Search...","cudazi");
		}
	?>
	<input type="text" class="textbox rounded-small" name="s" id="s" size="10" value="<?php echo $searchquery; ?>" />
    <input id="searchsubmit" class="submit rounded-small" type="submit" value="<?php _e("GO","cudazi"); ?>" />
</form>