<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FormulaMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formula-master-form">

   <?php $form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'type-form','layout' => 'horizontal', 'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4 control-label',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-6',
        ]]]); ?>

 <?php if($model->receiver_name!=''){
           	echo $form->field($model, "receiver_name")->dropDownList($model_reciver);
           }else{ echo $form->field($model, "receiver_name")->dropDownList($model_reciver,['prompt'=>'Select']); } ?>
  <?php if($model->category_id!=''){
           	echo $form->field($model, "category_id")->dropDownList($model_category);
           }else{ echo $form->field($model, "category_id")->dropDownList($model_category,['prompt'=>'Select Category']); } ?>


<?= $form->field($model, "receiver_per")->textInput(['maxlength' => true,'onkeyup'=> 'add_total_payment(this.id)','placeholder'=>'0.00','type' => 'number','min'=>0,'max' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>Formula</b><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></span>");

    });
  </script>