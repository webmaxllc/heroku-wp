<?php

/**
 * Class MortgageWareBorrower
 */
class MortgageWareBorrower {

    /**
     * Marital Statuses
     * @var array
     */
    public static $maritial_statuses = array(
        0 => 'Married',
        1 => 'Unmarried',
        2 => 'Separated'
    );

    /**
     * Ethnicities
     * @var array
     */
    public static $ethnicities = array(
        0 => 'Hispanic or Latino',
        1 => 'Not Hispanic or Latino',
        2 => 'Not applicable',
    );

    /**
     * Races
     * @var array
     */
    public static $races = array(
        0 => 'American Indian or Alaskan Native',
        1 => 'Asian',
        2 => 'Black or African American',
        3 => 'Native Hawaiian or Other Pac. Islander',
        4 => 'White',
        5 => 'Not applicable',
    );

    /**
     * View Borrower Ajax
     */
    public static function viewBorrowerAjax() {
        $borrower = MortgageWareAPI::getBorrower($_REQUEST['borrower_id']);
        require_once __DIR__.'/../page/modal/borrower-view.php';
        exit();
    }

}