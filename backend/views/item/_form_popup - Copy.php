<?php

use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
//use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
use kartik\file\FileInput;
// or 'use kartikile\FileInput' if you have only installed yii2-widget-fileinput in isolation

/* @var $this yii\web\View */
/* @var $model backend\models\ItemMaster */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" type="text/css" href="css/gccsite.css">
<style type="text/css">
     #targetOuter{ 
      position:relative;
      text-align: center;
      background: #ddd;
/*      margin: 5px 0px 0px 0px;*/
      width: 100px;
      height: 100px;
      border-radius: 4px;
    }
     .form-group {
         margin-bottom: 0px;
     }
     .page-titles{
         margin-bottom: 0px!important;
     }
     .form-control {
         font-size: medium;
         font-weight: 500;
     }
     .control-label {
         font-size: small;
         font-weight: 500;
     }
</style>
<div class="item-master-form">
 <div class="row">
   <div class="col-lg-12">
        <div class="error-summary-purchase alert alert-danger" id="errors_test1" style="display: none;"><p><i class="fa fa-close pull-right" onclick="$(&quot;#errors_test1&quot;).hide()"></i><h5 class="text-danger"><b><i class="fa fa-exclamation-triangle"></i> <?= 'ERRORS'; ?>:</b></h5></p>
            <hr class="custom_error_hr">
            <div id="error_display_purchase" class="custom_error"></div>
        </div>
    </div>
  <div class="col-12">
                      <div class="card" style="padding-right: 10px">
                           
                            <div class="card-body">
                                <div class="form-body">

                                           <div>
                                              
    <?php
    $dispOptions = ['class' => 'form-control kv-monospace'];

    $saveOptions = [
        'type' => 'text',
        'label'=>'<label>Saved Value: </label>',
        'class' => 'kv-saved',
        'readonly' => true,
        'tabindex' => 1000
    ];

    $saveCont = ['class' => 'kv-saved-cont','style' => 'display:none'];
    $form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'purchase_form','layout' => 'horizontal', 'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4 control-label',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-8',
        ]],'options' => ['enctype' => 'multipart/form-data']]); ?>

         <?php if($model['images']){ 
             $image_path= Yii::getAlias('@web').'/uploads/'.$model['images'];
           
            
            }else{ 
             $image_path= Yii::getAlias('@web').'/img/no-image.jpg';
             } ?>


              <div class="row">
                  <div class="col-md-6">
                   
                      <div class="form-group">
                         <input type="hidden" value="<?= $id_pass ?>" name="id"/>
                          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                      </div>
                      <div class="form-group ">
                          <?= $form->field($model, 'details')->textInput(['maxlength' => true]) ?>
                      </div>
                      <div class="form-group ">
                          <?=$form->field($model, 'category_id')->dropDownList($model_category,['prompt'=>'Select Category','class'=>'form-control','onchange'=>'getItemType(this.id,this.value)']);

                          ?>
                      </div>
                      <div class="form-group">
                         <?= $form->field($model, "type_id")->dropDownList(array()) ?>
                      </div>
                        <div class="form-group">
                          <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>
                  </div>
                  </div>
                                                   <!--/span-->
                  <div class="col-md-6">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">
                      <input type="file" id="input-file-now-custom-1" name="fileToUpload" class="dropify" data-default-file="<?= $image_path; ?>" data-allowed-file-extensions="png jpeg tiff" />
                    </div>
                    </div>
                  <!--/span-->
              </div>

              <div class="row">
                 
                       <div class="col-md-6">
                          <div class="form-group">
                          <?= $form->field($model, 'purchase_amount')->textInput(['maxlength' => true]) ?>

                                                              
                                   
                               </div>
                           </div>
                           <!--/span-->
                           <div class="col-md-6">
                               <div class="form-group">
                                   <?php
                                   /*  echo DatePicker::widget([
                                         'name' => 'ItemMaster[purchase_date]',

                                         'type' => DatePicker::TYPE_INPUT,
                                         'value'=> $model['purchase_date'],
                                         'options' => [
                                             'placeholder' => 'dd-mm-yyyy',
                                         ],
                                         'pluginOptions' => [
                                             'autoclose'=>true,
                                             'format' => 'dd-mm-yyyy'
                                         ]
                                     ]);*/
                                   if($model['purchase_date']==''){
                                       $model['purchase_date']=date('d-m-Y');
                                   }else{
                                       $model['purchase_date']=Yii::$app->formatter->asDate($model['purchase_date'],'dd-MM-Y');
                                   }
                                   echo $form->field($model, 'purchase_date')->widget(DatePicker::classname(), [
                                       'options' => ['placeholder' => 'Select date ...'],

                                       'removeButton' => false,
                                       'pluginOptions' => [
                                           'autoclose'=>true,
                                           'format' => 'dd-mm-yyyy'
                                       ]
                                   ]);
                                   /*DatePicker::widget([
                                       'name' => 'itemmaster-purchase_date',
                                       'value' => date('d-M-Y'),
                                   ]);*/ ?>
                               </div>
                           <!--/span-->
                       </div>
                       </div>

                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                 
                                     <?= $form->field($model, 'rent_amount')->textInput(['maxlength' => true]) ?>
                               </div>
                           </div>
                           <!--/span-->
                           <div class="col-md-6">
                               <div class="form-group">
                                   
           <?= $form->field($model, 'deposit_amount')->textInput(['maxlength' => true]) ?>

                             </div>
                                                           <!--/span-->
                       </div>
                      </div>
          <!--     <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <?php // $form->field($model, 'scrab_status')->dropDownList([ 'No' => 'No', 'Yes' => 'Yes', ]) ?>

                      
                  </div>
              </div>
            
              <div class="col-md-6">
                  <div class="form-group">
                    <?php // $form->field($model, 'rent_times')->textInput(['maxlength' => true]) ?>
                     
                  </div>
              </div>
                 
              </div> -->
        <!--       <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                       <?php // $form->field($model, 'expense_amount')->textInput(['maxlength' => true]) ?>
                       </div>
                  </div>
                  
                  <div class="col-md-6">
                      <div class="form-group">
                          <?php // $form->field($model, 'item_status')->dropDownList([ 'Avaliable' => 'Avaliable', 'Rented' => 'Rented', 'Booked' => 'Booked', 'Discontinued' => 'Discontinued', 'Dry Cleaning' => 'Dry Cleaning', 'Alteration' => 'Alteration', 'Repairing' => 'Repairing', ]) ?>
                          </div>
                       </div>
                                                       
                     </div> -->
  <!--        <div class="row ">
                 <div class="col-md-6">
                     <div class="form-group">
                         <?php //$form->field($model, 'colour_cat')->dropDownList($color_model,['prompt'=>'Select Color','class'=>'form-control']);?>
                        </div>
                 </div>
               
                 <div class="col-md-6">
                     <div class="form-group">

                      <?php //$form->field($model, 'nos_dry_cleaning')->textInput(['maxlength' => true]) ?>
                         <?php /*$form->field($model, 'nos_dry_cleaning')->widget(NumberControl::classname(), [
                             'maskedInputOptions' => [
                                 'min' => 0,
                                 'allowMinus' => false
                             ],
                             'options' => $saveOptions,
                             'displayOptions' => $dispOptions,
                             'saveInputContainer' => $saveCont
                         ]);*/  ?>  </div>
                 </div>
                 
             </div> -->
              <!-- <div class="row">
                 
                 
                 <div class="col-md-6">
                     <div class="form-group">
                         <?php // $form->field($model, 'vendor_id')->dropDownList($model_vendor,['prompt'=>'Select Vendor','class'=>'form-control']);?>
                     </div>
                 </div>
                 
             </div> -->
<hr>
             <input type="hidden" value="0" name="delete_status" id="delete_status"/>
       <div class="form-actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','id'=>'submit_item']) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-inverse ']) ?>
        <?php if($model->id!=""){ echo Html::a('Create Item', ['create'], ['class' => 'btn btn-info']);  } ?>
          
        </div>

    <?php ActiveForm::end(); ?>
  <!--   <label class="control-label col-sm-2 control-label" for="itemmaster-expense_amount">Image </label>
<div class="col-lg-2 image">
       <div class="bgColor pull-right" style="z-index: 1;">
      <form id="uploadForm" method="post">
         <div id="targetOuter">
          <div id="targetLayer">
       <?php //if($model['images']){  ?>
         <img src="<?php //echo Yii::getAlias('@web').'/uploads/'.$model['images'];?>" width="200px" height="200px" class="upload-preview" />
           
            <?php
           // }else{ ?>
            <img src="<?php //echo Yii::getAlias('@web').'/img/no-image.jpg';?>" width="200px" height="200px" class="upload-preview" />
            <?php // } ?>
           </div>
  
          <div id="profile-upload-option">
            <div class="profile-upload-option-list file-wrapper"><input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);"/><span style="cursor: pointer" class="button"><img src="img/icons/pencil.png" height="17px"></span></div>
            <div class="profile-upload-option-list" onClick="removeProfilePhoto();"><img src="img/icons/trash.png" height="18px" style="margin-top: 3px"></div>
       
          </div>
        </div>  
        <div>
        <input type="submit" id="submit_button" value="Upload Photo" class="btnSubmit" style="display: none" />
        </div>
      </form>
    </div>

  
  </div> -->
</div>
</div>
</div>
</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="application/javascript">
    function addnewItem() {

        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('type/get-type') ?>",
            type: 'post',

            dataType:'json',
            beforeSend: function(){
                $(".overlay").show();
            },
            complete: function(){
                $(".overlay").hide();
            },
            success: function (data) {
                // console.log(data);

            },
            error: function(jqXhr, textStatus, errorThrown ){
                // alert(errorThrown);
                if(errorThrown=='Forbidden'){
                    alert(YOU_DONT_HAVE_ACCESS);
                }
            }
        });
    }

    function getItemType(id,category_id) {
          $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=item/get-type' ?>',
            type: 'post',
            dataType:'json',
            data:{
                depdrop_parents:category_id
            },
            success: function (data) {

                //console.log(data['output'].length);
               
              var option_strng='<option>Select Type</option>';  
              for (var i = 0 ; i < data['output'].length; i++) {
                   option_strng+='<option value="'+data['output'][i]['id']+'">'+data['output'][i]['name']+'</option>';
              }
            
                var select = $('#itemmaster-type_id');
                 select.empty().append(option_strng);
               
            },
            error: function( jqXhr, textStatus, errorThrown ){
                if(errorThrown=='Forbidden'){
                    alert(you_dont_have_access_label);
                }
            }
        });
     
     }
    function submit_form(){
        $("#submit_item").click();
    }
     function removeProfilePhoto(){
      
      var logo = $('#itemmaster-images').val();
      
      $.ajax({
        url: "<?php echo \Yii::$app->getUrlManager()->createUrl('item/remove') ?>",
        type: 'post',
        data:{
          logo:logo,
         
        
        },
        beforeSend: function(){
          $(".overlay").show();
        },
        complete: function(){
          $(".overlay").hide();
        },
        success: function(data)
        {    
          $("#userImage").val('');
          $('#itemmaster-images').val('');
          $("#targetLayer").html('');
        },
        error: function(jqXhr, textStatus, errorThrown) 
        {
           if(errorThrown=='Forbidden'){
                         alert(you_dont_have_accsess_label);
                        }
        }           
      });
    }
     $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

 $("form#purchase_form").submit(function(e){

       e.preventDefault();    
    var formData = new FormData(this);
      
    $.ajax({
    url:$('#purchase_form').attr('action'),
    type: 'post',
    dataType:'json',
    cache: false,
        contentType: false,
        processData: false,
    //data:$("#purchase_form").serialize(),
    data:formData,
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
       $(".error-summary-purchase").show();
        $("#error_display_purchase").html(html);
       }else{
         console.log(data['flag']);
         if(data[0]['flag']==1){
          $(".error-summary-purchase").hide();
         selectgoodservitem(data[0]['item_id'],data[0]['item_details'],data[0]['id'],data[0]['purchase_amount'],data[0]['item_type'],data[0]['item_category'],data[0]['img_path']);  
         }else{
           $(".error-summary-purchase").show();
        $("#error_display_purchase").html("Error Please contact admin");
         }      
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

 
  });



        // Translated
       /* $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });*/

        // Used events
        var drEvent = $('#input-file-now-custom-1').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            //return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            //alert('File deleted');
            $("#delete_status").val("1");

        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        });
    });
     function removeDuplicates(json_all) {
    var arr = [];   
    $.each(json_all, function (index, value) {        
          arr[value]=(value);        
    });
    return arr;
}
</script>