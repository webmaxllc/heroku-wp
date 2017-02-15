<?php

if (!function_exists('bravo_portfolio_func')) {
	function bravo_portfolio_func($attr, $content = false)
	{
		$attr = wp_parse_args($attr, array(
			'title' => '',
			'excerpt' => '',
			'number' => '6',
			'bravo_category'  => '',
			'order'  => 'asc',
			'orderby'  => 'none',
		));
		return BravoTemplate::load_view('elements/bravo-portfolio', false, $attr);
	}

	bravo_reg_shortcode('bravo_portfolio', 'bravo_portfolio_func');

	vc_map(array(
		"name"     => esc_html__("Bravo Portfolio", "bizone"),
		"base"     => "bravo_portfolio",
		"category" => "CMSBlueTheme",
		"params"   => array(
            array(
                "type"        => "textfield",
                "heading"     => esc_html__("Title", "bizone"),
                "param_name"  => "title",
                'admin_label' => true,
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
                "type"        => "textfield",
                "heading"     => esc_html__("Number", "bizone"),
                "param_name"  => "number",
                'admin_label' => true,
            ),
			array(
				"type" => "checkbox",
				"holder" => "div",
				"class" => "",
				"heading" => __("Category", "bizone"),
				"param_name" => "bravo_category",
				"value" => bravo_get_list_taxonomy('bravo_portfolio_cat'),
				"description" => __("<em>Tick 'All Categories' if you want to show portfolios of all Categories</em>", "bizone")
			),
			array(
				"type"             => "dropdown" ,
				"holder"           => "div" ,
				"heading"          => __( "Order" , "bizone" ) ,
				"param_name"       => "order" ,
				'value'            => array(
					__( 'Asc' , "bizone" )  => 'asc' ,
					__( 'Desc' , "bizone" ) => 'desc'
				) ,
				'edit_field_class' => 'vc_col-sm-6' ,
			) ,
			array(
				"type"             => "dropdown" ,
				"holder"           => "div" ,
				"heading"          => __( "Order By" , "bizone" ) ,
				"param_name"       => "orderby" ,
				"value"            => array(
					__( 'None' , "bizone" )          => 'none' ,
					__( 'ID' , "bizone" )            => 'ID' ,
					__( 'Author' , "bizone" )        => 'author' ,
					__( 'Title' , "bizone" )         => 'title' ,
					__( 'Name' , "bizone" )          => 'name' ,
					__( 'Type' , "bizone" )          => 'type' ,
					__( 'Date' , "bizone" )          => 'date' ,
					__( 'Modified' , "bizone" )      => 'modified' ,
					__( 'Parent' , "bizone" )        => 'parent' ,
					__( 'Rand' , "bizone" )          => 'rand' ,
					__( 'Comment Count' , "bizone" ) => 'comment_count' ,
				) ,
				'edit_field_class' => 'vc_col-sm-6' ,
			) ,

		)
	));
}