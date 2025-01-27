<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PurchaseHeader */

$this->title = $model->id;

\yii\web\YiiAsset::register($this);
?>

<style type="text/css">
  td,th{
    font-size: 15px; 
}

</style>
<div class="purchase-header-view">

     <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Purchase</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Purchase</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?= $this->title; ?></a></li>
                            
                        </ol>
                    </div>
                   
                </div>
<div class="row">
                    <div class="col-12">
                        <div class="card" >
                            <div class="card-body">
                                  <div class="row col-6 m-t-30">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
              [
            'attribute'=>'Attachment',
              'value'=>$model->imageurl,
               'format' => 'html',
                 'value' => function($data) { return '<a class="image-popup-vertical-fit" href="'.$data->imageurl.'">'.Html::img($data->imageurl, ['width'=>'100','height'=>'80']).'</a>'; },
               ],
            'vendor.name',
            'purchase_date:date',
            'purchase_amount',
            'discount',
           
        ],
    ]) ?>

</div>
  <div class="row m-t-20">
    <div class="table-responsive m-t-30">
                                    <table class="table color-table red-table">
                                        <thead>
                                            <tr>
                                                 <th>Image</th>
                                                <th>Item Name</th>
                                                 <th>Category</th>
                                               <th>Type</th>

                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $total_amount=0;
                                            $purchase_items=$model->purchaseItems;
                                            foreach ($purchase_items as $key => $purchase_item) {
                                                # code...
                                                $total_amount+=$purchase_item->net_value;
                                             ?>
                                            <tr>
                                               <td><a class="image-popup-vertical-fit" href="<?= $purchase_item->item->imageurl; ?>" ><img src="<?= $purchase_item->item->imageUrl; ?>" width="100" height="80" alt=""></a></td>
                                                
                                                <td><a  target="_blank" rel="noopener noreferrer" href="index.php?r=item%2Fview&id=<?= $purchase_item->item_code; ?>"><?= $purchase_item->item['name']; ?></a></td>
                                           <td><?= $purchase_item->item->category['name']; ?></td>
                                             <td><?= $purchase_item->item->type['name']; ?></td>
                                                <td><?= number_format($purchase_item->net_value); ?></td>
                                             
                                               
                                                
                                            </tr>
                                          <?php  }

                                          if($purchase_items==null){
                                            ?>
                                            <tr>
                                                <td colspan="7">No Items</td>
                                            </tr>
                                        <?php
                                          }
                                           ?>

                                        </tbody>
                                    </table>
                                    <hr>
                                     <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        
                                        <h3><b>Total Amount :</b> <?= number_format($total_amount); ?></h3>
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
