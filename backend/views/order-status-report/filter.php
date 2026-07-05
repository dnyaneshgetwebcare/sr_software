<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var string $month */
/** @var string $year */

$this->title = 'Order Status Report';

$month_array = [
    '01' => 'January', '02' => 'February', '03' => 'March',    '04' => 'April',
    '05' => 'May',     '06' => 'June',     '07' => 'July',     '08' => 'August',
    '09' => 'September','10' => 'October', '11' => 'November', '12' => 'December',
];
$year_array = range(date('Y') - 5, date('Y') + 1, 1);
?>
<style type="text/css">
    .osr-filter-card .form-group { margin-bottom: 15px; }
    .osr-filter-card .form-control { font-size: medium; font-weight: 500; }
</style>

<div class="row page-header no-status-page-header">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
            <h4><b><?= Html::encode($this->title) ?></b></h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card osr-filter-card">
            <div class="card-body">
                <form id="order_status_report_form" method="post"
                      action="<?= Url::to(['order-status-report/report']) ?>">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="osr-month" class="control-label"> Month </label>
                                <select name="month" id="osr-month" class="form-control">
                                    <?php foreach ($month_array as $key => $mLabel): ?>
                                        <option value="<?= $key ?>" <?= ($key == $month) ? 'selected' : '' ?>>
                                            <?= $mLabel ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="osr-year" class="control-label"> Year </label>
                                <select name="year" id="osr-year" class="form-control">
                                    <?php foreach ($year_array as $y): ?>
                                        <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding-top: 25px;">
                            <button type="submit" class="btn btn-primary"> SUBMIT </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
