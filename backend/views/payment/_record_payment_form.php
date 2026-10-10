<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentMaster */
/* @var $form yii\widgets\ActiveForm */
/* @var $booking_id integer */

// Check if user is admin
$user = Yii::$app->user->identity;
$is_admin = (isset($user->user_type) && ($user->user_type == "admin")) ? true : false;

// Configurable: Number of days allowed (0 = today only, 1 = today + yesterday, 2 = today + 2 days back)
$allowed_days_back = 1; // Change this value to configure allowed date range

?>

<div class="payment-master-form">

    <?php $form = ActiveForm::begin([
        'id' => 'payment-record-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?php
            // Configure date picker options based on user role
            $datePickerOptions = [
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Select date ...', 'id' => 'payment-date-input'],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true
                ]
            ];
            
            // If not admin, set min and max date restrictions
            if (!$is_admin) {
                $datePickerOptions['pluginOptions']['startDate'] = '-' . $allowed_days_back . 'd';
                $datePickerOptions['pluginOptions']['endDate'] = '0d';
            }
            
            echo $form->field($model, 'date')->widget(DatePicker::classname(), $datePickerOptions)->label('Date');
            ?>
        </div>

        <div class="col-md-6">
            <?php
            // Build payment types based on booking status
            $paymentTypes = [
                'Advance' => 'Advance',
                'Per-payment' => 'Per-payment',
                'Deposit' => 'Deposit',
            ];
            
            // Add Cancel-Charge if order_status is Cancelled
            if ($booking && $booking->order_status == 'Cancelled') {
                $paymentTypes['Cancel-Charge'] = 'Cancel-Charge';
            }
            
            // Add Return-Deposit if status is Picked or Returned
            if ($booking && ($booking->status == 'Picked' || $booking->status == 'Returned')) {
                $paymentTypes['Return-Deposit'] = 'Return-Deposit';
            }
            
            // Always add these payment types
            $paymentTypes['Final-Payment'] = 'Paid';  // Display name as 'Paid'
            $paymentTypes['Other-Charges'] = 'Other-Charges';
            $paymentTypes['Return-Payment'] = 'Return-Payment';
            
            echo $form->field($model, 'type')->dropDownList($paymentTypes, [
                'prompt' => 'Select Type...', 
                'onchange' => 'add_total_payment();'
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'mode_of_payment')->dropDownList([
                'Cash' => 'Cash',
                'Google Pay' => 'Google Pay',
                'Phone Pe' => 'Phone Pe',
                'Bank Transfer' => 'Bank Transfer',
                'Paytm' => 'Paytm',
                'Other' => 'Other',
                'Credit' => 'Credit',
                'Deposit' => 'Deposit'
            ], ['prompt' => 'Select Mode...', 'id' => 'payment-mode-select']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'amount')->textInput([
                'type' => 'number',
                'placeholder' => 'Enter amount',
                'step' => '1',
                'id' => 'payment-amount-input'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'received_by')->dropDownList([
                'Varsha' => 'Varsha',
                'Pranali' => 'Pranali',
                'Others' => 'Others'
            ], ['prompt' => 'Select Person...']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'received_during')->dropDownList([
                'Booking' => 'Booking',
                'Pickup' => 'Pickup',
                'Return' => 'Return',
                'Other' => 'Other'
            ], ['prompt' => 'Select Stage...']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'sendto')->dropDownList([
                'Company' => 'Company',
                'Pranali' => 'Pranali',
                'Varsha' => 'Varsha'
            ], ['prompt' => 'Select Recipient...']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'remark')->textarea(['rows' => 3, 'placeholder' => 'Enter any remarks...']) ?>
        </div>
    </div>

    <?= $form->field($model, 'booking_id')->hiddenInput(['value' => $booking_id])->label(false) ?>

    <div class="form-group">
        <?= Html::button('Save Payment', [
            'class' => 'btn btn-success',
            'onclick' => 'savePaymentRecord()',
        ]) ?>
        <?= Html::button('Cancel', [
            'class' => 'btn btn-default',
            'data-dismiss' => 'modal',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
function add_total_payment() {
    var type_payment = $('#paymentmaster-type').val();
    var modeSelect = $('#payment-mode-select');
    var amountInput = $('#payment-amount-input');
    
    var comman_option = '<option value="">Select Mode...</option>' +
        '<option value="Cash">Cash</option>' +
        '<option value="Google Pay">Google Pay</option>' +
        '<option value="Phone Pe">Phone Pe</option>' +
        '<option value="Bank Transfer">Bank Transfer</option>' +
        '<option value="Paytm">Paytm</option>' +
        '<option value="Other">Other</option>' +
        '<option value="Credit">Credit</option>' +
        '<option value="Deposit">Deposit</option>';
    
    var deposite_option = '<option value="Deposit" selected="">Deposit</option>';
    
    // Adjust dropdown based on payment type (same logic as booking form)
    if (type_payment == "Cancel-Charge" || type_payment == "Other-Charges") {
        modeSelect.empty().append(deposite_option);
    } else {
        if (modeSelect.val() == 'Deposit') {
            modeSelect.empty().append(comman_option);
        }
    }
}

function savePaymentRecord() {
    var form = $('#payment-record-form');
    var formData = form.serialize();

    // Validate form
    if (!form[0].checkValidity()) {
        alert('Please fill all required fields');
        return;
    }

    $.ajax({
        url: '<?php echo \Yii::$app->getUrlManager()->createUrl('payment/save-payment') ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            $('.overlay').show();
        },
        complete: function() {
            $('.overlay').hide();
        },
        success: function(response) {
            if (response.success) {
                // Show success message
                swal({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    button: "OK",
                }).then(function() {
                    $('#pModal').modal('hide');
                    // Reload the page to show updated payment information
                    location.reload();
                });
            } else {
                var errorMsg = 'Error saving payment:\n';
                if (response.errors) {
                    $.each(response.errors, function(key, value) {
                        errorMsg += key + ': ' + value.join(', ') + '\n';
                    });
                } else {
                    errorMsg += response.message;
                }
                swal({
                    title: "Error!",
                    text: errorMsg,
                    icon: "error",
                    button: "OK",
                });
            }
        },
        error: function(jqXhr, textStatus, errorThrown) {
            swal({
                title: "Error!",
                text: 'Error: ' + errorThrown,
                icon: "error",
                button: "OK",
            });
        }
    });
}
</script>

