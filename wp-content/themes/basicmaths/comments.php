			<div id="comments">
<?php
	$req = get_option('require_name_email'); // Checks if fields are required.
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( ! empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
?>
				<div class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'basicmaths') ?></div>
			</div><!-- .comments -->
<?php
		return;
	endif;
endif;
?>

<?php if ( have_comments() ) : ?>

<?php /* numbers of pings and comments */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>

<?php if ( ! empty($comments_by_type['comment']) ) : ?>

				<div id="comments-list" class="comments">
<?php if ( ('open' == $post->comment_status) ) : // Comments and trackbacks open ?>
					<h3><?php _e( 'Comments', 'basicmaths' ) ?></h3> <span class="comment-list-meta"><?php printf($comment_count > 1 ? __('<span>%d</span> Comments so far', 'basicmaths') : __('<span>One</span> Comment so far', 'basicmaths'), $comment_count) ?>.</span> <span class="add-comment"><a href="#respond"><?php _e( 'Leave a comment below.', 'basicmaths' ) ?></a></span>
<?php elseif ( !('open' == $post->comment_status) ) : // Comments and trackbacks closed ?>
					<h3><?php _e( 'Comments', 'basicmaths' ) ?></h3> <span class="comment-list-meta"><?php printf($comment_count > 1 ? __('<span>%d</span> Comments so far', 'basicmaths') : __('<span>One</span> Comment so far', 'basicmaths'), $comment_count) ?>.</span> <span class="add-comment"><?php _e( 'Comments are closed.', 'basicmaths' ) ?></span>
<?php endif; ?>
				
					<ol>
<?php wp_list_comments('avatar_size=48&type=comment&callback=basic_comments'); ?>
					</ol>

        			<div id="comments-nav-below" class="comment-navigation">
        			     <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
                    </div>
					
				</div><!-- #comments-list .comments -->

<?php endif; ?>

<?php if ( ! empty($comments_by_type['pings']) ) : ?>

				<div id="trackbacks-list" class="comments">
<?php if ( ('open' == $post->ping_status) ) : // Trackbacks open ?>
					<h3><?php _e( 'Trackbacks', 'basicmaths' ) ?></h3> <span class="comment-list-meta"><?php printf($ping_count > 1 ? __('<span>%d</span> pings so far.', 'basicmaths') : __('<span>One</span> Trackback', 'basicmaths'), $ping_count) ?></span>
<?php elseif ( !('open' == $post->ping_status) ) : // Trackbacks closed ?>
					<h3><?php _e( 'Trackbacks', 'basicmaths' ) ?></h3> <span class="comment-list-meta"><?php printf($ping_count > 1 ? __('<span>%d</span> pings so far.', 'basicmaths') : __('<span>One</span> Trackback', 'basicmaths'), $ping_count) ?></span> <span class="add-comment"><?php _e( 'Trackbacks are closed.', 'basicmaths' ) ?></span>
<?php endif; ?>
					
					<ol>
<?php wp_list_comments('type=pings&callback=basic_pings'); ?>
					</ol>				
					
				</div><!-- #trackbacks-list .comments -->			

<?php endif ?>
<?php endif ?>

<?php if ( 'open' == $post->comment_status ) : ?>
				<div id="respond">
    				<h3><?php comment_form_title( __('Add Your Comments', 'basicmaths'), __('Post a Reply to %s', 'basicmaths') ); ?></h3>
    				
    				<div id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'basicmaths'),
					get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>
					<div class="formcontainer">	

						<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

<?php if ( $user_ID ) : ?>
							<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'basicmaths'),
								get_option('siteurl') . '/wp-admin/profile.php',
								wp_specialchars($user_identity, true),
								wp_logout_url(get_permalink()) ) ?></p>

<?php else : ?>

                            <div id="form-section-author" class="form-section">
    							<div class="form-label"><label for="author"><?php _e('Name', 'basicmaths') ?></label></div>
    							<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /> <?php if ($req) _e('<span class="required">Required</span>', 'basicmaths') ?></div>
                            </div><!-- #form-section-author .form-section -->

                            <div id="form-section-email" class="form-section">
    							<div class="form-label"><label for="email"><?php _e('Email', 'basicmaths') ?></label></div>
    							<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /> <?php if ($req) _e('<span class="required">Required</span>', 'basicmaths') ?></div>
                            </div><!-- #form-section-email .form-section -->

                            <div id="form-section-url" class="form-section">
    							<div class="form-label"><label for="url"><?php _e('Website', 'basicmaths') ?></label></div>
    							<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>
                            </div><!-- #form-section-url .form-section -->

<?php endif ?>

                            <div id="form-section-comment" class="form-section">
    							<div class="form-label"><label for="comment"><?php _e('Comment', 'basicmaths') ?></label></div>
    							<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>
                            </div><!-- #form-section-comment .form-section -->
                            
                            <div id="form-allowed-tags" class="form-section">
    							<div class="form-label"><?php _e('Tips', 'basicmaths') ?></div>
                                <div class="form-textarea">
                                	<p id="comment-notes"><span><?php _e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: ', 'basicmaths') ?></span><strong><?php echo allowed_tags(); ?></strong></p>
									<p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'basicmaths') ?></p>
								</div>
                            </div>
							
                  <?php do_action('comment_form', $post->ID); ?>
                  
							<div class="form-submit">
								<div class="form-label"><?php _e('Ready?', 'basicmaths') ?></div>
								<input id="submit" name="submit" type="submit" value="<?php _e('Submit', 'basicmaths') ?>" tabindex="7" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
							</div>

                            <?php comment_id_fields(); ?>    

						</form><!-- #commentform -->

					</div><!-- .formcontainer -->
<?php endif ?>

				</div><!-- #respond -->
<?php endif ?>

			</div><!-- #comments -->