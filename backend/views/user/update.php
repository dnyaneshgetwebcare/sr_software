<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Update User: {nameAttribute}', [
  'nameAttribute' => $model->name,
]);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

  <!-- <h6><?php // Html::encode($this->title) ?></h6> -->

  <?= $this->render('_form', [
    'model' => $model,
    'acive_inactive' => $acive_inactive,
    'model_labels' => $model_labels,
    // 'erp_oth_user' => $erp_oth_user,
    // 'erp_user' => $erp_user,
    'date_format_arr_php' => $date_format_arr_php,
  ]) ?>

</div>
