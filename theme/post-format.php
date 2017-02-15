<?php
$format = get_post_format();
?>
<div class="entry-cover">
    <?php if($format == "image" or $format==''){ ?>
        <?php the_post_thumbnail( 'full', array('class' => 'img-responsive') ); ?>
    <?php } ?>
    <?php if($format == "video"){
                if ( $media_url = get_post_meta( get_the_ID(), 'media_url', true ) ) {
        ?>
        <div class="embed-responsive embed-responsive-16by9">
            <?php echo wp_oembed_get( $media_url ) ?>
        </div>
    <?php }
    }?>
    <?php if($format == "audio"){
        if ( $media_url = get_post_meta( get_the_ID(), 'media_url', true ) ) {
            ?>
            <div class="embed-responsive embed-responsive-16by9">
                <?php echo wp_oembed_get( $media_url ) ?>
            </div>
    <?php }
    }?>
</div>