<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentMaster */

$this->title = 'Create Payment Master';
$this->params['breadcrumbs'][] = ['label' => 'Payment Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
