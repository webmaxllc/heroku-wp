<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/18/15
 * Time: 9:16 PM
 */

if (!function_exists('bravo_we_do_func')) {
	function bravo_we_do_func($attr, $content = false)
	{
        $data = shortcode_atts(array(
            'title' => '',
            'icon'  => '',
            'color'  => '',
            'link_color'  => '',
            'link'  => '',
        ), $attr,'bravo_we_do');
        extract($data);
        $class = BravoAssets::build_css('  background: '.esc_attr($color).'; ');
        $class_color = BravoAssets::build_css('  color: '.esc_attr($color).' !important; ');
        $class_color2 = BravoAssets::build_css('  
                                                    background: '.esc_attr($color).' !important;
                                                 ',':hover::before');
        if($link_color != 'yes'){
            $class_color = '';
        }
		$tp_link = vc_build_link( $link );
		$html = '<div class="we-do">
					<div class="do-wrap text-center">
						  <div class="'.esc_attr($class).' top"></div>
						  <span class="'.esc_attr($class).'"><i class="'.esc_attr($icon).'"></i></span>
						  <h4>'.esc_html($title).'</h4>
						  <p>'.do_shortcode($content).'</p>
						  <a href="'.esc_url($tp_link['url']).'" class="readmore '.esc_attr($class_color).' '.esc_attr($class_color2).'">'.esc_html($tp_link['title']).'</a>
					 </div>
				</div>';
        return $html;

    }
	bravo_reg_shortcode('bravo_we_do', 'bravo_we_do_func');
	vc_map(array(
		"name"     => esc_html__("Bravo We Do", "bizone"),
		"base"     => "bravo_we_do",
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
				"type"      => "vc_link",
				"heading"   => esc_html__("Link", "bizone"),
				"param_name"=> "link",
				"description" => esc_html__("Link", "bizone"),
                'admin_label' => false
			),
            array(
                "type"      => "dropdown",
                "heading"   => esc_html__("Color Button Link", "bizone"),
                "param_name"=> "link_color",
                "description" => esc_html__("Color Button Link", "bizone"),
                'admin_label' => false,
                'value'            => array(
                    __( 'No' , "bizone" )  => 'no' ,
                    __( 'Yes' , "bizone" ) => 'yes'
                ) ,
            ),

            array(
                "type"        => "colorpicker",
                "heading"     => esc_html__("Color", "bizone"),
                "param_name"  => "color",
                'admin_label' => false
            )
		)
	));
}