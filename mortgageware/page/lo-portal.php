<?php
    $_SESSION['MW_PAGE'] = 'lo-portal';
    $user = $_SESSION['MW_USER'];
?>
<div class="inner">

    <h1 class="title"><?=MW_LO_ACCOUNT_TITLE?></h1>
    <?php require_once 'includes/account-details.php' ?>


    <h1><?=MW_LO_APPS_TITLE?></h1>
<?php
    if (count($loans)) {
?>
    <div id="my-applications">
        <div id="no-more-tables">
            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th>Loan #</th>
                        <th>Borrower</th>
                        <th>Address</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Created</th>
                        <th>Status</th>
        <?php
                    if (MW_LOS_ENABLED === true) {
        ?>
                        <th>LOS Status</th>
        <?php
                    }
        ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php
            foreach ($loans as $loan) {
                $created = new DateTime($loan->created);
                $address = '';
                if (property_exists($location,'address1')) {
                $address .= $location->address1;
                }
                if (property_exists($location,'city')) {
                $address .= '<br>'.$location->city.', ';
                }
                if (property_exists($location,'state') && is_object($location->state)) {
                $address .= $location->state->abbreviation;
                }

                if (trim($address) == '<br>,') {
                $address = "TBD";
                }
    ?>
                <tr data-guid="<?=$loan->guid?>">
                    <td data-title="Loan #"><?=$loan->id?></td>
                    <td data-title="Borrower"><?=$loan->borrower->first_name.' '.$loan->borrower->last_name?></td>
                    <td data-title="Address"><?=$address?></td>
                    <td data-title="Type"><?=MortgageWareLoan::$loanTypes[$loan->loan_type]?></td>
                    <td data-title="Amount"><?=property_exists($loan,'loan_amount') && $loan->loan_amount?'$'.number_format($loan->loan_amount):'Not Set'?></td>
                    <td data-title="Created"><?=$created->format(MW_DATE_FORMAT)?></td>
                    <td data-title="Status" class="mw-status"><?=$loan->deleted?'Deleted':MortgageWareLoan::$loanStatuses[$loan->status]?></td>
                    <?php
                    if (MW_LOS_ENABLED === true) {
                        ?>
                        <td data-title="LOS Status"><?=$loan->sent_to_los?"Sent":"Not Sent" ?></td>
                        <?php
                    }
                    ?>

                    <td data-title="Action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary mw_dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="MWViewApp"><i class="fa fa-eye"></i> View Loan Details</a></li>
                                <li><a class="mw-export-loan" data-format="fanniemae32"><i class="fa fa-share"></i> To Fannie Mae 3.2</li>
                                <li><a class="mw-export-loan" data-format="mismo231"><i class="fa fa-share"></i> To MISMO 2.3.1</li>
                                <li role="separator" class="divider"></li>
                                <?php
                                if (!$loan->deleted) {
                                    ?>
                                    <li><a class="MWDeleteApp"><i class="fa fa-trash"></i> Delete</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a class="MWUnDeleteApp"><i class="fa fa-repeat"></i> Reinstate</a></li>
                                    <?php
                                }

                                ?>
                            </ul>
                        </div>
                    </td>
                </tr>
    <?php
                }
    ?>
                </tbody>
            </table>
        </div>
        <div class="hidden-sm hidden-md hidden-lg">
            <div class="row">
                <b>Address:</b><br>
                AL  <br>
                Purchase<br>
                $100,000<br>
                <a href="/app_dev.php/user/account/loan/detail/1" class="btn btn-default">View</a>
            </div>
        </div>
<?php
    } else {
?>
        <p>There are no loans to display</p>
<?php
    }
?>
    </div>
    <!--<button class="btn btn-primary" id="startNewApplication"><?=MW_NEW_APP_BUTTON?></button>-->
</div>

<?php
    //var_dump($loan);
