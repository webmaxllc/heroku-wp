<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/25/15
 * Time: 9:04 PM
 */

if(!class_exists('BravoConfig'))
{
    class BravoConfig
    {
        static $_all;

        static function _init()
        {
            //Load Default Config
            self::load('config');
        }

        static function load($file)
        {
            $file_path=get_template_directory().'/'.BravoEcommerce::$app_dir.'/configs/'.esc_attr($file).'.php';

            $config=array();

            if(file_exists($file_path))
            {
                require_once($file_path);
            }

            if(!is_array(self::$_all)) self::$_all=array();

            self::$_all=array_merge(self::$_all,$config);
        }

        static function get($key=false,$default=NULL)
        {
            if(isset(self::$_all[$key])){

                $return =self::$_all[$key];
            }else{

                $return=$default;
            }


            return apply_filters('bravo_config_get_'.esc_attr($key),$return,$key,$default);
        }
    }

    BravoConfig::_init();
}