<?php
    $_SESSION['MW_PAGE'] = 'member-portal';
    $user = $_SESSION['MW_USER'];
    $lastAccess = new DateTime($user->last_access);
?>
<div class="inner">

    <h1 class="title"><?=MW_MY_ACCOUNT_TITLE?></h1>
    <?php require_once 'includes/account-details.php' ?>

    <h1><?=MW_MY_APPS_TITLE?></h1>
    <?php
        if (!empty($loans)) {
    ?>
    <div id="my-applications" class="table-responsive">
        <div id="no-more-tables">
            <table class="col-md-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th>Loan #</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php
            foreach ($loans as $loan) {
                $created = new DateTime($loan->created);
                $location = $loan->property_location;
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
                    <td data-title="Address"><?=$address?></td>
                    <td data-title="Role"><?=MortgageWareUser::getLoanUserRoleType($user,$loan)?></td>
                    <td data-title="Type"><?=MortgageWareLoan::$loanTypes[$loan->loan_type]?></td>
                    <td data-title="Amount"><?=property_exists($loan,'loan_amount') && $loan->loan_amount?'$'.number_format($loan->loan_amount):'Not Set'?></td>
                    <td data-title="Created"><?=$created->format(MW_DATE_FORMAT)?></td>
                    <td data-title="Status"><?=MortgageWareLoan::$loanStatuses[$loan->status]?></td>
                    <td data-title="Action">
                        <?php
                        if ($loan->completed) {
                            ?>
                            <button class="btn btn-primary MWViewApp"><?=MW_VIEW_APP_BUTTON?></button>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-primary MWCompleteApp"><?=MW_COMPLETE_APP_BUTTON?></button>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
    <?php
                }
    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
        }
    ?>
    <button class="btn btn-primary mw-new-loan-app"><?=MW_NEW_APP_BUTTON?></button>
</div>
