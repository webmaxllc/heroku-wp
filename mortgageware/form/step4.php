<?php
    //var_dump($loan->borrower->asset_account);
    $borrowers = array(
        $loan->borrower->id => $loan->borrower->first_name.' '.$loan->borrower->last_name
    );
    $borrower = $loan->borrower;

    if (!empty($loan->co_borrower)) {
        foreach($loan->co_borrower as $co_borrower) {
            $borrowers[$co_borrower->id] = $co_borrower->first_name.' '.$co_borrower->last_name;
        }
    }
    $index = 'prototype';
    $states = [];
    $statesObj = MortgageWareAPI::getAllStates();
    $borrower = $loan->borrower;
    $asset_account = new StdClass;

    foreach ($statesObj as $state) {
        $states[$state->id] = $state->name;
    }

    //var_dump($loan->asset_real_estate);
?>
<form id="loan-app-form-step4" method="post" novalidate="novalidate" class="horizontal-form mw-loan-application-form" data-step="4">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <p><?=MW_LOAN_STEP_4_TEXT?></p>
    <div id="mw-assets">
        <header>
            <h3>Bank Accounts</h3>
        </header>
        <div id="no-more-tables">
          <table class="col-md-12 table-bordered table-striped table-condensed cf" data-prototype='<?php $index = 'prototype'; include 'prototype/bank_account.php'?>'>
                <thead class="cf">
                    <tr>
                        <th>Borrower <span class="required-asterisk">*</span></th>
                        <th>Institution Name <span class="required-asterisk">*</span></th>
                        <th>Type of Account <span class="required-asterisk">*</span></th>
                        <th>Account Number</th>
                        <th>Balance <span class="required-asterisk">*</span></th>
                    </tr>
                </thead>
                <tbody>
<?php
                if (empty($loan->asset_account)) {
                    $asset_accounts = array(
                        new StdClass
                    );
                } else {
                    $asset_accounts = $loan->asset_account;
                }

                foreach ($asset_accounts as $index => $asset_account) {

                    include 'prototype/bank_account.php';
                }
?>
                </tbody>
            </table>
            <div class="text-center">
                <a type="button" id="mw-add-bank-account"><span class="glyphicon glyphicon-plus"></span> Add Account</a>
            </div>
        </div>
    </div>
    <?php
        $properties = array();
        $property = new stdClass;
        if (!empty($loan->asset_real_estate)) {
            $properties = $loan->asset_real_estate;
        }
    ?>
    <div id="mw-properties">
        <header>
            <h3>Property Owned</h3>
        </header>
        <div id="mw-property-list" data-prototype='<?php $index='prototype'; include 'prototype/asset_property.php'; ?>'>
            <?php
            if (!empty($properties)) {
                foreach ($properties as $index => $property) {
                    include 'prototype/asset_property.php';
                }
            }
            ?>
        </div>
        <button type="button" id="mw-add-asset-real-estate" href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add Property</button>
    </div>
    <div class="text-center submit-wrapper">
        <button type="button" class="btn btn-default mw-back-button"><?=MW_LOAN_APP_BACK_BUTTON?></button>
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_CONTINUE_BUTTON?></button>
    </div>
</form>
