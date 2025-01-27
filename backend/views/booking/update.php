<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookingHeader */

$this->title = 'Update Booking: #' . $model->booking_id;

?>
<style type="text/css">
    .page-header {
        margin: -7px -15px 8px -15px !important;
        padding: 11px 15px 8px 15px !important;
        align-self: center !important;
        font-size: 18px !important;
        box-shadow: 0px 1px 2px #a5a0a0 !important;
        /*  padding-left: 24px;*/
    }
</style>
<div class="booking-header-update">
    <!-- <div class="row page-header">
    <div class="col-lg-12">
 
   <div class="col-lg-4"></div>
 <div class="col-lg-4" style="text-align: center;"><h4 style="margin-top:-1px"><b><?php // $this->title ?></h4>
   </div>
 <div class="tool" style="position: absolute;right:0;top:0;margin-right:20px;">
   <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
    <div class="input-group input-group-sm">
  <div class="dropdown-hover Save_changes_slide">
    <a class="btn btn-warning dropdown-toggle pull-right hover-dropdown" data-toggle="dropdown"> ACTION
   </a>
    <ul class="dropdown-menu action pull-right">
   
    <li class="save_change"><a href='<?php //echo Yii::$app->request->baseUrl.'/index.php?r=booking/delivery&id='.$model->booking_id ?>'>
     <img src="img/icons/goods_issue.png" style="height:12px;margin-right:3px"> Delivery Item</a>
   </li>
  <li class="save_change"><a href='<?php //echo Yii::$app->request->baseUrl.'/index.php?r=booking/return-item&id='.$model->booking_id ?>'>
     <img src="img/icons/purchase.png" style="height:12px;margin-right:3px"> Return Item</a>
   </li>
    
     
       
    </ul>
  </div>
</div> 
        

             <div class="btn-group pull-left" onclick="printInvoiceSend()" data-toggle ="tooltip" data-placement ="bottom", title='PRINT'><a class="btn btn-info"  data-pjax="0"><span class="glyphicon glyphicon-print"></span> </a>
            </div> 
           
        

        
 
        </div>
                
  </div> 
    
</div>
</div> -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= $this->title ?> </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Sales</a></li>
                <li class="breadcrumb-item active">Update Booking</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">

                <div class="btn-group" style="margin-right: 5px;">
                    <button type="button" class="btn btn-primary btn-border dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                           href="<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/delivery&id=' . $model->booking_id ?>">Delivery
                            Items</a>
                        <a class="dropdown-item"
                           href="<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/return-item&id=' . $model->booking_id ?>">Return
                            Item</a>
                        <!--  <a class="dropdown-item" href="" onclick="cancelBooking('')">Cancel Booking</a> -->
                        <!--  <a class="dropdown-item" href="#">Something else here</a>
                         <div class="dropdown-divider"></div>
                         <a class="dropdown-item" href="#">Separated link</a> -->
                    </div>
                </div>
                <?php //echo Html::a('Create New Booking', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                <button type="button" class="btn btn-secondary btn-border" title="Send Invoice"
                        onclick="sendwhatsapp('<?= $model->booking_id; ?>')"><i class="fab fa-whatsapp"></i></button>
                <button type="button" class="btn btn-secondary btn-border" title="Send Invoice"
                        onclick="printInvoiceSend()"><i class="far fa-paper-plane"></i></button>
                <button type="button" class="btn btn-secondary btn-border" title="Send Invoice"
                        onclick="printInvoice('<?= $model->encryted_id ?>')"><i class="fas fa-print"></i></button>
            </div>
        </div>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'bal_amount' => $bal_amount,
        'booking_items' => $booking_items,
        'customer_model' => $customer_model,
        'address_grup' => $address_grup,
        'payment_models' => $payment_models,
        'settle_carry_frd' => $settle_carry_frd,
        'payment_carry_frd' => $payment_carry_frd
    ]) ?>

</div>
