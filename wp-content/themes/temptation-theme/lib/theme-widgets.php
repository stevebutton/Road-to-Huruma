<?php

	function celta_load_widgets() {
		unregister_widget('WP_Widget_Recent_Comments');
		
		register_widget( 'Celta_Latest_Posts' );
		register_widget( 'Celta_Flickr' );
		register_widget( 'Celta_Twitter' );
		register_widget( 'Celta_Tags_List' );
		register_widget( 'Celta_Google_Map' );
		register_widget( 'Celta_Contact_Details' );
		register_widget( 'Celta_Ads' );
		register_widget( 'Celta_Widget_Recent_Comments' );
	}
	
	// Latest Posts Widget
	
	class Celta_Latest_Posts extends WP_Widget {
	
		function Celta_Latest_Posts() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'widget-recent-posts', 'description' => 'Custom widget that displays the latest posts using thumbnails.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-recent-posts' );

			/* Create the widget. */
			$this->WP_Widget( 'widget-recent-posts', 'Celta Latest Posts', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$qty = $instance['qty'];
			$exclude = $instance['exclude'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;

			query_posts( array( 'category__not_in' => array( $exclude ), posts_per_page => $qty ) );
			echo '<ul>';
			while ( have_posts() ) : the_post();
				echo '<li>';
				echo '<a href="' . get_permalink() . '" class="img-holder round-3 align-left">';
				$thumb = get_post_thumbnail_id(); $image = celta_resize( $thumb, '', 70, 70, true );
				echo '<img src="'.$image[url].'" width="'.$image[width].'" height="'.$image[height].'" alt="" />';
				echo '</a>';
				echo '<a href="' . get_permalink() . '" title="" class="post-link">' . get_the_title() . '</a>';
				echo '<time datetime="' . get_the_time( 'Y-m-d' ) . '" class="post-created">' . get_the_time( 'F j, Y' ) . '</time>';
				echo '</li>';
			endwhile;
			echo '</ul>';
			wp_reset_query();

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['qty'] = strip_tags( $new_instance['qty'] );
			$instance['exclude'] = $new_instance['exclude'];

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => 'Latest Posts', 'qty' => '3', 'exclude' => '' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'qty' ); ?>">Number of Posts:</label>
				<input id="<?php echo $this->get_field_id( 'qty' ); ?>" name="<?php echo $this->get_field_name( 'qty' ); ?>" value="<?php echo $instance['qty']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'exclude' ); ?>">Exclude Categories:</label>
				<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:100%;" />
			</p>

			
		<?php }
	
	}
	
	// Flickr Widget
	
	class Celta_Flickr extends WP_Widget {
	
		function Celta_Flickr() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'widget-gallery', 'description' => 'Custom widget that displays picture from Flickr.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-gallery' );

			/* Create the widget. */
			$this->WP_Widget( 'widget-gallery', 'Celta Flickr', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$flickrID = $instance['flickrID'];
			$postcount = $instance['postcount'];
			$type = $instance['type'];
			$display = $instance['display'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;

			?>
			
			<div id="flickr_badge_wrapper" class="clearfix">
	
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
				
			</div>
	
			<?php

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
			$instance['postcount'] = $new_instance['postcount'];
			$instance['type'] = $new_instance['type'];
			$instance['display'] = $new_instance['display'];

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array(
				'title' => 'Flickr Pictures',
				'flickrID' => '52617155@N08',
				'postcount' => '6',
				'type' => 'user',
				'display' => 'latest',
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e( 'Flickr ID:' ) ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e( 'Number of Pictures:' ) ?></label>
				<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
					<option <?php if ( '4' == $instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
					<option <?php if ( '8' == $instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
					<option <?php if ( '8' == $instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type (User - Group):' ) ?></label>
				<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
					<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
					<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display (Random - Latest):' ) ?></label>
				<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
					<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
					<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
				</select>
			</p>
			
		<?php }
	
	}
	
	// Twitter Widget
	
	class Celta_Twitter extends WP_Widget {
	
		function Celta_Twitter() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'widget-tweets', 'description' => 'Custom widget that displays your latest tweets.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-tweets' );

			/* Create the widget. */
			$this->WP_Widget( 'widget-tweets', 'Celta Twitter', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$username = $instance['username'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
				
			echo '<div class="twitterUser" style="display:none">' . $username . '</div>';

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = strip_tags( $new_instance['username'] );

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array(
				'title' => 'Latest Tweets',
				'username' => 'celtathemes',
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Twitter Username e.g. celtathemes' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
			</p>
			
		<?php }
	
	}
	
	// Google Map Widget
	
	class Celta_Google_Map extends WP_Widget {
	
		function Celta_Google_Map() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'widget-contacts-location', 'description' => 'Custom widget that displays a Google Map.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-contacts-location' );

			/* Create the widget. */
			$this->WP_Widget( 'widget-contacts-location', 'Celta Google Map', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$src = $instance['src'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
				
			echo '<div class="map-holder round-3">';
			echo '<iframe width="270" height="350" src="' . $src . '"></iframe>';
			echo '</div>';

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['src'] = strip_tags( $new_instance['src'] );

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array(
				'title' => 'Google Map',
				'src' => 'http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Denver,+CO,+United+States&amp;aq=0&amp;sll=37.0625,-95.677068&amp;sspn=40.409448,56.513672&amp;ie=UTF8&amp;hq=&amp;hnear=%D0%94%D0%B5%D0%BD%D0%B2%D0%B5%D1%80,+%D0%9A%D0%BE%D0%BB%D0%BE%D1%80%D0%B0%D0%B4%D0%BE&amp;z=10&amp;ll=39.739154,-104.984703&amp;output=embed',
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Source' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'src' ); ?>" name="<?php echo $this->get_field_name( 'src' ); ?>" value="<?php echo $instance['src']; ?>" />
			</p>
			
		<?php }
	
	}
	
	// Google Map Widget
	
	class Celta_Ads extends WP_Widget {
	
		function Celta_Ads() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'widget-ads', 'description' => 'Custom widget that displays 6 125x125 ads.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-ads' );

			/* Create the widget. */
			$this->WP_Widget( 'widget-ads', 'Celta 125x125 Ads', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$ad_1_link = $instance['ad_1_link'];
			$ad_1_img = $instance['ad_1_img'];
			$ad_2_link = $instance['ad_2_link'];
			$ad_2_img = $instance['ad_2_img'];
			$ad_3_link = $instance['ad_3_link'];
			$ad_3_img = $instance['ad_3_img'];
			$ad_4_link = $instance['ad_4_link'];
			$ad_4_img = $instance['ad_4_img'];
			$ad_5_link = $instance['ad_5_link'];
			$ad_5_img = $instance['ad_5_img'];
			$ad_6_link = $instance['ad_6_link'];
			$ad_6_img = $instance['ad_6_img'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
				
			if ( $ad_1_img != '') {
				echo '<a class="widget-banner banner-125 align-left" href="' . $ad_1_link . '">';
				echo '<img src="' . $ad_1_img . '" alt="' . $ad_1_link . '" />';
				echo '</a>';
			}
			
			if ( $ad_2_img != '') {
				echo '<a class="widget-banner banner-125 align-right" href="' . $ad_2_link . '">';
				echo '<img src="' . $ad_2_img . '" alt="' . $ad_2_link . '" />';
				echo '</a>';
			}
			
			if ( $ad_3_img != '') {
				echo '<a class="widget-banner banner-125 align-left" href="' . $ad_3_link . '">';
				echo '<img src="' . $ad_3_img . '" alt="' . $ad_3_link . '" />';
				echo '</a>';
			}
			
			if ( $ad_4_img != '') {
				echo '<a class="widget-banner banner-125 align-right" href="' . $ad_4_link . '">';
				echo '<img src="' . $ad_4_img . '" alt="' . $ad_4_link . '" />';
				echo '</a>';
			}
			
			if ( $ad_5_img != '') {
				echo '<a class="widget-banner banner-125 align-left" href="' . $ad_5_link . '">';
				echo '<img src="' . $ad_5_img . '" alt="' . $ad_5_link . '" />';
				echo '</a>';
			}
			
			if ( $ad_6_img != '') {
				echo '<a class="widget-banner banner-125 align-right" href="' . $ad_6_link . '">';
				echo '<img src="' . $ad_6_img . '" alt="' . $ad_6_link . '" />';
				echo '</a>';
			}

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['ad_1_img'] = strip_tags( $new_instance['ad_1_img'] );
			$instance['ad_1_link'] = strip_tags( $new_instance['ad_1_link'] );
			$instance['ad_2_img'] = strip_tags( $new_instance['ad_2_img'] );
			$instance['ad_2_link'] = strip_tags( $new_instance['ad_2_link'] );
			$instance['ad_3_img'] = strip_tags( $new_instance['ad_3_img'] );
			$instance['ad_3_link'] = strip_tags( $new_instance['ad_3_link'] );
			$instance['ad_4_img'] = strip_tags( $new_instance['ad_4_img'] );
			$instance['ad_4_link'] = strip_tags( $new_instance['ad_4_link'] );
			$instance['ad_5_img'] = strip_tags( $new_instance['ad_5_img'] );
			$instance['ad_5_link'] = strip_tags( $new_instance['ad_5_link'] );
			$instance['ad_6_img'] = strip_tags( $new_instance['ad_6_img'] );
			$instance['ad_6_link'] = strip_tags( $new_instance['ad_6_link'] );

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array(
				'title' => 'Sponsors',
				'ad_1_img' => 'http://envato.s3.amazonaws.com/referrer_adverts/tf_125x125_v5.gif',
				'ad_1_link' => 'http://google.com'
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_1_img' ); ?>"><?php _e( 'Ad #1 Image URL' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_1_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_1_img' ); ?>" value="<?php echo $instance['ad_1_img']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_1_link' ); ?>"><?php _e( 'Ad #1 Link' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_1_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_1_link' ); ?>" value="<?php echo $instance['ad_1_link']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_2_img' ); ?>"><?php _e( 'Ad #2 Image URL' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_2_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_2_img' ); ?>" value="<?php echo $instance['ad_2_img']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_2_link' ); ?>"><?php _e( 'Ad #2 Link' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_2_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_2_link' ); ?>" value="<?php echo $instance['ad_2_link']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_3_img' ); ?>"><?php _e( 'Ad #3 Image URL' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_3_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_3_img' ); ?>" value="<?php echo $instance['ad_3_img']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_3_link' ); ?>"><?php _e( 'Ad #3 Link' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_3_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_3_link' ); ?>" value="<?php echo $instance['ad_3_link']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_4_img' ); ?>"><?php _e( 'Ad #4 Image URL' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_4_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_4_img' ); ?>" value="<?php echo $instance['ad_4_img']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_4_link' ); ?>"><?php _e( 'Ad #4 Link' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_4_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_4_link' ); ?>" value="<?php echo $instance['ad_4_link']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_5_img' ); ?>"><?php _e( 'Ad #5 Image URL' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_5_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_5_img' ); ?>" value="<?php echo $instance['ad_5_img']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_5_link' ); ?>"><?php _e( 'Ad #5 Link' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_5_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_5_link' ); ?>" value="<?php echo $instance['ad_5_link']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_6_img' ); ?>"><?php _e( 'Ad #6 Image URL' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_6_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_6_img' ); ?>" value="<?php echo $instance['ad_6_img']; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'ad_6_link' ); ?>"><?php _e( 'Ad #6 Link' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_6_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_6_link' ); ?>" value="<?php echo $instance['ad_6_link']; ?>" />
			</p>
			
		<?php }
	
	}
	
	// Tags List Widget
	
	class Celta_Tags_List extends WP_Widget {
	
		function Celta_Tags_List() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'tags', 'description' => 'Custom widget that displays a list of popular tags.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'tags' );

			/* Create the widget. */
			$this->WP_Widget( 'tags', 'Celta Tags List', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$qty = $instance['qty'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
				
			echo '<ul>';
			$tags = get_tags( array( 'orderby' => 'count', 'number' => $qty ) );
			foreach ($tags as $tag){
				$tag_link = get_tag_link($tag->term_id);					
				echo '<li><a href="' . $tag_link . '" title="' . $tag->name . 'Tag">';
				echo $tag->name . '</a></li>';
			}
			echo '</ul>';

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['qty'] = strip_tags( $new_instance['qty'] );

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array(
				'title' => 'Tags List',
				'qty' => '5',
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Quantity' ) ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'qty' ); ?>" name="<?php echo $this->get_field_name( 'qty' ); ?>" value="<?php echo $instance['qty']; ?>" />
			</p>
			
		<?php }
	
	}
	
	// Contact Details Widget
	
	class Celta_Contact_Details extends WP_Widget {
	
		function Celta_Contact_Details() {
		
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'widget-contacts-info', 'description' => 'Custom widget that displays contact details.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-contacts-info' );

			/* Create the widget. */
			$this->WP_Widget( 'widget-contacts-info', 'Celta Contact Details', $widget_ops, $control_ops );
		}
		
		function widget( $args, $instance ) {
		
			extract( $args );

			/* User-selected settings. */
			$title = apply_filters( 'widget_title', $instance['title'] );
			$address = $instance['address'];
			$phone = $instance['phone'];
			$fax = $instance['fax'];
			$email = $instance['email'];

			/* Before widget (defined by themes). */
			echo $before_widget;

			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<ul>';
			
			if ( $address != '' ) { echo '<li class="address">' . $address . '</li>'; }
			if ( $phone != '' ) { echo '<li class="phone"><span>Phone:</span>' . $phone . '</li>'; }
			if ( $fax != '' ) { echo '<li class="fax"><span>Fax:</span>' . $fax . '</li>'; }
			if ( $email != '' ) { echo '<li class="email"><span>Email:</span><a href="mailto:' . $email . '">' . $email . '</a></li>'; }
			
			echo '</ul>';
			wp_reset_query();

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		function update( $new_instance, $old_instance ) {
		
			$instance = $old_instance;

			/* Strip tags (if needed) and update the widget settings. */
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['address'] = strip_tags( $new_instance['address'] );
			$instance['phone'] = strip_tags( $new_instance['phone'] );
			$instance['fax'] = $new_instance['fax'];
			$instance['email'] = $new_instance['email'];

			return $instance;
		}
		
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => 'Contact Details' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', LANGUAGE ); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', LANGUAGE ); ?></label>
				<input id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', LANGUAGE ); ?></label>
				<input id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e( 'Fax:', LANGUAGE ); ?></label>
				<input id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo $instance['fax']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', LANGUAGE ); ?></label>
				<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:100%;" />
			</p>

			
		<?php }
	
	}
	
	/**
 * Recent_Comments widget class
 *
 * @since 2.8.0
 */
class Celta_Widget_Recent_Comments extends WP_Widget {

	function Celta_Widget_Recent_Comments() {
		$widget_ops = array('classname' => 'widget_recent_comments', 'description' => __( 'The most recent comments' ) );
		$this->WP_Widget('recent-comments', __('Recent Comments'), $widget_ops);
		$this->alt_option_name = 'widget_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array(&$this, 'recent_comments_style') );

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

	function recent_comments_style() {
		if ( ! current_theme_supports( 'widgets' ) // Temp hack #14876
			|| ! apply_filters( 'show_recent_comments_widget_style', true, $this->id_base ) )
			return;
		?>
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<?php
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_comments', 'widget');
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('widget_recent_comments', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
 		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title']);

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 5;

		$comments = get_comments( array( 'number' => $number, 'status' => 'approve' ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul id="recentcomments">';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
				$output .=  '<li>' . /* translators: comments widget: 1: comment author, 2: post link */ sprintf(_x('%1$s %2$s', 'widgets'), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a></span>', '<span class="widget-hint">' . get_comment_author_link() . '</span>' ) . '</li>';
			}
 		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_comments', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_comments']) )
			delete_option('widget_recent_comments');

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}
	
?>