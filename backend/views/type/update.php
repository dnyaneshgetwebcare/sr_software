<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TypeMaster */

$this->title = 'Update Type: ' . $model->name;

?>
<div class="type-master-update">
    <?= $this->render('_form', [
        'model' => $model,
        'category'=>$category,
        'status_array'=>$status_array,
    ]) ?>

</div>
