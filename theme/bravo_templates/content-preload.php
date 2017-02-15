<?php
$enable_preload = bravo_get_option('enable_preload','off');
$preload_style = bravo_get_option('preload_style','bounce');

$custom_enable_preload = get_post_meta(get_the_ID(),'enable_preload',true);

if($custom_enable_preload == 'on'){
    $enable_preload = $custom_enable_preload;
    $preload_style = get_post_meta(get_the_ID(),'preload_style',true);
}

if($enable_preload == 'on'):

    if($preload_style == 'bounce'){
        ?>
        <div class="loader">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <div class="loader">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
        <?php
    }
endif;

