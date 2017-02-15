<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 7/15/15
 * Time: 11:27 PM
 */
?>

<div id="comment-<?php comment_ID(); ?>" <?php comment_class(['media','blog-reply']) ?>>
    <div class="pull-left">
        <a href="#" onclick="return false">
            <?php echo get_avatar($comment,74,'','',array('class'=>'media-object')) ?>
        </a>
    </div>
    <div class="media-body">
        <h4> <?php printf(  '%s', sprintf( '%s', get_comment_author_link() ) ); ?></h4>
        <div class="comment-body"><?php comment_text($comment); ?></div>
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
</div>