<?php

    $states = [];
    $statesObj = MortgageWareAPI::getAllStates();

    foreach ($statesObj as $state) {
        $states[$state->id] = $state->name;
    }

    $entity = 'co_borrower';

?>
<form id="loan-app-form-step1" method="post" novalidate="novalidate" class="mw-loan-application-form" data-step="1">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <div id="mw-personal" data-prototype='<?php include 'prototype/borrower.php' ?>'>
        <p><?=MW_LOAN_STEP_1_TEXT?></p>
        <div class="form-inline well well-small">
            <div class="row">
                <div class="loan-type text-center ">
                    <label>Which type of loan are you applying for?&nbsp;<span class="required-asterisk" title="This field is required">*</span></label>
                    <div id="loanapplication_loan_type" class="radio-group">
                        <div class="radio">
                            <label>
                                <input type="radio" id="mw_loan_type_0" name="loan_type" required="required" value="0" checked="checked" />
                                Purchase&nbsp;<span class="required-asterisk required-alert" title="This field is required">*</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="mw_loan_type_1" name="loan_type" required="required" value="1" />
                                Refinance&nbsp;<span class="required-asterisk required-alert" title="This field is required">*</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        $entity = 'borrower';
        include 'prototype/borrower.php';

        if (property_exists($loan,'co_borrower')) {
            if (!empty($loan->co_borrower)) {
                $entity = 'co_borrower';
                $co_borrower = true;
                include 'prototype/borrower.php';
            }
        }
?>
    </div>
    <button type="button" id="mw-add-co-borrower" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Co-Borrower</button>
    <div class="text-center submit-wrapper">
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_CONTINUE_BUTTON?></button>
    </div>
</form>