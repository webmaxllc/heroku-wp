<?php

/**
 * Class MortgageWareLoan
 */
class MortgageWareLoan
{

    /**
     * Loan Types
     * @var array
     */
    public static $loanTypes = array(
        'Purchase',
        'Refinance'
    );

    /**
     * Loan Statuses
     * @var array
     */
    public static $loanStatuses = array(
        'Incomplete',
        'New',
        'Viewed',
        'In Process',
        'Junk',
        'Closed',
        'Imported from LOS',
        'Imported from File',
        'Imported from API'
    );

    /**
     * Property Types
     * @var array
     */
    public static $propertyTypes = array(
        0 => 'Single Family',
        1 => 'Attached',
        2 => 'Condominium',
        3 => 'Planned Unit Development (PUD)',
        4 => 'Multi-Family (2 - 4 Units)',
        5 => 'High Rise Condo',
        6 => 'Manufactured Home',
        7 => 'Detached Condo',
        8 => 'Manufactured Home: Condo/PUD/Co-Op',
        9 => 'Other',
    );

    /**
     * Residency Types
     * @var array
     */
    public static $residencyTypes = array(
        0 => 'Primary',
        1 => 'Second Home',
        2 => 'Investment'
    );

    /**
     * Sources
     * @var array
     */
    public static $sources = array(
        0 => 'Website',
        1 => 'LOS',
        2 => 'Fannie Mae 3.2 File',
        3 => 'API',
        4 => 'POST'
    );

    /**
     * Refinance Purposes
     * @var array
     */
    public static $refinancePurposes = array(
        0 => 'Cash-Out Debt Consolidation',
        1 => 'Cash-Out Home Improvement',
        2 => 'Cash-Out Other',
        3 => 'No Cash-Out',
        4 => 'Limited Cash-Out',
    );

    /**
     * Title Manners
     * @var array
     */
    public static $titleManners = array(
        'Community property' => 'Community property',
        'Joint tenants' => 'Joint tenants',
        'Single man' => 'Single man',
        'Single woman' => 'Single woman',
        'Married man' => 'Married man',
        'Married woman' => 'Married woman',
        'Tenants in common' => 'Tenants in common',
        'To be decided in escrow' => 'To be decided in escrow',
        'Unmarried man' => 'Unmarried man',
        'Unmarried woman' => 'Unmarried woman',
        'Other' => 'Other',
    );

    public static $declarations = array(
      'declaration_outstanding_judgement' => 'Are there any outstanding judgments against you?',
      'declaration_bankruptcy' => 'Have you been declared bankrupt within the past 7 years? ',
      'declaration_forclosure' => 'Have you had property foreclosed upon or given title or deed in lieu thereof in the last 7 years? ',
      'declaration_lawsuit' => 'Are you a party to a lawsuit?',
      'declaration_forclosure_obligation' => 'Have you directly or indirectly been obligated on any loan which resulted in foreclosure, transfer of title in lieu of foreclosure, or judgment?',
      'declaration_in_default' => 'Are you presently delinquent or in default on any Federal debt or any other loan, mortgage, financial obligation, bond or loan guarantee?',
      'declaration_alimony_child_support' => 'Are you obligated to pay alimony, child support, or separate maintenance?',
      'declaration_down_payment_borrowed' => 'Is any part of the down payment borrowed? ',
      'declaration_note_endorser' => 'Are you a co-maker or endorser on a note?',
      'declaration_us_citizen' => 'Are you a U.S. citizen?',
      'declaration_resident_alien' => 'Are you a permanent resident alien?',
      'declaration_primary_residence' => 'Do you intend to occupy the property as your primary residence?',
      'declaration_ownership_within_three_years' => 'Have you had an ownership interest in a property in the last three years?'
    );

    public static $property_ownership_types =  array(
        0 => 'Primary Residence',
        1 => 'Second Home',
        2 => 'Investment Property',
    );

    public static $property_ownership_title_types = array(
        0 => 'Solely',
        1 => 'Jointly with Spouse',
        2 => 'Jointly with Another Person',
    );

    public static $accountTypes = array(
        0 => 'Checking',
        1 => 'Savings',
        2 => 'Money Market',
        3 => 'CD',
        4 => 'Mutual Fund',
        5 => 'Retirement',
        6 => 'Other',
    );

    /**
     * Display Loan Navigation Menu
     *
     * @param int $step
     */
    public static function displayLoanNav($step = 1)
    {
        require_once __DIR__ . '/../template/nav.php';
    }

	/**
	 * Display Loan Thank You Page
	 *
	 */
	public static function displayLoanThankYou()
	{
		require_once __DIR__ . '/../page/loan-thankyou.php';
	}

    /**
     * Load Loan Application Step
     *
     * @param $step
     */
    public static function loadStep($step,$loan=null)
    {
        MortgageWareAPI::checkAPIToken();
        if (empty($loan)) {
            $loan = new StdClass();
        } else {
            $_SESSION['MW_LOAN'][$loan->guid]['CURRENT_STEP'] = $step;
        }

        if ($step <= MW_LOAN_STEPS) {
            require_once __DIR__ . "/../form/step$step.php";
        } else {
	        MortgageWareLoan::displayLoanThankYou();
        }
    }

    /**
     * View Loan Application
     *
     * @param $loan
     */
    public static function viewLoanApp($loanID)
    {
        $user = $_SESSION['MW_USER'];
        if (is_numeric($loanID)) {
            $loan = MortgageWareAPI::getLoan($loanID);
        } else {
            $loan = MortgageWareAPI::getLoanByGuid($loanID);
        }

        if (isset($loan->id)) {
            $authorized = false;

            if (MortgageWareUser::hasRole($user, 'ROLE_LOAN_OFFICER') || MortgageWareUser::hasRole($user, 'ROLE_ADMIN') || MortgageWareUser::hasRole($user, 'ROLE_SUPER_ADMIN')) {
                $view = 'loan-application-lo-view';
                $authorized = true;
            } else {
                $view = 'loan-application-member-view';
                if ($loan->user->id == $_SESSION['MW_USER_ID']) {
                    $authorized = true;
                }
                if (!$authorized) {
                    foreach ($loan->client_user as $clientUser) {
                        if ($clientUser->id == $user->id) {
                            $authorized = true;
                            break;
                        }
                    }
                }
            }

            if ($authorized) {
                require_once __DIR__ . '/../page/'.$view.'.php';
            } else {
                MortgageWare::displayError('unauthorized');
            }
        } else {
            MortgageWare::displayError();
        }
    }

    /**
     * Complete Loan Application
     *
     * @param $loan
     */
    public static function completeLoanApp($loanID)
    {
        $user = $_SESSION['MW_USER'];
        if (is_numeric($loanID)) {
            $loan = MortgageWareAPI::getLoan($loanID);
        } else {
            $loan = MortgageWareAPI::getLoanByGuid($loanID);
        }

        if (isset($loan->id)) {
            $authorized = false;

            if (MortgageWareUser::hasRole($user, 'ROLE_LOAN_OFFICER') || MortgageWareUser::hasRole($user, 'ROLE_ADMIN') || MortgageWareUser::hasRole($user, 'ROLE_SUPER_ADMIN')) {
                $view = 'loan-application-lo-view';
                $authorized = true;
            } else {
                $view = 'loan-application-member-view';
                if ($loan->user->id == $_SESSION['MW_USER_ID']) {
                    $authorized = true;
                }
                if (!$authorized) {
                    foreach ($loan->client_user as $clientUser) {
                        if ($clientUser->id == $user->id) {
                            $authorized = true;
                            break;
                        }
                    }
                }
            }

            if ($authorized) {
                $lastStepCompleted = $loan->last_step_completed;
                self::displayLoanNav($lastStepCompleted);
                echo '<div id="currentLoanStep">';
                self::loadStep($lastStepCompleted,$loan);
                echo '</div>';
            } else {
                MortgageWare::displayError('unauthorized');
            }
        } else {
            MortgageWare::displayError();
        }
    }

    /**
     * New Loan Application Ajax
     */
    public static function newLoanApplicationAjax()
    {
        $_SESSION['MW_NEW_LOAN'] = true;
        self::displayLoanNav();
        echo '<div id="currentLoanStep">';
        self::loadStep(1);
        echo '</div>';
        exit();
    }

    /**
     * Load Loan Application Step Ajax
     */
    public static function loadStepAjax()
    {
        $step = $_REQUEST['step'];
        if (!empty($_REQUEST['loan_guid'])) {
            if (isset($_REQUEST['save_loan'])) {
                $save = self::updateLoan($_REQUEST['loan_guid'],$_REQUEST);
                if (property_exists($save,'guid')) {
                    $loan = $save;
                } else {
                    echo "There was a problem saving the request.";
                    var_dump($save);
                    // self::loadStep($step-1,$loan);
                    exit();
                }
            } else {
                $loan = MortgageWareAPI::getLoanByGuid($_REQUEST['loan_guid']);
            }
        } else if ($step == 2) {
            $loan = self::saveNewLoan($_REQUEST);
        } else {
            $loan = null;
        }
        self::loadStep($step,$loan);
        exit();
    }

    /**
     * Save Loan Application
     */
    private static function saveNewLoan($data)
    {
        $data['last_step_completed'] = 1;
        $data['site']['id'] = $_SESSION['MW_SITE_ID'];
        $data['user']['id'] = $_SESSION['MW_USER_ID'];
        $data['loan_officer']['id'] = $_SESSION['MW_LOAN_OFFICER_ID'];
        $data['status'] = 0;
        $today = new DateTime();
        $todayFormatted = $today->format(DATE_ISO8601);
        $birthdate = new DateTime($data['borrower']['birth_date']);
        $data['borrower']['birth_date'] = $birthdate->format(DATE_ISO8601);
        $data['borrower']['location']['created'] = $todayFormatted;
        $data['borrower']['location']['location']['created'] = $todayFormatted;
        if (isset($data['co_borrower']) && !empty($data['co_borrower'])) {
            foreach ($data['co_borrower'] as $index => $co_borrower) {
                $birthdate = new DateTime($data['co_borrower'][$index]['birth_date']);
                $data['co_borrower'][$index]['birth_date'] = $birthdate->format(DATE_ISO8601);
                $data['co_borrower'][$index]['location']['created'] = $todayFormatted;
                $data['co_borrower'][$index]['location']['location']['created'] = $todayFormatted;
            }
        }
        return MortgageWareAPI::addLoan($data);
    }

    /**
     * Save Loan Application
     */
    private static function updateLoan($guid,$data)
    {
        $now = new DateTime();
        $previousStep = $data['step'] - 1;
        $loan = MortgageWareAPI::getLoanByGuid($guid);
        $borrower = $loan->borrower;
        $co_borrowers = $loan->co_borrower;
        switch ($data['step']) {
            case 2:
                // PERSONAL
                $data['borrower']['id'] = $borrower->id;
                $birthdate = new DateTime($data['borrower']['birth_date']);
                $data['borrower']['birth_date'] = $birthdate->format(DATE_ISO8601);
                $data['borrower']['location']['id'] = $borrower->location->id;
                $data['borrower']['location']['location']['id'] = $borrower->location->location->id;
                if (isset($data['co_borrower']) && !empty($data['co_borrower'])) {
                    foreach ($data['co_borrower'] as $index => $co_borrower) {
                        if(isset($loan->co_borrower[$index])) {
                            $co_borrower = $loan->co_borrower[$index];
                            $data['co_borrower'][$index]['id'] = $co_borrower->id;
                            $data['co_borrower'][$index]['location']['id'] = $co_borrower->location->id;
                            $data['co_borrower'][$index]['location']['location']['id'] = $co_borrower->location->location->id;
                        }
                        $birthdate = new DateTime($data['co_borrower'][$index]['birth_date']);
                        $data['co_borrower'][$index]['birth_date'] = $birthdate->format(DATE_ISO8601);

                    }
                }
                break;
            case 3:
                // PROPERTY
                break;
            case 4:
                // EMPLOYMENT
                foreach($data['borrower']['employment'] as $index => $employment) {
                    if (empty($employment['id'])) {
                        $data['borrower']['employment'][$index]['location']['created'] = $now->format(DATE_ISO8601);
                    }
                    $start_date = new DateTime($employment['start_date']);
                    $data['borrower']['employment'][$index]['start_date'] = $start_date->format(DATE_ISO8601);
                    if ($employment['current']) {
                        $end_date = new DateTime();
                    } else {
                        $end_date = new DateTime($employment['end_date']);
                    }
                    $data['borrower']['employment'][$index]['end_date'] = $end_date->format(DATE_ISO8601);
                }
                if (isset($data['co_borrower']) && !empty($data['co_borrower'])) {
                    foreach ($data['co_borrower'] as $index => $co_borrower) {
                        foreach($co_borrower['employment'] as $eindex => $employment) {
                            if (empty($employment['id'])) {
                                $data['co_borrower'][$index]['employment'][$eindex]['location']['created'] = $now->format(DATE_ISO8601);
                                unset($data['co_borrower'][$index]['employment'][$eindex]['id']);
                            }
                            $start_date = new DateTime($employment['start_date']);
                            $data['co_borrower'][$index]['employment'][$eindex]['start_date'] = $start_date->format(DATE_ISO8601);
                            if ($employment['current']) {
                                $end_date = new DateTime();
                            } else {
                                $end_date = new DateTime($employment['end_date']);
                            }
                            $data['co_borrower'][$index]['employment'][$eindex]['end_date'] = $end_date->format(DATE_ISO8601);
                        }
                    }
                }
                break;
            case 5:
                // ASSETS
                if (isset($data['asset_real_estate']) && !empty($data['asset_real_estate'])) {
                    $today = new DateTime();
                    $todayFormatted = $today->format(DATE_ISO8601);
                    foreach($data['asset_real_estate'] as $index => $property) {
                        if (!isset($property['id'])) {
                            $data['asset_real_estate'][$index]['location']['created'] = $todayFormatted;
                        }
                    }
                }
                break;
            case 6:
                // INCOME
                foreach ($data['income_monthly'] as $index => $income) {
                    if ($income['borrower']['id'] == $borrower->id) {
                        $data['borrower']['income_monthly'][$index] = $income;
                        $data['borrower']['id'] = $borrower->id;
                    } else if (!empty($co_borrowers)) {
                        foreach ($co_borrowers as $bindex => $co_borrower) {
                            if ($income['borrower']['id'] = $co_borrower->id) {
                                $data['co_borrower'][$bindex]['income_monthly'][$index] = $income;
                                $data['co_borrower'][$bindex]['id'] = $co_borrower->id;
                            }
                        }
                    }
                }
                unset($data['income_monthly']);
                break;
            case 7:
                // DECLARATIONS
                if (!isset($data['borrower']['govt_monitoring_opt_out'])) {
                    $data['borrower']['govt_monitoring_opt_out'] = 0;
                }
                if (!empty($co_borrowers)) {
                    foreach ($co_borrowers as $bindex => $co_borrower) {
                        if (!isset($data['co_borrower'][$bindex]['govt_monitoring_opt_out'])) {
                            $data['co_borrower'][$bindex]['govt_monitoring_opt_out'] = 0;
                        }
                    }
                }
                break;
            case 8:
                // SIGNATURE AND COMPLETION
                $data['completed'] = 1;
                $data['completed_date'] = $now->format(DATE_ISO8601);
                $data['status'] = 1;
                break;
        }
        // SET THE LAST STEP COMPLETED
        if ($previousStep > $loan->last_step_completed) {
            $data['last_step_completed'] = $previousStep;
        }
        $data['id'] = $loan->id;

        return MortgageWareAPI::editLoan($loan->id,$data);
    }

    /**
     * Complete Loan Application Ajax
     */
    public static function completeLoanAppAjax()
    {
        self::completeLoanApp($_REQUEST['guid']);
        exit();
    }

    /**
     * View Loan Application Ajax
     */
    public static function viewLoanAppAjax()
    {
        self::viewLoanApp($_REQUEST['guid']);
        exit();
    }

    /**
     * View Loan Application Ajax
     */
    public static function viewLoansAjax()
    {
        MortgageWare::determineDisplay();
        exit();
    }

    /**
     * View Loan Application Ajax
     */
    public static function exportLoan()
    {
        $loan = MortgageWareAPI::getLoanByGuid($_REQUEST['guid']);
        $content = MortgageWareAPI::exportLoan($loan->id,$_REQUEST['format']);
        if ($_REQUEST['format'] == 'mismo231') {
            $contentType = 'application/xml';
            $filename = sprintf('mismoLoan-%s.xml', $loan->id);
        } else {
            $contentType = 'text/plain';
            $filename = sprintf('loan-%s.fnm', $loan->id);
        }
        header('Content-Type: '.$contentType);
        header('Content-disposition: attachment; filename='.$filename);
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $content;
        exit();
    }

    /**
     * Delete Loan Application Ajax
     */
    public static function deleteLoanAjax()
    {
        $response = array();
        if (isset($_REQUEST['reverse'])) {
            $loan = MortgageWareAPI::undeleteLoanByGuid($_REQUEST['guid']);
            if (!$loan->deleted) {
                $response['status'] = MortgageWareLoan::$loanStatuses[$loan->status];
                $response['success'] = true;
            }
        } else {
            $loan = MortgageWareAPI::deleteLoanByGuid($_REQUEST['guid']);
            if ($loan->deleted) {
                $response['success'] = true;
            }
        }

        exit(json_encode($response));
    }

}