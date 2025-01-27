<?php

use backend\models\BookingItemSearch;
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

$this->title = "Booking Item";
$label_select='SELECT';
$view_levels=array('DETAIL'=>'Detail View','CATEGORY_DETAIL'=> 'Category Wise','Type_Wise'=>'Type Wise');
?>

<?php

  $form = ActiveForm::begin(['id'=>'bookingitem_report', 'method' => 'post','action' => ['item-wise-report/item-report'],'enableClientValidation'=>false]); ?>

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
                        // 'options' => ['onchange'=>"changeName(this.value)"], //,'onchange'=>"changeName(this.value)"
                         'pluginOptions' => [
                             'allowClear' => true,
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
          'name' => 'BookingItemSearch[from_date]',
          'type' => DatePicker::TYPE_COMPONENT_APPEND,
          'value'=> $model['from_date'],
          'options' => [
          'placeholder' => 'dd-mm-yyyy',
          'class' => 'form-control karthik-datepicker-width-sm',
          'id' => 'bookingitemsearch-from_date',
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
          'name' => 'BookingItemSearch[to_date]',
          'type' => DatePicker::TYPE_COMPONENT_APPEND,
          'value'=> $model['to_date'],
          'options' => [
          'placeholder' => 'dd-mm-yyyy',
          'class' => 'form-control karthik-datepicker-width-sm',
          'id' => 'bookingitemsearch-to_date',
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

  </div>
</div>

<?php ActiveForm::end(); ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

function submitForm(){
    if($("#bookingitemsearch-booking_id").val()==''  ) { //&& $("#bookingitemsearch-reference_key").val()==''
        /*block needs to add for month range report-start */
        //if (active_month_filter) {
            var return_check = checkDateFilter('bookingitemsearch-from_date', 'bookingitemsearch-to_date');
            if (!return_check) {
                return false;
            }
      //  }/*end of block*/
    }

  var formElements = {};
  //var action = $('#bookingitemsearch-view_level').val();
  $('#bookingitem_report select').each(function(){
    if($(this).val()!=''){
          formElements[$(this).attr('name')] = $(this).val();
    }
     // console.log(formElements);
  });
    // $('input:text[name="bookingitemsearch[status_search]"]').val(JSON.stringify(formElements));

       var POSTING_DATE_FROM;
  var POSTING_DATE_TO;

  if($('#bookingitemsearch-from_date').val()!=''){
    POSTING_DATE_FROM=$('#bookingitemsearch-from_date').val();
     POSTING_DATE_FROM = POSTING_DATE_FROM.replace(/-/g,'/')
    var match = /(\d+)\/(\d+)\/(\d+)/.exec(POSTING_DATE_FROM)
    POSTING_DATE_FROM = new Date(match[3], match[2], match[1]);
  }else{
    POSTING_DATE_FROM='';
  }
  if($('#bookingitemsearch-to_date').val()!=''){
    POSTING_DATE_TO=$('#bookingitemsearch-to_date').val();
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
    $('#bookingitem_report').submit();
  }
}
/*  $(document).ready(function () {
    $('#back_button').click(function(){
       window.location.href ='<?php //echo Yii::$app->request->baseUrl."/index.php?r=report/index"?>'

      });
}); */
/* function addmaterialsubgroup(val,id){
  if(val!=''){
    $('#bookingitemsearch-material_sub_category').val('').trigger('change');
      var grp_id = $('#bookingitemsearch-material_group').val();

      $.ajax({
        url: '<?php //echo Yii::$app->request->baseUrl.'/index.php?r=sales-material-group-report/sub-category-list' ?>',
        type: 'post',
        data:{
          temp_material_grp_id:grp_id,
          temp_material_subgrp_id:val,
        },
        success: function (data) {
          $('#bookingitemsearch-material_sub_category').html(data);
        },
        error: function( jqXhr, textStatus, errorThrown ){
          if(errorThrown=='Forbidden'){
            alert(you_dont_have_accsess_label);
          }
        }
      });
    }
  }*/
/*  function changeName(_view_name) {
    // body...
    if(_view_name=='DETAIL'){
      $("#date_lbl").html("Pick Date");
    }else{
      $("#date_lbl").html("Booking Date");
    }
  }*/
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