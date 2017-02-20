<?php

/**
 * Class MortgageWareSettings
 */
class MortgageWareSettings
{

    /**
     * Settings Menu
     */
    public static function settingsMenu()
    {
        add_menu_page('MortgageWare Plugin Settings', 'MortgageWare', 'administrator', __FILE__, 'MortgageWareSettings::settingsPage' , 'dashicons-admin-multisite' );
        //add_options_page( 'MortgageWare Plugin Settings', 'MortgageWare', 'administrator', 'MW_', 'MortgageWareSettings::options' );
        add_action( 'admin_init', 'MortgageWareSettings::registerSettings');
    }

    /**
     * Register Plugin Settings
     */
    public static function registerSettings()
    {
        register_setting( 'mortgageware-settings-group', 'mw_api_debugging');
        register_setting( 'mortgageware-settings-group', 'mw_loan_officer_id' );
        register_setting( 'mortgageware-settings-group', 'mw_site_id' );
        register_setting( 'mortgageware-settings-group', 'mw_api_url' );
        register_setting( 'mortgageware-settings-group', 'mw_api_key' );
        register_setting( 'mortgageware-settings-group', 'mw_client_id' );
        register_setting( 'mortgageware-settings-group', 'mw_client_secret' );
        register_setting( 'mortgageware-settings-group', 'mw_grant_type' );
        register_setting( 'mortgageware-settings-group', 'mw_has_sidebar' );
    }

    /**
     * Settings Page
     */
    public static function settingsPage()
    {
        echo '<div class="wrap">';
        require_once __DIR__.'/../form/settings.php';
        echo '</div>';
    }
}
