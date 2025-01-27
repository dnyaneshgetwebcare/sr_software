<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingItem */

$this->title = 'Update Booking Item: ' . $model->item_id;
$this->params['breadcrumbs'][] = ['label' => 'Booking Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_id, 'url' => ['view', 'id' => $model->item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="booking-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
