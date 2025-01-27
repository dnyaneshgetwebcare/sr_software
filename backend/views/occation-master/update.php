<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OccationMaster */

$this->title = 'Update Occation: ' . $model->name;

?>
<div class="occation-master-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
