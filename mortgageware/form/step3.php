<form id="loan-app-form-step1" method="post" novalidate="novalidate" class="horizontal-form mw-loan-application-form" data-step="3">
    <input type="hidden" name="loan_guid" id="mw-loan-guid" value="<?=property_exists($loan,'guid')?$loan->guid:''?>">
    <p><?=MW_LOAN_STEP_3_TEXT?></p>
<?php
    $states = [];
    $statesObj = MortgageWareAPI::getAllStates();

    foreach ($statesObj as $state) {
        $states[$state->id] = $state->name;
    }

    $entity = 'borrower';
    $type = 'borrower';
    $borrower = $loan->borrower;
    $disabled = false;

    $employment = new StdClass;
    $index = 'prototype';
?>
    <div id="employment-<?=$entity?>" class="employment-form" data-prototype='<?php include 'prototype/employment.php'?>'>
        <header>
            <h3><?=$borrower->first_name.' '.$borrower->last_name?>'s (<?=ucwords($type)?>) Employment</h3>
        </header>
        <?php

        if (empty($borrower->employment)) {
            $employments = array(
                new StdClass
            );
        } else {
            $employments = $borrower->employment;
        }

        if (property_exists($borrower,'employed')) {
            $employed = $borrower->employed;
            if (!$employed) {
                $disabled = true;
            }
        } else {
            $employed = true;
        }

        ?>
        <div class="form-inline well well-small">
            <div class="row">
                <div class="loan-type text-center ">
                    <label>Has <?=$borrower->first_name.' '.$borrower->last_name?> Been Employed In the Last 5 Years?&nbsp;<span class="required-asterisk" title="This field is required">*</span></label>
                    <div id="<?=$entity?>_employed" class="radio-group">
                        <div class="radio">
                            <label>
                                <input class="employment-radio" type="radio" id="loanapplication_<?=$entity?>_employed_0" data-borrower="<?=$type?>" name="<?=$entity?>[employed]" required="required" value="1" <?=$employed?'checked="checked"':''?> />
                                Yes&nbsp;<span class="required-asterisk required-alert" title="This field is required">*</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input class="employment-radio" type="radio" id="loanapplication_<?=$entity?>_employed_1" data-borrower="<?=$type?>" name="<?=$entity?>[employed]" required="required" value="0" <?=!$employed?'checked="checked"':''?> />
                                No&nbsp;<span class="required-asterisk required-alert" title="This field is required">*</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="<?=$entity?>[id]" value="<?=$borrower->id?>">
        <div id="<?=$type?>-employment" <?=!$employed?'class="temp-hide"':''?>>
            <?php
                foreach ($employments as $index => $employment) {
                    include 'prototype/employment.php';
                }
            ?>
        </div>
        <div class="mw-employment-message"></div>
    </div>
<?php
    if (!empty($loan->co_borrower)) {
        foreach ($loan->co_borrower as $bindex => $borrower) {
            $type = 'co_borrower';
            $entity = 'co_borrower['.$bindex.']';
            $co_borrower = $loan->co_borrower[$bindex];
            $disabled = false;
            ?>
            <div id="employment_<?= $entity ?>" class="employment-form">
                <header>
                    <h3><?= $co_borrower->first_name . ' ' . $co_borrower->last_name ?>'s Employment</h3>
                </header>
                <?php

                if (empty($co_borrower->employment)) {
                    $employments = array(
                        new StdClass
                    );
                } else {
                    $employments = $borrower->employment;
                }


                if (property_exists($co_borrower,'employed')) {
                    $employed = $co_borrower->employed;
                    if (!$employed) {
                        $disabled = true;
                    }
                } else {
                    $employed = true;
                }

                ?>
                <div class="form-inline well well-small">
                    <div class="row">
                        <div class="loan-type text-center ">
                            <label>Has <?= $borrower->first_name . ' ' . $borrower->last_name ?> Been Recently Employed?&nbsp;<span
                                    class="required-asterisk" title="This field is required">*</span></label>
                            <div id="<?= $entity ?>-employed" class="radio-group">
                                <div class="radio">
                                    <label>
                                        <input class="employment-radio" type="radio"
                                               id="loanapplication_<?= $entity ?>_employed_0"
                                               data-borrower="<?= $type.$index ?>" name="<?= $entity ?>[employed]"
                                               required="required"
                                               value="1" <?= $employed ? 'checked="checked"' : '' ?> />
                                        Yes&nbsp;<span class="required-asterisk required-alert"
                                                       title="This field is required">*</span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input class="employment-radio" type="radio"
                                               id="loanapplication_<?= $entity ?>_employed_1"
                                               data-borrower="<?= $type.$index ?>" name="<?= $entity ?>[employed]"
                                               required="required"
                                               value="0" <?= !$employed ? 'checked="checked"' : '' ?> />
                                        No&nbsp;<span class="required-asterisk required-alert"
                                                      title="This field is required">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="<?= $type.$index ?>-employment" <?= !$employed ? 'class="temp-hide"' : '' ?>>
                    <input type="hidden" name="<?= $entity ?>[id]" value="<?= $borrower->id ?>">
                    <?php
                        foreach ($employments as $index => $employment) {
                            include 'prototype/employment.php';
                        }
                    ?>
                </div>
            </div>
            <?php
        }
    }
?>
    <div class="text-center submit-wrapper">
        <button type="button" class="btn btn-default mw-back-button"><?=MW_LOAN_APP_BACK_BUTTON?></button>
        <button type="submit" class="btn btn-primary mw-submit-application"><?=MW_LOAN_APP_CONTINUE_BUTTON?></button>
    </div>
</form>
<?php

//var_dump($loan->co_borrower[0]->employment);