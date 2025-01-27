<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemMaster */

$this->title = 'Update Item: ' . $model->name;

?>
<div class="item-master-update">

    <h3><?php // Html::encode($this->title) ?></h3>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Item Master</a></li>
                <li class="breadcrumb-item active">Update Item</li>
            </ol>
        </div>

    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'model_category' => $model_category,
        'model_vendor'=>$model_vendor,
           'color_model'=>$color_model,
           'img_list'=>$img_list,
          'occasion_master'=>$occasion_master,
        'display_type'=>$display_type,
    ]) ?>

</div>
