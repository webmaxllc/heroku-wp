<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/28/15
 * Time: 10:07 PM
 */

if (!class_exists('BravoGeneral')) {

    class BravoGeneral
    {
        static function _init()
        {
            //Default Framwork Hooked

            add_action('wp', array(__CLASS__, '_setup_author'));
            add_action('after_setup_theme', array(__CLASS__, '_after_setup_theme'));
            add_action('widgets_init', array(__CLASS__, '_add_sidebars'));

            add_action('wp_enqueue_scripts', array(__CLASS__, '_add_scripts'));
            add_action('admin_enqueue_scripts', array(__CLASS__, '_add_admin_scripts'));

            //Custom hooked
            add_filter('bravo_get_sidebar', array(__CLASS__, '_blog_filter_sidebar'));
            add_action('init', array(__CLASS__, '_init_elements'));
            //add_action('bravo_before_main_content', array(__CLASS__, '_add_breadcrumb'));
            //add_action('wp_head', array(__CLASS__, '_show_custom_css'), 100);
            add_action( 'wp_footer', array(__CLASS__, '_show_custom_css'),11 );

            add_filter('body_class', array(__CLASS__, '_add_body_class'));

            add_action('wp_head', array(__CLASS__, '_add_custom_head'));



            // Header image
            add_action('bravo_header_image_src', array(__CLASS__, '_home_page_header_img'));

            add_filter('st_blog_title',array(__CLASS__,'_st_blog_title'));

            add_filter( 'excerpt_length',array(__CLASS__,'_excerpt_length') );


            add_filter('bs_blog_single_header_image',array(__CLASS__,'_change_image'));

            if(class_exists('WpbakeryShortcodeParams')){

                WpbakeryShortcodeParams::addField( 'add_social', array(__CLASS__,'add_social_param'), BravoAssets::url('js/vc_js.js') );

            }

            add_filter('get_the_archive_title',array(__CLASS__,'_change_archive_title'));

            add_filter('vc_iconpicker-type-fontawesome', array(__CLASS__, '_add_vc_icon'));

            add_filter('widget_categories_args',array(__CLASS__,'_change_category_walker'));

        }
        static function _change_category_walker($args){

            $args['walker']=new Bravo_Category_Walker();

            return $args;
        }

        static function _init_elements()
        {
            //vc_map_update('icon_type');
        }

        static function _add_vc_icon($icon)
        {
            $newicon = array(
                esc_html__('Bizone Icon','bizone')=>	array(
                    array('icon-icons9'     => 'Config'),
                    array('icon-umbrella'   => 'Umbrella'),
                    array('icon-icons20' => 'Clock'),
                    array('icon-icons96'   => 'Light'),
                    array('icon-globe' => 'globe'),
                    array('icon-icons42'    => 'tablet'),
                )

            );

            return  $newicon;
        }

        static function _change_archive_title($title)
        {
            if(is_search()){
                $title=sprintf(esc_html__("Search Result for: %s","bizone"),get_query_var('s'));
            }
            return $title;
        }
        static function add_social_param($settings, $value)
        {
            $val = $value;
            $html = '<div class="st_add_social">';

            parse_str(urldecode($value), $social);

            if(is_array($social))
            {
                $i = 1;
                foreach ($social as $key => $value) {
                    if(!isset($value['url'])) $value['url'] = '';
                    $html .= '<div class="social-item" data-item="'.esc_attr($i).'">';
                    $html .= '<label>Social '.esc_attr($i).':</label></br><label>Icon </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social st_iconpicker" name="'.esc_attr($i).'[social]" value="'.esc_html($value['social']).'" type="text" ></br>';
                    $html .= '<label>Link </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social" name="'.esc_attr($i).'[url]" value="'.esc_attr($value['url']).'" type="text" >';
                    $html .= '<a style="color:red" href="#" class="st-del-item">Delete</a>';
                    $html .= '</div>';
                    $i++;
                }
            }
            $html .= '</div>';
            $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add" type="button">'.esc_html__('Add social', "bizone").' </button></div>';
            $html .= '<input name="'.esc_attr($settings['param_name']).'" class="st-social-value wpb_vc_param_value wpb-textinput '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="hidden" value="'.esc_html($val).'" >';
            return $html;
        }
        static function _change_image($src){
            if(is_singular()){
                if($meta=get_post_meta(get_the_ID(),'_header_image',true)){
                    $src=$meta;
                }
            }

            return $src;

        }
        static function _excerpt_length($length)
        {
            return bravo_get_option('post_exerpt_length',$length);
        }

        static function _st_blog_title($title)
        {
            if(is_archive()){
                $title=get_the_archive_title();
            }

            if(is_search()){
                $title= sprintf( esc_html__( 'Search Results for: %s', "bizone" ), get_search_query() );

            }
            return $title;
        }
        static function _home_page_header_img($image_src)
        {
            if (is_page_template('template-blank.php')) {
                $image_src = bravo_get_option('header_image', $image_src);
            }

            if (is_singular()) {
                if ($meta = get_post_meta(get_the_ID(), '_header_image', true)) {
                    $image_src = $meta;
                }
            }

            return $image_src;
        }

        static function _add_body_class($class)
        {
            $menu = bravo_get_option('menu_width_fullwidth', 'on');
            if (is_singular()) {
                $meta = get_post_meta(get_the_ID(), 'menu_width_fullwidth', true);
                if ($meta) $menu = $meta;
            }

            $transparent_header = bravo_get_option('transparent_header', 'off');
            if (is_singular() and get_post_meta(get_the_ID(), 'custom_header_style', true) == 'on') {
                $meta = get_post_meta(get_the_ID(), 'transparent_header', true);
                if ($meta) $transparent_header = $meta;
            }

            if ($transparent_header == 'on') {
                $class[] = 'header_transparent';
            }

            if ($menu == 'on')
                $class[] = 'bravo_fullwidth_menu';
            else
                $class[] = 'bravo_boxed_menu';


            $class[] = 'woocommerce';

			if(bravo_get_option('gen_enable_preload')=='on'){
				$class[]='gen_enable_preload';
			}


            $positionMenu = bravo_menu_pos();
            $class[]=$positionMenu.'-menu';

            return $class;
        }

        static function _show_custom_css()
        {
            $style = BravoTemplate::load_view('custom_css');
            wp_add_inline_style( 'bravo_custom', $style );
            wp_add_inline_style( 'bravo_custom', bravo_get_option('style_custom_css') );

        }

        static function _add_breadcrumb()
        {
            get_template_part('bc');
        }



        static function _blog_filter_sidebar($sidebar)
        {

                $pos = bravo_get_option('page_sidebar_pos', 'right');

                $sidebar_id = bravo_get_option('page_sidebar_id', 'blog-sidebar');

                /// ID Meta ///
                if (is_singular()) {
                    if ($meta = get_post_meta(get_the_ID(), 'sidebar_id', true)) {
                        $sidebar_id = $meta;
                    }
                }
                if ($sidebar_id) {
                    $sidebar['id'] = $sidebar_id;
                }

                /// position Meta///
                $sidebar['position'] = $pos;
                if (is_singular()) {
                    if ($meta = get_post_meta(get_the_ID(), 'sidebar_pos', true)) {
                        $sidebar['position'] = $meta;
                    }
                }

                if (BravoInput::get('sidebar_pos')) {
                    $sidebar['position'] = BravoInput::get('sidebar_pos');
                }
                if (BravoInput::get('sidebar_id')) {
                    $sidebar['id'] = BravoInput::get('sidebar_id');
                }


            return $sidebar;
        }

        static function _top_page()
        {
            echo BravoTemplate::load_view('top_page');
        }
        static function studio_fonts_url() {
            $font_url = '';

            /*
            Translators: If there are characters in your language that are not supported
            by chosen font(s), translate this to 'off'. Do not translate into your own language.
             */
            if ( 'off' !== _x( 'on', 'Google font: on or off', 'bizone' ) ) {
                $font_url =add_query_arg( 'family', urlencode( 'Open Sans|Raleway:100,200,300,400' ), "//fonts.googleapis.com/css" );
            }
            return $font_url;
        }

        static function _add_scripts()
        {
            /*
             * Javascript
             * */
            wp_enqueue_script('bootstrap_min_js',BravoAssets::url('js/bootstrap.min.js'),array('jquery'),null,true);
            wp_enqueue_script('jqueryeasingmin',BravoAssets::url('js/jquery.easing.min.js'),array('jquery'),null,true);
            wp_enqueue_script('owlcarouselmin',BravoAssets::url('js/owl.carousel.min.js'),array('jquery'),null,true);
            wp_enqueue_script('jquerycountTo',BravoAssets::url('js/jquery-countTo.js'),array('jquery'),null,true);
            wp_enqueue_script('jqueryappear',BravoAssets::url('js/jquery.appear.js'),array('jquery'),null,true);
            wp_enqueue_script('jquerycircliful',BravoAssets::url('js/jquery.circliful.js'),array('jquery'),null,true);
            wp_enqueue_script('jquerymixitup.min',BravoAssets::url('js/jquery.mixitup.min.js'),array('jquery'),null,true);
            wp_enqueue_script('wowmin',BravoAssets::url('js/wow.min.js'),array('jquery'),null,true);
            wp_enqueue_script('jqueryparallax',BravoAssets::url('js/jquery.parallax-1.1.3.js'),array('jquery'),null,true);
            wp_enqueue_script('jqueryfancybox',BravoAssets::url('js/jquery.fancybox.js'),array('jquery'),null,true);
            wp_enqueue_script('jqueryfancyboxthumbs',BravoAssets::url('js/jquery.fancybox-thumbs.js'),array('jquery'),null,true);
            wp_enqueue_script('jqueryfancyboxmedia',BravoAssets::url('js/jquery.fancybox-media.js'),array('jquery'),null,true);
            wp_enqueue_script('jPushMenu',BravoAssets::url('js/jPushMenu.js'),array('jquery'),null,true);

            wp_enqueue_script('bravo_functions',BravoAssets::url('js/functions.js'),array('jquery'),null,true);

            wp_enqueue_script('bravo_custom',BravoAssets::url('js/custom.js'),array('jquery'),null,true);


            if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
            $data = array(
                'ajaxurl'   => esc_url(admin_url('admin-ajax.php')),
                'site_url'  => site_url(),
                'theme_url' => get_template_directory_uri(),
            );
            wp_localize_script('bootstrap.min.js', 'ajax_param', $data);
            wp_localize_script('jquery', 'bizone_params', array(
                'url_logo' =>  bravo_get_option('logo'),
                'url_logo_white' =>  bravo_get_option('logo_white'),
                'on_loading_text' => esc_html__("Loading ....", "bizone"),
                'loadmore_text'   => esc_html__('Load More', "bizone"),
                'ajax_url'        => esc_url(admin_url('admin-ajax.php')),
                'nomore_text'     => esc_html__('No More', "bizone")
            ));


            // Style
            add_editor_style();
            wp_enqueue_style('bravo-main-style',get_template_directory_uri().'/style.css');

            wp_enqueue_style( 'bravo_google_font', self::studio_fonts_url(), array(), '1.0.0' );


            wp_register_style('bootstrap',BravoAssets::url('css/bootstrap.min.css'));
            wp_register_style('font-awesome',BravoAssets::url('css/font-awesome.min.css'));
            wp_register_style('icomoon-fonts',BravoAssets::url('css/icomoon-fonts.css'));
            wp_register_style('animate_min',BravoAssets::url('css/animate.min.css'));
            wp_register_style("bravo_settings",BravoAssets::url('css/settings.css'));
            wp_register_style('owl_carousel',BravoAssets::url('css/owl.carousel.css'));
            wp_register_style('fancybox',BravoAssets::url('css/jquery.fancybox.css'));
            wp_register_style('zerogrid',BravoAssets::url('css/zerogrid.css'));
            wp_register_style('jPushMenu',BravoAssets::url('css/jPushMenu.css'));
            wp_register_style('onepage',BravoAssets::url('css/onepage.css'));
            wp_register_style('one-color',BravoAssets::url('css/one-color.css'));
            wp_register_style('bravo_loader',BravoAssets::url('css/loader.css'));
            wp_register_style('bravo_loader-color',BravoAssets::url('css/loader-colorful.css'));

            wp_register_style('bravo_custom',BravoAssets::url('css/custom.css'));


            wp_enqueue_style('bootstrap');
            wp_enqueue_style('font-awesome');
            wp_enqueue_style('icomoon-fonts');
            wp_enqueue_style('animate_min');
            wp_enqueue_style('bravo_settings');
            wp_enqueue_style('owl_carousel');
            wp_enqueue_style('fancybox');
            wp_enqueue_style("zerogrid");
            wp_enqueue_style('jPushMenu');
            wp_enqueue_style('onepage');
            wp_enqueue_style('bravo_one-color');

            $preload_style = bravo_get_option('preload_style','bounce');
            $custom_enable_preload = get_post_meta(get_the_ID(),'enable_preload',true);
            if($custom_enable_preload == 'on'){
                $preload_style = get_post_meta(get_the_ID(),'preload_style',true);
            }
            if($preload_style == 'bounce'){
                wp_enqueue_style('bravo_loader-color');
            }else{
                wp_enqueue_style('bravo_loader');
            }

            //wp_enqueue_style('custom');
        }


        static function _add_admin_scripts()
        {

            wp_enqueue_style('bravo_icomoon-fonts',BravoAssets::url('css/icomoon-fonts.css'));
        }


        // -----------------------------------------------------
        // Default Hooked, Do not edit

        /**
         * Hook setup theme
         *
         *
         * */

        static function _after_setup_theme()
        {
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change $st_textdomain to the name of your theme in all the template files
             */

            // This theme uses wp_nav_menu() in one location.
            $menus = BravoConfig::get('nav_menus');
            if (is_array($menus) and !empty($menus)) {
                register_nav_menus($menus);
            }


            //Theme supports from config

            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            add_theme_support('html5', array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
            ));
            add_theme_support('post-formats', array(
                'image', 'video', 'gallery', 'audio', 'quote'
            ));
            add_theme_support('woocommerce');
            add_theme_support('custom-header', array());
            add_theme_support('custom-background', array());
            add_theme_support('title-tag', array());

            if (!isset($content_width)) $content_width = 900;

        }

        /**
         * Add default sidebar to website
         *
         *
         * */
        static function _add_sidebars()
        {
            // From config file
            $sidebars = BravoConfig::get('sidebars');
            if (is_array($sidebars) and !empty($sidebars)) {
                foreach ($sidebars as $value) {
                    register_sidebar($value);
                }
            }

        }


        /**
         * Set up author data
         *
         * */
        static function _setup_author()
        {
            global $wp_query;

            if ($wp_query->is_author() && isset($wp_query->post)) {
                $GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
            }
        }


        /**
         * Hook to wp_title
         *
         * */
        static function _wp_title($title, $sep)
        {
            if (is_feed()) {
                return $title;
            }

            global $page, $paged;

            // Add the blog name
            $title .= get_bloginfo('name', 'display');

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && (is_home() || is_front_page())) {
                $title .= " $sep $site_description";
            }

            // Add a page number if necessary:
            if (($paged >= 2 || $page >= 2) && !is_404()) {
                $title .= " $sep " . sprintf(esc_html__('Page %s', "bizone"), max($paged, $page));
            }

            return $title;
        }

        /**
         * Hook to add_custom_head
         *
         * */
        static function _add_custom_head()
        {
//            $adv_ga_code = bravo_get_option('adv_ga_code');
//            if (!empty($adv_ga_code)) {
//                echo balanceTags($adv_ga_code);
//            }

            self::_add_favicon();
        }


        static function _add_favicon()
        {
            if ( function_exists( 'has_site_icon' ) and  has_site_icon() )return;

            $favicon = bravo_get_option('favicon');
            if(!$favicon) return;

            $ext = pathinfo($favicon, PATHINFO_EXTENSION);

            //if(strtolower($ext)=="pne")

            $type = "";

            switch (strtolower($ext)) {

                case "png":
                    $type = "image/png";
                    break;

                case "jpg":
                    $type = "image/jpg";
                    break;

                case "jpeg":
                    $type = "image/jpeg";
                    break;

                case "gif":
                    $type = "image/gif";
                    break;
            }

        }

        static function _change_favicon(){

        }


    }

    BravoGeneral::_init();
}