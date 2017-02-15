<?php
/**
 * Created by PhpStorm.
 * User: MrHa
 * Date: 3/12/2015
 * Time: 9:22 AM
 */
if (!class_exists('BravoPortfolio')) {

	class BravoPortfolio
	{
		static $content;

		static function __init()
		{

			if (function_exists('bravo_reg_post_type')) {
				add_action('init', array(__CLASS__, '__register_post_type'));
			}

			add_action('init', array(__CLASS__, '__add_metabox'));
			add_action('init', array(__CLASS__, '_init_elements'));

			add_filter('bravo_get_sidebar', array(__CLASS__, '_service_filter_sidebar'));

		}

		static function _service_filter_sidebar($sidebar)
		{
			return $sidebar;
		}


		static function __register_post_type()
		{
			$labels = array(
				'name'               => esc_html__('Portfolio', "bizone"),
				'singular_name'      => esc_html__('Portfolio', "bizone"),
				'menu_name'          => esc_html__('Portfolio', "bizone"),
				'name_admin_bar'     => esc_html__('Portfolio', "bizone"),
				'add_new'            => esc_html__('Add New', "bizone"),
				'add_new_item'       => esc_html__('Add New Portfolio', "bizone"),
				'new_item'           => esc_html__('New Portfolio', "bizone"),
				'edit_item'          => esc_html__('Edit Portfolio', "bizone"),
				'view_item'          => esc_html__('View Portfolio', "bizone"),
				'all_items'          => esc_html__('All Portfolio', "bizone"),
				'search_items'       => esc_html__('Search Portfolio', "bizone"),
				'parent_item_colon'  => esc_html__('Parent Portfolio:', "bizone"),
				'not_found'          => esc_html__('No Portfolio found.', "bizone"),
				'not_found_in_trash' => esc_html__('No Portfolio found in Trash.', "bizone")
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array('slug' => 'bravo_portfolio'),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
				'menu_icon'          => 'dashicons-bravo-portfolio'
			);
			bravo_reg_post_type('bravo_portfolio', $args);



			$labels = array(
				'name'              => esc_html__('Portfolio Categories', "bizone"),
				'singular_name'     => esc_html__('Portfolio Category', "bizone"),
				'search_items'      => esc_html__('Search Portfolio Categories', "bizone"),
				'all_items'         => esc_html__('All Portfolio Categories', "bizone"),
				'parent_item'       => esc_html__('Parent Portfolio Category', "bizone"),
				'parent_item_colon' => esc_html__('Parent Portfolio Category:', "bizone"),
				'edit_item'         => esc_html__('Edit Portfolio Category', "bizone"),
				'update_item'       => esc_html__('Update Portfolio Category', "bizone"),
				'add_new_item'      => esc_html__('Add New Portfolio Category', "bizone"),
				'new_item_name'     => esc_html__('New Portfolio Category Name', "bizone"),
				'menu_name'         => esc_html__('Portfolio Category', "bizone"),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => 'bravo_portfolio_cat'),
			);

			bravo_reg_taxonomy('bravo_portfolio_cat', array('bravo_portfolio'), $args);


		}

		static function __add_metabox()
		{
			$my_meta_box = array(
				'id'       => 'bravo_portfolio_metabox',
				'title'    => esc_html__('Portfolio Options', "bizone"),
				'desc'     => '',
				'pages'    => array('bravo_portfolio'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => array(
					array(
						'label' => __( 'General' , "bizone" ) ,
						'type'  => 'tab' ,
						'id'    => 'gen_tab'
					) ,
					array(
						'label' => esc_html__('Size Item (%)', "bizone"),
						'id'    => 'size_item',
						'type'  => 'select',
                        'desc'        => esc_html__('Size Item (%)', "bizone"),
                        'choices'     => array(
                            array(
                                'value'       => 'size25',
                                'label'       => __( '-- 25% --', 'bizone' ),
                            ),
                            array(
                                'value'       => 'size50',
                                'label'       => __( '-- 50% --', 'bizone' ),
                            ),
                        )
					),
                    array(
                        'label' => esc_html__('Media Url', "bizone"),
                        'id'    => 'video',
                        'type'  => 'text',
                        'desc'        => esc_html__('Media Url', "bizone"),
                    ),

				)
			);


			/**
			 * Register our meta boxes using the
			 * ot_register_meta_box() function.
			 */
			if (function_exists('ot_register_meta_box')) {
				ot_register_meta_box($my_meta_box);
			}

		}

		static function _init_elements()
		{

		}

	}


	BravoPortfolio::__init();
}