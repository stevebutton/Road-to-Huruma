<!-- Comments -->
<div class="comments-section">
	<h3><?php _e( 'Comments', LANGUAGE ); ?></h3>

	<?php 
		$num_comments = get_comments_number(); 
		if ($num_comments == 0) {
			echo '<p>';
			_e( 'There are no comments yet.', LANGUAGE );
			echo '</p>';
		} else { ?>
			<ul>
				<?php wp_list_comments( 'type=comment&callback=celta_format_comment' ); ?>
			</ul>
	<?php } ?>
</div>
	
<div class="two-third">
	<?php 
	$commenter = wp_get_current_commenter();
	$args = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' => '<label for="author">' . __( 'Name:' ) . '</label> ' .
					'<input class="textbox" id="author" name="author" type="text" value="' .
					esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1" />',
		'email'  => '<label for="email">' . __( 'Email:' ) . '</label> ' .
					'<input id="email" class="textbox" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2" />',
		'url'    => '<label for="url">' . __( 'Website:' ) . '</label>' .
					'<input id="url" class="textbox" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' ) ),
		'comment_field' =>'<label for="comment">' . __( 'Comment:' ) . '</label><textarea id="comment" class="textbox" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be logged in to post a comment.', LANGUAGE ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%s">%s</a>.</p>', LANGUAGE ), admin_url( 'profile.php' ), $user_identity ),
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'id_form' => 'comments-form',
		'id_submit' => 'post-comment',
		'title_reply' => __( 'Leave a Reply', LANGUAGE ),
		'title_reply_to' => __( 'Leave a Reply to %s', LANGUAGE ),
		'cancel_reply_link' => __( 'Cancel reply', LANGUAGE ),
		'label_submit' => __( 'Post Comment', LANGUAGE ),
	);
	comment_form( $args ); 
	?>
</div>