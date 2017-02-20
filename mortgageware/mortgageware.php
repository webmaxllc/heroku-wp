<?php
/**
 * Plugin Name: MortgageWare
 * Plugin URI: http://webmaxco.com/wordpress
 * Description: MortgageWare 1003, Member Portal & Loan Officer Portal
 * Version: 1.1
 * Author: WM MortgageWare LLC
 * Author URI: http://webmaxco.com
 * License: GPL2
 */

global $mw_settings;

/* BEGIN CONFIGURATION */

// TODO: Move these to settings from API
define('MW_DOCUMENTS_ENABLED',true);
define('MW_LOS_ENABLED',true);

/* Dates */
define('MW_DATE_FORMAT','M j, Y');
define('MW_DATETIME_FORMAT','M j, Y h:i a');

/* Login/Register */
define('MW_INACTIVITY_LOG_OUT_TEXT','You were logged out do to inactivity.');
define('MW_PASSWORD_RESET_TEXT','Your password has been reset. Please login using the form below.');
define('MW_FORGOT_PASSWORD_EMAIL_SENT_TEXT','An email was sent to the account email containing a link to reset your password.');
define('MW_LOGIN_REGISTER_TEXT',"In order to fill out a loan application, you must first register or login using the form below.");

/* Passwprd Forgot/Reset */
define('MW_FORGOT_PASSWORD_TEXT',"Please enter your email address or username.");
define('MW_RESET_PASSWORD_TEXT',"Please choose a new password.");

/* Loan Application */
define('MW_LOAN_APPLICATION_TITLE',"Loan Application");
define('MW_LOAN_STEP_1_TEXT',"");
define('MW_LOAN_STEP_2_TEXT',"In this section of the application, you'll provide information about the property you are financing.");
define('MW_LOAN_STEP_3_TEXT',"One of the things considered when you apply for a mortgage is the relationship of your income to your expenses. In this section of the application, we'll ask the sources and amounts of your income.");
define('MW_LOAN_STEP_4_TEXT',"");
define('MW_LOAN_STEP_5_TEXT',"Detail your combined monthly housing expenses & income below.");
define('MW_LOAN_STEP_6_TEXT',"");
define('MW_LOAN_STEP_7_TEXT',"Please review your application");

/* Member Portal & Loan Officer Portal */
define('MW_MY_ACCOUNT_TITLE','My Account');
define('MW_MY_APPS_TITLE','My Applications');
define('MW_NO_LOANS_TEXT','');
define('MW_NEW_APP_BUTTON','<i class="fa fa-plus" aria-hidden="true"></i> Start New Application');
define('MW_DOCUMENT_DOWNLOAD_BUTTON','<i class="fa fa-download" aria-hidden="true"></i> Download');
define('MW_DOCUMENT_UPLOAD_BUTTON','<i class="fa fa-upload" aria-hidden="true"></i> Upload Document');
define('MW_DOCUMENT_APPROVE_BUTTON','<i class="fa fa-thumbs-o-up"></i> Approve</a>');
define('MW_DELETE_BUTTON','<i class="fa fa-trash"></i> Delete</a>');
define('MW_LO_ACCOUNT_TITLE',"My Account");
define('MW_LO_APPS_TITLE',"Loan Applications");

/* Loan Application */
define('MW_LOAN_APP_BACK_BUTTON','<i class="fa fa-arrow-left" aria-hidden="true"></i> Back');
define('MW_LOAN_APP_CONTINUE_BUTTON','Save & Continue <i class="fa fa-check" aria-hidden="true"></i>');
define('MW_LOAN_APP_FINISH_BUTTON','Submit & Finish <i class="fa fa-check" aria-hidden="true"></i>');
define('MW_VIEW_APP_BUTTON','<i class="fa fa-eye" aria-hidden="true"></i> View');
define('MW_COMPLETE_APP_BUTTON','<i class="fa fa-pencil" aria-hidden="true"></i> Complete');

/* Loan Application Agreements */
define('MW_LOAN_APP_AGREEMENT_ONE','I/We specifically represent to Lender and to Lender\'s actual or potential agents, brokers, processors, attorneys, insurers, servicers, successors and assigns and agrees and acknowledges that: (1) the information provided in this application is true and correct as of the date set forth opposite my initials and that any intentional or negligent misrepresentation of this information contained in this application may result in civil liability, including monetary damages, to any person who may suffer any loss due to reliance upon any misrepresentation that I have made on this application, and/or in criminal penalties including, but not limited to, fine or imprisonment or both under the provisions of Title 18, United States Code, Sec. 1001, et seq.; (2) the loan requested pursuant to this application (the "Loan") will be secured by a mortgage or deed of trust on the property described in this application; (3) the property will not be used for any illegal or prohibited purpose or use; (4) all statements made in this application are made for the purpose of obtaining a residential mortgage loan; (5) the property will be occupied as indicated in this application; (6) the Lender, its servicers, successors or assigns may retain the original and/or an electronic record of this application, whether or not the Loan is approved; (7) the Lender and its agents, brokers, insurers, servicers, successors, and assigns may continuously rely on the information contained in the application, and I am obligated to amend and/or supplement the information provided in this application if any of the material facts that I have represented herein should change prior to closing of the Loan; (8) in the event that my payments on the Loan become delinquent, the Lender, its servicers, successors or assigns may, in addition to any other rights and remedies that it may have relating to such delinquency, report my name and account information to one or more consumer reporting agencies; (9) ownership of the Loan and/or administration of the Loan account may be transferred with such notice as may be required by law; (10) neither Lender nor its agents, brokers, insurers, servicers, successors or assigns has made any representation or warranty, express or implied, to me regarding the property or the condition or value of the property; and (11) my transmission of this application as an "electronic record" containing my "electronic signature," as those terms are defined in applicable federal and/or state laws (excluding audio and video recordings), or my facsimile transmission of this application containing a facsimile of my signature, shall be as effective, enforceable and valid as if a paper version of this application were delivered containing my original written signature.');
define('MW_LOAN_APP_AGREEMENT_TWO','I/We hereby acknowledge that any owner of the Loan, its servicers, successors and assigns, may verify or reverify any information contained in this application or obtain any information or data relating to the Loan, for any legitimate business purpose through any source, including a source named in this application or a consumer reporting agency.');
define('MW_LOAN_APP_AGREEMENT_THREE','I/We fully understand that it is a Federal crime punishable by fine or imprisonment, or both, to knowingly make any false statements concerning any of the above facts as applicable under the provisions of Title 18, United States Code, Section 1001, et seq.');


/* END CONFIGURATION */

/* DO NOT EDIT BELOW THIS LINE */

//define('MW_SITE_ID',get_option('mw_site_id'));
//define('MW_LOAN_OFFICER_ID',get_option('mw_loan_officer_id'));
define('MW_USER_ROLE','ROLE_MEMBER');
define('MW_NOTIFY_USER',false);
define('MW_SUPPORT_EMAIL','support@webmaxco.com');
define('MW_API_DEBUGGING',get_option('mw_api_debugging'));
define('MW_URL',get_option('mw_api_url'));
define('MW_API_KEY',get_option('mw_api_key'));
define('MW_CLIENT_ID',get_option('mw_client_id'));
define('MW_CLIENT_SECRET',get_option('mw_client_secret'));
define('MW_GRANT_TYPE',get_option('mw_grant_type'));
define('MW_HAS_SIDEBAR',get_option('mw_has_sidebar'));

// Uncomment to display errors
#error_reporting(E_ALL);
#ini_set("display_errors", 1);

define('MW_LOAN_STEPS',7);
define('MW_VERSION','1.2.0');

if(!session_id()) {
    session_start();
}
if (isset($_GET['mw_logout'])) {
    unset(
        $_SESSION['MW_USER'],
        $_SESSION['MW_SITE_ID'],
        $_SESSION['MW_LOAN_OFFICER_ID'],
        $_SESSION['MW_USER_ID'],
        $_SESSION['MW_CURRENT_LOAN'],
        $_SESSION['MW_CURRENT_LOAN_STEP'],
        $_SESSION['MW_NEW_LOAN'],
        $_SESSION['MW_FORGOT_PW'],
        $_SESSION['MW_FORGOT_PW_EMAIL_SENT']
    );
}
if (isset($_GET['destroy']))
{
    session_destroy();
    session_start();
}

require_once 'lib/MortgageWareClass.php';
require_once 'lib/MortgageWareSettingsClass.php';
require_once 'lib/MortgageWareAPIClass.php';
require_once 'lib/MortgageWareFormClass.php';
require_once 'lib/MortgageWareUserClass.php';
require_once 'lib/MortgageWareLoanClass.php';
require_once 'lib/MortgageWareBorrowerClass.php';
require_once 'lib/MortgageWareDocumentClass.php';
require_once 'lib/MortgageWareMessageClass.php';

if (isset($_REQUEST['download'])) {
    if (isset($_REQUEST['guid'])) {
        MortgageWareLoan::exportLoan();
    } else if (isset($_REQUEST['document'])) {
        MortgageWareDocument::downloadLoanDocument();
    }
}
MortgageWare::defineActions();