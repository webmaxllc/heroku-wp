<?php
    $borrowerName = $loan->borrower->first_name.' ';
    $borowerInitials = substr($loan->borrower->first_name,0,1);
    if (!empty($loan->borrower->middle_initial)) {
        $borrowerName .= $loan->borrower->middle_initial.'. ';
        $borowerInitials .= $loan->borrower->middle_initial;
    }
    $borrowerName = $loan->borrower->last_name;
    $borowerInitials.= substr($loan->borrower->last_name,0,1);
?>
<form id="loan-app-form-step7" method="post" novalidate="novalidate" class="horizontal-form mw-loan-application-form" data-step="7">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <p><?=MW_LOAN_STEP_7_TEXT?></p>
    <div class="clearfix">
        <?php include 'prototype/summary.php'; ?>
    </div>
    <div class="mw-loan-comments">
        <?php
        MortgageWareForm::displayInput(null,'comments','textarea',array(
            'natural' => true,
            'noLabel' => true,
            'placeholder' => 'Comments',
            'input_size' => 12
        ));
        ?>
    </div>
    <div id="agreements" class="MWLoanSection">
        <h2>Acknowledgement &amp; Agreement</h2>
        <?php
        MortgageWareForm::displayInput(null,'agreement_one','checkbox',array(
            'natural' => true,
            'label' => MW_LOAN_APP_AGREEMENT_ONE,
            'class' => 'mw-agreement',
            'label_size' => 12,
            'value' => 1
        ));

        MortgageWareForm::displayInput(null,'agreement_two','checkbox',array(
            'natural' => true,
            'label' => MW_LOAN_APP_AGREEMENT_TWO,
            'class' => 'mw-agreement',
            'label_size' => 12,
            'value' => 1
        ));

        MortgageWareForm::displayInput(null,'agreement_three','checkbox',array(
            'natural' => true,
            'label' => MW_LOAN_APP_AGREEMENT_THREE,
            'class' => 'mw-agreement',
            'label_size' => 12,
            'value' => 1
        ));
        ?>
    </div>
    <div id="well-signature" class="clearfix">
        <div class="pull-left well">
            <div class="borrower-signature clearfix">
                <div class="borrower-signature clearfix">
                    <p class="borrower-initials-wrapper">
                        <b><?=$borrowerName?>'s Initials</b>
                        <input type="text" id="borrower_initials" name="borrower[initials]" required="required" style="width: 100px; display: inline-block" class="form-control borrower-initials" data-initials="<?=$borowerInitials?>">
                    </p>
                    <?php if ($loan->borrower->signature) { ?>
                    <div class="sigPad signed" data-signature="<?=$loan->borrower->signature?>">
                        <div class="sigWrapper">
                            <div class="typed">{{ borrower.fullName }}</div>
                            <canvas class="pad" width="198" height="55"></canvas>
                        </div>
                        <p><?=$borrowerName?></p>
                    </div>
                    <?php } else { ?>
                    <div class="sigPad clearfix">
                        <ul class="sigNav">
                            <li class="typeIt"><a href="#type-it" class="current">Auto-Sign</a></li>
                            <li class="drawIt"><a href="#draw-it" >Sign</a></li>
                            <li class="clearButton"><a href="#clear">Clear</a></li>
                        </ul>
                        <div class="sig sigWrapper">
                            <div class="typed"><?=$borrowerName?></div>
                            <canvas class="pad" width="198" height="55"></canvas>
                            <b><label>Borrower Signature</label></b>
                            <input type="hidden" id="borrower_signature" name="borrower[signature]" class="output" value="">
                            <input type="hidden" id="borrower_id" name="borrower[id]" value="<?=$loan->borrower->id?>">
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="text-center submit-wrapper">
        <button type="button" class="btn btn-default mw-back-button"><?=MW_LOAN_APP_BACK_BUTTON?></button>
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_FINISH_BUTTON?></button>
    </div>
</form>