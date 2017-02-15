<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/18/15
 * Time: 9:16 PM
 */

if (!function_exists('bravo_testimonial_func')) {
	function bravo_testimonial_func($attr, $content = false)
	{
		$data = shortcode_atts(array(
			'name' => '1',
			'position'  => '',
			'avatar'  => '',
			'excerpt'  => '',
			'social'  => '',
			'color'  => '',
		), $attr,'bravo_testimonial');
		extract($data);

        $social = vc_param_group_parse_atts( $social );
        $html_social = '';
        if(!empty($social)){
            foreach($social as $k=>$v){
                $html_social .= ' <li><a href="'.esc_url($v['link']).'" class="text-center"><i class="'.esc_attr($v['icon']).'"></i><span></span></a></li>';
            }
        }
        $class = BravoAssets::build_css('  background-color: '.esc_attr($color).' !important; ');
		$img = wp_get_attachment_image_src($avatar,'full');
		if(!empty($img)) $img = $img[0];
		$html = '<div class="thinkers text-center">
					<div class="thinker-wrap">
						  <div class="thinker-image">
							<img src="'.esc_url($img).'" alt="Richard" class="img-responsive">
							<div class="overlay '.esc_attr($class).'">
							  <div class="overlay-inner">
								 <ul class="social-link">
                                    '.do_shortcode($html_social).'
                                  </ul>
							  </div>
							</div>
						  </div>
						  <h3>'.esc_html($name).'</h3>
						  <small>'.esc_html($position).'</small>
						  <p>'.esc_html($excerpt).'</p>
						</div>
				</div>';
		return $html;
	}
	bravo_reg_shortcode('bravo_testimonial', 'bravo_testimonial_func');
	vc_map(array(
		"name"     => esc_html__("Bravo Testimonial", "bizone"),
		"base"     => "bravo_testimonial",
		"category" => "CMSBlueTheme",
		"params"   => array(
			array(
				"type"        => "textfield",
				"heading"     => esc_html__("Name", 'bizone'),
				"param_name"  => "name",
				'admin_label' => true
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__("Position", 'bizone'),
				"param_name"  => "position",
				'admin_label' => true
			),
			array(
				"type"      => "textarea",
				"heading"   => esc_html__("Excerpt", "bizone"),
				"param_name"=> "excerpt",
				"description" => esc_html__("Excerpt", "bizone"),
                'admin_label' => false
			),
			array(
				"type"      => "attach_image",
				"heading"   => esc_html__("Avatar", "bizone"),
				"param_name"=> "avatar",
				"description" => esc_html__("Avatar", "bizone"),
                'admin_label' => false
			),
			array(
				"type"        => "param_group",
				"heading"     => esc_html__("Social", 'bizone'),
				"param_name"  => "social",
				'admin_label' => false,
                "params"   => array(
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Icon", 'bizone'),
                        "param_name"  => "icon",
                        'admin_label' => true
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Link", "bizone"),
                        "param_name"  => "link",
                        'admin_label' => true
                    ),
                )
			),
			array(
				"type"        => "colorpicker",
				"heading"     => esc_html__("Color", "bizone"),
				"param_name"  => "color",
				'admin_label' => false
			),
		)
	));
}