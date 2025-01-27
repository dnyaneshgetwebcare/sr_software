<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Sales Order';
?>
<style type="text/css">
  .even-strip 
  {
    padding-top:10px !important;
    padding-bottom:5px !important;
  }
</style>
<div class="row">
  <div class="row col-lg-12">
    <div class="col-lg-8">
      <div class="panel panel-default">
        <div class="panel-body" style="padding:0px 0px 0px 0px !important">

          <div class="row even-strip" style="margin:0px !important">
        <div class="col-lg-12">
        <label class="col-md-3">Details</label>
              </div>
              <div class="col-md-12">
                  <div class="ellipsis">
                      <table class="table table-striped table-responsive">
                          <tr>
                              <td><b>Desc:</b> <?= $item_data['details'];  ?></td>
                              <td><b>Size: </b>  <?= $item_data['size'];  ?></td>
                          </tr>
                          <tr>
                              <td><b>Rent:  </b> <?= number_format($item_data['rent_amount'],2);  ?></td>
                              <td><b>Deposite Amount: </b> <?= number_format($item_data['deposit_amount'],2)  ?></td>

                          </tr>

                      </table>
                  </div>
              </div>
          </div><hr style="margin: 0px">

        </div>
          </div>       
            </div>
              <div class="col-lg-1"></div>
                <div class="col-lg-2" >      
                <img src="<?= (($item_data['images']!='')?('uploads/'.$item_data['images']):'img/no-image.jpg'); ?>" style="height: 100px;width:100px;">
              </div>
            </div>
          </div>
        <hr>
   

    <div class="col-lg-12" style="overflow: auto; height: 100px;">
      <table class="table table-striped table-responsive">
          <tr>
            <td>Cust Name</td>
          <td>Pick Date</td>
          <td>Return Date</td>
          <td>Status</td>
          </tr>
          <?php foreach ($booking_item as $book_item){ ?>
        <tr>
            <td><?= $book_item->booking->customer->name ?></td>
          <td ><b><?= date_format(date_create($book_item->pickup_date),"d/m/Y");?></b></td>
          <td> <b><?= date_format(date_create($book_item->return_date),"d/m/Y");?></b></td>
            <td> <b><?= $book_item->item_status;?></b></td>
        </tr>
      <?php } ?>
              </table>
    </div>

  </div>
</div>
