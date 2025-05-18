<?php
$this->title = 'Packing';
    use kartik\form\ActiveForm;
    use yii\helpers\Html;
?>
<style>
    .customer_details {
        background-color: #ffe767 !important;
    }
</style>
<div class="image-gallery">
<?php   $form = ActiveForm::begin(['id'=>'packing_submit', 'method' => 'post','action' =>
    ['packing/get-packing-item'],'enableClientValidation'=>false]); ?>
  <table class="table table-head-bg-primary mt-4 mb-5">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Details</th>
      <th scope="col">Measurement</th>
      <th scope="col">Notes</th>
    </tr>
    </thead>
    <tbody>
    <?php



    $cur_customer = null;
    $cur_booking_id = null;

    foreach ($booking_details as $booking_detail) {
      $img_url = Yii::$app->helpercomponent->getImageurl($booking_detail['images']);
      if ($cur_booking_id != $booking_detail['booking_id']) {
        $cur_booking_id = $booking_detail['booking_id'];
        ?>
        <tr>
          <td class="customer_details">
            <input type="checkbox" name="selected_header[]" value="<?= $booking_detail['booking_id']; ?>"
                   class="order_check <?= 'all_' . $booking_detail['booking_id']; ?> check">
          </td>
          <td class="customer_details" style="font-size: large; font-weight: bold"><?= date('d-m-Y',
              strtotime
              ($booking_detail['pickup_date']));
            ?></td>
          <td class="customer_details" onclick="open_booking('index.php?r=booking/update&id=<?=
            $booking_detail['booking_id']; ?>')" style="font-size: large; font-weight: bold; cursor: pointer"> <?= "(#"
            .$booking_detail['booking_id'].") - ".$booking_detail['customer_name']; ?> </td>
          <td colspan="2" class="customer_details"><?= $booking_detail['remark']; ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td style="padding: 30px !important;">
          <input type="checkbox" name="selected_item[<?= $booking_detail['booking_id']; ?>][]"
                 value="<?= $booking_detail['item_no']; ?>" data-booking-id="<?= $booking_detail['booking_id']; ?>"
                 class="<?= 'items_check item_check_' . $booking_detail['booking_id']; ?>  check"></td>
        <td><a class="image-popup-vertical-fit" href="<?= $img_url ?>"> <?= Html::img
            ($img_url, ['width' => '100', 'height' => '80']) ?> </a></td>
        <td><?= $booking_detail['description']; ?></td>
        <td><?= $booking_detail['note']; ?></td>
        <td></td>
      </tr>
      <?php
    } ?>

    </tbody>
  </table>
<button type="button" class="btn btn-info" onclick="submitpacking()" style="position: fixed; bottom: 5px ">Submit</button>
   <?php ActiveForm::end(); ?>
</div>
<?php   $form = ActiveForm::begin(['id'=>'packing_search', 'method' => 'post','action' =>
    ['packing/get-packing-item'],'enableClientValidation'=>false]); ?>
<div style="display: none">
  <input name = "filter_pickup_date" value ="<?= $post_pickup_date; ?>">
  <input name = "customer_filter" value ="<?= json_encode($customer_ids) ?>">
  <input name = "booking_id_filter" value ="<?= json_encode($booking_ids) ?>">

</div>
<?php ActiveForm::end(); ?>

<script src="kai-admin-assets/js/core/jquery-3.7.1.min.js"></script>

<script src="kai-admin-assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js"></script>
<script>
  $('.image-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    removalDelay: 300,
    gallery: {
      enabled: true,
    },
    mainClass: 'mfp-with-zoom',
    zoom: {
      enabled: true,
      duration: 300,
      easing: 'ease-in-out',
      opener: function (openerElement) {
        return openerElement.is('img') ? openerElement : openerElement.find('img');
      }
    }
  });
  let suppressEvent = false;
  $(document).ready(function () {
    $('.items_check').on('ifChanged', function (event) {
      if (suppressEvent) return;
      // Triggered when checkbox is changed (either checked or unchecked)
      var booking_id = $(this).data('booking-id');
      var all_status = $(`.item_check_${booking_id}`).filter(':checked').length === $(`.item_check_${booking_id}`).length;
      suppressEvent = true;
      if (all_status) {
        $(`.all_${booking_id}`).iCheck('check');
      } else {
        $(`.all_${booking_id}`).iCheck('uncheck');
      }
      suppressEvent = false;
    });

    $('.order_check').on('ifChecked', function (event) {
      if (suppressEvent) return;
      // Triggered when checkbox is changed (either checked or unchecked)
      var booking_id = $(this).val();
      /* var all_status = $(`item_check_${booking_id}`).filter(':checked').length === $(`item_check_${booking_id}`).length;*/

      suppressEvent = true;
      $(`.item_check_${booking_id}`).iCheck('check');
      suppressEvent = false;
      /*} else {
        $(`.item_check_${booking_id}`).iCheck('uncheck');
      }*/
    });
    $('.order_check').on('ifUnchecked', function (event) {
      if (suppressEvent) return;
      // Triggered when checkbox is changed (either checked or unchecked)
      var booking_id = $(this).val();
      /* var all_status = $(`item_check_${booking_id}`).filter(':checked').length === $(`item_check_${booking_id}`).length;*/

      suppressEvent = true;
      $(`.item_check_${booking_id}`).iCheck('uncheck');
      suppressEvent = false;
      /*} else {
        $(`.item_check_${booking_id}`).iCheck('uncheck');
      }*/
    });
  });
function open_booking(req_url){
   window.open(req_url, '_blank');
}

function submitpacking() {
 var url = $("#packing_submit").attr('action');    // Get form action URL
    var data = $("#packing_submit").serialize();
  $.ajax({
        url: url,
        type: 'post',
        data : data,
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
        success: function (data) {
          if(data['flag']){
            $("#packing_search").submit();
          }else{
            alert("Please select item");
          }
        },
        error: function( jqXhr, textStatus, errorThrown ){
          if(errorThrown=='Forbidden'){
            alert(you_dont_have_accsess_label);
          }
        }
      });
}
</script>


