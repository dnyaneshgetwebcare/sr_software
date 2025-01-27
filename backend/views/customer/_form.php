<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerMaster */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-control {
        font-size: medium;
        font-weight: 500;
    }

    .control-label {
        font-size: small;
        font-weight: 500;
    }
</style>

<div class="customer-master-form">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 mx-auto">
                                <?php
                                $dispOptions = ['class' => 'form-control kv-monospace'];

                                $saveOptions = [
                                    'type' => 'text',
                                    'label' => '<label>Saved Value: </label>',
                                    'class' => 'kv-saved',
                                    'readonly' => true,
                                    'tabindex' => 1000
                                ];

                                $saveCont = ['class' => 'kv-saved-cont', 'style' => 'display:none'];
                                $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => [
                                    'horizontalCssClasses' => [
                                        'label' => 'control-label',
                                        'offset' => 'col-sm-offset-2',
                                        'wrapper' => 'col-sm-6',
                                    ],
                                    'template' => "<div class='form-floating form-floating-custom '>{input}{label}</div>",

                                ]]); ?>
                                <!--<div class='form-floating form-floating-custom mb-3'>
              <input
                type="email"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
              />
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating form-floating-custom mb-3"><input type="text" id="customermaster-name1" class="form-control" name="CustomerMaster[name]" maxlength="150" aria-required="true" placeholder="name@example.com"/><label for="customermaster-name1">Name</label></div>-->

                                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]) ?>

                                <?= $form->field($model, 'email_id')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('email_id')]) ?>

                                <?= $form->field($model, 'contact_nos')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('contact_nos')]) ?>

                                <?= $form->field($model, 'contact_nos_2')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('contact_nos_2')]) ?>

                                <div class="form-group required">
                                    <label class="control-label col-sm-3"
                                           style=" padding: 7px 0 0 0; text-align: left;">Created Date</label>
                                    <div class="col-sm-6">
                                        <!-- <input type="text" id="customermaster-name" class="form-control" name="CustomerMaster[name]" maxlength="150" aria-required="true"> -->
                                        <?php $model['created_on'] = ($model['created_on'] != '') ? Yii::$app->formatter->asDate($model['created_on'], 'dd-MM-Y') : date('d-m-Y');

                                        echo DatePicker::widget([
                                            'name' => 'CustomerMaster[created_on]',

                                            'type' => DatePicker::TYPE_INPUT,
                                            'value' => $model['created_on'],
                                            //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                                            'options' => [
                                                'placeholder' => 'dd-mm-yyyy',
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'dd-mm-yyyy'
                                            ]
                                        ]); ?>

                                    </div>

                                </div>


                                <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('address'), 'style' => 'margin-bottom:10px']) ?>
                                <!-- --><?php /*= $form->field($model, 'address_group')->dropDownList($address_grup, ['class' => 'form-control']) */ ?>
                                <div style="margin-bottom: 10px">
                                    <?= $form->field($model, 'address_group')->widget(Select2::classname(), [
                                        'data' => $address_grup,
                                        'size' => Select2::MEDIUM,
                                        'theme' => Select2::THEME_BOOTSTRAP,
                                        'options' => ['placeholder' => 'Select Address Group'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false); ?>
                                </div>

                                <?php /*= $form->field($model, 'reference')->dropDownList(['None' => 'None', 'FaceBook' => 'FaceBook', 'Instagram' => 'Instagram', 'Google' => 'Google', 'Friend' => 'Friend',]) */ ?>

                                <?php $list = array('None' => 'None', 'FaceBook' => 'FaceBook', 'Instagram' => 'Instagram', 'Google' => 'Google', 'Friend' => 'Friend') ?>
                                <?= $form->field($model, 'reference')->widget(Select2::classname(), [
                                    'data' => $list,
                                    'size' => Select2::MEDIUM,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'options' => ['placeholder' => 'Select Reference'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false); ?>

                                <?= $form->field($model, 'reference_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('reference_name'), 'style' => 'margin-bottom:10px']) ?>


                                <!-- --><?php /*= $form->field($model, 'cust_group')->dropDownList(['None' => 'None', 'Photographer' => 'Photographer', 'Model' => 'Model', 'Friend' => 'Friend',]) */ ?>

                                <?php $cust_list = array('None' => 'None', 'Photographer' => 'Photographer', 'Model' => 'Model', 'Friend' => 'Friend') ?>
                                <div style="margin-bottom: 10px">
                                    <?= $form->field($model, 'cust_group')->widget(Select2::classname(), [
                                        'data' => $cust_list,
                                        'size' => Select2::MEDIUM,
                                        'theme' => Select2::THEME_BOOTSTRAP,
                                        'options' => ['placeholder' => 'Select Group', 'style' => 'margin-bottom:10px'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false); ?>
                                </div>
                                <div class="form-actions">
                                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-inverse ']) ?>
                                    <?php if ($model->id != "") {
                                        echo Html::a('Create Customer', ['create'], ['class' => 'btn btn-info']);
                                    } ?>

                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>