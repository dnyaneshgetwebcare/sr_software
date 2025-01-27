<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingHeader */

$this->title = $model->booking_id;
$this->params['breadcrumbs'][] = ['label' => 'Booking Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="booking-header-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->booking_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->booking_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'booking_id',
            'booking_date',
            'pickup_date',
            'picked_date',
            'return_date',
            'returned_date',
            'net_value',
            'discount',
            'deposite_applicable',
            'deposite_amount',
            'payment_status',
            'customer_id',
            'deposite_status',
            'order_status',
            'status',
        ],
    ]) ?>

</div>
