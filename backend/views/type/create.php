<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TypeMaster */

$this->title = 'Create Type Master';

?>
<div class="type-master-create">

    <?= $this->render('_form', [
        'model' => $model,
        'category'=>$category,
        'status_array'=>$status_array,
    ]) ?>

</div>
