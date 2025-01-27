<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpsenseCategory */

$this->title = 'Update Expsense Category: ' . $model->name;

?>
<div class="expsense-category-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
