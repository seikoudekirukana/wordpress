<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<?php the_comments_navigation(); ?>

		<div class="hwp_comment_list comment-list media-list">
			<?php
				wp_list_comments( array(
					'style'       => 'li',
					'short_ping'  => true,
					'avatar_size' => 42,
                    'callback'      => 'hwp_comment'
				) );
			?>
		</div><!-- .comment-list -->

		<?php //the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'hwp' ); ?></p>
	<?php endif; ?>

</div><!-- .comments-area -->
