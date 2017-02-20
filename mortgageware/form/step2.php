<?php
    $states = [];
    $statesObj = MortgageWareAPI::getLocationStates();

    foreach ($statesObj as $state) {
        $states[$state->id] = $state->name;
    }
    asort($states);

    if (property_exists($loan,'property_location')) {
        $location = $loan->property_location;
    } else {
        $location = new StdClass();
    }
?>

<form id="loan-app-form-step2" method="post" novalidate="novalidate" class="mw-loan-application-form" data-step="2">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <p><?=MW_LOAN_STEP_2_TEXT?></p>
    <div class="form-inline well well-small">
        <div class="row">
            <div class="loan-type text-center ">
                <label>Are you currently working with a realtor?&nbsp;<span class="required-asterisk" title="This field is required">*</span></label>
                <div id="loanapplication_has_realtor" class="radio-group">
                    <div class="radio">
                        <label>
                            <input type="radio" id="loanapplication_has_realtor_0" name="has_realtor" required="required" value="0" <?=property_exists($loan,'has_realtor')&&$loan->has_realtor==0?'checked="checked"':''?> />
                            No&nbsp;<span class="required-asterisk required-alert" title="This field is required">*</span>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="loanapplication_has_realtor_1" name="has_realtor" required="required" value="1" <?=property_exists($loan,'has_realtor')&&$loan->has_realtor==1?'checked="checked"':''?> />
                            Yes&nbsp;<span class="required-asterisk required-alert" title="This field is required">*</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="property0">
        <header>
            <h3>Property Information</h3>
        </header>
        <div class="col-md-6">
<?php
            MortgageWareForm::displayInput('property_location','address1','text',array(
                'required' => false,
                'label' => 'Address',
                'value' => property_exists($location,'address1')?$location->address1:''
            ));

            MortgageWareForm::displayInput('property_location','city','text',array(
                'required' => false,
                'label' => 'City',
                'value' => property_exists($location,'city')?$location->city:''
            ));

            MortgageWareForm::displayInput('property_location','[state][id]','select',array(
                'required' => false,
                'options' => $states,
                'semi_natural' => true,
                'label' => 'State',
                'nullOption' => 'Select a State',
                'value' => property_exists($location,'state')?$location->state->id:''
            ));

            MortgageWareForm::displayInput('property_location','zipcode','text',array(
                'required' => false,
                'label' => 'Zipcode',
                'value' => property_exists($location,'zipcode')?$location->zipcode:''
            ));

            MortgageWareForm::displayInput(null,'property_type','select',array(
                'required' => false,
                'natural' => true,
                'options' => array(
                    'Single Family',
                    'Attached',
                    'Condominum',
                    'Planned Unit Development (PUD)',
                    'Mulit-Family (2 - 4 Units)',
                    'High Rise Condo',
                    'Manufactured Home',
                    'Detached Condo',
                    'Manufactured Home: Condo/PUD/Co-Op',
                    'Other'
                ),
                'nullOption' => 'Please Select One',
                'value' => property_exists($loan,'property_type')?$loan->property_type:''
            ));

            if ($loan->loan_type == 1) {

                MortgageWareForm::displayInput(null,'refinance_year_aquired','text',array(
                    'required' => true,
                    'natural' => true,
                    'label' => 'Year Acquired',
                    'class' => 'year',
                    'value' => property_exists($loan,'refinance_year_aquired')?$loan->refinance_year_aquired:''

                ));

                MortgageWareForm::displayInput(null,'refinance_original_cost','text',array(
                    'required' => true,
                    'natural' => true,
                    'label' => 'Original Cost',
                    'class' => 'number',
                    'prefix' => '$',
                    'suffix' => '.00',
                    'value' => property_exists($loan,'refinance_original_cost')?$loan->refinance_original_cost:''
                ));

                MortgageWareForm::displayInput(null,'refinance_existing_liens','text',array(
                    'required' => true,
                    'natural' => true,
                    'class' => 'number',
                    'prefix' => '$',
                    'suffix' => '.00',
                    'label' => 'Existing Liens',
                    'value' => property_exists($loan,'refinance_existing_liens')?$loan->refinance_existing_liens:''
                ));

                MortgageWareForm::displayInput(null,'refinance_purpose','select',array(
                    'required' => true,
                    'natural' => true,
                    'label' => 'Purpose of Refinance',
                    'options' => array(
                        'Cash-Out Debt Consolidation',
                        'Cash-Out Home Improvement',
                        'Cash-Out Other',
                        'No Cash-Out',
                        'Limited Cash-Out'
                    ),
                    'nullOption' => 'Please Select One',
                    'value' => property_exists($loan,'refinance_purpose')?$loan->refinance_purpose:''
                ));

            }
?>
        </div>
        <div class="col-md-6">
<?php
            MortgageWareForm::displayInput(null,'residency_type','select',array(
                'required' => true,
                'natural' => true,
                'options' => array(
                    'Primary',
                    'Second Home',
                    'Investment'
                ),
                'nullOption' => 'Please Select One',
                'value' => property_exists($loan,'residency_type')?$loan->residency_type:''
            ));

            MortgageWareForm::displayInput(null,'loan_amount','text',array(
                'required' => true,
                'natural' => true,
                'class' => 'money integer',
                'prefix' => '$',
                'suffix' => '.00',
                'value' => property_exists($loan,'loan_amount')?$loan->loan_amount:''
            ));

            MortgageWareForm::displayInput(null,'loan_term','select',array(
                'required' => true,
                'label' => 'Desired Loan Term',
                'natural' => true,
                'options' => array(
                    10 => "10 Years",
                    15 => "15 Years",
                    20 => "20 Years",
                    25 => "25 Years",
                    30 => "30 Years",
                    40 => "40 Years",
                    50 => "50 Years"
                ),
                'nullOption' => 'Please select one',
                'value' => property_exists($loan,'loan_term')?$loan->loan_term:''
            ));

            MortgageWareForm::displayInput(null,'num_units','text',array(
                'required' => true,
                'natural' => true,
                'class' => 'number',
                'value' => property_exists($loan,'num_units')?$loan->num_units:''
            ));

            MortgageWareForm::displayInput(null,'property_year_built','text',array(
                'required' => false,
                'natural' => true,
                'label' => 'Year Built',
                'class' => 'year',
                'value' => property_exists($loan,'property_year_built')?$loan->property_year_built:''
            ));

            if ($loan->loan_type == 1) {
                MortgageWareForm::displayInput(null,'refinance_current_rate','text',array(
                    'required' => true,
                    'natural' => true,
                    'class' => 'year',
                    'suffix' => '%',
                    'value' => property_exists($loan,'refinance_current_rate')?$loan->refinance_current_rate:''
                ));

                MortgageWareForm::displayInput(null,'refinance_current_loan_type','text',array(
                    'required' => true,
                    'natural' => true,
                    'label' => 'Current Loan Type',
                    'helper' => '(ex. 30 Year FHA)',
                    'value' => property_exists($loan,'refinance_current_loan_type')?$loan->refinance_current_loan_type:''
                ));

                MortgageWareForm::displayInput(null,'refinance_current_lender','text',array(
                    'required' => true,
                    'natural' => true,
                    'value' => property_exists($loan,'refinance_current_lender')?$loan->refinance_current_lender:''
                ));
            }
?>

        </div>
        <header>
            <h3>Title Information</h3>
            <p class="label">Title will be held by</p>
        </header>
        <div class="col-md-6">
<?php
            MortgageWareForm::displayInput(null,'title_company1','text',array(
                'label' => 'Name #1',
                'natural' => true,
                'value' => property_exists($loan,'title_company1')?$loan->title_company1:''
            ));

            MortgageWareForm::displayInput(null,'title_company2','text',array(
                'label' => 'Name #2',
                'natural' => true,
                'value' => property_exists($loan,'title_company2')?$loan->title_company2:''
            ));
?>
        </div>
        <div class="col-md-6">
<?php
        MortgageWareForm::displayInput(null,'title_manner','select',array(
            'options' => array(
                "Community property" => "Community property",
                "Joint tenants" => "Joint tenants",
                "Single man" => "Single man",
                "Single woman" => "Single woman",
                "Married man" => "Married man",
                "Married woman" => "Married woman",
                "Tenants in common" => "Tenants in common",
                "To be decided in escrow" => "To be decided in escrow",
                "Unmarried man" => "Unmarried man",
                "Unmarried woman" => "Unmarried woman",
                "Other" => "Other"
            ),
            'nullOption' => 'Please select one',
            'value' => property_exists($loan,'title_manner')?$loan->title_manner:'',
            'natural' => true
        ));
?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="text-center submit-wrapper">
        <button type="button" class="btn btn-default mw-back-button"><?=MW_LOAN_APP_BACK_BUTTON?></button>
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_CONTINUE_BUTTON?></button>
    </div>

</form>