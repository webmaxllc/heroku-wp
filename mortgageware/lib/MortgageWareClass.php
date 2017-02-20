<?php

/**
 * Class MortgageWare
 */

class MortgageWare
{

    /**
     * Timezones
     * @var array
     */
    public static $timezones = array(
        'America' => array(
            'America/Adak' => 'Adak',
            'America/Anchorage' => 'Anchorage',
            'America/Chicago' => 'Chicago',
            'America/Denver' => 'Denver',
            'America/Los_Angeles' => 'Los Angeles',
            'America/New_York' => 'New York',
            'America/Phoenix' => 'Phoenix'
        ),
        'Pacific' => array(
            'Pacific/Honolulu' => 'Honolulu'
        )
    );

    /**
     * Set WordPress Short Code
     * @param $atts
     * @param null $content
     * @param $tag
     * @return string
     */
    public static function shortcode($atts = [], $content = null, $tag = '')
    {
        ob_start();

        define("MW_SITE_ID",$atts['site']);
        define("MW_LOAN_OFFICER_ID",$atts['lo']);
        $_SESSION['MW_SITE_ID'] = $atts['site'];
        $_SESSION['MW_LOAN_OFFICER_ID'] = $atts['lo'];

        self::init();

        return ob_get_clean();
    }

    /**
     * Define the WordPress Actions
     */
    public static function defineActions()
    {
        add_shortcode( 'mw-1003', 'MortgageWare::shortcode' );

        /**
         * Plugin Settings Menu
         */
        add_action( 'admin_menu', 'MortgageWareSettings::settingsMenu' );

        /**
         * Home
         */
        add_action( 'wp_ajax_mw_home_ajax', 'MortgageWare::homeAjax' );
        add_action( 'wp_ajax_nopriv_mw_home_ajax', 'MortgageWare:homeAjax' );


        /**
         * Register
         */
        add_action( 'wp_ajax_mw_register_ajax', 'MortgageWareUser::registerAjax' );
        add_action( 'wp_ajax_nopriv_mw_register_ajax', 'MortgageWareUser::registerAjax' );

        /**
         * Login
         */
        add_action( 'wp_ajax_mw_login_ajax', 'MortgageWareUser::loginAjax' );
        add_action( 'wp_ajax_nopriv_mw_login_ajax', 'MortgageWareUser::loginAjax' );

        /**
         * Logged In
         */
        add_action( 'wp_ajax_mw_logged_in_ajax', 'MortgageWareUser::loggedInAjax' );
        add_action( 'wp_ajax_nopriv_mw_logged_in_ajax', 'MortgageWareUser::loggedInAjax' );

        /**
         * Forgot Password Form
         */
        add_action( 'wp_ajax_mw_forgot_password_form_ajax', 'MortgageWareUser::forgotPasswordFormAjax' );
        add_action( 'wp_ajax_nopriv_mw_forgot_password_form_ajax', 'MortgageWareUser::forgotPasswordFormAjax' );

        /**
         * Forgot Password
         */
        add_action( 'wp_ajax_mw_forgot_password_ajax', 'MortgageWareUser::forgotPasswordAjax' );
        add_action( 'wp_ajax_nopriv_mw_forgot_password_ajax', 'MortgageWareUser::forgotPasswordAjax' );

        /**
         * Reset Password
         */
        add_action( 'wp_ajax_mw_reset_password_ajax', 'MortgageWareUser::resetPasswordAjax' );
        add_action( 'wp_ajax_nopriv_mw_reset_password_ajax', 'MortgageWareUser::resetPasswordAjax' );


        /**
         * Check Session
         */
        add_action( 'wp_ajax_mw_session_check_ajax', 'MortgageWare::checkSessionAjax' );
        add_action( 'wp_ajax_nopriv_mw_session_check_ajax', 'MortgageWare::checkSessionAjax' );

        /**
         * View Loans
         */
        add_action( 'wp_ajax_mw_view_loans_ajax', 'MortgageWareLoan::viewLoansAjax' );
        add_action( 'wp_ajax_nopriv_mw_view_loans_ajax', 'MortgageWareLoan::viewLoansAjax' );

        /**
         * New Loan Application
         */
        add_action( 'wp_ajax_mw_new_loan_application_ajax', 'MortgageWareLoan::newLoanApplicationAjax' );
        add_action( 'wp_ajax_nopriv_mw_new_loan_application_ajax', 'MortgageWareLoan::newLoanApplicationAjax' );

        /**
         * View Loan App
         */
        add_action( 'wp_ajax_mw_view_loan_app_ajax', 'MortgageWareLoan::viewLoanAppAjax' );
        add_action( 'wp_ajax_nopriv_mw_view_loan_app_ajax', 'MortgageWareLoan::viewLoanAppAjax' );

        /**
         * View Loan App
         */
        add_action( 'wp_ajax_mw_complete_loan_app_ajax', 'MortgageWareLoan::completeLoanAppAjax' );
        add_action( 'wp_ajax_nopriv_mw_complete_loan_app_ajax', 'MortgageWareLoan::completeLoanAppAjax' );

        /**
         * My Account
         */
        add_action( 'wp_ajax_mw_my_account_ajax', 'MortgageWareUser::myAccountAjax' );
        add_action( 'wp_ajax_nopriv_mw_my_account_ajax', 'MortgageWareUser::myAccountAjax' );

        /**
         * Loan Step
         */
        add_action( 'wp_ajax_mw_load_step_ajax', 'MortgageWareLoan::loadStepAjax' );
        add_action( 'wp_ajax_nopriv_mw_load_step_ajax', 'MortgageWareLoan::loadStepAjax' );

        /**
         * View Borrower
         */
        add_action( 'wp_ajax_mw_view_borrower_ajax', 'MortgageWareBorrower::viewBorrowerAjax' );
        add_action( 'wp_ajax_nopriv_mw_view_borrower_ajax', 'MortgageWareBorrower::viewBorrowerAjax' );

        /**
         * View Message
         */
        add_action( 'wp_ajax_mw_view_message_ajax', 'MortgageWareMessage::viewMessageAjax' );
        add_action( 'wp_ajax_nopriv_mw_view_message_ajax', 'MortgageWareMessage::viewMessageAjax' );

        /**
         * Add Loan Message
         */
        add_action( 'wp_ajax_mw_add_loan_message_ajax', 'MortgageWareMessage::addLoanMessageAjax' );
        add_action( 'wp_ajax_nopriv_mw_add_loan_message_ajax', 'MortgageWareMessage::addLoanMessageAjax' );

        /**
         * Add Loan Document
         */
        add_action( 'wp_ajax_mw_add_loan_document_ajax', 'MortgageWareDocument::addLoanDocumentAjax' );
        add_action( 'wp_ajax_nopriv_mw_add_loan_document_ajax', 'MortgageWareDocument::addLoanDocumentAjax' );

        /**
         * Approve Loan Document
         */
        add_action('wp_ajax_mw_approve_loan_document_ajax','MortgageWareDocument::approveLoanDocumentAjax');
        add_action('wp_ajax_nopriv_mw_approve_loan_document_ajax','MortgageWareDocument::approveLoanDocumentAjax');

        /**
         * Edit Account Details
         */
        add_action( 'wp_ajax_mw_edit_account_details_ajax', 'MortgageWareUser::editAccountDetailsAjax' );
        add_action( 'wp_ajax_nopriv_mw_edit_account_details_ajax', 'MortgageWareUser::editAccountDetailsAjax' );

        /**
         * Save Account Details
         */
        add_action( 'wp_ajax_mw_save_account_details_ajax', 'MortgageWareUser::saveAccountDetailsAjax' );
        add_action( 'wp_ajax_nopriv_mw_save_account_details_ajax', 'MortgageWareUser::saveAccountDetailsAjax' );

        /**
         * Export Loan
         */
        add_action( 'wp_ajax_mw_export_loan_ajax', 'MortgageWareLoan::exportLoanAjax' );
        add_action( 'wp_ajax_nopriv_mw_export_loan_ajax', 'MorgageWareLoan::exportLoanAjax' );

        /**
         * Delete Loan
         */
        add_action( 'wp_ajax_mw_delete_loan_ajax', 'MortgageWareLoan::deleteLoanAjax' );
        add_action( 'wp_ajax_nopriv_mw_delete_loan_ajax', 'MorgageWareLoan::deleteLoanAjax' );

    }

    // Initialize the Plugin
    public static function init()
    {
        self::addEnqueue();
        self::displayContainer('top');
        self::determineDisplay();
        self::displayContainer('bottom');
    }

    /**
     * Enqueue CSS & JS
     */
    public static function addEnqueue()
    {
        global $mw_settings;
        $mw_settings = MortgageWareAPI::getSettings();

        //Scripts
        wp_register_script('mw_jquery.1.12.1', 'https://code.jquery.com/jquery-1.12.1.min.js');
        wp_enqueue_script('mw_jquery.1.12.1');
        wp_register_script('mw_history', plugins_url('../js/history/history.js', __FILE__));
        wp_enqueue_script('mw_history');
        wp_register_script('mw_history_adapter', plugins_url('../js/history/history.adapter.jquery.js', __FILE__));
        wp_enqueue_script('mw_history_adapter');
        wp_register_script('mw_history_html4', plugins_url('../js/history/history.html4.js', __FILE__));
        wp_enqueue_script('mw_history_html4');
        wp_register_script('mw_inputmask', plugins_url('../js/jquery.mask.min.js', __FILE__));
        wp_enqueue_script('mw_inputmask');
        wp_register_script('mw_jquery.ui', '//code.jquery.com/ui/1.11.4/jquery-ui.min.js');
        wp_enqueue_script('mw_jquery.ui');
        wp_register_script('mw_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
        wp_enqueue_script('mw_bootstrap');
        wp_register_script('mw_datatables', '//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js');
        wp_enqueue_script('mw_datatables');
        wp_register_script('mw_datatables_bootstrap', '//cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js');
        wp_enqueue_script('mw_datatables_bootstrap');
        wp_register_script('mw_jconfirm', plugins_url('../js/jquery-confirm.min.js', __FILE__));
        wp_enqueue_script('mw_jconfirm');
        wp_register_script('mw_livequery', plugins_url('../js/jquery-livequery.min.js', __FILE__));
        wp_enqueue_script('mw_livequery');
        wp_register_script('mw_sigpad', plugins_url('../js/signaturepad/jquery.signaturepad.min.js', __FILE__));
        wp_enqueue_script('mw_sigpad');
        wp_register_script('mw_moment', plugins_url('../js/moment.min.js', __FILE__));
        wp_enqueue_script('mw_moment');
        wp_register_script('mw_app', plugins_url('../js/app.js', __FILE__));
        wp_enqueue_script('mw_app');

        // Styles
        wp_register_style('mw_style', plugins_url('../css/style.css', __FILE__));
        wp_enqueue_style('mw_style');
        wp_register_style('mw_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
        wp_enqueue_style('mw_bootstrap');
        wp_register_style('mw_datatables', '//cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css');
        wp_enqueue_style('mw_datatables');
        wp_register_style('mw_jconfirm', plugins_url('../css/jquery-confirm.min.css', __FILE__));
        wp_enqueue_style('mw_jconfirm');
        wp_register_style('mw_jquery.ui', '//code.jquery.com/ui/1.12.0-beta.1/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('mw_jquery.ui');
        wp_register_style('mw_fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
        wp_enqueue_style('mw_fontawesome');
        wp_register_style('mw_sigpad', plugins_url('../js/signaturepad/assets/jquery.signaturepad.css', __FILE__));
        wp_enqueue_style('mw_sigpad');

        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        wp_localize_script('mw_app', 'mw_app', array(
            'path' => plugins_url(),
            'ajax_url' => admin_url('admin-ajax.php', $protocol),
            'ajax_upload_url' => admin_url('async-upload.php')
        ));

    }

    public static function homeAjax() {
        unset($_SESSION['MW_FORGOT_PW']);
        self::determineDisplay();
    }

    /**
     * Determine Display
     */
    public static function determineDisplay()
    {

        if (isset($_SESSION['MW_USER'])) {
            $user = $_SESSION['MW_USER'];

            if (MortgageWareUser::hasRole($user,'ROLE_LOAN_OFFICER')) {

                // LOAN OFFICER

                if (isset($_REQUEST['loan']) && $_REQUEST['loan'] != '') {

                    // VIEW LOAN APP

                    MortgageWareLoan::viewLoanApp($_REQUEST['loan']);
                } else {

                    // DISPLAY LO PORTAL

                    $loans = MortgageWareAPI::getLoanOfficerLoans(MW_LOAN_OFFICER_ID);
                    self::displayPortal($loans, 'lo');
                }
            } else {

                // MEMBER

                if (isset($_REQUEST['loan']) && !empty($_REQUEST['loan'])) {

                    // VIEW LOAN APP
                    MortgageWareLoan::viewLoanApp($_REQUEST['loan']);

                } else if (isset($_REQUEST['app']) && !empty($_REQUEST['app'])) {

                    // COMPLETE LOAN APP

                    $loan = MortgageWareAPI::getLoanByGuid($_REQUEST['app']);

                    if (isset($_SESSION['MW_LOAN'])) {
                        if (isset($_SESSION['MW_LOAN'][$loan->guid])) {
                            $step = $_SESSION['MW_LOAN'][$loan->guid]['CURRENT_STEP'];
                        }
                    }

                    if (!isset($step)) {
                        $step = $loan->last_step_completed;
                        $_SESSION['MW_LOAN'][$loan->guid]['CURRENT_STEP'] = $step;
                    }

                    if ($step <= MW_LOAN_STEPS) {
                        MortgageWareLoan::displayLoanNav($step);
                        echo '<div id="currentLoanStep">';
                        MortgageWareLoan::loadStep($step,$loan);
                        echo '</div>';
                    } else {
                        $loans = MortgageWareAPI::getUserLoans($user->id);
                        self::displayPortal($loans, 'member');
                    }
                } else {

                    // GET MEMBER LOANS

                    $loans = MortgageWareAPI::getUserLoans($user->id);
                    if ($_SESSION['MW_PAGE'] == 'member-portal') {
                        self::displayPortal($loans, 'member');
                    } else if (empty($loans) || isset($_SESSION['MW_NEW_LOAN'])) {

                        // NEW LOAN APPLICATION

                        $step = 1;
                        MortgageWareLoan::displayLoanNav($step);
                        echo '<div id="currentLoanStep">';
                        MortgageWareLoan::loadStep($step);
                        echo '</div>';
                    } else {

                        // DISPLAY MEMBER PORTAL

                        if (!empty($loans)) {
                            self::displayPortal($loans, 'member');
                        } else {
                            MortgageWare::displayError();
                        }
                    }
                }
            }
        } else if (isset($_REQUEST['rp_token']) && !empty($_REQUEST['rp_token'])) {

            MortgageWareUser::loadResetPasswordForm();

        } else if (isset($_SESSION['MW_FORGOT_PW']) && $_SESSION['MW_FORGOT_PW']) {

            MortgageWareUser::loadForgotPasswordForm();

        } else {

            MortgageWareUser::loadLoginRegister();

        }
    }

    public static function displayContainer($area)
    {
        /** @noinspection PhpIncludeInspection */
        require_once __DIR__ . '/../template/'.$area.'.php';
    }


    /**
     * Display Portal
     *
     * @param $loans
     * @param $type
     */
    public static function displayPortal($loans,$type)
    {
        if (isset($loans)) {
            switch($type) {
                case 'member': require_once __DIR__ . '/../page/member-portal.php'; break;
                case 'lo':
                    $loanOfficer = MortgageWareAPI::getLoanOfficer($_SESSION['MW_LOAN_OFFICER_ID']);
                    if (is_object($loanOfficer)) {
                        require_once __DIR__ . '/../page/lo-portal.php';
                    } else {
                        self::displayError('admin');
                    }
            }
        }
    }


    /**
     * Display Error Page
     *
     * @param string $type
     */
    public static function displayError($type='user')
    {
        switch ($type) {
            case 'admin': require_once __DIR__ . '/../page/admin-error.php'; break;
            case 'unauthorized': require_once __DIR__ . '/../page/unauthorized.php'; break;
            default: require_once __DIR__ . '/../page/user-error.php';
        }

    }

}