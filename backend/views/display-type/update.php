<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DisplayType */

$this->title = 'Update Display Type: ' . $model->name;

?>
<div class="display-type-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
