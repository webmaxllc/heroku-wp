<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/25/15
 * Time: 8:20 PM
 */
if(!class_exists('BravoEcommerce'))
{
    class BravoEcommerce
    {
        static $system_dir;
        static $app_dir;

        static $framework_version="1.0";

        /**
         * Define system variable
         *
         * Load required core file
         *
         * Run theme app
         *
         *
         * */
        static function init()
        {
            // Init some variable
            self::$system_dir=apply_filters('bravo_system_dir','bravo_ecommerce');
            self::$app_dir=apply_filters('bravo_app_dir','bravo_app');

            // Load Core Files
            self::_load_core_files();

            // Load libraries and helpers
            self::_load_libs();

            // Autoload libraries, helpers, models
            self::_autoload();


            // All Done! Run our app now
            get_template_part(self::$app_dir.'/index');

            add_action('admin_enqueue_scripts',array(__CLASS__,'_add_scripts'));
        }

        static function _add_scripts()
        {
            wp_enqueue_style('bravo-admin',BravoAssets::url('admin/css/admin.css'));
        }

        /**
         *
         * Autoload libraries, helpers, models
         *
         * */
        static function _autoload()
        {
            $autoloads=BravoConfig::get('autoload');

            // Load Helpers
            $helpers=isset($autoloads['helpers'])?$autoloads['helpers']:array();
            BravoLoader::helpers($helpers);

            // Load libraries
            $libraries=isset($autoloads['libraries'])?$autoloads['libraries']:array();
            BravoLoader::libraries($libraries);

            // Load Helpers
            $models=isset($autoloads['models'])?$autoloads['models']:array();
            BravoLoader::models($models);

            // Load Widgets
            self::_load_widgets();

            // Load elements
            add_action('init',array(__CLASS__,'_load_elements'));
        }

        static function _load_widgets()
        {
            $dir=get_template_directory().'/'.self::$app_dir;

            $elements=glob($dir."/widgets/*.php");

            // Auto load all $elements file
            if(!empty($elements)){
                foreach ($elements as $filename)
                {
                    BravoLoader::widget(basename($filename, ".php"));
                }
            }
        }

        static function _load_elements()
        {
            if(!function_exists('bravo_reg_shortcode') or !function_exists('vc_map')) return;

            $dir=get_template_directory().'/'.self::$app_dir;

            $elements=glob($dir."/elements/*.php");

            // Auto load all $elements file
            if(!empty($elements)){
                foreach ($elements as $filename)
                {
                    BravoLoader::element(basename($filename, ".php"));
                }
            }
        }

        static function _load_core_files(){

            // Loader CLass
            self::_include('core/class-bravo-loader');

            // Config Class
            self::_include('core/class-bravo-config');

            // Session Class
            self::_include('core/class-bravo-session');

            // Template Class
            self::_include('core/class-bravo-template');


        }

        static function _load_libs()
        {
            //Load libraries

        }


        /**
         *
         * Include file in system
         *
         * */
        static function _include($file){
            get_template_part(self::$system_dir.'/'.esc_attr($file));
        }




    }

    BravoEcommerce::init();
}

