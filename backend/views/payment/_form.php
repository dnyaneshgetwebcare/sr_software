<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Advance' => 'Advance', 'Per-payment' => 'Per-payment', 'Deposit' => 'Deposit', 'Final-Payment' => 'Final-Payment', 'Return-Deposit' => 'Return-Deposit', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'mode_of_payment')->dropDownList([ 'Cash' => 'Cash', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'received_by')->dropDownList([ 'Varsha' => 'Varsha', 'Pranali' => 'Pranali', 'Others' => 'Others', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'received_during')->dropDownList([ 'Booking' => 'Booking', 'Pickup' => 'Pickup', 'Return' => 'Return', 'Other' => 'Other', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'dom')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'booking_id')->textInput() ?>

    <?= $form->field($model, 'sendto')->dropDownList([ 'Company' => 'Company', 'Pranali' => 'Pranali', 'Varsha' => 'Varsha', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
