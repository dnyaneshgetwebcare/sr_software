<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'email_id') ?>

    <?= $form->field($model, 'contact_nos') ?>

    <?= $form->field($model, 'contact_nos_2') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'reference_name') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'cust_group') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
