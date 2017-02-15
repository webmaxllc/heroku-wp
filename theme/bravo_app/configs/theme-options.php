<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/28/15
 * Time: 7:01 PM
 */

/**
 *
 * List all theme options fields
 *
 * @see BravoOptiontree::_add_themeoptions();
 *
 *
 * */
$config['theme_options'] = array(
	'sections' => array(
		array(
			'id'    => 'option_general',
			'title' => esc_html__('General Options', "bizone")
		),
		array(
			'id'    => 'option_header',
			'title' => esc_html__('Menu Options', "bizone")
		),
		array(
			'id'    => 'option_post',
			'title' => esc_html__('Posts Options', "bizone")
		),
		array(
			'id'    => 'option_style',
			'title' => esc_html__('Styling Options', "bizone")
		),
	),
	'settings' => array(
		/*----------------Begin General --------------------*/


		array(
			'id'      => 'logo',
			'label'   => esc_html__('Logo', "bizone"),
			'desc'    => esc_html__('This allow you to change logo', "bizone"),
			'type'    => 'upload',
			'section' => 'option_general',
			'std'     => BravoAssets::url() . 'images/logo.png'
		),
		array(
			'id'      => 'logo_white',
			'label'   => esc_html__('Logo white', "bizone"),
			'desc'    => esc_html__('This allow you to change logo white', "bizone"),
			'type'    => 'upload',
			'section' => 'option_general',
			'std'     => BravoAssets::url() . 'images/logo-white.png'
		),

		array(
			'id'      => 'logo_retina',
			'label'   => esc_html__('Logo Retina', "bizone"),
			'desc'    => esc_html__('Note: You MUST re-name Logo Retina to logo-name@2x.ext-name. Example:<br>
                                    Logo is: <em>my-logo.jpg</em><br>Logo Retina must be: <em>my-logo@2x.jpg</em>  ', "bizone"),
			'type'    => 'upload',
			'section' => 'option_general',
		),
        array(
            'id'        => 'footer_copyright',
            'label'     => esc_html__('Footer Copy Right', "bizone"),
            'type'      => 'textarea_simple',
            'section'   => 'option_general',
            'rows'=>2
        ),

		/*----------------End General ----------------------*/

		/*----------------Begin Header ---------------------- */
        array(
            'id'      => 'menu_style',
            'label'   => esc_html__("Menu Style", "bizone"),
            'type'    => 'select',
            'section' => 'option_header',
            'choices' => array(
                array(
                    'value' => 'style_1',
                    'label' => esc_html__("-- Style One --", "bizone")
                ),
                array(
                    'value' => 'style_2',
                    'label' => esc_html__("-- Style Two --", "bizone")
                ),
            )
        ),
        array(
            'id'          => 'enable_affix',
            'label'       => __('Menu affix setting',"bizone"),
            'type'        => 'on-off',
            'section'     => 'option_header',
            'std'     => 'off',
            'condition' => 'menu_style:is(style_1)' ,
        ),
        array(
			'id'      => 'social_menu',
			'label'    => esc_html__("Social Menu", "bizone"),
			'desc'     => esc_html__("Social Menu", "bizone"),
			'type'     => 'list-item',
			'section'  => 'option_header',
			'settings' => array(
				array(
					'id'    => 'icon',
					'label' => esc_html__("Icon", "bizone"),
					'type'  => 'text',
				),
                array(
                    'id'      => 'icon',
                    'label'   => esc_html__("Share", "bizone"),
                    'type'    => 'select',
                    'section' => 'option_header',
                    'choices' => array(
                        array(
                            'value' => 'fa fa-facebook',
                            'label' => esc_html__("Facebook", "bizone")
                        ),
                        array(
                            'value' => 'fa fa-twitter',
                            'label' => esc_html__("Twitter", "bizone")
                        ),
                        array(
                            'value' => 'icon-instagram',
                            'label' => esc_html__("Instagram", "bizone")
                        ),
                        array(
                            'value' => 'fa fa-google-plus',
                            'label' => esc_html__("Google", "bizone")
                        ),
                    )
                ),
                array(
                    'id'    => 'link',
                    'label' => esc_html__("Link", "bizone"),
                    'type'  => 'text',
                ),
			)
		),

		/*----------------End Header ----------------------*/



		/*----------------Begin  Styling ----------------------*/
        //preloader
        array(
            'id'          => 'enable_preload',
            'label'       => __('Preload setting',"bizone"),
            'type'        => 'on-off',
            'section'     => 'option_style',
            'std'     => 'off'
        ),
        array(
            'id'      => 'preload_style',
            'label'   => esc_html__("Preload Style", "bizone"),
            'type'    => 'select',
            'section' => 'option_style',
            'condition' => 'enable_preload:is(on)' ,
            'choices' => array(
                array(
                    'value' => 'bounce',
                    'label' => esc_html__("Bounce", "bizone")
                ),
                array(
                    'value' => 'dot',
                    'label' => esc_html__("Dot", "bizone")
                ),
            )
        ),
		array(
			'id'      => 'main_color',
			'label'   => esc_html__('Main Color', "bizone"),
			'desc'    => esc_html__('Choose your own main color', "bizone"),
			'type'    => 'colorpicker',
			'section' => 'option_style',
			'std'     => '#82b440'
		),
		array(
			'id'      => 'google_fonts',
			'label'   => esc_html__('Google Fonts', "bizone"),
			'desc'    => esc_html__('Google Fonts', "bizone"),
			'type'    => 'google-fonts',
			'section' => 'option_style'
		),
		array(
			'id'      => 'body_font',
			'label'   => esc_html__("Typography", "bizone"),
			'desc'    => esc_html__("Typography", "bizone"),
			'type'    => 'typography',
			'section' => 'option_style',
			'output'  => 'body,p'
		),
		array(
			'id'      => 'heading_font',
			'label'   => esc_html__("Heading Font", "bizone"),
			'desc'    => esc_html__("Heading Font", "bizone"),
			'type'    => 'typography',
			'section' => 'option_style',
			'output'  => 'h1,h2,h3,h4,h5'
		),
		array(
			'id'      => 'style_custom_css',
			'label'   => esc_html__('Custom CSS', "bizone"),
			'desc'    => esc_html__('Custom CSS', "bizone"),
			'type'    => 'css',
			'section' => 'option_style',
		),
		/*----------------End Styling ----------------------*/
		/*----------------Begin Posts Options ----------------------*/
		array(
			'id'      => 'post_blog_tab',
			'label'   => esc_html__('Blog Options', "bizone"),
			'type'    => 'tab',
			'section' => 'option_post'
		),
		array(
			'id'      => 'enable_head_page',
			'label'   => esc_html__('Enable Banner ?', "bizone"),
			'type'    => 'on-off',
			'std'     => 'off',
			'section' => 'option_post'
		),
		array(
			'id'      => 'post_blog_title',
			'label'   => esc_html__('Blog page title', "bizone"),
			'type'    => 'text',
			'std'     => 'Blog',
			'section' => 'option_post',
			'condition' => 'enable_head_page:is(on)' ,
		),
        array(
            'id'      => 'post_blog_sub_title',
            'label'   => esc_html__('Sub page title', "bizone"),
            'type'    => 'text',
            'std'     => '',
            'section' => 'option_post',
            'condition' => 'enable_head_page:is(on)' ,
        ),
		array(
			'id'      => 'blog_background_image',
			'label'   => esc_html__('Blog page background image', "bizone"),
			'desc'    => esc_html__('Blog page background image', "bizone"),
			'type'    => 'upload',
			'std'     => '',
			'section' => 'option_post',
			'condition' => 'enable_head_page:is(on)' ,
		),
		array(
			'id'      => 'page_sidebar_pos',
			'label'   => esc_html__("Sidebar Position", "bizone"),
			'type'    => 'select',
			'section' => 'option_post',
			'choices' => array(
				array(
					'value' => 'no',
					'label' => esc_html__("No Sidebar", "bizone")
				),
				array(
					'value' => 'left',
					'label' => esc_html__("Sidebar Left", "bizone")
				),
				array(
					'value' => 'right',
					'label' => esc_html__("Sidebar Right", "bizone")
				),
			)
		),
		array(
			'id'      => 'page_sidebar_id',
			'label'   => esc_html__("Widget Area Selection", "bizone"),
			'type'    => 'sidebar-select',
			'section' => 'option_post',
			'std'     => 'blog-sidebar'
		),


        array(
            'id'      => 'post_page_tab',
            'label'   => esc_html__('Page Options', "bizone"),
            'type'    => 'tab',
            'section' => 'option_post'
        ),
        array(
            'id'      => 'enable_head_single_page',
            'label'   => esc_html__('Enable Banner ?', "bizone"),
            'type'    => 'on-off',
            'std'     => 'off',
            'section' => 'option_post'
        ),
        array(
            'id'      => 'post_page_title',
            'label'   => esc_html__('Blog page title', "bizone"),
            'type'    => 'text',
            'std'     => 'Blog',
            'section' => 'option_post',
            'condition' => 'enable_head_single_page:is(on)' ,
        ),
        array(
            'id'      => 'post_page_sub_title',
            'label'   => esc_html__('Sub page title', "bizone"),
            'type'    => 'text',
            'std'     => '',
            'section' => 'option_post',
            'condition' => 'enable_head_single_page:is(on)' ,
        ),
        array(
            'id'      => 'page_background_image',
            'label'   => esc_html__('Blog page background image', "bizone"),
            'desc'    => esc_html__('Blog page background image', "bizone"),
            'type'    => 'upload',
            'std'     => '',
            'section' => 'option_post',
            'condition' => 'enable_head_single_page:is(on)' ,
        ),

		/*----------------End Posts Options ----------------------*/

		/*----------------Option Departments  ----------------------*/
		array(
			'id'      => 'head_departments_tab',
			'label'   => esc_html__('Banner Options', "bizone"),
			'type'    => 'tab',
			'section' => 'option_departments'
		),

		array(
			'id'      => 'enable_head_departments',
			'label'   => esc_html__('Enable Banner ?', "bizone"),
			'type'    => 'on-off',
			'std'     => 'off',
			'section' => 'option_departments'
		),
		array(
			'id'      => 'head_departments_title',
			'label'   => esc_html__('Departments page title', "bizone"),
			'type'    => 'text',
			'std'     => '',
			'section' => 'option_departments',
			'condition' => 'enable_head_departments:is(on)' ,
		),
		array(
			'id'      => 'head_departments_image',
			'label'   => esc_html__('Departments page background image', "bizone"),
			'desc'    => esc_html__('Departments page background image', "bizone"),
			'type'    => 'upload',
			'std'     => '',
			'section' => 'option_departments',
			'condition' => 'enable_head_departments:is(on)' ,
		),
		array(
			'id'      => 'departments_tab',
			'label'   => esc_html__('Departments Options', "bizone"),
			'type'    => 'tab',
			'section' => 'option_departments'
		),
		array(
			'id'      => 'departments_single_sidebar_pos',
			'label'   => esc_html__("Sidebar Position", "bizone"),
			'type'    => 'select',
			'section' => 'option_departments',
			'choices' => array(
				array(
					'value' => 'no',
					'label' => esc_html__("No Sidebar", "bizone")
				),
				array(
					'value' => 'left',
					'label' => esc_html__("Sidebar Left", "bizone")
				),
				array(
					'value' => 'right',
					'label' => esc_html__("Sidebar Right", "bizone")
				),
			)
		),
		array(
			'id'      => 'departments_single_sidebar_id',
			'label'   => esc_html__("Widget Area Selection", "bizone"),
			'type'    => 'sidebar-select',
			'section' => 'option_departments',
			'std'     => 'blog-sidebar'
		),
		/*----------------End Option Departments ----------------------*/

		/*----------------Option Departments  ----------------------*/
		array(
			'id'      => 'head_gallery_tab',
			'label'   => esc_html__('Banner Options', "bizone"),
			'type'    => 'tab',
			'section' => 'option_gallery'
		),

		array(
			'id'      => 'enable_head_gallery',
			'label'   => esc_html__('Enable Banner ?', "bizone"),
			'type'    => 'on-off',
			'std'     => 'off',
			'section' => 'option_gallery'
		),
		array(
			'id'      => 'head_gallery_title',
			'label'   => esc_html__('Gallery page title', "bizone"),
			'type'    => 'text',
			'std'     => '',
			'section' => 'option_gallery',
			'condition' => 'enable_head_gallery:is(on)' ,
		),
		array(
			'id'      => 'head_gallery_image',
			'label'   => esc_html__('Gallery page background image', "bizone"),
			'desc'    => esc_html__('Gallery page background image', "bizone"),
			'type'    => 'upload',
			'std'     => '',
			'section' => 'option_gallery',
			'condition' => 'enable_head_gallery:is(on)' ,
		),
		/*----------------End Option Departments ----------------------*/



	)
);
