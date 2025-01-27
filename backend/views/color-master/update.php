<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ColorMaster */

$this->title = 'Update Color: ' . $model->name;


?>
<div class="color-master-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
