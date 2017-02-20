<?php
    $address = isset($loan->property_location->address1)?$address = $loan->property_location->address1.'<br>':'';
    $address.= isset($loan->property_location->address2)?$address = $loan->property_location->address2.'<br>':'';
    $address.= isset($loan->property_location->city)?$loan->property_location->city.', ':'';
    $address.= $loan->property_location->state->abbreviation;

    $borrower = $loan->borrower;
    $co_borrowers = $loan->co_borrower;

    $borrowerName = $borrower->first_name.' '.$borrower->last_name;
    $borrowerSSN = substr($borrower->ssn,-4);
    $borrowerDOB = new DateTime($borrower->birth_date);

?>
<div class="mw-loan-view" id="mw-loan-details-view">
    <div class="col-md-12">
        <div id="propertyInfo" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="2"><i class="fa fa-pencil"></i></a> Property Info</h2>
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
            <h2><a class="mw-edit-link" data-step="1"><i class="fa fa-pencil"></i></a> Borrowers</h2>
            <div id="no-more-tables">
                <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>SSN</th>
                            <th>Birth Date</th>
                            <th>View</th>
                        </tr>
                    </head>
                    <tbody>
                        <tr data-borrower_id="<?=$borrower->id?>" data-title="<?=$borrowerName?>">
                            <td data-title="Name"><?=$borrowerName?></td>
                            <td data-title="Type">Primary</td>
                            <td data-title="SSN">XXX-XX-<?=$borrowerSSN?></td>
                            <td data-title="Birth Date"><?=$borrowerDOB->format(MW_DATE_FORMAT)?></td>
                            <td data-title="Views"><button class="btn btn-primary MWViewBorrower">View Details</button></td>
                        </tr>
                        <?php
                        if (!empty($co_borrowers)) {
                            foreach ($co_borrowers as $co_borrower) {
                                $co_borrowerName = $co_borrower->first_name.' '.$co_borrower->last_name;
                                $co_borrowerSSN = substr($co_borrower->ssn,-4);
                                $co_borrowerDOB = new DateTime($co_borrower->birth_date);
                            ?>
                            <tr data-borrower_id="<?=$borrower->id?>" data-title="<?=$co_borrowerName?>">
                                <td data-title="Name"><?=$co_borrowerName?></td>
                                <td data-title="Type">Co-Borrower</td>
                                <td data-title="SSN">XXX-XX-<?=$co_borrowerSSN?></td>
                                <td data-title="Birthdate"><?=$co_borrowerDOB->format(MW_DATE_FORMAT)?></td>
                                <td data-title="Views"><button class="btn btn-primary MWViewBorrower">View Details</button></td>
                            </tr>
                    </tbody>
                        <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="employment" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="3"><i class="fa fa-pencil"></i></a> Employment</h2>
            <div id="no-more-tables">
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
                    <table class="col-md-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>Borrower</th>
                                <th>Employer</th>
                                <th>Phone</th>
                                <th>Position/Title</th>
                                <th>Self Employed</th>
                                <th>Time of Employment</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($borrower->employment as $employment) {
                            $start = new DateTime($employment->start_date);
                            $end = new DateTime($employment->end_date);
                            ?>
                            <tbody>
                                <tr>
                                    <td data-title="Borrower"><?=$borrowerName?></td>
                                    <td data-title="Employer"><?=$employment->employer_name?></td>
                                    <td data-title="Phone"><?=$employment->employer_phone?></td>
                                    <td data-title="Position/Title"><?=$employment->title?></td>
                                    <td data-title="Self Employed"><?=MortgageWareForm::boolToYesNo($employment->self_employed)?></td>
                                    <td data-title="Time of Employment"><?=$start->format(MW_DATE_FORMAT)?> - <?=$end->format(MW_DATE_FORMAT)?></td>
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
                                            <td data-title="Co-Borrower"><?=$co_borrower->first_name.' '.$co_borrower->last_name?></td>
                                            <td data-title="Employer"><?=$employment->employer_name?></td>
                                            <td data-title="Phone"><?=$employment->employer_phone?></td>
                                            <td data-title="Position/Title"><?=$employment->title?></td>
                                            <td data-title="Self Employed"><?=MortgageWareForm::boolToYesNo($employment->self_employed)?></td>
                                            <td data-title="Time of Employment"><?=$start->format(MW_DATE_FORMAT)?> - <?=$end->format(MW_DATE_FORMAT)?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "None";
                }
                ?>
            </div>
        </div>
        <div id="accountAssets" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="4"><i class="fa fa-pencil"></i></a> Account Assets</h2>
            <div id="no-more-tables">
                <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                        <tr>
                            <th>Borrower</th>
                            <th>Institution</th>
                            <th>Account Type</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <?php
                    foreach($borrower->asset_account as $account) {
                        ?>
                        <tbody>
                            <tr>
                                <td data-title="Borrower"><?=$borrowerName?></td>
                                <td data-title="Institution"><?=$account->institution_name?></td>
                                <td data-title="Account Type"><?=MortgageWareLoan::$accountTypes[$account->type]?></td>
                                <td data-title="Balance">$<?=$account->balance?></td>
                            </tr>
                        <?php
                    }
                    if (!empty($co_borrowers)) {
                        foreach($co_borrowers as $co_borrower) {
                            if (!empty($co_borrower->asset_account)) {
                                foreach ($co_borrower->asset_account as $account) {
                                    ?>
                                    <tr>
                                        <td data-title="Co-Borrower"><?= $co_borrower->first_name.' '.$co_borrower->last_name ?></td>
                                        <td data-title="Institution"><?= $account->institution_name ?></td>
                                        <td data-title="Account Type"><?= MortgageWareLoan::$accountTypes[$account->type] ?></td>
                                        <td data-title="Balance">$<?= $account->balance ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="realestateAssets" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="4"><i class="fa fa-pencil"></i></a> Real Estate Assets</h2>
            <div id="no-more-tables">
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
                    <table class="col-md-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
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
                        </thead>
                        <?php
                        foreach ($borrower->asset_realestate as $asset) {
                            ?>
                            <tbody>
                                <tr>
                                    <td data-title="Borrower"><?=$borrowerName?></td>
                                    <td data-title="Location"><?=isset($asset->location->address1)?$asset->location->address1:''?></td>
                                    <td data-title="Market Value">$<?=isset($asset->market_value)?$asset->market_value:''?></td>
                                    <td data-title="Mortgage Amount">$<?=isset($asset->mortgage_amount)?$asset->mortgage_amount:''?></td>
                                    <td data-title="Gross Rent">$<?=isset($asset->rent_gross_income)?$asset->rent_gross_income:''?></td>
                                    <td data-title="Net Rent">$<?=isset($asset->rent_net_income)?$asset->rent_net_income:''?></td>
                                    <td data-title="Mortgage Payment">$<?=isset($asset->mortgage_payment)?$asset->mortgage_payment:''?></td>
                                    <td data-title="Ins/Tax/Exp">$<?=isset($asset->ins_tax_exp)?$asset->ins_tax_exp:''?></td>
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
                                            <td data-title="Co-Borrower"><?= $co_borrower->first_name.' '.$co_borrower->last_name ?></td>
                                            <td data-title="Location"><?= isset($asset->location->address1) ? $asset->location->address1 : '' ?></td>
                                            <td data-title="Market Value"><?= isset($asset->market_value) ? '$' . $asset->market_value : '' ?></td>
                                            <td data-title="Mortgage Amount"><?= isset($asset->mortgage_amount) ? '$' . $asset->mortgage_amount : '' ?></td>
                                            <td data-title="Gross Rent"><?= isset($asset->gross_rent_income) ? '$' . $asset->gross_rent_income : '' ?></td>
                                            <td data-title="Net Rent"><?= isset($asset->net_rent) ? '$' . $asset->net_rent : '' ?></td>
                                            <td data-title="Mortgage Payment"><?= isset($asset->mortgage_payment) ? '$' . $asset->mortgage_payment : '' ?></td>
                                            <td data-title="Ins/Tax/Exp"><?= isset($asset->ins_tax_exp) ? '$' . $asset->ins_tax_exp : '' ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo 'None';
                }
                ?>
            </div>
        </div>
        <div id="accountAssets" class="MWLoanSection">
            <h2><a class="mw-edit-link" data-step="5"><i class="fa fa-pencil"></i></a> Housing Expenses</h2>
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
            <div id="no-more-tables">
                <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
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
                    </thead>
                    <?php
                    foreach($borrower->income_monthly as $income) {
                        ?>
                        <tbody>
                            <tr>
                                <td data-title="Borrower"><?=$borrowerName?></td>
                                <td data-title="Base">$<?=$income->base?></td>
                                <td data-title="Overtime">$<?=$income->overtime?></td>
                                <td data-title="Bonus">$<?=$income->bonus?></td>
                                <td data-title="Comission">$<?=$income->commission?></td>
                                <td data-title="Interest">$<?=$income->interest?></td>
                                <td data-title="Net Rent">$<?=$income->rent_net?></td>
                                <td data-title="Other">$<?=$income->other?></td>
                            </tr>
                        <?php
                    }
                    if (!empty($co_borrowers)) {
                        foreach($co_borrowers as $co_borrower) {
                            if (!empty($co_borrower->income_monthly)) {
                                foreach($co_borrower->income_monthly as $income) {
                                    ?>
                                    <tr>
                                        <td data-title="Co-Borrower"><?=$co_borrower->first_name.' '.$co_borrower->last_name?></td>
                                        <td data-title="Base">$<?=$income->base?></td>
                                        <td data-title="Overtime">$<?=$income->overtime?></td>
                                        <td data-title="Bonus">$<?=$income->bonus?></td>
                                        <td data-title="Comission">$<?=$income->commission?></td>
                                        <td data-title="Interest">$<?=$income->interest?></td>
                                        <td data-title="Net Rent">$<?=$income->rent_net?></td>
                                        <td data-title="Other">$<?=$income->other?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                    </tbody>
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
