<div class="mw-borrower <?=$entity?>" id="<?=$entity?>">
    <header>
<?php
        if ($entity == 'borrower') {
            if (property_exists($loan,'borrower')) {
                $borrower = $loan->borrower;
            } else {
                $borrower = new StdClass();
            }
?>
        <h3>Borrower Information</h3>
        <p>In order to get started, we need to gather some basic personal information along with choosing whether you&#39;ll have a co-borrower.</p>
<?php
        } else {
            $entity = 'co_borrower[0]';
            if (property_exists($loan,'co_borrower') && !empty($loan->co_borrower)) {
                $borrower = $loan->co_borrower[0];
            } else {
                $borrower = new StdClass();
            }
?>
            <h3><span id="mw-remove-co-borrower" title="Remove Co-Borrower" class="glyphicon glyphicon-remove pointer"></span> Co-Borrower Information</h3>
<?php
        }
?>
    </header>
    <div class="col-md-6">
<?php
        MortgageWareForm::displayInput($entity,'first_name','text',array(
            'required' => true,
            'value' => property_exists($borrower,'first_name')?$borrower->first_name:''
        ));

        MortgageWareForm::displayInput($entity,'middle_initial','text',array(
            'required' => false,
            'value' => property_exists($borrower,'middle_initial')?$borrower->middle_initial:''
        ));

        MortgageWareForm::displayInput($entity,'last_name','text',array(
             'required' => true,
            'value' => property_exists($borrower,'last_name')?$borrower->last_name:''
        ));

        MortgageWareForm::displayInput($entity,'suffix','text',array(
            'required' => false,
            'value' => property_exists($borrower,'suffix')?$borrower->suffix:''
        ));

        MortgageWareForm::displayInput($entity,'[location][location][address1]','text',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Address',
            'value' => property_exists($borrower,'location')?$borrower->location->location->address1:''
        ));

        MortgageWareForm::displayInput($entity,'[location][location][city]','text',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'City',
            'value' => property_exists($borrower,'location')?$borrower->location->location->city:''
        ));

        MortgageWareForm::displayInput($entity,'[location][location][state][id]','select',array(
            'required' => true,
            'options' => $states,
            'nullOption' => 'Select a State',
            'label' => 'State',
            'semi_natural' => true,
            'value' => property_exists($borrower,'location')?$borrower->location->location->state->id:''
        ));

        MortgageWareForm::displayInput($entity,'[location][location][zipcode]','text',array(
            'required' => true,
            'semi_natural' => true,
            'label' => 'Zipcode',
            'value' => property_exists($borrower,'location')?$borrower->location->location->zipcode:''
        ));

        /*MortgageWareForm::displayInput($entity,'[location][years_at_location]','text',array(
            'required' => true,
            'semi_natural' => true,
            'maxlength' => 2,
            'label' => 'Years At Residence',
            'value' => property_exists($borrower,'location')?$borrower->location->years_at_location:''
        ));

        MortgageWareForm::displayInput($entity,'[location][months_at_location]','text',array(
            'required' => true,
            'semi_natural' => true,
            'maxlength' => 2,
            'label' => 'Months At Residence',
            'value' => property_exists($borrower,'location')?$borrower->location->months_at_location:''
        ));
        */

        MortgageWareForm::displayInput($entity,'time_at_residence','text_group',array(
            'fields' => array(
                array(
                    'name' => '[location][years_at_location]',
                    'noLabel' => true,
                    'required' => true,
                    'maxlength' => 2,
                    'input_size'=> 6,
                    'col_class' => 'no-pad-left',
                    'class' => 'integer',
                    'placeholder'=>'Years',
                    'semi_natural' => true,
                    'value' => property_exists($borrower,'location')?$borrower->location->years_at_location:''
                ),
                array(
                    'name' => '[location][months_at_location]',
                    'noLabel' => true,
                    'required' => true,
                    'input_size'=> 6,
                    'col_class'=>'no-pad-right',
                    'class' => 'integer',
                    'placeholder'=>'Months',
                    'maxlength' => 2,
                    'semi_natural' => true,
                    'value' => property_exists($borrower,'location')?$borrower->location->months_at_location:''
                ),
            ),
            'input_size' => 7,
            'label' => 'Years/Months at Residence',
            'required' => true,
            'semi_natural' => true
        ));

?>
    </div>
    <div class="col-md-6">
<?php
        MortgageWareForm::displayInput($entity,'phone_home','text',array(
            'required' => true,
            'class' => 'phone',
            'value' => property_exists($borrower,'phone_home')?$borrower->phone_home:'',
            'label' => 'Primary Phone'
        ));

        MortgageWareForm::displayInput($entity,'email','text',array(
            'required' => true,
            'value' => property_exists($borrower,'email')?$borrower->email:''
        ));

        MortgageWareForm::displayInput($entity,'ssn','ssn',array(
            'required' => true,
            'label' => 'SSN',
            'value' => property_exists($borrower,'ssn')?$borrower->ssn:''
        ));

        if (property_exists($borrower,'birth_date')) {
            $birth_date = new DateTime($borrower->birth_date);
            $birth_date = $birth_date->format('m/d/y');
        } else {
            $birth_date = null;
        }
        MortgageWareForm::displayInput($entity,'birth_date','text',array(
            'required' => true,
            'class' => 'dob date',
            'label' => 'Birth Date',
            'value' => $birth_date
        ));

        MortgageWareForm::displayInput($entity,'years_of_school','text',array(
            'required' => true,
            'value' => property_exists($borrower,'years_of_school')?$borrower->years_of_school:''
        ));

        MortgageWareForm::displayInput($entity,'marital_status','select',array(
            'required' => true,
            'options' => array(
                'Married',
                'Unmarried',
                'Separated'
            ),
            'nullOption' => 'Select a Value',
            'value' => property_exists($borrower,'marital_status')?$borrower->marital_status:''
        ));

        $own_residence = null;
        if (property_exists($borrower,'location')) {
            if (property_exists($borrower->location,'own_residence')) {
                $own_residence = $borrower->location->own_residence;
            }
        }
        MortgageWareForm::displayInput($entity,'[location][own_residence]','boolean',array(
            'required' => true,
            'inline' => true,
            'label' => 'Own this residence?',
            'semi_natural'=>true,
            'value' => $own_residence
        ));

        MortgageWareForm::displayInput($entity,'dependents','boolean',array(
            'required' => true,
            'inline' => true,
            'class' => 'dependents',
            'value' => property_exists($borrower,'dependents')?$borrower->dependents:''
        ));
?>
        <div class="dependents_extra <?=property_exists($borrower,'dependents')&&$borrower->dependents?'':'temp-hide'?>">
<?php
            MortgageWareForm::displayInput($entity,'num_dependents','text',array(
                'required' => 'maybe',
                'label' => '# Dependents',
                'class' => 'integer',
                'value' => property_exists($borrower,'num_dependents')?$borrower->num_dependents:''
            ));

            MortgageWareForm::displayInput($entity,'ages_dependents','text',array(
                'required' => 'maybe',
                'label' => 'Ages',
                'value' => property_exists($borrower,'ages_dependents')?$borrower->ages_dependents:''
            ));
?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
