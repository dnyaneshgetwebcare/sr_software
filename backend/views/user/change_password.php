<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">

#err_tested_cust{
  position: relative;
  margin-left: 2px;
}
#errors_tested_customer{
  color: #a94442;
  font-size:12px;
}
</style>
  <div class="row">
     <div class="col-lg-12">
      <div class="error-summary" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;.error-summary&quot;).hide()"></i><h5><b><i class="fa fa-exclamation-triangle"></i><?= 'ERRORS' ?> :</b></h5></p>
        <hr class="custom_error_hr">
        <div id="error_display_password" class="custom_error"></div>
      </div>
    </div>
  </div>
<?php
 // $lang = strtoupper($_COOKIE['companyLang']);
 // if($lang=='AR'){ ?>
		    <?php //echo $form = ActiveForm::begin(['id' => 'form_change_password','enableClientValidation'=>false, 'enableAjaxValidation'=>false,'options' => ['onSubmit'=> 'return false']]);  ?>
	<!-- 	    <div class="user-form " style="padding:5px 0px 0px 0px">
	<div class="row popup_style">
    <div class="col-lg-12">
	<div class="col-lg-9 col-sm-10 col-lg-10 col-xs-10">
        <div class="row col-lg-12" dir="rtl">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">Old Password</label>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'oldpass')->passwordInput(['maxlength' => true])->label(false); ?>
                  
                </span>
            </div>
        <div class="row col-lg-12" dir="rtl">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">New Password</label>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(false); ?></span>
            </div>
               <div class="row col-lg-12" dir="rtl">
                <label class="col-lg-4 col-sm-4 col-lg-4 col-xs-4" style="float:right;">Confirm Password</label>
                <span class="col-lg-8 col-sm-8 col-lg-8 col-xs-8"><?php //echo $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true])->label(false); ?></span>
            </div>
           

</div> -->

   <!--  <div class="form-group">
        <?php // Html::submitButton( 'Change Password', ['class' => 'btn btn-success next-button','onclick'=>'checkvalidate()']) ?>
            </div>   -->
            <!-- <div class="col-lg-12">
   <div class="alert alert-danger alert-dismissible" id="err_tested_cust" dir="rtl">
                <button type="button" class="close" onclick="close_alert()">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> <div id="errors_tested_customer"> </div>
            </div>
</div>
</div>

</div>
</div> -->

    <?php //ActiveForm::end(); ?>
    <?php //} else { ?>
    <?php $form = ActiveForm::begin(['id' => 'form_change_password','enableClientValidation'=>false, 'enableAjaxValidation'=>false,'options' => ['onSubmit'=> 'return false']]);  ?>
    <div class="user-form ">
     <div class="row">
      <div class="col-lg-12">
           <!-- <div class="row right_section">
            <div class="col-lg-12">
               <div class="form-group cust-group">
             <label class="col-lg-3 control-label label-required">Old Password</label>
             <div class="col-lg-6"><?php //echo $form->field($model, 'oldpass')->passwordInput(['maxlength' => true])->label(false); ?>
             </div>
           </div>
           </div>
           </div> -->
            <div class="row right_section">
               <div class="col-lg-12">
                 <div class="form-group cust-group">
             <label class="col-lg-4 control-label label-required"><?= 'NEW_PASSWORD' ?></label>
             <div class="col-lg-8"><?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(false); ?></div>
           </div>
         </div>
           </div>
        <div class="row right_section">
           <div class="col-lg-12">
             <div class="form-group cust-group">
            <label class="col-lg-4 control-label label-required"><?= 'CONFIRM_PASSWORD' ?></label>
            <div class="col-lg-8"><?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true])->label(false); ?></div>
          </div>
        </div>
          </div>
      </div>
     </div>
    </div>
<button type="button" onclick="checkvalidate()"
        class="btn btn-info save_submit"
        data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png"
                                                              style="height:12px"> Save
</button>

    <?php ActiveForm::end(); ?>
    <?php // } ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    flag=1;
    $("#err_tested_cust").hide();
    $('#heading').html('Users');
    $('.modal-header').html("<span style='color:black;font-size:14px;'><b>"+'<?= 'CHANGE_PASSWORD' ?>'+"</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");
    $("#purchase_search").html('<?= 'CHANGE_PASSWORD' ?>');
    $("#purchase_search").click(function(){
      if(flag==1){
          checkvalidate();
        }
    });

 $('.modal').on('hidden.bs.modal', function(){
       $("#purchase_search").html('<?= 'SAVE' ?>');
    });
});
  // function flush_password(){
  //   alert();
  //    // $('.modal-footer').html('');
  //   };  
function close_alert(){
    $('#err_tested_cust').hide();
}

var form_submit=false;
function checkvalidate(){
 if(!form_submit){
  form_submit=true;
   setTimeout(function() {
    $.ajax({
    url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=user/change-password&id='.$user_id; ?>',
    type: 'POST',
    dataType:'json',
    data:$("#form_change_password").serialize(),
      success: function (data) {
     //    $('#err_tested_cust').show();
      
     //     var html='';
     //   if(data['changepassword-confirm_password']){html+=data['changepassword-confirm_password']+"<br>"};
     //    if(data['changepassword-password']){html+=data['changepassword-password']+"<br>"};
     //    if(data['changepassword-oldpass']){html+=data['changepassword-oldpass']+"<br>"};
   
       
     //   $("#errors_tested_customer").html(html);
     // if(html=='' && data==true){ 
     //    $('#pModal').modal('hide'); 
     //     var url = 'index.php?r=user/index';
     // //    window.location.href = url;    
     //       window.location.reload();
     //    }else if(html=='' && data==2){ 
     //       $('#pModal').modal('hide'); 
     //       $("#logout_form").submit();
     //    }
       
    //     send_vendor(data); // customer no send after customer create
               $('.form-control').removeClass("errors_color");
            var html="";
            var cleaned = removeDuplicates(data['errors']);

            for(var key in data['errors']){       
              $('#'+key).addClass("errors_color");                 
            }
              console.log(data['errors']);
            for(var key in cleaned){       
              html+=key+"<br>";
            }
            $("html, body").animate({ scrollTop: 0 }, "slow");
            if(data['error_message']){
                     html+=data['error_message'];
            }
            if(html!=''){
              // alert();
               form_submit=false;
              $(".error-summary").show();
              $("#error_display_password").html(html);
            }else{
              $(".error-summary").hide(); 
                // window.location.href = '<?php //echo Yii::$app->request->baseUrl.'/index.php?r=user/index'?>'; 
                 window.location.reload();
                // alert(url);      
            }

          
           },
          error: function( jqXhr, textStatus, errorThrown ){
              form_submit=false;
             if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS' ?>");
                        } 
          }
      
    });
   },1000);
  }
}
function removeDuplicates(json_all) {
        var arr = [];   
        $.each(json_all, function (index, value) {        
          arr[value]=(value);        
        });
        return arr;
      }
</script>
