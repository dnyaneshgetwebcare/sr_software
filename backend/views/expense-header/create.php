<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpenseHeader */

$this->title = 'Create Expense Header';
$this->params['breadcrumbs'][] = ['label' => 'Expense Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-header-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
