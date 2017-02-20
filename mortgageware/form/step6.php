<?php
    $borrower = $loan->borrower;
    $co_borrowers = $loan->co_borrower;
    //var_dump($borrower);

    $declarations = array(
        array(
            'name' => 'outstanding_judgement',
            'label' => 'Are there any outstanding judgements against you?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'bankruptcy',
            'label' => 'Have you declared bankruptcy in the past 7 years?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'forclosure',
            'label' => 'Have you had property foreclosed upon or given title or deed in lieu thereof in the last 7 years?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'lawsuit',
            'label' => 'Are you a party to a lawsuit?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'forclosure_obligation',
            'label' => 'Have you directly or indirectly been obligated on any loan which resulted in foreclosure, transfer of title in lieu of foreclosure, or judgment?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'in_default',
            'label' => 'Are you presently delinquent or in default on any Federal debt or any other loan, mortgage, financial obligation, bond or loan guarantee?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'alimony_child_support',
            'label' => 'Are you obligated to pay alimony, child support, or separate maintenance?',
            'correct_answer' => 0,
            'additional_fields' => array(
                'alimony' => array(),
                'child_support' => array(),
                'separate_maintenance' => array()
            )
        ),
        array(
            'name' => 'down_payment_borrowed',
            'label' => 'Is any part of the down payment borrowed?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'note_endorser',
            'label' => 'Are you a co-maker or endorser on a note?',
            'correct_answer' => 0
        ),
        array(
            'name' => 'us_citizen',
            'label' => 'Are you a U.S. citizen?',
            'correct_answer' => null
        ),
        array(
            'name' => 'resident_alien',
            'label' => 'Are you a permanent resident alien?',
            'correct_answer' => null
        ),
        array(
            'name' => 'primary_residence',
            'label' => 'Do you intend to occupy the property as your primary residence?',
            'correct_answer' => null
        ),
        array(
            'name' => 'ownership_within_three_years',
            'label' => 'Have you had an ownership interest in a property in the last 3 years?',
            'correct_answer' => 0,
            'additional_fields' => array(
                'property_type' => array('label'=>'What type of property did you own?','options'=> array('Primary Residence','Second Home','Investment Property')),
                'child_support' => array('label'=>'How did you hold the title to the home?','options'=>array('Solely','Joinly w/Spouse','Joinly w/Another Person')),
            )
        ),
    );
?>
<form id="loan-app-form-step6" method="post" novalidate="novalidate" class="horizontal-form mw-loan-application-form" data-step="6">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <p><?=MW_LOAN_STEP_6_TEXT?></p>
    <div id="mw-declarations">
        <header>
            <h2><?=$borrower->first_name.' '.$borrower->last_name?>'s (Borrower) Declarations</h2>
        </header>
        <input type="hidden" name="borrower[id]" value="<?=$borrower->id?>">
        <?php
            $entity = 'borrower';
            foreach ($declarations as $declaration) {
                include 'prototype/declaration.php';
            }
            include 'prototype/government_monitoring.php';

            if (!empty($co_borrowers)) {
                foreach ($co_borrowers as $index => $borrower) {
                    ?>
                    <hr>
                    <header>
                        <h2><?=$borrower->first_name.' '.$borrower->last_name?>'s (Co-Borrower) Declarations</h2>
                    </header>
                    <input type="hidden" name="co_borrower[<?=$index?>][id]" value="<?=$borrower->id?>">
                    <?php
                    $entity = 'co_borrower['.$index.']';
                    foreach ($declarations as $declaration) {
                        include 'prototype/declaration.php';
                    }
                    include 'prototype/government_monitoring.php';
                }
            }
        ?>
    </div>
    <div class="text-center submit-wrapper">
        <button type="button" class="btn btn-default mw-back-button"><?=MW_LOAN_APP_BACK_BUTTON?></button>
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_CONTINUE_BUTTON?></button>
    </div>
</form>