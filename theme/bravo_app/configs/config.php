<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/25/15
 * Time: 9:11 PM
 */

$config['version']='1.0';

/**
 * List all helpers file autoload
 * @see BravoEcommerce::_autoload();
 *
 * */
$config['autoload']['helpers']=array(
    'general',
    'post',
    'woocommerce'
);

/**
 * List all libraries file autoload
 * @see BravoEcommerce::_autoload();
 *
 * */
$config['autoload']['libraries']=array(
    'class-params',
    'assets',
    'input',
    'optiontree',
    'required_plugins',
    'importer',
    'optiontree-css-output',
    'author-meta',
    'otf_regen_thumbs',
    'rectan-menu-walker',
    'TwitterAPIExchange',
    'category-walker'
);

/**
 * List all models file autoload
 * @see BravoEcommerce::_autoload();
 *
 * */
$config['autoload']['models']=array(
    'general',
    'post',
    'page',

    'portfolio',
    'woocommerce',
    'vc_customs',
    'layout',
    'login',
);


/**
 * Array of defaults navigation menu
 *
 * @see BravoGeneral::_after_setup_theme()
 *
 *
 * */
$config['nav_menus']=array(
    'primary' => esc_html__( 'Top Menu', "bizone" ),
    'footer_menu' => esc_html__( 'Footer Menu', "bizone" ),
);



/**
 * Default sidebar
 * @see BravoGeneral::_add_sidebars();
 *
 * */
$config['sidebars']=array(
    array(
        'name' => esc_html__( 'Blog Sidebar', "bizone" ),
        'id' => 'blog-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown on all blog page.', "bizone"),
        'before_title' => '<h4 class="sidebar-heading">',
        'after_title' => '</h4>',
        'before_widget' => '<div id="%1$s" class="sidebar-widget bravo-sidebar widget %2$s">',
        'after_widget'  => '</div>',
    ),


);


/**
 * Default get assets folder
 * @see BravoAssets::url()
 *
 * */
$config['asset_url']=get_template_directory_uri().'/assets';


/**
 * Default Theme Options Menu Title
 *
 * @see BravoOptiontree::_change_menu_title()
 *
 *
 * */
$config['theme_option_menu_title']='Theme Settings';