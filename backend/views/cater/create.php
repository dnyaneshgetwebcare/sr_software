<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */

$this->title = 'Category';

?>
<div class="category-master-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
