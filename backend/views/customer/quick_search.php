<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;



$label_select = 'SELECT';
$temp_add['Add New']=' + ADD_NEW';

?>


<style type="text/css">
#date_popup,#date_popup1{
    z-index: 99999 !important;
}
.input-group-lg > .input-group-btn > .btn {
  font-size:14px;
  height:30px;
  padding:5px 10px;
  margin-bottom: 10px;
}
</style>

<div class="row" style="margin-top:5px !important">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

   <div class="pull-left temp_change_company_customer" style="width:auto;padding:0px 15px 0px 15px;cursor: pointer;margin-top: -2px;float: left;max-width: 50%;overflow: hidden;display: inline-block;"><h4 class="ellipsis"><span style="font-weight: 550;color:#333">
    <?php 
      
        echo "CUSTOMER SEARCH";
     
     ?></span></h4></div>

          <div class="btn-toolbar kv-grid-toolbar pull-right" role="toolbar" style="margin: 5px 20px 0px 0px;">
          <span class="glyphicon glyphicon-remove slider-close" style="margin:7px 0px 10px 10px;cursor:pointer;color: #000000" onclick="slider_close()"></span>
        </div>
  </div>

</div>
<hr class="top-hr"> 
<div >

  <?php $form = ActiveForm::begin([
    'action' => ['customer-search'],
      'id' => 'customer_search_page_form',
    'method' => 'post',
  ]); ?>

  <div class="row" style="margin-top:0px !important">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      <div class="row right_section">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
         <div class="form-group cust-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">NAME</label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">             
              <?= $form->field($searchModel, 'name')->textInput(['maxlength' => true,'onkeyup'=>"customerchange(this.value,this.id)"])->label(false);?>
             
            <div id='customer_autodata' style="background-color:black">
                                                           
            </div>
             
            </div>
          </div>
        </div>
         <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
         <?= Html::Button('SEARCH', ['class' => 'btn btn-primary submit_page','onclick'=>'search_tested()']) ?>
       </div>
      </div><hr class="extend-hr" style="margin-left: -15px;margin-right: -15px;">
          <div class="row right_section">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group cust-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">MOBILE_NO</label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <?= $form->field($searchModel, 'contact_nos')->textInput(['maxlength' => true])->label(false)?>
           
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="row right_section">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <div class="form-group cust-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label"><?php //echo $model->attributelabels()['EMAIL']?></label>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <?php // $form->field($searchModel, 'EMAIL_SEARCH')->textInput(['maxlength' => true])->label(false);?>
            </div>
          </div>
        </div>
      </div>
       -->
     
   
         
    </div>
  </div>
  <?php ActiveForm::end(); ?>
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="table" style="margin-top:1%;">                                  
                             <div class="box-body">
                            <table class="table table-bordered table-hover sales-table">
                                <thead>
                                  <th>#</th>
                            <!--     <th><?php /* switch($searchModel->BUSINESS_PARTNER_TYPE){
                                  case 'C':
                                    echo $model_labels->attributelabels()['CUSTOMER_NO'];
                                  break;
                                  case 'V':
                                    echo $model_labels->attributelabels()['VENDOR_NO'];
                                  break;
                                  case 'O':
                                    echo $model_labels->attributelabels()['BENEFICIARY_NO'];
                                  break;
                                } */ ?></th>  -->                            
                                <th><?= 'NAME';?></th>
                                <th><?= 'MOBILE_NO';?></th>
                                <th><?= 'EMAIL';?></th>
                               
                              
                              </thead>
                              <tbody>
                                <tr><td colspan="6"><?= 'NO_DATA_FOUND' ?></td></tr>
                              </tbody>
                           </table>
                         </div>
                        </div>
                        </div> 

</div>

<!-- <script type="text/javascript">
   $(document).ready(function () {  
    
   $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b><?php //echo Yii::t('yii','Advance Search')?></b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");
   $('#errors_test').hide();

   //$('.daterangepicker .ranges ul li').click(function(event) {

    }); 
   $('#purchase_search').click(function() {
   $(".submit_page").click();
    });
   
    

function searchpurchaseord() {  
   $(".submit_page").click();
}

function resetpopup(){
 window.location.href = "<?php //echo Yii::$app->request->baseUrl.'/index.php?r=customer/index' ?>";
}
</script> -->


<!-- End Search Form -->
<script type="text/javascript">
  // function search_tested(){
   
  //   $.ajax({
  //   url: '<?php //echo Yii::$app->request->baseUrl.'/index.php?r=sales-header/customer-search' ?>',
  //   type: 'post',
  //   data:$("#customer_search_page_form").serialize(),
  //     success: function (data) {
  //       //alert(data);

  //       if(data==''){
  //         alert("Please provide some input for searching!");
  //       }else{
  //     // console.log(data);
  //       $('#table').html(data);
  //   }

  //     }
  //   });
  //   return false;
  // }
   function customerchange(val, id_pass,flag=0){
        saved_flag=true;
        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('booking/customer-autocomplete') ?>",
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
                 data_new+= '<li style="color: #337AB7; font-weight: bold !important;" onClick="add_new_customer()">+ New Customer </li>';

                for(i=0; i<data['customer_data'].length; i++) {
                    data_new += '<li onClick="showView(\''+data['customer_data'][i]['id']+'\',\''+data['customer_data'][i]['name']+'\','+flag+')">'+data['customer_data'][i]['name']+'</li>';
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
 function country_change(val){
   //alert(val);
    var id=val;

     $.ajax({
                url:"<?php echo \Yii::$app->getUrlManager()->createUrl('customer-master/country-change') ?>",
                dataType: 'html',
                type: 'post',
                data:{
                  cust_type:val,
                },
                success: function( data, textStatus, jQxhr ){
                 //alert(data);
                // vat_hide(val);
                 var result = '#addresssale-country';
                 $(result).html( data );
                 var countryValue = $('#addresssale-country').val();
                 $("#addresssale-customer_type").val(val);
                 $('#customermaster-country').val(countryValue);
                 changeEmirate();
                },
                error: function( jqXhr, textStatus, errorThrown ){

                  alert(errorThrown);
                    console.log( errorThrown );
                }
            });
  }

  function changeEmirate(){
    var countryValue = $('#addresssale-country').val();
    if(countryValue == 'AE'){
      $('#emirate_view').show();
    }else{
      $('#emirate_view').hide();
    }
  }

  function backtoSearchPage(){
    $('#err_tested_cust').hide();
    $("#sales-header-create").hide();
    
    $("#customer-searching-form").show();
  }

  function createcustomer(){
    $("#customer-searching-form").hide();
   
    $("#sales-header-create").show();
  }

   
     function close_alert(){
        $('#err_tested_cust').hide();
     }
  function customer_testedCheck(){
    $.ajax({
    url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=tested/customer-search-first'?>',
    type: 'post',
    dataType:'json',
    data:$("#tested_customer_create").serialize(),
      success: function (data) {
    //     console.log(data);
  
         $('#err_tested_cust').show();
         var html='';
         
         if(data['customermaster-customer_type']){html+=data['customermaster-customer_type']+"<br>"};
    if(data['addresssale-f_name']){html+=data['addresssale-f_name']+"<br>"};
        if(data['addressarray-f_name']){html+=data['addressarray-f_name']+"<br>"};
         if(data['addresssale-mobile_number']){html+=data['addresssale-mobile_number']+"<br>"};
         if(data['addresssale-country']){html+=data['addresssale-country']+"<br>"};
        if(data['customermaster-emirate']){html+=data['customermaster-emirate']+"<br>"};
        if(data['customermaster-id_type']){html+=data['customermaster-id_type']+"<br>"};
         if(data['customermaster-id']){html+=data['customermaster-id']+"<br>"};
       $("#errors_tested_customer").html(html);
       if(html==''){ 

        $('#pModal').modal('hide');      
       
        send_vendor(data); // customer no send after customer create
       }
      }
    });
    return false;
  }

  function slider_close() {
    $(".sidebar-modal").hide('slide');
    $(".overlay-back").hide();
  }
</script>

