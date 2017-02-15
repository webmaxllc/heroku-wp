<?php
if (!function_exists('bravo_slogan_func')) {
	function bravo_slogan_func($attr, $content = false)
	{
        $data = shortcode_atts(array(
            'title' => '1',
            'link' => '1',
        ), $attr,'bravo_slogan');
        extract($data);
        $tp_link = vc_build_link( $link );
        $html = ' 
            <div class="slogan"> 
                <h5 class="hidden">hiddens</h5>
                <p class="pull-left">'.esc_html($title).'</p>
                <a class="pull-right bounce-top" href="'.esc_url($tp_link['url']).'">'.esc_html($tp_link['title']).'</a> 
            </div>
           ';
        return $html;
    }
	bravo_reg_shortcode('bravo_slogan', 'bravo_slogan_func');
	vc_map(array(
		"name"     => esc_html__("Bravo Slogan", "bizone"),
		"base"     => "bravo_slogan",
		"category" => "CMSBlueTheme",
		"params"   => array(
			array(
				"type"        => "textfield",
				"heading"     => esc_html__("Title", "bizone"),
				"param_name"  => "title",
				'admin_label' => true
			),
            array(
                "type"      => "vc_link",
                "heading"   => esc_html__("Link", "bizone"),
                "param_name"=> "link",
                "description" => esc_html__("Link", "bizone"),
                'admin_label' => false
            ),
		)
	));
}