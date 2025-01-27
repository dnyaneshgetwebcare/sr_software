<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ColorMaster */

$this->title = 'Color Masters';

?>
<div class="color-master-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
