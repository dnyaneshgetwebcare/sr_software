<?php
$this->title = 'Item Masters';
?>
<style>
  .close{
      position: absolute;
    right: 20px;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Item Master</h4>
      </div>
      <div class="card-body">
        <div class="row image-gallery">
          <?php foreach ($item_master as $item_details) { ?>
            <div class="card col-6 col-md-3 mb-4">
              <div class="card-body" style="padding:0; align-self: center;">
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
                <div class="col-3" style = "flex-direction: row; display: flex; padding-left: 5px;   padding-right:
                5px;">
                <button class="btn btn-icon" type="button" onclick="edit_item('<?= $item_details->id; ?>')"> <i
                    class="fa
                fa-edit"></i></button>
                  <button class="btn btn-icon" type="button" onclick="view_item('<?= $item_details->id; ?>','<?= $item_details->name;
                  ?>')">  <i
                      class="fa fa-eye"></i></button>
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
  function edit_item(item_id) {
    let url = "index.php?r=item/update&id="+item_id;
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
