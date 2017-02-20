<tr class="mw-income-monthly">
    <td data-title="Borrower">
<?php
    if (($index > 0 || $index === 'prototype') && !property_exists($income,'id')) {
?>
        <div class="mw-delete-income"><span class="glyphicon glyphicon-remove"></span></div>
<?php
    }
    if (property_exists($income,'id')) {
        ?>
        <input type="hidden" name="income_monthly[<?=$index?>][id]" value="<?=$income->id?>">
        <?php
    }
        MortgageWareForm::displayInput('income_monthly','[borrower][id]','select',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Borrower',
            'options' => $borrowers,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'value' => property_exists($income,'borrower') ? $income->borrower->id : ''
        ),$index)
?>
    </td>
    <td data-title="Base">
<?php
        MortgageWareForm::displayInput('income_monthly','base','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'base') ? $income->base : ''
        ),$index)
?>

    </td>
    <td data-title="Overtime">
<?php
        MortgageWareForm::displayInput('income_monthly','overtime','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'overtime') ? $income->overtime : ''
        ),$index)
?>
    </td>
    <td data-title="Bonus">
<?php
        MortgageWareForm::displayInput('income_monthly','bonus','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'bonus') ? $income->bonus : ''
        ),$index)
?>
    </td>
    <td data-title="Commission">
<?php
        MortgageWareForm::displayInput('income_monthly','commission','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'commission') ? $income->commission : ''
        ),$index)
?>
    </td>
    <td data-title="Interest">
        <?php
        MortgageWareForm::displayInput('income_monthly','interest','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'interest') ? $income->interest : ''
        ),$index)
        ?>
    </td>
    <td data-title="Net Rent">
        <?php
        MortgageWareForm::displayInput('income_monthly','rent_net','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'rent_net') ? $income->rent_net : ''
        ),$index)
        ?>
    </td>
    <td data-title="Other">
        <?php
        MortgageWareForm::displayInput('income_monthly','other','text',array(
            'required' => false,
            'noLabel' => true,
            'standalone' => true,
            'input_size' => 12,
            'class' => 'integer',
            'value' => property_exists($income,'other') ? $income->other : ''
        ),$index)
        ?>
    </td>
</tr>
