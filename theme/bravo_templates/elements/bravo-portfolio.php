<?php

$query=array(
    'posts_per_page'=>$number,
    'post_type' => 'bravo_portfolio',
    'order'=>$order,
    'orderby'=>$orderby,
);
$check = (explode(",",$bravo_category));
$list_cat = array();
if($bravo_category != "_0_" and !in_array('_0_',$check) and !empty($bravo_category))
{
    $query['tax_query'][]=array(
        'taxonomy'=>'bravo_portfolio_cat',
        'field'  =>'slug',
        'terms'=>explode(",",$bravo_category)
    );
    $terms=get_terms('bravo_portfolio_cat', array( 'taxonomy'   => 'bravo_portfolio_cat' , 'hide_empty' => false , 'slug'    => explode(",",$bravo_category) ));
    if(!empty($terms)){
        foreach($terms as $k=>$v){
            $list_cat[$v->name]= $v->slug;
        }
    }
}
if($bravo_category == "_0_" and in_array('_0_',$check)){
    $terms=get_terms('bravo_portfolio_cat',array('taxonomy'=>'bravo_portfolio_cat','hide_empty'=>false));
    if(!empty($terms)){
        foreach($terms as $k=>$v){
            $list_cat[$v->name]= $v->slug;
        }
    }
}
$bravo_query = new WP_Query( $query );
?>

<section class="content_portfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="title"><?php echo esc_html($excerpt) ?></p>
                <h2 class="heading"><?php echo esc_html($title) ?></h2>
                <div class="work-filter">
                    <ul class="text-center">
                        <li><a href="javascript:;" data-filter="all" class="active filter"><?php esc_html_e('All','bizone') ?></a></li>
                        <?php
                        if(!empty($list_cat)){
                            foreach($list_cat as $k=>$v){
                                echo '<li><a href="javascript:;" data-filter=".'.esc_attr($v).'" class="filter">'.esc_html($k).'</a></li>';
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="project-wrapper">
        <div class="zerogrid">
            <div class="clearfix">
                <div class="wrap-content">
                    <div class="row">
                        <?php
                        $i = 1;
                        $check = false;
                        while($bravo_query->have_posts()){
                            $bravo_query->the_post();
                            $terms = wp_get_post_terms( get_the_ID(), 'bravo_portfolio_cat' );
                            $cat = '';
                            if(!empty($terms)){
                                foreach($terms as $k=> $v){
                                    $cat .= " ".esc_attr($v->slug);
                                }
                            }
                            $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
                            $size_item = get_post_meta(get_the_ID(),'size_item',true);
                            if(empty($size_item)) $size_item = 'size25';

                            if($i == 1 or $i== 4){
                                echo '<div class="col-md-6">';
                                $check = true;
                            }
                            ?>
                                <div class="item_portfolio mix work-item <?php echo esc_html($cat) ?> <?php echo esc_html($size_item) ?>">
                                    <div class="wrap-col">
                                        <div class="item-container">
                                            <a class="fancybox overlay text-center" data-fancybox-group="gallery" href="<?php echo esc_url($feat_image_url) ?>">
                                                <div class="overlay-inner">
                                                    <h4 class="base"><?php the_title() ?></h4>
                                                    <div class="line"></div>
                                                    <div><?php the_excerpt() ?></div>
                                                </div>
                                            </a>
                                            <?php echo get_the_post_thumbnail(get_the_ID(),'full',array('class'=>'img-responsive')); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            if($i == 3 or $i==6){
                                $check = false;
                                echo '</div>';
                            }
                            ?>
                            <?php
                                $i++;
                                if($i==7)$i=1;
                        } ?>
                        <?php if($check == true)  echo '</div>';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
