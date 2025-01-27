<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemMaster */

$this->title = 'Create Item Master';

?>
<div class="item-master-create">

    <h3><?php // Html::encode($this->title) ?></h3>

    <?= $this->render('_form_popup', [
        'model' => $model,
        'model_category' => $model_category,
        'model_vendor'=>$model_vendor,
         'color_model'=>$color_model,
         'id_pass'=>$id_pass,
    ]) ?>

</div>
