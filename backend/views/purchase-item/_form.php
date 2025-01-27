<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'purhcase_id')->textInput() ?>

    <?= $form->field($model, 'item_code')->textInput() ?>

    <?= $form->field($model, 'net_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_type')->textInput() ?>

    <?= $form->field($model, 'item_category')->textInput() ?>

    <?= $form->field($model, 'item_image')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
