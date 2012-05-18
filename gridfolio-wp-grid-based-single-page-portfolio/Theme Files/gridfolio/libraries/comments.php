<?php
	if ( ! function_exists( 'cudazi_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 */
	function cudazi_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 80 ); ?>
				<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'cudazi' ); ?></em>
				<br />
			<?php endif; ?>
			<div class="comment-body"><?php comment_text(); ?></div>
			<div class="reply">
				<div class="comment-toolbox">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					<?php edit_comment_link( __( 'Edit', 'cudazi' ), ' ' ); ?>
				</div>
				<a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php _e( 'Link to this comment', 'cudazi' ); ?>">
					<?php printf( __( 'Posted on %1$s ', 'cudazi' ), get_comment_date() ); ?>
                </a>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->
	
		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'cudazi' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'cudazi'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
	endif;

?>