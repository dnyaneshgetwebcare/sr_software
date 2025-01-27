<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
  #err_tested_cust {
    position: relative;
    margin-left: 2px;
  }

  #errors_tested_customer {
    color: #a94442;
    font-size: 12px;
  }</style>
<div class="row">
  <div class="col-lg-12">
    <div class="error-summary" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right"
                                                                              onclick="$(&quot;.error-summary&quot;).hide()"></i>
      <h5><b><i class="fa fa-exclamation-triangle"></i><?= 'ERRORS' ?> :</b></h5></p>
      <hr class="custom_error_hr">
      <div id="error_display_update" class="custom_error"></div>
    </div>
  </div>
</div>
<?php
// $lang = strtoupper($_COOKIE['companyLang']);
// if($lang=='AR'){ ?>
<!-- <div class="user-form " style="padding:5px 0px 0px 0px">
          <?php //echo $form = ActiveForm::begin(['id' =>'user_update','enableClientValidation'=>false, 'enableAjaxValidation'=>false,'options' => ['onSubmit'=> 'return false']]); ?>
    <div class="row popup_style">

    <div class="col-lg-12">
    <div class="col-lg-7 col-sm-10 col-lg-10 col-xs-10">
        <div class="row col-lg-12">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">Name</label>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'name')->textInput(['maxlength' => true])->label(false); ?></span>
            </div>
        <div class="row col-lg-12" dir="rtl">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">Username</label>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'username')->textInput(['maxlength' => true,'autocomplete' => 'off'])->label(false); ?></span>
            </div>
               <div class="row col-lg-12" dir="rtl">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">Email</label>
                <?php // ($model->id==1)?$readonly_email=true:$readonly_email=false; ?>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'email')->textInput(['maxlength' => true,'onchange'=>'editEmail(this.value)','onkeyup'=>'editEmail(this.value)'])->label(false); ?></span>
            </div>
            <div class="row col-lg-12" dir="rtl">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">Contact No.</label>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'contact_nos')->textInput(['maxlength' => true])->label(false); ?></span>
            </div>

</div> -->
<?php // if($erp_oth_user!=null){
//echo $form->field($erp_oth_user, 'user_email')->hiddenInput(['maxlength' => true, 'dir' => 'rtl'])->label(false);


/*}else{
  $erp_oth_user=new ERPOtherUsers();
  $erp_oth_user->user_email=$model->email;
echo $form->field($erp_oth_user, 'user_email')->textInput(['maxlength' => true])->label(false);
}*/

// if($erp_user!=null){ 
//echo $form->field($erp_user, 'email')->hiddenInput(['maxlength' => true, 'dir' => 'rtl'])->label(false); 


/*}else{
$erp_user=new ERPUser();
$erp_user->email=$model->email;
echo $form->field($erp_user, 'email')->textInput(['maxlength' => true])->label(false); 
}*/

?>
<!--  <div class="form-group col-lg-5">
        <?php //echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary next-button','onclick'=>'user_update()',]) ?>
        <?php //if($model['id'] == Yii::$app->user->identity->id){ ?>
        <?php //echo Html::Button('Change Password', [ 'class' =>'btn btn-primary next-button','onclick'=>'changePassword()']) ?>
        <?php //}else{ ?>
        <?php //echo Html::Button('Reset Password', [ 'class' =>'btn btn-primary next-button','onclick'=>'resetPassword()']) ?>
        <?php //} ?>
    </div> -->
<!--    <div class="col-lg-12">
    <div class="alert alert-danger alert-dismissible" id="err_tested_cust" dir="rtl">
               <button type="button" class="close" onclick="close_alert()">&times;</button>
               <h4><i class="icon fa fa-ban"></i> Error!</h4> <div id="errors_tested_customer"> </div>
           </div>
         </div> -->

<!-- </div>

</div> -->
<?php // ActiveForm::end(); ?>
<!-- </div> -->
<?php //} else { ?>
<div class="user-form">
  <?php $form = ActiveForm::begin(['id' => 'user_update', 'enableClientValidation' => false, 'enableAjaxValidation' => false, 'options' => ['onSubmit' => 'return false']]); ?>
  <div class="row">

    <div class="col-lg-12">

      <!--<div class="row right_section">
        <div class="col-lg-12">
          <div class="form-group cust-group">
            <label class="col-lg-3 control-label label-required"><?php /*= 'NAME' */?></label>
            <div class="col-lg-6">
              <?php
/*
              echo $form->field($model, 'name')->textInput(['maxlength' => true])->label(false); */?></div>
          </div>
        </div>
      </div>-->
      <div class="row right_section">
        <div class="col-lg-12">
          <div class="form-group cust-group">
            <label class="col-lg-3 control-label"><?= 'USER_NAME' ?></label>
            <div class="col-lg-6">
              <?php $readonly_user = ($model->id != "") ? true : false;
              echo $form->field($model, 'username')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'readonly' => $readonly_user, 'style' => 'background:none'])->label(false); ?></div>
          </div>
        </div>
      </div>
      <div class="row right_section">
        <div class="col-lg-12">
          <div class="form-group cust-group">
            <label class="col-lg-3 control-label"><?= 'EMAIL' ?></label>
            <?php // ($model->id==1)?$readonly_email=true:$readonly_email=false; ?>
            <div
              class="col-lg-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true, 'onchange' => 'editEmail(this.value)', 'onkeyup' => 'editEmail(this.value)'])->label(false); ?>

              <?php //$model['old_mail']=($model['email']!='')?$model['email']:'';
              //echo  $form->field($model, 'old_mail')->textInput(['maxlength' => true,])->label(false); ?></div>
          </div>
        </div>
      </div>



      <div class="row right_section">
        <div class="col-lg-12">
          <div class="form-group cust-group">
            <div class="col-lg-5" style="font-size: 14px;color:#00ACD6;text-decoration: underline;cursor:pointer"
                 onclick="changePassword()"><?= 'CHANGE_PASSWORD' ?></div>
          </div>
        </div>
      </div>

      <?php // if($erp_oth_user!=null){
      // echo $form->field($erp_oth_user, 'user_email')->hiddenInput(['maxlength' => true])->label(false);


      /*}else{
        $erp_oth_user=new ERPOtherUsers();
        $erp_oth_user->user_email=$model->email;
      echo $form->field($erp_oth_user, 'user_email')->textInput(['maxlength' => true])->label(false);
      }*/

      // if($erp_user!=null){
      // echo $form->field($erp_user, 'email')->hiddenInput(['maxlength' => true])->label(false);


      /*}else{
      $erp_user=new ERPUser();
      $erp_user->email=$model->email;
      echo $form->field($erp_user, 'email')->textInput(['maxlength' => true])->label(false);
      }*/

      ?>
      <!--  <div class="form-group col-lg-5">
        <?php // Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary next-button','onclick'=>'user_update()',]) ?>
        <?php //if($model['id'] == Yii::$app->user->identity->id){ ?>
        <?php // Html::Button('Change Password', [ 'class' =>'btn btn-primary next-button','onclick'=>'changePassword()']) ?>
        <?php //}else{ ?>
        <?php // Html::Button('Reset Password', [ 'class' =>'btn btn-primary next-button','onclick'=>'resetPassword()']) ?>
        <?php //} ?>
    </div> -->
      <!--  <div class="col-lg-12">
        <div class="alert alert-danger alert-dismissible" id="err_tested_cust" >
                   <button type="button" class="close" onclick="close_alert()">&times;</button>
                   <h4><i class="icon fa fa-ban"></i> Error!</h4> <div id="errors_tested_customer"> </div>
               </div>
             </div> -->

    </div>

  </div>
    <button type="button" onclick="checkvalidate()"
            class="btn btn-info save_submit"
            data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png"
                                                                  style="height:12px"> Save
    </button>
  <?php ActiveForm::end(); ?>
</div>
<?php // } ?>

<script>
  var flag = 0;
  $(document).ready(function () {
    $("#err_tested_cust").hide();
    $('#heading').html('Users');
    $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>" + '<?= 'USER_PROFILE' ?>' + "</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");
    // var footer= $('.modal-footer').html();
    // $('.modal-footer').html(footer+'<button type="button" id="btn-confirm-change_password" class="btn btn-info confirm_save">Change Password</button>');

    //$('#btn-confirm-cancel').hide();
    $('#purchase_search').attr('id', 'purchase_search_user_update');
    $('#purchase_search_user_update').html('<?= 'UPDATE' ?>');
    $("#purchase_search_user_update").click(function () {
      if (flag == 1) {
        checkvalidate();
      } else if (flag == 3) {
        customer_testedCheck();
      } else {
        user_update();
      }
    });
    $('.modal').on('hidden.bs.modal', function () {
      $("#purchase_search_user_update").html('<?= 'SAVE' ?>');
      $('#purchase_search_user_update').attr('id', 'purchase_search');
    });
  });

  // var form_submit_user=false;
  function user_update() {
// if(!form_submit_user){
    // form_submit_user=true;
    // setTimeout(function() {
    // alert('1');
    $.ajax({
      url: "<?php echo Yii::$app->request->baseUrl . '/index.php?r=user/update&id=' . $model->id?>",
      type: 'POST',
      dataType: 'json',
      data: $("#user_update").serialize(),
      success: function (data) {
        // console.log(data);
        //    console.log(data);
        //    $('#err_tested_cust').show();
        //     var html='';
        //    if(data['user-email']){html+=data['user-email']+"<br>"};
        //    if(data['user-username']){html+=data['user-username']+"<br>"};
        //     if(data['user-name']){html+=data['user-name']+"<br>"};
        //     if(data['erpotherusers-user_email']){html+=data['erpotherusers-user_email']+"<br>"};
        //       if(data['erpuser-email']){html+=data['erpuser-email']+"<br>"};

        //   $("#errors_tested_customer").html(html);
        // if(html=='' && data==true){
        //    $('#pModal').modal('hide');
        //     var url = 'index.php?r=user/index';
        //      window.location.href = url;
        //    // window.location.reload();
        //    }
        $('.form-control').removeClass("errors_color");
        var html = "";
        var cleaned = removeDuplicates(data['errors']);

        for (var key in data['errors']) {
          $('#' + key).addClass("errors_color");
        }
        // console.log(data['errors']);
        for (var key in cleaned) {
          html += key + "<br>";
        }
        $("html, body").animate({scrollTop: 0}, "slow");
        if (data['error_message']) {
          html += data['error_message'];
        }
        if (html != '') {
          // alert();
          // form_submit_user=false;
          $(".error-summary").show();
          $("#error_display_update").html(html);
        } else {
          $(".error-summary").hide();
          //window.location.href = '<?php //echo Yii::$app->request->baseUrl.'/index.php?r=user/index'?>';
          window.location.reload();
          // alert(url);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        // form_submit_user=false;
        if (jqXhr['status'] == 403 || jqXhr['statusText'] == "Forbidden") {
          alert("You don't have access");
        }
      }
    });
    // },1000);
    // }
  }

  function editEmail(email) {
    $("#erpotherusers-user_email").val(email);
    $("#erpuser-email").val(email);
  }

  function changePassword() {
    $('#purchase_search_user_update').attr('id', 'purchase_search');
    $('#purchase_search').html('<?= 'CHANGE_PASSWORD' ?>');
    $.ajax({
      'url': "<?php echo Yii::$app->request->baseUrl . '/index.php?r=user%2Fchange-password&id=' . $model->id;?>",
      'dataType': 'html',
      'success': function (data) {
        $('#pModal_search').modal('show');
        $('#modalContent_search').html(data);
      }
    });
  }

  function resetPassword() {
    $.ajax({
      'url': "<?php echo Yii::$app->request->baseUrl . '/index.php?r=user%2Freset-password&id=' . $model->id;?>",
      'dataType': 'html',
      'success': function (data) {
        $('#pModal_search').modal('show');
        $('#modalContent_search').html(data);
      }
    });
  }

  function removeDuplicates(json_all) {
    var arr = [];
    $.each(json_all, function (index, value) {
      arr[value] = (value);
    });
    return arr;
  }
</script>