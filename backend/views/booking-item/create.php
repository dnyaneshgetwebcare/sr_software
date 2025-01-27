<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingItem */

$this->title = 'Create Booking Item';
$this->params['breadcrumbs'][] = ['label' => 'Booking Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
