<div class="wrap">
	<h2>Snazzy Archives</h2>
				
	<div id="poststuff" style="margin-top:10px;">

	 <div id="sideblock" style="float:right;width:270px;margin-left:10px;"> 
		 <iframe width=270 height=800 frameborder="0" src="http://www.prelovac.com/plugin/news.php?id=4&utm_source=plugin&utm_medium=plugin&utm_campaign=Snazzy%2BArchives"></iframe>
 	</div>

	 <div id="mainblock" style="width:710px">
	 
		<div class="dbx-content">
		 	<form name="SnazzyArchives" action="<?php echo $action_url ?>" method="post">
					<input type="hidden" name="submitted" value="1" /> 
					
					<?php wp_nonce_field('snazzy-nonce'); ?>
					
					<h2>Usage</h2>		
					<p>Create a new page for your snazzy archive, and insert the code [snazzy-archive] in the editor. Load this page and enjoy the view!</p>
					<p>For more customization options please refer to <a href="http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives">Snazzy Archives Home page</a>. </p>
					<br />
					
					<h2>Show</h2>
					<p>You can choose what pages you want to show in the archives.</p>
					<input type="checkbox" name="posts"  <?php echo $posts ?>/><label for="posts"> Show Posts</label>  <br />
					<input type="checkbox" name="pages"  <?php echo $pages ?>/><label for="pages"> Show Pages</label>  <br />
					<br />
					<p>You can exclude categories from showing. Enter category IDs, seperated by comma.
					<input type="text" name="exclude_cat" size="25" value="<?php echo $exclude_cat ?>"/><label for="exclude_cat"> Exclude categories</label><br/>
					<p>
					<?php if ($writeable) : ?>
					Your wp-content folder is writeable by WordPress. You may use the cache.<br /><br />
					<input type="checkbox" name="cache"  <?php echo $cache ?>/><label for="cache"> Use Snazzy Cache</label>  <br />
					<?php else : ?>
					Your wp-content folder is not writeable by WordPress. Caching is not possible.
					<?php endif; ?>
					</p>
					<br />
										
					<input type="checkbox" name="thumb"  <?php echo $thumb ?>/><label for="thumb"> Use thumbnail cache (uncheck if you get blog errors)</label>  <br />
					
					<h2>Layout</h2>
					<p>Snazzy Archives currently supports two layouts, and you can buid your own.</p>
					<input type="text" name="layout" size="15" value="<?php echo $layout ?>"/><label for="layout"> Default layout (1 or 2)</label><br/>
					<br /> 					
					<img src="<?php echo $imgpath ?>/example1.jpg"> <img src="<?php echo $imgpath ?>/example2.jpg">
					<br /s>
					<p>Layout 1 uses less space and is more compact, while layout 2 shows more information.</p>
					
					<h2>Effects</h2>
					<p>Special effects modify the way your archives look. You can either select one of them or use the archives without special effects (this is default, same as setting special fx to 0).</p>
					<input type="text" name="fx" size="15" value="<?php echo $fx ?>"/><label for="width"> Special FX</label><br/>	
					<p>Currently available effects:<br><ul>
						<li>1. <a href="http://www.prelovac.com/vladimir/archive-spec?fx=1">Carousel</a> - Shows the Snazzy Archive using JavaScript carousel (saving space).</li>						
						<li>2. <a href="http://www.prelovac.com/vladimir/archive-spec?fx=2">jQuery space</a> - Uses jQuery to Animate the most popular posts</li>
						<li>3. <a href="http://www.prelovac.com/vladimir/archive-spec?fx=3">Flash space</a> - Uses Flash Animation</li>						
					</ul></p>
					<br /><br />
					
					<h2>Display</h2>			
					<p>These are tweaks to the way Snazzy archives look.</p>
					<input type="checkbox" name="mini"  <?php echo $mini ?> /><label for="mini"> Start in mini mode (collapsed archives)</label>  <br />
					<br><img src="<?php echo $imgpath ?>/example3.jpg"> 
					<p>Mini mode can gain you a lot of space, and the user can expand/shrink archives by clicking on the date headings. This works in full mode too!</p>
					
					<input type="checkbox" name="fold"  <?php echo $fold ?> /><label for="fold"> Display Years in rows</label>  <br />	
					<p>When enabled a new archive year will display below the previous, instead in one big row.</p><br/>
					
					<input type="checkbox" name="reverse_months"  <?php echo $reverse_months ?> /><label for="reverse_months"> Reverse months</label>  <br />
					<p>If enabled, archive months will be displayed in descending order (December through January).</p> <br />
					
					<input type="checkbox" name="showimages"  <?php echo $showimages ?> /><label for="showimages"> Show Images</label>  <br />
					<p>Show post images. You can disable this to preserve bandwidth.</p>
                    <p><a href="<?php echo $action_url; ?>&amp;remove_cached_images=1" onclick="return confirm('Do you really want to remove cached images?');">Remove cached images</a></p><br/>
					
					<input type="checkbox" name="corners"  <?php echo $corners ?> /><label for="corners"> Round corners of images</label>  <br />
					<p>This will apply dynamic rounding of image corners for better looking images.</p><br/>	
					

					
					<h2>Year book</h2>	
					<p>You can specify unique text to print with any year, describing it.</p>
					<img src="<?php echo $imgpath ?>/example4.jpg"> <p>Year book shows below the year and is useful for sharing your thoughts.</p>
					<p>Use description in the form year#description, one per line, HTML allowed. For example: <br><br>
					2007#This was a good year! I traveled a lot and met new people.<br>
					2008#Learned a lot about WordPress and I am loving it.<br>
					</p>
					
					<textarea name="years"  rows="10" cols="80"><?php echo $years ?></textarea>				<br/>	<br/>	
					
					<h2>Advanced</h2>	
					<p>You may enter Snazzy Archives Page ID. If you do, Snazzy Archives will load JavaScript files only on this page.</p>
					<input type="text" name="pageid" size="15" value="<?php echo $pageid ?>"/><label for="pageid"> Enter Snazzy Archives Page ID</label><br/>
					<br/>	<br/>	
					
					<div class="submit"><input type="submit" name="Submit" value="Update" /></div>
			</form>
		</div>
		
		<br/><br/><h2>&nbsp;</h2>	
	 </div>

	</div>
	
<h5>Another fine WordPress plugin by <a href="http://www.prelovac.com/vladimir/">Vladimir Prelovac</a></h5>
</div>