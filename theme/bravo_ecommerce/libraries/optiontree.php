<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/28/15
 * Time: 7:07 PM
 */
if (!class_exists('BravoOptiontree')) {
    class BravoOptiontree
    {
        static $theme;

        static function _init()
        {

            //Load helper

            BravoLoader::helper('optiontree');

            if (!class_exists('OT_Loader')) return;

            // Register theme options
            self::_add_themeoptions();
            add_action('init', array(__CLASS__, '_add_themeoptions'));

            self::$theme = wp_get_theme();

            add_filter('ot_header_version_text', array(__CLASS__, '_ot_header_version_text'));

            add_filter('ot_theme_options_parent_slug', array(__CLASS__, '_change_parent_slug'), 1);
            add_filter('ot_theme_options_menu_title', array(__CLASS__, '_change_menu_title'));
            add_filter('ot_header_logo_link', array(__CLASS__, '_change_header_logo_link'));

            add_filter('ot_theme_options_icon_url', array(__CLASS__, '_change_menu_icon'));

            add_filter('ot_theme_options_position', array(__CLASS__, '_change_menu_pos'));

            add_action('admin_menu', array(__CLASS__, '_change_admin_menu'));

            //Check WPML Installed
            if (defined('ICL_LANGUAGE_CODE') and defined('ICL_SITEPRESS_VERSION') and class_exists('SitePress')) {

                add_action('admin_init', array(__CLASS__, '_copy_default_theme_option'));
                add_filter('ot_options_id', array(__CLASS__, '_get_option_by_lang'), 10, 1);
            }
        }

        static function _change_header_logo_link()
        {
            return "<a ><img src='" . BravoAssets::url("admin/img/Logo.jpg") . "'></a>";
        }

        static function _get_option_by_lang($option)
        {
            return $option_key = $option . '_' . ICL_LANGUAGE_CODE;
        }

        static function _copy_default_theme_option()
        {
            $option_name = 'option_tree';
            if (defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')) {
                global $sitepress;
                $options = get_option($option_name);
                $wpml_lang = icl_get_languages('skip_missing=0&orderby=custom');
                $default_lang = $sitepress->get_default_language();
                if (is_array($wpml_lang) && !empty($wpml_lang)) {
                    foreach ($wpml_lang as $lang) {
                        $lang_option = get_option($option_name . '_' . $lang['language_code']);
                        if ($lang_option == '') {
                            update_option($option_name . '_' . $lang['language_code'], $options);
                        }
                    }
                }
            }
        }

        static function _change_admin_menu()
        {

        }

        static function _change_menu_pos()
        {
            return 59;
        }

        static function _change_menu_icon()
        {
            return 'dashicons-bravotheme';
        }

        static function _change_parent_slug($slug)
        {
            return false;
        }

        static function _change_menu_title($title)
        {
            return BravoConfig::get('theme_option_menu_title');
        }

        static function _add_themeoptions()
        {
            /* OptionTree is not loaded yet, or this is not an admin request */
            if (!function_exists('ot_settings_id') || !is_admin())
                return false;


            $saved_settings = get_option(ot_settings_id(), array());

            BravoConfig::load('theme-options');

            $custom_settings = BravoConfig::get('theme_options', array());

            if (is_array($custom_settings) and !empty($custom_settings)) {
                /* allow settings to be filtered before saving */
                $custom_settings = apply_filters(ot_settings_id() . '_args', $custom_settings);

                /* settings are not the same update the DB */
                if ($saved_settings !== $custom_settings) {
                    update_option(ot_settings_id(), $custom_settings);
                }
            }


        }

        static function _ot_header_version_text()
        {
            $title = esc_html(self::$theme->display('Name'));
            $title .= ' - ' . sprintf(esc_html__('Version %s', "bizone"), self::$theme->display('Version'));


            if (class_exists('SitePress') and defined('ICL_LANGUAGE_NAME')) {
                $title .= ' ' . sprintf(esc_html__('for %s', "bizone"), ICL_LANGUAGE_NAME);

            }

            return $title;
        }


    }

    BravoOptiontree::_init();
}
