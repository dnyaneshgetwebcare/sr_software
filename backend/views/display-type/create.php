<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DisplayType */

$this->title = 'Create Display Type';

?>
<div class="display-type-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
