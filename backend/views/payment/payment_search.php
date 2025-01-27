<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\CHtml;
use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use backend\models\BillingItem;

$this->title = "Payment";
$label_select='SELECT';
$view_levels=array('DETAIL'=>'Detail View','CASH_FLOW'=>'Daily Summary','OVERVIEW'=>'Detail OverView');
?>

<?php
  
  $form = ActiveForm::begin(['id'=>'payment_report', 'method' => 'post','action' => ['payment/payment-report'],'enableClientValidation'=>false]); ?>

<div class="row page-header no-status-page-header">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
       <!-- <img src="img/icons/back-arrow.png" style="height:16px;cursor:pointer;margin-top:11px" id="back_button" class="back-redirect-for-button"> -->
    </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: center;"><h4><b><?php echo $this->title; ?></b></h4></div>
      </div>
</div>

 



<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <div class="row">
       <div class="col-lg-12">
           <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
               
                   <div class="form-group cust-group">
                       <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label"> View </label>
                       <span class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                     <?php
                        echo $form->field($model, 'view_level')->widget(Select2::classname(), [
                         'data' => $view_levels,
                         'options' => ['onchange'=>"changeName(this.value)"], //,'onchange'=>"changeName(this.value)"
                         'pluginOptions' => [
                             'allowClear' => false,
                             //'dropdownParent' => new yii\web\JsExpression('$("#pModal")'),
                         ],
                     ])->label(false); ?>
                    </span>
                   
               </div>
           </div>
       </div> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
        
          <div class="form-group cust-group">
        <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label" id="date_lbl"> Pickup From </label>
        <span class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
        <?php 
         echo DatePicker::widget([
          'name' => 'PaymentMasterSearch[from_date]',
          'type' => DatePicker::TYPE_COMPONENT_APPEND,
          'value'=> $model['from_date'],
          'options' => [
          'placeholder' => 'dd-mm-yyyy',
          'class' => 'form-control karthik-datepicker-width-sm',
          'id' => 'paymentmastersearch-from_date',
          'autocomplete'=>'off',
          ],
          'pluginOptions' => [
          'autoclose'=>true,
          'todayHighlight'=>true,
          'format' => 'dd-mm-yyyy'
          ]
          ]);

         /* echo  $form->field($model,'from_date')
            ->label(false)
            ->widget('kartik\date\DatePicker', [
              'options' => [
                'placeholder' => 'DD-MM-YYYY',
                'autocomplete'=>'off',
              ],
              'pluginOptions' => [
              'format'         => 'dd-mm-yyyy',
              'todayHighlight' => true,
              'clearButton'    => false,
              'autoclose'=>true,
          ]])*/;   
        ?>
        </span> 
        </div>
       
      </div>
      <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
        
                                   
                           <div class="form-group cust-group">
        <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label"> To</label>
        <span class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
        <?php  
           echo DatePicker::widget([
          'name' => 'PaymentMasterSearch[to_date]',
          'type' => DatePicker::TYPE_COMPONENT_APPEND,
          'value'=> $model['to_date'],
          'options' => [
          'placeholder' => 'dd-mm-yyyy',
          'class' => 'form-control karthik-datepicker-width-sm',
          'id' => 'paymentmastersearch-to_date',
          'autocomplete'=>'off',
          ],
          'pluginOptions' => [
          'autoclose'=>true,
          'todayHighlight'=>true,
          'format' => 'dd-mm-yyyy'
          ]
          ]);   
        ?>
        </span> 
        </div>
        </div>    
      
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 report-submit">
          <button type="button" onclick="submitForm()" class="btn btn-primary" data-toggle ="tooltip" title=<?= 'SUBMIT'?>> <?= 'SUBMIT' ?></button>
      </div> 
    </div>
  </div>
    <div class="row">

     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="booking_id" style="margin-top: 15px;">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            
                                   
                           <div class="form-group cust-group">
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"> <?= 'Booking Id' ?></label>
        <span class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
          <?php echo $form->field($model, 'booking_id')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=> $model->attributeLabels()['booking_id'],'autocomplete'=>"off"])->label(false);
          ?>
           <div id='billing_autodata' style="background-color:black"></div> 
        </span>
        </div>
         
      </div>      
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="payment_status">
      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
       
          <div class="form-group cust-group">
            <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"> Payment Type </label>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php  echo $form->field($model, 'type')->checkboxList($array_payment_status,['separator'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp",'class'=>'deposite_applicable_class check','data-checkbox'=>"icheckbox_square-red"])->label(false);?>
            </div>  
            </div>
                   
        </div>
      </div>

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="payment_mode">
      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
       
          <div class="form-group cust-group">
            <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"> Payment Mode </label>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php  echo $form->field($model, 'mode_of_payment')->checkboxList($array_payment_mode,['separator'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp",'class'=>'deposite_applicable_class check','data-checkbox'=>"icheckbox_square-red"])->label(false);?>
            </div>  
            </div>
                   
        </div>
      </div>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="billing_type">
           <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
             
                                   
                           <div class="form-group cust-group">
        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"> Customer </label>
        <span class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
          <?php 
                echo $form->field($model, 'search_cust')->widget(Select2::classname(), [
                'data' => $customer_master,
                'options' => ['prompt' => $label_select.' Customer ','class'=>'form-control txt'],
                'pluginOptions' => [
                'allowClear' => false
                ],
            ])->label(false);?>
           </span>  
           </div>
           </div>  
      
    </div>
  </div>

 

 
   
  </div>
</div>

<?php ActiveForm::end(); ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
  
function submitForm(){
    if($("#paymentmastersearch-booking_id").val()==''  ) { //&& $("#paymentmastersearch-reference_key").val()==''
        /*block needs to add for month range report-start */
        //if (active_month_filter) {
            var return_check = checkDateFilter('paymentmastersearch-from_date', 'paymentmastersearch-to_date');
            if (!return_check) {
                return false;
            }
      //  }/*end of block*/
    }

  var formElements = {};
  //var action = $('#paymentmastersearch-view_level').val();
  $('#payment_report select').each(function(){
    if($(this).val()!=''){
          formElements[$(this).attr('name')] = $(this).val();
    }
     // console.log(formElements);       
  });
    // $('input:text[name="PaymentMasterSearch[status_search]"]').val(JSON.stringify(formElements));

       var POSTING_DATE_FROM;
  var POSTING_DATE_TO;

  if($('#paymentmastersearch-from_date').val()!=''){
    POSTING_DATE_FROM=$('#paymentmastersearch-from_date').val();    
     POSTING_DATE_FROM = POSTING_DATE_FROM.replace(/-/g,'/')
    var match = /(\d+)\/(\d+)\/(\d+)/.exec(POSTING_DATE_FROM)
    POSTING_DATE_FROM = new Date(match[3], match[2], match[1]);
  }else{
    POSTING_DATE_FROM='';
  }
  if($('#paymentmastersearch-to_date').val()!=''){
    POSTING_DATE_TO=$('#paymentmastersearch-to_date').val();    
    POSTING_DATE_TO = POSTING_DATE_TO.replace(/-/g,'/')
    var match = /(\d+)\/(\d+)\/(\d+)/.exec(POSTING_DATE_TO)
    POSTING_DATE_TO = new Date(match[3], match[2], match[1]);    

  }else{
    POSTING_DATE_TO='';
  }


 

 if((POSTING_DATE_FROM!='' && POSTING_DATE_TO!='') && (POSTING_DATE_FROM>POSTING_DATE_TO || POSTING_DATE_FROM=='' && POSTING_DATE_TO!='')){
    alert('Please select valid pickup date');
  }else{
    $(".overlay").show();
    $('#payment_report').submit();
  }
}
/*  $(document).ready(function () {
    $('#back_button').click(function(){
       window.location.href ='<?php //echo Yii::$app->request->baseUrl."/index.php?r=report/index"?>'
      
      });
}); */
/* function addmaterialsubgroup(val,id){
  if(val!=''){
    $('#paymentmastersearch-material_sub_category').val('').trigger('change');
      var grp_id = $('#paymentmastersearch-material_group').val();
      
      $.ajax({
        url: '<?php //echo Yii::$app->request->baseUrl.'/index.php?r=sales-material-group-report/sub-category-list' ?>',
        type: 'post',
        data:{
          temp_material_grp_id:grp_id,
          temp_material_subgrp_id:val,
        },
        success: function (data) {
          $('#paymentmastersearch-material_sub_category').html(data);       
        },
        error: function( jqXhr, textStatus, errorThrown ){
          if(errorThrown=='Forbidden'){
            alert(you_dont_have_accsess_label);
          }
        }
      });     
    }
  }*/
  function changeName(_view_name) {
    // body...
    if(_view_name=='DETAIL'){
      $("#date_lbl").html("Pick Date");
    }else{
      $("#date_lbl").html("Payment Date");
    }
  }
   function checkDateFilter(from_date_id,to_date_id,days=30){
      var POSTING_DATE_FROM;
      var POSTING_DATE_TO;
      if($('#'+from_date_id).val()!=''){
          POSTING_DATE_FROM=$('#'+from_date_id).val();
          POSTING_DATE_FROM = POSTING_DATE_FROM.replace(/-/g,'/')
          var match = /(\d+)\/(\d+)\/(\d+)/.exec(POSTING_DATE_FROM)
          POSTING_DATE_FROM = new Date(match[3], match[2], match[1]);
      }else{
          POSTING_DATE_FROM='';
          swal("<?php echo Yii::t('yii', 'Please Select From & To Date');?>");
          return false;
      }

      if($('#'+to_date_id).val()!=''){
          POSTING_DATE_TO=$('#'+to_date_id).val();
          POSTING_DATE_TO = POSTING_DATE_TO.replace(/-/g,'/')
          var match = /(\d+)\/(\d+)\/(\d+)/.exec(POSTING_DATE_TO)
          POSTING_DATE_TO = new Date(match[3], match[2], match[1]);
      }else{
          POSTING_DATE_TO='';
          swal("<?php echo Yii::t('yii', 'Please Select From & To Date');?>");
          return false;
      }

      if(POSTING_DATE_FROM!='' && POSTING_DATE_TO!='' && POSTING_DATE_FROM>POSTING_DATE_TO || POSTING_DATE_FROM=='' && POSTING_DATE_TO!=''){
          swal("<?php echo Yii::t('yii','Enter valid Date range')?>");
      }else{
          const diffTime = Math.abs(POSTING_DATE_TO - POSTING_DATE_FROM);
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
          /*if(diffDays>days){
              swal("<?php // echo Yii::t('yii', 'Report will display only for one month');?>");
              return false;
          }else{*/
              return true;
         // }
      }
  }

</script>