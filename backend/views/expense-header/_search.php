<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpenseHeaderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-header-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'expense_date') ?>

    <?= $form->field($model, 'expense_type') ?>

    <?= $form->field($model, 'remark') ?>

    <?= $form->field($model, 'image_url') ?>

    <?php // echo $form->field($model, 'vendor_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'contact_nos') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'delete_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
