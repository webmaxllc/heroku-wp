<?php
    $borrowers = array(
        $loan->borrower->id => $loan->borrower->first_name.' '.$loan->borrower->last_name
    );
    $borrower = $loan->borrower;

    $income = new StdClass;
    $incomes = array();
    if (!empty($borrower->income_monthly)) {
        foreach($borrower->income_monthly as $income) {
            $income->borrower = new StdClass;
            $income->borrower->id = $borrower->id;
            $incomes[] = $income;
        }

    }

    if (!empty($loan->co_borrower)) {
        foreach($loan->co_borrower as $co_borrower) {
            $borrowers[$co_borrower->id] = $co_borrower->first_name.' '.$co_borrower->last_name;
            if (!empty($co_borrower->income_monthly)) {
                foreach($co_borrower->income_monthly as $income) {
                    $income->borrower = new StdClass;
                    $income->borrower->id = $co_borrower->id;
                    $incomes[] = $income;
                }
            }
        }
    }

    if (empty($incomes)) {
        $incomes[] = new stdClass;
    }

    $expenses = $loan->expense_housing;
?>
<form id="loan-app-form-step5" method="post" novalidate="novalidate" class="horizontal-form mw-loan-application-form" data-step="5">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <p><?=MW_LOAN_STEP_5_TEXT?></p>
    <div id="mw-housing">
        <header>
            <h3>Monthly Housing Expenses</h3>
        </header>
        <div class="col-md-6">
            <?php
            MortgageWareForm::displayInput('expense_housing','rent','text',array(
                'required' => false,
                'class' => 'integer',
                'value' => property_exists($expenses,'rent') ? $expenses->rent : ''
            ));

            MortgageWareForm::displayInput('expense_housing','mortgage','text',array(
                'required' => false,
                'class' => 'integer',
                'value' => property_exists($expenses,'mortgage') ? $expenses->mortgage : ''
            ));

            MortgageWareForm::displayInput('expense_housing','insurance_hazard','text',array(
                'required' => false,
                'label' => 'Hazard Insurance',
                'class' => 'integer',
                'value' => property_exists($expenses,'insurance_hazard') ? $expenses->insurance_hazard : ''
            ));

            MortgageWareForm::displayInput('expense_housing','other_financial','text',array(
                'required' => false,
                'class' => 'integer',
                'value' => property_exists($expenses,'other_financial') ? $expenses->other_financial : ''
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            MortgageWareForm::displayInput('expense_housing','insurance_mortgage','text',array(
                'required' => false,
                'label' => 'Mortgage Insurance',
                'class' => 'integer',
                'value' => property_exists($expenses,'insurance_mortgage') ? $expenses->insurance_mortgage : ''
            ));

            MortgageWareForm::displayInput('expense_housing','tax_real_estate','text',array(
                'required' => false,
                'label' => 'Real Estate Tax',
                'class' => 'integer',
                'value' => property_exists($expenses,'tax_real_estate') ? $expenses->tax_real_estate : ''
            ));

            MortgageWareForm::displayInput('expense_housing','hoa_dues','text',array(
                'required' => false,
                'label' => 'HOA Dues',
                'class' => 'integer',
                'value' => property_exists($expenses,'hoa_dues') ? $expenses->hoa_dues : ''
            ));

            MortgageWareForm::displayInput('expense_housing','other','text',array(
                'required' => false,
                'class' => 'integer',
                'value' => property_exists($expenses,'other') ? $expenses->other : ''
            ));
            ?>
        </div>
    </div>
    <div id="mw-income">
        <header>
            <h3>Monthly Income</h3>
        </header>
        <div id="no-more-tables">
            <table class="col-md-12 table-bordered table-striped table-condensed cf" data-prototype='<?php $index = 'prototype'; include 'prototype/income.php'?>'>
                <thead class="cf">
                    <tr>
                        <th width="20%">Borrower <span class="required-asterisk">*</span></th>
                        <th>Base</th>
                        <th>Overtime</th>
                        <th>Bonus</th>
                        <th>Commission</th>
                        <th>Interest</th>
                        <th>Net Rent</th>
                        <th>Other</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($incomes as $index => $income) {
                    include 'prototype/income.php';
                }
                ?>
                </tbody>
            </table>
            <div class="text-center">
                <a type="button" id="mw-add-income"><span class="glyphicon glyphicon-plus"></span> Add Income</a>
            </div>
        </div>
    </div>
    <div class="mw-income-message"></div>
    <div class="text-center submit-wrapper">
        <button type="button" class="btn btn-default mw-back-button"><?=MW_LOAN_APP_BACK_BUTTON?></button>
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_CONTINUE_BUTTON?></button>
    </div>
</form>
