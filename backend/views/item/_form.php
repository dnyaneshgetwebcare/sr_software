<?php

use kartik\number\NumberControl;
use kartik\select2\Select2;
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
$user = Yii::$app->user->identity;
$is_admin = ($user->user_type == "admin") ? true : false;
?>
<link rel="stylesheet" type="text/css" href="css/gccsite.css">
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="dist_crop/imagerJs.js"></script>
<link href="dist_crop/imagerJs.css" rel="stylesheet">
<style type="text/css">
    .imager-edit-container .toolbar {
        position: absolute;
    }

    #imagers {
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .imager-test {
        display: inline-block;
        margin-top: 30px;
        margin-bottom: 100px;
    }

    .imager-test.custom-quality-visible {
        margin-bottom: 200px;
    }

    .image-container {
        min-width: 300px;
        margin-right: 30px;
        text-align: left;
    }

    #targetOuter {
        position: relative;
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

    .page-titles {
        margin-bottom: 0px !important;
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
  <div class="col-lg-12" style="padding-left: 0px">
    <div class="list-main-tab">
      <div class="list-main-tab-heading" id="matetialServiceTab">
        <ul class="nav nav-tabs customtab2" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#component_pills"
                                  role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span>
              <span class="hidden-xs-down" style="font-size: 14px;">General</span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#operation-pills"
                                  role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span>
              <span style="font-size: 14px;" class="hidden-xs-down">Image</span></a></li>

        </ul>

      </div>

    </div>
    <div class="tab-content master-main-tab"> <!-- General Tab-->
      <div class="tab-pane active in" id="component_pills">
        <div class="row">
          <div class="col-12">
            <div class="card" style="padding-right: 10px">

              <div class="card-body">
                <div class="form-body">

                  <div>
                    <input type="hidden" id="item_id" value="<?= $model->id; ?>">
                    <input type="hidden" id="nos_of_images" value="<?= sizeof($img_list); ?>">
                    <?php
                    $dispOptions = ['class' => 'form-control kv-monospace'];

                    $saveOptions = [
                      'type' => 'text',
                      'label' => '<label>Saved Value: </label>',
                      'class' => 'kv-saved',
                      'readonly' => true,
                      'tabindex' => 1000
                    ];

                    $saveCont = ['class' => 'kv-saved-cont', 'style' => 'display:none'];
                    $form = ActiveForm::begin(['layout' => 'horizontal', 'fieldConfig' => [
                      'horizontalCssClasses' => [
                        'label' => 'col-sm-4 control-label',
                        'offset' => 'col-sm-offset-2',
                        'wrapper' => 'col-sm-8',
                      ]], 'options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?php if ($model['images']) {
                      $image_path = Yii::getAlias('@web') . '/uploads/' . $model['images'];


                    } else {
                      $image_path = Yii::getAlias('@web') . '/img/no-image.jpg';
                    } ?>


                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-group">
                          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="form-group ">
                          <?= $form->field($model, 'details')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="form-group ">
                          <?= $form->field($model, 'category_id')->dropDownList($model_category, ['prompt' => 'Select Category', 'class' => 'form-control']);

                          ?>
                        </div>
                        <div class="form-group">
                          <?php
                          $type_master = ($model->category_id != '') ? ArrayHelper::map($model->category->typeMasters, 'id', 'name') : array();
                          echo $form->field($model, 'type_id')->widget(DepDrop::classname(), [
                            //'options' => ['id' => 'subcat-id'],
                            'data' => $type_master,

                            'pluginOptions' => [
                              'depends' => ['itemmaster-category_id'],
                              'placeholder' => 'Select...',
                              'url' => Url::to(['/item/get-type'])
                            ]
                          ]);
                          ?>
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
                          <!--<input type="file" id="input-file-now-custom-1" name="fileToUpload"
                                                           class="dropify" data-default-file="<? /*= $image_path; */ ?>"
                                                           data-allowed-file-extensions="png jpg jpeg tiff"/>-->
                          <img src="<?= $image_path; ?>" style="width: 200px;">
                        </div>
                      </div>
                      <!--/span-->
                    </div>

                    <div class="row">

                      <div class="col-md-6" style="<?= ($is_admin) ? "" : "display:none"; ?>">
                        <div class="form-group">
                          <?= $form->field($model, 'purchase_amount')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                              'prefix' => '₹ ',
                              'min' => 1,
                              'allowMinus' => false
                            ],
                            'options' => $saveOptions,
                            'displayOptions' => $dispOptions,
                            'saveInputContainer' => $saveCont
                          ]);// $form->field($model, 'purchase_amount')->textInput(['maxlength' => true])          ?>


                        </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6" style="<?= ($is_admin) ? "" : "display:none"; ?>">
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
                          if ($model['purchase_date'] == '') {
                            $model['purchase_date'] = date('d-m-Y');
                          } else {
                            $model['purchase_date'] = Yii::$app->formatter->asDate($model['purchase_date'], 'dd-MM-Y');
                          }
                          echo $form->field($model, 'purchase_date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Select date ...'],

                            'removeButton' => false,
                            'pluginOptions' => [
                              'autoclose' => true,
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
                          <?= $form->field($model, 'rent_amount')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                              'prefix' => '₹ ',
                              'min' => 1,
                              'allowMinus' => false
                            ],
                            'options' => $saveOptions,
                            'displayOptions' => $dispOptions,
                            'saveInputContainer' => $saveCont
                          ]);

                          ?>
                        </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                        <div class="form-group">
                          <?= $form->field($model, 'images')->hiddenInput(['readonly' => true])->label(false) ?>
                          <?= $form->field($model, 'deposit_amount')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                              'prefix' => '₹ ',
                              'min' => 0,
                              'allowMinus' => false
                            ],
                            'options' => $saveOptions,
                            'displayOptions' => $dispOptions,
                            'saveInputContainer' => $saveCont
                          ]);
                          ?> </div>
                        <!--/span-->
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <?= $form->field($model, 'scrab_status')->dropDownList(['No' => 'No', 'Yes' => 'Yes',]) ?>


                        </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                        <div class="form-group">
                          <?= $form->field($model, 'rent_times')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                              'min' => 0,
                              'allowMinus' => false
                            ],
                            'options' => $saveOptions,
                            'displayOptions' => $dispOptions,
                            'saveInputContainer' => $saveCont
                          ]); ?>
                        </div>
                      </div>
                      <!--/span-->
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <?= $form->field($model, 'expense_amount')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                              'prefix' => '₹ ',
                              'min' => 0,
                              'allowMinus' => false
                            ],
                            'options' => $saveOptions,
                            'displayOptions' => $dispOptions,
                            'saveInputContainer' => $saveCont
                          ]); ?>

                        </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                        <div class="form-group">
                          <?= $form->field($model, 'item_status')->dropDownList(['Avaliable' => 'Avaliable', 'Rented' => 'Rented', 'Booked' => 'Booked', 'Discontinued' => 'Discontinued', 'Dry Cleaning' => 'Dry Cleaning', 'Alteration' => 'Alteration', 'Repairing' => 'Repairing',]) ?>
                        </div>
                      </div>
                      <!--/span-->
                    </div>


                    <div class="row ">
                      <div class="col-md-6">
                        <div class="form-group">


                          <?= $form->field($model, 'colour_cat')->dropDownList($color_model, ['prompt' => 'Select Color', 'class' => 'form-control']); ?>
                        </div>
                      </div>
                      <!--/span-->
                      <div class="col-md-6">
                        <div class="form-group">
                          <?= $form->field($model, 'nos_dry_cleaning')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                              'min' => 0,
                              'allowMinus' => false
                            ],
                            'options' => $saveOptions,
                            'displayOptions' => $dispOptions,
                            'saveInputContainer' => $saveCont
                          ]); ?>  </div>
                      </div>

                      <!--/span-->
                    </div>
                    <div class="row">

                      <!--/span-->
                      <div class="col-md-6" style="<?= ($is_admin) ? "" : "display:none"; ?>">
                        <div class="form-group">
                          <?= $form->field($model, 'vendor_id')->dropDownList($model_vendor, ['prompt' => 'Select Vendor', 'class' => 'form-control']); ?>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" style="margin-left: 20px">
                          <label class="control-label">
                            <?= $model->getAttributeLabel('occasion_master'); ?>
                          </label>
                          <?php
                          if ($model->occasion_master != "") {
                            $occ_arry = explode(',', $model->occasion_master);
                            $model->occasion_master = $occ_arry;
                          }
                          echo Select2::widget([
                            'name' => 'ItemMaster[occasion_master]',
                            'value' => $model->occasion_master, // initial value (will be ordered accordingly and pushed to the top)
                            'data' => $occasion_master,
                            'maintainOrder' => true,
                            'options' => ['placeholder' => 'Select  ...', 'multiple' => true],
                            'pluginOptions' => [
                              'tags' => true,
                              'maximumInputLength' => 10,
                              'class' => 'form-control'
                            ],
                          ]);
                          ?> </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" style="margin-left: 20px">
                          <label class="control-label">
                            <?= $model->getAttributeLabel('display_type'); ?>
                          </label>
                          <?php
                          if ($model->display_type != "") {
                            $dis_arry = explode(',', $model->display_type);
                            $model->display_type = $dis_arry;
                          }
                          echo Select2::widget([
                            'name' => 'ItemMaster[display_type]',
                            'value' => $model->display_type, // initial value (will be ordered accordingly and pushed to the top)
                            'data' => $display_type,
                            'maintainOrder' => true,
                            'options' => ['placeholder' => 'Select  ...', 'multiple' => true],
                            'pluginOptions' => [
                              'tags' => true,
                              'maximumInputLength' => 10,
                              'class' => 'form-control'
                            ],
                          ]);
                          ?> </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" style="margin-top: 20px; font-size: 14px;margin-left: 20px">
                          <!--<label class="control-label">
                                                        <?php /*= $model->getAttributeLabel('skip_website'); */ ?>
                                                    </label>-->
                          <?= $form->field($model, 'skip_website')
                            ->checkBox(['class' => 'skip_website_class check col-sm-offset-0', 'data-checkbox' => "icheckbox_square-red"]); ?>
                        </div>
                      </div>
                    </div>

                    <hr>
                    <input type="hidden" value="0" name="delete_status" id="delete_status"/>
                    <div class="form-actions">
                      <?= Html::submitButton('Save', ['class' => 'btn btn-secondary', 'id' => 'submit_item']) ?>
                      <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
                      <?php if ($model->id != "") {
                        echo Html::a('<i class="fas fa-plus"></i>Create Item', ['create'], ['class' => 'btn btn-info']);
                      } ?>
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
      </div>
      <div class="tab-pane" id="operation-pills">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <?php if ($model->id != '') { ?>
                <div class="form-group">
                  <div id="image_list">
                    <?= $this->render('img_list', [
                      'img_list' => $img_list
                    ]) ?>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="addNew()"><i class="fas fa-plus"></i> Add new
                  </button>
                </div>
                <div class="form-group" id="imagers">
                </div>
              <?php } else {
                echo '<div class="form-group"><span class="col-lg-12 p-20 " ><h3>Add Images after saving item </h3></span> </div>';
              } ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>-->
<script type="application/javascript">


  function addnewItem() {

    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('type/get-type') ?>",
      type: 'post',

      dataType: 'json',
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      success: function (data) {
        // console.log(data);

      },
      error: function (jqXhr, textStatus, errorThrown) {
        // alert(errorThrown);
        if (errorThrown == 'Forbidden') {
          alert(YOU_DONT_HAVE_ACCESS);
        }
      }
    });
  }


  /*$('.def_change_status').on('ifChecked', function(event){
              //$('.deposite_applicable_class').iCheck('uncheck');
             //cancelBooking();
      alert();
          });*/
  function showPreview(objFileInput) {
    $.ajaxSetup({
      data: <?= \yii\helpers\Json::encode([
        \yii::$app->request->csrfParam => \yii::$app->request->csrfToken,
      ]) ?>
    });
    var img = $('#userImage').prop('files')[0]; // $('#userImage').val();
    var old_file = $('#itemmaster-images').val(); // $('#userImage').val();

    var form_data = new FormData();
    form_data.append('file', img);
    form_data.append('old_file', old_file);

    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('item/upload') ?>",
      dataType: 'html',
      type: "POST",
      data: form_data,
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      success: function (data) {
        $('#itemmaster-images').val(data);
        $("#targetLayer").css('opacity', '1');
      },
      error: function (jqXhr, textStatus, errorThrown) {
        if (errorThrown == 'Forbidden') {
          alert(you_dont_have_accsess_label);
        }
      }
    });
    // hideUploadOption();
    if (objFileInput.files[0]) {
      var fileReader = new FileReader();
      fileReader.onload = function (e) {
        $("#targetLayer").html('<img src="' + e.target.result + '" width="200px" height="200px" class="upload-preview" />');
        $("#targetLayer").css('opacity', '0.7');
        //$(".icon-choose-image").css('opacity','1');
      }
      fileReader.readAsDataURL(objFileInput.files[0]);
    }
    //uploadForm();

  }

  function submit_form() {
    $("#submit_item").click();
  }

  function removeProfilePhoto() {

    var logo = $('#itemmaster-images').val();

    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('item/remove') ?>",
      type: 'post',
      data: {
        logo: logo,


      },
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      success: function (data) {
        $("#userImage").val('');
        $('#itemmaster-images').val('');
        $("#targetLayer").html('');
      },
      error: function (jqXhr, textStatus, errorThrown) {
        if (errorThrown == 'Forbidden') {
          alert(you_dont_have_accsess_label);
        }
      }
    });
  }

  function getimagelist() {
    var item_id = $("#item_id").val();
    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('item/getimage-list') ?>",
      type: 'post',
      data: {
        item_id: item_id,
      },
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      success: function (data) {

        $("#image_list").html(data);
      },
      error: function (jqXhr, textStatus, errorThrown) {
        if (errorThrown == 'Forbidden') {
          alert(you_dont_have_accsess_label);
        }
      }
    });
  }

  function changeimagestatus(req_flag, img_id) {
    var item_id = $("#item_id").val();

    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('item/img-status') ?>",
      type: 'post',
      data: {
        req_flag: req_flag,
        item_id: item_id,
        img_id: img_id,
      },
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
        if (req_flag == "delete") {
          $("#nos_of_images").val($("#nos_of_images").val() - 1);
        }
      },
      success: function (data) {
        getimagelist();
      },
      error: function (jqXhr, textStatus, errorThrown) {
        if (errorThrown == 'Forbidden') {
          alert(you_dont_have_accsess_label);
        }
      }
    });
  }

  $(document).ready(function () {
    // Basic
    $('.dropify').dropify();

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

    drEvent.on('dropify.beforeClear', function (event, element) {
      //return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function (event, element) {
      //alert('File deleted');
      $("#delete_status").val("1");

    });

    drEvent.on('dropify.errors', function (event, element) {
      console.log('Has Errors');
    });

    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function (e) {
      e.preventDefault();
      if (drDestroy.isDropified()) {
        drDestroy.destroy();
      } else {
        drDestroy.init();
      }
    })
  });


  var pluginsConfig = {
    Rotate: {
      controlsCss: {
        width: '15px',
        height: '15px',
        background: 'white',
        border: '1px solid black'
      },
      controlsTouchCss: {
        width: '25px',
        height: '25px',
        background: 'white',
        border: '2px solid black'
      }
    },
    Resize: {
      controlsCss: {
        width: '15px',
        height: '15px',
        background: 'white',
        border: '1px solid black'
      },
      controlsTouchCss: {
        width: '25px',
        height: '25px',
        background: 'white',
        border: '2px solid black'
      }
    },
    Crop: {
      controlsCss: {
        width: '15px',
        height: '15px',
        background: 'white',
        border: '1px solid black'
      },
      controlsTouchCss: {
        width: '25px',
        height: '25px',
        background: 'white',
        border: '2px solid black'
      }
    },
    Toolbar: {
      toolbarSize: 85,
      toolbarSizeTouch: 43,
      tooltipEnabled: true,
      tooltipCss: {
        color: 'white',
        background: 'black'
      }
    },
    Delete: {
      fullRemove: true
    },
    Save: {
      upload: true,
      uploadFunction: function (imageId, imageData, callback) {
        // Here should be the code to upload image somewhere
        // to Azure, Amazon S3 or similar. When upload completes we will have
        // the url of uploaded image. Then call the function callback(image_url)
        // to notify ImagerJs that image has been uploaded to the server
        //
        // Make sure that returned path is on the same domain that imagerJs was loaded from
        // or contains proper access-control headers.
        //
        // for demo we just use some wallpaper
        var imager = this;
        var item_id = $("#item_id").val();
        var nos_of_images = $("#nos_of_images").val();
        // alert(item_id);
        //setTimeout(function() {
        //))  callback('/example/wallpaper-2997883.jpg');
        //}, 500); // emulate server call

        console.log('uploading ' + imageId);

        var data = imageData.replace(/^data:image\/(png|jpg|jpeg);base64,/, '');
        var dataJson = '{ "imageId": "' + imageId + '", "imageData" : "' + imageData + '" }';

        $.ajax({
          url: '<?php echo \Yii::$app->getUrlManager()->createUrl('item/upload-mul') ?>',
          dataType: 'json',
          //data: dataJson,
          data: {
            image_data: imageData,
            item_id: item_id,
            nos_of_images: nos_of_images,
          },
          // contentType: 'application/json; charset=utf-8',
          type: 'POST',
          success: function () {
            // callback(imageUrl); // assuming that server returns an `imageUrl` as a response
            // getimagelist();
            // $("#imagers").remove();
            var prev_nos_of_images = $("#nos_of_images").val();
            $("#nos_of_images").val(prev_nos_of_images + 1);
            location.reload();
          },
          error: function (xhr, status, error) {
            console.log(error);
          }
        });


      }
    }
  };

  var options = {
    plugins: ['Rotate', 'Crop', 'Resize', 'Save', 'Toolbar', 'Delete', 'Undo'],
    editModeCss: {},
    pluginsConfig: pluginsConfig,
    quality: {
      sizes: [
        {label: 'Original', scale: 1, quality: 1, percentage: 100},
        {label: 'Large', scale: 0.5, quality: 0.5, percentage: 50},
        {label: 'Medium', scale: 0.2, quality: 0.2, percentage: 20},
        {label: 'Small', scale: 0.05, quality: 0.05, percentage: 5}
      ],
      allowCustomSetting: true
    },
    contentConfig: {
      saveImageData: function (imageId, imageData) {
        try {
          console.log('Save button clicked! ImageId:', imageId);
          console.log('ImageData argument here is the image encoded in base64 string. ' +
            'This function gets called anytime user clicks on `save` button. ' +
            'If one wants to disable edit after saving, check the `standalone-remote-upload.html` ' +
            'example file which shows how to upload image on the server ' +
            'and display it in place of ImagerJs after that.');
          localStorage.setItem('image_' + imageId, imageData);
        } catch (err) {
          console.error(err);
        }
      }
    }
  };

  var addNew = function () {
    var $imageContainer = $(
      '<div class="image-container">' +
      '  <img class="imager-test" ' +
      '       src="" ' +
      '       style="min-width: 300px; min-height: 200px; width: 300px;">' +
      '</div>');

    $('#imagers').append($imageContainer);
    var imager = new ImagerJs.Imager($imageContainer.find('img'), options);
    imager.startSelector();

    imager.on('editStart', function () {
      // fix image dimensions so that it could be properly placed on the grid
      imager.$imageElement.css({
        minWidth: '500',
        minHeight: '500'
      });
      var qualitySelector = new window.ImagerQualitySelector(imager, options.quality);

      var qualityContainer = $('<div class="imager-quality-standalone"></div>');
      qualityContainer.append(qualitySelector.getElement());

      imager.$editContainer.append(qualityContainer);

      qualitySelector.show();
      qualitySelector.update();
    });
  };
</script>