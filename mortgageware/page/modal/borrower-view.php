<?php
    $dob = new DateTime($borrower->birth_date);
    //var_dump($borrower);
    $key = 0;
    $addresses = array();
    $location = $borrower->location;
    $addresses[$key]['address'] = isset($location->location->address1)?$address = $location->location->address1.'<br>':'';
    $addresses[$key]['address'].= isset($location->location->address2)?$address = $location->location->address2.'<br>':'';
    $addresses[$key]['address'].= isset($location->location->city)?$location->location->city.', ':'';
    $addresses[$key]['address'].= $location->location->state->abbreviation.' '.$location->location->zipcode;
    $addresses[$key]['years'] = $location->years_at_location;
    $addresses[$key]['months'] = $location->months_at_location;
    $addresses[$key]['own'] = $location->own_residence;

?>
<div id="propertyInfo" class="MWLoanSection">
    <div>
        <div><strong>Home Phone: </strong> <?=$borrower->phone_home?></div>
        <div><strong>Email: </strong> <?=$borrower->email?></div>
        <div><strong>SSN: </strong> XXX-XX-<?=substr($borrower->ssn,-4)?></div>
        <div><strong>Birth Date: </strong> <?=$dob->format(MW_DATE_FORMAT)?></div>
        <div><strong>Marital Status: </strong> <?=MortgageWareBorrower::$maritial_statuses[$borrower->marital_status]?></div>
        <div><strong>Dependents: </strong> <?=MortgageWareForm::boolToYesNo($borrower->dependents)?></div>
        <br>
        <?php
        foreach($addresses as $address) {
            ?>
            <div><strong>Address: </strong><br><?=$address['address']?></div>
            <div><strong>Time at Residence: </strong> <?=$address['years']?> Years, <?=$address['months']?> Months</div>
            <div><strong>Own Residence: </strong> <?=MortgageWareForm::boolToYesNo($address['own'])?></div>
            <br>
            <?php
        }
        ?>
    </div>
</div>
