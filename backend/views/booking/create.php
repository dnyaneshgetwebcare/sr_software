<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingHeader */

$this->title = 'Create Booking';
$this->params['breadcrumbs'][] = ['label' => 'Booking Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-header-create">
    <!--   <h3><?= Html::encode($this->title) ?></h3> -->
    <!--<div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Booking</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Sales</a></li>
                <li class="breadcrumb-item active">Create Booking</li>
            </ol>
        </div>
    </div>-->
  <?= $this->render('_form', [
    'model' => $model,
    'booking_items' => $booking_items,
    'address_grup' => $address_grup,
    'customer_model' => $customer_model,
    'payment_models' => $payment_models
  ]) ?>

</div>
