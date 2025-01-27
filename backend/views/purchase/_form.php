<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\BookingItem;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\popover\PopoverX;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use backend\models\PaymentMaster;
use backend\models\PurchaseItem;

?>
<?php
/*$tax_active_string=($model_company->TAX_ACTIVE==1)?'':'display:none';
$sales_departmnet_string=($model_company->MULTI_SALES_DEPARTMENT==1)?'':'display:none';
$sales_location_string=($model_company->MULTI_SALES_LOCATION==1)?'':'display:none';*/
?>
<!-- <script src="js/sweetalert.min.js"></script> -->
<style type="text/css">
    /*  .table-bordered>tbody>tr>td,.table-bordered>thead>tr>th{
  border:1px solid #eee !important;
 }*/
 .form-group {
     margin-bottom: 0px;
}
.page-titles{
    margin-bottom: 10px!important;
}
.form-control {
    font-size: 15px;
    font-weight: 100;
}
.control-label {
    font-size: small;
    font-weight: 500;
}
th{
    font-size: 15px; 
}
.panel{
    margin-bottom: 0px !important;
 }
 .error-summary {
    color: #a94442;
    background: #efd4d4;
    border-left: 3px solid #eed3d7;
    padding: 10px 20px;
/*    margin: 0 15px 15px 15px;*/
}
    .ui-widget-content,.autocomplete {
        border: 1px solid #aaaaaa !important;
        background: #ffffff url("images/ui-bg_flat_75_ffffff_40x100.png") 50% 50% repeat-x !important;
        color: #222222 !important;
        max-height:150px !important;
        overflow-y:auto !important;
        overflow-x:hidden !important;
        font-size:11px !important;
        padding-left:0px;
        text-align: left;
    }
    .ui-menu-item,.autocomplete li {
        position: relative !important;
        margin: 0 !important;
        padding: 3px 1em 3px .4em !important;
    }

    .ui-menu-item,.autocomplete li,.ui-widget{
        cursor: pointer !important;
        min-height: 0 !important;
        list-style-image: url("data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7") !important;
    }

    .ui-widget,.autocomplete li {
        font-family: Verdana,Arial,sans-serif !important;
    }

    .ui-menu-item div:hover ,.autocomplete li:hover{
        background: #337ab7 !important;
        font-weight: normal !important;
        color: #fff !important;
    }
    .autocomplete{  ;position: absolute;z-index:3;margin-top: -4px}
    .autocomplete li{
        padding: 3px 0em 3px 0em;
        border:none !important;
    }
    .item_autocomplete .autocomplete_data {
        width:100% !important;
    }
    .autocomplete{
        margin-top:2px;
        width: 100%

    }
    .autocomplete li{
        width: 100%;
    }
    .number input[type="text"]{
        text-align:right;
    }
    input[readonly], input[readonly="readonly"],input[disabled],select[disabled]{
        cursor: not-allowed;
        background:transparent !important;
    }
    .number input[type="text"]:hover{
        background: #F9F9F9 !important;
        border-bottom:1px solid #aaa;
    }

</style>


<?php
 //echo (Yii::$app->session->hasFlash('success'));die;
  
   
$active_div=true;

$label_select='SELECT';
$form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'booking_header_form', 'options' => ['class' => 'disable-submit-buttons','onSubmit'=> 'return clientShowLoader()']]);
?>
<div class="row" >
    <div class="card col-lg-12">

        <div class="card-body">
    <div class="col-lg-12">
        <div class="error-summary-sales alert alert-danger" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;#errors_test1&quot;).hide()"></i><h5 class="text-danger"><b><i class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b></h5></p>
            <hr class="custom_error_hr">
            <div id="error_display_sales" class="custom_error"></div>
        </div>
    </div>
<input type="hidden" name ="booking_sms" id="booking_sms" value="0">
 <?php echo $form->field($model, 'vendor_id')->hiddenInput(['maxlength' => true,'class'=>'form-control','placeholder'=> $model->attributeLabels()['vendor_id'],'autocomplete'=>"off",'id'=>"hidden_id"])->label(false);
                        echo $form->field($vendor_model, 'id')->hiddenInput(['maxlength' => true,'class'=>'form-control','placeholder'=> $model->attributeLabels()['vendor_id'],'autocomplete'=>"off"])->label(false);
                        //echo $form->field($model, 'order_type')->hiddenInput(['maxlength' => true,'class'=>'form-control','placeholder'=> $model->attributeLabels()['order_type']])->label(false);  ?>
  <!-- Row -->
                <div class="row">

                    <div class="col-lg-8">
                                    <div class="form-body">
                                        <h5 class="box-title">Vendor</h5>
                                        <hr class="m-t-0">
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-left col-md-2">Name</label>
                                                    <div class="col-md-10"    style="padding-left: 0px!important; margin-left: -12px;">
                                                       <?php echo $form->field($vendor_model, 'name')->textInput(['maxlength' => true,'onkeyup'=>"customerchange(this.value,this.id)",'class'=>'form-control text_first','placeholder'=> $vendor_model->attributeLabels()['name'],'autocomplete'=>"off"])->label(false);?>
                                                       <div id='customer_autodata' style="background-color:black"></div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-left col-md-3" style="padding-right: 0px !important">Mobile No.</label>
                                                    <div class="col-md-9">
                                                         <?php echo $form->field($vendor_model, 'contact_nos')->textInput(['maxlength' => true,'class'=>'form-control text_first','placeholder'=> $vendor_model->attributeLabels()['contact_nos'],'autocomplete'=>"off"])->label(false);?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-left col-md-3">Email ID</label>
                                                    <div class="col-md-9">
                                                        <?php echo $form->field($vendor_model, 'email_id')->textInput(['maxlength' => true,'class'=>'form-control text_first','placeholder'=> $vendor_model->attributeLabels()['email_id'],'autocomplete'=>"off"])->label(false);?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-left col-md-3" style="padding-right: 0px !important">Group</label>
                                                    <div class="col-md-9">
                                                       <?= $form->field($vendor_model, 'group_id')->dropDownList([ 'None' => 'None', 'Supplier' => 'Supplier', 'Dry Cleaning' => 'Dry Cleaning', 'Alteration' => 'Alteration'],['class'=>'form-control text_first',])->label(false) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-left col-md-3" style="padding-right: 0px">address</label>
                                                    <div class="col-md-9">
                                                        <?php // $form->field($vendor_model, 'cust_group')->dropDownList([ 'None' => 'None', 'Photographer' => 'Photographer', 'Model' => 'Model', 'Friend' => 'Friend', ], ['class'=>'form-control text_first'])->label(false) ?>
                                             <?= $form->field($vendor_model, 'address')->textInput(['maxlength' => true,'class'=>'form-control text_first','placeholder'=> $vendor_model->attributeLabels()['address'],'autocomplete'=>"off"])->label(false);


                                                        //$form->field($vendor_model, 'address_group')->dropDownList($address_grup, ['class'=>'form-control text_first'])->label(false) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                      
                                    </div>

                            
                         
                    </div>
                    <div class="col-lg-4">


                        <div class="form-body">

                            <!--/row-->
                            <div class="row" style="margin-bottom: 7px;">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4"><?= $model->attributeLabels()['purchase_date'] ?></label>
                                        <div class="col-md-8">
                                            <?php  $model['purchase_date']=($model['purchase_date'] !='')?Yii::$app->formatter->asDate($model['purchase_date'],'dd-MM-Y'):date('d-m-Y');

                                            echo DatePicker::widget([
                                                'name' => 'PurchaseHeader[purchase_date]',

                                                'type' => DatePicker::TYPE_INPUT,
                                                'value'=> $model['purchase_date'],
                                                //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                                                'options' => [
                                                    'placeholder' => 'dd-mm-yyyy',
                                                ],
                                                'pluginOptions' => [
                                                    'autoclose'=>true,
                                                    'format' => 'dd-mm-yyyy'
                                                ]
                                            ]); ?>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <h1><b><center><div id="display_pending" style="background-color: #c4ecba">Amount:  <?= ($model->purchase_amount!='')?$model->purchase_amount:0; ?></div></center></b></h1>
                                </div>
                            </div>
                            <!--/row-->
                        </div>



                    </div>

                </div>
                <!-- Row -->





 <div class="col-lg-12" style="padding-left: 0px">
  

        
<div class="row  col-lg-12"  style="padding-left: 0px;" >
      
        <div class="col-lg-12" id="sales_items_tab_payment" style="margin-top: 10px">
               <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_payment',
        'widgetBody' => '.container-items-payment',
        'widgetItem' => '.payment-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-payment',
        'deleteButton' => '.remove-payment',
        'model' => $purchase_items[0],
        'formId' => 'booking_header_form',
        'formFields' => [
            'description',
        ],
    ]); ?>
    <table class="table color-bordered-table muted-bordered-table table-striped">
        <thead>
            <tr>
                <th style="width: 30%">Item Name </th>
                 <th style="width: 30%">Image </th>
                <!-- <th style="width: 25%">Category </th>
                <th style="width: 25%">Type</th> -->
                <th style="width: 40%">Purchase Amt.</th>
               

                <!--<th style="width: 450px;">Quantity</th>-->
                <th class="text-center" style="width: 5%;">
                <button type="button" onclick="addPaymentitem()"" class="add-payment btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="container-items-payment">
        <?php 
             $array1=[new PurchaseItem()];
             $purchase_items=array_merge($array1,$purchase_items);
             $count_item_payment=count($purchase_items);
             $sub_total=0;
        foreach ($purchase_items as $indexHouse => $purchase_item): 
           // $active_div=($model->id!='' && $indexHouse!=0)?'':'display:none;';
          // $purchase_item['date']=($purchase_item['date']=="")?date('Y-m-d'):$purchase_item['date'];
            $image_path= Yii::getAlias('@web').'/img/no-image.jpg';
           if($indexHouse!=0){
            if(isset($purchase_item->item_code) && $purchase_item->item_code!=''){
                $purchase_item->item_name=$purchase_item->item->name;
           if($purchase_item->item->images){ 
             $image_path= Yii::getAlias('@web').'/uploads/'.$purchase_item->item['images'];
           
            
            }

                //$image =$purchase_item->item->images;

            }
           }
            ?>
            <tr class="payment-item" id='<?php echo "purchaseitem-{$indexHouse}-test";?>'>
                 <td id='<?php echo "purchaseitem-{$indexHouse}-tax_new_id";?>' style="text-align: center;vertical-align: middle !important;">
<div class="col-lg-12 name_input_field " style="padding-right:0px"> 
            <input type="text" autocomplete="off" name="<?php echo "PurchaseItem[{$indexHouse}][item_name]" ?>" placeholder="Select Item" onkeyup = "changeitemdetails(this.value,this.id)" id='<?php echo "purchaseitem-{$indexHouse}-item_name" ?>' class="valid_till_date form-control" value="<?php echo $purchase_item['item_name']; ?>">
            <i class="glyphicon glyphicon-menu-down items-icon" id="<?php echo "purchaseitem-{$indexHouse}-item_name_icn" ?>" onclick="changeitemdetails('',this.id)" style="font-size: 11px;padding:5px;position: absolute;right:0;margin: 3px 10px 0 0"></i>
               <div class='item_autocomplete' id='<?php echo "purchaseitem-{$indexHouse}-box";?>'></div>
                      <?= $form->field($purchase_item, "[{$indexHouse}]purhcase_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
</div>
               </td>
               <td>
                   <img src="<?= $image_path; ?>" style="height:80px" id='<?php echo "purchaseitem-{$indexHouse}-image" ?>'>
               </td>
                <!--  <td>
                      <?php // $form->field($purchase_item, "[{$indexHouse}]item_category")->dropDownList($model_category,['prompt'=>'Select Category','onchange'=>'getItemType(this.id,this.value)'])->label(false) ?>
                
                </td>
                   <td>

                  <?php // $form->field($purchase_item, "[{$indexHouse}]item_type")->dropDownList(array())->label(false) ?>
                </td> -->
                <td>
                     <?= $form->field($purchase_item, "[{$indexHouse}]item_type")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                     <?= $form->field($purchase_item, "[{$indexHouse}]item_no")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                     <?= $form->field($purchase_item, "[{$indexHouse}]item_code")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                      <?= $form->field($purchase_item, "[{$indexHouse}]item_category")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                    <?= $form->field($purchase_item, "[{$indexHouse}]net_value")->label(false)->textInput(['maxlength' => true,'onkeyup'=> 'add_total_payment(this.id)','placeholder'=>'0.00']) ?>
                </td>
              

                <!-- <td>
                    <?php // $form->field($purchase_item, "[{$indexHouse}]rent_amount")->label(false)->textInput(['maxlength' => true,'onkeyup'=> 'add_total_payment(this.id)','placeholder'=>'0.00',]) ?>
                </td>
 -->
                
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-payment btn btn-danger btn-xs" onclick="removePaymentitem()"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
    <?php DynamicFormWidget::end(); ?>
        </div>
    </div>


    </div>
<!--              <div class="row" style="margin:0px" >
      <div class="col-lg-12">
         <div class="col-lg-6">


          </div>
      </div>
    </div> -->
            <div class="row col-lg-4 form-total pull-right">
                <div class="panel panel-default">
                    <!--  <div class="panel-heading"></div> -->
                    <div class="panel-body" style="padding-top:0px !important;padding-bottom:0px !important">
                        <!-- Nav tabs -->

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                <div class="form-group">
                                    <label class="col-md-6 control-label"> Amount </label>
                                    <div class="col-md-6 number">
                                        <input type="text" name="PurchaseHeader[purchase_amount]" id="sub_total" value="<?= ($model->purchase_amount==''? 0 :$model->purchase_amount )?>" class="form-control total" style="border:none;background: none !important;" readonly id="paid_amount">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="row">
              <?php if($model['image']){
             $image_path= Yii::getAlias('@web').'/purchase/'.$model['image'];
             $image_path_2= Yii::getAlias('@web').'/purchase/'.$model['image1'];
             $image_path_3= Yii::getAlias('@web').'/purchase/'.$model['image2'];
             $image_path_4= Yii::getAlias('@web').'/purchase/'.$model['image3'];
             $image_path_5= Yii::getAlias('@web').'/purchase/'.$model['image4'];
             $image_path_6= Yii::getAlias('@web').'/purchase/'.$model['image5'];


            }else{
             $image_path= Yii::getAlias('@web').'/img/no-image.jpg';
             $image_path_2= Yii::getAlias('@web').'/img/no-image.jpg';
             $image_path_3= Yii::getAlias('@web').'/img/no-image.jpg';
             $image_path_4= Yii::getAlias('@web').'/img/no-image.jpg';
             $image_path_5= Yii::getAlias('@web').'/img/no-image.jpg';
             $image_path_6= Yii::getAlias('@web').'/img/no-image.jpg';
             } ?>
                               <div class="col-md-2">
                                <input type="file" id="input-file-now-custom-1" name="fileToUpload" class="dropify" data-default-file="<?= $image_path; ?>" multiple />
                                </div>

                               <div class="col-md-2">
                                <input type="file" id="input-file-now-custom-2" name="fileToUpload-2" class="dropify" data-default-file="<?= $image_path_2; ?>" multiple />
                                </div>
                                <div class="col-md-2">
                                <input type="file" id="input-file-now-custom-3" name="fileToUpload-3" class="dropify" data-default-file="<?= $image_path_3; ?>" multiple />
                                </div>
                                <div class="col-md-2">
                                <input type="file" id="input-file-now-custom-4" name="fileToUpload-4" class="dropify" data-default-file="<?= $image_path_4; ?>" multiple />
                                </div>
                                <div class="col-md-2">
                                <input type="file" id="input-file-now-custom-5" name="fileToUpload-5" class="dropify" data-default-file="<?= $image_path_5; ?>" multiple />
                                </div>
                                 <div class="col-md-2">
                                <input type="file" id="input-file-now-custom-6" name="fileToUpload-6" class="dropify" data-default-file="<?= $image_path_6; ?>" multiple />
                                </div>
                            </div>
</div>

<div class="row" style="position: fixed;bottom: 0;width: 100%; z-index:1500">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                
                    <button type="button" id="submit_btn" onclick="submitForm()" class="btn btn-info save_submit"  data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png" style="height:12px"> Save</button>
              
                  
                    <!-- <button type="button" class="btn btn-warning" onclick="send_invoice()" data-toggle="tooltip" data-original-title="Send">Send Invoice</button> -->
              

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript">
var form_submit=true;
    $(document).ready(function() {
        $("#purchaseitem-0-test").hide();
   /*     $('.desc .temp_change_item').unbind().click( function(){
            var vendor_id=$("#hidden_id").val();

                select_item_function($(this));

        });*/
       var drEvent = $('#input-file-now-custom-1').dropify();
       var drEvent = $('#input-file-now-custom-2').dropify();
       var drEvent = $('#input-file-now-custom-3').dropify();
       var drEvent = $('#input-file-now-custom-4').dropify();
       var drEvent = $('#input-file-now-custom-5').dropify();

 $("form#booking_header_form").submit(function(e){
       e.preventDefault();    
    var formData = new FormData(this);
      
 if(form_submit){
    form_submit=false;
      setTimeout(function() {
    $.ajax({
    url:$('#booking_header_form').attr('action'),
    type: 'post',
    dataType:'json',
     cache: false,
        contentType: false,
        processData: false,
    
    data:formData,
    //data:$("#booking_header_form").serialize(),
    beforeSend: function(){
          $(".overlay").show();
        },
     complete: function(){
      $(".overlay").hide();
      $('#submit_btn').prop('disabled', false);
        form_submit=true;
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
},1000);
    
   // wait(3000);
   //test_submit=0;
}
 
  });
        

    });
function submitForm() {

    $('#submit_btn').prop('disabled', true);
    $('#booking_header_form').submit();

}

    


var count_item_payment="<?= $count_item_payment;?>";

    function showView(id,name,flag=0){

        saved_flag=true;
        $('#cust_details').html(name);
        $('.arrow-img').hide();
        $('#customer_autodata').hide();
        $('.cust_icon').show();

        $('#hidden_id').val(id);
        $('#vendormaster-id').val(id);
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=purchase/vendor-details' ?>',
            type: 'get',
            dataType:'json',
            data:{
                id:id
            },
            success: function (data) {

                console.log(data);
                $("#vendormaster-contact_nos").val(data['contact_nos']);
                $("#vendormaster-email_id").val(data['email_id']);
                $("#vendormaster-name").val(name);
                $("#vendormaster-group_id").val(data['group_id']);
                $("#vendormaster-address").val(data['address']);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                if(errorThrown=='Forbidden'){
                    alert(you_dont_have_access_label);
                }
            }
        });

    }


function changeitemdetails(val,id_pass){
    //var value = $("#itemselection-item_type").val();
    // $(label_name).find('.service_name').hide();
    // $(label_name).find('.'+value).show();

   var n = id_pass.lastIndexOf('-');
    var result = '#'+id_pass.substring(0,n+1);   

         $.ajax({
          url:"<?php echo \Yii::$app->getUrlManager()->createUrl('purchase/item-details-autocomplete') ?>",
          dataType: 'json',
          type: 'get',
          data:{
            term:val,
            id:id_pass,
           // type:value,
          },
          success: function( data, textStatus, jQxhr ){  
           
            var result1 =  result+"box";
            $(result1).show();
            var result2 = "#itemselection-description";
              var data_new= '<ul class="autocomplete add_new">';
              data_new+="<li value=''>"+'<?= 'SELECT'; ?>'+"</li>";

            data_new+="<li value='Add New' onClick='addnewItem(\""+data['id_pass']+"\")'><i class='fa fa-plus'></i> "+'<?= 'ADD_NEW'; ?>'+"</li>";
            //console.log(data);
              for(i=0; i<data['item_details'].length; i++) {
                var image_name='img/no-image.jpg';
               // alert(data['item_details'][i]['images']!= '');
                if(data['item_details'][i]['images']!= ''){
                    image_name='uploads/'+data['item_details'][i]['images'];
                }
                
               var item_name = addslashes(data['item_details'][i]['name']);
               var img_path = addslashes(image_name);
                   data_new += '<li onClick="selectgoodservitem('+data['item_details'][i]['id']+',\''+item_name+'\',\''+id_pass+'\',\''+data['item_details'][i]['purchase_amount']+'\',\''+data['item_details'][i]['type_id']+'\',\''+data['item_details'][i]['category_id']+'\',\''+img_path+'\')"><img src="'+image_name+'" style="height: 70px;width: 70px;">'+data['item_details'][i]['id']+" - "+data['item_details'][i]['name']+'</li>';

              }
              data_new += '</ul>';     
       
             $(result1).html(data_new);
            // alert($(result1).html());
                // $(result2).prop('readonly',true);

             },
              error: function( jqXhr, textStatus, errorThrown ){
              //alert(errorThrown);
                   if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS';?>");
                        }
              //console.log( errorThrown );
              }
          });

    
   
     
   }
 function selectgoodservitem(item_id,item_details,id,purchase_amount,item_type,item_category,img_path) {
    var n = id.lastIndexOf('-');
    var result = '#'+id.substring(0,n+1);
    
      $(result+'item_name').val(item_details);
      $(result+'item_code').val(item_id);
      $(result+'net_value').val(purchase_amount);
      $(result+'item_type').val(item_type);
      $(result+'item_category').val(item_category);
      $(result+'image').attr("src",img_path);
       var result1 =  result+"box";
     $(result1).hide();
     // $(result+'item_type').val(item_details);
     add_total_payment(id);
}






    function customerchange(val, id_pass,flag=0){
        saved_flag=true;
        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('purchase/vendor-autocomplete') ?>",
            dataType: 'json',
            type: 'get',
            data:{
                term:val,
                id:id_pass,
            },
            success: function( data, textStatus, jQxhr ){

                var n = data['id_pass'].lastIndexOf('-');
                var result1 = '#customer_autodata';


                var data_new= '<ul class="autocomplete add_new_autocomplete" >';

                for(i=0; i<data['vendor_data'].length; i++) {
                    data_new += '<li onClick="showView(\''+data['vendor_data'][i]['id']+'\',\''+data['vendor_data'][i]['name']+'\','+flag+')">'+data['vendor_data'][i]['name']+'</li>';
                }
                data_new += '</ul>';
                if(flag==1){
                    $('.customer_autodata_show').show();
                    $('.customer_autodata_show').html(data_new);
                    $(".customer_sales_data").removeClass('even-strip');
                    $('.customer_sales_data').parent('.row').removeClass('billimg-edit');
                }else{
                    //alert(result1);
                    $(result1).show();
                    $('.add_new_autocomplete').css('display','');
                    $(result1).html(data_new);
                    $("#customer_sales").removeClass('even-strip');
                    $('#customer_sales').parent('.row').removeClass('billimg-edit');
                }

            },
            error: function( jqXhr, textStatus, errorThrown ){
                //alert(errorThrown);
                //console.log( errorThrown );
                if(errorThrown=='Forbidden'){
                    alert(you_dont_have_access_label);
                }
            }
        });
    }
   
        
  function addnewItem(id) {

        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('item/create-popup') ?>",
            type: 'post',
            dataType:'html',
             data:{
                    id:id,
                   
                },
            beforeSend: function(){
                $(".overlay").show();
            },
            complete: function(){
                $(".overlay").hide();
            },
            success: function (data) {
                // console.log(data);
                $('#big_modal').modal('show');
                $('#bigmodalContent').html(data);
            },
            error: function(jqXhr, textStatus, errorThrown ){
                // alert(errorThrown);
                if(errorThrown=='Forbidden'){
                    alert(YOU_DONT_HAVE_ACCESS);
                }
            }
        });
    }
  

function removeDuplicates(json_all) {
    var arr = [];   
    $.each(json_all, function (index, value) {        
          arr[value]=(value);        
    });
    return arr;
}




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

function add_total_payment(id){
   var final_value=0;
    //alert(count_item_payment);
 for(i=0;i<count_item_payment;i++){
    var amount_val=$("#purchaseitem-"+i+"-net_value").val();
final_value+=Number(amount_val);

   }
    $("#sub_total").val(final_value);
   //var net_value=Number($("#sub_total").val());

   $("#display_pending").html("Amount: "+final_value);

}

</script>
   