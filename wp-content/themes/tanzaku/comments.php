<?php
// Do not delete these lines
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
?>
	
<?php if ( post_password_required() ) : ?>

<div class="single-item">
	<div class="comment-content">
		<p><?php _e('Enter your password to view comments.'); ?></p>
	</div>
</div><!-- /single-item -->

<?php return; endif; ?>

<div class="single-item">

	<h2 class="comment-title" id="comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?> 
		<?php if ( comments_open() ) : ?>
			<a href="#respond" title="<?php _e("Leave a comment"); ?>">&raquo;</a>
		<?php endif; ?>
	</h2>
	<div class="comment-list">

	<?php if ( have_comments() ) : ?>

		<div class="navigation">
			<?php previous_comments_link() ?> <?php next_comments_link() ?>
		</div>
		<ol>
			<?php wp_list_comments();?>
		</ol>
		<div class="navigation">
			<?php previous_comments_link() ?> <?php next_comments_link() ?>
		</div>

	<?php endif; ?>

		<p class="comment-meta">
			<?php if ( comments_open() ) : ?>
				<?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?> /
			<?php endif; ?>
			<?php if ( pings_open() ) : ?>
				<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Uniform Resource Identifier">URI</abbr>'); ?></a>
			<?php endif; ?>
		</p>
	</div><!-- /comment-list -->

</div><!-- /single-item -->

<div class="single-item" id="respond">

<?php if ( comments_open() ) : ?>

	<h2 class="comment-title"><?php comment_form_title(); ?></h2>
	<div id="cancel-comment-reply"> 
		<?php cancel_comment_reply_link() ?>
	</div>
	
	<div class="comment-form">

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() )); ?></p>
	<?php else : ?>

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>
			<p>
				<?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?>
				<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a>
			</p>
		<?php else : ?>
			<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			<label for="author"><small><?php _e('Name'); ?> <?php if ($req) _e("(required)"); ?></small></label></p>
			
			<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			<label for="email"><small><?php _e('Mail (will not be published)'); ?> <?php if ($req) _e("(required)"); ?></small></label></p>
			
			<p><input type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
			<label for="url"><small><?php _e('Website'); ?></small></label></p>
		<?php endif; ?>

			<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), allowed_tags()); ?></small></p>-->
			<p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment'); ?>" />
			<?php comment_id_fields(); ?></p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>

		<?php endif; ?>

	</div><!-- /comment-form -->

<?php else : /* Comments are closed */ ?>

	<div class="comment-content">
		<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
	</div>

<?php endif; ?>

</div><!-- /single-item -->
