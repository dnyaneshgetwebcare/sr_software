<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpsenseCategory */

$this->title = 'Create Expense Category';

?>
<div class="expsense-category-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
