<?php
if (!function_exists('bravo_facts_func')) {
	function bravo_facts_func($attr, $content = false)
	{
        $data = shortcode_atts(array(
            'title' => '1',
            'number'  => '',
            'icon'  => '',
            'color'  => '',
        ), $attr,'bravo_facts');
        extract($data);
        $class = BravoAssets::build_css('  background: '.esc_attr($color).'; ');
        $html = '
               <div class="facts">
               		<div class="number-counters">
						  <div class="text-center">
							<div class="counters-item '.esc_attr($class).' row">
							<i class="'.esc_attr($icon).'"></i>
							<h2><strong data-to="'.esc_attr($number).'">0</strong></h2>
							  <p>'.esc_html($title).'</p>
							</div>
						</div>
					</div>
				</div>';
        return $html;

    }
	bravo_reg_shortcode('bravo_facts', 'bravo_facts_func');
	vc_map(array(
		"name"     => esc_html__("Bravo Facts", "bizone"),
		"base"     => "bravo_facts",
		"category" => "CMSBlueTheme",
		"params"   => array(
			array(
				"type"        => "textfield",
				"heading"     => esc_html__("Title", "bizone"),
				"param_name"  => "title",
				'admin_label' => true
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__("Number", "bizone"),
				"param_name"  => "number",
				'admin_label' => true
			),
			array(
				"type"        => "iconpicker",
				"heading"     => esc_html__("Icon", 'bizone'),
				"param_name"  => "icon",
				'admin_label' => true,
				'settings' => array(
					'type' => 'fontawesome',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
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