<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


$active_div=($po_number=='')?'display:none;':'';
$label_select= 'SELECT'; 
$this->title = 'PickUp';
?>

<style type="text/css">

.dropdown-right {
    position: relative;
    margin-left:5px;
    float:left;
}
 .right_section .form-group,.row_new .form-group {
    margin:0px !important;
  }
    .cust-group .form-control {
  /* padding: 5px 8px;
    box-shadow: none;*/
    border: 1px solid #ced4dc !important;
  }
   .cust-group { 
    margin:0px 0px 12px 0px !important;
  }
.dropdown-right-content {
    display: none;
    position: absolute;
    right: 0;
    top:30px;
    background-color: #f9f9f9;
    min-width: 150px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1000;
}

.dropdown-right-content a {
    color: black;
    padding: 8px 5px;
    text-decoration: none;
    display: block;
}

.dropdown-right-content a:hover {background-color: #f1f1f1}

.dropdown-right:hover .dropdown-right-content {
    display: block;
}

.dropdown-right:hover .dropbtn {
    background-color:#ddd;
}
.dropdown-right-content li{
  border-bottom:1px solid #eee;
  padding:2px !important;
}
.open > .dropdown-menu {
  margin-left:-135px;
}
.dropdown-menu > li > a {
  padding:8px 20px;
}
  .row_new
  {
    margin-top: 0px !important;
    padding: 4px !important;
  }
  .form-control 
  {
    border-color: #f4f4f4 !important;
  }
  .control-label 
  {
    margin-top:9px !important;
  }

  .dynamic_table td input[type="text"]:focus
  {
    border:1px solid #eee !important;
    margin:0px !important;
  }
  #pur_doc_flow_goods_items_details .table-bordered>tbody>tr>td,.table-bordered>thead>tr>th
  {
    border:1px solid #eee !important;
  }
  #pur_doc_flow_goods_items_details .table-bordered>tbody>tr>td .form-group 
  {
    margin:0px !important;
  }
  #pur_doc_flow_goods_items_details .table-bordered>tbody>tr>td  select
  {
    padding-left:7px; 
    margin: 1px !important;
    padding-right: 1px;
  }
  #pur_doc_flow_goods_items_details .table > tbody > tr > td 
  {
    vertical-align: top!important;
    color:#555;
  }
  .inner_desc input[type="text"]
  {
    padding-bottom: 40px;
    padding-top:10px;
  }
  .datepicker.dropdown-menu 
  {
    z-index: 10002 !important;
  }
  input[readonly], input[readonly="readonly"]{
  cursor: not-allowed;
  background:transparent !important;
}
.OPEN{
 background-color: #f5f5ab !important;
color:#696908 !important;
border-color: #696908 !important;
font-size: 10px;
display: inline;
padding: .2em .6em .3em;
/*font-size: 75%;*/
font-weight: bold;
line-height: 1; 
}
.CLOSED{
background-color: #dff0d8 !important;
color: #3c763d !important;
border-color: #dff0d8 !important;
font-size: 10px;
display: inline;
padding: .2em .6em .3em;
/*font-size: 75%;*/
font-weight: bold;
line-height: 1;
}
.PARTIAL{
background-color: #fbe5bd!important;
color: #9a7736 !important;
border-color: #9a7736 !important;
font-size: 10px;
display: inline;
padding: .2em .6em .3em;
/*font-size: 75%;*/
font-weight: bold;
line-height: 1;
}
.dynamicform_wrapper {
  overflow:inherit !important;
}
.view-striped > tbody > tr:nth-of-type(even)  
{
    background: #f9f9f9 !important;
}
.number{
  text-align: right
}
.user-header-stock {
  padding:16px;
  cursor: pointer
}
.stock-nav li{
background: #488bc3;
margin-left:10px;
color:#fff;
margin-top:8px;
padding:8px;
}
.dynamicform_wrapper {
  overflow: inherit;
}
</style>
<aside class="sidebar-modal control-sidebar-modal-dark" style="position: fixed;right:0;z-index:1090;display: none;width:80%;margin-top:-60px; height: 100%">
    <div class="tab-content" style="overflow-y:auto;overflow-x: hidden; height: 100%;">
    </div>
</aside>
<div class="row page-header update-page-header"  id="header_details">
  <div class="col-lg-12">
    <div class="col-lg-4">
      <img src="img/icons/back-arrow.png" style="height:16px;cursor:pointer" id="back_button" class="back-redirect-for-button">
    </div>
    <div class="col-lg-4" style="text-align: center;margin-top:0px!important;">
      <h4 style="margin: 0px;"><b class="category-ar"><span id="heading1"><?= Html::encode($this->title) ?></span></b></h4>
      <hr style="margin-top: 0px;margin-bottom: 0px;width: 150px;border-top:1px solid #aaa;">
      <div><b class="category-ar status-label"><?= 'STATUS' ?></b> - <span class="<?= $status;?> status-value"><?= ucfirst(strtolower($status)) ?></span></div>
    </div>

  <div style="margin: 0px!important;" class="btn-toolbar kv-grid-toolbar row pull-right" role="toolbar">
        <div class="dropdown-right" style="margin-left: 0px !important;">
          <div class="input-group" style="margin-top:0px">
           <button type="button" class="btn dropdown-toggle action-three-dot" data-toggle="dropdown" style="margin-left: 0px"><a><span class="glyphicon glyphicon-option-vertical"></span></a></button>
            <ul class="dropdown-menu action-three-dot-dropdown action pull-right">
             
             
              <li ><a style="cursor: pointer;"><i class="glyphicon glyphicon-file" style="margin-right: 3px;"></i> <?= 'NOTES' ?></a></li>
          </div>
        </div>     
   </div>
 </div>
</div>
 <div class="" id="show_operation" style="display: none;" >
    <div class="vcenter" style="background: #f5f0f0;min-height:50px;margin-top:0px;z-index:10;">
      <ul class="nav navbar-nav stock-nav">
        
        <li class="user-header-stock" onclick="GoodsIssueDataShow(0)"><b>Post </b></li>
    
      </ul>
      <div class="user-header-stock" style="float: right;"><span class="glyphicon glyphicon-remove slider-close" id="close_show_operation" style=""></span></div>   
    </div>
  </div>


  <div class="row page-header update-page-header" id="goods_heading" style="display: none;margin-bottom: 10px">
    <div class="col-lg-4" >
     <img src="img/icons/back-arrow.png" style="height:16px;cursor:pointer;margin-left: 10px;" class="back_button_cancel back-redirect-for-button">
    </div>
    <div class="col-lg-4" style="text-align: center;margin-top:0px!important;">
      <h4 style="margin: 0px;"><b class="category-ar"><span id="heading"><?= Html::encode($this->title) ?></span></b></h4>
      <hr style="margin-top: 0px;margin-bottom: 0px;width: 150px;border-top:1px solid #aaa;">
      <div><b class="category-ar status-label"><?=  'STATUS' ?></b> - <span class='<?= $status;?> status-value'><?= ucfirst(strtolower($status)) ?></span></div>
    </div>
    <div class="col-lg-4"></div>
</div>
<?php $form = ActiveForm::begin(['id'=>'purchase_document_form', 'options' => ['class' => 'disable-submit-buttons','onSubmit'=> 'return false']]);?>
   <div class="row">
     <div class="col-lg-12">
      <div class="error-summary" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;.error-summary&quot;).hide()"></i><h5><b><i class="fa fa-exclamation-triangle"></i> <?= 'ERRORS' ?>:</b></h5></p>
        <hr class="custom_error_hr">
        <div id="error_display" class="custom_error"></div>
      </div>
    </div>
  </div>
<div class="row show_vendor_data" style="display: none;">
  <div class="col-lg-12">
    <div class="">
      <div class="panel-body" style="padding-top: 0px;padding-bottom: 0px">
        <div class="tab-content">
        <div class="row right_section">
          <div class="row col-lg-6" style="margin-top:0px !important;margin-bottom:0px !important">                              
          <div class="form-group cust-group">
            <label class="col-lg-4 control-label" style="text-align: left"><?= $model->attributeLabels()[ 'POSTING_DATE'] ?></label>
              <div class="col-lg-6">
              	<div class="form-group">
                <?php  $model['POSTING_DATE']=($model['POSTING_DATE'] !='')?Yii::$app->formatter->asDate($model['POSTING_DATE'],$_COOKIE['dateFormat']):$model['POSTING_DATE']=date('d-m-Y');
                  echo DatePicker::widget([
                    'id'=>'posting_date',
                     'name' => 'GoodsMovementHeader[POSTING_DATE]',
                     'type' => DatePicker::TYPE_INPUT,

                     'value'=> $model['POSTING_DATE'],
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
        </div>

          


 </div>
    </div>
  </div>
</div>
</div><hr class="div-hr" style="margin:0px !important">



<div class="row" style="margin-bottom: 7000px">
  <div class="col-lg-10" id="pur_doc_flow_goods_items_details" style="">
    <?php DynamicFormWidget::begin([
      'id' => 'goods-receipt-details',
      'widgetContainer' => 'dynamicform_wrapper',
      'widgetBody' => '.container-goods-items',
      'widgetItem' => '.goods-item',
      'limit' => 100,
      'min' => 2,
      'insertButton' => '.add-goods',
      'deleteButton' => '.remove-goods',
      'model' => $model_goods_mov_itm,
      'formId' => 'goods_issue_form',
      'formFields' => ['DESCRIPTION',],]); ?>
    <table class="table table-responsive dynamic_table table-bordered">
      <thead class="even-strip">
        <tr>
          <th style="width:3%">
            <?php if($status=='CLOSED'){?>
              <span class="fa fa-check" style="color: #008000;cursor: pointer;" title=<?=  'GOODS_RECIEPT_COMPLETED'] ?>>
              </span>
            <?php }else {?>
              <input type="checkbox" class="chk_box_main">
            <?php }?>
          </th>
          <th style="width:20%;" class="background-color-div"> 
            <?=  'DESCRIPTION' ?>
          </th>
          <th style="width:30%;" class="background-color-div">
            <?=  'QUANTITY' ?>
          </th>
          <th style="width:30%;<?= $show_transit ?>" class="background-color-div">
            <?= 'TRANSIT_QUANTITY' ?>
          </th>
         
         
        </tr>
      </thead>
      <tbody class="container-goods-items">
        <?php
          $quantity=array();
          $count = 0;
          foreach ($purchase_items as $indexHouse => $value):
              $count++;
            
        ?>
        <tr class="goods-item">
          <td>
            <?php if($value->GR_STATUS=='CLOSED'){  ?> 
              <span class="fa fa-check" style="color: #008000;cursor: pointer;" title=<?= 'GOODS_RECIEPT_COMPLETED' ?>></span> 
            <?php }else {?>
            <input type="checkbox" name="selection[]" class="chk_boxes1" value="<?= $value['PO_ITEM']?>" id="<?= 'po_item'.$value['PO_ITEM']?>">
            <?php } ?>
          </td> 
         
       
          
          <td class="background-color-div">
             <?php echo "<p><span style='width:60%' class=''>".number_format($value->GR_QUANTITY,2)."</span></p>"; ?>
          </td>
        
        </tr>
       <?php endforeach;  ?>
      </tbody>
    </table>
    <?php DynamicFormWidget::end(); ?>
  </div>
</div>


<div class="row save_btn_div" style="position: fixed;bottom: 0;margin-bottom: -20px;width: 100%;display: none;" id="save_button_show">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <button type="button" class="btn btn-primary" onclick="submitFormPDF()"><?= 'SAVE' ?></button>
      </div>
    </div>
  </div>
</div>

<?php ActiveForm::end(); ?>
<script type="text/javascript">  
  
  function close_tabs(){
   $("#show_operation").hide();
   $("#header_details").show();
   $("#pur_doc_flow_goods_items_details").show();
   $(".transit_from").hide();
   $(".error-summary").hide();
   $(".show_vendor_data").hide();
   $("#goods_heading").hide();
   $("table tr th:nth-child(6), table tr td:nth-child(6)").hide();
   $(".save_btn_div").hide();
   $("#goods_recept_history").show();
   $("#show_history_table").hide();
}
function GoodsIssueDataShow(process){
  var show_transit = '<?= $po_header->GOODS_IN_TRANSIT_TRACK ?>';
  $(".show_vendor_data").show();
  $(".save_btn_div").show();
  $("#goods_heading").show();
  $("#goodsmovementheader-git").val(process);
  $("#post_type").val(process);
if(process==1){

 $("#show_history_table").hide();
 $(".transit_from").show();
}else if(process==2){
  
  $("#show_history_table").show();
  $(".transit_from").hide();
  $("#pur_doc_flow_goods_items_details").hide();
}else{
  $("#show_history_table").hide();
   $(".transit_from").hide();
}
  $("table tr th:nth-child(6), table tr td:nth-child(6)").show();
  if(show_transit==1){
     $("table tr th:nth-child(4), table tr td:nth-child(4)").show();
  } 
  $("#show_operation").hide();
}

 var Status = '<?= $status ?>';
  $(document).ready(function(e) {
    $("table tr th:nth-child(6), table tr td:nth-child(6)").hide();
    var id= "#purchaseitems-1-other";
    var n = id.lastIndexOf('-');    
    var other = id.substring(0,n+1)+'other';
    var plant=id.substring(0,n+1)+'plant';
    var warehouse=$(plant+" option:selected").text();
      if(warehouse && item_type=='PART'){
        $(other).show();
       var wn = warehouse.lastIndexOf('-');
       
      }
      $('#back_button').click(function(){
        window.location.href = '<?php echo Yii::$app->request->baseUrl.'/index.php?r=purchase-order-header/update&PO_NUMBER='.$po_number.'&COMPANY_CODE='.$model_company->Code ?>';        
      });

      $('.btn-cancel-back-new').click(function(){
       window.location.href = '<?php echo Yii::$app->request->baseUrl.'/index.php?r=purchase-order-header/update&PO_NUMBER='.$po_number.'&COMPANY_CODE='.$model_company->Code ?>';
      });

      $('.temp_change_batch').click(function(){
          var id_data = $(this).attr('id');
          var n = id_data.lastIndexOf('-');
          var result = '#'+id_data.substring(0,n+1);       
          var status = $(result+'gr_status').val();
          var stock_trans_status = $(result+'stock_in_transit_status').val();
         //alert(stock_trans_status);
        if(status=='PARTIAL' || status=='CLOSED' || stock_trans_status=='PARTIAL' || stock_trans_status=='CLOSED'){
          batchdatashow("#"+id_data,'GoodsMovementItems',1,1,1,1);
        }else{
          $('#purchase_search').hide();
          select_batch_function($(this),'GoodsMovementItems');
        }
      });

      $('.temp_change_serial').click( function(){
        var id_data = $(this).attr('id');
        var n = id_data.lastIndexOf('-');
        var result = '#'+id_data.substring(0,n+1);        
        var status = $(result+'gr_status').val();
        var stock_trans_status = $(result+'stock_in_transit_status').val();
        // alert(result+'batch_no');
        if(status=='PARTIAL' || status=='CLOSED' || stock_trans_status=='PARTIAL' || stock_trans_status=='CLOSED'){
          batchdatashow("#"+id_data,'GoodsMovementItems',1,1,1,1);
        }else{
          $('#purchase_search').hide();
          select_batch_function($(this),'GoodsMovementItems',1,1);
        }
      });
      $('#close_show_operation').unbind().click(function(){ 
      $(".chk_box_main").prop('checked', false);
      $(".chk_boxes1").prop('checked', false);
      close_tabs();
      });
      $('.back_button_cancel').unbind().click( function(){ 
      $(".chk_box_main").prop('checked', false);
      $(".chk_boxes1").prop('checked', false);
      close_tabs();
      });
      //select all checkboxes
      $(".chk_box_main").change(function(){  //"select all" change 
          $(".chk_boxes1").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
           if( $(this).prop("checked")==true){
            // alert();
          if(!$('#save_button_show').is(':visible')){

            $("#show_operation").slideDown(500);
             $("#header_details").hide();
          $("#goods_heading").hide();
          $("#goods_recept_history").hide();
          }
         
          }else{
            close_tabs();
          }  
      });

      //".checkbox" change 
      $('.chk_boxes1').change(function(){
    //uncheck "select all", if one of the listed checkbox item is unchecked
          if(false == $(this).prop("checked")){ //if this item is unchecked
            $(".chk_box_main").prop('checked', false); //change "select all" checked status to false
           
         }else{
            if(!$('#save_button_show').is(':visible')){
              // alert();
              $("#show_operation").slideDown(500);
               $("#header_details").hide();
             $(".show_vendor_data").hide();
             $("#goods_heading").hide();
             $("#goods_recept_history").hide();
            }
           
         }
    //check "select all" if all checkbox items are checked
          if ($('.chk_boxes1:checked').length == $('.chk_boxes1').length ){
            // alert('2')
              $(".chk_box_main").prop('checked', true);
          }
          if ($('.chk_boxes1:not(:checked)').length == $('.chk_boxes1').length ){
            close_tabs()
            // $("table tr th:nth-child(5), table tr td:nth-child(5)").hide();
          }
      });
       $('.overlay-back').unbind().click(function(){
         $('.batch_row').slideUp();
         $('.asset_row').slideUp();
       });
  
});




 var form_submit=false;
 function submitFormPDF(){
  if(!form_submit){
       form_submit=true;
     

var url=$('#purchase_document_form').attr('action');
var post_type=$("#post_type").val();
if(post_type=='2'){
  url = '<?php echo Yii::$app->request->baseUrl.'/index.php?r=purchase-document-flow/transfer' ?>'
}
      setTimeout(function() {
      //event.preventDefault();
        $.ajax({
          url:url,
          type: 'post',
          dataType:'json',
          data:$("#purchase_document_form").serialize(),
          beforeSend: function(){
            $(".overlay").show();
          },
          complete: function(){
            $(".overlay").hide();
          },
          success: function (data) {
            //console.log(data);
           // alert(data);
         $('.form-control').removeClass("errors_color");
        var html="";
        var cleaned = removeDuplicates(data['errors']);
        for(var key in data['errors']){       
          $('#'+key).addClass("errors_color");                 
        }
        for(var key in cleaned){     
          html+=key+"<br>";
        }
        $("html, body").animate({ scrollTop: 0 }, "slow");
        if(data['error_message']){
          html+=data['error_message'];
        }
        if(html!=''){
           form_submit=false;
          $(".error-summary").show();
          $("#error_display").html(html);
        }else{
          $(".error-summary").hide();
          var url="<?php echo Yii::$app->request->baseUrl.'/index.php?r='?>"+ data['url'];
         window.location.href=url;              
        }
          },
          error: function(jqXhr, textStatus, errorThrown ){
                   form_submit=false;
                    if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS' ?>");
                        }
               
    }
  });
    },1000);
   }
 }

function removeDuplicates(json_all) {
  var arr = [];   
  $.each(json_all, function (index, value) 
  {        
    arr[value]=(value);        
  });
    return arr;
  }

function view_dochistory(){
  var po_number = '<?= $po_number ?>';
  var order_type ='<?= $po_header->ORDER_TYPE ?>'
  $.ajax({
          url:"<?php echo \Yii::$app->getUrlManager()->createUrl('purchase-document-flow/prbilling-history') ?>",
          dataType: 'html',
          type: 'get',
          data:{
           po_number:po_number,
           order_type:order_type,
          },
          success: function( data, textStatus, jQxhr ){
            // console.log(data);
            // alert(data);
              $('.sidebar-modal .tab-content').html(data);
              $(".sidebar-modal").show('slide');
              $(".overlay-back").show(); 
             },
              error: function( jqXhr, textStatus, errorThrown ){
              // alert('error');
              //console.log( errorThrown );
               if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS' ?>");
                        }
               }
              
        });
}
 function show_asset_data(id_pass,flag=0){
  $('#purchase_search').hide();
   var n = id_pass.lastIndexOf('-');
   var asset_no=$("#"+id_pass.substring(0,n+1)+'asset_no').val();
   var url =PATH+'asset-master/asset-details';
   $.ajax({
    url:url,
    dataType: 'html',
    type: 'post',
    data:{       
      asset_no:asset_no,
      id_pass:id_pass,
      flag:flag,
    },
    success: function( data, textStatus, jQxhr ){
        // $('.batch_row').hide();
        $('.overlay-back').hide();
        $('#pModal_search').modal('show');
        $('#modalContent_search').html(data);
    },
    error: function( jqXhr, textStatus, errorThrown ){
      alert(errorThrown);
          //console.log( errorThrown );
        }
      });
 }
function gotochangeasset(id_pass){
    var n = id_pass.lastIndexOf('-');
    var asset_no=$("#"+id_pass.substring(0,n+1)+'asset_no').val();
    var data=$("#"+id_pass).parent().next('.asset_row').slideDown();
  //  alert(data);
   append_asset_data("#"+id_pass,asset_no);
 }
 function append_asset_data(id_pass,asset_no){
  saved_flag=true;
   var numbers = id_pass.match(/[0-9]+/g);
   var n = id_pass.lastIndexOf('-'); 
   var asset_category=$(id_pass.substring(0,n+1)+'asset_category').val();
   var url =PATH+'purchase-order-header/get-asset-details';
   $.ajax({
    url:url,
    dataType: 'html',
    type: 'post',
    data:{       
      asset_no:asset_no,     
      numbers:numbers,     
      asset_category:asset_category,     
      id_pass:id_pass,     
      asset_model_flag:'GoodsMovementItems',     
    },
    success: function(data, textStatus, jQxhr ){
      var details = id_pass.substring(0,n+1)+'asset_details';     
      $('.overlay-back').show();           
      $(details).html(data);    
    },
    error: function( jqXhr, textStatus, errorThrown ){
      alert(errorThrown);
          //console.log( errorThrown );
        }
      });
 }
 function close_asset_row(){
    $('.asset_row').hide();
    $('.overlay-back').hide();
}

</script> 