<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\ColorMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="color-master-form">
<div class="row" >
    <div class="col-lg-12">
        <div class="error-summary error-summary-sales custom-errors" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;#errors_test1&quot;).hide()"></i><h5><b><i class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b></h5></p>
            <hr class="custom_error_hr">
            <div id="error_display_sales" class="custom_error"></div>
        </div>
    </div>
</div>
    <?php $form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'color-form','layout' => 'horizontal', 'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2 control-label',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-6',
        ]]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

  
<div class="box-footer pull-right">
       <button type="button" onclick="submitCatForm()" class="btn btn-info save_submit" data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png" style="height:12px"> Save</button>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>Color</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");

    });
    function removeDuplicates(json_all) {
    var arr = [];   
    $.each(json_all, function (index, value) {        
          arr[value]=(value);        
    });
    return arr;
}
 function submitCatForm(){
      
      

    $.ajax({
    url:$('#color-form').attr('action'),
    type: 'post',
    dataType:'json',
    data:$("#color-form").serialize(),
    beforeSend: function(){
          $(".overlay").show();
        },
     complete: function(){
      $(".overlay").hide();

     },
      success: function (data) {
        // console.log(data)
       $('.form-control').removeClass("errors_color");
       var html="";
      var cleaned = removeDuplicates(data['errors']);

   // console.log(cleaned);
       for(var key in data['errors']){       
          $('#'+key).addClass("errors_color");                 
        }
        for(var key in cleaned){       
          html+=key+"<br>";
        }
       $("html, body").animate({ scrollTop: 0 }, "slow");
       if(html!=''){
       test_submit=0;
       $(".error-summary-sales").show();
        $("#error_display_sales").html(html);
       }else{
         $(".error-summary-sales").hide();        
       }
       $('#redirect_saved_changes').hide();
      },
      error: function(jqXhr, textStatus, errorThrown ){
                 //  alert(errorThrown); 
                  test_submit=1;
                    if(errorThrown=='Forbidden'){
                         alert(you_dont_have_access_label);
                        }
      }
    });

    
   // wait(3000);
   //test_submit=0;

 
  }
</script>