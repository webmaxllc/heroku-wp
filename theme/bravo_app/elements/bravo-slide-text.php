<?php
if(!function_exists('bravo_list_notype')) {
    vc_map( array(
        "name" => esc_html__("Bravo Slide Banner Text", "bizone"),
        "base" => "bravo_slide_banner_text",
        "as_parent" => array('only' => 'bravo_slide_banner_text_item'),
        "content_element" => true,
        "show_settings_on_create" => true,
        "js_view" => 'VcColumnView',
        "category"  => 'Content',
        "params" => array(
            array(
                "type"      => "attach_image",
                "heading"   => esc_html__("Background", "bizone"),
                "param_name"=> "bg",
                "description" => esc_html__("Background", "bizone"),
                'admin_label' => false
            ),
        )
    ) );
    vc_map( array(
        "name"      => esc_html__("Bravo Banner Text Item", "bizone"),
        "base"      => "bravo_slide_banner_text_item",
        "as_child" => array('only' => 'slide_banner_text'),
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
                "type"      => "textarea",
                "heading"   => esc_html__("Excerpt", "bizone"),
                "param_name"=> "excerpt",
                "description" => esc_html__("Excerpt", "bizone"),
                'admin_label' => false
            ),
        )));

    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_bravo_slide_banner_text extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'bg'=>'',
                ), $arg,'bravo_slide_banner_text');
                extract($data);


                $img = wp_get_attachment_image_src($bg,'full');
                if(!empty($img)) $img = $img[0];
                $class = BravoAssets::build_css('  background:url("'.esc_attr($img).'"); ');
                $html ='<section class="text-rotator '.esc_attr($class).'">
                          <div class="container">
                            <div class="row">
                              <div class="col-md-12">
                                  <div id="paralax-slider"  class="owl-carousel paralax-slider">
                                        '.do_shortcode($content).'
                                  </div>
                              </div>
                            </div>
                          </div>
                        </section>';
                return $html;
            }
        }
    }

    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_bravo_slide_banner_text_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(array(
                    'title'=>'',
                    'excerpt'=>'',
                ), $arg,'bravo_slide_banner_text_item');
                extract($data);
                $html =' <div class="item">
                              <div class="item-content text-center">
                                <p>'.esc_html($title).'</p>
                                <h2>'.do_shortcode($excerpt).'</h2>
                              </div>
                         </div>';
                return $html;
            }
        }
    }
}


