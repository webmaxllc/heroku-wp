<?php
if(!function_exists('bravo_list_notype')) {
    vc_map( array(
        "name" => esc_html__("Bravo Experties", "bizone"),
        "base" => "bravo_experties",
        "as_parent" => array('only' => 'bravo_experties_item'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "js_view" => 'VcColumnView',
        "category"  => 'Content',
        "params" => array(
        )
    ) );
    vc_map( array(
        "name"      => esc_html__("Bravo Experties Item", "bizone"),
        "base"      => "bravo_experties_item",
        "as_child" => array('only' => 'bravo_experties'),
        "content_element" => true,
        "params"    => array(
            array(
                "type"      => "textfield",
                "holder"    => "div",
                "class"     => "",
                "heading"   => esc_html__("Title", "bizone"),
                "param_name"=> "title",
                "description" => esc_html__("Title", "bizone")
            ),
            array(
                "type"      => "textfield",
                "holder"    => "div",
                "class"     => "",
                "heading"   => esc_html__("Number", "bizone"),
                "param_name"=> "number",
                "description" => esc_html__("Number", "bizone")
            ),
            array(
                "type"        => "colorpicker",
                "heading"     => esc_html__("Color", "bizone"),
                "param_name"  => "color",
                'admin_label' => true
            ),

        )));

    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_bravo_experties extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'title'=>'',
                ), $arg,'bravo_experties');
                extract($data);
                $html ='<div class="some clearfix text-center">
                            '.do_shortcode($content).'
                      </div>';
                return $html;
            }
        }
    }

    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_bravo_experties_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'title'=>'',
                    'number'=>'',
                    'color'=>'',
                ), $arg,'bravo_experties_item');
                extract($data);
                $html ='
                <div class="myStat2" data-text="'.esc_attr($number).'%" data-width="10" data-fontsize="14" data-percent="86" data-fgcolor="'.esc_attr($color).'" data-bgcolor="#eee" data-bordersize="15">
                      <p>'.esc_html($title).'</p>
                </div>';
                return $html;
            }
        }
    }
}


