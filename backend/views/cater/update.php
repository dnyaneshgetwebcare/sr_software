<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */

$this->title = 'Update Category: ' . $model->name;

?>
<div class="category-master-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
