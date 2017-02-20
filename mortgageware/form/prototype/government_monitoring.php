<div class="mw-government-monitoring">
    <header>
        <h2>Information for Government Monitoring</h2>
        <?php

            if (property_exists($borrower,'govt_monitoring_opt_out')) {
                $checked = $borrower->govt_monitoring_opt_out;
            } else {
                $checked = false;
            }

            MortgageWareForm::displayInput($entity,'govt_monitoring_opt_out','checkbox',array(
                'required' => true,
                'inline' => true,
                'label' => 'I do not wish to furnish this information',
                'label_size' => 11,
                'class' => 'opt-out',
                'checked' => $checked,
                'value' => 1
            ));
        ?>
        <div class="mw-government-monitoring-info <?=$checked ? 'temp-hide' : ''?>">
            <?php
                MortgageWareForm::displayInput($entity,'ethnicity','select',array(
                    'required' => true,
                    'disabled' => $checked,
                    'label_size' => 2,
                    'input_size' => 4,
                    'options' => array(
                        'Hispanic or Latino',
                        'Not Hispanic or Latino',
                        'Not Applicable'
                    ),
                    'nullOption' => 'Select Your Ethnicity',
                    'value' => property_exists($borrower,'ethnicity') ? $borrower->ethnicity : ''
                ));

                MortgageWareForm::displayInput($entity,'race','select',array(
                    'required' => true,
                    'disabled' => $checked,
                    'label_size' => 2,
                    'input_size' => 4,
                    'options' => array(
                        'American Indian or Alaskan Native',
                        'Asian',
                        'Black or African American',
                        'Native Hawaiian or Other Pacific Islander',
                        'White/Caucasian',
                        'Not Applicable'
                    ),
                    'nullOption' => 'Select Your Race',
                    'value' => property_exists($borrower,'race') ? $borrower->race : ''
                ));

                MortgageWareForm::displayInput($entity,'is_male','radio',array(
                    'required' => true,
                    'disabled' => $checked,
                    'inline' => true,
                    'boolean' => true,
                    'label' => 'Gender',
                    'label_size' => 2,
                    'input_size' => 4,
                    'options' => array(
                        'Male',
                        'Female'
                    ),
                    'value' => property_exists($borrower,'is_male') ? $borrower->is_male : ''
                ));
            ?>
        </div>
    </header>
</div>