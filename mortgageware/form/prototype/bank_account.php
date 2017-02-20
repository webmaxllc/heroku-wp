<tr class="mw-asset-account">
    <td data-title="Borrower">
<?php
    if (($index > 0 || $index === 'prototype') && !property_exists($asset_account,'id')) {
?>
        <div class="mw-delete-bank-account"><span class="glyphicon glyphicon-remove"></span></div>
<?php
    }

        if (property_exists($asset_account,'id')) {
            ?>
            <input type="hidden" name="asset_account[<?=$index?>][id]" value="<?=$asset_account->id?>">
            <?php
        }
        MortgageWareForm::displayInput('asset_account','[borrower][id]','select',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Borrower',
            'options' => $borrowers,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'value' => property_exists($asset_account,'borrower') ? $asset_account->borrower->id : ''
        ),$index)
?>
    </td>
    <td data-title="Institution Name">
<?php
        MortgageWareForm::displayInput('asset_account','institution_name','text',array(
            'required' => true,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'value' => property_exists($asset_account,'institution_name') ? $asset_account->institution_name : ''
        ),$index)
?>

    </td>
    <td data-title="Type of Account">
<?php
        MortgageWareForm::displayInput('asset_account','type','select',array(
            'required' => true,
            'options' => array(
                'Checking',
                'Savings',
                'Money Market',
                'CD',
                'Mutual Fund',
                'Retirement',
                'Other'
            ),
            'noLabel' => true,
            'standalone' => true,
            'nullOption' => 'Select Type',
            'input_size' => 12,
            'value' => property_exists($asset_account,'type') ? $asset_account->type : ''
        ),$index)
?>
    </td>
    <td data-title="Account Number">
<?php
        MortgageWareForm::displayInput('asset_account','account_number','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($asset_account,'account_number') ? $asset_account->account_number : ''
        ),$index)
?>
    </td>
    <td data-title="Balance">
<?php
        MortgageWareForm::displayInput('asset_account','balance','text',array(
            'required' => true,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($asset_account,'balance') ? $asset_account->balance : ''
        ),$index)
?>
    </td>
</tr>
