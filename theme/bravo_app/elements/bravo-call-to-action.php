<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/18/15
 * Time: 9:16 PM
 */

if (!function_exists('bravo_choose_func')) {
	function bravo_call_to_action_func($attr, $content = false)
	{
		$data = shortcode_atts(array(
			'title' => '',
			'link'  => '',
			'sub_title'  => '',
		), $attr,'bravo_call_to_action');
		extract($data);
		$link  = vc_build_link( $link );
		return '<section id="bg-paralax">
                      <div class="container">
                            <div class="row">
                                  <div class="col-md-12 text-center">
                                    <p>'.esc_html($sub_title).'</p>
                                    <h2 class="magin30">'.esc_html($title).'</h2>
                                    <a class="btn-green btn-common bounce-top page-scroll" href="'.esc_url($link['url']).'">'.esc_html($link['title']).'</a>
                                  </div>
                            </div>
                      </div>
                </section>';
	}
	bravo_reg_shortcode('bravo_call_to_action', 'bravo_call_to_action_func');
	vc_map(array(
		"name"     => esc_html__("Bravo Call To Action", "bizone"),
		"base"     => "bravo_call_to_action",
		"category" => "CMSBlueTheme",
		"params"   => array(
			array(
				"type"        => "textfield",
				"heading"     => esc_html__("Title", "bizone"),
				"param_name"  => "title",
				'admin_label' => true
			),
			array(
				"type"      => "textarea",
				"holder"    => "div",
				"class"     => "",
				"heading"   => esc_html__("Sub Title", "bizone"),
				"param_name"=> "sub_title",
				"value"     => "",
				"description" => esc_html__("content", "bizone")
			),
			array(
				"type"      => "vc_link",
				"holder"    => "div",
				"heading"   => esc_html__("Link", "bizone"),
				"param_name"=> "link",
			),
		)
	));
}