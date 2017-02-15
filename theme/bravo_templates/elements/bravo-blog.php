<?php

$query=array(
    'posts_per_page'=>$number,
    'post_type' => 'post',
    'order'=>$order,
    'orderby'=>$orderby,
);
$check = (explode(",",$bravo_category));
$list_cat = array();
if($bravo_category != "_0_" and !in_array('_0_',$check) and !empty($bravo_category))
{
    $query['tax_query'][]=array(
        'taxonomy'=>'category',
        'field'  =>'slug',
        'terms'=>explode(",",$bravo_category)
    );
}
$bravo_query = new WP_Query( $query );
?>
<section id="publication" class="section-padding padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="title"><?php echo esc_html($excerpt) ?></p>
                <h2 class="heading"><?php echo esc_html($title) ?></h2>
            </div>
        </div>
        <div class="row">
            <div id="publication-slider" class="owl-carousel publication-slider">
                <?php
                $i = 1;
                $check = false;
                while($bravo_query->have_posts()){
                    $bravo_query->the_post();
                    $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
                    ?>
                    <div class="item">
                        <div class="image">
                            <a href="<?php the_permalink() ?>">
                                <?php
                                if(has_post_thumbnail()){
                                    echo get_the_post_thumbnail(get_the_ID(),array(360,250));
                                }
                                ?>
                            </a>
                        </div>
                        <h5><?php echo get_the_time('j F Y') ?></h5>
                        <h4><?php the_title() ?></h4>
                        <p><?php esc_html_e('by','bizone') ?>
                            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="name"><?php the_author(); ?> </a>
                            -
                            <a href="<?php the_permalink() ?>#comment" class="comment">
                                <?php comments_number( 'No Comment', 'One Comment', '% Comments' ); ?>
                            </a>
                        </p>
                        <div><?php the_excerpt() ?></div>
                        <a href="<?php the_permalink() ?>"><?php esc_html_e('read more','bizone') ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); ?>
