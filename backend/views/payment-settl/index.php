<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\widgets\DateTimePicker;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerPayment */
/* @var $form yii\widgets\ActiveForm */
$active_cust_div =  '';
$mobile_no = '';
$email_id = '';
$tax_treatment = '';
$tax_treatment_data = '';
$place_of_supply = '';
$trn = '';
$cust_name = '';
$flag_disting = 2;
$active_div =  '';

$table_display =  "display:block" ;
/*if (isset($_GET['order_number']) || ($model->SALES_ORDER_NO != "")) {
  ($model->PAYMENT_CATEGORY == 'DOWNPAY') ? ($model->down_request == 1) : '';
  ($sales_header != null) ? $model->CUSTOMER_NO = $sales_header->customer_no : '';
  ($sales_header != null) ? $model->customer_name = $sales_header->businessPartner->NAME : '';
  ($sales_header != null) ? $business_partner_model = $sales_header->businessPartner : '';
  ($sales_header != null) ? $model->SALES_ORDER_NO = $sales_header->order_number : '';
  $mobile_no = (isset($sales_header['CASH_CUST_MOBILE']) ? $sales_header['CASH_CUST_MOBILE'] : '');
  $email_id = (isset($sales_header['CASH_CUST_EMAIL']) ? $sales_header['CASH_CUST_EMAIL'] : '');
  $tax_treatment = (isset($sales_header->taxTreatment->DESCRIPTION) ? $sales_header->taxTreatment->DESCRIPTION : '');
  $tax_treatment_data = (isset($sales_header->taxTreatment->TAX_TREATMENT) ? $sales_header->taxTreatment->TAX_TREATMENT : '');
  $place_of_supply = isset($sales_header['PLACE_OF_SUPPLY']) ? $sales_header->PLACE_OF_SUPPLY : '';
  $trn = isset($sales_header->TRN) ? $sales_header->TRN : '';
  $cust_name = isset($sales_header['CASH_CUST_NAME']) ? $sales_header->CASH_CUST_NAME : '';
  $flag_disting = 0;
  $active_div = '';
}*/


// print_r($model->SALES_ORDER_NO);die;

$precision = 2;
$flag_script = 1;
?>

<style type="text/css">
    .barcode_auto {
        width: 625px;
        margin-top: -5px;
    }

    #customerpayment-paid_received_ind input[type="radio"] {
        position: absolute;
        margin-left: -20px;
        width: 12px;
        height: 12px;
    }

    #customerpayment-paid_received_ind label {
        font-size: 11px !important;
        font-weight: inherit !important;
        margin-top: 10px;
        margin-left: 27px;
    }

    .field-vendorpayment-paid_received_ind {
      margin: 0px !important;
    }

    #pModal_check .modal-dialog {
        width:90%;
        max-height: 500px;
        overflow: auto
    }

    input[readonly], input[readonly="readonly"], input[disabled], select[disabled] {
        cursor: not-allowed;
        background: transparent !important;
    }

    .control-label {
        margin-top: 9px !important;
    }

    .content-wrapper {
        min-height: 100vh !important;
    }
    @media only screen and (min-width: 992px) {
      .extra_div {display: none;}
      .show-hide {
        display: none;
      }
    }
    @media only screen and (max-width: 992px) {
      .show-hide, #right_arrow_img, #down_arrow_img.toggle {
        display: inline-block;
      }
      .information,#down_arrow_img, #right_arrow_img.toggle {
        display: none;
      }
      .information.toggle {
        display: block;
      }

    }

</style>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="error-summary error-summary-main" id="errors_test1" style="display: none;"><p><i
          class="fa fa-close pull-right" onclick="$(&quot;.error-summary-main&quot;).hide()"></i><h5><b><i
            class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b>
      </h5></p>
      <hr class="custom_error_hr">
      <div id="error_display_main" class="custom_error"></div>
    </div>
  </div>
</div>
<div class="customer-payment-form">
  <?php // $readonly_chng = ($model->CUSTOMER_NO != '') ? true : false;
  $readonly_chng = false;
  $form = ActiveForm::begin(['id' => 'customer_payment_form']);

  $count_billing = $count_payment = 0;
  ?>
  <div class="row hide_show_packing_header">

    <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="col-lg-8 col-md-8 col-sm-11 col-xs-11">
        <?php if ($flag_script == 1) { ?>

          <div class="panel panel-default">
            <div class="panel-body" style="padding:5px 5px 5px 5px">
              <div class="row" style="margin-top: 0px !important;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="pull-left temp_change_company"
                       style="width:auto;padding:0px 0px 0px 15px;cursor: pointer;margin-top: -2px;margin-bottom:-10px;max-width: 50%;overflow: hidden;display: inline-block;">
                    <h4 class="ellipsis"><span style="font-weight: 550;color:#333;font-size:14px"><b
                          id="cust_details"><?= ($model->customer_id != '') ? ($business_partner_model->name) : "SELECT_CUSTOMER" ?></b></span>
                    </h4>
                  </div>
                  <div class="pull-left temp_change_company"
                       style="padding:5px 15px 0px 0px;cursor: pointer;">   <?php /*= $readonly_chng ? 'display: none' : ''; */?>
                    <i class="  glyphicon glyphicon-menu-down"
                       style="font-size: 11px;padding:5px;"></i><img
                      src="img/icons/grey_triangle.png"
                      style="position: absolute;margin:12px 0  0 -26px;" class="arrow-img">
                  </div>
                      <div class="btn-group pull-right btn-info cust_icon" onclick="veiwpopup()"
                       style="margin-left: 5px;<?= ($active_cust_div == '') ? $active_div : ''; ?>"><a
                      style="padding: 2px" class="btn" data-toggle="tooltip"
                      data-placement="bottom"
                      title=<?= 'VIEW'; ?> style=""><img
                        src="img/icons/360-degr.png" style="height: 1.2%;"></a></div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="search_customer">
                <input type="text" id="auto_search_customer_vw"
                       placeholder="<?= 'SEARCH_CUSTOMER'; ?>"
                       onkeyup="customerchange(this.value,this.id)" autocomplete="off">
                <div class="btn-group" onclick="advance_search_sider('C')"><a class="btn btn-info"
                                                                              style="padding:4px 7px 3px 7px"
                                                                              data-toggle="tooltip"
                                                                              data-placement="bottom"
                                                                              title=<?= 'SEARCH'; ?> style=""><i
                      class="glyphicon glyphicon-search fa-white"></i></a></div>
                <div id='customer_autodata' style="background-color:black"></div>
              </div>
              <div class="row customer_active_tab"
                   style="margin:0px 0px 0px 0px !important;<?= ($active_cust_div == '') ? $active_div : ''; ?>">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="customer_sales">
                  <div class="row other_customer_editable">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <table class="table">
                        <tr>
                          <td id="mob_no"
                              class="cust_non_editable"><?php echo '<i class="fa fa-phone fa-fw"></i> ' . $mobile_no; ?></td>
                        </tr>
                        <tr>
                          <td id="email"
                              class="cust_non_editable"><?php echo '<i class="fa fa-envelope fa-fw"></i> ' . $email_id; ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                      <?php
                      /*$model->CUST_NAME = $cust_name;
                      $model->CUST_MOBILE = $mobile_no;
                      $model->CUST_EMAIL = $email_id;
                      $model->TAX_TREATMENT = $tax_treatment_data;
                      $model->TRN = $trn;
                      $model->PLACE_OF_SUPPLY = $place_of_supply;
                      echo $form->field($model, 'CUST_NAME')->hiddenInput()->label(false);
                      echo $form->field($model, 'TRN')->hiddenInput()->label(false);
                      echo $form->field($model, 'PLACE_OF_SUPPLY')->hiddenInput()->label(false);
                      echo $form->field($model, 'TAX_TREATMENT')->hiddenInput()->label(false);
                      echo $form->field($model, 'CUST_EMAIL')->hiddenInput()->label(false);
                      echo $form->field($model, 'CUST_MOBILE')->hiddenInput()->label(false);
                      $model->flag_distinguish = $flag_disting;
                      $model->return_flag = $return_flag;
                      $model->CUST_NAME = $cust_name; //for setting that data when comes from sales order
                      $model->CUST_MOBILE = $mobile_no;
                      $model->CUST_EMAIL = $email_id;
                      $model->TAX_TREATMENT = $tax_treatment_data;
                      $model->TRN = $trn;
                      $model->PLACE_OF_SUPPLY = $place_of_supply;*/

                      /*echo $form->field($model, 'flag_distinguish')->hiddenInput()->label(false);
                      echo $form->field($model, 'return_flag')->hiddenInput()->label(false);*/ ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }  ?>

      </div>
    </div>

    <?php echo $form->field($model, 'customer_id')->hiddenInput([' ' => true, 'class' => 'form-control text_first', 'placeholder' => 'CUSTOMER_NO'])->label(false);
   // echo $form->field($model, 'customer_name')->hiddenInput(['maxlength' => true, 'class' => 'form-control text_first', 'placeholder' => 'ENTER_CUSTOMER_NAME'], 'style' => 'cursor:pointer;height:34px', 'readonly' => $readonly_chng])->label(false); ?>

  </div>
  <hr style="margin:0px !important" class="div-hr">
  <?php
 $list = array('PAID' => 'amount_paid', 'RECEIVED' => 'amount_received'); ?>
  <div class="row" style="margin-top:0px !important;padding-bottom:0px !important">
    <div class="col-lg-12">
      <div>
        <div class="panel-body" style="padding-top:0px !important;padding-bottom:0px !important">
          <div class="tab-content">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

              <div class="row right_section">
                <div class="form-group cust-group">
                  <label class="col-lg-2 col-md-2 col-sm-4 col-xs-4 control-label"
                         style=""><?= 'PAYMENT_DATE' ?></label>
                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <?php //$model['PAYMENT_DATE'] = ($model['PAYMENT_DATE'] != '') ? Yii::$app->formatter->asDate($model['PAYMENT_DATE'], $_COOKIE['dateFormat']) : date('d-m-Y');
                    echo DatePicker::widget([
                      'name' => 'PaymentMaster[date]',
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      //'value' => $model['PAYMENT_DATE'],
                      'options' => [
                        'placeholder' => 'dd-mm-yyyy',
                        'class' => 'form-control karthik-datepicker-width-sm',
                        /*'value' => function ($model, $key, $index, $grid) {
                          return Yii::$app->formatter->asDate($model['PAYMENT_DATE'], $_COOKIE['dateFormat']);
                        },*/
                      ],
                      'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy',
                        'orientation' => 'bottom',
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
  <!-- <hr class="extend-hr" style="margin-top:14px;">-->
  <div class="row" style="margin-top:0px !important;padding-bottom:0px !important">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div>
        <div class="panel-body" style="padding-top:0px !important;padding-bottom:0px !important">
          <div class="tab-content">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <?php if (true) {   //todo $payment_category == '' ?>
                <div class="row right_section">
                  <div class="form-group cust-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                      <?php //echo $form->field($model, 'PAID_RECEIVED_IND')->radioList($list, ['separator' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp", 'onChange' => 'ChangePaymentMethod(this.value)'])->label(false) ?>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <?php //echo $form->field($model, 'PAID_RECEIVED_IND')->hiddenInput(['placeholder' => $model->attributeLabels()['PAID_RECEIVED_IND']])->label(false) ?>
              <?php }
              $css = '';
            /*  if ($payment_category == 1 || $payment_category == '3') {
                $css = 'display:none;';
              }*/ ?>
              <div class="row right_section" style=<?= $css ?>>

                <?php
                /*if ($payment_category == 2) {    //todo $flag
                  $model->PAYMENT_CATEGORY = "FINAL";
                }
                //$paid_array=[ 'RET' => 'Return Payment'];
                if ($payment_category == '1') {
                  $Received_array = ['Down Payment' => 'DOWNPAY'];
                  $Received_array1 = ['DOWNPAY' => 'Down Payment'];
                  $model->PAYMENT_CATEGORY = "DOWNPAY";
                } else if ($payment_category == '2') {
                  if ($model->SALES_ORDER_NO == '' && $model->JOBCARD_NO == "") {

                    $model->PAYMENT_CATEGORY = "FINAL";
                  }
                  $Received_array = ['Partial Payment' => 'PARTIAL', 'Final Payment' => 'FINAL', 'Multiple Settlement' => 'MULTIPLE_SETTELMENT', 'RET' => 'Return Payment'];
                  $Received_array1 = ['PARTIAL' => 'PARTIAL_PAYMENT', 'FINAL' => 'FINAL_PAYMENT', 'MULTIPLE_SETTELMENT' => 'MULTIPLE_SETTELMENT', 'RET' => 'Return Payment'];

                } else {
                  $model->PAYMENT_CATEGORY = 'RET';
                  $Received_array1 = ['RET' => 'Return Payment'];
                  $Received_array = ['RET' => 'Return Payment'];
                }
                $paid_array = ['Return Payment' => 'RET'];*/
                ?>
                <div class="form-group cust-group">
                  <label
                    class="col-lg-3 col-md-3 col-sm-4 col-xs-4 control-label">  <?= 'PAYMENT_CATEGORY'; ?></label>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <?php /*echo $form->field($model, 'PAYMENT_CATEGORY')->widget(Select2::classname(), [
                      'data' => $Received_array1,
                      'options' => ['onchange' => 'payment_cat(this.value)'],
                      'pluginOptions' => [
                        'allowClear' => false
                      ],
                    ])->label(false);*/
                    ?>
                  </div>

                </div>

              </div>

              <div class="row right_section">
                <div class="form-group cust-group">
                  <label
                    class="col-lg-3 col-md-3 col-sm-4 col-xs-4 control-label"> <?= $payment_model->attributeLabels()['mode_of_payment'] ?></label>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <?php   // payment_method >> mode_of_payment
                    echo $form->field($payment_model, 'mode_of_payment')->widget(Select2::classname(), [
                      'data' => $payment_methods,
                      'options' => ['prompt' => 'SELECT' . ' ' . $payment_model->attributeLabels()['mode_of_payment'], 'onchange' => 'model_check_data(this.value)'],
                      'pluginOptions' => [
                        'allowClear' => false],
                    ])->label(false); ?>
                  </div>
                  <div class="col-sm-4 col-xs-4 extra_div" >&nbsp;</div>

                  <div class="col-sm-4 col-xs-4 extra_div" >&nbsp;</div>



                </div>
              </div>

              <div class="row right_section" id="amount_curr_div">
                <div class="form-group cust-group">
                  <label  class="col-lg-3 col-md-3 col-sm-4 col-xs-4 control-label">  <?= $model->attributeLabels()['AMOUNT'] ?></label>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <?php $model->AMOUNT_TEMP = $model->AMOUNT; ?>
                    <?= $form->field($model, 'AMOUNT_TEMP')->textInput(['placeholder' => $model->attributeLabels()['AMOUNT'], 'onkeyup' => "format_amount(this.id,this.value)", 'onpaste' => "format_amount(this.id,this.value)", 'oncut' => "format_amount(this.id,this.value)", 'readonly' => ($active_cust_div == 1) ? false : $readonly_chng])->label(false); ?>
                    <?= $form->field($model, 'AMOUNT')->hiddenInput(['placeholder' => $model->attributeLabels()['AMOUNT'], 'onchange' => 'calculate()', 'readonly' => ($active_cust_div == 1) ? false : $readonly_chng])->label(false); ?>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="<?= $table_display ?>" id="payment_subtotal">
              <div class="col-lg-12 table-responsive" style="padding:0px;">
                <table class="table-bordered table">
                  <thead>
                  <tr>
                    <th style="width: 40%"></th>
                    <th style="width:30%">Recv(+)</th>
                    <th style="width:30%">Return(-)</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>INVOICE</td>
                    <td  id="invoice_outstanding">  </td>  <!-- todo outstanding-->
                    <td id="invoice_subtotal"></td>
                  </tr>
                  <tr>
                    <td>Payment</td>
                    <td  id="payment_recv">  </td>  <!-- todo outstanding-->
                    <td id="payment_return"></td>
                  </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--<hr class="extend-hr">-->


  <!--<div class="row" style="margin-bottom:150px;">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div id="multiple_settlement_div"></div>
</div>
</div>-->

  <hr style="display: none;" class="final_class">

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
  <div class="row final_class"
       style="position: fixed;bottom: 0;width: 100%;margin-bottom:49px;margin-left:2px;margin-right:3px;display: none;background: #F9F908">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 show-hide" style="margin-left:-15px;">
        <img class="" id="right_arrow_img" src="img/icons/triangle-right-arrow.png" style="height: 15px;" >
        <img class="" id="down_arrow_img" src="img/icons/drop-down-arrow.png" style="height: 15px;" >
        <label style="margin-top:5px;">Payment Summary</label>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 information">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

          <label class="col-lg-8 col-md-8 col-sm-8 col-xs-8 left-align-label" style="font-size: 15px"><?= $model->attributeLabels()['AMOUNT_RECEIVED'] . ' In Loc. Curr.' ?></label>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 amt-field1">
            <?= $form->field($model, 'AMOUNT_RECEIVED')->hiddenInput(['readonly' => true])->label(false) ?>
            <?= $form->field($model, 'AMOUNT_RECEIVED_TEMP')->textInput(['readonly' => true, 'style' => 'font-size: 13px;font-weight:bold'])->label(false) ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

          <label class="col-lg-6 col-md-6 col-sm-8 col-xs-8 left-align-label"
                 style="font-size: 15px"><?php echo $model->attributeLabels()['AMOUNT_APPLIED'].' '.'(LC)' ?></label>
          <?php $model->AMOUNT_APPLIED_TEMP = $model->AMOUNT_APPLIED_TEMP; ?>
          <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 amt-field2" >
            <?= $form->field($model, 'AMOUNT_APPLIED')->hiddenInput(['readonly' => true])->label(false) ?>
            <?= $form->field($model, 'AMOUNT_APPLIED_TEMP')->textInput(['readonly' => true, 'style' => 'font-size: 13px;font-weight:bold'])->label(false) ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >

          <label class="col-lg-4 col-md-4 col-sm-8 col-xs-8 left-align-label amt-label-field3"                 style="font-size: 15px;"><?= $model->attributeLabels()['DIFFERENCE'] ?></label>
          <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 amt-field3">
            <?= $form->field($model, 'DIFFERENCE')->hiddenInput(['readonly' => true])->label(false) ?>
            <?= $form->field($model, 'DIFFERENCE_TEMP')->textInput(['readonly' => true, 'style' => 'font-size: 13px;font-weight:bold'])->label(false) ?>
            <?= $form->field($model, 'total_part_amount')->hiddenInput(['readonly' => true])->label(false) ?>
          </div>
        </div>
        <input type="hidden" id="total_last_local" name='CustomerPayment[AMOUNT_LOC_CURRENCY]'>
        <input type="hidden" id="payment_total_local" name='PAYMENT_TOTAL_LOCAL'>
        <input type="hidden" id="deposit_payment_total_local" name='DEPOSIT_PAYMENT_TOTAL_LOCAL'>
        <input type="hidden" id="journal_total_local" name='JOURNAL_TOTAL_LOCAL'>
        <input type="hidden" id="return_payment_total" value="0">
        <input type="hidden" id="billing_total_main" value="0">
        <input type="hidden" id="credit_total" value="0">
        <input type="hidden" id="total_invoice_outstanding" placeholder="total_invoice_outstanding">
        <input type="hidden" id="total_credit_note_outstanding" placeholder="total_credit_note_outstanding">
        <input type="hidden" id="total_downpayment_outstanding" placeholder="total_downpayment_outstanding">
        <input type="hidden" id="total_deposit_outstanding" placeholder="total_deposit_outstanding">
        <input type="hidden" id="total_jv_outstanding" placeholder="total_jv_outstanding">
        <input type="hidden" id="total_invoice_settlement" placeholder="total_invoice_settlement">
        <input type="hidden" id="total_credit_note_settlement" placeholder="total_credit_note_settlement">
        <input type="hidden" id="total_downpayment_settlement" placeholder="total_downpayment_settlement">
        <input type="hidden" id="total_deposit_settlement" placeholder="total_deposit_settlement">
        <input type="hidden" id="total_jv_settlement" placeholder="total_jv_settlement">
      </div>
    </div>
  </div>

  <?php ActiveForm::end() ?>

  <div class="row" style="position: fixed;bottom: 0;margin-bottom: -20px;width: 100%;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-info" onclick="submitForm()"><img src="img/icons/save.png"
                                                                                 style="height:12px"> <?= 'SAVE' ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var you_dont_have_access_label = "<?= 'YOU_DONT_HAVE_ACCESS';?>";
    var tax_treatment_label = 'TAX_TREATMENT';
    var place_of_supply_label = 'PLACE_OF_SUPPLY';
    var trn_label = 'TRN';
    var billing_add_label = 'BILLING_ADD';
    var delivery_add_label = 'DELIVERY_ADD';
    var amount_check_amount_same_label = 'amount_check_amount_same';
    /*var count_check = "<?php //echo $count; ?>";*/
    var advance_payment_flag =  0 ;

    function test_exc() {
      var value = $("#customerpayment-amount").val();
      changeexchangerate();
      calculate();
    }

    function calc_check() {

    }

    function model_check_data_other(eleId) {

      var index = $("#" + eleId).attr('id').split('-')[1];
      var id = $('#customerpaymentmultpleother-' + index + '-payment_mode').val();
      var gl_Account = ('customerpaymentmultpleother-' + index + '-gl_account');
      $('#customerpaymentmultpleother-' + index + '-gl_account').val("");
      $('#customerpaymentmultpleother-' + index + '-cash_gl').val("");
      //alert("id"+id);
      // alert("index"+index);
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer-payment/payment-mode-details') ?>",
        dataType: 'json',
        type: 'GET',
        //  async:false,
        data: {
          payment_mode: id,
        },
        success: function (data, textStatus, jQxhr) {
          var alternet_number_range_format = data['alternet_number_range_format'];
          if (data['account_data']) {
            var accounts = '<select id="' + id + '" style="border:none;padding-left: 1px;"  name="CustomerPayment[' + index + '][GL_ACCOUNT]" aria-invalid="false">';
            accounts += '<option value="">' + "<?php echo 'SELECT' ?>" + '</option>';

            for (var i = 0; i < data['account_data'].length; i++) {
              if (data['loginLang'] == 'EN') {
                if (alternet_number_range_format == 1) {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['MANUAL_NUMBER'] + ' - ' + data['account_data'][i]['DESCRIPTION'] + "</option>";
                } else {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['GL_NO'] + ' - ' + data['account_data'][i]['DESCRIPTION'] + "</option>";
                }

              } else {
                if (alternet_number_range_format == 1) {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['MANUAL_NUMBER'] + ' - ' + data['account_data'][i]['DESCRIPTION_OTH'] + '(' + data['account_data'][i]['DESCRIPTION_OTH'] + ")</option>";
                } else {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['GL_NO'] + ' - ' + data['account_data'][i]['DESCRIPTION_OTH'] + '(' + data['account_data'][i]['DESCRIPTION_OTH'] + ")</option>";
                }
              }
            }
            accounts += "</select>";

          }
          $("#" + gl_Account).html(accounts);
        }
      });
      if (id == 1) {
        $('#show_on_cash-' + index + '-cash-gl_account').show();
        $('#hide_on_cash-' + index + '-gl_account').hide();
        //$('#show_on_cash').show();
        // $('#hide_on_cash').hide();
      } else {

        getPaymentTypeMulti(id, gl_Account);
        $('#hide_on_cash-' + index + '-gl_account').show();
        $('#show_on_cash-' + index + '-cash-gl_account').hide();
        //$('#hide_on_cash').show();
        //$('#show_on_cash').hide();
      }
    }


    function getPaymentTypeMulti(val, id) {
      var res = "";
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('vendor-payment/payment-type') ?>",
        dataType: 'JSON',
        type: 'GET',
        // async:false,
        data: {
          payment_mode: val,
        },
        success: function (data) {
          if (data != "") {
            res = data.TYPE;
            if (data.TYPE == 'O') {
              //alert(data.DEFAULT_ACCOUNT)
              $('#' + id).val(data.DEFAULT_ACCOUNT);
            }
          }
        }
      });
      return res;
    }

    var check_total_amount = 0;
    var outstanding_total_amount = 0
    $(document).ready(function () {
      $('#paymentMultipleOther .modal-dialog').css('width','90%');
      //$('#paymentMultipleOther .modal-dialog').css('font-size','60%');
      $(".sidebar-toggle").trigger("click");
      $('.show-hide').click(function() {
        $('.information').toggleClass('toggle');
        $('#down_arrow_img').toggleClass('toggle');
        $('#right_arrow_img').toggleClass('toggle');
      });
      new Cleave("#customerpayment-amount_temp", {
        prefix: '',
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalScale: netPricePrecisionPlace
      });

      if ($('#customerpayment-downpayment_amount_temp').length) {
        new Cleave("#customerpayment-downpayment_amount_temp", {
          prefix: '',
          numeral: true,
          numeralThousandsGroupStyle: 'thousand',
          numeralDecimalScale: netPricePrecisionPlace
        });
      }


      $('.temp_del_charges').unbind().click(function () {
        $('.overlay-back').show();
        $('.del_row').slideDown();
        $('.del_row').find('.deldata').show();
      });
      $('.del_cancel').unbind().click(function () {
        $(this).closest('.del_row').slideUp();
        $('.overlay-back').hide();
        $(this).closest('.del_row').find('.deldata').hide();
      });


      var customer_no = $("#customerpayment-customer_id").val();
      if (customer_no) {
        var customer_name = $("#customerpayment-customer_name").val();
        append_customer(customer_no, customer_name);
      }

      $('.temp_change_company').unbind().click(function () {

        if (!"<?=$readonly_chng?>") {
          $('#search_customer').toggle();
          $('.arrow-img').toggle();
          $('#auto_search_customer_vw').focus();

          customerchange('', 'auto_search_customer_vw');
        }

      });
      $('.overlay-back').unbind().click(function () {
        $('.del_row').hide();
      });

      new Cleave('#customerpaymentmultpleother-0-amount_temp', {
        prefix: '',
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalScale: netPricePrecisionPlace
      });
      new Cleave('#customerpaymentmulticheck-0-check_amount_temp', {
        prefix: '',
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalScale: netPricePrecisionPlace
      });
      new Cleave('#customerpaymentcheck-0-check_amount_temp', {
        prefix: '',
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalScale: netPricePrecisionPlace
      });
    });

    function sales_order_check(assign_sales_check) {
      if (assign_sales_check) {
        $('.taxdata').show();
      } else {
        $('.taxdata').hide();
      }
      return;
    }

    function refreshcontrol() {
      'use strict';
      var keyCodes = {
        116: "f5 "
      };
      var body = document.querySelector('body');
      body.onkeydown = function (e) {
        if (!e.metaKey) {
          if (e.keyCode == 116) {
            var finsesion = 1
            e.preventDefault();
          }
        }
      }
    }

    var count_check = 0;

    function calculate() {
      value = ($("#customerpayment-amount_temp").val()).replace(/[^\d.-]/g, '');
      $("#customerpayment-amount").val(value);
      var tax_rate = $("#customerpayment-tax_rate").val();

      if (tax_rate != '') {
        var tax_final_value = Number(value) * ((tax_rate) / (+100 + +(tax_rate)));
        $("#customerpayment-tax_amount").val(convertStrToFloat(tax_final_value));
      }

      $("#customerpayment-amount").val(value);

      new Cleave("#customerpayment-amount_temp", {
        prefix: '',
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalScale: netPricePrecisionPlace
      });
      value = value * $("#customerpayment-exchange_rate").val();
      value = convertStrToFloat(value);
      $("#customerpayment-amount_received").val(convertStrToFloat(value));
      $("#customerpayment-amount_received_temp").val(formatConvert(value));

      if ($("#customerpayment-payment_category").val() == 'PARTIAL') {
        var bill_doc = $("input:radio[name='CustomerPayment[BILLING_DOC_NO]']:checked").val();
        if (bill_doc != '') {
          partial_pay_check(bill_doc);
        }
      }
      var total = +$("#total_last_local").val();
      total = convertStrToFloat(total);
      calculateTotalAll();
    }


    function ChangePaymentMethod(value) {
      var received_array = <?php echo json_encode($Received_array); ?>;
      var paid_array = <?php echo json_encode($paid_array); ?>;
      // var Received_array;
      // var paid_array;
      $("#customerpayment-payment_category").empty();
      value = $("input:radio[name='CustomerPayment[PAID_RECEIVED_IND]']:checked").val();
      if (value != 'PAID') {
        for (var text in received_array) {
          var val = received_array[text];
          $('<option/>').val(val).text(text).appendTo($("#customerpayment-payment_category"))
        }
        ;
      } else {
        for (var text in paid_array) {
          var val = paid_array[text];
          $('<option/>').val(val).text(text).appendTo($("#customerpayment-payment_category"))
        }
        ;
      }

    }
  var search_customer_response = false;
    function customerchange(val, id_pass, flag = 0) {
      if(!search_customer_response) {
        search_customer_response = true;
        saved_flag = true;
        $.ajax({
          url: "<?php echo \Yii::$app->getUrlManager()->createUrl('sales-header/customer-autocomplete') ?>",
          dataType: 'json',
          type: 'get',
          data: {
            term: val,
            id: id_pass,
          },
          success: function (data, textStatus, jQxhr) {

            var n = data['id_pass'].lastIndexOf('-');
            var result1 = '#customer_autodata';

            var url = "<?php echo Url::to(['sales-header/create']);?>";
            var data_new = '<ul class="autocomplete add_new_autocomplete" >';
            data_new += "<li onClick='opencustomerpopup()'>+" + '<?='ADD_NEW'; ?>' + "</li>";
            for (i = 0; i < data['customer_data'].length; i++) {
              var cust_name = addslashes(data['customer_data'][i]['NAME']);
              data_new += '<li onClick="showView(\'' + data['customer_data'][i]['ID'] + '\',\'' + cust_name + '\',' + flag + ')">' + data['customer_data'][i]['NAME'] + '</li>';
            }
            data_new += '</ul>';
            if (flag == 1) {
              $('.customer_autodata_show').show();
              $('.customer_autodata_show').html(data_new);
              $(".customer_sales_data").removeClass('even-strip');
              $('.customer_sales_data').parent('.row').removeClass('billimg-edit');
            } else {
              $(result1).show();
              $(result1).html(data_new);
              $("#customer_sales").removeClass('even-strip');
              $('#customer_sales').parent('.row').removeClass('billimg-edit');
            }
            // alert()
            search_customer_response = false;

          },
          error: function (jqXhr, textStatus, errorThrown) {
            //alert(errorThrown);
            //console.log( errorThrown );
            search_customer_response = false;
            if (errorThrown == 'Forbidden') {
              alert(you_dont_have_access_label);
            }
          }
        });
      }
    }

    function showView(id, name, flag = 0) {
      var payment_cat = $('#customerpayment-payment_category').val();
      saved_flag = true;
      $('#cust_details').html(name);
      $('.arrow-img').hide();
      $('#search_customer').hide();
      $('.cust_icon').show();
      var code = $("#hidden_company_code").val();
      $('#hidden_id').val(id);
      clearAllValues();


      $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=sales-header/customer-view' ?>',
        type: 'post',
        dataType: 'json',
        data: {
          ID: id
        },
        beforeSend: function () {
          $(".overlay").show();
        },
        complete: function () {
          //$(".overlay").hide();
        },
        success: function (data) {
          // console.log(data);
          $('#businesspartner-country').val(data['customer_data']['COUNTRY']);
          $('#businesspartner-id').val(data['customer_data']['ID']);
          $('#customerpayment-cust_name').val(data['customer_data']['NAME']);
          $('.customer_active_tab').show();
          if (data['customer_data']['MOBILE_NO'] != '') {
            $('#mob_no').show();
            $('#mob_no').html('<i class="fa fa-phone fa-fw"></i> ' + data['customer_data']['MOBILE_NO']);
            $('.field-businesspartner-mobile_no input').val(data['customer_data']['MOBILE_NO']);
            $('#customerpayment-cust_mobile').val(data['customer_data']['MOBILE_NO']);
          } else {
            $('#mob_no').hide();
            $('.field-businesspartner-mobile_no input').val('');
            $('#customerpayment-cust_mobile').val('');
          }

          if (data['customer_data']['EMAIL'] != '') {
            $('#email').show();
            $('#email').html('<i class="fa fa-envelope fa-fw"></i> ' + data['customer_data']['EMAIL']);
            $('.field-businesspartner-email input').val(data['customer_data']['EMAIL']);
            $('#customerpayment-cust_email').val(data['customer_data']['EMAIL']);
          } else {
            $('#email').hide();
            $('.field-businesspartner-email input').val('');
            $('#customerpayment-cust_email').val('');
          }
          var flag = 0;
          if (data['bill_address_data'] != null) {
            // alert("df")
            flag = 1;
            $('#billing_address').show();
            $('#billing_address_value').html('<span class="text-tip" style="width: 100%;cursor: pointer;"><span id="billing_address_value" class="pull-left text-tip" style="cursor: pointer"><i class="fa fa-map-marker fa-fw"></i> ' + '<b>' + billing_add_label + ': </b><a class="attension_data">' + data['bill_address_data']['ATTENTION'] + '</a><p id="bill_add_data">' + data['bill_address'] + '</p></span></span>');

            $('#kv-login-form #businesspartneradd-attention').val(data['bill_address_data']['ATTENTION']);
            $('#kv-login-form #businesspartneradd-id').val(data['bill_address_data']['ID']);
            $('#kv-login-form #businesspartneradd-street').val(data['bill_address_data']['STREET']);
            $('#kv-login-form #businesspartneradd-city').val(data['bill_address_data']['CITY']);
            $('#kv-login-form #businesspartneradd-state').val(data['bill_address_data']['STATE']);
            $('#kv-login-form #businesspartneradd-postal_code').val(data['bill_address_data']['POSTAL_CODE']);
            $('#kv-login-form #businesspartneradd-contact_no').val(data['bill_address_data']['CONTACT_NO']);

          } else {
            flag = 0;
            $('#billing_address').hide();
            $('#billing_address_value').html('');
          }
          if (data['deli_address_data'] != null) {
            flag = 1;
            $('#delivery_address').show();
            $('#delivery_address_value').html('<span class="text-tip" style="width: 100%;cursor: pointer;"><span id="delivery_address_value" class="pull-left text-tip" style="cursor: pointer"><i class="fa fa-map-marker fa-fw"></i> ' + '<b>' + delivery_add_label + ': </b><a id="del_attn_data">' + data['deli_address_data']['ATTENTION'] + '</a><p id="address_del_data">' + data['del_address'] + '</p></span></span>');

            $('#kv-delivary-form #businesspartneradd-attention').val(data['deli_address_data']['ATTENTION']);
            $('#kv-delivary-form #businesspartneradd-id').val(data['deli_address_data']['ID']);
            $('#kv-delivary-form #businesspartneradd-street').val(data['deli_address_data']['STREET']);
            $('#kv-delivary-form #businesspartneradd-city').val(data['deli_address_data']['CITY']);
            $('#kv-delivary-form #businesspartneradd-state').val(data['deli_address_data']['STATE']);
            $('#kv-delivary-form #businesspartneradd-postal_code').val(data['deli_address_data']['POSTAL_CODE']);
            $('#kv-delivary-form #businesspartneradd-contact_no').val(data['deli_address_data']['CONTACT_NO']);


          } else {
            $('#delivery_address').hide();
            $('#delivery_address_value').html('');
          }

          if (flag) {
            $(".customer_address").show();
          } else {
            $(".customer_address").hide();
          }

          var data_trmt = '<select class="autocomplete add_new tax_trtmnt_create" >';
          data_trmt += "<option value=''>" + '<?= 'SELECT'; ?>' + "</option>";
          data_trmt += "<option value='Add New' onClick='addtaxtreatment(this.value,this.id)'>+" + '<?= 'ADD_NEW'; ?>' + "</option>";
          var place_supply_mandetory_flag = '1';
          for (i = 0; i < data['customer_trmt'].length; i++) {

            data_trmt += '<option value=' + data['customer_trmt'][i]['TAX_TREATMENT'] + '>' + data['customer_trmt'][i]['DESCRIPTION'] + '</option>';

            if (data['customer_trmt'][i]['TAX_TREATMENT'] == data['customer_data']['TAX_TREATMENT']) {
              place_supply_mandetory_flag = data['customer_trmt'][i]['PLACE_OF_SUPPLY_MAND'];
            }
          }
          data_trmt += '</select>';
          $('.field-businesspartner-tax_treatment select').html(data_trmt);
          var tax_treat = '';
          var tax_treat_old = $('#businesspartner-tax_treatment').val();
          if (data['customer_data']['taxTreatment'] != null && data['customer_data']['DESCRIPTION'] != null) {
            tax_treat = data['customer_data']['TAX_TREATMENT'];
            $('#tax_treatment').show();
            $('#tax_treatment').html('<b>' + tax_treatment_label + ' : </b>' + data['customer_data']['DESCRIPTION']);
            $('.field-businesspartner-tax_treatment select').val(data['customer_data']['TAX_TREATMENT']);
            $('#customerpayment-tax_treatment').val(data['customer_data']['TAX_TREATMENT']);

          } else {
            $('#tax_treatment').hide();
            $('.field-businesspartner-tax_treatment select').val('');
            $('#customerpayment-tax_treatment').val('');
          }

          // if(tax_treat_old!=tax_treat){
          //      changeAllVats();
          //    }
          if (data['customer_data']['PLACE_OF_SUPPLY'] != '' && data['customer_data']['PLACE_OF_SUPPLY'] != null) {
            $('#place_of_supply').show();
            $('#place_of_supply').html('<b>' + place_of_supply_label + ' : </b>' + data['customer_data']['PLACE_OF_SUPPLY'])
            $('.field-businesspartner-place_of_supply select').val(data['customer_data']['PLACE_OF_SUPPLY']);
            $('#customerpayment-place_of_supply').val(data['customer_data']['PLACE_OF_SUPPLY']);
          } else {
            $('#place_of_supply').hide();
            $('.field-businesspartner-place_of_supply select').val('');
            $('#customerpayment-place_of_supply').val('');
          }

          if (data['customer_data']['TRN'] != '' && data['customer_data']['TRN'] != null) {
            $('#trn').show();
            $('#trn').html('<b>' + trn_label + ' : </b>' + data['customer_data']['TRN'])
            $('.field-businesspartner-trn input').val(data['customer_data']['TRN']);
            $('#customerpayment-trn').val(data['customer_data']['TRN']);
          } else {
            $('#trn').hide();
            $('.field-businesspartner-trn input').val('');
            $('#customerpayment-trn').val('');
          }

          $('#hidden_business_type').val('C');
          $('#hidden_company_code').val(+data['customer_data']['COMPANY_CODE']);
          $('.cust_editable').hide();

          if ($('#place_of_supply').val() != '') {
            $('.field-businesspartner-place_of_supply select').val($('#place_of_supply').val());
          }

          if (place_supply_mandetory_flag == '0') {
            $('.field-businesspartner-place_of_supply select').prop('disabled', true);
            $('.field-businesspartner-place_of_supply select').val('');
          } else if (place_supply_mandetory_flag == '1') {
            $('.field-businesspartner-place_of_supply select').prop('disabled', false);
          }
          // console.log(data_trmt)

          append_customer(id, name);
        },
        error: function (jqXhr, textStatus, errorThrown) {
          // alert(errorThrown);
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
        }
      });
      set_data_cust(id);
      /*if (payment_cat == "MULTIPLE_SETTELMENT" || payment_cat == "FINAL" || payment_cat == "RET") {
        retriveMultipleSettlement();
      }*/
    }

    function set_data_cust(id) {
      $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=sales-quotation/set-data' ?>',
        type: 'post',
        dataType: 'json',
        data: {
          ID: id
        },
        success: function (data) {
          if (data['cust_data']['CUST_CURRENCY'] != null || data['cust_data']['CUST_CURRENCY'] != '') {
            $('#customerpayment-currency').val(data['cust_data']['CUST_CURRENCY']).trigger('change');
           /* currencyChange(data['cust_data']['CUST_CURRENCY'], '', 'customerpayment-exchange_rate');
            changeexchangerate();*/
          }
        },
        error: function (jqXhr, textStatus, errorThrown) {
          alert(errorThrown);
        }
      });
    }

    function ChangeAccount(value, id, flag) {
      var id_str = "";
      var name_str = ""
      if (flag == 1) {
        id_str = "customerpaymentcheck";
        name_str = "CustomerPaymentCheck";
      } else {
        id_str = "customerpaymentmulticheck";
        name_str = "CustomerPaymentMultiCheck";
      }
      var payment_cat = '';
      console.log(payment_cat + " -- " + value);
      /*if((value=='PDC' || value=='UNDEP' || value=='DEPOSITED') && (payment_cat==2 || payment_cat==1)){
flag_chk_status=1;
}else{
flag_chk_status=2;
}*/
      if ((value != 'CLEARED') && (payment_cat == 2 || payment_cat == 1)) {
        flag_chk_status = 1;
      } else {
        flag_chk_status = 2;
      }
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer-payment/change-check-accounts') ?>",
        dataType: 'json',
        type: 'post',
        data: {
          check_status: value,
          id: id,
          flag: flag_chk_status,
        },
        success: function (data, textStatus, jQxhr) {
          var alternet_number_range_format = data['alternet_number_range_format'];
          var numbers = id.match(/[0-9]+/g);
          var tax_dropdown = ".field-" + id_str + "-" + numbers + "-bank_account";

          var tax_table = '<select  name="' + name_str + '[' + numbers + '][BANK_ACCOUNT]" id="' + id_str + '-' + numbers + '-bank_account" style="padding-left: 1px;" class="form-control" aria-invalid="false" >';
          tax_table += '<option value="">' + "<?= 'SELECT'; ?>" + '</option>';


          for (var i = 0; i < data['details'].length; i++) {
            if (alternet_number_range_format == 1) {

              tax_table += "<option value='" + data['details'][i]['GL_NO'] + "'>" + data['details'][i]['MANUAL_NUMBER'] + ' - ' + data['details'][i]['DESCRIPTION'] + "</option>";
            } else {
              tax_table += "<option value='" + data['details'][i]['GL_NO'] + "'>" + data['details'][i]['GL_NO'] + ' - ' + data['details'][i]['DESCRIPTION'] + "</option>";
            }

          }
          tax_table += "</select>";
          // tax_table+='</tbody></table>';
          $(tax_dropdown).html(tax_table);

        },
        error: function (jqXhr, textStatus, errorThrown) {
          // alert(errorThrown);
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
          //console.log( errorThrown );
        }
      });
      return true;

    }


    function opencustomerpopup() {
      $('.sidebar-modal .tab-content').html('');
      saved_flag = true;
      $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=customer-quick/create' ?>',
        type: 'post',
        data: '',
        success: function (data) {

          $('.sidebar-modal .tab-content').html(data);
          $(".sidebar-modal").show('slide');
          $(".overlay-back").show();

        },
        error: function (jqXhr, textStatus, errorThrown) {
          // alert(errorThrown);
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
        }
      });
    }

    function customer_autocomplete() {
      //alert();
      var val = $("#customerpayment-customer_name").val();
      // alert(val);
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer-payment/customer-autocomplete') ?>",
        dataType: 'json',
        type: 'GET',
        // async:false,
        data: {
          term: val,
        },
        success: function (data, textStatus, jQxhr) {
          // console.log(data)

          var data_new = '<ul class="autocomplete barcode_auto">';
          data_new += "<li value='' style='padding:6px 6px !important;background:#f2f2f2;box-shadow:inset -3px 3px 10px rgba(2,2,2,.2)'>" + '<?= 'SELECT'; ?>' + "</li>";
          var desc = '';

          for (i = 0; i < data.length; i++) {

            data_new += '<li onclick="append_customer(' + data[i]['id'] + ',\'' + data[i]['label'] + '\')" style="border-bottom:1px solid #ddd !important;padding:6px 0px 8px 8px !important;">' + data[i]['label'] + '</li>';

          }
          data_new += '</ul>';
          $('#barcodeautocomplete').html(data_new);
          data_new = '';
        },
        error: function (jqXhr, textStatus, errorThrown) {
          // alert(errorThrown);
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
          //console.log( errorThrown );
        }
      });

    }

    function append_customer(id, label) {
      var val = $('#customerpayment-payment_category').val();
      var sales_order_no =  '';
      var jobcard_no =  '';
      var work_order =  '';
      var flag_disting = false;
      var ret_flag = false;

      // alert('sales_order_no'+sales_order_no+'----'+'jobcard_no'+jobcard_no)
      $('#customerpayment-customer_id').val(id);
      $('#customerpayment-customer_name').val(label);
      var payment_category = $('#customerpayment-payment_category').val();

      if (val == 'DOWNPAY') {
        $('.tax_details_div').show();
        var assign_sales_check = $("#customerpayment-assign_sales_order").prop('checked');
        $('.sales_class').show();
        sales_order_check(assign_sales_check);
      } else {
        $('.tax_details_div').hide();
        $('.sales_class').hide();
      }


      if (val == 'DOWNPAY' || val == 'PARTIAL' || ret_flag == 1) {
        $('.final_class').hide();
      } else {
        $('.final_class').show();
      }

      $.ajax({
        //url:"<?php //echo \Yii::$app->getUrlManager()->createUrl('customer-payment/sales-orders') ?>//",
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('new-customer-payment/index') ?>",
        dataType: 'json',
        type: 'GET',
        // async:false,
        data: {
          customer_no: id,
          payment_category: payment_category,
          sales_order: sales_order_no,
          jobcard_no: jobcard_no,
          work_order: work_order,
          flag_disting: flag_disting, //1 for jobcard,0 for sales
          ret_flag: ret_flag,
        },
        beforeSend: function () {
          $(".overlay").show();
        },
        complete: function () {
          // $(".overlay").hide();
        },
        success: function (data, textStatus, jQxhr) {
          // console.log(data);

          $('.taxdata').html(data);
          //$(".overlay").hide();
        }
      });
      return;
    }



    function JournalVoucherAdd() {
      var total_data = 0;
      var count = $('#journal_voucher_count_items').val();

      for (i = 0; i < count; i++) {
        var check_count = "#journal_voucher_count" + i;
        if ($(check_count).is(':checked')) {
          total_data += Number($(check_count).val());
        }
      }
      $("#journal_total_local").val(total_data);
      $("#jv_subtotal").html(formatConvert(total_data));
      $("#total_jv_settlement").val(total_data);
      calculateTotalAll();
    }

    function appendDataJv(business_part,flag=1) {
      var id = $('#customerpayment-customer_id').val();
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('journal-voucher-payment/retrive-settlement-data') ?>",
        data: {
          customer_no: id,
        },
        dataType: 'html',
        type: 'GET',
        beforeSend: function () {
          $(".overlay").show();
          $("#jv_details_loader").show();
        },
        complete: function () {
          $(".overlay").hide();
          $("#jv_details_loader").hide();
        },
        success: function (data, textStatus, jQxhr) {
          if (flag==1){
            $('#pModal_jv_payment .modal-dialog').css('width', '80%');
            $('#pModal_jv_payment').modal('show');
            $('#modalContent_jv_payment').html(data);
          }else{
            $('#modalContent_jv_payment').html(data);
          }

        }
      });
      return true;
    }

    function changeDelProcess(value, id) {
      saved_flag = true;
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('sales-header/change-vat-process') ?>",
        dataType: 'json',
        type: 'get',
        data: {
          tax_process: value,
        },
        beforeSend: function () {
          $(".overlay").show();
        },
        complete: function () {
          $(".overlay").hide();
        },
        success: function (data, textStatus, jQxhr) {
          $('#customerpayment-tax_amount').val('');
          var tax_dropdown = ".field-customerpayment-tax_code";
          var tax_code = "customerpayment-tax_code";
          var tax_code_default = $("#" + tax_code).val();

          if (data['tax_details'] != null) {
            var tax_table = '<select  name="CustomerPayment[TAX_CODE]" onchange="taxcodechange()"  id="customerpayment-tax_code" style="padding-left: 1px;" class="form-control" aria-invalid="false" >';
            tax_table += '<option value="">Select</option>';

            for (var i = 0; i < data['tax_details'].length; i++) {
              if (data['tax_details'][i]['TAX_CODE'] == tax_code_default) {
                tax_table += "<option value='" + data['tax_details'][i]['TAX_CODE'] + "' selected>" + data['tax_details'][i]['TAX_CODE'] + ' - ' + data['tax_details'][i]['DESCRIPTION_EN'] + "</option>";
              } else {
                tax_table += "<option value='" + data['tax_details'][i]['TAX_CODE'] + "'>" + data['tax_details'][i]['TAX_CODE'] + ' - ' + data['tax_details'][i]['DESCRIPTION_EN'] + "</option>";
              }
            }
            tax_table += "</select>";
          }
          $(tax_dropdown).html(tax_table);
        },
        error: function (jqXhr, textStatus, errorThrown) {
          // alert(errorThrown);
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
          //console.log( errorThrown );
        }
      });
      return true;
    }

    function taxcodechange() {
      var tax_code = $("#customerpayment-tax_code").val();
      var tax_process = $("#customerpayment-tax_process").val();
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('sales-header/tax-details') ?>",
        dataType: 'json',
        type: 'get',
        data: {
          tax_code: tax_code,
          id: '',
          tax_process: tax_process,
          tax_type: 'OUTPUT',
        },
        beforeSend: function () {
          $(".overlay").show();
        },
        complete: function () {
          $(".overlay").hide();
        },
        success: function (data, textStatus, jQxhr) {
          if (data['tax_details']['TAX_RATE'] == null) {
            var rate_val = 0.00;
          } else {
            var rate_val = convertStrToFloat(data['tax_details']['TAX_RATE']);
          }
          var amount = $("#customerpayment-amount").val();
          amount = convertStrToFloat(amount);
          $("#customerpayment-tax_rate").val(rate_val);
          // $("#customerpayment-tax_rate").val( Math.round(data['tax_details']['TAX_RATE']));

          var tax_final_value = (amount) * ((rate_val) / (+100 + +(rate_val)));

          tax_final_value = convertStrToFloat(tax_final_value);
          $("#customerpayment-tax_amount").val(tax_final_value);
        },
        error: function (jqXhr, textStatus, errorThrown) {
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
          //console.log( errorThrown );
        }
      });
    }

    function clear_check_modal_multi() {

      //alert(count_check_other+"---"+count_check_multi);
      //$('#customer_payment_form')[0].reset();
      //$('.payment_multiple_other').find('input:text').val('');
      $('#customerpayment-amount').prop('readonly', true);
      $("#customerpayment-amount").val('');
      $('#customerpayment-amount_temp').prop('readonly', true);
      $("#customerpayment-amount_temp").val('');
      $("#customerpayment-tax_amount").val('');
      $('#multi_amount_span').html('0.00');
      $('#paymentMultipleOther').find("input,textarea,select").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
      if (count_check_other > 0) {
        for (var i = 0; i < count_check_other; i++) {
          $(".remove-check-item-other").trigger("click");
        }
      }
      if (count_check_multi > 0) {
        for (var i = 0; i < count_check_multi; i++) {
          $(".remove-check-item-check-details").trigger("click");
        }
      }

    }

    function clear_check_modal() {

      $('#customerpayment-amount').prop('readonly', true);
      $("#customerpayment-amount").val('');
      $('#customerpayment-amount_temp').prop('readonly', true);
      $("#customerpayment-amount_temp").val('');
      $("#customerpayment-tax_amount").val('');
      $('#pModal_check').find("input,textarea,select").val('').end().find("input[type=radio]").prop("checked", "").end();
      if (count_check > 0) {

        for (var i = 0; i < count_check; i++) {
          $(".remove-check-item").trigger("click");
        }
      }

    }

    function model_check_data() {

      var val = $('#customerpayment-payment_method').val();
      var type = '';
      $("#customerpayment-gl_account").val("").trigger('change');
      $("#customerpayment-cash_gl").val("");
      $("input[name='CustomerPayment[RETURN_CHECK]']").prop('checked', false);
      var downpayment_adj = 0;
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer-payment/payment-mode-details') ?>",
        dataType: 'json',
        type: 'GET',
        //async:false,
        data: {
          payment_mode: val,
        },
        success: function (data, textStatus, jQxhr) {
          // alert(data['alternet_number_range_format'])
          type = data['type'];
          var alternet_number_range_format = data['alternet_number_range_format'];
          if (data['account_data']) {
            var accounts = '<select id="customerpayment-gl_account"  style="border:none;padding-left: 1px;"  name="CustomerPayment[GL_ACCOUNT]" aria-invalid="false">';
            accounts += '<option value="">' + "<?php echo 'SELECT'; ?>" + '</option>';

            for (var i = 0; i < data['account_data'].length; i++) {

              if (data['loginLang'] == 'EN') {
                if (alternet_number_range_format == 1) {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['MANUAL_NUMBER'] + ' - ' + data['account_data'][i]['DESCRIPTION'] + "</option>";
                } else {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['GL_NO'] + ' - ' + data['account_data'][i]['DESCRIPTION'] + "</option>";
                }

              } else {
                if (alternet_number_range_format == 1) {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['MANUAL_NUMBER'] + ' - ' + data['account_data'][i]['DESCRIPTION_OTH'] + '(' + data['account_data'][i]['DESCRIPTION_OTH'] + ")</option>";
                } else {
                  accounts += "<option value='" + data['account_data'][i]['GL_NO'] + "'>" + data['account_data'][i]['GL_NO'] + ' - ' + data['account_data'][i]['DESCRIPTION_OTH'] + '(' + data['account_data'][i]['DESCRIPTION_OTH'] + ")</option>";
                }
              }
            }
            accounts += "</select>";

          }

          $("#customerpayment-gl_account").html(accounts);

          if(data['downpayment_adj']==1){
            $('#show_on_cash').hide();
            $('#hide_on_cash').hide();
            $('.show_on_check').hide();
            $('#customerpayment-amount_temp').prop('readonly', true);
            $('#customerpayment-amount_temp').val(0);
            $('#customerpayment-amount').val(0);
            downpayment_adj=(data['downpayment_adj']);
           // $("#amount_curr_div").hide();
          // }else{
          //     $('#customerpayment-amount_temp').prop('readonly', false);
          }
        }
      });


      if (val != 8) {
        $('#customerpayment-multipe_payments').prop("checked", false);
        $("#multi_not").show();
        $(".show_on_multi").hide();
        clear_check_modal_multi();
      }
      // alert(val);
      if (val != 3) {
        clear_check_modal();
        $('.show_on_check').hide();
      }

      if (val == 3) {
        $('.show_on_check').show();
        $('#hide_on_cash').hide();
        $('#show_on_cash').hide();
        $('#customerpayment-amount').prop('readonly', true);
        $("#customerpayment-amount").val('');
        $('#customerpayment-amount_temp').prop('readonly', true);
        $("#customerpayment-amount_temp").val('');
        $("#customerpayment-tax_amount").val('');
      } else if (val == 1) {
        $('#show_on_cash').show();
        $('#hide_on_cash').hide();
        $('.show_on_check').hide();
        $('#customerpayment-amount').prop('readonly', false);
        $('#customerpayment-amount_temp').prop('readonly', false);
      } else if (val == 8) {
        $('#customerpayment-multipe_payments').prop("checked", true);

        // clear_check_modal();
        $("#multi_not").hide();
        $(".show_on_multi").show();

        //added by mayuri
        $('#customerpayment-amount').prop('readonly', true);
        $("#customerpayment-amount").val('');
        $('#customerpayment-amount_temp').prop('readonly', true);
        $("#customerpayment-amount_temp").val('');
        $("#customerpayment-tax_amount").val('');
        $('#pModal_check').find("input,textarea,select").val('').end().find("input[type=radio]").prop("checked", "").end();

        if (count_check > 0) {
          for (var i = 0; i < count_check; i++) {
            $(".remove-check-item").trigger("click");
          }
        }
        //end
      } else {
        var type = getPaymentType(val);

        $('.show_on_check').hide();
        if(downpayment_adj==0){
             $('#hide_on_cash').show();
          }

        $('#show_on_cash').hide();
         if(downpayment_adj==0) {
        $('#customerpayment-amount').prop('readonly', false);
        $('#customerpayment-amount_temp').prop('readonly', false);
         }else{
           $('#customerpayment-amount_temp').val(0);
           $('#customerpayment-amount').val(0);
        }
      }
       calculate();
    }


    function payment_cat(val) {
      $("#customerpayment-amount").val("");
      $("#customerpayment-amount_temp").val("");
      if ($('#customerpayment-downpayment_amount').length) {
        $('#customerpayment-downpayment_amount').val('');
        $('#customerpayment-downpayment_amount_temp').val('');
      }
      var val = $('#customerpayment-payment_category').val();
      var id = $('#customerpayment-customer_id').val();
      var label = $('#customerpayment-customer_name').val();
      $("#customerpayment-amount_received").val(0.00);
      $("#customerpayment-amount_received_temp").val(0.00);
      clearAllValues();
      if (id != '') {
        append_customer(id, label);
        if (val == 'DOWNPAY' || val == 'PARTIAL' || val == 'FINAL' || val == 'MULTIPLE_SETTELMENT') {
          // append_customer(id,label)
          // $('.show_on_payment_cat').show();
        } else {
          $('.show_on_payment_cat').hide();
        }
      }
      if (val == "MULTIPLE_SETTELMENT" || val == "FINAL" || val == "RET") {


        $('#payment_subtotal').show();
        //advance_payment_flag=1;
        // retriveMultipleSettlement();
      } else {

        $('#payment_subtotal').hide();

      }
    }

    function setamount(val, id) {
      var company_curr = '';
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer-payment/sales-details') ?>",
        dataType: 'json',
        type: 'GET',
        //  async:false,
        data: {
          order_no: val,
        },
        success: function (data, textStatus, jQxhr) {
          //console.log(data);
          $("#customerpayment-amount").val(data['net_value']);
          $("#customerpayment-currency").val(data['currency']);
          $("#customerpayment-exchange_rate").val(data['exchange_rate']);
          $('.exchange_rate_show').html('1 ' + data['currency'] + '=' + data['exchange_rate'] + ' ' + company_curr);
        }
      });
    }

    function formatConvert(n, currency) {
      var precision = <?= $precision ?>;
      return n.toFixed(precision).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

    function addCheck() {
      count_check++;
      jQuery("#check_tab .dynamicform_wrapper").on("afterInsert", function (e, item) {
        e.stopImmediatePropagation();
        var new_data = "#customerpaymentcheck-" + (count_check - 1) + "-sr_no";
        var id = "#customerpaymentcheck-" + (count_check) + "-sr_no";
        var value = (+($(new_data).html()) + +1);
        $(id).html(value);
        cleave_id = '#customerpaymentcheck-' + count_check + '-check_amount_temp';
        new Cleave(cleave_id, {
          prefix: '',
          numeral: true,
          numeralThousandsGroupStyle: 'thousand',
          numeralDecimalScale: netPricePrecisionPlace
        });

        dynamicDatepicker('customerpaymentcheck-' + (count_check) + '-check_date');
        dynamicDatepicker('customerpaymentcheck-' + (count_check) + '-clearing_date');
        dynamicDatepicker('customerpaymentcheck-' + (count_check) + '-deposit_date');
      });
    }

    function removeCheck() {
      if (count_check > 0) {
        count_check = count_check - 1;
        jQuery("#check_tab .dynamicform_wrapper").on("afterDelete", function (e, item) {
          for (var i = 0; i <= count_check; i++) {
            e.stopImmediatePropagation();
            var temp_sr = "#customerpaymentcheck-" + (i) + "-sr_no";
            $(temp_sr).html(i + 1);
          }
        });
      }
      //calculate_amount('','');
    }

    var count_check_other = 0;

    function addCheckOther() {

      count_check_other++;
      jQuery("#check_details_other .dynamicform_wrapper_check_other").on("afterInsert", function (e, item) {
        e.stopImmediatePropagation();
        var new_data = "#customerpaymentcheckothers-" + (count_check_other - 1) + "-sr_no";
        var id = "#customerpaymentcheckothers-" + (count_check_other) + "-sr_no";
        var value = (+($(new_data).html()) + +1);
        //alert(id+"--"+value);
        $(id).html(value);
        cleave_id = '#customerpaymentmultpleother-' + count_check_other + '-amount_temp';
        new Cleave(cleave_id, {
          prefix: '',
          numeral: true,
          numeralThousandsGroupStyle: 'thousand',
          numeralDecimalScale: netPricePrecisionPlace
        });

      });
    }

    function removeCheckOther() {
      if (count_check_other > 0) {
        count_check_other = count_check_other - 1;
        jQuery("#check_details_other .dynamicform_wrapper_check_other").on("afterDelete", function (e, item) {
          e.stopImmediatePropagation();
          for (var i = 0; i <= count_check_other; i++) {
            var temp_sr = "#customerpaymentcheckothers-" + (i) + "-sr_no";
            $(temp_sr).html(i + 1);
          }
          calculate_amount_multi_label('', '');
        });

      }
    }

    var count_check_multi = 0;

    function addCheckMulti() {
      count_check_multi++;
      jQuery("#check_details_multi .dynamicform_wrapper_check_details").on("afterInsert", function (e, item) {
        e.stopImmediatePropagation();
        var new_data = "#customerpaymentmulticheck-" + (count_check_multi - 1) + "-sr_no";
        var id = "#customerpaymentmulticheck-" + (count_check_multi) + "-sr_no";
        var value = (+($(new_data).html()) + +1);
        $(id).html(value);
        cleave_id = '#customerpaymentmulticheck-' + count_check_multi + '-check_amount_temp';
        new Cleave(cleave_id, {
          prefix: '',
          numeral: true,
          numeralThousandsGroupStyle: 'thousand',
          numeralDecimalScale: netPricePrecisionPlace
        });
        dynamicDatepicker('customerpaymentmulticheck-' + (count_check_multi) + '-check_date');
        dynamicDatepicker('customerpaymentmulticheck-' + (count_check_multi) + '-clearing_date');
        dynamicDatepicker('customerpaymentmulticheck-' + (count_check_multi) + '-deposit_date');
      });
    }

    function removeCheckMulti() {
      if (count_check_multi > 0) {
        count_check_multi = count_check_multi - 1;
        jQuery("#check_details_multi .dynamicform_wrapper_check_details").on("afterDelete", function (e, item) {
          e.stopImmediatePropagation();
          for (var i = 0; i <= count_check_multi; i++) {
            var temp_sr = "#customerpaymentmulticheck-" + (i) + "-sr_no";
            $(temp_sr).html(i + 1);
          }
          calculate_amount_multi_label('', '');
        });

      }
    }

    function removeDuplicates(json_all) {
      var arr = [];
      $.each(json_all, function (index, value) {
        arr[value] = (value);
      });
      return arr;
    }

    function AssignFlagDistFlag() {
      var data = $('input[type="radio"]:checked').parent('td').next('td').html();
      if (data != '') {
        $('#customerpayment-flag_distinguish').val(0);
      } else {
        $('#customerpayment-flag_distinguish').val(1);
      }
    }

    var hit_flag = 0;
    var form_submit = false;

    function submitForm() {
      var pay_cat = $('#customerpayment-payment_category').val();
      // if(pay_cat!="FINAL"){
      //   AssignFlagDistFlag();
      // }
      var amount = $("#customerpayment-amount").val();
      var pay_method = $("#customerpayment-payment_method").val();
      var customer_bounce_flag = $("input[name='CustomerPayment[RETURN_CHECK]']").is(":checked");

      if (pay_method == 3 && amount != check_total_amount && !customer_bounce_flag) {
        alert(amount_check_amount_same_label);
        return false;
      }
      if (!form_submit) {
        form_submit = true;
        setTimeout(function () {
          $.ajax({
            url: $('#customer_payment_form').attr('action'),
            type: 'post',
            dataType: 'json',
            data: $("#customer_payment_form").serialize(),
            beforeSend: function () {
              $(".overlay").show();
            },
            complete: function () {
              $(".overlay").hide();
            },
            success: function (data) {
              $('.form-control').removeClass("errors_color");
              var html = "";
              var cleaned = removeDuplicates(data['errors']);

              if (data['exception']) {
                if (Number(hit_flag) < Number(reload_hit_flag)) {
                  hit_flag = hit_flag + 1;
                  setTimeout(function () {
                    form_submit = false;
                    submitForm();
                    return false;
                  }, 2000);
                } else {
                  if (data['error_message']) {
                    hit_flag = 0;
                    html = data['error_message'];
                    $("html, body").animate({scrollTop: 0}, "slow");
                    form_submit = false;
                    $(".error-summary-main").show();
                    $("#error_display_main").html(html);
                  }
                }
              } else {
                for (var key in data['errors']) {
                  $('#' + key).addClass("errors_color");
                }
                for (var key in cleaned) {
                  html += key + "<br>";
                }
                if (data['error_message']) {
                  html += data['error_message'];
                }
                $("html, body").animate({scrollTop: 0}, "slow");
                if (html != '') {
                  form_submit = false;
                  $(".error-summary-main").show();
                  $("#error_display_main").html(html);
                } else {
                  $(".error-summary-main").hide();
                  if (data['success']) {
                    window.location.href = "<?php echo \Yii::$app->getUrlManager()->createUrl('customer-payment/view') . '&BUSINESS_PARTNER_TYPE=C&CUSTOMER_NO='?>" + data['CUSTOMER_NO'] + '&DOCUMENT_NO=' + data['DOCUMENT_NO'];
                  }
                }
              }
            },
            error: function (jqXhr, textStatus, errorThrown) {
              console.log(jqXhr);
              form_submit = false;
              if (errorThrown == 'Forbidden') {
                alert(you_dont_have_access_label);
              }
            }
          });
        }, 1000);
      }
    }


    function show_check_data() {
      var return_check = $("input[name='CustomerPayment[RETURN_CHECK]']").is(":checked");
      if (return_check) {
        clear_check_modal();
        $('#bounce_check_amount_span').html(0);
        var id = $('#customerpayment-customer_id').val();
        $.ajax({
          url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=customer-payment/check-create-details' ?>',
          type: 'get',
          dataType: 'html',
          data: {ID: id, return_check: return_check},
          beforeSend: function () {
            $(".overlay").show();
          },
          complete: function () {
            $(".overlay").hide();
          },
          success: function (data) {
            $("#payment_check_return").modal('show');
            $("#return_check_class").html(data);

            // $('.sidebar-modal .tab-content').html(data);
            // $(".sidebar-modal").show('slide');
            // $(".overlay-back").show();
          },
          error: function (jqXhr, textStatus, errorThrown) {
            // alert(errorThrown);
            if (errorThrown == 'Forbidden') {
              alert(you_dont_have_access_label);
            }
          }
        });
      } else {
        $(".error-summary-check").hide();
        $('#pModal_check').modal('show');
      }


      /* if($("input[name='CustomerPayment[RETURN_CHECK]']:checked").val()){

}else{

}
 */
    }

    function clearReturn() {
      var return_check = $("input[name='CustomerPayment[RETURN_CHECK]']").is(":checked");
      if (!return_check) {
        $('#customerpayment-amount').val('');
        $('#customerpayment-amount_temp').val('');
      }
    }

    function addcurrency(val, id) {
      saved_flag = true;
      if (val == 'Add New') {
        $('#' + id).val('');
        $('#modalContent_search').html('');
        $.ajax({
          url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=currency-code/createpopup' ?>',
          type: 'post',
          data: {
            temp_curr_id: id,
          },

          success: function (data) {
            $('#pModal_search').modal('show');
            $('#modalContent_search').html(data);
          },
          error: function (jqXhr, textStatus, errorThrown) {
            //alert(errorThrown);
            if (errorThrown == 'Forbidden') {
              alert(you_dont_have_access_label);
            }
          }
        });
      } else {
        currencyChange(val, '', 'customerpayment-exchange_rate');
        changeexchangerate();
        test_exc();
      }
    }

    function changeexchangerate() {
      saved_flag = true;
      var val = $('#customerpayment-exchange_rate').val();
      var currency = $('#customerpayment-currency').val();
      $('.displaycurr').html(currency);
      $(".dropdown_discount").text(currency);
      $('#display_exc_stream').html('1 ' + currency + ' = ' + val + ' ' + "");
    }

    function calculate_amount(id, val) {
      if (id != '') {
        var amount_id = id.slice(0, -5);
        var total = val.replace(/[^\d.-]/g, '');
        $("#" + amount_id).val(total);
      }
      var count = count_check + 1;
      var final_amount = 0;

      for (var i = 0; i < count; i++) {
        var result = '#customerpaymentcheck-';
        var input_amount = ($(result + i + "-check_amount").val());
        final_amount = +final_amount + +convertStrToFloat(input_amount);
      }


        check_total_amount = final_amount;
        $('#customerpayment-amount').val(convertStrToFloat(final_amount));
        $('#customerpayment-amount_temp').val(convertStrToFloat(final_amount));
        calculate();

    }

    function calculate_amount_multi() {

      var count;
      var final_amount = 0;
      for (var i = 0; i < count_check_multi + 1; i++) {
        var result = '#customerpaymentmulticheck-';
        var input_amount = ($(result + i + "-check_amount").val());
        final_amount = +final_amount + +convertStrToFloat(input_amount);
      }

      for (var i = 0; i < count_check_other + 1; i++) {
        var result = '#customerpaymentmultpleother-';
        var input_amount = ($(result + i + "-amount").val());
        input_amount = convertStrToFloat(input_amount);
        final_amount = +final_amount + +input_amount;
      }
      final_amount = convertStrToFloat(final_amount);


        check_total_amount = final_amount;

        $('#customerpayment-amount').val(final_amount);
        $('#customerpayment-amount_temp').val(final_amount);
        calculate();

    }

    function calculate_amount_multi_label(id, val) {
      if (id != '') {
        var amount_id = id.slice(0, -5);
        var total = val.replace(/[^\d.-]/g, '');
        $("#" + amount_id).val(total);
      }
      var final_amount = 0;

      for (var i = 0; i < count_check_multi + 1; i++) {
        var result = '#customerpaymentmulticheck-';
        var input_amount = ($(result + i + "-check_amount").val());
        final_amount = +final_amount + +convertStrToFloat(input_amount);
      }

      for (var i = 0; i < count_check_other + 1; i++) {
        var result = '#customerpaymentmultpleother-';
        var input_amount = ($(result + i + "-amount").val());
        final_amount = +final_amount + +convertStrToFloat(input_amount);
      }
      //alert(final_amount);
      final_amount = convertStrToFloat(final_amount);
      $('#multi_amount_span').html(formatConvert(final_amount));

    }


    function veiwpopup() {
      $('.sidebar-modal .tab-content').html('');
      saved_flag = true;
      var id = $('#customerpayment-customer_id').val();
      var type = 'C';
      var code = '';

      $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=customer/viewpopup' ?>',
        type: 'get',
        data: {ID: id, BUSINESS_PARTNER_TYPE: type, COMPANY_CODE: code},
        beforeSend: function () {
          $(".overlay").show();
        },
        complete: function () {
          $(".overlay").hide();
        },
        success: function (data) {
          $('.sidebar-modal .tab-content').html(data);
          $(".sidebar-modal").show('slide');
          $(".overlay-back").show();
        },
        error: function (jqXhr, textStatus, errorThrown) {
          // alert(errorThrown);
          if (errorThrown == 'Forbidden') {
            alert(you_dont_have_access_label);
          }
        }
      });
    }

    function check_details_validation() {
      var html = "";
      var final_amount = 0;
      for (var i = 0; i <= count_check; i++) {
        var check_no = $('#customerpaymentcheck-' + i + '-check_no').val();
        var check_status = $('#customerpaymentcheck-' + i + '-check_status').val();
        var check_amount = $('#customerpaymentcheck-' + i + '-check_amount').val();
        var bank_account = $('#customerpaymentcheck-' + i + '-bank_account').val();
        var check_date = $('#customerpaymentcheck-' + i + '-check_date').val();
        final_amount = +final_amount + +check_amount;
        final_amount = convertStrToFloat(final_amount);
        if (check_status == '') {
          html += "#" + (i + 1) + ' Select Check Status.<br>';
        }
        if (check_no == '') {
          html += "#" + (i + 1) + ' Enter Check No.<br>';
        }
        if (check_date == '') {
          html += "#" + (i + 1) + ' Select Check Date <br>';
        }
        if (check_amount == '') {
          html += "#" + (i + 1) + ' Enter Check Amount <br>';
        }
        if (bank_account == '') {
          html += "#" + (i + 1) + ' Select Bank Account <br>';
        }
      }

      if (html != '') {
        $(".error-summary-check").show();
        $("#error_display_check").html(html);
      } else {
        $('#pModal_check').modal('hide');
        $(".error-summary-check").hide();
      }
      calculate_amount('', '');
    }

    function bounce_check_validation() {
      var html = "";
      var final_amount = 0;
      $('.bounce_checkbox:checked').each(function (i) {
        final_amount = +final_amount + +$(this).val();
      });
      $('#payment_check_return').modal('hide');
      final_amount = convertStrToFloat(final_amount);
      $('#customerpayment-amount').val(convertStrToFloat(final_amount));
      $('#customerpayment-amount_temp').val(formatConvert(convertStrToFloat(final_amount)));
    }


    function check_details_validation_other() {

      var html = "";
      var final_amount = 0;
      for (var i = 0; i <= count_check_other; i++) {
        var payment_mode = $('#customerpaymentmultpleother-' + i + '-payment_mode').val();
        var check_amount = $('#customerpaymentmultpleother-' + i + '-amount').val();
        if (payment_mode == 1) {
          var bank_account = $('#customerpaymentmultpleother-' + i + '-cash_gl').val();
        } else {
          var bank_account = $('#customerpaymentmultpleother-' + i + '-gl_account').val();
        }
        var check_date = $('#customerpaymentmultpleother-' + i + '-check_date').val();
        if (payment_mode != '' || check_amount != '' || bank_account != '') {
          final_amount = +final_amount + +check_amount;
          if (payment_mode == '') {
            html += "#" + (i + 1) + '(Other) Enter Payment Mode.<br>';
          }

          if (check_amount == '') {
            html += "#" + (i + 1) + '(Other) Enter Amount <br>';
          }
          if (bank_account == '') {
            html += "#" + (i + 1) + '(Other) Select GL Account <br>';
          }
        }
      }

      for (var i = 0; i <= count_check_multi; i++) {
        var check_status = $('#customerpaymentmulticheck-' + i + '-check_status').val();
        var check_no = $('#customerpaymentmulticheck-' + i + '-check_no').val();
        var check_amount = $('#customerpaymentmulticheck-' + i + '-check_amount').val();
        var bank_account = $('#customerpaymentmulticheck-' + i + '-bank_account').val();
        var check_date = $('#customerpaymentmulticheck-' + i + '-check_date').val();
        if (check_status != '' || check_no != '' || check_amount != '' || bank_account != '') {
          final_amount = +final_amount + +check_amount;
          if (check_status == '') {
            html += "#" + (i + 1) + '(Cheque) Select Check Status.<br>';
          }
          if (check_no == '') {
            html += "#" + (i + 1) + '(Cheque) Enter Check No.<br>';
          }
          if (check_date == '') {
            html += "#" + (i + 1) + '(Cheque) Select Check Date <br>';
          }
          if (check_amount == '') {
            html += "#" + (i + 1) + '(Cheque) Enter Check Amount <br>';
          }
          if (bank_account == '') {
            html += "#" + (i + 1) + '(Cheque) Select Bank Account <br>';
          }
        }
      }

      if (html != '') {
        $(".error-summary-check-other").show();
        $("#error_display_check_other").html(html);
      } else {
        $('#paymentMultipleOther').modal('hide');
        $(".error-summary-check-other").hide();
      }
      calculate_amount_multi();
    }

    function format_amount(id, val) {
      setTimeout(function () {
        val = $("#" + id).val();
        new Cleave("#" + id, {
          prefix: '',
          numeral: true,
          numeralThousandsGroupStyle: 'thousand',
          numeralDecimalScale: netPricePrecisionPlace
        });
        value = ($("#customerpayment-amount_temp").val()).replace(/[^\d.-]/g, '');
        $("#customerpayment-amount").val(value);
        //calculate();
        value = value * convertStrToFloat($("#customerpayment-exchange_rate").val());
        $("#customerpayment-amount_received").val(convertStrToFloat(value));
        $("#customerpayment-amount_received_temp").val(formatConvert(convertStrToFloat(value)));
        calculateTotalAll();
        if ($("#customerpayment-payment_category").val() == 'PARTIAL') {
        var bill_doc = $("input:radio[name='CustomerPayment[BILLING_DOC_NO]']:checked").val();
        if (bill_doc != '') {
          partial_pay_check(bill_doc);
        }
      }

      }, 10);
    }

    function multiPayment(check_flag) {
      //alert()
      // $("#customerpayment-payment_method").val("").trigger('change');
      $("#customerpayment-cash_gl").val("").trigger('change');
      $("#customerpayment-gl_account").val("").trigger('change');
      if (check_flag) {
        clear_check_modal();
        $("#multi_not").hide();
        $(".show_on_multi").show();
        $("#customerpayment-payment_method").val(8).trigger('change');
      } else {
        $("#multi_not").show();
        $(".show_on_multi").hide();
        $("#customerpayment-payment_method").val("").trigger('change');
      }
    }

    function show_multi_data() {
      //paymentMultipleOther
      $(".error-summary-check-other").hide();
      //$(".error-summary-check-multi").hide();
      $('#paymentMultipleOther').modal('show');
      //alert("ff")
    }

    function format_advance_payment(id, val) {
      var n = id.lastIndexOf('-');
      var amount = id.substring(0, n + 1) + 'downpayment_amount';
      var total = val.replace(/[^\d.-]/g, '');
      $("#" + amount).val(total);
      calculateTotalAll();
    }

    function calculateTotalAll() {
      var journal_total = convertStrToFloat($("#journal_total_local").val());
      var billing_total = convertStrToFloat($("#billing_total_main").val());
      var credit_total = convertStrToFloat($("#credit_total").val());
      var total_ret = convertStrToFloat($("#return_payment_total").val());

      var received_invoice = 0;

      var advance_payment_amt = 0;
      var return_reverse_flag =0;
      var payment_cat_val = $('#customerpayment-payment_category').val();
      if(payment_cat_val=='RET'){
        return_reverse_flag=1;
      }

      if (payment_cat_val == "MULTIPLE_SETTELMENT" || payment_cat_val == "FINAL") {
        if (advance_payment_flag == 1) {
          var advance_payment_amt = $('#customerpayment-downpayment_amount').val();
          if (advance_payment_amt != '') {
            advance_payment_amt = convertStrToFloat(advance_payment_amt) * convertStrToFloat($("#customerpayment-exchange_rate").val());
            advance_payment_amt = convertStrToFloat(advance_payment_amt);
          }
        }
      }

      if ($("#payment_total_local").length) {
        var payment_total_local = convertStrToFloat($("#payment_total_local").val());
        var deposit_payment_total_local = convertStrToFloat($("#deposit_payment_total_local").val());
        received_invoice = convertStrToFloat(+payment_total_local + +deposit_payment_total_local);
      }
      received_invoice = convertStrToFloat(received_invoice);


      var received = $("#customerpayment-amount").val() * $("#customerpayment-exchange_rate").val();
      if (return_reverse_flag == 1) {
        received = received * -1;
      }
      received = convertStrToFloat(received);

      var fin_total = convertStrToFloat(journal_total + billing_total + advance_payment_amt - received_invoice - received + total_ret + credit_total);
      var rec_total = convertStrToFloat(journal_total + billing_total + advance_payment_amt - received_invoice + total_ret + credit_total);
      var total_last_loc = convertStrToFloat(billing_total + total_ret + journal_total + credit_total);

      if (return_reverse_flag == 1) {
        fin_total = fin_total * -1;
        rec_total = rec_total * -1;
        total_last_loc = total_last_loc * -1;
      }

      $("#customerpayment-difference").val(fin_total);
      $("#customerpayment-amount_applied").val(rec_total);
      $("#customerpayment-difference_temp").val(formatConvert(fin_total));
      $("#customerpayment-amount_applied_temp").val(formatConvert(rec_total));
      $("#total_last_local").val(total_last_loc);

      //settlements total
      var billing_set_tot = $("#total_invoice_settlement").val();
      var ret_cre_set_tot = $("#total_credit_note_settlement").val();
      var dow_pay_set_tot = $("#total_downpayment_settlement").val();
      var dep_set_tot = $("#total_deposit_settlement").val();
      var jv_set_tot = $("#total_jv_settlement").val();
      total_settlement = +billing_set_tot + +ret_cre_set_tot + +jv_set_tot - dow_pay_set_tot - dep_set_tot;
      if (return_reverse_flag == 1) {
        total_settlement = total_settlement * -1;
      }
      $("#settlement_total").html(formatConvert(convertStrToFloat(total_settlement)));

      //need confirmation
      /*if ((fin_total) == 0) {
        $('#save_btn_form').prop('disabled', false);
      } else {
        $('#save_btn_form').prop('disabled', true);
      }*/
    }

    function clearAllValues() {
      $("#invoice_outstanding").html(formatConvert(0));
      $("#credit_note_outstanding").html(formatConvert(0));
      $("#downpayment_outstanding").html(formatConvert(0));
      $("#deposit_outstanding").html(formatConvert(0));
      $("#jv_outstanding").html(formatConvert(0));

      $("#invoice_subtotal").html(formatConvert(0));
      $("#credit_note_subtotal").html(formatConvert(0));
      $("#downpayment_subtotal").html(formatConvert(0));
      $("#deposit_subtotal").html(formatConvert(0));
      $("#jv_subtotal").html(formatConvert(0));

      $("#outstanding_total").html(formatConvert(0));
      $("#settlement_total").html(formatConvert(0));

      $("#total_invoice_outstanding").val(0);
      $("#total_credit_note_outstanding").val(0);
      $("#total_downpayment_outstanding").val(0);
      $("#total_deposit_outstanding").val(0);
      $("#total_jv_outstanding").val(0);
      $("#customerpayment-amount_received_temp").val(0);
      $("#customerpayment-amount_received").val(0);

      $("#total_invoice_settlement").val(0);
      $("#total_credit_note_settlement").val(0);
      $("#total_downpayment_settlement").val(0);
      $("#total_deposit_settlement").val(0);
      $("#total_jv_settlement").val(0);
    }
  </script>