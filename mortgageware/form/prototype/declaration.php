<?php

    MortgageWareForm::displayInput($entity,'declaration_'.$declaration['name'],'declaration',array(
        'required' => true,
        'inline' => true,
        'group-style' => 'margin-bottom: 0px;',
        'label' => $declaration['label'],
        'label_size' => 7,
        'input_size' => 4,
        'class' => 'mw-declaration text-left',
        'data' => array('correct'=>$declaration['correct_answer'],'fields'=>isset($declarations['fields']) ? 'true' : 'false'),
        'value' => property_exists($borrower,'declaration_'.$declaration['name']) ? $borrower->{'declaration_'.$declaration['name']} : ''
    ));

    if (isset($declaration['correct_answer'])) {
        $disabled = property_exists($borrower,'declaration_'.$declaration['name']) ? !$borrower->{'declaration_'.$declaration['name']} : true;
        ?>
        <div id="<?=str_replace('[','-',str_replace(']','',$entity)).'-'.$declaration['name'].'-details'?>" <?=$disabled ? 'class="temp-hide"' : ''?>>
        <?php
            if (!isset($declaration['additional_fields'])) {

                MortgageWareForm::displayInput($entity,'declaration_'.$declaration['name'].'_details','textarea',array(
                    'required' => true,
                    'disabled' => $disabled,
                    'noLabel' => true,
                    'input_size' => 12,
                    'placeholder' => 'Please provide additional details...',
                    'value' => property_exists($borrower,'declaration_'.$declaration['name'].'_details') ? $borrower->{'declaration_'.$declaration['name'].'_details'} : ''
                ));
            } else {
                foreach ($declaration['additional_fields'] as $field => $params) {
                    if (isset($params['options'])) {
                        MortgageWareForm::displayInput($entity, 'declaration_' . $declaration['name'] . '_' . $field, 'select', array(
                            'required' => true,
                            'disabled' => $disabled,
                            'label' => $params['label'],
                            'options' => $params['options'],
                            'input_size' => 3,
                            'label_size' => 7,
                            'value' => property_exists($borrower, 'declaration_' . $declaration['name'] . '_' . $field) ? $borrower->{'declaration_' . $declaration['name'] . '_' . $field} : ''
                        ));
                    } else {
                        MortgageWareForm::displayInput($entity, 'declaration_' . $declaration['name'] . '_' . $field, 'text', array(
                            'required' => true,
                            'disabled' => $disabled,
                            'label' => ucwords(str_replace('_', ' ', $field)),
                            'input_size' => 3,
                            'label_size' => 7,
                            'prefix' => '$',
                            'suffix' => '.00',
                            'value' => property_exists($borrower, 'declaration_' . $declaration['name'] . '_' . $field) ? $borrower->{'declaration_' . $declaration['name'] . '_' . $field} : ''
                        ));
                    }
                }
            }
        ?>
        </div>
    <?php
    }