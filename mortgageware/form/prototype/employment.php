<?php
    $start_date = property_exists($employment,'start_date') ? new DateTime($employment->start_date) : '';
    $end_date = property_exists($employment,'end_date') ? new DateTime($employment->end_date) : new DateTime();
    $current = property_exists($employment,'current') ? $employment->current : true;
    ?>
    <div id="<?= $type ?>_<?= $index ?>" class="mw-employment-record">
        <?php
            if (property_exists($employment,'id')) {
        ?>
                <input type="hidden" name="<?=$entity?>[employment][<?=$index?>][id]" value="<?= $employment->id ?>">
                <input type="hidden" name="<?=$entity?>[employment][<?=$index?>][location][id]" value="<?= $employment->location->id ?>">
        <?php
            }
        ?>

        <div class="col-md-6">
            <?php
            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][employer_name]', 'text', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Employer Name',
                'value' => property_exists($employment, 'employer_name') ? $employment->employer_name : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][location][address1]', 'text', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Employer Address',
                'value' => property_exists($employment, 'location') ? $employment->location->address1 : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][location][city]', 'text', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Employer City',
                'value' => property_exists($employment, 'location') ? $employment->location->city : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][location][state][id]', 'select', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Employer State',
                'options' => $states,
                'nullOption' => 'Select a State',
                'value' => property_exists($employment, 'employer_name') ? $employment->location->state->id : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][location][zipcode]', 'text', array(
                'required' => true,
                'semi_natural' => true,
                'disabled' => $disabled,
                'label' => 'Employer Zipcode',
                'value' => property_exists($employment, 'location') ? $employment->location->zipcode : ''
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][employer_phone]', 'text', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Employer Phone',
                'class' => 'phone',
                'value' => property_exists($employment, 'employer_phone') ? $employment->employer_phone : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][current]', 'boolean', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Current Employer?',
                'class' => 'current-employment-radio',
                'inline' => true,
                'value' => $current
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][time_of_employment]', 'text_group', array(
                'label' => 'Time of Employment',
                'fields' => array(
                    array(
                        'name' => '[employment][' . $index . '][start_date]',
                        'semi_natural'=>true,
                        'label' => '',
                        'class' => 'date start',
                        'col_class' => 'no-pad-left no-pad-right',
                        'label_size' => 0,
                        'input_size' => 5,
                        'disabled' => $disabled,
                        'value' => property_exists($employment, 'start_date') ? $start_date->format('m/d/Y') : ''
                    ),
                    array(
                        'name' => '[employment][' . $index . '][end_date]',
                        'label' => '&nbsp; to',
                        'semi_natural'=>true,
                        'label_class' => 'text-left',
                        'class' => 'date end',
                        'col_class' => 'no-pad-left no-pad-right',
                        'label_size' => 2,
                        'input_size' => 5,
                        'disabled' => $current===true?true:$disabled,
                        'value' => $end_date ? $end_date->format('m/d/Y') : ''
                    )
                ),
                'required' => true,
                'disabled' => $disabled
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][title]', 'text', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Position / Job Title',
                'value' => property_exists($employment, 'title') ? $employment->title : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][self_employed]', 'boolean', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Self Employed?',
                'inline' => true,
                'value' => property_exists($employment, 'self_employed') ? $employment->self_employed : ''
            ));

            MortgageWareForm::displayInput($entity, '[employment][' . $index . '][years_employed]', 'text', array(
                'required' => true,
                'disabled' => $disabled,
                'semi_natural' => true,
                'label' => 'Years Employed In This Line of Work',
                'class' => 'number',
                'value' => property_exists($employment, 'years_employed') ? $employment->years_employed : ''
            ));
            ?>
        </div>
        <div class="clearfix"></div>
    </div>