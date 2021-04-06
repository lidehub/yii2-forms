<?php

namespace common\components\FormHtml;

use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2020/6/4
 * Time: 16:20
 */
class FormHtmls
{
    public $model;
    public $fields;
    public $keyHtmlType;
    public $defaultSelectArr = [
        'point' => '学币',
        'gold' => '金币'
    ];

    public function createAtagBtn($model, $fields, $haveRight = true)
    {
        $attributeLabels = $model->attributeLabels();
        if (!isset($attributeLabels[$fields])) {
            return '';
        }
        $atext = '添加' . $attributeLabels[$fields] . '配置';

        $aBtn = Html::a('添加配置<i class="fa fa-plus"></i>', 'javascript:void(0)', ['id' => 'reward-create', 'class' => 'btn btn-default btn-sm reward-create', 'title' => $atext,]);
        $contenDiv = Html::tag('div', $aBtn, ['class' => 'col-xs-8 col-sm-8']);
        $right = '';
        if ($haveRight == true) {
            $right = $attributeLabels[$fields];
        }
        $label = Html::tag('label', $right, ['class' => 'control-label', 'for' => '']);
        $rightDiv = Html::tag('div', $label, ['class' => 'col-xs-2 col-sm-2 text-right']);
        $boxDiv = Html::tag('div', $rightDiv . $contenDiv, ['class' => 'row row-box']);
        $createDiv = Html::tag('div', $boxDiv, ['class' => 'form-group btn-reward-create', 'id' => 'btn-reward-create']);

        return $createDiv;
    }

    public function createFieldsKeyValuePair($model, $fields, $keyType = 'select', $SelectArr = array())
    {
        $Classname = $model::className();
        $Classname = strrchr($Classname, '\\');
        $Classname = trim($Classname, '\\');
        $fieldName = $Classname . '[' . $fields . ']';

        if (empty($SelectArr)) {
            $SelectArr = $this->defaultSelectArr;
        }

        $helpDiv = Html::tag('div', '', ['class' => 'help-block']);
        $content = $model->$fields;
        $textDiv = '';
        $showstyle = '';
        if (empty($content)) {
            $parentContent = ['point' => ''];
            $showstyle = 'display: none;';
        } else {
            $parentContent = json_decode($content, true);
        }
        if (is_array($parentContent)) {
            foreach ($parentContent as $k => $v) {
                $keyContent = Html::textInput($fieldName . '[key][]', $k, ['class' => 'form-control', 'placeholder' => '键']);
                if ($keyType == 'select') {
                    $keyContent = Html::dropDownList($fieldName . '[key][]', $k, $SelectArr, ['class' => 'form-control', 'placeholder' => '键', 'prompt' => '==请选择配置项==']);
                }
                $keycontentDiv = Html::tag('div', $keyContent . $helpDiv, ['class' => 'col-lg-10']);
                $keylabel = Html::tag('label', '', ['class' => 'col-primary-1 control-label', 'for' => 'reward-key']);
                $keyrightDiv = Html::tag('div', $keylabel, ['class' => 'col-xs-2 col-sm-2 text-right']);
                $keygroupDiv = Html::tag('div', $keyrightDiv . $keycontentDiv, ['class' => 'form-group field-reward-key required']);

                $valContent = Html::textInput($fieldName . '[value][]', $v, ['class' => 'form-control', 'placeholder' => '值']);
                $valcontentDiv = Html::tag('div', $valContent . $helpDiv, ['class' => 'col-lg-10']);
                $vallabel = Html::tag('label', '', ['class' => 'col-primary-1 control-label', 'for' => 'reward-value']);
                $valrightDiv = Html::tag('div', $vallabel, ['class' => 'col-xs-2 col-sm-2 text-right']);
                $valgroupDiv = Html::tag('div', $valrightDiv . $valcontentDiv, ['class' => 'form-group field-reward-value required']);

                $aBtn = Html::a('<i class="glyphicon glyphicon-minus"></i>', 'javascript:void(0)', ['id' => 'reward-delone', 'class' => 'btn btn-danger btn-xs', 'title' => '删除此项',]);
                $textDiv .= Html::tag('div', $keygroupDiv . $valgroupDiv . $aBtn, ['class' => 'form-group highlight-addon reward-text col-lg-12','style'=>$showstyle]);
            }
        }
        $boxDiv = Html::tag('div', $textDiv, ['class' => 'reward-box']);

        return $boxDiv;
    }

}