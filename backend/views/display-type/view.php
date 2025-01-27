<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DisplayType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Display Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="display-type-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'deatils_type',
            'status',
            [
            'attribute'=>'main_screen_active',
                'format' => 'boolean',
    'header'=>'Website',

                'value' =>'main_screen_active'],
        ],
    ]) ?>

</div>
