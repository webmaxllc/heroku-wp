<?php
$menu_style = bravo_get_option('menu_style','style_1');
$enable_affix = bravo_get_option('enable_affix','off');
$custom_menu = get_post_meta(get_the_ID(),'custom_menu',true);
if($custom_menu == 'on'){
    $menu_style = get_post_meta(get_the_ID(),'menu_style',true);
    $enable_affix = get_post_meta(get_the_ID(),'enable_affix',true);
}
if($menu_style == "style_1"):
    $social_menu = bravo_get_option('social_menu');
    ?>
    <!-- Main-Navigation -->
    <header id="main-navigation">
        <div id="navigation" <?php if($enable_affix == 'on') echo "class='affix enable_affix'"; else echo 'data-spy="affix" data-offset-top="20"'; ?> >
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if(!empty($social_menu)){
                            echo '<ul class="top-right text-right">';
                            foreach($social_menu as $k=>$v){
                                $class = str_replace('fa fa-','',$v['icon']);
                                $class = str_replace('icon-','',$class);
                                echo '<li><a href="'.esc_url($v['link']).'" class="'.esc_attr($class).'"><i class="'.esc_attr($v['icon']).'"></i></a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                        <nav class="navbar navbar-default">
                            <div class="navbar-header page-scroll">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fixed-collapse-navbar" aria-expanded="true">
                                    <span class="icon-bar top-bar"></span>
                                    <span class="icon-bar middle-bar"></span>
                                    <span class="icon-bar bottom-bar"></span>
                                </button>
                                <a class="navbar-brand logo" href="<?php echo esc_url(home_url()) ?>">
                                    <?php $logo = bravo_get_option('logo_white');
                                    if(!empty($logo)){
                                        ?>
                                        <img src="<?php echo esc_url($logo) ?>" alt="logo" class="img-responsive">
                                    <?php }else{
                                        ?>
                                        <h1><?php echo esc_html_e("Bizone","bizone"); ?></h1>
                                    <?php
                                    } ?>
                                </a>
                            </div>
                            <div id="fixed-collapse-navbar" class="navbar-collapse collapse navbar-right">
                                <?php
                                if(has_nav_menu('primary')){
                                    $args = array(
                                        'theme_location'  => 'primary',
                                        'menu_class'      => 'nav navbar-nav menu-main navbar-right',
                                        'container'=>'',
                                        'walker'          => new Bravo_Menu_Walker,
                                    );
                                    wp_nav_menu($args);
                                }
                                ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php endif;?>
<?php if($menu_style == "style_2"): ?>
    <!-- Main-Navigation -->
    <header id="main-navigation" class="noborder style_2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a class="navbar-brand logo-space" href="<?php echo esc_url(home_url()) ?>">
                        <?php $logo = bravo_get_option('logo_white');
                        if(!empty($logo)){
                            ?>
                            <img src="<?php echo esc_url($logo) ?>" alt="logo" class="img-responsive">
                        <?php } ?>
                    </a>
                    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right">
                        <a href="#." class="push_nav_brand">
                            <?php $logo = bravo_get_option('logo');
                            if(!empty($logo)){
                                ?>
                                <img src="<?php echo esc_url($logo) ?>" alt="logo" class="img-responsive">
                            <?php } ?>
                        </a>
                        <?php
                        if(has_nav_menu('primary')){
                            $args = array(
                                'theme_location'  => 'primary',
                                'menu_class'      => 'push_nav',
                                'container'=>'',
                                'walker'          => new Bravo_Menu_Walker,
                            );
                            wp_nav_menu($args);
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="main-button right">
            <button class="toggle-menu menu-right push-body"> <span></span> <span></span> <span></span> </button>
        </div>
    </div>
<?php endif;?>
