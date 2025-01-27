<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ExpenseHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expense Headers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-header-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Expense Header', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'expense_date',
            'expense_type',
            'remark:ntext',
            'image_url:url',
            //'vendor_id',
            //'name',
            //'contact_nos',
            //'address:ntext',
            //'delete_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
