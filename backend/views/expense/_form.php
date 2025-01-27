<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\ExpenseItem;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\ExpenseHeader */
/* @var $form yii\widgets\ActiveForm */
?>

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
$form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'expense_form', 'options' => ['class' => 'disable-submit-buttons','onSubmit'=> 'return clientShowLoader()']]);
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
                                                       <?php echo $form->field($vendor_model, 'name')->textInput(['maxlength' => true,'onkeyup'=>"customerchange(this.value,this.id)",'class'=>'form-control text_first','placeholder'=> $model->attributeLabels()['name'],'autocomplete'=>"off"])->label(false);?>
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
                                                         <?php echo $form->field($vendor_model, 'contact_nos')->textInput(['maxlength' => true,'class'=>'form-control text_first','placeholder'=> $model->attributeLabels()['contact_nos'],'autocomplete'=>"off"])->label(false);?>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="row" style="margin-bottom: 7px;">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4"><?= $model->attributeLabels()['expense_date'] ?></label>
                                        <div class="col-md-8">
                                            <?php  $model['expense_date']=($model['expense_date'] !='')?Yii::$app->formatter->asDate($model['expense_date'],'dd-MM-Y'):date('d-m-Y');

                                            echo DatePicker::widget([
                                                'name' => 'ExpenseHeader[expense_date]',

                                                'type' => DatePicker::TYPE_INPUT,
                                                'value'=> $model['expense_date'],
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
                                                </div>
                                                          <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label text-left col-md-3" style="padding-right: 0px !important">Category</label>
                                                    <div class="col-md-9">
                                                        <?php  $prompt_exp=array('class'=>'form-control  table-feild','prompt' => 'Select Category', 'style'=>"width:100%;",'onchange'=>'change_category()'); 
                                                        ?>
                                                        <?= $form->field($model, "expense_category")->dropDownlist($expense_category,$prompt_exp)->label(false); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                          <div class="col-md-6" class="item_wise">
                                                <div class="form-group row">
                                                    
                                                    <div class="col-md-9">
                                                <?=  $form->field($model, 'item_level_expense')
          ->checkBox(['class'=>'item_level_expense check ','data-checkbox'=>"icheckbox_square-red"]); ?>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!--/span-->
                                        </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                     
                                        <!--/row-->
                                      
                                   
                    <div class="col-lg-4">
              <?php if($model['image_url']){ 
             $image_path= Yii::getAlias('@web').'/expense/'.$model['image_url'];
           
            
            }else{ 
             $image_path= Yii::getAlias('@web').'/img/no-image.jpg';
             } ?>

                        <div class="form-body">

                            <!--/row-->
                           
                           <div class="row">
                               <div class="col-md-12">
                                <input type="file" id="input-file-now-custom-1" name="fileToUpload" class="dropify" data-default-file="<?= $image_path; ?>" />
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                    <h1><b><center><div id="display_pending" style="background-color: #c4ecba">Amount:  <?= ($model->expense_amount!='')?$model->expense_amount:0; ?></div></center></b></h1>
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
        'model' => $expense_items[0],
        'formId' => 'expense_form',
        'formFields' => [
            'description',
        ],
    ]); ?>
    <table class="table color-bordered-table muted-bordered-table table-striped">
        <thead>
            <tr>
                <th style="width: 30%">Item Name </th>
                 <th style="width: 10%">Image </th>
               
                <th style="width: 35%">Remark</th> 
                <th style="width: 40%">Expense Amt.</th>
               

                <!--<th style="width: 450px;">Quantity</th>-->
                <th class="text-center" style="width: 5%;">
                <button type="button" onclick="addPaymentitem()"" class="add-payment btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="container-items-payment">
        <?php 
             $array1=[new ExpenseItem()];
             $expense_items=array_merge($array1,$expense_items);
             $count_item_payment=count($expense_items);
             $sub_total=0;
        foreach ($expense_items as $indexHouse => $expense_item): 
           // $active_div=($model->id!='' && $indexHouse!=0)?'':'display:none;';
          // $expense_item['date']=($expense_item['date']=="")?date('Y-m-d'):$expense_item['date'];
            $image_path= Yii::getAlias('@web').'/img/no-image.jpg';
           if($indexHouse!=0){
            if(isset($expense_item->item_code) && $expense_item->item_code!=''){
                $expense_item->item_name=$expense_item->item->name;
           if($expense_item->item->images){ 
             $image_path= Yii::getAlias('@web').'/uploads/'.$expense_item->item['images'];
           
            
            }

                //$image =$expense_item->item->images;

            }
           }
            ?>
            <tr class="payment-item" id='<?php echo "expenseitem-{$indexHouse}-test";?>'>
                 <td id='<?php echo "expenseitem-{$indexHouse}-tax_new_id";?>' style="text-align: center;vertical-align: middle !important;">
<div class="col-lg-12 name_input_field " style="padding-right:0px"> 
            <input type="text" autocomplete="off" name="<?php echo "ExpenseItem[{$indexHouse}][description]" ?>" placeholder="Select Item" onkeyup = "changeitemdetails(this.value,this.id)" id='<?php echo "expenseitem-{$indexHouse}-description" ?>' class="valid_till_date form-control" value="<?php echo $expense_item['description']; ?>">
            <i class="glyphicon glyphicon-menu-down items-icon" id="<?php echo "expenseitem-{$indexHouse}-item_name_icn" ?>" onclick="changeitemdetails('',this.id)" style="font-size: 11px;padding:5px;position: absolute;right:0;margin: 3px 10px 0 0"></i>
               <div class='item_autocomplete' id='<?php echo "expenseitem-{$indexHouse}-box";?>'></div>
                      <?= $form->field($expense_item, "[{$indexHouse}]expense_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
</div>
               </td>
               <td>
                   <img src="<?= $image_path; ?>" style="height:80px" id='<?php echo "expenseitem-{$indexHouse}-image" ?>'>
               </td>
               <td>
                <?= $form->field($model, '[{$indexHouse}]remark')->textarea(['rows' => '2','placeholder'=>"Enter Remark"])->label(false) ?>
                     

                       
                
                </td>
                 
                <td>
                     <?= $form->field($expense_item, "[{$indexHouse}]item_type")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                     <?= $form->field($expense_item, "[{$indexHouse}]expense_item_no")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                     <?= $form->field($expense_item, "[{$indexHouse}]item_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                      <?= $form->field($expense_item, "[{$indexHouse}]item_category")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                    <?= $form->field($expense_item, "[{$indexHouse}]amount")->label(false)->textInput(['maxlength' => true,'onkeyup'=> 'add_total_payment(this.id)','placeholder'=>'0.00']) ?>
                </td>
              

                <!-- <td>
                    <?php // $form->field($expense_item, "[{$indexHouse}]rent_amount")->label(false)->textInput(['maxlength' => true,'onkeyup'=> 'add_total_payment(this.id)','placeholder'=>'0.00',]) ?>
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
                                        <input type="text" name="ExpenseHeader[expense_amount]" id="sub_total" value="<?= ($model->expense_amount==''? 0 :$model->expense_amount )?>" class="form-control total" style="border:none;background: none !important;" readonly id="paid_amount">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        $("#expenseitem-0-test").hide();
   /*     $('.desc .temp_change_item').unbind().click( function(){
            var vendor_id=$("#hidden_id").val();

                select_item_function($(this));

        });*/
       var drEvent = $('#input-file-now-custom-1').dropify();

 $("form#expense_form").submit(function(e){
       e.preventDefault();    
    var formData = new FormData(this);
      
 if(form_submit){
    form_submit=false;
      setTimeout(function() {
    $.ajax({
    url:$('#expense_form').attr('action'),
    type: 'post',
    dataType:'json',
     cache: false,
        contentType: false,
        processData: false,
    
    data:formData,
    //data:$("#expense_form").serialize(),
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
    $('#expense_form').submit();

}
function removeDuplicates(json_all) {
    var arr = [];   
    $.each(json_all, function (index, value) {        
          arr[value]=(value);        
    });
    return arr;
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
   var count_item_payment="<?= $count_item_payment;?>";

    function showView(id,name,flag=0){

        saved_flag=true;
       // $('#cust_details').html(name);
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
                //$("#vendormaster-email_id").val(data['email_id']);
                $("#vendormaster-name").val(name);
               // $("#vendormaster-group_id").val(data['group_id']);
                //$("#vendormaster-address").val(data['address']);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                if(errorThrown=='Forbidden'){
                    alert(you_dont_have_access_label);
                }
            }
        });

    }
    function add_total_payment(id){
   var final_value=0;
    //alert(count_item_payment);
 for(i=0;i<count_item_payment;i++){
    var amount_val=$("#expenseitem-"+i+"-amount").val();
final_value+=Number(amount_val);

   }
    $("#sub_total").val(final_value);
   //var net_value=Number($("#sub_total").val());

   $("#display_pending").html("Amount: "+final_value);

}
     function selectgoodservitem(item_id,item_details,id,purchase_amount,item_type,item_category,img_path) {
    var n = id.lastIndexOf('-');
    var result = '#'+id.substring(0,n+1);
    
      $(result+'description').val(item_details);
      $(result+'expense_item_no').val(item_id);
      //$(result+'amount').val(purchase_amount);
      $(result+'item_type').val(item_type);
      $(result+'item_category').val(item_category);
      $(result+'image').attr("src",img_path);
       var result1 =  result+"box";
     $(result1).hide();
     // $(result+'item_type').val(item_details);
     add_total_payment(id);
}

    function changeitemdetails(val,id_pass){
    //var value = $("#itemselection-item_type").val();
    // $(label_name).find('.service_name').hide();
    // $(label_name).find('.'+value).show();

   var n = id_pass.lastIndexOf('-');
    var result = '#'+id_pass.substring(0,n+1);   

         $.ajax({
          url:"<?php echo \Yii::$app->getUrlManager()->createUrl('purchase/item-details-purchase') ?>",
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
</script>