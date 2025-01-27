<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\PaymentMaster;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$temp_header=($item_status=='Picked')?'Delivery Item':'Return Item';
$this->title = $temp_header.' of Order #'.$_GET['id'];
//$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
	  .error-summary {
    color: #a94442;
    background: #efd4d4;
    border-left: 3px solid #eed3d7;
    padding: 10px 20px;
/*    margin: 0 15px 15px 15px;*/
}
 
    /*  .table-bordered>tbody>tr>td,.table-bordered>thead>tr>th{
  border:1px solid #eee !important;
 }*/
 .form-group {
     margin-bottom: 0px;
}
.page-titles{
    margin-bottom: 10px!important;
}
.control-label ,.form-control {
    font-size: 14px;
    font-weight: 400;
}
td,th{
    font-size: 12px; 
}
</style>
<div class="booking-header-index">
<div class="row page-titles">

<div class="col-md-5 col-8 align-self-center">

    <h3 class="text-themecolor m-b-0 m-t-0"><a href="index.php?r=booking%2Fupdate&id=<?= $booking_id ?>" tag="Go to order""><?= Html::encode($this->title) ?></a></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Sales</a></li>
                            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
                        </ol>
                    </div>
                  </div>

<!--   <div class="row page-header update-page-header"  id="header_details">
  <div class="col-lg-12">
    <div class="col-lg-4">
      <img src="img/icons/back-arrow.png" style="height:16px;cursor:pointer" id="back_button" class="back-redirect-for-button" onclick="back_click()">
    </div>
    <div class="col-lg-4" style="text-align: center;margin-top:0px!important;">
      <h4 style="margin: 0px;"><b class="category-ar"><span id="heading1"><?php // Html::encode($this->title) ?></span></b></h4>
      <hr style="margin-top: 0px;margin-bottom: 0px;width: 150px;border-top:1px solid #aaa;">
    </div>


 </div>
</div> -->
<?php

$form = ActiveForm::begin(['enableClientValidation'=>false, 'action' => Url::to(['booking/delivery-item']),'id'=>'booking_header_form', 'options' => ['class' => 'disable-submit-buttons','onSubmit'=> 'return clientShowLoader()']]);
?>

<div class="row" >
    <div class="card col-lg-12">

        <div class="card-body">
    <div class="col-lg-12">
        <div class="error-summary error-summary-sales custom-errors" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;#errors_test1&quot;).hide()"></i><h5><b><i class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b></h5></p>
            <hr class="custom_error_hr">
            <div id="error_display_sales" class="custom_error"></div>
        </div>
    </div>

<input type="hidden" name="item_status" value="<?= $item_status ?>">
<input type="hidden" name="booking_id" value="<?= $booking_id ?>">





 <div class="row show_vendor_data" >
<div class="row">
  <div class="col-md-12">
      <div class="form-group row">
        <label class="control-label text-left col-md-3" style="padding-right: 0px !important">Date</label>
          <div class="col-md-9">
            <?php  //$posting_date=date('d-m-Y');
                  echo DatePicker::widget([
                    'id'=>'posting_date',
                     'name' => 'delivery_date',
                     'type' => DatePicker::TYPE_INPUT,

                    // 'value'=> $posting_date,
                     'options' =>
                    [
                     'placeholder' => 'dd-mm-yyyy',
                     'autocomplete' => 'off',
                    ],
                     'pluginOptions' =>
                    [
                       'autoclose'=>true,
                       'format' => 'dd-mm-yyyy'
                    ]
                ]); ?>        
          </div>
        </div>
    </div>
   </div>





  <!-- <div class="col-lg-12">
    <div class="">
      <div class="panel-body" style="padding-top: 0px;padding-bottom: 0px">
        <div class="tab-content">
        <div class="row right_section">
          <div class="row col-lg-6" style="margin-top:0px !important;margin-bottom:0px !important">                              
          <div class="form-group cust-group">
            <label class="col-lg-4 control-label" style="text-align: left">Date</label>
              <div class="col-lg-6">
              	<div class="form-group">
                <?php  //$posting_date=date('d-m-Y');
                 /* echo DatePicker::widget([
                    'id'=>'posting_date',
                     'name' => 'delivery_date',
                     'type' => DatePicker::TYPE_INPUT,

                     'value'=> $posting_date,
                     'options' =>
                    [
                     'placeholder' => 'dd-mm-yyyy',
                     'autocomplete' => 'off',
                    ],
                     'pluginOptions' =>
                    [
                       'autoclose'=>true,
                       'format' => 'dd-mm-yyyy'
                    ]
                ]);*/ ?>          
              </div>
          </div>
          </div>
        </div>
        </div>
 </div>
    </div>
  </div>
</div> -->
         <!--   <div class="row right_section">
             <div class="row col-lg-6" style="margin-top:0px !important;margin-bottom:0px !important">      
                <div class="form-group cust-group">
              <label class="col-lg-4 control-label" style="text-align: left"></label>
                <div class="col-lg-6">
                <?php // $form->field($model, 'REFERENCE')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>$model->attributeLabels()[ 'REFERENCE']])->label(false);  ?>
                                      
                </div>
            </div>
          </div>
          </div> -->

<?php  //$form->field($model, 'complete_order')->checkBox(['class'=>'deposite_applicable_class check ','data-checkbox'=>"icheckbox_square-red"]); ?>

</div><hr class="div-hr" >

 <div class="row" style="margin-top: 10px" >

  <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'display nowrap table table-hover color-bordered-table muted-bordered-table table-striped table-bordered'],
        'columns' => [
        	  [
          'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
                return ['value' => $model->item_id,'class'=>'check item_list','checked'=>true,'readonly'=>true,'data-checkbox'=>"icheckbox_square-red"];
            },
              ],
            //['class' => 'yii\grid\SerialColumn'],

            //'booking_id',
           // 'item.name',
             [
             // 'attribute' => 'images',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Image',
                /* 'format' => 'image',
             'value'=>function($data) { return $data->imageurl; },*/
             'format' => 'html',
              'value' => function($data) { return '<a class="image-popup-vertical-fit" href="'.$data->item->imageurl.'">'.Html::img($data->item->imageurl, ['width'=>'100','height'=>'80']).'</a>'; },
              
            ],
            [
        'attribute' => 'item.name',
        'enableSorting' => false
         ],  
         [
        'attribute' => 'pickup_date',
        'enableSorting' => false,
        'format' => ['date', 'php:d/m/Y']
         ],
          [
        'attribute' => 'return_date',
        'enableSorting' => false,
        'format' => ['date', 'php:d/m/Y']
         ],
          [
        'attribute' => 'item_status',
        'enableSorting' => false
         ],
             //'picked_date',
            
            //'picked_date',
            //'return_date',
           // 'returned_date',
           // 'item_status',
            //'net_value',
            //'discount',
            //'deposite_applicable',
           // 'deposite_amount',
            //'payment_status',
           
            //'deposite_status',
            //'order_status',
            //'status',

          
        ],
    ]); ?>
</div>
</div>

                <h3 class="box-title m-t-20">Payments</h3>
                <hr class="m-t-0">
            <div class="row">
                <div class="col-md-4 pull-right">
                    <h1><b><center><div id="display_pending" style="background-color: #c4ecba">Amount:  0</div></center></b></h1>
                </div>
            </div>
                <div class="col-md-6 number" style="margin-top: 3px; display: none">

                    <input type="text" name="BookingHeader[net_value]" value="<?=$model->net_value?>" class="form-control total" style="border:none;background: none !important;" readonly id="sub_total">
                </div>
                <div class="col-md-6 number" style="display: none">
                    <input type="text" name="BookingHeader[deposite_amount]" value="<?=$model->deposite_amount?>" class="form-control total" style="border:none;background: none !important;" readonly id="total_deposite_amount">
                </div>
              

                    <div class="col-lg-12" id="sales_items_tab_payment" style="margin-top: 10px;padding-left: 0px;padding-right: 0px;">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper_payment',
                            'widgetBody' => '.container-items-payment',
                            'widgetItem' => '.payment-item',
                            'limit' => 10,
                            'min' => 1,
                            'insertButton' => '.add-payment',
                            'deleteButton' => '.remove-payment',
                            'model' => $payment_models[0],
                            'formId' => 'booking_header_form',
                            'formFields' => [
                                'description',
                            ],
                        ]); ?>
                        <table class="table color-bordered-table muted-bordered-table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 8%">Date </th>
                                <th style="width: 15%">Remark </th>
                                <th style="width: 14%">Type </th>
                                <th style="width: 14%">Mode</th>
                                <th style="width: 14%">Recived By</th>
                                <th style="width: 14%">Recived In</th>
                                <th style="width: 14%">During</th>
                                <th style="width: 10%">Amount</th>
                                <!--<th style="width: 450px;">Quantity</th>-->
                                <th class="text-center" style="width: 3%;">
                                    <button type="button" onclick="addPaymentitem()"" class="add-payment btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="container-items-payment">
                            <?php
                            $array1=[new PaymentMaster()];
                            $payment_models=array_merge($array1,$payment_models);
                            $count_item_payment=count($payment_models);
                            $sub_total=0;
                            foreach ($payment_models as $indexHouse => $payment_model):
                                $active_div=($model->booking_id!='' && $indexHouse!=0)?'':'display:none;';
                                $payment_model['date']=($payment_model['date']=="")?date('Y-m-d'):$payment_model['date'];
                                ?>
                                <tr class="payment-item" id='<?php echo "paymentmaster-{$indexHouse}-test";?>'>
                                    <td id='<?php echo "paymentmaster-{$indexHouse}-tax_new_id";?>' style="text-align: center;vertical-align: middle !important;">

                                        <input type="date"  name="<?php echo "PaymentMaster[{$indexHouse}][date]" ?>" id='<?php echo "pricelistassignmentdiscounts-{$indexHouse}-valid_till" ?>' class="valid_till_date form-control" value="<?php echo $payment_model['date']; ?>" style="width: 150px!important ">
                                        <?= $form->field($payment_model, "[{$indexHouse}]payment_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                                        <?= $form->field($payment_model, "[{$indexHouse}]booking_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($payment_model, "[{$indexHouse}]remark")->label(false)->textInput(['maxlength' => true,'placeholder'=>'Remark',]) ?>
                                    </td>

                                    <td>
                                        <?= $form->field($payment_model, "[{$indexHouse}]type")->dropDownList([ 'Advance' => 'Advance', 'Per-payment' => 'Per-payment', 'Final-Payment' => 'Final-Payment', 'Return-Deposit' => 'Return-Deposit','Cancel-Charge'=>'Cancel-Charge','Other-Charges'=>'Other-Charges','Return-Payment'=>'Return-Payment'],['options'=>['style'=>'font-size:8px;'],'onchange'=>'add_total_payment()'])->label(false) ?>

                                    </td>
                                    <td>

                                         <?php 
                  $option_array=($payment_model->type=='Cancel-Charge'|| $payment_model->type=='Other-Charges')?['Deposit'=>'Deposit']:[ 'Cash' => 'Cash', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other', ];

                  echo  $form->field($payment_model, "[{$indexHouse}]mode_of_payment")->dropDownList($option_array)->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($payment_model, "[{$indexHouse}]received_by")->dropDownList([ 'Varsha' => 'Varsha', 'Pranali' => 'Pranali', 'Others' => 'Others', ])->label(false) ?>
                                    </td>

                                    <td>

                                        <?= $form->field($payment_model, "[{$indexHouse}]sendto")->dropDownList([ 'Company' => 'Company', 'Pranali' => 'Pranali', 'Varsha' => 'Varsha', ])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($payment_model, "[{$indexHouse}]received_during")->dropDownList([ 'Booking' => 'Booking', 'Pickup' => 'Pickup', 'Return' => 'Return', 'Other' => 'Other', ])->label(false) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($payment_model, "[{$indexHouse}]amount")->label(false)->textInput(['maxlength' => true,'onkeyup'=> 'add_total_payment(this.id)','placeholder'=>'0.00',]) ?>
                                    </td>


                                    <td class="text-center vcenter" style="verti">
                                        <button type="button" class="remove-payment btn btn-danger btn-xs" onclick="removePaymentitem()"><span class="fa fa-minus"></span></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                
               <div class="row col-lg-4 form-total pull-right">
            <div class="panel panel-default">
                       <!--  <div class="panel-heading"></div> -->
            <div class="panel-body" style="padding-top:0px !important;padding-bottom:0px !important">
            <!-- Nav tabs -->
                         
            <!-- Tab panes -->
                  <div class="tab-content">               
                    <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                    <div class="form-group col-12">
                      <label class="col-md-6 control-label"> Paid </label>
                        <div class="col-md-6 number">
                         <input type="text" name="BookingHeader[paid_amount]" value="<?= ($model->paid_amount==''? 0 :$model->paid_amount )?>" class="form-control total" style="border:none;background: none !important;" readonly id="paid_amount">
                        </div>
                    </div>
                  </div>
                    <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                    <div class="form-group col-12">
                      <label class="col-md-6 control-label"> Pending </label>
                        <div class="col-md-6 number">
                         <input type="text" name="BookingHeader[pending_amount]" value="<?=$model->net_value - ($model->paid_amount-$model->cancellation_charges) ?>" class="form-control total" style="border:none;background: none !important;" readonly id="pending_amount">
                        </div>
                    </div>
                  </div>


                    <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                    <div class="form-group col-12">
                      <label class="col-md-6 control-label"> Return </label>
                        <div class="col-md-6 number">
                         <input type="text" name="BookingHeader[return_amount]" value="<?=$model->return_amount; ?>" class="form-control total" style="border:none;background: none !important;" readonly id="return_amount">
                        </div>
                    </div>
                  </div>
                  <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                    <div class="form-group col-12">
                      <label class="col-md-6 control-label"> Cancel Charge </label>
                        <div class="col-md-6 number">
                         <input type="text" name="BookingHeader[cancellation_charges]" value="<?=$model->cancellation_charges ?>" class="form-control total" style="border:none;background: none !important;" readonly id="cancellation_charges">
                        </div>
                    </div>
                  </div>
     <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                    <div class="form-group col-12">
                      <label class="col-md-6 control-label"> Other Charge </label>
                        <div class="col-md-6 number">
                         <input type="text" name="BookingHeader[other_charges]" value="<?=$model->other_charges ?>" class="form-control total" style="border:none;background: none !important;" readonly id="other_charges">
                        </div>
                    </div>
                  </div>
                   <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                    <div class="form-group col-12">
                      <label class="col-md-6 control-label"> Refund </label>
                        <div class="col-md-6 number">
                         <input type="text" value="<?= $model->refunded.'/'.$model->deposite_amount ?>" class="form-control total" style="border:none;background: none !important;" readonly id="refund_dis">  
                          <input type="hidden" name="BookingHeader[refunded]" value="<?= ($model->refunded==''? 0 :$model->refunded ) ?>" class="form-control total" style="border:none;background: none !important;" readonly id="refunded">
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>
<?php ActiveForm::end(); ?>


</div>
</div>
</div>
<div class="row" style="position: fixed;bottom: 0;margin-bottom: -20px;width: 100%;z-index: 1200">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button type="button" onclick="submitForm()" <?= ($model->order_status=='Closed')?'disabled':''; ?> class="btn btn-info save_submit" data-toggle="tooltip" data-original-title=<?= 'SAVE'?>><img src="img/icons/save.png" style="height:12px"> <?= 'SAVE'?></button>
                <button type="button" class="btn btn-warning btn-cancel-back-new" data-toggle="tooltip" data-original-title=<?= 'CANCEL'?>><?= 'CANCEL'?>
                </button> 
            </div>
        </div>
    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript">

    var count_item_payment="<?= $count_item_payment;?>";
     function submitForm(){
      
     // alert($('#booking_header_form').attr('action'));

    $.ajax({
    url:$('#booking_header_form').attr('action'),
    type: 'post',
    dataType:'json',
    data:$("#booking_header_form").serialize(),
    beforeSend: function(){
          $(".overlay").show();
        },
     complete: function(){
      $(".overlay").hide();

     },
      success: function (data) {
        // console.log(data)
       $('.form-control').removeClass("errors_color");
       var html="";
      var cleaned = removeDuplicates(data['errors']);

   // console.log(cleaned);
       for(var key in data['errors']){       
          $('#'+key).addClass("errors_color");                 
        }
        for(var key in cleaned){       
          html+=key+"<br>";
        }
       $("html, body").animate({ scrollTop: 0 }, "slow");
       if(html!=''){
       test_submit=0;
       $(".error-summary-sales").show();
        $("#error_display_sales").html(html);
       }else{
         $(".error-summary-sales").hide();
          location.reload();        
       }
       $('#redirect_saved_changes').hide();

      },
      error: function(jqXhr, textStatus, errorThrown ){
                 //  alert(errorThrown); 
                  test_submit=1;
                    if(errorThrown=='Forbidden'){
                         alert(you_dont_have_access_label);
                        }
      }
    });

    
   // wait(3000);
   //test_submit=0;

 
  }
  function back_click() {
    window.location.href = "<?php echo Yii::$app->request->baseUrl.'/index.php?r=booking/update&id='.$_GET['id'] ?>";
  }
function removeDuplicates(json_all) {
    var arr = [];   
    $.each(json_all, function (index, value) {        
          arr[value]=(value);        
    });
    return arr;
}
function add_total_payment(){
    var paid_amount=0;
    var refund=0;
    var return_amount=0;
    var cancellation_charges=0;
    var other_charges=0;
var comman_option ='<option value="Cash" selected="">Cash</option><option value="Google Pay">Google Pay</option><option value="Phone Pe">Phone Pe</option><option value="Bank Transfer">Bank Transfer</option><option value="Paytm">Paytm</option><option value="Other">Other</option>';
var deposite_option= '<option value="Deposit" selected="">Deposit</option>';
 for(i=0;i<count_item_payment;i++){
    var amount_val=$("#paymentmaster-"+i+"-amount").val();
    var type_payment=$("#paymentmaster-"+i+"-type").val();

    if(type_payment=="Return-Deposit"){
       refund=+refund + +Number(amount_val);
    }else if(type_payment=="Cancel-Charge"){
       cancellation_charges=+cancellation_charges + +Number(amount_val);
       //paid_amount=+paid_amount + +Number(amount_val);
    }else if(type_payment=="Return-Payment"){
           return_amount=+return_amount + +Number(amount_val);
           paid_amount=+paid_amount - +Number(amount_val);
     }else if(type_payment=="Other-Charges"){
           other_charges=+other_charges + +Number(amount_val);
          // paid_amount=+paid_amount + +Number(amount_val);
     }else{
            paid_amount=+paid_amount + +Number(amount_val);
        }
        
      if(type_payment=="Cancel-Charge" || type_payment=="Other-Charges"){

         $("#paymentmaster-"+i+"-mode_of_payment").empty().append(deposite_option); 
      }else{
         if($("#paymentmaster-"+i+"-mode_of_payment").val()=='Deposit'){
             $("#paymentmaster-"+i+"-mode_of_payment").empty().append(comman_option);
         }
      }
    }
   
   var net_value=Number($("#sub_total").val());
   var deposit_amount=$("#total_deposite_amount").val()
   $("#return_amount").val(return_amount);
   $("#cancellation_charges").val(cancellation_charges);
   $("#other_charges").val(other_charges);
   $("#paid_amount").val(paid_amount);
   $("#pending_amount").val(net_value - (paid_amount-cancellation_charges));
   $("#display_pending").html("Amount: "+$("#pending_amount").val());
   $("#refunded").val(refund);
   $("#refund_dis").val(refund+'/'+deposit_amount);
}

     $(document).ready(function() {

         $("#display_pending").html("Amount: "+$("#pending_amount").val());

         $("#paymentmaster-0-test").hide();


         $('.item_details_lable .glyphicon-remove').unbind().click(function(){

             removeRow($(this));
             //$(this).closest('.temp_change_item').();
             // $(this).closest('td.other_quantity').hide();
             //  $('.name_input_field').show();
         });
         $('.item_details_lable .glyphicon-pencil').unbind().click(function(){
             updateItemRow($(this));
         });




     });
    function addPaymentitem(){
        count_item_payment++;
        $("#sales_items_tab_payment .dynamicform_wrapper_payment").on("afterInsert", function(e, item) {


        });
    }


    function removePaymentitem (){
        saved_flag=true;
        /* if (count_item==2) {
          flushdata('');
         }*/
        if(count_item_payment>2){
            count_item_payment=count_item_payment-1;
            //  count_item_sr=count_item_sr-1;
        }
        jQuery("#sales_items_tab_payment .dynamicform_wrapper_payment").on("afterDelete", function(e, item) {

            //add();
            add_total_payment('');
        });
    }
</script>