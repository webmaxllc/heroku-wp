<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/18/15
 * Time: 9:16 PM
 */

if (!function_exists('bravo_about_func')) {
	function bravo_about_func($attr, $content = false)
	{
        $data = shortcode_atts(array(
            'title' => '1',
            'icon'  => '',
            'color'  => '',
			'icon_type'=>false
        ), $attr,'bravo_about');
        extract($data);
        $class = BravoAssets::build_css('  color: '.esc_attr($color).'; ',' .color_about');
        $class2 = BravoAssets::build_css('  color: '.esc_attr($color).' !important; ',':hover .color_about');

        $html = ' 
            <div class="item_about canvas-box magin30 text-center wow '.esc_attr($class).' '.esc_attr($class2).'">
                <span class="text-center"><i class="'.esc_attr($icon).' color_about"></i></span>
                <h4 class="color_about">'.esc_html($title).'</h4>
                <p>'.do_shortcode($content).'</p>
            </div>';
        return $html;

    }
	bravo_reg_shortcode('bravo_about', 'bravo_about_func');
	vc_map(array(
		"name"     => esc_html__("Bravo About", "bizone"),
		"base"     => "bravo_about",
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
				"heading"     => esc_html__("Content", "bizone"),
				"param_name"  => "content",
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