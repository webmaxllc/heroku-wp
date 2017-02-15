<?php
	/**
	 * The template for displaying comments
	 *
	 * The area of the page that contains both current comments
	 * and the comment form.
	 *
	 * @package WordPress
	 * @subpackage Twenty_Fifteen
	 * @since Twenty Fifteen 1.0
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
	<div class="post-comment">
		<?php if ( have_comments() ) : ?>
			<div class="sect-header">
				<h3>
					<?php comments_number( esc_html__( 'No comment', "bizone" ),
						esc_html__( 'Comment: 1', "bizone" ), esc_html__( 'Comments : %', "bizone" ) ) ?>

				</h3>
			</div>


			<?php bravo_comment_nav(); ?>


			<?php
			wp_list_comments( array(
				'short_ping'  => true,
				'avatar_size' => 127,
				'callback'    => 'bravo_comment_list'
			) );
			?>

			<?php bravo_comment_nav(); ?>

		<?php endif; // have_comments() ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
				?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', "bizone" ); ?></p>
			<?php endif; ?>
		<div class="comment-form">

			<?php
				$comment_field = '';
				if ( is_user_logged_in() ) {
					$comment_field = '
										<textarea id="comment" name="comment" class="form-control" rows="8" placeholder="' . esc_html__( 'Comment', "bizone" ) . '"></textarea>
									';
				} ?>
			<?php
			$commenter=wp_parse_args($commenter,array(
				'comment_author_email'=>'',
				'comment_author_website'=>'',
				'comment_author'=>''
			));
				$comment_form = array(
					'fields'         => array(

						'author'  => '<div class="row">
												<div class="col-md-4 col-sm-12">
													<input id="author"  name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true"  class="form-control" placeholder="' . esc_html__( 'Your Name', "bizone" ) . '" />	
							                    </div>',

						'url'    => '<div class="col-md-4 col-sm-12"> 
											<input id="url" class="form-control" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" placeholder="' . esc_html__( 'Website', "bizone" ) . '" />
									</div>',


						'email'   => '<div class="col-md-4 col-sm-12 ">
										<input  placeholder="' . esc_html__( 'Email', "bizone" ) . '"  class="form-control" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" />
							          </div>',


						'message' => '<div class="col-sm-12">
                                          <textarea class="form-control" id="comment" name="comment" cols="40" rows="5" placeholder="' . esc_html__( 'Type your message...', "bizone" ) . '"></textarea>	
                                        </div>
                                     </div>',
					),
					'comment_field'  => $comment_field,
					'class_submit'   => 'submit-small',
					'title_reply'    => '<div class="sect-header"><h3>'.esc_html__( 'Leave a comment', "bizone" ).'</h3></div>',
					'title_reply_to' => esc_html__( 'Leave a COMMENT to %s', "bizone" ),
					'label_submit' => esc_html__( 'SEND COMMENT', "bizone" ),
				);

				comment_form( $comment_form ); ?>
		</div>

	</div>
