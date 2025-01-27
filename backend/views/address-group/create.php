<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AddressGroup */

$this->title = 'Create Address Group';
$this->params['breadcrumbs'][] = ['label' => 'Address Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-group-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
