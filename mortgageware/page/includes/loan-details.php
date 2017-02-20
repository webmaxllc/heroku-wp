<div class="mw-loan-view temp-hide" id="mw-loan-details-view">
    <div class="col-md-12">
        <div id="propertyInfo" class="MWLoanSection">
            <h2>Property Info</h2>
            <div>
                <div><?=$address?></div>
                <div><strong>Loan Type: </strong> <?=MortgageWareLoan::$loanTypes[$loan->loan_type]?></div>
                <div><strong>Property Type: </strong> <?=MortgageWareLoan::$propertyTypes[$loan->property_type]?></div>
                <div><strong>Residency Type: </strong> <?=MortgageWareLoan::$residencyTypes[$loan->residency_type]?></div>
                <div><strong>Loan Amount: </strong> $<?=$loan->loan_amount?></div>
                <div><strong>Loan Term: </strong> $<?=$loan->loan_term?></div>
                <div><strong>Number of Units Amount: </strong> $<?=$loan->loan_amount?></div>
            </div>
        </div>
        <div id="titleInfo">
            <h2>Title Info</h2>
            <div><strong>Title Manner: </strong> <?=isset($loan->title_manner)?$loan->title_manner:'Not Set'?></div>
        </div>
        <div id="borrowers" class="MWLoanSection">
            <h2>Borrowers</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>SSN</th>
                        <th>Birth Date</th>
                        <th>View</th>
                    </tr>
                    <tr data-borrower_id="<?=$borrower->id?>" data-title="<?=$borrowerName?>">
                        <td><?=$borrowerName?></td>
                        <td>Primary</td>
                        <td>XXX-XX-<?=$borrowerSSN?></td>
                        <td><?=$borrowerDOB->format(MW_DATE_FORMAT)?></td>
                        <td><button class="btn btn-primary MWViewBorrower">View Details</button></td>
                    </tr>
                    <?php
                    if (!empty($co_borrowers)) {
                        foreach ($co_borrowers as $co_borrower) {
                            $co_borrowerName = $co_borrower->first_name.' '.$co_borrower->last_name;
                            $co_borrowerSSN = substr($co_borrower->ssn,-4);
                            $co_borrowerDOB = new DateTime($co_borrower->birth_date);
                            ?>
                            <tr data-borrower_id="<?=$borrower->id?>" data-title="<?=$co_borrowerName?>">
                                <td><?=$co_borrowerName?></td>
                                <td>Co-Borrower</td>
                                <td>XXX-XX-<?=$co_borrowerSSN?></td>
                                <td><?=$co_borrowerDOB->format(MW_DATE_FORMAT)?></td>
                                <td><button class="btn btn-primary MWViewBorrower">View Details</button></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="employment" class="MWLoanSection">
            <h2>Employment</h2>
            <div class="table-responsive">
                <?php
                $showTable = false;
                if (!empty($borrower->employment)) {
                    $showTable = true;
                } else if (!empty($co_borrowers)) {
                    foreach ($co_borrowers as $co_borrower) {
                        if (!empty($co_borrower->employment)) {
                            $showTable = true;
                        }
                    }
                }
                if ($showTable) {
                    ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Borrower</th>
                            <th>Employer</th>
                            <th>Phone</th>
                            <th>Position/Title</th>
                            <th>Self Employed</th>
                            <th>Time of Employment</th>
                        </tr>
                        <?php
                        foreach ($borrower->employment as $employment) {
                            $start = new DateTime($employment->start_date);
                            $end = new DateTime($employment->end_date);
                            ?>
                            <tr>
                                <td><?=$borrowerName?></td>
                                <td><?=$employment->employer_name?></td>
                                <td><?=$employment->employer_phone?></td>
                                <td><?=$employment->title?></td>
                                <td><?=MortgageWareForm::boolToYesNo($employment->self_employed)?></td>
                                <td><?=$start->format(MW_DATE_FORMAT)?> - <?=$end->format(MW_DATE_FORMAT)?></td>
                            </tr>
                            <?php
                        }

                        if (!empty($co_borrowers)) {
                            foreach ($co_borrowers as $co_borrower) {
                                if (!empty($co_borrower->employment)) {
                                    foreach ($co_borrower->employment as $employment) {
                                        $start = new DateTime($employment->start_date);
                                        $end = new DateTime($employment->end_date);
                                        ?>
                                        <tr>
                                            <td><?=$co_borrower->first_name.' '.$co_borrower->last_name?></td>
                                            <td><?=$employment->employer_name?></td>
                                            <td><?=$employment->employer_phone?></td>
                                            <td><?=$employment->title?></td>
                                            <td><?=MortgageWareForm::boolToYesNo($employment->self_employed)?></td>
                                            <td><?=$start->format(MW_DATE_FORMAT)?> - <?=$end->format(MW_DATE_FORMAT)?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    echo "None";
                }
                ?>
            </div>
        </div>
        <div id="accountAssets" class="MWLoanSection">
            <h2>Account Assets</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Borrower</th>
                        <th>Institution</th>
                        <th>Account Type</th>
                        <th>Balance</th>
                    </tr>
                    <?php
                    foreach($borrower->asset_account as $account) {
                        ?>
                        <tr>
                            <td><?=$borrowerName?></td>
                            <td><?=$account->institution_name?></td>
                            <td><?=MortgageWareLoan::$accountTypes[$account->type]?></td>
                            <td>$<?=$account->balance?></td>
                        </tr>
                        <?php
                    }
                    if (!empty($co_borrowers)) {
                        foreach($co_borrowers as $co_borrower) {
                            if (!empty($co_borrower->asset_account)) {
                                foreach ($co_borrower->asset_account as $account) {
                                    ?>
                                    <tr>
                                        <td><?= $co_borrower->first_name.' '.$co_borrower->last_name ?></td>
                                        <td><?= $account->institution_name ?></td>
                                        <td><?= MortgageWareLoan::$accountTypes[$account->type] ?></td>
                                        <td>$<?= $account->balance ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="realestateAssets" class="MWLoanSection">
            <h2>Real Estate Assets</h2>
            <div class="table-responsive">
                <?php
                $showTable = false;
                if (!empty($borrower->asset_realestate)) {
                    $showTable = true;
                } else if (!empty($co_borrowers)) {
                    foreach ($co_borrowers as $co_borrower) {
                        if (!empty($co_borrower->asset_realestate)) {
                            $showTable = true;
                        }
                    }
                }
                if ($showTable) {
                    ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Borrower</th>
                            <th>Location</th>
                            <th>Market Value</th>
                            <th>Mortgage Amount</th>
                            <th>Gross Rent</th>
                            <th>Net Rent</th>
                            <th>Mortgage Payment</th>
                            <th>Ins/Tax/Exp</th>
                        </tr>
                        <?php
                        foreach ($borrower->asset_realestate as $asset) {
                            ?>
                            <tr>
                                <td><?=$borrowerName?></td>
                                <td><?=isset($asset->location->address1)?$asset->location->address1:''?></td>
                                <td>$<?=isset($asset->market_value)?$asset->market_value:''?></td>
                                <td>$<?=isset($asset->mortgage_amount)?$asset->mortgage_amount:''?></td>
                                <td>$<?=isset($asset->rent_gross_income)?$asset->rent_gross_income:''?></td>
                                <td>$<?=isset($asset->rent_net_income)?$asset->rent_net_income:''?></td>
                                <td>$<?=isset($asset->mortgage_payment)?$asset->mortgage_payment:''?></td>
                                <td>$<?=isset($asset->ins_tax_exp)?$asset->ins_tax_exp:''?></td>
                            </tr>
                            <?php
                        }
                        if (!empty($co_borrowers)) {
                            foreach ($co_borrowers as $co_borrower) {
                                if (!empty($co_borrower->asset_realestate)) {
                                    foreach ($co_borrower->asset_realestate as $asset) {
                                        //var_dump($asset);
                                        ?>
                                        <tr>
                                            <td><?= $co_borrower->first_name.' '.$co_borrower->last_name ?></td>
                                            <td><?= isset($asset->location->address1) ? $asset->location->address1 : '' ?></td>
                                            <td><?= isset($asset->market_value) ? '$' . $asset->market_value : '' ?></td>
                                            <td><?= isset($asset->mortgage_amount) ? '$' . $asset->mortgage_amount : '' ?></td>
                                            <td><?= isset($asset->gross_rent_income) ? '$' . $asset->gross_rent_income : '' ?></td>
                                            <td><?= isset($asset->net_rent) ? '$' . $asset->net_rent : '' ?></td>
                                            <td><?= isset($asset->mortgage_payment) ? '$' . $asset->mortgage_payment : '' ?></td>
                                            <td><?= isset($asset->ins_tax_exp) ? '$' . $asset->ins_tax_exp : '' ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    echo 'None';
                }
                ?>
            </div>
        </div>
        <div id="accountAssets" class="MWLoanSection">
            <h2>Housing Expenses</h2>
            <div>
                <div><strong>Rent: </strong> $<?=isset($loan->expense_housing->rent)?$loan->expense_housing->rent:0?></div>
                <div><strong>Mortgage: </strong> $<?=isset($loan->expense_housing->mortgage)?$loan->expense_housing->mortgage:0?></div>
                <div><strong>Other Financial: </strong> $<?=isset($loan->expense_housing->other_financial)?$loan->expense_housing->other_financial:0?></div>
                <div><strong>Hazard Insurance: </strong> $<?=isset($loan->expense_housing->insurance_hazard)?$loan->expense_housing->insurance_hazard:0?></div>
                <div><strong>Mortgage Insurance: </strong> $<?=isset($loan->expense_housing->insurance_mortgage)?$loan->expense_housing->insurance_mortgage:0?></div>
                <div><strong>Real Estate Taxes: </strong> $<?=isset($loan->expense_housing->real_estate_taxes)?$loan->expense_housing->real_estate_taxes:0?></div>
                <div><strong>HOA Dues: </strong> $<?=isset($loan->expense_housing->rent)?$loan->expense_housing->hoa_dues:0?></div>
                <div><strong>Other: </strong> $<?=isset($loan->expense_housing->other)?$loan->expense_housing->other:0?></div>
            </div>
        </div>
        <div id="accountAssets" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="5"><i class="fa fa-pencil"></i></a> Monthly Income</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Borrower</th>
                        <th>Base</th>
                        <th>Overtime</th>
                        <th>Bonus</th>
                        <th>Commission</th>
                        <th>Interest</th>
                        <th>Net Rent</th>
                        <th>Other</th>
                    </tr>
                    <?php
                    foreach($borrower->income_monthly as $income) {
                        ?>
                        <tr>
                            <td><?=$borrowerName?></td>
                            <td>$<?=$income->base?></td>
                            <td>$<?=$income->overtime?></td>
                            <td>$<?=$income->bonus?></td>
                            <td>$<?=$income->commission?></td>
                            <td>$<?=$income->interest?></td>
                            <td>$<?=$income->rent_net?></td>
                            <td>$<?=$income->other?></td>
                        </tr>
                        <?php
                    }
                    if (!empty($co_borrowers)) {
                        foreach($co_borrowers as $co_borrower) {
                            if (!empty($co_borrower->income_monthly)) {
                                foreach($co_borrower->income_monthly as $income) {
                                    ?>
                                    <tr>
                                        <td><?=$co_borrower->first_name.' '.$co_borrower->last_name?></td>
                                        <td>$<?=$income->base?></td>
                                        <td>$<?=$income->overtime?></td>
                                        <td>$<?=$income->bonus?></td>
                                        <td>$<?=$income->commission?></td>
                                        <td>$<?=$income->interest?></td>
                                        <td>$<?=$income->rent_net?></td>
                                        <td>$<?=$income->other?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="accountAssets" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="6"><i class="fa fa-pencil"></i></a> Declarations</h2>
            <div>
                <h4><?=$borrowerName?></h4>
                <?php
                foreach (MortgageWareLoan::$declarations as $field => $declaration) {
                    ?>
                    <div class="declaration"><span class="declarationAnswer"><?=MortgageWareForm::boolToYesNo($loan->borrower->$field)?></span> <?=$declaration?></div>
                    <?php
                }
                if (!empty($co_borrowers)) {
                    foreach ($co_borrowers as $co_borrower) {
                        ?>
                        <h4><?=$co_borrower->first_name.' '.$co_borrower->last_name?></h4>
                        <?php
                        foreach (MortgageWareLoan::$declarations as $field => $declaration) {
                            ?>
                            <div class="declaration"><span class="declarationAnswer"><?=MortgageWareForm::boolToYesNo($co_borrower->$field)?></span> <?=$declaration?></div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
        <div id="governmentMonitoring" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="6"><i class="fa fa-pencil"></i></a> Government Monitoring</h2>
            <div>
                <h4><?=$borrowerName?></h4>
                <?php
                if (!$loan->borrower->govt_monitoring_opt_out) {
                    ?>
                    <div><strong>Ethnicity: </strong> <?=MortgageWareBorrower::$ethnicities[$borrower->ethnicity]?></div>
                    <div><strong>Race: </strong> <?=MortgageWareBorrower::$races[$borrower->race]?></div>
                    <div><strong>Sex: </strong> <?=$borrower->is_male?'Male':'Female'?></div>
                    <?php
                } else {
                    echo "Opted Out";
                }
                if (!empty($co_borrowers)) {
                    foreach ($co_borrowers as $co_borrower) {
                        ?>
                        <h4><?=$co_borrower->first_name.' '.$co_borrower->last_name?></h4>
                        <?php
                        if (!$borrower->govt_monitoring_opt_out) {
                            ?>
                            <div><strong>Ethnicity: </strong> <?=MortgageWareBorrower::$ethnicities[$co_borrower->ethnicity]?></div>
                            <div><strong>Race: </strong> <?=MortgageWareBorrower::$races[$co_borrower->race]?></div>
                            <div><strong>Sex: </strong> <?=$co_borrower->is_male?'Male':'Female'?></div>
                            <?php
                        } else {
                            echo "Opted Out";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>