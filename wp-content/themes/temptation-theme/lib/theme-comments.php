<?php
function celta_format_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment, $size='60' ); ?>
			<div class="comment-text">
				<cite><?php comment_author_link(); ?></cite>
				<br />
				<small><?php comment_date( 'F d, Y - G:i ' ); ?></small>
				<?php if ($comment->comment_approved == '0') : ?>
					<p><em><?php _e( 'Your comment is awaiting moderation.', LANGUAGE ); ?></em></p>
				<?php endif; ?>
				<?php comment_text() ?>
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
			</div>
			<div class="clear"></div>
		</div>
<?php } ?>