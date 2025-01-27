<?php

/* @var $this yii\web\View */

$this->title = 'Panache Wears';
?>
<link rel="stylesheet" type="text/css" href="css/gccsite.css">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
      
    </section>

    <!-- Main content -->
      <div class="row dashboard">
    <div class="col-lg-12">
       <div class="col-lg-2 col-md-6 top-menu">
        <div class="panel panel-cyan top-margin">
          <div class="panel-heading padding">
            <div class="row margin">
              <div class="col-xs-12 text-left  no-padding">
               <div class="top_menu_text">Booking(<?= $booking_this_month['numb_booking'] ?>)</div>
                  <div class="huge">
                    <span style="margin:auto; display:table;font-size: 16px"><?php echo (($booking_this_month['numb_booking']>0)?number_format($booking_this_month['total']):0)?></span>
                  </div>
                </div>
            </div>
          </div>                       
        </div>
      </div>
       <div class="col-lg-2 col-md-6 top-menu">
        <div class="panel panel-info top-margin">
          <div class="panel-heading padding">
            <div class="row margin">
              <div class="col-xs-12 text-left no-padding">
                <div class="top_menu_text">Cash</div>
                  <div class="huge">
                   <span style="margin:auto; display:table;font-size: 16px"><?php echo (($payment_cash['total']>0)?number_format($payment_cash['total']):0)?></span>
                  </div>
              </div>
            </div>
          </div>                       
        </div>
      </div>
     
       <div class="col-lg-2 col-md-6 top-menu">
        <div class="panel panel-cyan top-margin">
          <div class="panel-heading padding">
            <div class="row margin">
              <div class="col-xs-12 text-left  no-padding">
                <div class="top_menu_text">Deposite</div>
                  <div class="huge">

                   <span style="margin:auto; display:table;font-size: 16px"><?php echo (($deposite_amt['total']>0)?number_format($deposite_amt['total']):0)?></span>
                  </div>
              </div>
            </div>
          </div>                       
        </div>
      </div>
      <div class="col-lg-2 col-md-6 top-menu">
        <div class="panel panel-info top-margin">
          <div class="panel-heading padding">
            <div class="row margin">
              <div class="col-xs-12 text-left  no-padding">
                <div class="top_menu_text">Expense</div>
                  <div class="huge">
                   <span style="margin:auto; display:table;font-size: 16px"><?php echo (($expense['total']>0)?number_format($expense['total']):0)?></span>
                  </div>
                </div>
            </div>
          </div>                       
        </div>
      </div>
           <div class="col-lg-2 col-md-6 top-menu">
        <div class="panel panel-cyan top-margin">
          <div class="panel-heading padding">
            <div class="row margin">
              <div class="col-xs-12 text-left  no-padding">
                <div class="top_menu_text">-</div>
                  <div class="huge">
                   <span style="margin:auto; display:table;font-size: 16px">-<?php //echo Yii::$app->formatter->asCurrencyWithoutDecimal($total_this_year_ord['total']-$total_this_year_ret['total'],'');?></span>
                  </div>
                </div>
            </div>
          </div>                       
        </div>
      </div>
  
    </div>
  </div>
  <div class="col-lg-12" style="margin-top: 20px">

  <div class="col-lg-6">

            <?php // $model_delivary->pickup_date ?>
      
  </div>
</div>
<div class="col-md-4"  style="overflow-y: scroll; max-height: 300px">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Delivery Order <small>Next 3days</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    
                   <!--    <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <?php
                      foreach ($model_delivarys as $key => $model_delivary) { ?>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?= date_format(date_create($model_delivary->pickup_date),"M") ?></p>
                        <p class="day"><?= date_format(date_create($model_delivary->pickup_date),"d") ?></p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="index.php?r=booking/delivery&id=<?= $model_delivary->booking_id ?>"><?= $model_delivary->customer->name ?></a>
                        <p><?= $model_delivary->customer->contact_nos ?></p>
                      </div>
                    </article>
                     <?php } 
                     if(sizeof($model_delivarys)==0){

                        ?>
                        <p class="day">No Item to Delivery</p>
                        <?php
                     }
                     ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="overflow-y: scroll; max-height: 300px">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Return Order <small>Next 3days</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    
                   <!--    <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <?php
                      foreach ($model_returns as $key => $model_return) { ?>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?= date_format(date_create($model_return->pickup_date),"M") ?></p>
                        <p class="day"><?= date_format(date_create($model_return->pickup_date),"d") ?></p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="index.php?r=booking/return-item&id=<?= $model_return->booking_id ?>"><?= $model_return->customer->name ?></a>
                        <p><?= $model_return->customer->contact_nos ?></p>
                      </div>
                    </article>
                     <?php } 
                     if(sizeof($model_returns)==0){

                        ?>
                        <p class="day">No Item to return</p>
                        <?php
                     }
                     ?>

                  </div>
                </div>
              </div>