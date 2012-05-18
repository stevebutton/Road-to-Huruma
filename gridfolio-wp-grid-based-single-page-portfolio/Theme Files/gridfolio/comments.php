<!-- Source: comments.php -->
<?php
/**
 * The template for displaying Comments.
*/
?>

<?php if ( post_password_required() ) : ?>
				<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'cudazi' ); ?></p>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<h3 id="comments-title"><?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'cudazi' ),
			number_format_i18n( get_comments_number() ), '' . get_the_title() . '' );
			?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation clearfix">
	<div class="nav-previous left"><?php previous_comments_link( __( '&lt;&nbsp;&nbsp;Older Comments', 'cudazi' ) ); ?></div>
	<div class="nav-next right"><?php next_comments_link( __( 'Newer Comments&nbsp;&nbsp;&gt;', 'cudazi' ) ); ?></div>
</div>
<?php endif; // check for comment navigation ?>

	<ol>
		<?php
			/* Loop through and list the comments, see cudazi_comment() for formatting options. */
			wp_list_comments( array( 'callback' => 'cudazi_comment' ) );
		?>
	</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation clearfix">
	<div class="nav-previous left"><?php previous_comments_link( __( '&lt;&nbsp;&nbsp;Older Comments', 'cudazi' ) ); ?></div>
	<div class="nav-next right"><?php next_comments_link( __( 'Newer Comments&nbsp;&nbsp;&gt;', 'cudazi' ) ); ?></div>
</div>
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<!--<p><?php _e( 'Comments are closed.', 'cudazi' ); ?></p>-->
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>