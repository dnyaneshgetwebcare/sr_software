<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AddressGroup */

$this->title = 'Update Address Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Address Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="address-group-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
