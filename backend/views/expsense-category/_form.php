<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpsenseCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expsense-category-form">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'type-form','layout' => 'horizontal', 'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-2 control-label',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-6',
        ]]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

   

     <div class="box-footer pull-right">
         <button type="button" onclick="submitTypeForm()" class="btn btn-info save_submit" data-toggle="tooltip" data-original-title="Save"><img src="img/icons/save.png" style="height:12px"> Save</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>Expense</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");

    });
 function removeDuplicates(json_all) {
    var arr = [];   
    $.each(json_all, function (index, value) {        
          arr[value]=(value);        
    });
    return arr;
}
 function submitTypeForm(){
      
      //alert();

    $.ajax({
    url:$('#type-form').attr('action'),
    type: 'post',
    dataType:'json',
    data:$("#type-form").serialize(),
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
}
</script>