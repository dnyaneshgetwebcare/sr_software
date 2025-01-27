<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

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


 <?php
    $dispOptions = ['class' => 'form-control kv-monospace'];

    $saveOptions = [
        'type' => 'text',
        'label'=>'<label>Saved Value: </label>',
        'class' => 'kv-saved',
        'readonly' => true,
        'tabindex' => 1000
    ];

    $saveCont = ['class' => 'kv-saved-cont','style' => 'display:none'];
    $form = ActiveForm::begin(['layout' => 'horizontal','id'=>'quick_customer', 'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4 control-label',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-6',
        ]]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_nos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_nos_2')->textInput(['maxlength' => true]) ?>

<div class="form-group field-customermaster-name required">
<label class="control-label col-sm-4 control-label" for="customermaster-name">Created  Date</label>
<div class="col-sm-6">
<!-- <input type="text" id="customermaster-name" class="form-control" name="CustomerMaster[name]" maxlength="150" aria-required="true"> -->
 <?php  $model['created_on']=($model['created_on'] !='')?Yii::$app->formatter->asDate($model['created_on'],'dd-MM-Y'):date('d-m-Y');

                                echo DatePicker::widget([
                                    'name' => 'CustomerMaster[created_on]',

                                    'type' => DatePicker::TYPE_INPUT,
                                    'value'=> $model['created_on'],
                                    //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                                    'options' => [
                                        'placeholder' => 'dd-mm-yyyy',
                                    ],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'dd-mm-yyyy'
                                    ]
                                ]); ?>

</div>

</div>




    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'address_group')->dropDownList($address_grup, ['class'=>'form-control text_first']) ?>

    <?= $form->field($model, 'reference')->dropDownList([ 'None' => 'None', 'FaceBook' => 'FaceBook', 'Instagram' => 'Instagram', 'Google' => 'Google', 'Friend' => 'Friend', ]) ?>

    <?= $form->field($model, 'reference_name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'cust_group')->dropDownList([ 'None' => 'None', 'Photographer' => 'Photographer', 'Model' => 'Model', 'Friend' => 'Friend', ]) ?>

    <div class="form-actions">
        <?= Html::Button('Save', ['class' => 'btn btn-success','onClick'=>'save_new_customer()']) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-inverse ']) ?>
        <?php if($model->id!=""){ echo Html::a('Create Customer', ['create'], ['class' => 'btn btn-info']);  } ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
                </div>
            </div>
        </div>
    </div>
</div>