<?php

use kartik\date\DatePicker;

$this->title = 'Item Masters';
?>
<style>
    .sidebar-style-2{
        display: none;
    }
    .main-header{
        display: none;
    }
    .close {
        position: absolute;
        right: 20px;
    }
    .container{
        margin-top:0px !important;
    }
    .main-panel{
        position: fixed;
        width: 100% !important;
    }
    .item_rent {
        position: absolute;
        right: 20px;
        text-align: center;
        bottom: 74px;
        width: 70%;
        background-color: #726f6f70;
        color: #ffffff;
    }

    .unavailable-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Dark overlay */
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2em;
    font-weight: bold;
    text-transform: uppercase;
    pointer-events: none; /* Prevent interactions */
}
    .warning-overlay {
   position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgb(255 224 192 / 50%);
    color: #ad2929;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2em;
    font-weight: bold;
    text-transform: uppercase;
    pointer-events: none;
}
    .booking_dates {
        position: absolute;
    top: 11px;
    font-size: small;
    color: white;
    font-weight: 400;
    align-self: anchor-center;
    padding-top: 50px;
    }
    .warning-booking-dates {
        position: absolute;
    top: 11px;
    font-size: small;
    color: #201414;
    font-weight: 400;
    align-self: anchor-center;
    padding-top: 50px;
    }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title col-md-7"">Item</h4>

        <div class="col-md-5">
          <div style="width: 85%">
            <?php
          echo DatePicker::widget([
            'name' => 'filter_from_date',
            'name2' => 'filter_to_date',
            'attribute' => 'from_date',

            'attribute2' => 'to_date',

            'type' => DatePicker::TYPE_RANGE,
            //'value' => $model['booking_date'],
            //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
            'options' => [
              'placeholder' => 'dd-mm-yyyy',
              'autocomplete' => 'off',
              'id' => 'from_date',
            ],
            'options2' => [
              'placeholder' => 'dd-mm-yyyy',
              'autocomplete' => 'off',
              'id' => 'to_date',
            ],
            'pluginOptions' => [
              'autoclose' => true,
              'format' => 'dd-mm-yyyy',
              'todayHighlight' => true,
              'orientation' => 'bottom',

            ]
          ]); ?>
            </div>
          <div style="position: absolute;    top: 0px;    right: 26px;">
         <button type="button" class="btn btn-icon btn-info col-lg-1" onclick="checkAvailable()" ><i class="fa fa-search"></i></button>
        <button type="button" style="position: absolute; top: 30px; left: 0; padding: 6px 5px;" class="btn btn-link col-lg-1"
                onclick="clear_check_avaiblity()" >Clear</i></button>

       </div>
        </div>
          <div class="form-group">

	<div class="selectgroup selectgroup-pills">
    <?php  foreach ($model_category as $cat_id => $category){ ?>
		<label class="selectgroup-item select_category <?= 'select_cat_'
      .$cat_id ?>">
			<input type="checkbox" value="<?= $cat_id; ?>" class="selectgroup-input select_category_input"
             onchange="filter_data()">
			<span class="selectgroup-button"> <?php echo $category; ?></span>
		</label>
		<?php } ?>
     <?php  foreach ($type_master as $type){ ?>
		<label class="selectgroup-item filter_type <?= 'filter_cat_type_'.$type['category_id'] ?>" style="display: none;">
			<input type="checkbox"  name =  "item_type[]" value="<?= $type['id']; ?>" class="selectgroup-input select_type_input"
             onchange="filter_data_type()">
			<span class="selectgroup-button"> <?php echo $type['name']; ?></span>
		</label>
		<?php } ?>
	</div>
      </div>

      </div>
      <div class="card-body" style="height: 100vh; overflow: auto">
        <div class="row image-gallery">
          <?php foreach ($item_master as $item_details) { ?>
            <div class="card col-6 col-md-3 mb-4 items_class  <?= 'cat_item_'.$item_details['category_id'] ?> <?= 'type_item_'
            .$item_details['type_id'] ?>">
              <div class="card-body card-item_view" id = "card_body_<?= $item_details->id; ?>" style="padding:0;
              align-self:
              center;">
                <a href="<?= $item_details->imageurl; ?>">
                  <img src="<?= $item_details->imageurl; ?>" class="img-fluid" style="max-height: 200px;
											min-height: 200px; align-content: center">
                </a>

              </div>
              <div class="card-footer" style="display: flex; flex-direction: row;">
                <span class="text-bold col-9">
                  <?= $item_details->name;
                  ?>
                </span>
                <div class="col-3" style="flex-direction: row; display: flex; padding-left: 5px;   padding-right:
                5px;">
                  <span style="font-size: 10px; font-weight: 500;"><?= "Size:".$item_details['size'] ?></span>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="kai-admin-assets/js/core/jquery-3.7.1.min.js"></script>
<!--	<script src="kai-admin-assets/js/core/popper.min.js"></script>
	<script src="kai-admin-assets/js/core/bootstrap.min.js"></script>-->

<!-- jQuery Scrollbar -->
<!--	<script src="kai-admin-assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>-->  <!-- Magnific Popup -->
<script src="kai-admin-assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Kaiadmin JS -->
<!--	<script src="kai-admin-assets/js/kaiadmin.min.js"></script>-->


<script>
  // This will create a single gallery from all elements that have class "gallery-item"

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
function filter_data() {

  //$('.items_class').hide();
  //let cat_class = `cat_item_${cat_id}`;
  let check_count = 0;
  $(`.select_category_input:checked`).each(function() {
    let active_cat = $(this).val();
     console.log(`Checked Cat : ${active_cat}`);
    let cat_item_class = `cat_item_${active_cat}`;
    let cat_type_class = `filter_cat_type_${active_cat}`;
    $(`.${cat_item_class}`).show();
    $(`.${cat_type_class}`).show();
    check_count++;
});

  $(`.select_category_input:not(:checked)`).each(function() {

    let active_cat = $(this).val();
    console.log(`UnCheck Cat : ${active_cat}`);
    let cat_item_class = `cat_item_${active_cat}`;
    let cat_type_class = `filter_cat_type_${active_cat}`;
    $(`.${cat_item_class}`).hide();

    $(`.${cat_type_class} .selectgroup-input`).prop('checked', false);
    $(`.${cat_type_class}`).hide();
});
  console.log(`Check Cat Count: ${check_count}`);
if(check_count == 0){
  $('.items_class').show();
}
}
function filter_data_type() {

  //$('.items_class').hide();
  //let cat_class = `cat_item_${cat_id}`;
  let check_count = 0;
  $(`.select_type_input:checked`).each(function() {
    let active_type = $(this).val();
console.log(`Checked type: ${active_type}`);
    let cat_item_class = `type_item_${active_type}`;
    $(`.${cat_item_class}`).show();
    check_count++;
});

  $(`.select_type_input:not(:checked)`).each(function() {
    let in_active_type = $(this).val();
    console.log(`UnCheck type: ${in_active_type}`);
    let cat_item_class = `type_item_${in_active_type}`;
    $(`.${cat_item_class}`).hide();
});
console.log(`Check Count: ${check_count}`);
if(check_count == 0){
  filter_data();
  //$('.items_class').show();
}

}
function checkAvailable() {
  let fromdate = $("#from_date").val();
  let todate = $("#to_date").val();

  if(fromdate == "" || todate == ""){
    swal("Dates cannot be blank");
    return;
  }
  clear_check_avaiblity()
    let selected_type = $('.select_type_input, #from_date, #to_date').serialize();
    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/check-availability') ?>",
      type: 'post',
      dataType: 'json',
      data: selected_type,
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      success: function (data) {
         console.log(data['multi_items']);
        for (let datumKey in data['multi_items']) {
          let dates = "";
          for (let i = 0; i < data['multi_items'][datumKey].length; i++) {
            dates =dates+"<br>"+data['multi_items'][datumKey][i]
          }
          setunavailable(datumKey,dates)
        }
         for (let datumKey in data['warning']) {
          let dates = "";
          for (let i = 0; i < data['warning'][datumKey].length; i++) {
            dates =dates+"<br>"+data['warning'][datumKey][i]
          }
          setwarning(datumKey,dates)
        }

      },
      error: function (jqXhr, textStatus, errorThrown) {
        // alert(errorThrown);
        if (errorThrown == 'Forbidden') {
          alert(YOU_DONT_HAVE_ACCESS);
        }
      }
    });
}
function setunavailable(item_id, booking_dates, message = "Not Available"){
    $(`#card_body_${item_id}`).css({
        "filter": "grayscale(100%)",
        "opacity": "0.6",
    }).parent().css({"position": "relative",}).append(`<div class="unavailable-overlay">${message} <span
    class = "booking_dates">
    ${booking_dates}
    </span></div>`);

}
function setwarning(item_id, booking_dates, message = "Warning"){
    $(`#card_body_${item_id}`).css({
        "filter": "grayscale(100%)",
        "opacity": "0.6",
    }).parent().css({"position": "relative",}).append(`<div class="warning-overlay">${message} <span
    class = "warning-booking-dates">
    ${booking_dates}
    </span></div>`);

}

function clear_check_avaiblity() {
  $(".unavailable-overlay").remove();
  $(".warning-overlay").remove();
   $(".card-item_view").css({
        "filter": "none",
        "opacity": "1",
    })

}

  function edit_item(item_id) {
    let url = "index.php?r=item/update&id=" + item_id;
    window.open(url, '_blank');
  }

  function view_item(item_id, item_name) {
    ///$('#pModal').modal('show');
    /*let url = "index.php?r=item/view&id="+$item_id;
     window.open(url, '_blank');*/

    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('item/open-bookings') ?>",
      type: 'get',
      dataType: 'html',
      data: {
        item_id: item_id
      },
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      success: function (data) {
        // console.log(data);
        $('#pModal').modal('show');
        $('#modal-title').html(`Item History(${item_name}`);

        $('#modalContent').html(data);
      },
      error: function (jqXhr, textStatus, errorThrown) {
        // alert(errorThrown);
        if (errorThrown == 'Forbidden') {
          alert(YOU_DONT_HAVE_ACCESS);
        }
      }
    });
  }

</script>
