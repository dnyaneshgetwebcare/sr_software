<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'SIGNUP';
// $this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  .sales-table > thead > tr > th {
    border-left:none !important;
    border-right:none !important;
}

#err_tested_cust{
  position: relative;
  margin-left: 2px;
}
#errors_tested_customer{
  color: #a94442;
  font-size:12px;
}
</style>
   <div class="row" >
     <div class="col-lg-12">
      <div class="error-summary" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;.error-summary&quot;).hide()"></i><h5><b><i class="fa fa-exclamation-triangle"></i><?= 'ERRORS'; ?>:</b></h5></p>
        <hr class="custom_error_hr">
        <div id="error_display" class="custom_error"></div>
      </div>
    </div>
  </div>
  <?php $form = ActiveForm::begin(['id' => 'form-signup','enableClientValidation'=>false, 'enableAjaxValidation'=>false,'options' => ['onSubmit'=> 'return false']]); ?>
<div class="row">
    <div class="col-lg-12">
            
            <div class="row right_section">
              <div class="col-lg-12">
              <div class="form-group cust-group">
                <label class="col-lg-3 control-label label-required"><?= 'NAME'; ?></label>
                <div class="col-lg-6"><?= $form->field($model, 'name')->textInput(['autofocus' => true])->label(false); ?></div>
              </div>
            </div>
            </div>

             <div class="row right_section">
              <div class="col-lg-12">
                 <div class="form-group cust-group">
                <label class="col-lg-3 control-label label-required"><?= 'USER_NAME'; ?></label>
                <div class="col-lg-6"><?= $form->field($model, 'username')->textInput(['maxlength'=>10,'autocomplete' => 'off'])->label(false); ?></div>
              </div>
            </div>
            </div>

            <div class="row right_section">
              <div class="col-lg-12">
                 <div class="form-group cust-group">
                 <label class="col-lg-3 control-label label-required"><?= 'EMAIL'; ?></label>
                <div class="col-lg-6"><?= $form->field($model, 'email',['inputOptions' => [
                   'autocomplete' => 'off']])->label(false); ?></div>
                 </div>
               </div>
             </div>

             <div class="row right_section">
              <div class="col-lg-12">
                 <div class="form-group cust-group">
                 <label class="col-lg-3 control-label"><?= 'CONTACT_NO'; ?></label>
                <div class="col-lg-6"><?= $form->field($model, 'contact_nos',['inputOptions' => [
                   'autocomplete' => 'off']])->label(false); ?></div>
                 </div>
               </div>
             </div>

              <div class="row right_section">
                 <div class="col-lg-12">
                   <div class="form-group cust-group">
                <label class="col-lg-3 control-label label-required"><?= 'PASSWORD'; ?></label>
                <div class="col-lg-6"><?= $form->field($model, 'password')->passwordInput()->label(false) ?></div>
             </div>
           </div>
           </div>

               <div class="row right_section">
                 <div class="col-lg-12">
                   <div class="form-group cust-group">
                <label class="col-lg-3 control-label label-required"><?= 'CONFIRM_PASSWORD'; ?></label>
                <span class="col-lg-6"><?= $form->field($model, 'confirm_password')->passwordInput()->label(false) ?></span>
              </div>
            </div>
             </div>
  
    <!--      <div class="form-group">
           <?php // Html::submitButton('Save', ['class' => 'btn btn-success next-button' ,'onclick'=>'customer_testedCheck()', 'data' => ['disabled-text' => 'Please Wait']])
         ?>
           
               
    </div> -->
    <div class="col-lg-12">
    <div class="alert alert-danger alert-dismissible" id="err_tested_cust" >
                <button type="button" class="close" onclick="close_alert()">&times;</button>
                <h4><i class="icon fa fa-ban"></i><?= 'ERRORS'; ?> ! </h4> <div id="errors_tested_customer"> </div>
            </div>
          </div>
    </div>
 

</div>

<button type="button" onclick="customer_testedCheck()"
        class="btn btn-info save_submit"
        data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png"
                                                              style="height:12px"> Save
</button>
    <?php ActiveForm::end();?>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
 <script>
      $( document ).ready(function() {
        $("#err_tested_cust").hide();
    // $('#heading').html('Users');
      $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>"+'<?= 'USER_PROFILE'; ?>'+"</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");

});
      function form_submit(){
            //$("#errors").show();
      }
</script>

<script type="text/javascript">
  $(document).ready(function(){
    flag=3;
       $("#purchase_search").click(function(){
        if(flag==3){
          customer_testedCheck();
        }
       
      });
  });
   function close_alert(){
        $('#err_tested_cust').hide();
     }
   var form_submit=false;
  function customer_testedCheck(){
   if(!form_submit){
    form_submit=true;
    setTimeout(function() {
    $.ajax({
    url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=user/signup'?>',
    type: 'POST',
    dataType:'json',
    data:$("#form-signup").serialize(),
     beforeSend: function(){
          $(".overlay").show();
        },
   complete: function(){
    $(".overlay").hide();
   },
      success: function (data) {
        // alert(data[0]['user_id']);
        console.log(data);
       // alert(data[0]['user_id']);
     //    if(data['flag']){
     //          window.location.href = '<?php echo Yii::$app->request->baseUrl.'/index.php?r=user/index'?>';
     //          return;
     //    }
     //    $('#err_tested_cust').show();
     //     var html='';
     //     if(data['signupform-name']){html+=data['signupform-name']+"<br>"};
     //     if(data['signupform-username']){html+=data['signupform-username']+"<br>"};
     //     if(data['signupform-email']){html+=data['signupform-email']+"<br>"};
     //     if(data['signupform-password']){html+=data['signupform-password']+"<br>"};
     //  if(data['signupform-confirm_password']){html+=data['signupform-confirm_password']+"<br>"};
       
     //   $("#errors_tested_customer").html(html);
     // if(html=='' && data!=0){ 
     //    $('#pModal').modal('hide'); 
     //     var url = 'index.php?r=auth/rbac/roles&id='+data;
     //    // window.location.href = url;   
     //  //  window.location.reload(); 
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
              $("#error_display").html(html);
            }else{
              $(".error-summary").hide(); 
                window.location.href = '<?php echo Yii::$app->request->baseUrl.'/index.php?r=user/index'?>';
                // alert(url);      
            }
            
            // $('#redirect_saved_changes').hide();
       },
      error: function( jqXhr, textStatus, errorThrown ){
         form_submit=false;
                if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS'; ?>");
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

