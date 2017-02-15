<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/27/15
 * Time: 12:27 AM
 */
if(!class_exists('BravoLoader'))
{
    class BravoLoader
    {
        static $_sysdir;
        static $_appdir;

        static function _init()
        {
            self::$_appdir=BravoEcommerce::$app_dir;
            self::$_sysdir=BravoEcommerce::$system_dir;
        }

        // -----------------------------------------------------------------
        /**
         * @string library file to load
         *
         * @todo load library file from libraries folder
         * @since 1.0
         * */
        static function library($lib_name=false)
        {
            if(!$lib_name) return;

            locate_template(array(
                self::$_appdir.'/libraries/'.esc_attr($lib_name).'.php',
                self::$_sysdir.'/libraries/'.esc_attr($lib_name).'.php',
            ),true);

        }
        // -----------------------------------------------------------------
        /**
         * @array libraries array files to load
         *
         * @todo load libraries file from libraries folder
         * @since 1.0
         * */
        static function libraries($libs=array())
        {
            if(!empty($libs) and is_array($libs))
            {
                foreach($libs as $key)
                    self::library($key);
            }

        }

        // -----------------------------------------------------------------
        /**
         * @string element file to load
         *
         * @todo load element file from elements folder
         * @since 1.0
         * */
        static function element($lib_name=false)
        {
            if(!function_exists('vc_map') or !function_exists('bravo_reg_shortcode')) return;
            if(!$lib_name) return;

            locate_template(array(
                self::$_appdir.'/elements/'.esc_attr($lib_name).'.php',
                self::$_sysdir.'/elements/'.esc_attr($lib_name).'.php',
            ),true);

        }
        // -----------------------------------------------------------------
        /**
         * @array elements array files to load
         *
         * @todo load elements file from elements folder
         * @since 1.0
         * */
        static function elements($libs=array())
        {

            if(!empty($libs) and is_array($libs))
            {
                foreach($libs as $key)
                    self::element($key);
            }

        }

        // -----------------------------------------------------------------
        /**
         * @string widget file to load
         *
         * @todo load widget file from libraries folder
         * @since 1.0
         * */
        static function widget($lib_name=false)
        {
            if(!$lib_name) return;

            locate_template(array(
                self::$_appdir.'/widgets/'.esc_attr($lib_name).'.php',
                self::$_sysdir.'/widgets/'.esc_attr($lib_name).'.php',
            ),true);

        }
        // -----------------------------------------------------------------
        /**
         * @array widgets array files to load
         *
         * @todo load widgets file from libraries folder
         * @since 1.0
         * */
        static function widgets($libs=array())
        {
            if(!empty($libs) and is_array($libs))
            {
                foreach($libs as $key)
                    self::widget($key);
            }

        }

        // -----------------------------------------------------------------
        /**
         * @string helper file to load
         *
         * @todo load helper file from  folder
         * @since 1.0
         * */
        static function helper($lib_name=false)
        {
            if(!$lib_name) return;

            locate_template(array(
                self::$_appdir.'/helpers/'.esc_attr($lib_name).'.php',
                self::$_sysdir.'/helpers/'.esc_attr($lib_name).'.php',
            ),true);

        }

        // -----------------------------------------------------------------
        /**
         * @array helpers array file to load
         *
         * @todo load helpers file from helpers folder
         * @since 1.0
         * */
        static function helpers($helpers=array())
        {
            if(!empty($helpers) and is_array($helpers))
            {
                foreach($helpers as $key)
                    self::helper($key);
            }

        }
        // -----------------------------------------------------------------
        /**
         *
         * @todo load model file from models folder
         * @since 1.0
         * */
        static function model($lib_name=false)
        {
            if(!$lib_name) return;

            locate_template(array(
                self::$_appdir.'/models/'.esc_attr($lib_name).'.php',
                self::$_sysdir.'/models/'.esc_attr($lib_name).'.php',
            ),true);

        }

        // -----------------------------------------------------------------
        /**
         * @array models file to load
         *
         * @todo load multi model file from models folder
         * @since 1.0
         * */
        static function models($models=array())
        {
            if(!empty($models) and is_array($models))
            {
                foreach($models as $key)
                    self::model($key);
            }
        }
    }

    BravoLoader::_init();
}
