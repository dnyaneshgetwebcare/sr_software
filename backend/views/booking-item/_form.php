<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_id')->textInput() ?>

    <?= $form->field($model, 'booking_id')->textInput() ?>

    <?= $form->field($model, 'item_no')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'net_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'deposit_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deposite_charge_status')->textInput() ?>

    <?= $form->field($model, 'pickup_date')->textInput() ?>

    <?= $form->field($model, 'picked_date')->textInput() ?>

    <?= $form->field($model, 'return_date')->textInput() ?>

    <?= $form->field($model, 'returned_date')->textInput() ?>

    <?= $form->field($model, 'item_status')->dropDownList([ 'Booked' => 'Booked', 'Picked' => 'Picked', 'Returned' => 'Returned', 'Cancelled' => 'Cancelled', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'deposite_status')->dropDownList([ 'NA' => 'NA', 'PAID' => 'PAID', 'PARTIAL' => 'PARTIAL', 'RETURN' => 'RETURN', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
