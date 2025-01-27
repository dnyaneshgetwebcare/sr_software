<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VendorMaster */

$this->title = 'Create Vendor Master';
$this->params['breadcrumbs'][] = ['label' => 'Vendor Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-master-create">

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </div>

    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
