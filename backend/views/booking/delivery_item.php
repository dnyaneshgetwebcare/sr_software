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
$temp_header = ($item_status == 'Picked') ? 'Delivery Item' : 'Return Item';
$this->title = $temp_header . ' of Order #' . $_GET['id'];
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
.form-group:has(input[type="hidden"]) {
    display: none;
}
    /*  .table-bordered>tbody>tr>td,.table-bordered>thead>tr>th{
  border:1px solid #eee !important;
 }*/
    input[type="date"].form-control {
        line-height: 24px;
    }

    .form-group {
        margin-bottom: 0px;
    }
 .form-control {
        font-size: 15px;
        font-weight: 500;
        line-height: 1.5 !important;
        padding: 5px !important;
    }

    .control-label, .form-control {
        font-size: 14px;
        font-weight: 400;
    }

    td, th {
        font-size: 12px;
    }
</style>
<div class="booking-header-index">
    <div class="row page-titles">

        <div class="col-md-6 col-6 align-self-center">

            <h3 class="text-themecolor m-b-0 m-t-0">
              <a href="index.php?r=booking%2Fupdate&id=<?= $booking_id ?>"
                                                       tag="Go to order""><?= Html::encode($this->title) ?>
              </a>
            </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Sales</a></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </div>
      <div class="col-md-5 col-5 align-self-center">
        <span> <label>Customer Name: </label> <?= $customer_master['name']; ?></span> <br>
        <span> <label>Contact Name: </label> <?= $customer_master['contact_nos']; ?></span>
      </div>
      <div class="col-md-1 col-1 align-self-center">
        <button class="btn btn-secondary btn-border" onclick="sendwhatsapp('<?= "91".$customer_master['contact_nos']
        ?>', '<?= $item_status; ?>', )">
          <i class="fab fa-whatsapp"></i>
        </button>
        <?php if($item_status != 'Picked'):
            $whatsapp_nos = ($model->gpay_number == "") ? $customer_master['contact_nos']: $model->gpay_number;
            ?>
        <button class="btn btn-info btn-border mt-2" onclick="sendCustomerDetailsWhatsapp('<?= $customer_master['name']; ?>', '<?= $whatsapp_nos; ?>', '<?= $model->deposite_amount - ($model->other_charges + $model->refunded); ?>')">
          <i class="fab fa-whatsapp"></i> Rtr. Dep.
        </button>
        <?php endif; ?>
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

    $form = ActiveForm::begin(['enableClientValidation' => false, 'action' => Url::to(['booking/delivery-item']), 'id' => 'booking_header_form', 'options' => ['class' => 'disable-submit-buttons', 'onSubmit' => 'return clientShowLoader()']]);
    ?>

    <div class="row">
        <div class="card col-lg-12">

            <div class="card-body">
                <div class="error-summary error-summary-sales custom-errors" id="errors_test1" style="display: none;">
                    <p><i class="fa fa-close pull-right" onclick="$(&quot;#errors_test1&quot;).hide()"></i><h5><b><i
                                    class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b></h5></p>
                    <hr class="custom_error_hr">
                    <div id="error_display_sales" class="custom_error"></div>
                </div>

                <input type="hidden" name="item_status" value="<?= $item_status ?>">
                <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                <input type="hidden" name="updated_time_temp" value="<?= $model->updated_time ?>">

                <div class="row show_vendor_data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="control-label text-left col-md-1" style="padding-right: 0px !important">Date</label>
                                <div class="col-md-3">
                                    <?php //$posting_date=date('d-m-Y');
                                    echo DatePicker::widget([
                                        'id' => 'posting_date',
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
                                                'autoclose' => true,
                                                'format' => 'dd-mm-yyyy'
                                            ]
                                    ]); ?>
                                </div>
                                <label class="control-label text-left col-md-1" style="padding-right: 0px !important; padding-left: 15px;">GPay Nos.</label>
                                <div class="col-md-3">
                                    <?php echo $form->field($model, 'gpay_number')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Enter GPay Number', 'autocomplete' => "off"])->label(false); ?>
                                </div>
                              <label class="col-md-3"> Remark: <span style="font-weight: 400"><?= $model->remark; ?>
                                </span><br>
                               Measurment: <span style="font-weight: 400">  <?php if($model->chest !="" || $model->waist !="" || $model->hip
                                    !=""){
                                  echo "C: ".$model->chest
                                    .", W: ".$model->waist
                                    .", H: ".$model->hip;
                                }
                                ?>
                                </span>
                              </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="div-hr">

                <div class="row" style="margin-top: 10px">

                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            // 'filterModel' => $searchModel,
                            'tableOptions' => ['class' => 'display nowrap table table-hover color-bordered-table muted-bordered-table table-striped table-bordered'],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function ($model) {
                                    return ['value' => $model->item_id, 'class' => 'check item_list', 'checked' => true, 'readonly' => true, 'data-checkbox' => "icheckbox_square-red"];
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
                                    'value' => function ($data) {
                                        return '<a class="image-popup-vertical-fit" href="' . $data->item->imageurl . '">' . Html::img($data->item->imageurl, ['width' => '100', 'height' => '80']) . '</a>';
                                    },

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

                                 'note:ntext',
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
                        <h1><b>
                                <center>
                                    <div id="display_pending" style="background-color: #c4ecba">Amount: 0</div>
                                </center>
                            </b></h1>
                    </div>
                  <div class="col-md-6 pull-right" style="display: <?= ($item_status=='Picked')?'None':'Block' ?>">
                        <h1><b>
                                <center>
                                    <div id="deposit_pending" style="background-color: #b4daf1">Balance DP Amt:
                                      <?= $model->deposite_amount - ($model->other_charges + $model->refunded + $model->deposit_adjustment)
                                      ?></div>
                                </center>
                            </b></h1>
                    </div>
                </div>
                <div class="col-md-6 number" style="margin-top: 3px; display: none">

                    <input type="text" name="BookingHeader[net_value]" value="<?= $model->net_value ?>"
                           class="form-control total" style="border:none;background: none !important;" readonly
                           id="sub_total">
                </div>
                <div class="col-md-6 number" style="display: none">
                    <input type="text" name="BookingHeader[deposite_amount]" value="<?= $model->deposite_amount ?>"
                           class="form-control total" style="border:none;background: none !important;" readonly
                           id="total_deposite_amount">
                </div>


                <div class="col-lg-12" id="sales_items_tab_payment"
                     style="margin-top: 10px;padding-left: 0px;padding-right: 0px;">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper_payment',
                        'widgetBody' => '.container-items-payment',
                        'widgetItem' => '.payment-item',
                        'limit' => 25,
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
                            <th style="width: 8%">Date</th>
                            <th style="width: 15%">Remark</th>
                            <th style="width: 14%">Type</th>
                            <th style="width: 14%">Mode</th>
                            <th style="width: 14%">Recived By</th>
                            <th style="width: 14%">Recived In</th>
                            <th style="width: 14%">During</th>
                            <th style="width: 10%">Amount</th>
                            <!--<th style="width: 450px;">Quantity</th>-->
                            <th class="text-center" style="width: 3%;">
                                <button type="button" onclick="addPaymentitem()"
                                " class="add-payment btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="container-items-payment">
                        <?php
                        $array1 = [new PaymentMaster()];
                        $payment_models = array_merge($array1, $payment_models);
                        $count_item_payment = count($payment_models);
                        $sub_total = 0;
                        $payment_cancel_charge  = 0;
                        $readonly_flag = true;
                        $payment_type = ['Advance'
                                    => 'Advance', 'Per-payment' => 'Per-payment', 'Final-Payment' => 'Final-Payment',
                                      'Return-Deposit' => 'Return-Deposit', 'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges', 'Return-Payment' => 'Return-Payment'];
                        foreach ($payment_models as $indexHouse => $payment_model):
                            $active_div = ($model->booking_id != '' && $indexHouse != 0) ? '' : 'display:none;';
                            $payment_model['date'] = ($payment_model['date'] == "") ? date('Y-m-d') : $payment_model['date'];
                            $readonly_flag = ($indexHouse != 0);
                            if($payment_model["type"] == "Cancel-Charge"){
                                $payment_cancel_charge += $payment_model["amount"];
                            }

                            $during = ($indexHouse != 0)?['Booking' => 'Booking', 'Pickup' => 'Pickup', 'Return' => 'Return', 'Other' => 'Other']: ['Pickup' => 'Pickup'];
                            if($indexHouse != 0){
                               $payment_type = ['Advance'
                                    => 'Advance', 'Per-payment' => 'Per-payment', 'Final-Payment' => 'Final-Payment',
                                      'Return-Deposit' => 'Return-Deposit', 'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges', 'Return-Payment' => 'Return-Payment'];
                               $during = ['Booking' => 'Booking', 'Pickup' => 'Pickup', 'Return' => 'Return', 'Other'
                               => 'Other'];
                            }else{
                              if($item_status == 'Picked'){
                                $payment_type = ['Final-Payment' => 'Final-Payment', 'Advance'
                                    => 'Advance', 'Per-payment' => 'Per-payment',
                                      'Return-Deposit' => 'Return-Deposit', 'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges', 'Return-Payment' => 'Return-Payment'];
                                $during = ['Pickup' => 'Pickup'];
                              }else {
                                $payment_type = ['Return-Deposit' => 'Return-Deposit', 'Final-Payment' => 'Final-Payment', 'Advance' => 'Advance', 'Per-payment' => 'Per-payment',
                                      'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges', 'Return-Payment' => 'Return-Payment'];
                                $during = ['Return' => 'Return'];
                              }


                            }

                            ?>
                            <tr class="payment-item" id='<?php echo "paymentmaster-{$indexHouse}-test"; ?>'>
                                <td id='<?php echo "paymentmaster-{$indexHouse}-tax_new_id"; ?>'
                                    style="text-align: center;vertical-align: middle !important;">

                                    <?php 
                                    // Calculate min date (3 days ago) and max date (today)
                                    $minDate = date('Y-m-d', strtotime('-3 days'));
                                    $maxDate = date('Y-m-d');
                                    ?>
                                    <input type="date" name="<?php echo "PaymentMaster[{$indexHouse}][date]" ?>"
                                           id='<?php echo "paymentmaster-{$indexHouse}-date" ?>'
                                           class="valid_till_date form-control payment-date-input" <?= ($readonly_flag)? 'readonly':'';  ?>
                                           min="<?php echo $minDate; ?>"
                                           max="<?php echo $maxDate; ?>"
                                           value="<?php echo $payment_model['date']; ?>"
                                           style="width: 150px!important ">
                                    <?= $form->field($payment_model, "[{$indexHouse}]payment_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                             </td>
                                <td>
                                    <?= $form->field($payment_model, "[{$indexHouse}]remark")->label(false)
                                      ->textInput(['maxlength' => true, 'placeholder' => 'Remark','readonly' =>
                                        $readonly_flag]) ?>
                                    <?= $form->field($payment_model, "[{$indexHouse}]booking_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>

                                </td>

                                <td>
                                    <?= $form->field($payment_model, "[{$indexHouse}]type")->dropDownList
                                    ($payment_type ,
                                      ['options' => ['style' => 'font-size:8px;'], 'onchange' => 'check_payment_type(this);  add_total_payment()', 'readonly' => $readonly_flag])->label(false) ?>

                                </td>
                                <td>

                                    <?php
                                    $option_array = ($payment_model->type == 'Cancel-Charge' || $payment_model->type == 'Other-Charges') ? ['Deposit' => 'Deposit'] : ['Cash' => 'Cash', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other',];

                                    echo $form->field($payment_model, "[{$indexHouse}]mode_of_payment")->dropDownList
                                    ($option_array, [ 'readonly' => $readonly_flag,'prompt' => 'Select Payment Mode'])
                                      ->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($payment_model, "[{$indexHouse}]received_by")->dropDownList(['Varsha' => 'Varsha',  'Others' => 'Others',],[ 'readonly' => $readonly_flag])->label(false) ?>
                                </td>

                                <td>

                                    <?= $form->field($payment_model, "[{$indexHouse}]sendto")->dropDownList(['Company' => 'Company',  'Varsha' => 'Varsha',],[ 'readonly' => $readonly_flag])->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($payment_model, "[{$indexHouse}]received_during")->dropDownList
                                    ($during ,[ 'readonly' => $readonly_flag])->label(false) ?>
                                </td>
                                <td>
                                    <?= $form->field($payment_model, "[{$indexHouse}]amount")->label(false)
                                      ->textInput(['maxlength' => true, 'onkeyup' => 'add_total_payment(this.id)', 'placeholder' => '0.00',  'readonly' => $readonly_flag, 'style' => 'text-align: right']) ?>
                                </td>


                                <td class="text-center vcenter" style="verti">
                                    <button type="button" class="remove-payment btn btn-danger btn-xs"
                                            onclick="removePaymentitem()"><span class="fa fa-minus"></span></button>
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
                                            <input type="text" name="BookingHeader[paid_amount]"
                                                   value="<?= ($model->paid_amount == '' ? 0 : $model->paid_amount) ?>"
                                                   class="form-control total"
                                                   style="border:none;background: none !important; text-align: right;" readonly
                                                   id="paid_amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                    <div class="form-group col-12">
                                        <label class="col-md-6 control-label"> Pending </label>
                                        <div class="col-md-6 number">
                                            <input type="text" name="BookingHeader[pending_amount]"
                                                   value="<?= ($model->net_value - $model->deposit_adjustment) - ($model->paid_amount - $payment_cancel_charge) ?>"
                                                   class="form-control total"
                                                   style="border:none;background: none !important;text-align: right; " readonly;
                                                   id="pending_amount">
                                        </div>
                                    </div>
                                </div>


                                <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                    <div class="form-group col-12">
                                        <label class="col-md-6 control-label"> Return </label>
                                        <div class="col-md-6 number">
                                            <input type="text" name="BookingHeader[return_amount]"
                                                   value="<?= $model->return_amount; ?>" class="form-control total"
                                                   style="border:none;background: none !important; text-align: right;" readonly
                                                   id="return_amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                    <div class="form-group col-12">
                                        <label class="col-md-6 control-label"> Cancel Charge </label>
                                        <div class="col-md-6 number">
                                            <input type="text" name="BookingHeader[cancellation_charges]"
                                                   value="<?= $model->cancellation_charges ?>"
                                                   class="form-control total"
                                                   style="border:none;background: none !important; text-align: right;" readonly
                                                   id="cancellation_charges">
                                        </div>
                                    </div>
                                </div>


                                <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                    <div class="form-group col-12">
                                        <label class="col-md-9 control-label"> Adjst Cancel Charge with Deposit </label>
                                        <div class="col-md-3 number">
                                            <input type="text" name="BookingHeader[deposit_adjustment]"
                                                   value="<?= isset($model->deposit_adjustment) ? $model->deposit_adjustment : '0' ?>"
                                                   class="form-control total"
                                                   placeholder="Out of <?= $model->cancellation_charges ?>"
                                                   style="text-align: right;"  onkeyup="add_total_payment()"
                                                   id="deposit_adjustment">

                                        </div>
                                    </div>
                                </div>


                                <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                    <div class="form-group col-12">
                                        <label class="col-md-6 control-label"> Other Charge </label>
                                        <div class="col-md-6 number">
                                            <input type="text" name="BookingHeader[other_charges]"
                                                   value="<?= $model->other_charges ?>" class="form-control total"
                                                   style="border:none;background: none !important; text-align: right;" readonly
                                                   id="other_charges">
                                        </div>
                                    </div>
                                </div>
                                <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                    <div class="form-group col-12">
                                        <label class="col-md-6 control-label" style="text-wrap: auto;"> (Refund +
                                          Charges) /
                                          Deposite
                                        </label>
                                        <div class="col-md-6 number">
                                            <input type="text"
                                                   value="<?= ($model->refunded + $model->other_charges +$model->deposit_adjustment ). '/' .
                                                   $model->deposite_amount ?>"
                                                   class="form-control total"
                                                   style="border:none;background: none !important; text-align: right;" readonly
                                                   id="refund_dis">

                                        </div>
                                    </div>
                                </div>
                               <input type="hidden" name="BookingHeader[refunded]"
                                                   value="<?= ($model->refunded == '' ? 0 : $model->refunded) ?>"
                                                   class="form-control total"
                                                   style="border:none;background: none !important; text-align: right;" readonly
                                                   id="refunded">
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
                <button type="button"
                        onclick="submitForm()" <?= ($model->order_status == 'Closed') ? 'disabled' : ''; ?>
                        class="btn btn-info save_submit" data-toggle="tooltip" data-original-title=<?= 'SAVE' ?>><img
                            src="img/icons/save.png" style="height:12px"> <?= 'SAVE' ?></button>
                <button type="button" class="btn btn-warning btn-cancel-back-new" data-toggle="tooltip"
                        data-original-title=<?= 'CANCEL' ?>><?= 'CANCEL' ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

    var count_item_payment = "<?= $count_item_payment;?>";

    function submitForm() {
        
        // Check pending amount before submitting
        var pending_amount = parseFloat($("#pending_amount").val()) || 0;
        
        if (pending_amount > 0) {
            swal({
                title: "Payment Pending",
                text: "Pending amount is ₹" + pending_amount.toFixed(2) + ". Are you sure you want to proceed without completing the payment?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-secondary",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Proceed Anyway",
                        value: true,
                        visible: true,
                        className: "btn btn-warning",
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((willProceed) => {
                if (willProceed) {
                    // User chose to proceed, submit the form
                    submitFormAjax();
                }
                // If user cancels, do nothing
            });
            return false;
        }

        // If no pending amount, submit directly
        submitFormAjax();
    }

    function submitFormAjax() {
        // alert($('#booking_header_form').attr('action'));

        $.ajax({
            url: $('#booking_header_form').attr('action'),
            type: 'post',
            dataType: 'json',
            data: $("#booking_header_form").serialize(),
            beforeSend: function () {
                $(".overlay").show();
            },
            complete: function () {
                $(".overlay").hide();

            },
            success: function (data) {
                // console.log(data)
                $('.form-control').removeClass("errors_color");
                var html = "";
                var cleaned = removeDuplicates(data['errors']);

                // console.log(cleaned);
                for (var key in data['errors']) {
                    $('#' + key).addClass("errors_color");
                }
                for (var key in cleaned) {
                    html += key + "<br>";
                }
                $("html, body").animate({scrollTop: 0}, "slow");
                if (html != '') {
                    test_submit = 0;
                    $(".error-summary-sales").show();
                    $("#error_display_sales").html(html);
                } else {
                    $(".error-summary-sales").hide();
                    location.reload();
                }
                $('#redirect_saved_changes').hide();

            },
            error: function (jqXhr, textStatus, errorThrown) {
                //  alert(errorThrown);
                test_submit = 1;
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });


        // wait(3000);
        //test_submit=0;


    }
    function check_payment_type(el) {
        let payment_type = $(el).val();

        if (payment_type == "Cancel-Charge") {
            swal({
                title: "Option Deactivated",
                text: "This functionality is disabled now use item cancel option to cancel item",
                icon: "warning",
            });
        }
    }
    function back_click() {
        window.location.href = "<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/update&id=' . $_GET['id'] ?>";
    }

    function removeDuplicates(json_all) {
        var arr = [];
        $.each(json_all, function (index, value) {
            arr[value] = (value);
        });
        return arr;
    }

    function add_total_payment() {
        var paid_amount = 0;
        var refund = 0;
        var return_amount = 0;
        var cancellation_charges = 0;
        var other_charges = 0;
        var comman_option = '<option value="Cash" selected="">Cash</option><option value="Google Pay">Google Pay</option><option value="Phone Pe">Phone Pe</option><option value="Bank Transfer">Bank Transfer</option><option value="Paytm">Paytm</option><option value="Other">Other</option>';
        var deposite_option = '<option value="Deposit" selected="">Deposit</option>';
        for (i = 0; i < count_item_payment; i++) {
            var amount_val = $("#paymentmaster-" + i + "-amount").val();
            var type_payment = $("#paymentmaster-" + i + "-type").val();

            if (type_payment == "Return-Deposit") {
                refund = +refund + +Number(amount_val);
            } else if (type_payment == "Cancel-Charge") {
                cancellation_charges = +cancellation_charges + +Number(amount_val);
                //paid_amount=+paid_amount + +Number(amount_val);
            } else if (type_payment == "Return-Payment") {
                return_amount = +return_amount + +Number(amount_val);
                paid_amount = +paid_amount - +Number(amount_val);
            } else if (type_payment == "Other-Charges") {
                other_charges = +other_charges + +Number(amount_val);
                // paid_amount=+paid_amount + +Number(amount_val);
            } else {
                paid_amount = +paid_amount + +Number(amount_val);
            }

            if (type_payment == "Cancel-Charge" || type_payment == "Other-Charges") {

                $("#paymentmaster-" + i + "-mode_of_payment").empty().append(deposite_option);
            } else {
                if ($("#paymentmaster-" + i + "-mode_of_payment").val() == 'Deposit') {
                    $("#paymentmaster-" + i + "-mode_of_payment").empty().append(comman_option);
                }
            }
        }
        let deposite_adjustment = other_charges + refund;
        var net_value = Number($("#sub_total").val());
        var deposit_amount = $("#total_deposite_amount").val()
        var deposit_adjsted_amount = Number($("#deposit_adjustment").val());
        let can_charge = $("#cancellation_charges").val();
        if(deposit_adjsted_amount > can_charge){
            deposit_adjsted_amount = 0;
            $("#deposit_adjustment").val(0).select();
            swal(`Adjustment cannot be greater that ${can_charge}`);
        }
        $("#return_amount").val(return_amount);
        //$("#cancellation_charges").val(cancellation_charges);
        $("#other_charges").val(other_charges);
        $("#paid_amount").val(paid_amount);
        $("#pending_amount").val(net_value - ((paid_amount +deposit_adjsted_amount) - cancellation_charges));
        $("#display_pending").html("Amount: " + $("#pending_amount").val());
        $("#deposit_pending").html(`Balance DP Amt: ${deposit_amount-deposite_adjustment-deposit_adjsted_amount}`);
        $("#refunded").val(refund);
        $("#refund_dis").val((deposite_adjustment + deposit_adjsted_amount) + '/' + deposit_amount);
    }

    $(document).ready(function () {

        $("#display_pending").html("Amount: " + $("#pending_amount").val());

        $("#paymentmaster-0-test").hide();


        $('.item_details_lable .glyphicon-remove').unbind().click(function () {

            removeRow($(this));
            //$(this).closest('.temp_change_item').();
            // $(this).closest('td.other_quantity').hide();
            //  $('.name_input_field').show();
        });
        $('.item_details_lable .glyphicon-pencil').unbind().click(function () {
            updateItemRow($(this));
        });


    });

    function addPaymentitem() {
        count_item_payment++;
        $("#sales_items_tab_payment .dynamicform_wrapper_payment").on("afterInsert", function (e, item) {


        });
    }


    function removePaymentitem() {
        saved_flag = true;
        /* if (count_item==2) {
          flushdata('');
         }*/
        if (count_item_payment > 2) {
            count_item_payment = count_item_payment - 1;
            //  count_item_sr=count_item_sr-1;
        }
        jQuery("#sales_items_tab_payment .dynamicform_wrapper_payment").on("afterDelete", function (e, item) {

            //add();
            add_total_payment('');
        });
    }
    function sendwhatsapp(contact_nos, ord_status) {
      let pickup_message = "Your outfits are packed and ready for pickup. Please collect them before 7:30 PM."
      if(ord_status != "Picked"){
          pickup_message  = "Please return item before 7.30 PM to avoid late charges";
      }
       var message = encodeURI(pickup_message);
        // window.open('https://api.whatsapp.com/send/?phone='+data["contact_nos"]+'&text='+message, '_blank').focus();
        window.open('https://web.whatsapp.com/send/?phone=' + contact_nos + '&text=' + message, '_blank').focus();
    }

    function sendCustomerDetailsWhatsapp(customer_name, contact_nos, deposite_amount) {
        var message = customer_name + "\n" + contact_nos + "\n" + deposite_amount;
        var encodedMessage = encodeURI(message);
        window.open('https://web.whatsapp.com/send/?phone=918237703030&text=' + encodedMessage, '_blank').focus();
    }

    // Payment date validation - Allow only current date or past 3 days
    $(document).on('change', '.payment-date-input', function() {
        var selectedDate = new Date($(this).val());
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        
        var threeDaysAgo = new Date();
        threeDaysAgo.setDate(threeDaysAgo.getDate() - 3);
        threeDaysAgo.setHours(0, 0, 0, 0);
        
        if (selectedDate > today) {
            swal({
                title: "Invalid Date",
                text: "Payment date cannot be in the future. Please select today's date or a past date (up to 3 days ago).",
                icon: "error",
                button: "OK",
            });
            $(this).val('<?php echo date('Y-m-d'); ?>');
        } else if (selectedDate < threeDaysAgo) {
            swal({
                title: "Invalid Date",
                text: "Payment date cannot be more than 3 days in the past. Please select a date within the last 3 days.",
                icon: "error",
                button: "OK",
            });
            $(this).val('<?php echo date('Y-m-d'); ?>');
        }
    });

</script>