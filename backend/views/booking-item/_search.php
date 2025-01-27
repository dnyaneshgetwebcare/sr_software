<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'booking_id') ?>

    <?= $form->field($model, 'item_no') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'net_value') ?>

    <?php // echo $form->field($model, 'item_type') ?>

    <?php // echo $form->field($model, 'item_category') ?>

    <?php // echo $form->field($model, 'image_name') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'deposit_amount') ?>

    <?php // echo $form->field($model, 'deposite_charge_status') ?>

    <?php // echo $form->field($model, 'pickup_date') ?>

    <?php // echo $form->field($model, 'picked_date') ?>

    <?php // echo $form->field($model, 'return_date') ?>

    <?php // echo $form->field($model, 'returned_date') ?>

    <?php // echo $form->field($model, 'item_status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'deposite_status') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
