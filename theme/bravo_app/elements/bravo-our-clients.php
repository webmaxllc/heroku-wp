<?php
if(!function_exists('bravo_our_clients')) {
    vc_map( array(
        "name" => esc_html__("Bravo Our Clients", "bizone"),
        "base" => "bravo_our_clients",
        "as_parent" => array('only' => 'bravo_our_clients_item'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "js_view" => 'VcColumnView',
        "category"  => 'Content',
        "params" => array(
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
        )
    ) );
    vc_map( array(
        "name"      => esc_html__("Bravo Our Clients Item", "bizone"),
        "base"      => "bravo_our_clients_item",
        "as_child" => array('only' => 'bravo_our_clients'),
        "content_element" => true,
        "params"    => array(
            array(
                "type"      => "textfield",
                "heading"   => esc_html__("Title", "bizone"),
                "param_name"=> "title",
                "description" => esc_html__("Title", "bizone")
            ),
            array(
                "type"      => "textarea",
                "heading"   => esc_html__("Content", "bizone"),
                "param_name"=> "content",
                "description" => esc_html__("Content", "bizone"),
                'admin_label' => false
            ),
            array(
                "type"      => "attach_image",
                "heading"   => esc_html__("Star rating", "bizone"),
                "param_name"=> "star",
                "description" => esc_html__("Star rating", "bizone"),
                'admin_label' => false
            ),


        )));

    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_bravo_our_clients extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'title'=>'',
                    'excerpt'=>'',
                ), $arg,'bravo_our_clients');
                extract($data);
                $html ='<div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="testinomial" class="content_testinomial padding text-center">
                                        <p class="title">'.esc_html($title).'</p>
                                        <h2 class="heading">'.esc_html($excerpt).'</h2>
                                        <div id="testinomial-slider" class="owl-carousel">
                                            '.do_shortcode($content).'
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>';
                return $html;
            }
        }
    }

    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_bravo_our_clients_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'title'=>'',
                    'star'=>'',
                ), $arg,'bravo_our_clients_item');
                extract($data);
                $content = do_shortcode($content);
                $img = wp_get_attachment_image_src($star,'full');
                if(!empty($img)) $img = $img[0];
                $html ='
                        <div class="item">
                            <p>'.do_shortcode($content).'</p>
                            <h5>'.esc_html($title).'</h5>
                            <img src="'.esc_url($img).'" alt="star rating"> 
                        </div>';
                return $html;
            }
        }
    }
}


