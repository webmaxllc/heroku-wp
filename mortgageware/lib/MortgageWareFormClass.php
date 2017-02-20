<?php

/**
 * Class MortgageWareForm
 */
class MortgageWareForm
{

    /**
     * Display Input
     *
     * @param $entity
     * @param $name
     * @param string $type
     * @param array $params
     * @param int $index
     */
    public static function displayInput($entity,$name,$type='text',$params=array(),$index=null) {
        $label = $name;

        if (isset($params['semi_natural'])) {
            if (is_numeric($index) || $index == 'prototype') {
                $name = $entity.'['.$index.']'.$name;
            } else {
                $name = $entity.$name;
            }
        } else if (!isset($params['natural'])) {
            if (is_numeric($index) || $index == 'prototype') {
                $name = $entity.'['.$index.']['.$name.']';
            } else {
                $name = $entity.'['.$name.']';
            }
        }

        $params = self::setDefaults($params,array(
            'id' => 'mw_'.$name,
            'class' => '',
            'value' => '',
            'noLabel' => false,
            'standalone' => false,
            'label' => ucwords(str_replace('_',' ',$label)),
            'required' => false,
            'disabled' => false,
            'hidden' => false,
            'label_size' => 4,
            'input_size' => 7,
            'maxlength' => ''
        ));

        if (!$params['standalone']) {
            ?>
            <div class="form-group <?=$params['hidden']?'temp-hide':''?>" <?=isset($params['group-style']) ? 'style="'.$params['group-style'].'"' : ''?>>
            <?php
        }

        $data = [];
        if ( isset($params['data']) && is_array($params['data'])) {
            foreach($params['data'] as $dataName => $dataValue) {
                $data[] = 'data-'.$dataName.'="'.$dataValue.'"';
            }
        }
        switch($type) {

            // STANDARD TEXT ENTRY
            case 'text':
                if (!isset($params['placeholder'])) $params['placeholder'] = '';
                if (!isset($params['maxlength'])) $params['maxlength'] = '';
                if (!$params['noLabel']) {
                    ?>
                    <label for="<?=$params['id']?>" class="col-sm-12 col-md-<?=$params['label_size']?> control-label text-right <?=$params['class']?>"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                    <?php
                }
                ?>
            <div class="col-sm-12 col-md-<?=$params['input_size']?>">
                <?php
            if (isset($params['prefix']) || isset($params['suffix'])) {
                ?>
                <div class="input-group">
                <?php
            }
                if (isset($params['prefix'])) {
                    ?>
                    <div class="input-group-addon"><?=$params['prefix']?></div>
                    <?php
                }
                ?>
                <input
                    type="text"
                    name="<?=$name?>"
                    class="form-control <?=$params['class']?>"
                    id="<?=$params['id']?>"
                    maxlength="<?=$params['maxlength']?>"
                    placeholder="<?=$params['placeholder']?>"
                    <?=$params['required']===true?'required="required"':''?>
                    <?=$params['disabled']===true?'disabled="disabled"':''?>
                    <?=implode(' ',$data)?>
                    value="<?=$params['value']?>"
                >
                <?php
                if (isset($params['suffix'])) {
                    ?>
                    <div class="input-group-addon"><?=$params['suffix']?></div>
                    <?php
                }
            if (isset($params['prefix']) || isset($params['suffix'])) {
                ?>
                </div>
                <?php
            }
                if (!$params['standalone']) {
                    ?>
                    </div>

                    <?php
                }
                break;

            // TEXTAREA
            case 'textarea':
                if (!isset($params['placeholder'])) $params['placeholder'] = '';
                if (!isset($params['maxlength'])) $params['maxlength'] = '';
                if (!$params['noLabel']) {
                    ?>
                    <label for="<?=$params['id']?>" class="col-sm-<?=$params['label_size']?> control-label text-right <?=$params['class']?>"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                    <?php
                }
                ?>
            <div class="col-sm-<?=$params['input_size']?>">
                <?php
            if (isset($params['prefix']) || isset($params['suffix'])) {
                ?>
                <div class="input-group">
                <?php
            }
                if (isset($params['prefix'])) {
                    ?>
                    <div class="input-group-addon"><?=$params['prefix']?></div>
                    <?php
                }
                ?>
                <textarea
                    name="<?=$name?>"
                    class="form-control <?=$params['class']?>"
                    id="<?=$params['id']?>"
                    maxlength="<?=$params['maxlength']?>"
                    placeholder="<?=$params['placeholder']?>"
                    <?=$params['required']===true?'required="required"':''?>
                    <?=$params['disabled']===true?'disabled="disabled"':''?>
                    <?=implode(' ',$data)?>
                ><?=$params['value']?></textarea>
                <?php
                if (isset($params['suffix'])) {
                    ?>
                    <div class="input-group-addon"><?=$params['suffix']?></div>
                    <?php
                }
            if (isset($params['prefix']) || isset($params['suffix'])) {
                ?>
                </div>
                <?php
            }
                if (!$params['standalone']) {
                    ?>
                    </div>

                    <?php
                }
                break;

            // PASSWORD
            case 'password':
                if (!isset($params['placeholder'])) $params['placeholder'] = '';
                if (!isset($params['maxlength'])) $params['maxlength'] = '';
                if (!$params['noLabel']) {
                    ?>
                    <label for="<?=$params['id']?>" class="col-sm-12 col-md-<?=$params['label_size']?> control-label text-right"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                    <?php
                }
                ?>
                <div class="col-sm-12 col-md-<?=$params['input_size']?>">
                    <input
                        type="password"
                        name="<?=$name?>"
                        class="form-control <?=$params['class']?>"
                        id="<?=$params['id']?>"
                        maxlength="<?=$params['maxlength']?>"
                        placeholder="<?=$params['placeholder']?>"
                        <?=$params['required']===true?'required="required"':''?>
                        <?=$params['disabled']===true?'disabled="disabled"':''?>
                        value="<?=$params['value']?>"
                    >
                </div>
                <?php
                break;

            // TEXT GROUP
            case 'text_group':
                ?>
                <label class="col-sm-12 col-md-<?=$params['label_size']?> control-label text-right"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                <div class="col-sm-12 col-md-<?=$params['input_size']?>">
                    <?php
                    foreach ($params['fields'] as $field) {
                        if (isset($field['semi_natural']) && $field['semi_natural']) {
                            if (is_numeric($index)) {
                                $name = $entity.'['.$index.']'.$field['name'];
                            } else {
                                $name = $entity.$field['name'];
                            }
                        } else if (!isset($params['natural']) || !$field['natural']) {
                            if (is_numeric($index)) {
                                $name = $entity.'['.$index.']['.$field['name'].']';
                            } else {
                                $name = $entity.'['.$field['name'].']';
                            }
                        }
                        $field = self::setDefaults($field,array(
                            'id' => $name,
                            'class' => '',
                            'value' => '',
                            'label' => ucwords(str_replace('_',' ',$field['name'])),
                            'noLabel' => false,
                            'required' => false,
                            'disabled' => false,
                            'label_size' => 3,
                            'label_class' => 'text-right',
                            'input_size' => 3,
                            'maxlength' => '',
                            'placeholder' => '',
                            'col_class' => ''
                        ));

                        if (!$field['noLabel']) {
                            ?>
                            <label for="<?=$field['id']?>" class="col-sm-<?=$field['label_size']?> <?=$field['label_class']?> group-label no-pad-right"><?=$field['label']?></label>
                            <?php
                            }
                        ?>
                        <div class="col-sm-<?=$field['input_size']?> <?=$field['col_class']?>">
                            <input
                                type="text"
                                name="<?=$name?>"
                                class="form-control <?=$field['class']?>"
                                id="<?=$field['id']?>"
                                maxlength="<?=$field['maxlength']?>"
                                placeholder="<?=$field['placeholder']?>"
                                <?=$field['required']===true?'required="required"':''?>
                                <?=$field['disabled']===true?'disabled="disabled"':''?>
                                value="<?=$field['value']?>"
                            >
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <?php
                break;

            // SOCIAL SECURITY NUMBER
            case 'ssn':
                if (!isset($params['placeholder'])) $params['placeholder'] = '';
                if (!$params['noLabel']) {
                    ?>
                    <label for="<?=$params['id']?>" class="col-sm-12 col-md-<?=$params['label_size']?> control-label text-right"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                    <?php
                }
                ?>
                <div class="col-sm-12 col-md-<?=$params['input_size']?>">
                    <input
                        type="text"
                        class="form-control ssn <?=$params['class']?>"
                        id="<?=$params['id']?>"
                        placeholder="<?=$params['placeholder']?>"
                        <?=$params['required']===true?'required="required"':''?>
                        <?=$params['disabled']===true?'disabled="disabled"':''?>
                        value="<?=$params['value']?'***-**-****':''?>"
                    >
                    <input
                        type="hidden"
                        name="<?=$name?>"
                        class="ssn-val"
                        value="<?=$params['value']?>"
                        <?=$params['disabled']===true?'disabled="disabled"':''?>
                    >
                </div>
                <?php
                break;

            // SELECT BOX
            case 'select':
                if (!isset($params['nullOption'])) $params['nullOption'] = '';
                if (!isset($params['options'])) $params['options'] = array();
                if (!$params['noLabel']) {
                    ?>
                    <label for="<?= $params['id'] ?>" class="col-sm-12 col-md-<?= $params['label_size'] ?> control-label text-right"><?= $params['label'] ?> <?= $params['required'] ? '<span class="required-asterisk" title="This field is required">*</span>' : '' ?></label>
                    <?php
                }
                ?>
                <div class="col-sm-12 col-md-<?=$params['input_size']?>">
                    <select
                        name="<?=$name?>"
                        class="form-control <?=$params['class']?>"
                        id="<?=$params['id']?>"
                        <?=$params['required']===true?'required="required"':''?>
                        <?=$params['disabled']===true?'disabled="disabled"':''?>>
                        <?php
                        if ($params['nullOption']) {
                            ?>
                            <option value=""><?=$params['nullOption']?></option>
                            <?php
                        }
                        foreach($params['options'] as $value => $option) {
                            if (is_array($option)) {
                                ?>
                                <optgroup label="<?=$value?>">
                                    <?php
                                    foreach($option as $val => $opt) {
                                        ?>
                                        <option value="<?=$val?>" <?=$params['value'] === $val ? 'selected' : ''?>><?=$opt?></option>
                                        <?php
                                    }
                                    ?>
                                </optgroup>
                                <?php
                            } else {
                                ?>
                                <option value="<?=$value?>" <?=$params['value'] === $value ? 'selected' : ''?>><?=$option?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php
                break;
            // RADIO BUTTON
            case 'radio':
                if (!isset($params['inline'])) $params['inline'] = false;
                if (!isset($params['boolean'])) $params['boolean'] = false;
                ?>
                <label class="col-sm-12 col-md-<?=$params['label_size']?> control-label text-right"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                <?php
                foreach ($params['options'] as $value => $option) {
                    $checked = '';
                    if (!$params['boolean']) {
                        if ($params['value'] === $value) {
                            $checked = 'checked';
                        }
                    } else {
                        if ($value == 0 && $params['value'] === true) {
                            $checked = 'checked';
                        } else if ($value == 1 && $params['value'] === false) {
                            $checked = 'checked';
                        }
                    }
                    ?>
                    <div class="radio<?=$params['inline']?'-inline':''?>">
                        <label>
                            <input
                                type="radio"
                                name="<?=$name?>"
                                class="<?=$params['class']?>"
                                id="<?=$params['id']?>_<?=$value?>"
                                value="<?=$value?>"
                                <?=$checked?>
                                <?=$params['required']===true?'required="required"':''?>
                                <?=$params['disabled']===true?'disabled="disabled"':''?>
                            >
                            <?=$option?>
                        </label>
                    </div>
                    <?php
                }
                break;
            // CHECKBOX
            case 'checkbox':
                if (!isset($params['inline'])) $params['inline'] = false;
                if (!isset($params['checked'])) $params['checked'] = false;
                ?>
                <div class="checkbox<?=$params['inline']?'-inline':''?> col-sm-<?=$params['label_size']?> <?=isset($params['label_offset']) ? 'col-md-offset-'.$params['label_offset'] : ''?>">
                    <label class="control-label">
                        <input
                            type="checkbox"
                            name="<?=$name?>"
                            class="checkbox <?=$params['class']?>"
                            id="<?=$params['id']?>"
                            value="<?=$params['value']?>"
                            <?=$params['checked']?'checked':''?>
                            <?=$params['required']===true?'required="required"':''?>
                            <?=$params['disabled']===true?'disabled="disabled"':''?>
                        >
                        <?=$params['label']?>
                    </label>
                </div>
                <?php
                break;

            // BOOLEAN RADIO
            case 'boolean':
                if (!isset($params['inline'])) $params['inline'] = false;
                if (strpos($params['label'],'?') === false) $params['label'].= '?';
                ?>
                <label class="col-sm-<?=$params['label_size']?> control-label text-right"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                <div class="col-sm-<?=$params['input_size']?> boolean-group" <?=implode(' ',$data)?>>
                    <div class="radio<?=$params['inline']?'-inline':''?>">
                        <label class="radio-label">
                            <input
                                type="radio"
                                name="<?=$name?>"
                                class="<?=$params['class']?>"
                                id="<?=$params['id']?>_1"
                                value="1"
                                <?=$params['value']===true?'checked':''?>
                                <?=$params['required']===true?'required="required"':''?>
                                <?=$params['disabled']===true?'disabled="disabled"':''?>
                            >
                            Yes
                        </label>
                    </div>
                    <div class="radio<?=$params['inline']?'-inline':''?>">
                        <label class="radio-label">
                            <input type="radio"
                                   name="<?=$name?>"
                                   class="<?=$params['class']?>"
                                   id="<?=$params['id']?>_0"
                                   value="0"
                                <?=$params['value']===false?'checked':''?>
                                <?=$params['required']===true?'required="required"':''?>
                                <?=$params['disabled']===true?'disabled="disabled"':''?>
                            >
                            No
                        </label>
                    </div>
                </div>
                <?php
                break;
            // BOOLEAN RADIO
            case 'declaration':
                if (!isset($params['inline'])) $params['inline'] = false;
                if (strpos($params['label'],'?') === false) $params['label'].= '?';
                ?>
                <label class="col-sm-<?=$params['label_size']?> control-label text-left"><?=$params['label']?> <?=$params['required']?'<span class="required-asterisk" title="This field is required">*</span>':''?></label>
                <div class="col-sm-<?=$params['input_size']?> boolean-group" <?=isset($params['correct_answer'])?'data-correct="'.$params['correct_answer'].'"':''?> <?=implode(' ',$data)?>>
                    <div class="radio<?=$params['inline']?'-inline':''?>">
                        <label class="radio-label">
                            <input
                                type="radio"
                                name="<?=$name?>"
                                class="<?=$params['class']?>"
                                id="<?=$params['id']?>_1"
                                value="1"
                                <?=$params['value']===true?'checked':''?>
                                <?=$params['required']===true?'required="required"':''?>
                                <?=$params['disabled']===true?'disabled="disabled"':''?>
                            >
                            Yes
                        </label>
                    </div>
                    <div class="radio<?=$params['inline']?'-inline':''?>">
                        <label class="radio-label">
                            <input type="radio"
                                   name="<?=$name?>"
                                   class="<?=$params['class']?>"
                                   id="<?=$params['id']?>_0"
                                   value="0"
                                <?=$params['value']===false?'checked':''?>
                                <?=$params['required']===true?'required="required"':''?>
                                <?=$params['disabled']===true?'disabled="disabled"':''?>
                            >
                            No
                        </label>
                    </div>
                </div>
                <?php
                break;

        }
        ?>
        <div class="clearfix"></div>
        </div>
        <?php

    }

    /**
     * Display Submit
     *
     * @param $text
     * @param string $class
     */
    public static function displaySubmit($text,$class="btn-primary")
    {
        ?>
        <div class="form-group text-center">
            <button class="btn <?=$class?>" type="submit"><?=$text?></button>
        </div>
        <?php
    }


    /**
     * Display Save/Cancel
     *
     * @param $text
     * @param string $class
     */
    public static function displaySaveCancel($params=array())
    {
        $saveText = isset($params['saveText'])?$params['saveText']:'Save';
        $saveClass = isset($params['saveClass'])?$params['saveClass']:'btn-primary';
        $cancelText = isset($params['cancelText'])?$params['cancelText']:'Cancel';
        $cancelClass = isset($params['cancelClass'])?$params['cancelClass']:'btn-danger';
        ?>
        <div class="form-group text-center">
            <button class="btn <?=$saveClass?> save" type="submit"><?=$saveText?></button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="btn <?=$cancelClass?> cancel" type="button"><?=$cancelText?></button>
        </div>
        <?php
    }

    /**
     * Set Input Defaults
     *
     * @param $params
     * @param $defaults
     * @return mixed
     */
    public static function setDefaults($params,$defaults)
    {
        foreach ($defaults as $parameter => $default) {
            if (!isset($params[$parameter])) $params[$parameter] = $default;
        }
        return $params;
    }

    /**
     * Boolean to Yes/No
     *
     * @param $data
     */
    public static function boolToYesNo($data)
    {
        return $data?'Yes':'No';
    }

    /**
     * Boolean to Yes/No
     *
     * @param $data
     */
    public static function boolToYN($data)
    {
        return $data?'Y':'N';;
    }
}
