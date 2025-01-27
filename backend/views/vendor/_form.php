<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VendorMaster */
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
<div class="vendor-master-form">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="form-body">
    <?php  $dispOptions = ['class' => 'form-control kv-monospace'];

    $saveOptions = [
        'type' => 'text',
        'label'=>'<label>Saved Value: </label>',
        'class' => 'kv-saved',
        'readonly' => true,
        'tabindex' => 1000
    ];

    $saveCont = ['class' => 'kv-saved-cont','style' => 'display:none'];
    $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2 control-label',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-6',
        ]]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_nos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group_id')->dropDownList([ 'None' => 'None', 'Supplier' => 'Supplier', 'Dry Cleaning' => 'Dry Cleaning', 'Alteration' => 'Alteration', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'In Active' => 'In Active', ], ['prompt' => '']) ?>

                        <div class="form-actions">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-inverse ']) ?>
                            <?php if($model->id!=""){ echo Html::a('Create New', ['create'], ['class' => 'btn btn-info']);  } ?>

                        </div>

    <?php ActiveForm::end(); ?>

</div>
                </div>
            </div>
        </div>
    </div>
</div>
