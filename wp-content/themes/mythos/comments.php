<?php
/**
* The template for displaying comments
*/

/*
* If the current post is protected by a password and
* the visitor has not yet entered the password we will
* return early without loading the comments.
*/

if ( post_password_required() ) {
    return;
}

$discussion = mythos_get_discussion_data(); ?>

<div id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">
    <div class="<?php echo $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses'; ?>">
        <h2 class="comments-title">
        <?php
        if ( comments_open() ) {
            if ( have_comments() ) {
                esc_html_e( 'Comment List', 'mythos' );
            } else {
                esc_html_e( 'Leave a comment', 'mythos' );
            }
        } else {
            if ( '1' == $discussion->responses ) {
                /* translators: %s: post title */
                printf( esc_html( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'mythos' ), esc_html(get_the_title()) );
            } else {
                printf(
                    /* translators: 1: number of comments, 2: post title */
                    esc_html(
                        '%1$s reply on &ldquo;%2$s&rdquo;',
                        '%1$s replies on &ldquo;%2$s&rdquo;',
                        $discussion->responses,
                        'comments title',
                        'mythos'
                    ),
                    esc_html(number_format_i18n( $discussion->responses )),
                    esc_html(get_the_title())
                );
            }
        }
        ?>
        </h2><!-- .comments-title -->
        <?php
            // Only show discussion meta information when comments are open and available.
        if ( have_comments() && comments_open() ) {
            get_template_part( 'template-parts/post/discussion', 'meta' );
        }
        ?>
    </div><!-- .comments-title-flex -->
    <?php
    if ( have_comments() ) :

        // Show comment form at top if showing newest comments at the top.
        if ( comments_open() ) {
            mythos_comment_form( 'desc' );
        }

        ?>
        <ul class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'walker'      => new Gutenwp_Comment(),
                    'avatar_size' => mythos_get_avatar_size(),
                    'short_ping'  => true,
                    'style'       => 'ol',
                )
            );
            ?>
        </ul><!-- .comment-list -->
        <?php

        // Show comment navigation
        if ( have_comments() ) :
            $comments_text = __( 'Comments', 'mythos' );
            the_comments_navigation(
                array(
                    'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', '<i class="fa fa-arrow-left"></i>', __( 'Previous', 'mythos' ), __( 'Comments', 'mythos' ) ),
                    'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', 'mythos' ), __( 'Comments', 'mythos' ), '<i class="fa fa-arrow-right"></i>' ),
                )
            );
        endif;

        // Show comment form at bottom if showing newest comments at the bottom.
        if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
            ?>
            <div class="comment-form-flex">
                <span class="screen-reader-text"><?php esc_html_e( 'Leave a comment', 'mythos' ); ?></span>
                <?php mythos_comment_form( 'asc' ); ?>
            </div>
                
            <?php
        endif;

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() ) :
            ?>
            <p class="no-comments">
                <?php esc_html_e( 'Comments are closed.', 'mythos' ); ?>
            </p>
            <?php
        endif;

    else :

        // Show comment form.
        mythos_comment_form( true );

    endif; // if have_comments();
    ?>
</div><!-- #comments -->
