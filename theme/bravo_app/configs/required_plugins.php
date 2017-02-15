<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/28/15
 * Time: 8:17 PM
 */


/**
 * List all required plugins for themes
 *
 * @see BravoRequiredPlugins::register_required_plugins();
 *
 *
 * */
$config['required_plugins'] = array(
    array(
        'name'     => 'Option Tree', // The plugin name.
        'slug'     => 'option-tree', // The plugin slug (typically the folder name).
        'required' => true, // If false, the plugin is only 'recommended' instead of required.
    ),
    array(
        'name'     => 'Contact Form 7',
        'slug'     => 'contact-form-7',
        'required' => true,
    ),
    array(
        'name'     => 'Visual Composer',
        'slug'     => 'js_composer',
        'required' => true,
        'source'   =>  esc_url('http://bravotheme.com/demo/plugin/js_composer.zip')
    ),
    array(
        'name'     => 'cmsBlue Toolkit',
        'slug'     => 'cmsblue-toolkit',
        'required' => true,
        'source'   => esc_url('http://premiumbluethemes.com/WordPress/wp_smarty/files/cmsblue-toolkit1.1.3.zip')
    ),
    array(
        'name'     => 'Revolution Sliders',
        'slug'     => 'revslider',
        'required' => true,
        'source'   => esc_url('http://bravotheme.com/plugins/revslider.zip')
    ),
);