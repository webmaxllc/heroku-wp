<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 3/3/15
 * Time: 7:41 PM
 */

if (!class_exists('BravoPage')) {
    class BravoPage
    {
        static function _init()
        {
            if (function_exists('vc_add_param')) {
                add_action('init', array(__CLASS__, '_init_elements'));

            }
            add_action('init', array(__CLASS__, '_add_metabox'));

            //add_filter('vc_tta_container_classes', array(__CLASS__, '_add_tab_class'), 10, 2);

            //add_filter('vc-tta-get-params-tabs-list',array(__CLASS__,'_add_tab_icon'),10,4);

            add_filter( 'vc_shortcodes_css_class' , array(
                __CLASS__ ,
                'css_classes_for_vc_row_and_vc_column'
            ) , 10 , 2 );

        }

        static function _add_tab_icon($html, $atts, $content, $this_object){



            $isPageEditabe = vc_is_page_editable();

            $html = array();
            $html[] = '<div class="vc_tta-tabs-container">';
            $html[] = '<ul class="vc_tta-tabs-list">';
            if ( ! $isPageEditabe ) {

                $active_section = $this_object->getActiveSection( $atts, true );

                foreach ( WPBakeryShortCode_VC_Tta_Section::$section_info as $nth => $section ) {
                    $classes = array( 'vc_tta-tab' );
                    if ( ( $nth + 1 ) === $active_section ) {
                        $classes[] = $this_object->activeClass;
                    }
                    $data_icon=false;
                    $data_icon=isset($section['bravo_icon'])?$section['bravo_icon']:false;

                    $title = '<span class="vc_tta-title-text">' . esc_html($section['title']) . '</span>';
                    if ( 'true' === $section['add_icon'] ) {
                        $icon_html = '<span class="bravo_js_icon" data-icon="'.esc_attr($data_icon).'">'.esc_html($this_object->constructIcon( $section )).'</span>';
                        if ( 'left' === $section['i_position'] ) {
                            $title = $icon_html . $title;
                        } else {
                            $title = $title . $icon_html;
                        }
                    }
                    $a_html = '<a href="#' . esc_attr($section['tab_id']) . '" data-vc-tabs data-vc-container=".vc_tta">' . esc_html($title) . '</a>';
                    $html[] = '<li class="' . implode( ' ', $classes ) . '" data-vc-tab>' . esc_html($a_html) . '</li>';
                }
            }

            $html[] = '</ul>';
            $html[] = '</div>';

            return apply_filters( 'bravo-tta-get-params-tabs-list', $html, $atts, $content, $this_object );
        }
        static function _add_tab_class($class, $att = array())
        {
            $att = wp_parse_args($att, array(
                'bravo_service_tab' => ''
            ));

            if ($att['bravo_service_tab'] == 'true') {
                $class[] = 'services';
            }

            return $class;
        }

        static function _init_elements()
        {



            vc_add_param( 'vc_row' , array(
                    "type"       => "dropdown" ,
                    "heading"    => __( 'Bravo Effect' , "bizone" ) ,
                    "param_name" => "row_effect" ,
                    "value"      => array(
                        __( '-- Select --' , "bizone" )             => '' ,
                        __( 'bounce' , "bizone" )             => 'bounce' ,
                        __( 'flash' , "bizone" )              => 'flash' ,
                        __( 'pulse' , "bizone" )              => 'flash' ,
                        __( 'rubberBand' , "bizone" )         => 'rubberBand' ,
                        __( 'shake' , "bizone" )              => 'shake' ,
                        __( 'headShake' , "bizone" )          => 'headShake' ,
                        __( 'swing' , "bizone" )              => 'swing' ,
                        __( 'tada' , "bizone" )               => 'tada' ,
                        __( 'wobble' , "bizone" )             => 'wobble' ,
                        __( 'jello' , "bizone" )              => 'jello' ,
                        __( 'bounceIn' , "bizone" )           => 'bounceIn' ,
                        __( 'bounceInDown' , "bizone" )       => 'bounceInDown' ,
                        __( 'bounceInLeft' , "bizone" )       => 'bounceInLeft' ,
                        __( 'bounceInRight' , "bizone" )      => 'bounceInRight' ,
                        __( 'bounceInUp' , "bizone" )         => 'bounceInUp' ,
                        __( 'bounceOut' , "bizone" )          => 'bounceOut' ,
                        __( 'bounceOutDown' , "bizone" )      => 'bounceOutDown' ,
                        __( 'bounceOutLeft' , "bizone" )      => 'bounceOutLeft' ,
                        __( 'bounceOutRight' , "bizone" )     => 'bounceOutRight' ,
                        __( 'bounceOutUp' , "bizone" )        => 'bounceOutUp' ,
                        __( 'fadeIn' , "bizone" )             => 'fadeIn' ,
                        __( 'fadeInDown' , "bizone" )         => 'fadeInDown' ,
                        __( 'fadeInDownBig' , "bizone" )      => 'fadeInDownBig' ,
                        __( 'fadeInLeft' , "bizone" )         => 'fadeInLeft' ,
                        __( 'fadeInLeftBig' , "bizone" )      => 'fadeInLeftBig' ,
                        __( 'fadeInRight' , "bizone" )        => 'fadeInRight' ,
                        __( 'fadeInRightBig' , "bizone" )     => 'fadeInRightBig' ,
                        __( 'fadeInUp' , "bizone" )           => 'fadeInUp' ,
                        __( 'fadeInUpBig' , "bizone" )        => 'fadeInUpBig' ,
                        __( 'fadeOut' , "bizone" )            => 'fadeOut' ,
                        __( 'fadeOutDown' , "bizone" )        => 'fadeOutDown' ,
                        __( 'fadeOutDownBig' , "bizone" )     => 'fadeOutDownBig' ,
                        __( 'fadeOutLeft' , "bizone" )        => 'fadeOutLeft' ,
                        __( 'fadeOutLeftBig' , "bizone" )     => 'fadeOutLeftBig' ,
                        __( 'fadeOutRight' , "bizone" )       => 'fadeOutRight' ,
                        __( 'fadeOutRightBig' , "bizone" )    => 'fadeOutRightBig' ,
                        __( 'fadeOutUp' , "bizone" )          => 'fadeOutUp' ,
                        __( 'fadeOutUpBig' , "bizone" )       => 'fadeOutUpBig' ,
                        __( 'flipInX' , "bizone" )            => 'flipInX' ,
                        __( 'flipInY' , "bizone" )            => 'flipInY' ,
                        __( 'flipOutX' , "bizone" )           => 'flipOutX' ,
                        __( 'flipOutY' , "bizone" )           => 'flipOutY' ,
                        __( 'lightSpeedIn' , "bizone" )       => 'lightSpeedIn' ,
                        __( 'lightSpeedOut' , "bizone" )      => 'lightSpeedOut' ,
                        __( 'rotateIn' , "bizone" )           => 'rotateIn' ,
                        __( 'rotateInDownLeft' , "bizone" )   => 'rotateInDownLeft' ,
                        __( 'rotateInDownRight' , "bizone" )  => 'rotateInDownRight' ,
                        __( 'rotateInUpLeft' , "bizone" )     => 'rotateInUpLeft' ,
                        __( 'rotateInUpRight' , "bizone" )    => 'rotateInUpRight' ,
                        __( 'rotateOut' , "bizone" )          => 'rotateOut' ,
                        __( 'rotateOutDownLeft' , "bizone" )  => 'rotateOutDownLeft' ,
                        __( 'rotateOutDownRight' , "bizone" ) => 'rotateOutDownRight' ,
                        __( 'rotateOutUpLeft' , "bizone" )    => 'rotateOutUpLeft' ,
                        __( 'rotateOutUpRight' , "bizone" )   => 'rotateOutUpRight' ,
                        __( 'hinge' , "bizone" )              => 'hinge' ,
                        __( 'rollIn' , "bizone" )             => 'rollIn' ,
                        __( 'rollOut' , "bizone" )            => 'rollOut' ,
                        __( 'zoomIn' , "bizone" )             => 'zoomIn' ,
                        __( 'zoomInDown' , "bizone" )         => 'zoomInDown' ,
                        __( 'zoomInLeft' , "bizone" )         => 'zoomInLeft' ,
                        __( 'zoomInRight' , "bizone" )        => 'zoomInRight' ,
                        __( 'zoomInUp' , "bizone" )           => 'zoomInUp' ,
                        __( 'zoomOut' , "bizone" )            => 'zoomOut' ,
                        __( 'zoomOutDown' , "bizone" )        => 'zoomOutDown' ,
                        __( 'zoomOutLeft' , "bizone" )        => 'zoomOutLeft' ,
                        __( 'zoomOutRight' , "bizone" )       => 'zoomOutRight' ,
                        __( 'zoomOutUp' , "bizone" )          => 'zoomOutUp' ,
                        __( 'slideInDown' , "bizone" )        => 'slideInDown' ,
                        __( 'slideInLeft' , "bizone" )        => 'slideInLeft' ,
                        __( 'slideInRight' , "bizone" )       => 'slideInRight' ,
                        __( 'slideInUp' , "bizone" )          => 'slideInUp' ,
                        __( 'slideOutDown' , "bizone" )       => 'slideOutDown' ,
                        __( 'slideOutLeft' , "bizone" )       => 'slideOutLeft' ,
                        __( 'slideOutRight' , "bizone" )      => 'slideOutRight' ,
                        __( 'slideOutUp' , "bizone" )         => 'slideOutUp' ,
                    ) ,
                )
            );

            vc_add_param( 'vc_column' , array(
                    "type"       => "dropdown" ,
                    "heading"    => __( 'Bravo Effect' , "bizone" ) ,
                    "param_name" => "row_effect" ,
                    "value"      => array(
                        __( '-- Select --' , "bizone" )             => '' ,
                        __( 'bounce' , "bizone" )             => 'bounce' ,
                        __( 'flash' , "bizone" )              => 'flash' ,
                        __( 'pulse' , "bizone" )              => 'flash' ,
                        __( 'rubberBand' , "bizone" )         => 'rubberBand' ,
                        __( 'shake' , "bizone" )              => 'shake' ,
                        __( 'headShake' , "bizone" )          => 'headShake' ,
                        __( 'swing' , "bizone" )              => 'swing' ,
                        __( 'tada' , "bizone" )               => 'tada' ,
                        __( 'wobble' , "bizone" )             => 'wobble' ,
                        __( 'jello' , "bizone" )              => 'jello' ,
                        __( 'bounceIn' , "bizone" )           => 'bounceIn' ,
                        __( 'bounceInDown' , "bizone" )       => 'bounceInDown' ,
                        __( 'bounceInLeft' , "bizone" )       => 'bounceInLeft' ,
                        __( 'bounceInRight' , "bizone" )      => 'bounceInRight' ,
                        __( 'bounceInUp' , "bizone" )         => 'bounceInUp' ,
                        __( 'bounceOut' , "bizone" )          => 'bounceOut' ,
                        __( 'bounceOutDown' , "bizone" )      => 'bounceOutDown' ,
                        __( 'bounceOutLeft' , "bizone" )      => 'bounceOutLeft' ,
                        __( 'bounceOutRight' , "bizone" )     => 'bounceOutRight' ,
                        __( 'bounceOutUp' , "bizone" )        => 'bounceOutUp' ,
                        __( 'fadeIn' , "bizone" )             => 'fadeIn' ,
                        __( 'fadeInDown' , "bizone" )         => 'fadeInDown' ,
                        __( 'fadeInDownBig' , "bizone" )      => 'fadeInDownBig' ,
                        __( 'fadeInLeft' , "bizone" )         => 'fadeInLeft' ,
                        __( 'fadeInLeftBig' , "bizone" )      => 'fadeInLeftBig' ,
                        __( 'fadeInRight' , "bizone" )        => 'fadeInRight' ,
                        __( 'fadeInRightBig' , "bizone" )     => 'fadeInRightBig' ,
                        __( 'fadeInUp' , "bizone" )           => 'fadeInUp' ,
                        __( 'fadeInUpBig' , "bizone" )        => 'fadeInUpBig' ,
                        __( 'fadeOut' , "bizone" )            => 'fadeOut' ,
                        __( 'fadeOutDown' , "bizone" )        => 'fadeOutDown' ,
                        __( 'fadeOutDownBig' , "bizone" )     => 'fadeOutDownBig' ,
                        __( 'fadeOutLeft' , "bizone" )        => 'fadeOutLeft' ,
                        __( 'fadeOutLeftBig' , "bizone" )     => 'fadeOutLeftBig' ,
                        __( 'fadeOutRight' , "bizone" )       => 'fadeOutRight' ,
                        __( 'fadeOutRightBig' , "bizone" )    => 'fadeOutRightBig' ,
                        __( 'fadeOutUp' , "bizone" )          => 'fadeOutUp' ,
                        __( 'fadeOutUpBig' , "bizone" )       => 'fadeOutUpBig' ,
                        __( 'flipInX' , "bizone" )            => 'flipInX' ,
                        __( 'flipInY' , "bizone" )            => 'flipInY' ,
                        __( 'flipOutX' , "bizone" )           => 'flipOutX' ,
                        __( 'flipOutY' , "bizone" )           => 'flipOutY' ,
                        __( 'lightSpeedIn' , "bizone" )       => 'lightSpeedIn' ,
                        __( 'lightSpeedOut' , "bizone" )      => 'lightSpeedOut' ,
                        __( 'rotateIn' , "bizone" )           => 'rotateIn' ,
                        __( 'rotateInDownLeft' , "bizone" )   => 'rotateInDownLeft' ,
                        __( 'rotateInDownRight' , "bizone" )  => 'rotateInDownRight' ,
                        __( 'rotateInUpLeft' , "bizone" )     => 'rotateInUpLeft' ,
                        __( 'rotateInUpRight' , "bizone" )    => 'rotateInUpRight' ,
                        __( 'rotateOut' , "bizone" )          => 'rotateOut' ,
                        __( 'rotateOutDownLeft' , "bizone" )  => 'rotateOutDownLeft' ,
                        __( 'rotateOutDownRight' , "bizone" ) => 'rotateOutDownRight' ,
                        __( 'rotateOutUpLeft' , "bizone" )    => 'rotateOutUpLeft' ,
                        __( 'rotateOutUpRight' , "bizone" )   => 'rotateOutUpRight' ,
                        __( 'hinge' , "bizone" )              => 'hinge' ,
                        __( 'rollIn' , "bizone" )             => 'rollIn' ,
                        __( 'rollOut' , "bizone" )            => 'rollOut' ,
                        __( 'zoomIn' , "bizone" )             => 'zoomIn' ,
                        __( 'zoomInDown' , "bizone" )         => 'zoomInDown' ,
                        __( 'zoomInLeft' , "bizone" )         => 'zoomInLeft' ,
                        __( 'zoomInRight' , "bizone" )        => 'zoomInRight' ,
                        __( 'zoomInUp' , "bizone" )           => 'zoomInUp' ,
                        __( 'zoomOut' , "bizone" )            => 'zoomOut' ,
                        __( 'zoomOutDown' , "bizone" )        => 'zoomOutDown' ,
                        __( 'zoomOutLeft' , "bizone" )        => 'zoomOutLeft' ,
                        __( 'zoomOutRight' , "bizone" )       => 'zoomOutRight' ,
                        __( 'zoomOutUp' , "bizone" )          => 'zoomOutUp' ,
                        __( 'slideInDown' , "bizone" )        => 'slideInDown' ,
                        __( 'slideInLeft' , "bizone" )        => 'slideInLeft' ,
                        __( 'slideInRight' , "bizone" )       => 'slideInRight' ,
                        __( 'slideInUp' , "bizone" )          => 'slideInUp' ,
                        __( 'slideOutDown' , "bizone" )       => 'slideOutDown' ,
                        __( 'slideOutLeft' , "bizone" )       => 'slideOutLeft' ,
                        __( 'slideOutRight' , "bizone" )      => 'slideOutRight' ,
                        __( 'slideOutUp' , "bizone" )         => 'slideOutUp' ,
                    ) ,
                )
            );

            vc_add_param( 'vc_row_inner' , array(
                    "type"       => "dropdown" ,
                    "heading"    => __( 'Bravo Effect' , "bizone" ) ,
                    "param_name" => "row_effect" ,
                    "value"      => array(
                        __( '-- Select --' , "bizone" )             => '' ,
                        __( 'bounce' , "bizone" )             => 'bounce' ,
                        __( 'flash' , "bizone" )              => 'flash' ,
                        __( 'pulse' , "bizone" )              => 'flash' ,
                        __( 'rubberBand' , "bizone" )         => 'rubberBand' ,
                        __( 'shake' , "bizone" )              => 'shake' ,
                        __( 'headShake' , "bizone" )          => 'headShake' ,
                        __( 'swing' , "bizone" )              => 'swing' ,
                        __( 'tada' , "bizone" )               => 'tada' ,
                        __( 'wobble' , "bizone" )             => 'wobble' ,
                        __( 'jello' , "bizone" )              => 'jello' ,
                        __( 'bounceIn' , "bizone" )           => 'bounceIn' ,
                        __( 'bounceInDown' , "bizone" )       => 'bounceInDown' ,
                        __( 'bounceInLeft' , "bizone" )       => 'bounceInLeft' ,
                        __( 'bounceInRight' , "bizone" )      => 'bounceInRight' ,
                        __( 'bounceInUp' , "bizone" )         => 'bounceInUp' ,
                        __( 'bounceOut' , "bizone" )          => 'bounceOut' ,
                        __( 'bounceOutDown' , "bizone" )      => 'bounceOutDown' ,
                        __( 'bounceOutLeft' , "bizone" )      => 'bounceOutLeft' ,
                        __( 'bounceOutRight' , "bizone" )     => 'bounceOutRight' ,
                        __( 'bounceOutUp' , "bizone" )        => 'bounceOutUp' ,
                        __( 'fadeIn' , "bizone" )             => 'fadeIn' ,
                        __( 'fadeInDown' , "bizone" )         => 'fadeInDown' ,
                        __( 'fadeInDownBig' , "bizone" )      => 'fadeInDownBig' ,
                        __( 'fadeInLeft' , "bizone" )         => 'fadeInLeft' ,
                        __( 'fadeInLeftBig' , "bizone" )      => 'fadeInLeftBig' ,
                        __( 'fadeInRight' , "bizone" )        => 'fadeInRight' ,
                        __( 'fadeInRightBig' , "bizone" )     => 'fadeInRightBig' ,
                        __( 'fadeInUp' , "bizone" )           => 'fadeInUp' ,
                        __( 'fadeInUpBig' , "bizone" )        => 'fadeInUpBig' ,
                        __( 'fadeOut' , "bizone" )            => 'fadeOut' ,
                        __( 'fadeOutDown' , "bizone" )        => 'fadeOutDown' ,
                        __( 'fadeOutDownBig' , "bizone" )     => 'fadeOutDownBig' ,
                        __( 'fadeOutLeft' , "bizone" )        => 'fadeOutLeft' ,
                        __( 'fadeOutLeftBig' , "bizone" )     => 'fadeOutLeftBig' ,
                        __( 'fadeOutRight' , "bizone" )       => 'fadeOutRight' ,
                        __( 'fadeOutRightBig' , "bizone" )    => 'fadeOutRightBig' ,
                        __( 'fadeOutUp' , "bizone" )          => 'fadeOutUp' ,
                        __( 'fadeOutUpBig' , "bizone" )       => 'fadeOutUpBig' ,
                        __( 'flipInX' , "bizone" )            => 'flipInX' ,
                        __( 'flipInY' , "bizone" )            => 'flipInY' ,
                        __( 'flipOutX' , "bizone" )           => 'flipOutX' ,
                        __( 'flipOutY' , "bizone" )           => 'flipOutY' ,
                        __( 'lightSpeedIn' , "bizone" )       => 'lightSpeedIn' ,
                        __( 'lightSpeedOut' , "bizone" )      => 'lightSpeedOut' ,
                        __( 'rotateIn' , "bizone" )           => 'rotateIn' ,
                        __( 'rotateInDownLeft' , "bizone" )   => 'rotateInDownLeft' ,
                        __( 'rotateInDownRight' , "bizone" )  => 'rotateInDownRight' ,
                        __( 'rotateInUpLeft' , "bizone" )     => 'rotateInUpLeft' ,
                        __( 'rotateInUpRight' , "bizone" )    => 'rotateInUpRight' ,
                        __( 'rotateOut' , "bizone" )          => 'rotateOut' ,
                        __( 'rotateOutDownLeft' , "bizone" )  => 'rotateOutDownLeft' ,
                        __( 'rotateOutDownRight' , "bizone" ) => 'rotateOutDownRight' ,
                        __( 'rotateOutUpLeft' , "bizone" )    => 'rotateOutUpLeft' ,
                        __( 'rotateOutUpRight' , "bizone" )   => 'rotateOutUpRight' ,
                        __( 'hinge' , "bizone" )              => 'hinge' ,
                        __( 'rollIn' , "bizone" )             => 'rollIn' ,
                        __( 'rollOut' , "bizone" )            => 'rollOut' ,
                        __( 'zoomIn' , "bizone" )             => 'zoomIn' ,
                        __( 'zoomInDown' , "bizone" )         => 'zoomInDown' ,
                        __( 'zoomInLeft' , "bizone" )         => 'zoomInLeft' ,
                        __( 'zoomInRight' , "bizone" )        => 'zoomInRight' ,
                        __( 'zoomInUp' , "bizone" )           => 'zoomInUp' ,
                        __( 'zoomOut' , "bizone" )            => 'zoomOut' ,
                        __( 'zoomOutDown' , "bizone" )        => 'zoomOutDown' ,
                        __( 'zoomOutLeft' , "bizone" )        => 'zoomOutLeft' ,
                        __( 'zoomOutRight' , "bizone" )       => 'zoomOutRight' ,
                        __( 'zoomOutUp' , "bizone" )          => 'zoomOutUp' ,
                        __( 'slideInDown' , "bizone" )        => 'slideInDown' ,
                        __( 'slideInLeft' , "bizone" )        => 'slideInLeft' ,
                        __( 'slideInRight' , "bizone" )       => 'slideInRight' ,
                        __( 'slideInUp' , "bizone" )          => 'slideInUp' ,
                        __( 'slideOutDown' , "bizone" )       => 'slideOutDown' ,
                        __( 'slideOutLeft' , "bizone" )       => 'slideOutLeft' ,
                        __( 'slideOutRight' , "bizone" )      => 'slideOutRight' ,
                        __( 'slideOutUp' , "bizone" )         => 'slideOutUp' ,
                    ) ,
                )
            );
            vc_add_param( 'vc_column_inner' , array(
                    "type"       => "dropdown" ,
                    "heading"    => __( 'Bravo Effect' , "bizone" ) ,
                    "param_name" => "row_effect" ,
                    "value"      => array(
                        __( '-- Select --' , "bizone" )             => '' ,
                        __( 'bounce' , "bizone" )             => 'bounce' ,
                        __( 'flash' , "bizone" )              => 'flash' ,
                        __( 'pulse' , "bizone" )              => 'flash' ,
                        __( 'rubberBand' , "bizone" )         => 'rubberBand' ,
                        __( 'shake' , "bizone" )              => 'shake' ,
                        __( 'headShake' , "bizone" )          => 'headShake' ,
                        __( 'swing' , "bizone" )              => 'swing' ,
                        __( 'tada' , "bizone" )               => 'tada' ,
                        __( 'wobble' , "bizone" )             => 'wobble' ,
                        __( 'jello' , "bizone" )              => 'jello' ,
                        __( 'bounceIn' , "bizone" )           => 'bounceIn' ,
                        __( 'bounceInDown' , "bizone" )       => 'bounceInDown' ,
                        __( 'bounceInLeft' , "bizone" )       => 'bounceInLeft' ,
                        __( 'bounceInRight' , "bizone" )      => 'bounceInRight' ,
                        __( 'bounceInUp' , "bizone" )         => 'bounceInUp' ,
                        __( 'bounceOut' , "bizone" )          => 'bounceOut' ,
                        __( 'bounceOutDown' , "bizone" )      => 'bounceOutDown' ,
                        __( 'bounceOutLeft' , "bizone" )      => 'bounceOutLeft' ,
                        __( 'bounceOutRight' , "bizone" )     => 'bounceOutRight' ,
                        __( 'bounceOutUp' , "bizone" )        => 'bounceOutUp' ,
                        __( 'fadeIn' , "bizone" )             => 'fadeIn' ,
                        __( 'fadeInDown' , "bizone" )         => 'fadeInDown' ,
                        __( 'fadeInDownBig' , "bizone" )      => 'fadeInDownBig' ,
                        __( 'fadeInLeft' , "bizone" )         => 'fadeInLeft' ,
                        __( 'fadeInLeftBig' , "bizone" )      => 'fadeInLeftBig' ,
                        __( 'fadeInRight' , "bizone" )        => 'fadeInRight' ,
                        __( 'fadeInRightBig' , "bizone" )     => 'fadeInRightBig' ,
                        __( 'fadeInUp' , "bizone" )           => 'fadeInUp' ,
                        __( 'fadeInUpBig' , "bizone" )        => 'fadeInUpBig' ,
                        __( 'fadeOut' , "bizone" )            => 'fadeOut' ,
                        __( 'fadeOutDown' , "bizone" )        => 'fadeOutDown' ,
                        __( 'fadeOutDownBig' , "bizone" )     => 'fadeOutDownBig' ,
                        __( 'fadeOutLeft' , "bizone" )        => 'fadeOutLeft' ,
                        __( 'fadeOutLeftBig' , "bizone" )     => 'fadeOutLeftBig' ,
                        __( 'fadeOutRight' , "bizone" )       => 'fadeOutRight' ,
                        __( 'fadeOutRightBig' , "bizone" )    => 'fadeOutRightBig' ,
                        __( 'fadeOutUp' , "bizone" )          => 'fadeOutUp' ,
                        __( 'fadeOutUpBig' , "bizone" )       => 'fadeOutUpBig' ,
                        __( 'flipInX' , "bizone" )            => 'flipInX' ,
                        __( 'flipInY' , "bizone" )            => 'flipInY' ,
                        __( 'flipOutX' , "bizone" )           => 'flipOutX' ,
                        __( 'flipOutY' , "bizone" )           => 'flipOutY' ,
                        __( 'lightSpeedIn' , "bizone" )       => 'lightSpeedIn' ,
                        __( 'lightSpeedOut' , "bizone" )      => 'lightSpeedOut' ,
                        __( 'rotateIn' , "bizone" )           => 'rotateIn' ,
                        __( 'rotateInDownLeft' , "bizone" )   => 'rotateInDownLeft' ,
                        __( 'rotateInDownRight' , "bizone" )  => 'rotateInDownRight' ,
                        __( 'rotateInUpLeft' , "bizone" )     => 'rotateInUpLeft' ,
                        __( 'rotateInUpRight' , "bizone" )    => 'rotateInUpRight' ,
                        __( 'rotateOut' , "bizone" )          => 'rotateOut' ,
                        __( 'rotateOutDownLeft' , "bizone" )  => 'rotateOutDownLeft' ,
                        __( 'rotateOutDownRight' , "bizone" ) => 'rotateOutDownRight' ,
                        __( 'rotateOutUpLeft' , "bizone" )    => 'rotateOutUpLeft' ,
                        __( 'rotateOutUpRight' , "bizone" )   => 'rotateOutUpRight' ,
                        __( 'hinge' , "bizone" )              => 'hinge' ,
                        __( 'rollIn' , "bizone" )             => 'rollIn' ,
                        __( 'rollOut' , "bizone" )            => 'rollOut' ,
                        __( 'zoomIn' , "bizone" )             => 'zoomIn' ,
                        __( 'zoomInDown' , "bizone" )         => 'zoomInDown' ,
                        __( 'zoomInLeft' , "bizone" )         => 'zoomInLeft' ,
                        __( 'zoomInRight' , "bizone" )        => 'zoomInRight' ,
                        __( 'zoomInUp' , "bizone" )           => 'zoomInUp' ,
                        __( 'zoomOut' , "bizone" )            => 'zoomOut' ,
                        __( 'zoomOutDown' , "bizone" )        => 'zoomOutDown' ,
                        __( 'zoomOutLeft' , "bizone" )        => 'zoomOutLeft' ,
                        __( 'zoomOutRight' , "bizone" )       => 'zoomOutRight' ,
                        __( 'zoomOutUp' , "bizone" )          => 'zoomOutUp' ,
                        __( 'slideInDown' , "bizone" )        => 'slideInDown' ,
                        __( 'slideInLeft' , "bizone" )        => 'slideInLeft' ,
                        __( 'slideInRight' , "bizone" )       => 'slideInRight' ,
                        __( 'slideInUp' , "bizone" )          => 'slideInUp' ,
                        __( 'slideOutDown' , "bizone" )       => 'slideOutDown' ,
                        __( 'slideOutLeft' , "bizone" )       => 'slideOutLeft' ,
                        __( 'slideOutRight' , "bizone" )      => 'slideOutRight' ,
                        __( 'slideOutUp' , "bizone" )         => 'slideOutUp' ,
                    ) ,
                )
            );


        }

        static function _add_metabox()
        {
            $my_meta_box = array(
                'id'       => 'bravo_page_metabox',
                'title'    =>esc_html__('Page Information', "bizone"),
                'desc'     => '',
                'pages'    => array('page'),
                'context'  => 'normal',
                'priority' => 'high',
                'fields'   => array(
                    array(
                        'label' => __( 'General' , "bizone" ) ,
                        'type'  => 'tab' ,
                        'id'    => 'gen_tab'
                    ) ,
                    array(
                        'id'          => 'enable_preload',
                        'label'       => __('Custom Preload',"bizone"),
                        'type'        => 'on-off',
                        'std'     => 'off'
                    ),
                    array(
                        'id'      => 'preload_style',
                        'label'   => esc_html__("Preload Style", "bizone"),
                        'type'    => 'select',

                        'condition' => 'enable_preload:is(on)' ,
                        'choices' => array(
                            array(
                                'value' => 'bounce',
                                'label' => esc_html__("Bounce", "bizone")
                            ),
                            array(
                                'value' => 'dot',
                                'label' => esc_html__("Dot", "bizone")
                            ),
                        )
                    ),
                    array(
                        'id'          => 'custom_menu',
                        'label'       => __('Custom Menu',"bizone"),
                        'type'        => 'on-off',
                        'std'     => 'off'
                    ),
                    array(
                        'id'      => 'menu_style',
                        'label'   => esc_html__("Menu Style", "bizone"),
                        'type'    => 'select',
                        'condition' => 'custom_menu:is(on)' ,
                        'choices' => array(
                            array(
                                'value' => 'style_1',
                                'label' => esc_html__("-- Style One --", "bizone")
                            ),
                            array(
                                'value' => 'style_2',
                                'label' => esc_html__("-- Style Two --", "bizone")
                            ),
                        )
                    ),
                    array(
                        'id'          => 'enable_affix',
                        'label'       => __('Menu affix setting',"bizone"),
                        'type'        => 'on-off',
                        'section'     => 'option_header',
                        'std'     => 'off',
                        'condition' => 'menu_style:is(style_1),custom_menu:is(on)' ,
                    ),
                )
            );

            /**
             * Register our meta boxes using the
             * ot_register_meta_box() function.
             */
            if (function_exists('ot_register_meta_box')) {
                ot_register_meta_box($my_meta_box);
            }
        }

        static function css_classes_for_vc_row_and_vc_column( $class_string , $tag )
        {
            if($tag == 'vc_row' || $tag == 'vc_row_inner') {
                $class_string = str_replace( 'vc_row-fluid' , '' , $class_string );
            }

            if(defined( 'WPB_VC_VERSION' )) {
                if(version_compare( WPB_VC_VERSION , '4.2.3' , '>' )) {
                    if($tag == 'vc_column' || $tag == 'vc_column_inner') {
                        //$class_string = preg_replace('/vc_span(\d{1,2})/', 'col-lg-$1', $class_string);
                        $class_string = str_replace( 'vc_col' , 'col' , $class_string );
                        $class_string = str_replace( 'col-sm' , 'col-md' , $class_string );
                    }
                } else {
                    if($tag == 'vc_column' || $tag == 'vc_column_inner') {
                        $class_string = preg_replace( '/vc_span(\d{1,2})/' , 'col-lg-$1' , $class_string );
                        $class_string = str_replace( 'col-sm' , 'col-md' , $class_string );
                    }
                }
            }

            return $class_string;
        }



    }

    BravoPage::_init();
}
