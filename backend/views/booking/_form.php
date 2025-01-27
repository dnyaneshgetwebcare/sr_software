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
use kartik\select2\Select2;

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

    .page-titles {
        margin-bottom: 10px !important;
    }

    .form-control {
        font-size: 15px;
        font-weight: 500;
    }

    th {
        font-size: 15px;
    }

    .customtab2 li a.nav-link.active {
        background-color: #fc4b6c;
    }

    .control-label {
        font-size: small;
        font-weight: 500;
    }

    .dropdown-item {
        font-size: 15px;
    }

    .panel {
        margin-bottom: 0px !important;
    }

    .list-main-tab .list-main-tab-heading {
        padding: 0px !important;
        background: #fff !important;
        /*  box-shadow: 0px 1px 2px #a5a0a0 !important;*/
        border-bottom: 2px solid #aaa !important;
    }

    .nav-pills li > a:hover {
        background: #eee !important;
        color: #000 !important;
        border-bottom: 2px solid #eee;
    }

    .nav-pills > li.active > a {
        background: none !important;
        color: #4285f4 !important;
        border-bottom: 2px solid #4285f4;
    }

    .nav-pills > li.active > a:hover {
        background-color: #f8f8f8 !important;
    }

    .nav-pills > li > a {
        border-radius: 0px;
        padding: 6px 16px 6px 16px !important;
        font-size: 12px;
        font-family: 'Roboto', sans-serif;
        text-transform: uppercase;
        font-weight: 550 !important;
        color: #616161;
        letter-spacing: .05em;
    }

    .item_autocomplete .autocomplete_data {
        width: 80% !important;
    }

    #sales_items_tab .table-bordered > tbody > tr > td .form-group {
        margin: 0px !important;
    }

    #sales_items_tab .table-bordered > tbody > tr > td select {
        padding-left: 7px;
        margin: 1px !important;
        padding-right: 1px;
    }

    #sales_items_tab .table > tbody > tr > td {
        vertical-align: top !important;
        color: #555;
    }

    #sales_items_tab .table > tbody > tr > td {
        overflow: visible !important;
    }

    #sales_items_tab .table-bordered > tbody > tr > td {
        border: none !important;
        border-bottom: 1px solid #f4f4f4 !important;
        border-top: 1px solid #f4f4f4 !important;
        padding: 12px 0px 12px 10px !important;
    }

    .glyphicon-pencil,
    .glyphicon-trash {
        /*color: #c9e4ea;*/
        color: transparent;

    }

    .error-summary {
        color: #a94442;
        background: #efd4d4;
        border-left: 3px solid #eed3d7;
        padding: 10px 20px;
        /*    margin: 0 15px 15px 15px;*/
    }

    .ui-widget-content,
    .autocomplete {
        border: 1px solid #aaaaaa !important;
        background: #ffffff url("images/ui-bg_flat_75_ffffff_40x100.png") 50% 50% repeat-x !important;
        color: #222222 !important;
        max-height: 150px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        font-size: 11px !important;
        padding-left: 0px;
    }

    .ui-menu-item,
    .autocomplete li {
        position: relative !important;
        margin: 0 !important;
        padding: 3px 1em 3px .4em !important;
    }

    .ui-menu-item,
    .autocomplete li,
    .ui-widget {
        cursor: pointer !important;
        min-height: 0 !important;
        list-style-image: url("data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7") !important;
    }

    .ui-widget,
    .autocomplete li {
        font-family: Verdana, Arial, sans-serif !important;
    }

    .ui-menu-item div:hover,
    .autocomplete li:hover {
        background: #337ab7 !important;
        font-weight: normal !important;
        color: #fff !important;
    }

    .autocomplete {;
        position: absolute;
        z-index: 3;
        margin-top: -4px
    }

    .autocomplete li {
        padding: 3px 0em 3px 0em;
        border: none !important;
    }

    .item_autocomplete .autocomplete_data {
        width: 80% !important;
    }

    .autocomplete {
        margin-top: 2px;
        width: 85%
    }

    .autocomplete li {
        width: 100%;
    }

    .number input[type="text"] {
        text-align: right;
    }

    input[readonly],
    input[readonly="readonly"],
    input[disabled],
    select[disabled] {
        cursor: not-allowed;
        background: transparent !important;
    }

    .number input[type="text"]:hover {
        background: #F9F9F9 !important;
        border-bottom: 1px solid #aaa;
    }

    .form-group {
        margin: 0 !important;
        padding: 0 !important;
    }

    .nav-secondary .nav-link.active:hover {
        color: #000 !important;
    }
</style>


<?php
//echo (Yii::$app->session->hasFlash('success'));die;


$active_div = true;
$order_status = ($model->booking_id != '') && ($model->status == 'Closed' || $model->status == 'Deleted') ? true : false;
$label_select = 'SELECT';
$form = ActiveForm::begin(['enableClientValidation' => false, 'id' => 'booking_header_form', 'options' => ['class' => 'disable-submit-buttons', 'onSubmit' => 'return clientShowLoader()']]);
?>
<div class="row">
    <div class="card col-lg-12" style="margin-bottom: 56px">
        <div class="card-body">
            <div class="col-lg-12">
                <div class="error-summary-sales alert alert-danger" id="errors_test1" style="display: none;">
                    <p><i
                                class="fa fa-close pull-right" onclick="$(&quot;#errors_test1&quot;).hide()"></i>
                    <h5
                            class="text-danger"><b><i class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b>
                    </h5>
                    </p>
                    <hr class="custom_error_hr">
                    <div id="error_display_sales" class="custom_error"></div>
                </div>
            </div>
            <input type="hidden" name="booking_sms" id="booking_sms" value="0">
            <?php echo $form->field($model, 'customer_id')->hiddenInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->attributeLabels()['customer_id'], 'autocomplete' => "off", 'id' => "hidden_id"])->label(false);
            echo $form->field($customer_model, 'id')->hiddenInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->attributeLabels()['customer_id'], 'autocomplete' => "off"])->label(false);
            echo $form->field($model, 'order_status')->hiddenInput(['maxlength' => true, 'class' => 'form-control'])->label(false);
            echo $form->field($model, 'status')->hiddenInput(['maxlength' => true, 'class' => 'form-control'])->label(false);
            ?>
            <!-- Row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-body">
                        <h5 class="box-title">Customer</h5>
                        <hr class="m-t-0">
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-2"
                                           style="align-self: center">Name</label>
                                    <div class="col-md-8" style="padding-left: 0px!important; margin-left: -12px;">
                                        <?php
                                        echo $form->field($customer_model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control text_first', 'placeholder' => 'Search by Name/Contact nos or Create New', 'autocomplete' => "off", 'readonly' => true])->label(false); ?>
                                        <!-- <div class="form-group field-customermastersearch-name">

                            <input type="text" id="customermastersearch-name" class="form-control text_first"  placeholder="Search by Name/Contact nos or Create New" autocomplete="off" style="display: none;" onkeyup="customerchange(this.value,this.id)">
                            </div>     <div id='customer_autodata' style="background-color:black">

                                        </div>-->


                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-info" onclick="showsearch()"><span
                                                    class="fa fa-edit"></span></button>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"
                                           style="padding-right: 0px !important;align-self: center">Mobile No.</label>
                                    <div class="col-md-9">
                                        <?php echo $form->field($customer_model, 'contact_nos')->textInput(['maxlength' => true, 'onfocusin' => '$("#customer_autodata").hide();', 'class' => 'form-control text_first', 'placeholder' => $customer_model->attributeLabels()['contact_nos'], 'autocomplete' => "off"])->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3" style="align-self: center">Email
                                        ID</label>
                                    <div class="col-md-9">
                                        <?php echo $form->field($customer_model, 'email_id')->textInput(['maxlength' => true, 'class' => 'form-control text_first', 'onfocusin' => '$("#customer_autodata").hide();', 'placeholder' => $customer_model->attributeLabels()['email_id'], 'autocomplete' => "off"])->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"
                                           style="padding-right: 0px !important;align-self: center">Reference</label>
                                    <div class="col-md-9">
                                        <!-- --><?php /*= $form->field($customer_model, 'reference')->dropDownList(['None' => 'None', 'FaceBook' => 'FaceBook', 'Instagram' => 'Instagram', 'Google' => 'Google', 'Friend' => 'Friend',], ['class' => 'form-control text_first',])->label(false) */ ?>
                                        <?php $list = array('None' => 'None', 'FaceBook' => 'FaceBook', 'Instagram' => 'Instagram', 'Google' => 'Google', 'Friend' => 'Friend') ?>
                                        <?= $form->field($customer_model, 'reference')->widget(Select2::classname(), [
                                            'data' => $list,
                                            'size' => Select2::MEDIUM,
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'options' => ['placeholder' => 'Select Reference'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label text-left col-md-3"
                                           style="padding-right: 0px;align-self: center">Addrs
                                        Grp</label>
                                    <div class="col-md-9">
                                        <?php // $form->field($customer_model, 'cust_group')->dropDownList([ 'None' => 'None', 'Photographer' => 'Photographer', 'Model' => 'Model', 'Friend' => 'Friend', ], ['class'=>'form-control text_first'])->label(false) 
                                        ?>
                                        <!--                                        --><?php //= $form->field($customer_model, 'address_group')->dropDownList($address_grup, ['class' => 'form-control text_first'])->label(false) ?>
                                        <?= $form->field($customer_model, 'address_group')->widget(Select2::classname(), [
                                            'data' => $address_grup,
                                            'size' => Select2::MEDIUM,
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'options' => ['placeholder' => 'Select Address Grp'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label id="customer_bal" class="control-label text-left col-md-12"
                                           style="padding-right: 0px !important;color: green;font-weight: bold;font-size: large;">
                                        <?php if (isset($bal_amount) && $bal_amount != 0) {
                                            echo "Available Balance : " . $bal_amount;
                                        } ?>
                                    </label>

                                </div>
                            </div>
                            <!--/span-->
                            <!--  <div class="col-md-6">
                                  <div class="form-group row">
                                      <label class="control-label text-left col-md-3" style="padding-right: 0px">Addrs Grp</label>
                                      <div class="col-md-9">

                                      </div>
                                  </div>
                              </div>-->
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <hr class="m-t-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <?php

                                        /*if($model->booking_id=="" ){
                                            // echo $model->deposite_applicable;die;
                                            $model->deposite_applicable=true;

                                        }*/
                                        //$model->deposite_applicable=false;
                                        $model->diplay_amount = true;
                                        ?>

                                        <?= $form->field($model, 'deposite_applicable')
                                            ->checkBox(['class' => 'deposite_applicable_class check', 'data-checkbox' => "icheckbox_square-red"]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <div class="col-md-9">
                                        <?= $form->field($model, 'diplay_amount')
                                            ->checkBox(['class' => 'deposite_applicable_class check control-label', 'data-checkbox' => "icheckbox_square-red"]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">

                                    <div class="col-md-9">


                                        <?= $form->field($model, 'picked_up')
                                            ->checkBox(['class' => 'deposite_applicable_class check ', 'data-checkbox' => "icheckbox_square-red"]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">

                                    <div class="col-md-9">


                                        <?= $form->field($model, 'complete_order')
                                            ->checkBox(['class' => 'deposite_applicable_class check ', 'data-checkbox' => "icheckbox_square-red"]); ?>
                                    </div>
                                </div>
                            </div>

                            <!--/span-->

                            <!--/span-->
                        </div>
                    </div>


                </div>
                <div class="col-lg-4">


                    <div class="form-body">

                        <!--/row-->
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-4"
                                           style="align-self: center"><?= $model->attributeLabels()['booking_date'] ?></label>
                                    <div class="col-md-8">
                                        <?php $model['booking_date'] = ($model['booking_date'] != '') ? date('d-m-Y', strtotime($model['booking_date'])) : date('d-m-Y');

                                        echo DatePicker::widget([
                                            'name' => 'BookingHeader[booking_date]',

                                            'type' => DatePicker::TYPE_INPUT,
                                            'value' => $model['booking_date'],
                                            //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                                            'options' => [
                                                'placeholder' => 'dd-mm-yyyy',
                                                'autocomplete' => 'off'
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'dd-mm-yyyy',
                                                'todayHighlight' => true,
                                                'orientation' => 'bottom',
                                            ]
                                        ]); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-4"
                                           style="align-self: center"><?= $model->attributeLabels()['pickup_date'] ?></label>
                                    <div class="col-md-8">
                                        <?php //$model['pickup_date']=($model['pickup_date'] !='')?date('d-m-Y',strtotime($model['pickup_date'])):date('d-m-Y');
                                        $model['pickup_date'] = ($model['pickup_date'] != '') ? date('d-m-Y', strtotime($model['pickup_date'])) : null;

                                        echo DatePicker::widget([
                                            'name' => 'BookingHeader[pickup_date]',

                                            'type' => DatePicker::TYPE_INPUT,
                                            'value' => $model['pickup_date'],
                                            //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                                            'options' => [
                                                'placeholder' => 'dd-mm-yyyy',
                                                'autocomplete' => 'off'
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'dd-mm-yyyy',
                                                'todayHighlight' => true,
                                                'orientation' => 'bottom',
                                            ]
                                        ]); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row" style="margin-bottom: 7px;">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-4"
                                           style="align-self: center"><?= $model->attributeLabels()['return_date'] ?></label>
                                    <div class="col-md-8">
                                        <?php //$model['return_date']=($model['return_date'] !='')?date('d-m-Y',strtotime($model['return_date'])):date('d-m-Y');
                                        $model['return_date'] = ($model['return_date'] != '') ? date('d-m-Y', strtotime($model['return_date'])) : null;

                                        echo DatePicker::widget([
                                            'name' => 'BookingHeader[return_date]',

                                            'type' => DatePicker::TYPE_INPUT,
                                            'value' => $model['return_date'],
                                            //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                                            'options' => [
                                                'placeholder' => 'dd-mm-yyyy',
                                                'autocomplete' => 'off'
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'dd-mm-yyyy',
                                                'todayHighlight' => true,
                                                'orientation' => 'bottom',
                                            ]
                                        ]); ?>
                                        <?php echo $form->field($model, 'booking_id')->hiddenInput(['maxlength' => true, 'class' => 'form-control text_first', 'placeholder' => $model->attributeLabels()['booking_id'], 'autocomplete' => "off"])->label(false); ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--/row-->
                        <div class="row">
                            <div class="col-md-12">
                                <h3><b>
                                        <center>
                                            <div id="display_pending"
                                                 style="background-color: #c4ecba;border-radius: 5px;padding: 5px 0">
                                                Amount: 0
                                            </div>
                                        </center>
                                    </b></h3>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">

                                <div class="col-md-9">


                                    <?= $form->field($model, 'postpond')
                                        ->checkBox(['class' => 'deposite_applicable_class check ']); ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($model->booking_id != '' && $model->order_status == 'Open' && $model->status == 'Booked') { ?>
                            <div class="row" style="display: none;">

                                <div class="col-md-12">
                                    <div class="form-group row">

                                        <div class="col-md-9">


                                            <?= $form->field($model, 'cancel_flag')
                                                ->checkBox(['class' => 'cancel_class check ', 'data-checkbox' => "icheckbox_square-red"]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--/row-->
                    </div>


                </div>

            </div>
            <!-- Row -->


            <!-- <div class="row" style="margin-top:0px !important;padding-bottom:0px !important">
    <div class="col-lg-4 panel panel-default">
        <div class="panel-body" style="padding-bottom:0px !important">

            <div class="tab-content">

                <div class="col-lg-12">
                    <div class="row right_section">

                        <div class="form-group cust-group">
                            <label class="col-lg-5 control-label" style="text-align: left"> <?php // $model->attributeLabels()['booking_date'] 
            ?> </label>
                            <div class="col-lg-6 form-group">
                                <?php // $model['booking_date']=($model['booking_date'] !='')?Yii::$app->formatter->asDate($model['booking_date'],'dd-MM-Y'):date('d-m-Y');

            /*echo DatePicker::widget([
'name' => 'BookingHeader[booking_date]',

'type' => DatePicker::TYPE_INPUT,
'value'=> $model['booking_date'],
//'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
'options' => [
'placeholder' => 'dd-mm-yyyy',
],
'pluginOptions' => [
'autoclose'=>true,
'format' => 'dd-mm-yyyy'
]
]);*/ ?>

                            </div>
                        </div>
                    </div>
                    <div class="row right_section">

                        <div class="form-group cust-group">
                            <label class="col-lg-5 control-label" style="text-align: left"> <?php // $model->attributeLabels()['pickup_date'] 
            ?> </label>
                            <div class="col-lg-6 form-group">
                                <?php //$model['pickup_date']=($model['pickup_date'] !='')?Yii::$app->formatter->asDate($model['pickup_date'],'dd-MM-Y'):date('d-m-Y');

            /* echo DatePicker::widget([
'name' => 'BookingHeader[pickup_date]',

'type' => DatePicker::TYPE_INPUT,
'value'=> $model['pickup_date'],
//'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
'options' => [
 'placeholder' => 'dd-mm-yyyy',
],
'pluginOptions' => [
 'autoclose'=>true,
 'format' => 'dd-mm-yyyy'
]
]);*/ ?>

                            </div>
                        </div>
                    </div>
                    <div class="row right_section">

                        <div class="form-group cust-group">
                            <label class="col-lg-5 control-label" style="text-align: left"> <?php // $model->attributeLabels()['return_date'] 
            ?> </label>
                            <div class="col-lg-6 form-group">
                                <?php //$model['return_date']=($model['return_date'] !='')?Yii::$app->formatter->asDate($model['return_date'],'dd-MM-Y'):date('d-m-Y');

            /*echo DatePicker::widget([
'name' => 'BookingHeader[return_date]',

'type' => DatePicker::TYPE_INPUT,
'value'=> $model['return_date'],
//'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
'options' => [
'placeholder' => 'dd-mm-yyyy',
],
'pluginOptions' => [
'autoclose'=>true,
'format' => 'dd-mm-yyyy'
]
]);*/ ?>
<?php // echo $form->field($model, 'booking_id')->hiddenInput(['maxlength' => true,'class'=>'form-control text_first','placeholder'=> $model->attributeLabels()['booking_id'],'autocomplete'=>"off"])->label(false);
            ?>
                            </div>
                        </div>
                    </div>
                 

                </div>

            </div>
        </div>
        
    </div>
    
</div>
 -->


            <div class="col-lg-12" style="padding-left: 0px">

                <!-- <div class="list-main-tab">
                    <div class="list-main-tab-heading" id="matetialServiceTab"> -->


                <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons mb-3"
                    id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-items-tab" data-bs-toggle="pill"
                           href="#component_pills" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                            <i class="flaticon-home"></i>
                            Items
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-payment-tab" data-bs-toggle="pill" href="#operation-pills"
                           role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                            <i class="flaticon-user-4"></i>
                            Payment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-measurement-tab" data-bs-toggle="pill" href="#measure-pills"
                           role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                            <i class="flaticon-mailbox"></i>
                            Measurment
                        </a>
                    </li>
                </ul>

                <!--                <ul class="nav nav-pills mb-3 customtab2" id="pills-tab" role="tablist">-->
                <!--                    <li class="nav-item" role="presentation">-->
                <!--                        <button class="nav-link active" id="pills-items-tab" data-bs-toggle="pill"-->
                <!--                                data-bs-target="#component_pills" type="button" role="tab" aria-controls="pills-items"-->
                <!--                                aria-selected="true">Items-->
                <!--                        </button>-->
                <!--                    </li>-->
                <!--                    <li class="nav-item" role="presentation">-->
                <!--                        <button class="nav-link" id="pills-payment-tab" data-bs-toggle="pill"-->
                <!--                                data-bs-target="#operation-pills" type="button" role="tab" aria-controls="pills-payment"-->
                <!--                                aria-selected="false">Payment-->
                <!--                        </button>-->
                <!--                    </li>-->
                <!--                    <li class="nav-item" role="presentation">-->
                <!--                        <button class="nav-link" id="pills-measurement-tab" data-bs-toggle="pill"-->
                <!--                                data-bs-target="#measure-pills" type="button" role="tab"-->
                <!--                                aria-controls="pills-measurement" aria-selected="false">Measurment-->
                <!--                        </button>-->
                <!--                    </li>-->
                <!--                </ul>-->

                <div class="tab-content master-main-tab"> <!-- General Tab-->
                    <div class="tab-pane  show active in" id="component_pills" role="tabpanel"
                         aria-labelledby="pills-items-tab">
                        <div class="row ">
                            <div class="col-lg-12" id="sales_items_tab" style="margin-top: 10px">
                                <?php DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_wrapper_booking',
                                    'widgetBody' => '.container-items',
                                    'widgetItem' => '.house-item',
                                    'limit' => 10,
                                    'min' => 1,
                                    'insertButton' => '.add-house',
                                    'deleteButton' => '.remove-house',
                                    'model' => $booking_items[0],
                                    'formId' => 'booking_header_form',
                                    'formFields' => [
                                        'description',
                                    ],
                                ]); ?>
                                <table class="table table-hover table-bordered table-head-bg-info table-bordered-bd-info">
                                    <thead>
                                    <tr>
                                        <th style="width: 3%">#</th>
                                        <th style="width: 30%">Item</th>
                                        <th style="width: 10%">Amount</th>
                                        <th style="width: 10%">Deposite</th>
                                        <th style="width: 10%">Discount</th>
                                        <th style="width: 7px;">Extra</th>

                                        <th style="width: 10%">Net Value</th>
                                        <th style="width: 20%">Note</th>
                                        <th class="text-center" style="width: 2%;">
                                            <button type="button" onclick="addBookingitem()"
                                                    class="add-house btn btn-success btn-xs">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="container-items">
                                    <?php
                                    $array1 = [new BookingItem()];
                                    $booking_items = array_merge($array1, $booking_items);
                                    $count_item = count($booking_items);
                                    $sub_total = 0;

                                    foreach ($booking_items as $indexHouse => $booking_item):
                                        $active_div = ($model->booking_id != '' && $indexHouse != 0) ? '' : 'display:none;';
                                        $item_status = false;
                                        $booking_item->item_status = ($model->booking_id != '' && $indexHouse != 0) ? $booking_item->item_status : 'Booked';
                                        if ($model->booking_id != '' && $indexHouse != 0) {
                                            $item_status = ($booking_item->item_status != 'Booked');
                                        }
                                        ?>
                                        <tr class="house-item" id='<?php echo "bookingitem-{$indexHouse}-test"; ?>'>
                                            <td id='<?php echo "bookingitem-{$indexHouse}-tax_new_id"; ?>'
                                                style="text-align: center;vertical-align: middle !important;"><?= $indexHouse; ?>

                                            </td>
                                            <td class="vcenter desc"
                                                style="width: 300px;max-width: 300px;overflow: visible;word-break: all;vertical-align: top !important;">
                                                <div class="row temp_change_item_row"
                                                     style="margin-left:1px;font-size:13px;padding-bottom: 0px;border-radius: 4px;width:100%;height:34px;border:1px solid #aad0e6;cursor: pointer;<?= ($active_div != '') ? 'display: block' : 'display:none'; ?>">
                                                    <div class="pull-left temp_change_item"
                                                         style="padding:0px 0px 0px 10px;cursor: pointer;margin-top: -2px;width: 85%;overflow: hidden; display: flex;align-items: center;height: 100%;">
                                                        <h6 class="ellipsis" style="margin: 0">
                                                            <span style="color:#333;font-size: 12px">
                                                                <b><?= 'Select Item' ?></b>
                                                            </span>
                                                        </h6>

                                                    </div>
                                                    <div class="pull-left temp_change_item"
                                                         style="padding:3px 15px 0px 0px;cursor: pointer;width: 15%;text-align: right;">
                                                        <i class="glyphicon glyphicon-menu-down"
                                                           style="font-size: 11px;padding:5px;"></i>
                                                    </div>

                                                </div>
                                                <div class="row search_row"
                                                     style="z-index: 1080;position: absolute;width: 95%;min-height:200px;display: none ;background: #fff;    box-shadow: 1px 3px 3px 1px #aaa;padding: 10px;">

                                                    <div class="col-lg-12 other_details_data"
                                                         id='<?php echo "bookingitem-{$indexHouse}-item_details_data"; ?>'></div>

                                                </div>

                                                <div class="item_details_lable" style="<?= $active_div ?>"
                                                     id='<?php echo "bookingitem-{$indexHouse}-label_name"; ?>'>
                                                    <div class="pull-left item_content" style="width: 90%">
                                                        <div style="<?= $active_div; ?>" class="inner_desc"
                                                             id='<?php echo "bookingitem-{$indexHouse}-item_desc"; ?>'>
                                                            <?= $form->field($booking_item, "[{$indexHouse}]description")->textarea(['placeholder' => $booking_items[0]->attributeLabels()['description'], 'maxlength' => true, 'class' => 'form-control txt table-feild', 'style' => 'resize: none; height:34px !important;padding:6px 0px 6px 6px !important;margin-bottom:2px;color:#585b5d;background:none;font-weight:600;', 'onkeyup' => 'changeitemdetails(this.value,this.id)', 'autocomplete' => "off",])->label(false); ?>
                                                        </div>

                                                    </div>
                                                    <i class="  glyphicon glyphicon-pencil"
                                                       style="font-size: 11px;padding:5px;color: #00ACD6"></i>
                                                    <?php //}
                                                    ?>

                                                </div>


                                                <?php
                                                // necessary for update action.
                                                if (!$booking_item->isNewRecord) {
                                                    echo Html::activeHiddenInput($booking_item, "[{$indexHouse}]item_id");
                                                }
                                                ?>


                                            </td>
                                            <td>
                                                <?= $form->field($booking_item, "[{$indexHouse}]amount")->label(false)->textInput(['maxlength' => true, 'onkeyup' => 'add_total(this.id)', 'placeholder' => '0.00', 'readonly' => $item_status]) ?>
                                                <?= $form->field($booking_item, "[{$indexHouse}]product_id")->label(false)->hiddenInput(['maxlength' => true]) ?>
                                                <?= $form->field($booking_item, "[{$indexHouse}]item_type")->label(false)->hiddenInput(['maxlength' => true]) ?>
                                                <?= $form->field($booking_item, "[{$indexHouse}]item_category")->label(false)->hiddenInput(['maxlength' => true]) ?>
                                                <?= $form->field($booking_item, "[{$indexHouse}]item_no")->label(false)->hiddenInput(['maxlength' => true]) ?>
                                                <?= $form->field($booking_item, "[{$indexHouse}]item_status")->label(false)->hiddenInput(['maxlength' => true]) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($booking_item, "[{$indexHouse}]deposit_amount")->label(false)->textInput(['maxlength' => true, 'onkeyup' => 'add_total(this.id)', 'placeholder' => '0.00', 'readonly' => $item_status]) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($booking_item, "[{$indexHouse}]discount")->label(false)->textInput(['maxlength' => true, 'onkeyup' => 'add_total(this.id)', 'placeholder' => '0.00', 'readonly' => $order_status]) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($booking_item, "[{$indexHouse}]extra_per")->label(false)->textInput(['maxlength' => true, 'onkeyup' => 'add_total(this.id)', 'placeholder' => '0', 'readonly' => $order_status]) ?>
                                            </td>

                                            <td>
                                                <?= $form->field($booking_item, "[{$indexHouse}]net_value")->label(false)->textInput(['maxlength' => true, 'readonly' => true, 'style' => "border:none;background: none !important;"]) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($booking_item, "[{$indexHouse}]note")->label(false)->textInput(['maxlength' => true]) ?>
                                            </td>
                                            <td class="text-center vcenter" style="width: 90px; verti">

                                                <button type="button" class="remove-house btn btn-danger btn-xs"
                                                        onclick="removeBookingitem()" <?php echo ($item_status) ? 'disabled' : ''; ?>>
                                                    <span class="fa <?= ($item_status) ? 'fa-truck' : 'fa-minus' ?>"></span>
                                                </button>
                                                <?php if ($item_status) { ?>
                                                    <button style="margin-top: 5px;" type="button"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="<?php echo ($item_status) ? 'cancel_pickup(' . $model->booking_id . ',' . $booking_item->item_id . ',\'' . $booking_item->item_status . '\')' : ''; ?>"
                                                            title="Cancel Pickup"><span class="fa fa-ban"></span>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php DynamicFormWidget::end(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body" <?= ($model->booking_id != "") ? '' : 'style="display: none;"'; ?>>

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-left col-md-3">Penalty:</label>
                                                <div class="col-md-9">
                                                    <?php echo $form->field($model, 'issues_penalty')->textInput(['maxlength' => true, 'class' => 'form-control text_first', 'onkeyup' => 'add()', 'placeholder' => $model->attributeLabels()['issues_penalty'], 'autocomplete' => "off"])->label(false); ?>
                                                </div>
                                            </div>
                                        </div>


                                        <?php echo $form->field($model, 'issues_reason')->textarea(['maxlength' => true, 'class' => 'form-control', 'placeholder' => $model->attributeLabels()['issues_reason']])->label(false); ?>
                                    </div>
                                </div>
                                <div class="card"
                                     id="cancel_reason_display" <?= ($model->order_status == "Cancelled" || $model->order_status == "Deleted") ? '' : 'style="display: none;"'; ?>>
                                    <div class="card-body">
                                        <h4 class="card-title">Reason to Cancel/Delete:</h4>
                                        <p>
                                        <h6 class="card-subtitle"
                                            id="cancel_reason_data"><?= ($model->reason == '') ? "Reason not specified" : $model->reason; ?></h6>
                                        </p>
                                        <?php echo $form->field($model, 'reason')->hiddenInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 form-total pull-right">
                                <div class="panel panel-default">
                                    <!--  <div class="panel-heading"></div> -->
                                    <div class="panel-body"
                                         style="padding:0px !important;">
                                        <!-- Nav tabs -->

                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <div class="even-strip row_new" style="border-top:1px solid #eee;">
                                                <div class="form-group row">
                                                    <label class="col-md-6 control-label"
                                                           style="align-self: center;margin:0"> Rent Amount </label>
                                                    <div class="col-md-6 number">
                                                        <input type="text" name="BookingHeader[rent_amount]"
                                                               value="<?= $model->rent_amount ?>"
                                                               class="form-control total"
                                                               style="border:none;background: none !important;"
                                                               readonly id="total_rent_amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row_new" style="border-top:1px solid #eee;">
                                                <div class="form-group row">
                                                    <label class="col-md-6 control-label"
                                                           style="align-self: center;margin:0"> Deposit
                                                        Amount </label>
                                                    <div class="col-md-6 number">
                                                        <input type="text" name="BookingHeader[deposite_amount]"
                                                               value="<?= $model->deposite_amount ?>"
                                                               class="form-control total"
                                                               style="border:none;background: none !important;"
                                                               readonly id="total_deposite_amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="even-strip row_new" style="border-top:1px solid #eee;">
                                                <div class="form-group row">
                                                    <label class="col-md-6 control-label"
                                                           style="align-self: center;margin:0"> Discount </label>
                                                    <div class="col-md-6 number">
                                                        <input type="text" name="BookingHeader[discount]"
                                                               value="<?= $model->discount ?>"
                                                               class="form-control total"
                                                               style="border:none;background: none !important;"
                                                               readonly id="total_discount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="even-strip row_new" style="border-top:1px solid #eee;">
                                                <div class="form-group row">
                                                    <label class="col-md-6 control-label"
                                                           style="align-self: center;margin:0"> Extra Amount </label>
                                                    <div class="col-md-6 number">
                                                        <input type="text" name="BookingHeader[extra_amount]"
                                                               value="<?= $model->extra_amount ?>"
                                                               class="form-control total"
                                                               style="border:none;background: none !important;"
                                                               readonly id="extra_amount">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row_new"
                                                 style="border-top:1px solid #eee;background-color: #c4ecba">
                                                <div class="form-group row">
                                                    <label class="col-md-6 control-label total"
                                                           style="align-self: center;margin:0"> Total </label>
                                                    <div class="col-md-6 number">

                                                        <input type="text" name="BookingHeader[net_value]"
                                                               value="<?= $model->net_value ?>"
                                                               class="form-control total"
                                                               style="border:none;background: none !important;"
                                                               readonly id="sub_total">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane " id="operation-pills" role="tabpanel" aria-labelledby="pills-payment-tab">

                        <div class="row  col-lg-12" style="padding-left: 0px;">

                            <div class="col-lg-12" id="sales_items_tab_payment" style="margin-top: 10px">
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
                                        <th style="width: 10%">Date</th>
                                        <th style="width: 10%">Remark</th>
                                        <th style="width: 15%">Type</th>
                                        <th style="width: 15%">Mode</th>
                                        <th style="width: 15%">Recived By</th>
                                        <th style="width: 15%">Recived In</th>
                                        <th style="width: 15%">During</th>
                                        <th style="width: 20%">Amount</th>
                                        <!--<th style="width: 450px;">Quantity</th>-->
                                        <th class="text-center" style="width: 10%;">
                                            <button type="button" onclick="addPaymentitem()"
                                            " class=" add-payment btn btn-success btn-xs"><span
                                                    class="fa fa-plus"></span></button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="container-items-payment">
                                    <?php
                                    $array1 = [new PaymentMaster()];
                                    $payment_models = array_merge($array1, $payment_models);
                                    $count_item_payment = count($payment_models);
                                    $sub_total = 0;
                                    foreach ($payment_models as $indexHouse => $payment_model):
                                        $active_div = ($model->booking_id != '' && $indexHouse != 0) ? '' : 'display:none;';
                                        $payment_model['date'] = ($payment_model['date'] == "") ? date('Y-m-d') : $payment_model['date'];
                                        ?>
                                        <tr class="payment-item"
                                            id='<?php echo "paymentmaster-{$indexHouse}-test"; ?>'>
                                            <td id='<?php echo "paymentmaster-{$indexHouse}-tax_new_id"; ?>'
                                                style="text-align: center;vertical-align: middle !important;">

                                                <input type="date"
                                                       name="<?php echo "PaymentMaster[{$indexHouse}][date]" ?>"
                                                       id='<?php echo "pricelistassignmentdiscounts-{$indexHouse}-valid_till" ?>'
                                                       class="valid_till_date form-control"
                                                       value="<?php echo $payment_model['date']; ?>">
                                                <?= $form->field($payment_model, "[{$indexHouse}]payment_id")->label(false)->hiddenInput(['maxlength' => true,]) ?>
                                                <?= $form->field($payment_model, "[{$indexHouse}]booking_id")->label(false)->hiddenInput(['maxlength' => true]) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($payment_model, "[{$indexHouse}]remark")->label(false)->textInput(['maxlength' => true, 'placeholder' => 'Remark',]) ?>
                                            </td>

                                            <td>
                                                <?= $form->field($payment_model, "[{$indexHouse}]type")->dropDownList(['Advance' => 'Advance', 'Per-payment' => 'Per-payment', 'Final-Payment' => 'Final-Payment', 'Return-Deposit' => 'Return-Deposit', 'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges', 'Return-Payment' => 'Return-Payment'], ['onchange' => 'add_total_payment()'])->label(false) ?>

                                            </td>
                                            <td>

                                                <?php
                                                $option_array = ($payment_model->type == 'Cancel-Charge' || $payment_model->type == 'Other-Charges') ? ['Deposit' => 'Deposit'] : ['Cash' => 'Cash', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other', 'Carry_Frwd' => 'Carry Frwd', 'Credit' => 'Balance'];

                                                echo $form->field($payment_model, "[{$indexHouse}]mode_of_payment")->dropDownList($option_array, ['onchange' => 'change_mode()'])->label(false) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($payment_model, "[{$indexHouse}]received_by")->dropDownList(['Varsha' => 'Varsha', 'Pranali' => 'Pranali', 'Others' => 'Others',])->label(false) ?>
                                            </td>

                                            <td>

                                                <?= $form->field($payment_model, "[{$indexHouse}]sendto")->dropDownList(['Company' => 'Company', 'Pranali' => 'Pranali', 'Varsha' => 'Varsha',])->label(false) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($payment_model, "[{$indexHouse}]received_during")->dropDownList(['Booking' => 'Booking', 'Pickup' => 'Pickup', 'Return' => 'Return', 'Other' => 'Other',])->label(false) ?>
                                            </td>
                                            <td>
                                                <?= $form->field($payment_model, "[{$indexHouse}]amount")->label(false)->textInput(['maxlength' => true, 'onkeyup' => 'add_total_payment()', 'placeholder' => '0.00',]) ?>
                                            </td>


                                            <td class="text-center vcenter" style="width: 90px; verti">
                                                <button type="button" class="remove-payment btn btn-danger btn-xs"
                                                        onclick="removePaymentitem()"><span
                                                            class="fa fa-minus"></span></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php DynamicFormWidget::end(); ?>
                            </div>
                        </div>
                        <?php
                        if ($model->booking_id != '') {

                            ?>
                            <div class="row col-lg-8">
                                <div class="panel panel-default ">
                                    <!--  <div class="panel-heading"></div> -->
                                    <div class="panel-body"
                                         style="padding-top:10px !important;padding-bottom:10px !important">
                                        <!-- Nav tabs -->

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="row even-strip " style="border-top:1px solid #eee;">
                                                <div class="form-group col-12">
                                                    <?= $form->field($model, 'carry_frwd_app')
                                                        ->checkBox(['class' => 'carry_frwd_app_class check ', 'data-checkbox' => "icheckbox_square-red"]); ?>
                                                </div>
                                            </div>

                                            <div class="row odd-strip row_new" style="border-top:1px solid #eee;">
                                                <div class="form-group col-12">
                                                    <label class="col-md-6 control-label"> Balance </label>
                                                    <div class="col-md-6 number">
                                                        <?php
                                                        $payment_carry_frd_list = ArrayHelper::map($payment_carry_frd, 'id', function ($m) {
                                                            return $m['total_bal'] . " (Amt: " . $m['carry_balance'] . " Dept: " . $m['carry_return'] . ")";
                                                        });
                                                        $payment_carry_retrn = ArrayHelper::index($payment_carry_frd, 'id');
                                                        echo $form->field($model, "open_balance")->dropDownList($payment_carry_frd_list, ['prompt' => 'select', 'data-details' => $payment_carry_retrn])->label(false) ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row odd-strip row_new" style="border-top:1px solid #eee;">
                                                <div class="form-group col-12">

                                                    <div class="col-md-12 number">
                                                        <?php

                                                        if (isset($settle_carry_frd)) {
                                                            ?>
                                                            <table class="table-bordered table">
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Recevied</td>
                                                                    <td>Return</td>
                                                                    <td>Tot. Bal.</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Before</td>
                                                                    <td> -</td>
                                                                    <td> -</td>
                                                                    <td>
                                                                            <span class="pull-right"> <?php if (isset($payment_carry_frd[0])) {
                                                                                    echo $payment_carry_frd[0]['total_bal'];
                                                                                }
                                                                                ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Order</td>
                                                                    <td>
                                                                        <span class="pull-right"><?= $model['rent_amount']; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="pull-right"><?= $model['deposite_amount']; ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="pull-right"><?= $model['rent_amount']; ?></span>
                                                                    </td>
                                                                </tr>
                                                                <?php foreach ($payment_models as $pm_key => $p_model) {
                                                                    if ($pm_key == 0 || $p_model['amount'] == '') {
                                                                        continue;
                                                                    }
                                                                    $retrun_pay = 0;
                                                                    $recv_pay = 0;
                                                                    if ($p_model['type'] == 'Return-Deposit' || $p_model['type'] == 'Return-Payment') {
                                                                        $retrun_pay = $p_model['amount'];
                                                                    } else {
                                                                        $recv_pay = $p_model['amount'];
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="pull-right"><?= $p_model['mode_of_payment'] ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="pull-right"><?= $recv_pay; ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="pull-right"><?= $retrun_pay; ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="pull-right"><?= $recv_pay - $retrun_pay; ?></span>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                    <td>After</td>
                                                                    <td> -</td>
                                                                    <td> -</td>
                                                                    <td>
                                                                        <span class="pull-right"><?= $settle_carry_frd['total_bal'] ?></span>
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row even-strip " style="border-top:1px solid #eee;">
                                                <div class="form-group col-12">
                                                    <?php if (isset($model->carry_frwd_app) && $model->carry_frwd_app != 1) { ?>
                                                        <button type="button" class="btn btn-info btn-square pull-right"
                                                                style="margin-right: 10px"
                                                                title="Carry Forward bal."
                                                                onclick="carryfrwbal('<?= $model->booking_id ?>')">Carry
                                                            frwd Bal
                                                        </button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                        } ?>

                        <div class="row col-lg-4 form-total pull-right">
                            <div class="panel panel-default">
                                <!--  <div class="panel-heading"></div> -->
                                <div class="panel-body"
                                     style="padding-top:0px !important;padding-bottom:0px !important">
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
                                                           style="border:none;background: none !important;" readonly
                                                           id="paid_amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                            <div class="form-group col-12">
                                                <label class="col-md-6 control-label"> Pending </label>
                                                <div class="col-md-6 number">
                                                    <input type="text" name="BookingHeader[pending_amount]"
                                                           value="<?= $model->net_value - (($model->paid_amount) - $model->cancellation_charges) ?>"
                                                           class="form-control total"
                                                           style="border:none;background: none !important;" readonly
                                                           id="pending_amount">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                            <div class="form-group col-12">
                                                <label class="col-md-6 control-label"> Return </label>
                                                <div class="col-md-6 number">
                                                    <input type="text" name="BookingHeader[return_amount]"
                                                           value="<?= $model->return_amount; ?>"
                                                           class="form-control total"
                                                           style="border:none;background: none !important;" readonly
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
                                                           style="border:none;background: none !important;" readonly
                                                           id="cancellation_charges">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                            <div class="form-group col-12">
                                                <label class="col-md-6 control-label"> Other Charge </label>
                                                <div class="col-md-6 number">
                                                    <input type="text" name="BookingHeader[other_charges]"
                                                           value="<?= $model->other_charges ?>"
                                                           class="form-control total"
                                                           style="border:none;background: none !important;" readonly
                                                           id="other_charges">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row even-strip row_new" style="border-top:1px solid #eee;">
                                            <div class="form-group col-12">
                                                <label class="col-md-6 control-label"> Refund </label>
                                                <div class="col-md-6 number">
                                                    <input type="text"
                                                           value="<?= $model->refunded . '/' . $model->deposite_amount ?>"
                                                           class="form-control total"
                                                           style="border:none;background: none !important;" readonly
                                                           id="refund_dis">
                                                    <input type="hidden" name="BookingHeader[refunded]"
                                                           value="<?= ($model->refunded == '' ? 0 : $model->refunded) ?>"
                                                           class="form-control total"
                                                           style="border:none;background: none !important;" readonly
                                                           id="refunded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane " id="measure-pills" role="tabpanel"
                         aria-labelledby="pills-measurement-tab" style="margin-top: 15px;">
                        <div class="col-lg-12">
                            <div class="row right_section">

                                <div class="form-group cust-group">
                                    <label class="col-lg-5 control-label"
                                           style="text-align: left"> <?= $model->attributeLabels()['chest'] ?> </label>
                                    <div class="col-lg-6 form-group">
                                        <?php $model['chest'] = ($model['chest'] != '') ? $model['chest'] : 0;

                                        echo $form->field($model, 'chest')->textInput(['maxlength' => true, 'class' => 'form-control text_first', 'placeholder' => $model->attributeLabels()['chest'], 'autocomplete' => "off"])->label(false); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row right_section">

                                <div class="form-group cust-group">
                                    <label class="col-lg-5 control-label"
                                           style="text-align: left"> <?= $model->attributeLabels()['waist'] ?> </label>
                                    <div class="col-lg-6 form-group">
                                        <?php $model['waist'] = ($model['waist'] != '') ? $model['waist'] : 0;

                                        echo $form->field($model, 'waist')->textInput(['maxlength' => true, 'class' => 'form-control text_first', 'placeholder' => $model->attributeLabels()['waist'], 'autocomplete' => "off"])->label(false); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row right_section">

                                <div class="form-group cust-group">
                                    <label class="col-lg-5 control-label"
                                           style="text-align: left"> <?= $model->attributeLabels()['hip'] ?> </label>
                                    <div class="col-lg-6 form-group">
                                        <?php $model['hip'] = ($model['hip'] != '') ? $model['hip'] : 0;

                                        echo $form->field($model, 'hip')->textInput(['maxlength' => true, 'class' => 'form-control text_first', 'placeholder' => $model->attributeLabels()['hip'], 'autocomplete' => "off"])->label(false); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- </div> -->
            </div>
            <!--              <div class="row" style="margin:0px" >
                  <div class="col-lg-12">
                     <div class="col-lg-6">


                      </div>
                  </div>
                </div> -->
        </div>
    </div>

</div>

<div class="row" style="position: fixed;bottom: 0;width: 100%; z-index:1500">

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <button type="button" onclick="submitForm()"
                        class="btn btn-info save_submit" <?= ($model->order_status == 'Closed' || $model->order_status == 'Deleted' || $model->order_status == 'Cancelled') ? 'disabled' : ''; ?>
                        data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png"
                                                                              style="height:12px"> Save
                </button>

                <?php if (($model->booking_id != '') && $model->order_status == 'Open' && $model->status == 'Booked') { ?>
                    <button type="button" class="btn btn-warning btn-square" style="margin-right: 10px"
                            title="Cancel Booking" onclick="cancelBooking()">Cancel Booking
                    </button>
                <?php } ?>
                <?php if (($model->booking_id != '') && $model->order_status == 'Open' && $model->status == 'Booked' && ($model->paid_amount == 0 || $model->paid_amount == '')) { ?>
                    <button type="button" class="btn btn-danger btn-square" style="margin-right: 10px"
                            title="Delete Booking" onclick="deleteBooking('<?= $model->booking_id ?>','1')">Delete
                    </button>
                <?php } ?>
                <!-- <button type="button" class="btn btn-warning" onclick="send_invoice()" data-toggle="tooltip" data-original-title="Send">Send Invoice</button> -->


            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    var order_status = '<?= $order_status ?>';
    $(window).load(function () {
        // PAGE IS FULLY LOADED
        // FADE OUT YOUR OVERLAYING DIV
        $('.overlay').hide();
    });

    function carryfrwbal(booking_id) {
        var carry_frd_id = $("#bookingheader-open_balance").val();
        var data_json = $("#bookingheader-open_balance").attr('data-details');
        tot_bal = 0;
        if (data_json != '') {
            data_arr = JSON.parse(data_json);
            var final_setl = "";
            if (carry_frd_id != '') {
                var old_settle = data_arr[carry_frd_id];
                var carry_rtn = old_settle['carry_return'];
                var retrn_bal = old_settle['carry_balance'];
                var tot_bal = old_settle['total_bal'];


            } else {
                final_setl = "You have not selected any perv. open balance. Do you want to proceed?\n";
            }
            var final_depo = $("#total_deposite_amount").val();
            var final_rent = $("#total_rent_amount").val();
            var current_retrn_dep = $("#refunded").val();
            var current_paid = $("#paid_amount").val();
            var cal_depo = Number(final_depo) - Number(current_retrn_dep);
            var cal_bal = Number(tot_bal) + ((Number(current_paid) - Number(final_depo)) - Number(final_rent));
            var final_bal = cal_bal + cal_depo;
            //var statement = "Prev: \n Depo Carry Frd: "+carry_rtn+"\n Bal Amt.: "+retrn_bal + "\n Tot. Bal.: "+tot_bal;
            final_setl = final_setl + "Final: \n Depo Carry Frd: " + cal_depo + "\n Bal Amt.: " + cal_bal + "\n Tot. Bal.: " + final_bal;
            swal({
                title: "Are you sure!",
                text: final_setl,
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((isconfirm) => {
                console.log(isconfirm)
                if (isconfirm) {
                    settlebooking(carry_frd_id, booking_id)
                }
            });

            //  swal(final_setl);
        }
    }

    function settlebooking(carry_frd_id, booking_id) {

        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/carry-frd' ?>',
            type: 'get',
            dataType: 'json',
            data: {
                booking_id: booking_id,
                carry_frd_id: carry_frd_id,
            },
            success: function (data) {
                var return_err = '';
                var cleaned = removeDuplicates(data['errors']);
                for (var key in cleaned) {
                    return_err += key + "<br>";
                }
                console.log(return_err)
                if (return_err != '') {
                    swal(return_err)
                } else {
                    alert("Successful")
                    window.location.reload();
                    //showView(data['customer_id'], data['customer_name'])
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });
    }

    $(document).ready(function () {
        $('.overlay').show();

        $("#display_pending").html("Amount: " + $("#pending_amount").val());


        /* $('.cancel_class').on('ifChecked', function(event){
            //$('.deposite_applicable_class').iCheck('uncheck');
            cancelBooking();
        });*/
        /*  $('.add-house').click(function() {
           alert();
              // body...
          });*/
        // $('#mdate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('.temp_change_company').unbind().click(function () {
            // $('#vendor_data_div').toggle();

            $('#search_customer').toggle();
            $('.arrow-img').toggle();
            $('#customermaster-name').focus();

            customerchange('', 'customermaster-name');

        });
        $("#customer_sales").removeClass('even-strip');

        $('.popover-customer').unbind().click(function () {
            $('.other_edit').show();
            $('.other_customer_editable').addClass('edit_background');
        });

        $('.popover-down').unbind().click(function () {
            $('.billing_edit').show();
            $('#billing_address').addClass('edit_background');
        });
        $('.popover-down-delivery').unbind().click(function () {
            $('.delivery_edit').show();
            $('#delivery_address').addClass('edit_background');
        });

        $("#bookingitem-0-test").hide();
        $("#paymentmaster-0-test").hide();
        $('.desc .temp_change_item').unbind().click(function () {
            var customer_id = $("#hidden_id").val();

            select_item_function($(this));

        });


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


    function removeBookingitem() {
        saved_flag = true;
        /* if (count_item==2) {
          flushdata('');
         }*/
        if (count_item > 2) {
            count_item = count_item - 1;
            //  count_item_sr=count_item_sr-1;
        }

        jQuery("#sales_items_tab .dynamicform_wrapper_booking").on("afterDelete", function (e, item) {
            //alert(count_item);
            for (var i = 1; i < count_item; i++) {
                var temp_sr = "#bookingitem-" + (i) + "-tax_new_id";
                //var temp_sr_no="#salesitems-"+(i)+"-sr_no";
                $(temp_sr).html(i);
                // $(temp_sr_no).val(i);
            }
            add();
        });
    }

    var count_item = "<?= $count_item; ?>";
    var count_item_payment = "<?= $count_item_payment; ?>";

    function showView(id, name, flag = 0) {

        saved_flag = true;
        $('#cust_details').html(name);
        $('.arrow-img').hide();
        $('#customer_autodata').hide();
        $('#pModal').modal('hide');
        $('.overlay-back').hide();
        $('.cust_icon').show();

        $('#hidden_id').val(id);
        $('#customermaster-id').val(id);
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/customer-details' ?>',
            type: 'get',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {

                // console.log(data);
                $("#customer_bal").html("");
                $("#customermaster-contact_nos").val(data['contact_nos']);
                $("#customermaster-email_id").val(data['email_id']);
                $("#customermaster-name").val(name);
                $("#customermaster-cust_group").val(data['cust_group']);
                $("#customermaster-reference").val(data['reference']);
                if (data['bal'] != 0) {
                    swal("Available Balance: " + data['bal']);
                    $("#customer_bal").html("Available Balance: " + data['bal']);
                }

            },
            error: function (jqXhr, textStatus, errorThrown) {
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });

    }

    function sendinvoice() {
        var id = $('#bookingheader-booking_id').val(id);

        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/send-invoice' ?>',
            type: 'get',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (data) {

                alert("Send");

            },
            error: function (jqXhr, textStatus, errorThrown) {
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });
    }

    function updateItemRow(obj) {
        saved_flag = true;
        // obj.closest('.item_details_lable').hide();
        //    obj.closest('.item_details_lable').siblings('.name_input_field').find('input').val('');
        //    obj.closest('.item_details_lable').siblings('.name_input_field').find('.form-group input[type="text"]').attr('autofocus', 'true');
        //    obj.closest('.item_details_lable').siblings('.name_input_field').show();
        //     obj.closest('.item_details_lable').siblings('.other').hide();
        //     obj.closest('.item_details_lable').siblings('.other').hide();
        //     obj.closest('.item_details_lable').parent('.desc').find('.temp_change_item_row').show();
        //     var row_id=obj.closest('.item_details_lable').parent('.desc').parent('.sales-item').attr('id');
        //     console.log(obj)
        //      // select_item_function(obj);

        //  flushAllColumn(row_id);


        $('.overlay-back').show();
        // obj.closest('.item_details_lable').parent('.desc').find('.search_row').find('.add_button a').html('Update');
        //  obj.closest('.item_details_lable').parent('.desc').find('.search_row').find('.add_button a').attr('title','Update');
        //  obj.closest('.item_details_lable').parent('.desc').find('.search_row').find('.add_button a').attr('data-original-title','Update');

        obj.closest('.item_details_lable').parent('.desc').find('.search_row').slideDown();
        obj.closest('.item_details_lable').parent('.desc').find('.search_field').slideDown();
        var new_id = (obj.closest('.item_details_lable').parent('.desc').find('.search_field').attr('id'));
        var id = "#" + new_id;
        var id = obj.closest('.item_details_lable').parent('.desc').find('.search_row').children('.other_details_data').attr('id');


        // var n = id.lastIndexOf('-');
        // var item_type=$(id.substring(0,n+1)+'item_type').val();
        // var material_no=$(id.substring(0,n+1)+'material_no').val();
        // var description=$(id.substring(0,n+1)+'description').val();
        // var description_new=$(id.substring(0,n+1)+'description_new').val();
        // var warehouse=id.substring(0,n+1)+'warehouse';

        // if($(id.substring(0,n+1)+'item_type').val()=='OTH'){
        //  $('.seach_button').hide();
        // } else {
        //  $('.seach_button').show();
        //  $(warehouse).show();
        // }

        // if(description!=description_new){
        //   $(id.substring(0,n+1)+'description_new').val(description);
        //   // alert($("#"+id.substring(0,n+1)+'item_type').val())
        //   $(id.substring(0,n+1)+'item_type_temp').val($(id.substring(0,n+1)+'item_type').val());
        //   selectgoodservitem(material_no,description,new_id);
        // }


        // change_display_item_details(item_type,id);
        OpenItemPopup(id);
        //no use
        //    obj.closest('.arrow-img').toggle();
        //     obj.parent('.row').siblings('.search_row').children('.name_input_field').find('.auto_search').focus();
        //       var id= obj.parent('.row').siblings('.search_row').children('.name_input_field').find('.auto_search').attr('id');

        //     changeitemdetails('',id);
        $('html, body').animate({
            'scrollTop': obj.closest('.item_details_lable').parent('.desc').find('.search_row').position().top + 250
        }, 100);


    }

    function cancelBooking() {

        var cancel_message = "";
        //if(flag==0){
        var paid_amount = $('#paid_amount').val();
        var cancel_charge = $('#cancellation_charges').val();
        var other_charges = $('#other_charges').val();
        if (Number(paid_amount) - ((Number)(cancel_charge) + (Number)(other_charges)) != 0) {
            // $("#customermaster-cancel_flag"). prop("checked", false);

            alert("Please Settle Payment before you cancel booking.");
            return;
        }

        cancel_message = '<h4><p class="text-warning">Note: You are appyling cancelletion Charges of ₹ ' + paid_amount + '</p></h4>';
        //}
        $('#pModal').modal('show');
        $('#modalContent').html('<div class="form-group"> ' + cancel_message + ' <br><textarea name="cancel_reason" cols="40" rows="5" class="form-control " id="cancel_reason_header" placeholder="Enter Reason to cancel order"></textarea> </div><br><button type="button" onclick="submit_cancel_booking()" class="btn btn-info pull-right waves-effect" data-dismiss="modal">Submit</button>');
        $('.modal-header').html('<h4 class="modal-title" id="myModalLabel">Cancel Booking</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>');


        /* */
    }

    function deleteBooking(id, flag) {


        $('#pModal').modal('show');
        $('#modalContent').html('<div class="form-group">  <br><textarea name="Text1" cols="40" rows="5" class="form-control " id="cancel_reason" placeholder="Enter Reason to cancel order"></textarea> </div><br><button type="button" onclick="submit_delete_booking(' + id + ',' + flag + ')" class="btn btn-info pull-right waves-effect" data-dismiss="modal">Submit</button>');
        $('.modal-header').html('<h4 class="modal-title" id="myModalLabel">Cancel Booking</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>');


        /* */
    }

    function submit_cancel_booking() {
        $('.cancel_class').iCheck('check');
        var message = $('#cancel_reason_header').val();

        $('#cancel_reason_data').html(message);
        $('#cancel_reason_display').show();
        $('#customermaster-reason').val(message);
        submitForm();
    }

    function submit_delete_booking(id, flag) {
        var reason = $('#cancel_reason').val();
        // flag 1 = delete 0 = cancel
        if (reason != "") {
            $.ajax({
                url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/delete') ?>",
                type: 'post',
                data: {
                    id: id,
                    reason: reason,
                    flag: flag,
                },
                dataType: 'json',
                beforeSend: function () {
                    $(".overlay").show();
                },
                complete: function () {
                    $(".overlay").hide();

                },
                success: function (data) {
                    // console.log(data);
                    $('#pModal').modal('hide');
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
                    $("html, body").animate({
                        scrollTop: 0
                    }, "slow");
                    if (html != '') {
                        test_submit = 0;
                        $(".error-summary-sales").show();
                        $("#error_display_sales").html(html);
                    } else {
                        $(".error-summary-sales").hide();
                    }
                    // $('#redirect_saved_changes').hide();
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    // alert(errorThrown);
                    if (errorThrown == 'Forbidden') {
                        alert(YOU_DONT_HAVE_ACCESS);
                    }
                }
            });
        } else {
            alert("Please enter reason");
        }
    }

    function add_total(id_pass, flag = 0) {
        saved_flag = true;
        var n = id_pass.lastIndexOf('-');
        var result = '#' + id_pass.substring(0, n + 1);
        //var quantity=result+"quantity";
        var amount = result + "amount";
        // var net_price_value=result+"net_price_value";
        var net_value = result + "net_value";
        var extra_per = result + "extra_per";
        //var discount=result+"temp_discount";
        // var discount_change=result+"temp_discount_change";
        var discount_amt = result + "discount";
        // var discount_percentage=result+"discount_percentage";
        // var dropselect=result+"dropselect";
        var deposit_amount = result + "deposit_amount";
        // var details= result+"tax_amount_calculate";
        //var dis_discount=result+"displaydiscount";
        // var tax_rate=result+"tax_rate";
        //var currency = $('#salesheader-currency').val();
        //var sales_tax_include=$('input[name="SalesHeader[TAX_INCL_EXCL_INT]"]:checked').val();

        /* if(flag==1){
           var numbers = result.match(/[0-9]+/g);
           calculate_discount_material(numbers);
         }*/
        //    var tax_final_value= ($(net_price).val()*$(tax_rate).val())/100;

        var dis = $(discount_amt).val();
        var extra_percent = $(extra_per).val();
        //var percnt_amnt=$(dropselect).val();
        //var netvalue = $(net_price).val();

        if (Number(dis) > Number($(amount).val())) {
            $(discount_amt).val(0);
            alert("Invalid Discount");
            dis = 0;
        }

        if (Number(extra_percent) > 100) {
            $(extra_per).val(0);
            alert("Invalid Extra Percent");
            extra_percent = 0;
        }
        var extra_amount = (+Number($(amount).val()) * Number(extra_percent)) / 100;

        var final = (+Number($(amount).val()) + +Number($(deposit_amount).val())) - (dis) + extra_amount;


        $(net_value).val(final);


        // var final=(($(quantity).val()*$(net_price).val())-dis_result)+tax_final_value;
        // $(net_value_value).val(final);
        // $(net_value).val(final);
        /* new Cleave(net_value_value, {prefix: '',numeral: true,numeralThousandsGroupStyle: 'thousand'});
         new Cleave(discount_change, {prefix: '',numeral: true,numeralThousandsGroupStyle: 'thousand'});*/
        add();


    }

    function mailpopup(sales_order_no, objectkey, attatchment_path = "") {
        // var sales_order_no=$('#sales_order_number').val();
        // var objectkey = 'SALES_ORDER';
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=mailing' ?>',
            data: {
                sales_order_no: sales_order_no,
                objectkey: objectkey,
                attatchment_path: attatchment_path,
            },
            type: 'post',
            beforeSend: function () {
                $(".overlay").show();
                $('.sidebar-modal .tab-content').html('');
            },
            complete: function () {
                $(".overlay").hide();
            },
            success: function (data) {
                $(".sidebar-modal").show('slide');
                $('.sidebar-modal .tab-content').html(data);
                $(".overlay-back").show();
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function add() {
        saved_flag = true;
        var deposit = 0;
        var discount_amt = 0;
        var total = 0;
        var total_extra_amount = 0;
        var total_value = 0;
        var rent_amount = 0;


        for (i = 0; i < count_item; i++) {
            var netvalue = "#bookingitem-" + i + "-net_value";
            var discount = "#bookingitem-" + i + "-discount";
            var deposit_amount = "#bookingitem-" + i + "-deposit_amount";
            var amount = "#bookingitem-" + i + "-amount";
            var extra_per = "#bookingitem-" + i + "-extra_per";
            if ($(discount).val() === undefined) {
                continue;
            }
            var numb = parseFloat(Number($(discount).val()));

            var extra_percent = parseFloat(Number($(extra_per).val()));

            rent_amount = rent_amount + +Number($(amount).val());
            var extra_amount = (+Number($(amount).val()) * Number(extra_percent)) / 100;
            //total+=Number($(netvalue).val());
            total_extra_amount += extra_amount;
            total = +total + +Number($(netvalue).val());
            discount_amt = +discount_amt + +Number((numb));
            deposit = +deposit + +Number($(deposit_amount).val());
            total_value = +total_value + (+(Number($(amount).val())) + +(Number($(deposit_amount).val()))) - numb + extra_amount;
        }

        //tax=  +tax + +$("#salesheader-tax_amount").val();

        var penalty_amount = $("#bookingheader-issues_penalty").val();
        if (penalty_amount != '') {
            total_value = total_value - Number(penalty_amount);
        }
        $("#total_rent_amount").val(rent_amount);
        $("#sub_total").val(total_value);
        $("#total_discount").val(discount_amt);
        $("#extra_amount").val(total_extra_amount);
        $("#total_deposite_amount").val(deposit);
        $("#pending_amount").val(total_value - +Number($("#paid_amount").val()));
        $("#display_pending").html("Amount: " + $("#pending_amount").val());

        var refund = $("#refunded").val();
        $("#refund_dis").val(Number(refund) + '/' + deposit);
        // $("#total_rent_amount").val(total);

        /* new Cleave("#sub_total", {prefix: '',numeral: true,numeralThousandsGroupStyle: 'thousand'});
         new Cleave("#total_discount", {prefix: '',numeral: true,numeralThousandsGroupStyle: 'thousand'});
         new Cleave("#total_tax", {prefix: '',numeral: true,numeralThousandsGroupStyle: 'thousand'});
         new Cleave("#total_value", {prefix: '',numeral: true,numeralThousandsGroupStyle: 'thousand'});*/
        return true;
    }

    function advance_search_sider() {

        saved_flag = true;
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/advance-search' ?>',
            type: 'post',
            /*  data:{
                  type:BUSINESS_PARTNER_TYPE,
                  module_chng:module_chng,
              },*/
            success: function (data) {

                // $('#pModal_search').modal('show');
                // $('#modalContent_search').html(data);
                // $(".modal-footer button").hide()
                $('.sidebar-modal .tab-content').html(data);
                $(".sidebar-modal").show('slide');
                $(".overlay-back").show();
            },
            error: function (jqXhr, textStatus, errorThrown) {
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });

    }

    function save_new_customer() {

        saved_flag = true;
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer/quick-create') ?>",
            dataType: 'json',
            type: 'post',
            data: $("#quick_customer :input").serialize(),
            /*data:{
                term:val,
                id:id_pass,
            },*/
            success: function (data) {

                var return_err = '';
                var cleaned = removeDuplicates(data['errors']);
                for (var key in cleaned) {
                    return_err += key + "<br>";
                }
                console.log(return_err)
                if (return_err != '') {
                    alert(return_err)
                } else {
                    alert("Successful")
                    showView(data['customer_id'], data['customer_name'])
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                //alert(errorThrown);
                //console.log( errorThrown );
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });

    }

    function add_new_customer() {

        saved_flag = true;
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('customer/quick-create') ?>",
            dataType: 'html',
            type: 'get',
            /*data:{
                term:val,
                id:id_pass,
            },*/
            success: function (data) {
                $('.overlay-back').show();
                console.log(data)
                $('#pModal_search').modal('show');
                $('#modalContent').html(data);
                $('.modal-header').html("<h4>Add Customer</h4> <button type='button' class='close pull-right' onClick='closeCustomer()'>x</button>");


            },
            error: function (jqXhr, textStatus, errorThrown) {
                //alert(errorThrown);
                //console.log( errorThrown );
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });

    }

    function customerchange(val, id_pass, flag = 0) {
        saved_flag = true;
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/customer-autocomplete') ?>",
            dataType: 'json',
            type: 'get',
            data: {
                term: val,
                id: id_pass,
            },
            success: function (data, textStatus, jQxhr) {

                var n = data['id_pass'].lastIndexOf('-');
                var result1 = '#customer_autodata';


                var data_new = '<ul class="autocomplete add_new_autocomplete" >';
                data_new += '<li style="color: #337AB7; font-weight: bold !important;" onClick="add_new_customer()">+ New Customer </li>';
                for (i = 0; i < data['customer_data'].length; i++) {
                    data_new += '<li onClick="showView(\'' + data['customer_data'][i]['id'] + '\',\'' + data['customer_data'][i]['name'] + '\',' + flag + ')">' + data['customer_data'][i]['name'] + '</li>';
                }
                data_new += '</ul>';
                if (flag == 1) {
                    $('.customer_autodata_show').show();
                    $('.customer_autodata_show').html(data_new);
                    $(".customer_sales_data").removeClass('even-strip');
                    $('.customer_sales_data').parent('.row').removeClass('billimg-edit');
                } else {
                    //alert(result1);
                    $(result1).show();
                    $('.add_new_autocomplete').css('display', '');
                    $(result1).html(data_new);
                    $("#customer_sales").removeClass('even-strip');
                    $('#customer_sales').parent('.row').removeClass('billimg-edit');
                }

            },
            error: function (jqXhr, textStatus, errorThrown) {
                //alert(errorThrown);
                //console.log( errorThrown );
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
            }
        });
    }

    function select_item_function(obj) {
        if (order_status) {
            return;
        }
        saved_flag = true;
        obj.parent('.row').siblings('.search_row').children('.search_field').hide();
        $('.overlay-back').show();
        obj.parent('.row').siblings('.search_row').slideDown();
        obj.parent('.row').siblings('.search_row').children('.search_field').slideDown();
        var id = obj.parent('.row').siblings('.search_row').children('.other_details_data').attr('id');

        OpenItemPopup(id);
        // obj.closest('.arrow-img').toggle();
        //  obj.parent('.row').siblings('.search_row').children('.name_input_field').find('.auto_search').focus();
        //    var id= obj.parent('.row').siblings('.search_row').children('.other_details_data').find('.auto_search').attr('id');

        //  changeitemdetails('',id);
        //      $('html, body').animate({
        //     'scrollTop' :obj.parent('.row').siblings('.search_row').position().top
        // });
        $('html, body').animate({
            'scrollTop': obj.parent('.row').siblings('.search_row').position().top + 250
        });
    }

    function OpenItemPopup(id) {
        saved_flag = true;

        var n = id.lastIndexOf('-');
        var item_id = $("#" + id.substring(0, n + 1) + 'product_id').val();
        var description = $("#" + id.substring(0, n + 1) + 'description').val();
        var item_type = $("#" + id.substring(0, n + 1) + 'item_type').val();
        var item_category = $("#" + id.substring(0, n + 1) + 'item_category').val();
        // var service_catelog_id=$("#"+id.substring(0,n+1)+'item_type').service_catelog_id();


        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/item-details-popup') ?>",
            dataType: 'html',
            type: 'post',
            data: {
                id: id,
                item_type: item_type,
                item_category: item_category,
                description: description,
                item_id: item_id,
            },
            success: function (data, textStatus, jQxhr) {
                $("#" + id).html(data);

                // obj.parent('.row').siblings('.search_row').children('.name_input_field').find('.auto_search').focus();


                // changeitemdetails('',"itemselection-description");

                // var n = data['id'].lastIndexOf('-');
                // var tax="#"+data['id'].substring(0,n+1)+'tax_details';
                // var tax_rate="#"+data['id'].substring(0,n+1)+'tax_rate';
                // var tax_code="#"+data['id'].substring(0,n+1)+'tax_code';
                // var tax_process="#"+data['id'].substring(0,n+1)+'tax_process';
                // var tax_process_old="#"+data['id'].substring(0,n+1)+'tax_process_old';
                // $(tax_process_old).val($(tax_process).val());


            },
            error: function (jqXhr, textStatus, errorThrown) {
                if (errorThrown == 'Forbidden') {
                    alert(you_dont_have_access_label);
                }
                //console.log( errorThrown );
            }
        });
    }

    function cancel_check() {
        alert();
    }

    function addText(id) {

        var result1 = "#itemselection-suggesstion-itemdetail-box";
        $(result1).hide();
        saved_flag = true;
        var n = id.lastIndexOf('-');
        var result = '#' + id.substring(0, n + 1);

        $('.item_error').html('');

        var item_status = $(result + 'item_status').val();
        // var picked_field_status = $(result+'hidden_picked_data').val();
        if (item_status != 'Booked') {
            alert("Item is picked or delivered cannot make any change");
            return false;
        }
        var display_amt = $('#bookingheader-diplay_amount').is(":checked");
        /*     if(readonly_closed_string==true){
               alert(billing_has_been_closed_label +' '+ you_cant_select_any_item);
               return false;
             }
             if(goods_field_status==1){
               alert(goods_inv_has_closed_label+' '+you_cant_select_any_item);
               return false;
             }
                  if(picked_field_status==1){
               alert(you_cant_select_item_becoz_item_packed_label);
               return false;
             } */

        var item_details = $("#itemselection-description").val();
        var product_id = $("#itemselection-item_id").val();
        if (product_id == '') {
            $('.item_error').html('Please select item');
            return false;
        }
        //var MATERIAL_NO_old=$(result+'material_no').val();

        /*    if(MATERIAL_NO_old!=MATERIAL_NO){
              $(result+'batch_no').val('');
              $(result+'unit').val('');
            }  */
        var label_name = result + 'label_name';
        var item_type_new = $(result + 'item_type').val();
        var item_type = $("#itemselection-item_type").val();
        //alert(item_type);
        //alert($("#itemselection-rent_amount").val());
        $(result + 'item_category').val($("#itemselection-item_category").val());
        if (display_amt) {
            $(result + 'amount').val($("#itemselection-rent_amount").val());
        } else {
            $(result + 'amount').val(0);
        }

        var deposite_applicable = $('#bookingheader-deposite_applicable').is(":checked");

        if (deposite_applicable) {
            $(result + 'deposit_amount').val($("#itemselection-deposit_amount").val());
        } else {
            $(result + 'deposit_amount').val(0);
        }

        var description = result + "description";
        var value_oth = $("#itemselection-item_type").val();
        $(result + 'product_id').val(product_id);
        //alert(description);
        $(result + 'item_desc').closest('.desc').find('.temp_change_item_row').hide();
        $(result + 'item_desc').closest('.desc').find('.temp_change_item_row').css('display', 'none');
        //  obj.closest('.desc').find('.item_content').html(value);

        $(result + 'item_desc').show();
        $(description).val(item_details);
        //$(label_name).find('.service_name').hide();
        //alert(label_name)
        $(label_name).show();
        //$(label_name).find('.'+value_oth).show();
        $(result + "item_type").val(item_type);
        $('.search_row').slideUp(200);
        $('.overlay-back').hide();
        $(".other_details_data").html('');

        // }

        // var id="#salesheader-exchange_rate";
        add_total(id);
    }

    function removeDuplicates(json_all) {
        var arr = [];
        $.each(json_all, function (index, value) {
            arr[value] = (value);
        });
        return arr;
    }

    function showsearch() {
        $('.overlay-back').show();
        $('#pModal').modal('show');
        $('#modalContent').html('<div class="form-group field-customermastersearch-name"><input type="text" id="customermastersearch-name" class="form-control text_first"  placeholder="Search by Name/Contact nos or Create New" autocomplete="off" onkeyup="customerchange(this.value,this.id)"></div>    <div id="customer_autodata" style="background-color:black"></div>');
        $('.modal-header').html("<h4>Select Customer</h4> <button type='button' class='btn btn-info' onClick='add_new_customer()'>+New</button> <button type='button' class='close pull-right' onClick='closeCustomer()'>x</button>");
        //$("#customermastersearch-name").show();
        //$("#customermaster-name").hide();
    }

    function closeCustomer() {
        $('.overlay-back').hide();
        $('#pModal').modal('hide');
    }

    function submitForm() {


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
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                if (html != '') {
                    test_submit = 0;
                    $(".error-summary-sales").show();
                    $("#error_display_sales").html(html);
                } else {
                    $(".error-summary-sales").hide();
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

    function sendwhatsapp(booking_id) {

        var r = confirm("Are you sure do you want to send WhatsApp!");
        if (r == false) {
            return;
        }
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/get-whatsapp') ?>",
            type: 'post',
            dataType: 'json',
            data: {
                booking_id: booking_id,

            },
            beforeSend: function () {
                $(".overlay").show();
            },
            complete: function () {
                $(".overlay").hide();

            },
            success: function (data) {

                console.log(data);
                var message = encodeURI(data['message']);
                // window.open('https://api.whatsapp.com/send/?phone='+data["contact_nos"]+'&text='+message, '_blank').focus();
                window.open('https://web.whatsapp.com/send/?phone=' + data["contact_nos"] + '&text=' + message, '_blank').focus();
                //window.location.reload();
            },
            error: function (jqXhr, textStatus, errorThrown) {

            }
        });
    }

    function cancel_pickup(booking_id, booking_item, item_status) {
        if (item_status != 'Picked') {
            alert("Cannot Perform this action.");
            return;

        }
        var r = confirm("Are you sure do you want to cancel pickup!");
        if (r == false) {
            return;
        }
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/cancel-delivery') ?>",
            type: 'post',
            dataType: 'json',
            data: {
                booking_id: booking_id,
                booking_item: booking_item,
            },
            beforeSend: function () {
                $(".overlay").show();
            },
            complete: function () {
                $(".overlay").hide();

            },
            success: function (data) {
                console.log(data);
                window.location.reload();
            },
            error: function (jqXhr, textStatus, errorThrown) {

            }
        });
    }

    function printInvoiceSend() {
        $("#booking_sms").val("1");
        submitForm();
    }

    function printInvoice(id) {
        window.open("http://billing.thesoyara.com/index.php?r=booking/invoice-view&id=" + id, "_blank");
    }

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
            add_total_payment();
        });
    }

    function addBookingitem() {

        if (order_status) {
            return;
        }
        count_item++;
        $("#sales_items_tab .dynamicform_wrapper_booking").on("afterInsert", function (e, item) {

            $('.item_details_lable .glyphicon-pencil').unbind().click(function () {
                updateItemRow($(this));
            });
            $('.desc .temp_change_item').unbind().click(function () {

                select_item_function($(this));

            });
            var item_status_id = "bookingitem-" + (count_item - 1) + "-item_status";
            $('#' + item_status_id).val('Booked');
            /*var id = obj.parent('.row').siblings('.search_row').children('.other_details_data').attr('id');
            alert(id);*/
            $(".dynamic_table tr:last-child").focus();
            // $('html, body').animate({
            //   scrollTop: $("#"+new_row).offset().top +10
            //   },1000);
            //    var scrollBottom = Math.max($('.dynamic_table').height() - $('.dynamicform_wrapper_sales').height(), 0);
            // $('.dynamicform_wrapper_sales').scrollTop(scrollBottom);
            for (var i = 1; i < count_item; i++) {
                var sr_replace = "#bookingitem-" + (i) + "-tax_new_id";
                //var sr_no_replace="#salesitems-"+(i)+"-sr_no";

                $(sr_replace).html(i);
                //$(sr_no_replace).val(i);
            }


        });
    }

    function change_mode() {
        // body...
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/get_balance') ?>",
            type: 'post',
            dataType: 'json',
            data: {
                customer_id: customer_id,

            },
            beforeSend: function () {
                $(".overlay").show();
            },
            complete: function () {
                $(".overlay").hide();

            },
            success: function (data) {
                console.log(data);
                //window.location.reload();
            },
            error: function (jqXhr, textStatus, errorThrown) {

            }
        });
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

        var net_value = Number($("#sub_total").val());
        var deposit_amount = $("#total_deposite_amount").val()
        $("#return_amount").val(return_amount);
        $("#cancellation_charges").val(cancellation_charges);
        $("#other_charges").val(other_charges);
        $("#paid_amount").val(paid_amount);
        $("#pending_amount").val(net_value - ((paid_amount) - cancellation_charges));
        $("#display_pending").html("Amount: " + $("#pending_amount").val());
        $("#refunded").val(refund);
        $("#refund_dis").val(refund + '/' + deposit_amount);
    }
</script>