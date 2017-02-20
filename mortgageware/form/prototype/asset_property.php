<div class="mw-asset-real-estate" id="mw-asset-real-estate<?=$index?>">
    <header>
        <h3><?php if (!property_exists($property,'id')) { ?><span class="glyphicon glyphicon-remove mw-delete-asset-real-estate pointer"></span><?php } ?> Property</h3>
    </header>
    <div class="col-md-6">
    <?php

        if (property_exists($property,'id')) {
            ?>
            <input type="hidden" name="asset_real_estate[<?=$index?>][id]" value="<?=$property->id?>">
            <input type="hidden" name="asset_real_estate[<?=$index?>][location][id]" value="<?=$property->location->id?>">
            <?php
        }

        MortgageWareForm::displayInput('asset_real_estate','[borrower][id]','select',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Borrower',
            'options' => $borrowers,
            'value' => property_exists($property,'borrower') ? $property->borrower->id : ''

        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','[location][address1]','text',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Address',
            'value' => property_exists($property,'location') ? $property->location->address1 : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','[location][city]','text',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'City',
            'value' => property_exists($property,'location') ? $property->location->city : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','[location][state][id]','select',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'State',
            'options' => $states,
            'nullOption' => 'Select a State',
            'value' => property_exists($property,'location') ? $property->location->state->id : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','[location][zipcode]','text',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Zipcode',
            'class' => 'zip',
            'value' => property_exists($property,'location') ? $property->location->zipcode : ''
        ),$index);
    ?>
    </div>
    <div class="col-md-6">
    <?php
        MortgageWareForm::displayInput('asset_real_estate','market_value','text',array(
            'required' => true,
            'prefix' => '$',
            'suffix' => '.00',
            'class' => 'integer',
            'value' => property_exists($property,'market_value') ? $property->market_value : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','mortgage_amount','text',array(
            'required' => true,
            'prefix' => '$',
            'suffix' => '.00',
            'class' => 'integer',
            'value' => property_exists($property,'mortgage_amount') ? $property->mortgage_amount : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','mortgage_payment','text',array(
            'required' => true,
            'prefix' => '$',
            'suffix' => '.00',
            'class' => 'integer',
            'value' => property_exists($property,'mortgage_payment') ? $property->mortgage_payment : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','rent_gross_income','text',array(
            'required' => true,
            'prefix' => '$',
            'suffix' => '.00',
            'class' => 'integer',
            'value' => property_exists($property,'rent_gross_income') ? $property->rent_gross_income : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','rent_net_income','text',array(
            'required' => true,
            'prefix' => '$',
            'suffix' => '.00',
            'class' => 'integer',
            'value' => property_exists($property,'rent_net_income') ? $property->rent_net_income : ''
        ),$index);

        MortgageWareForm::displayInput('asset_real_estate','ins_tax_exp','text',array(
            'required' => true,
            'prefix' => '$',
            'suffix' => '.00',
            'class' => 'integer',
            'value' => property_exists($property,'ins_tax_exp') ? $property->ins_tax_exp : ''
        ),$index);
    ?>
    </div>
    <div class="clearfix"></div>
</div>