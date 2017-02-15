<?php
$bravo_sidebar=bravo_get_sidebar();
$bravo_sidebar_pos=$bravo_sidebar['position'];
global $wp_query;
get_header();
$bravo_enable_head = bravo_get_option('enable_head_page');
$bravo_title = bravo_get_option('post_blog_title');
$bravo_sub_title = bravo_get_option('post_blog_sub_title');
$bravo_bg = bravo_get_option('blog_background_image');
if($bravo_enable_head == 'on'){
    $class = BravoAssets::build_css(' background: url("'.esc_url($bravo_bg).'") no-repeat fixed center center / cover ;')
    ?>
    <section class="innerpage-banner <?php echo esc_attr($class) ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-right">
                    <h2><?php echo esc_html($bravo_title) ?></h2>
                    <p class="tagline"><?php echo esc_html($bravo_sub_title) ?></p>
                </div>
            </div>
        </div>
    </section>
<?php }else{
    echo '<div class="no_banner"></div>';
} ?>
    <div id="area-main" class="padding">
        <div class="blog">
            <div class="container">
                <h2 class="page-title">
                    <?php esc_html_e(" Search Results for","bizone") ?>:
                    <?php printf( __( '"%s"', "bizone" ), '<span>' . get_search_query() . '</span>' ); ?>
                </h2>
                <div class="row">
                    <?php if($bravo_sidebar_pos=='left'){ get_sidebar(); }?>
                    <div class="col-xs-12 <?php echo esc_html($bravo_sidebar_pos=='no'?'col-md-12':'col-md-8'); ?>">
                        <?php
                        if(have_posts()){
                            while(have_posts()){
                                the_post();
                                echo get_template_part('loop','post');
                            }
                        }else{
                            get_template_part('loop','none');
                        }

                        ?>
                        <?php echo bravo_paginate_links(); ?>
                    </div>
                    <?php if($bravo_sidebar_pos=='right'){ get_sidebar(); }?>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();