<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingHeaderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-header-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'booking_id') ?>

    <?= $form->field($model, 'booking_date') ?>

    <?= $form->field($model, 'pickup_date') ?>

    <?= $form->field($model, 'picked_date') ?>

    <?= $form->field($model, 'return_date') ?>

    <?php // echo $form->field($model, 'returned_date') ?>

    <?php // echo $form->field($model, 'net_value') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'deposite_applicable') ?>

    <?php // echo $form->field($model, 'deposite_amount') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'deposite_status') ?>

    <?php // echo $form->field($model, 'order_status') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
