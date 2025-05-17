<?php
/* @var $this yii\web\View */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
$this->title = 'Packing';
?>
<style>
  .select2-search__field{
      width: 300px!important;
  }
</style>
<div class="row">
  <?php   $form = ActiveForm::begin(['id'=>'packing_search', 'method' => 'post','action' =>
    ['packing/get-packing-item'],'enableClientValidation'=>false]); ?>

  <label class="control-label text-right col-md-2"
         style="align-self: center">Select Pickup date</label>
  <div class="col-lg-2">
    <?php $filter_date = (isset($filter_date) && $filter_date != '') ? date('d-m-Y', strtotime($filter_date)) : '';

    echo DatePicker::widget([
      'name' => 'filter_pickup_date',
      'id' => 'filter_pickup_date',
      'type' => DatePicker::TYPE_INPUT,
      'value' => $filter_date,
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
  <label class="control-label text-right col-md-2"
         style="align-self: center">Select Customer</label>

    <?php
    $url = "index.php?r=packing/customer-search";
    echo Select2::widget([
      'data' => $customer_list,
      'name' => 'customer_filter',
      'id' => 'customer_filter',
      'options' => ['multiple' => true, 'placeholder' => 'Search for a Customer ...',  'style' => 'width:300px !important',],
      'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 3,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
          'url' => $url,
          'dataType' => 'json',
          'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }')
      ],
    ]); ?>
    <div>
  </div>
<div class="row mt-3" >
  <label class="control-label text-right col-md-2"
         style="align-self: center">Enter Booking Id</label>
      <?php
    $url = "index.php?r=packing/booking-search";
    echo Select2::widget([
      'data' => [],
      'name' => 'booking_id_filter',
      'id' => 'booking_id_filter',
      'options' => ['multiple' => true, 'placeholder' => 'Search for a Booking ...'],
      'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
          'url' => $url,
          'dataType' => 'json',
          'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }')
      ],
    ]); ?>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 report-submit">
          <button type="button" onclick="filterPackingData()" class="btn btn-primary" data-toggle="tooltip"
                  title=<?= 'SEARCH' ?>> <?= 'SEARCH' ?></button>
        </div>
</div>
<!--<div class="row mt-3">
  <div id = "packing_item">

  </div>
</div>-->
  <?php ActiveForm::end(); ?>
</div>

<script>
  function filterPackingData(){

    var pickup_date = $('#filter_pickup_date').val();
    var customer_ids = $('#customer_filter').val();
    var booking_ids = $('#booking_id_filter').val();

    if(booking_ids == '' &&  customer_ids =='' && pickup_date == ''){
      alert("Please apply Filter");
    }
    $("#packing_search").submit();
    return;
    $.ajax({
      url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=packing/get-packing-item' ?>',
      type: 'post',
      dataType: 'html',
      data: {
        booking_ids: booking_ids,
        pickup_date: pickup_date,
        customer_ids: customer_ids
      },
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();

      },
      success: function (data) {
        $("#packing_item").html(data)
      },
      error: function (jqXhr, textStatus, errorThrown) {
        if (errorThrown == 'Forbidden') {
          alert('you_dont_have_access_label');
        }
      }
    });



  }
</script>