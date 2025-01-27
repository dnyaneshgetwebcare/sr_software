<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemMaster */

$this->title = $model->name;

\yii\web\YiiAsset::register($this);

$user = Yii::$app->user->identity;
$is_admin = ($user->user_type == "admin") ? true : false;
?>
<style type="text/css">
    td, th {
        font-size: 15px;
    }

    .form-control {
        font-size: 15px;
        font-weight: 150;
    }

    .booked {
        background-color: #7460ee;
    }

    .picked {
        background-color: #1e88e5;
    }

    .returned {
        background-color: #26c6da;
    }

    .cancelled {
        background-color: #ffb22b;
    }

    .deleted {
        background-color: #fc4b6c;
    }
</style>
<div class="item-master-view">


    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Item</a></li>
                <li class="breadcrumb-item active">Update Item Master</li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">


                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary pull-right']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger pull-right',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#details" role="tab"
                                            style="font-size: large;">Item details</a></li>
                    <li class="nav-item"><a style="font-size: large;" class="nav-link" data-toggle="tab"
                                            href="#purchase" role="tab">Booking History</a></li>
                    <!-- <li class="nav-item"> <a   style="font-size: large;" class="nav-link" data-toggle="tab" href="#settings" role="tab">Payment</a> </li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="details" role="tabpanel">


                        <div class="card-body">
                            <div class="table-responsive m-t-0">
                                <div class="col-sm-6 col-md-6 col-lg-6" style="padding-right: 0px;">
                                    <?php
                                    $columns = [
                                        'item_code',
                                        'name',
                                        'details',
                                        [
                                            'attribute' => 'category.name',
                                            'value' => $model->category->name,
                                            'label' => 'Category',
                                        ],
                                        [
                                            'attribute' => 'type.name',
                                            'value' => $model->type->name,
                                            'label' => 'Type',
                                        ],
                                        'size',
                                        [
                                            'attribute' => 'vendor_id',
                                            'value' => ($model->vendor_id != '') ? $model->vendor->name : '',
                                            'label' => 'Vendor',
                                        ],
                                        'scrab_status',
                                        'item_status',
                                        [
                                            'attribute' => 'colour_cat',
                                            'value' => ($model->colour_cat != '') ? $model->colourCat->name : '',
                                            'label' => 'Color',
                                        ]

                                    ];

                                    if(!$is_admin){
                                        $columns = [
                                            'item_code',
                                            'name',
                                            'details',
                                            [
                                                'attribute' => 'category.name',
                                                'value' => $model->category->name,
                                                'label' => 'Category',
                                            ],
                                            [
                                                'attribute' => 'type.name',
                                                'value' => $model->type->name,
                                                'label' => 'Type',
                                            ],
                                            'size',

                                            'scrab_status',
                                            'item_status',
                                            [
                                                'attribute' => 'colour_cat',
                                                'value' => ($model->colour_cat != '') ? $model->colourCat->name : '',
                                                'label' => 'Color',
                                            ]

                                        ];
                                    }
                                    ?>

                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => $columns,
                                    ]) ?>

                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6" style="padding-left: 0px;">
                                    <?php $columns = [['attribute' => 'images', 'format' => 'html', 'value' => function ($data) { return '<a class="image-popup-vertical-fit" href="' . $data->imageurl . '">' . Html::img($data->imageurl, ['width' => '100', 'height' => '80']) . '</a>';}, ], 'purchase_date:date', 'purchase_amount', 'rent_amount', 'deposit_amount', 'rent_times', 'expense_amount', 'nos_dry_cleaning',];
                                    if(!$is_admin){
                                        $columns = [['attribute' => 'images', 'format' => 'html', 'value' => function ($data) { return '<a class="image-popup-vertical-fit" href="' . $data->imageurl . '">' . Html::img($data->imageurl, ['width' => '100', 'height' => '80']) . '</a>';}, ],  'rent_amount', 'deposit_amount', ];
                                    }

                                    ?>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => $columns,
                                    ]) ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="purchase" role="tabpanel">
                        <div class="card-body">
                            <!--  <h4 class="card-title">Items Purchased History </h4> -->

                            <div class="table-responsive">
                                <table class="table color-table red-table">
                                    <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Pick Date</th>
                                        <th>Return Date</th>
                                        <th>Discount</th>
                                        <th>Deposite</th>
                                        <th>Amount</th>
                                        <th>Status</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_amount = 0;
                                    foreach ($booking_items as $key => $booking_item) {
                                        # code...
                                        $total_amount += $booking_item->amount;
                                        ?>
                                        <tr>
                                            <td><a target="_blank" rel="noopener noreferrer"
                                                   href="index.php?r=booking%2Fupdate&id=<?= $booking_item->booking_id; ?>">#<?= $booking_item->booking_id; ?></a>
                                            </td>

                                            <td><a target="_blank" rel="noopener noreferrer"
                                                   href="index.php?r=customer%2Fview&id=<?= $booking_item->booking['customer_id']; ?>"><?= $booking_item->booking->customer['name']; ?></a>
                                            </td>
                                            <td><span class="text-muted"><i
                                                            class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($booking_item->pickup_date, 'dd-MM-yyyy'); ?></span>
                                            </td>
                                            <td><span class="text-muted"><i
                                                            class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($booking_item->return_date, 'dd-MM-yyyy'); ?></span>
                                            </td>
                                            <td><?= number_format($booking_item->discount); ?></td>

                                            <td><?= number_format($booking_item->deposit_amount); ?></td>
                                            <td><?= number_format($booking_item->amount); ?></td>
                                            <td>
                                                <div class="label label-table <?= strtolower($booking_item->item_status); ?>"><?= $booking_item->item_status; ?></div>
                                            </td>

                                        </tr>
                                    <?php }

                                    if ($booking_items == null) {
                                        ?>
                                        <tr>
                                            <td colspan="7">No Items booking yet</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <hr>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <?php if($is_admin){ ?>
                                        <h3><b>Total Rent Amount :</b> <?= number_format($total_amount); ?></h3>
                                        <?php } ?>
                                    </div>
                                    <div class="clearfix"></div>

                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>