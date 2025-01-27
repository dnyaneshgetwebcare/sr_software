<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'payment_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'mode_of_payment') ?>

    <?= $form->field($model, 'received_by') ?>

    <?php // echo $form->field($model, 'received_during') ?>

    <?php // echo $form->field($model, 'dom') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'booking_id') ?>

    <?php // echo $form->field($model, 'sendto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
