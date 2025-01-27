<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerMaster */

$this->title = $model->name;

\yii\web\YiiAsset::register($this);
?>
<style type="text/css">
  td,th{
    font-size: 15px; 
}
.form-control {
    font-size: 15px;
    font-weight: 150;
}
.booked{
    background-color: #7460ee;
}
.picked{
    background-color: #1e88e5;
}
.returned{
    background-color: #26c6da;
}
.cancelled{
    background-color: #ffb22b;
}
.deleted{
    background-color: #fc4b6c;
}
</style>
<div class="customer-master-view">
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
 <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" style="font-size: large;">Profile</a> </li>
                                <li class="nav-item"> <a  style="font-size: large;" class="nav-link" data-toggle="tab" href="#purchase" role="tab">Booking History</a> </li>
                                <li class="nav-item"> <a   style="font-size: large;" class="nav-link" data-toggle="tab" href="#settings" role="tab">Payment</a> </li>
                                <li class="nav-item"> <a   style="font-size: large;" class="nav-link" data-toggle="tab" href="#settl" role="tab">Settlement</a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                     <div class="card-body">
                                            
                                <div class="table-responsive m-t-0">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'name',
            'email_id:email',
            'contact_nos',
            'contact_nos_2',
            'address',
            'reference',
            'reference_name',
            'created_date',
            'cust_group',
        ],
    ]) ?>
</div>
</div>
                                </div>
                                <!--second tab-->
                                <div class="tab-pane" id="purchase" role="tabpanel">
                                  <div class="card-body">
                               <!--  <h4 class="card-title">Items Purchased History </h4> -->
                              
                                <div class="table-responsive">
                                    <table class="table color-table red-table">
                                        <thead>
                                            <tr>
                                                <th>Invoice</th>
                                                <th colspan="2">Item Details</th>
                                                <th>Pick Date</th>
                                                <th>Return Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total_amount=0;
                                            foreach ($booking_items as $key => $booking_item) {
                                                # code...
                                                $total_amount+=$booking_item->amount;
                                             ?>
                                            <tr>
                                                <td><a target="_blank" rel="noopener noreferrer" href="index.php?r=booking%2Fupdate&id=<?= $booking_item->booking_id; ?>">#<?= $booking_item->booking_id; ?></a></td>
                                                <td><a class="image-popup-vertical-fit" href="<?= $booking_item->item->imageurl; ?>" ><img src="<?= $booking_item->item->imageUrl; ?>" width="100" height="80" alt=""></a></td>
                                                <td><?= $booking_item->item->name; ?></td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($booking_item->pickup_date,'dd-MM-yyyy'); ?></span> </td>
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($booking_item->return_date,'dd-MM-yyyy'); ?></span> </td>
                                                <td><?= number_format($booking_item->amount); ?></td>
                                                <td>
                                                    <div class="label label-table <?= strtolower($booking_item->item_status); ?>"><?= $booking_item->item_status; ?></div>
                                                </td>
                                                
                                            </tr>
                                          <?php  }

                                          if($booking_items==null){
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
                                        
                                        <h3><b>Total Rent Amount :</b> <?= number_format($total_amount); ?></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                    
                                    <hr>
                                </div>
                                </div>
                            </div>
                                </div>
                                <div class="tab-pane" id="settings" role="tabpanel">
                                  <div class="card-body">
                               <!--  <h4 class="card-title">Items Purchased History </h4> -->
                              
                                <div class="table-responsive">
                                    <table class="table color-table red-table">
                                        <thead>
                                            <tr>
                                                <th>Invoice</th>       
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Mode</th>
                                                <th>Recived By</th>
                                                <th>Recived In</th>
                                                <th>During</th>
                                                <th>Amount</th>
                                               
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total_amount=0;
                                            foreach ($payment_historys as $key => $payment_history) {
                                                # code...
                                                if($payment_history->type=='Return-Deposit'){
                                                  $payment_history->amount=$payment_history->amount*-1;
                                                }
                                                $total_amount+=$payment_history->amount;
                                             ?>
                                            <tr>
                                                <td><a target="_blank" rel="noopener noreferrer" href="index.php?r=booking%2Fupdate&id=<?= $payment_history->booking_id; ?>">#<?= $payment_history->booking_id; ?></a></td>
                                               
                                              
                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asDate($payment_history->date,'dd-MM-yyyy'); ?></span> </td>
                                                  <td><?= $payment_history->type; ?></td>
                                                  <td><?= $payment_history->mode_of_payment; ?></td>
                                                  <td><?= $payment_history->received_by; ?></td>
                                                  <td><?= $payment_history->sendto; ?></td>
                                                  <td><?= $payment_history->received_during; ?></td>
                                                <td><?= number_format($payment_history->amount); ?></td>
                                               
                                                
                                            </tr>
                                          <?php  }

                                          if($booking_items==null){
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
                                        
                                        <h3><b>Total :</b> <?= number_format($total_amount); ?></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    
                                </div>
                                </div>

                            </div>
                                </div>
                                <div class="tab-pane" id="settl" role="tabpanel">
                                  <div class="card-body">
                               <!--  <h4 class="card-title">Items Purchased History </h4> -->

                                <div class="table-responsive">
                                    <table class="table color-table red-table">
                                        <thead>
                                            <tr>
                                                <th>Booking ID</th>
                                                <th>Settle With ID</th>
                                                <th>Type</th>
                                                <th>Mode</th>
                                                <th>Recived By</th>
                                                <th>Recived In</th>
                                                <th>During</th>
                                                <th>Amount</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_amount=0;
                                            foreach ($carry_frd_booking as $key => $carry_frd_item) {
                                                # code...

                                             ?>
                                            <tr>
                                                <td><a target="_blank" rel="noopener noreferrer" href="index.php?r=booking%2Fupdate&id=<?= $carry_frd_item->booking_id; ?>">#<?= $carry_frd_item->booking_id; ?></a></td>


                                                <td> <?= $carry_frd_item->settle_with;  ?></td>
                                                  <td><?= $carry_frd_item->status; ?></td>
                                                  <td><?= number_format($carry_frd_item->carry_return); ?></td>
                                                  <td><?= number_format($carry_frd_item->carry_balance); ?></td>
                                                  <td><?= number_format($carry_frd_item->total_bal); ?></td>



                                            </tr>
                                          <?php  }

                                          if($booking_items==null){
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

                                        <h3><b>Total :</b> <?= number_format($total_amount); ?></h3>
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
   

</div>

