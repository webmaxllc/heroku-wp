<?php
if(!function_exists('bravo_pricing')) {
    vc_map( array(
        "name" => esc_html__("Bravo Pricing", "bizone"),
        "base" => "bravo_pricing",
        "as_parent" => array('only' => 'bravo_pricing_item'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "js_view" => 'VcColumnView',
        "category"  => 'Content',
        "params" => array(
        )
    ) );
    vc_map( array(
        "name"      => esc_html__("Bravo Pricing Item", "bizone"),
        "base"      => "bravo_pricing_item",
        "as_child" => array('only' => 'bravo_pricing'),
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
                "heading"   => esc_html__("Excerpt", "bizone"),
                "param_name"=> "excerpt",
                "description" => esc_html__("Excerpt", "bizone")
            ),
            array(
                "type"      => "textfield",
                "holder"    => "div",
                "class"     => "",
                "heading"   => esc_html__("Price", "bizone"),
                "param_name"=> "price",
                "description" => esc_html__("Price", "bizone")
            ),
            array(
                "type"        => "colorpicker",
                "heading"     => esc_html__("Color", "bizone"),
                "param_name"  => "color",
                'admin_label' => false,
            ),
            array(
                "type"        => "param_group",
                "heading"     => esc_html__("Pricing Feature", 'bizone'),
                "param_name"  => "social",
                'admin_label' => false,
                "params"   => array(
                    array(
                        "type"      => "textfield",
                        "heading"   => esc_html__("Title", "bizone"),
                        "param_name"=> "title",
                        "description" => esc_html__("Title", "bizone")
                    ),
                )
            ),
            array(
                "type"      => "textfield",
                "holder"    => "div",
                "class"     => "",
                "heading"   => esc_html__("Link", "bizone"),
                "param_name"=> "link",
                "description" => esc_html__("Link", "bizone")
            ),
        )));

    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_bravo_pricing extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                $html ='<div class="pricing pricing_tenzin">
                            '.do_shortcode($content).'
                        </div>';
                return $html;
            }
        }
    }

    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_bravo_pricing_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'title'=>'',
                    'excerpt'=>'',
                    'price'=>'',
                    'social'=>'',
                    'color'=>'#969696',
                    'link'=>'',
                ), $arg,'bravo_pricing_item');
                extract($data);
                $social = vc_param_group_parse_atts( $social );
                $html_pricing_feature = '';
                if(!empty($social)){
                    foreach($social as $k=>$v){
                        $html_pricing_feature .= ' <li class="pricing_feature">'.esc_html($v['title']).'</li>';
                    }
                }

                $class_color = BravoAssets::build_css('  background: '.esc_attr($color).' !important; ');
                $bd_color = BravoAssets::build_css('  border-color: '.esc_attr($color).' !important; ');


                $html ='
                    <div class="pricing_item '.esc_attr($bd_color).'">
                        <h3 class="pricing_title">'.esc_html($title).'</h3>
                        <div class="pricing_price"><span class="pricing_currency">$</span>'.esc_html($price).'</div>
                        <p class="pricing_sentence">'.esc_html($excerpt).'</p>
                        <ul class="pricing_list">
                            '.do_shortcode($html_pricing_feature).'
                        </ul>
                        <a class="pricing_action text-center '.esc_attr($class_color).'" href="'.esc_url($link).'">'.__("Choose plan","bizone").'</a>
                    </div>
                ';
                return $html;
            }
        }
    }
}


