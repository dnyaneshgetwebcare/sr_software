<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpenseHeader */

$this->title = 'Update Expense: ' . $model->id;


?>
<div class="expense-header-update">

     <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Expense</a></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </div>

    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'expense_category' => $expense_category,
            'expense_items' => $expense_items,
            'vendor_model' => $vendor_model,
    ]) ?>

</div>
