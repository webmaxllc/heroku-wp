<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/25/15
 * Time: 8:26 PM
 */

if(!class_exists('BravoTemplate'))
{
    class BravoTemplate{

        static $_template_dir;

        static $_message_session_key;

        static function _init()
        {
            // Init some environment
            self::$_template_dir=apply_filters('bravo_template_dir','bravo_templates');

            self::$_message_session_key=apply_filters('bravo_message_session_key','bravo_message');

            //Load config file
            BravoConfig::load('template');

        }


        static function load_view($view_name,$slug=false,$data=NULL,$echo=FALSE)
        {
            if($data) extract($data);

            if($slug){
                $template=locate_template(self::$_template_dir.'/'.$view_name.'-'.$slug.'.php');
                if(!$template){
                    $template=locate_template(self::$_template_dir.'/'.$view_name.'.php');
                }
            }else{
                $template=locate_template(self::$_template_dir.'/'.$view_name.'.php');
            }

            //Allow Template be filter

            $template=apply_filters('bravo_load_view',$template,$view_name,$slug);

            if(file_exists($template)){

                if(!$echo){
                    ob_start();
                    include $template;

                    return @ob_get_clean();
                }else

                include $template;
            }
        }

        static function set_message($message,$type='info',$clear=false)
        {
            if($clear)
            {
                self::clear_messages();
            }


            $messages=self::get_messages();

            if(!is_array($message))
            {
                $messages=array(
                    array(
                        'message'=>$message,
                        'type'=>$type
                    )
                );
            }else{

                $messages[]=array(
                    'message'=>$message,
                    'type'=>$type
                );
            }

            BravoSession::set(self::$_message_session_key,$messages);
        }

        static function get_messages()
        {
            return BravoSession::get(self::$_message_session_key,array());
        }

        static function get_message($first=false)
        {
            $messages=self::get_messages();
            if(!$first) return array_pop($messages);
            else return array_shift($messages);
        }

        static function clear_messages()
        {
            BravoSession::destroy(self::$_message_session_key,NULL);
        }


        static function message($first=false)
        {
            $message=self::get_message($first);
            return self::_message_to_string($message);
        }
        static function messages()
        {
            $all=self::get_messages();

            if(!empty($all))
            {
                $html='';

                foreach($all as $key=>$value)
                {
                    $html.=self::_message_to_string($value);
                }

                return $html;
            }


        }

        static function _message_to_string($message)
        {
            $layout=BravoConfig::get('message_layout');

            $html= sprintf($layout,$message['type'],$message['message']);

            return apply_filters('bravo_messagge_to_string',$html,$message);
        }

        public static function get_vc_pagecontent($page_id=false)
        {
            if($page_id)
            {
                $page=get_post($page_id);

                if($page)
                {
                    $content=apply_filters('the_content', $page->post_content);

                    $content = str_replace(']]>', ']]&gt;', $content);


                    $shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );

                    BravoAssets::add_css($shortcodes_custom_css);

                    wp_reset_postdata();

                    return $content;
                }
            }
        }
        static function remove_wpautop( $content, $autop = false ) {

            if ( $autop ) {
                $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
            }
            return do_shortcode( shortcode_unautop( $content) );
        }
    }

    BravoTemplate::_init();
}