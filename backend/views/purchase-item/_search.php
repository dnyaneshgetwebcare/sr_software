<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'item_no') ?>

    <?= $form->field($model, 'purhcase_id') ?>

    <?= $form->field($model, 'item_code') ?>

    <?= $form->field($model, 'net_value') ?>

    <?= $form->field($model, 'item_type') ?>

    <?php // echo $form->field($model, 'item_category') ?>

    <?php // echo $form->field($model, 'item_image') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
