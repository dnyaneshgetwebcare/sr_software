<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ArrayDataProvider $dataProvider */
/** @var string $month */
/** @var string $year */

$month_names = [
    '01' => 'January', '02' => 'February', '03' => 'March',    '04' => 'April',
    '05' => 'May',     '06' => 'June',     '07' => 'July',     '08' => 'August',
    '09' => 'September','10' => 'October', '11' => 'November', '12' => 'December',
];
$monthLabel = isset($month_names[$month]) ? $month_names[$month] : $month;

$this->title = 'Order Status Report - ' . $monthLabel . ' ' . $year;

$grand_total = 0;
foreach ($dataProvider->allModels as $row) {
    $grand_total += (float)$row['total_earning'];
}

$osrConfig = [
    'ordersUrl'  => Url::to(['order-status-report/orders']),
    'bookingUrl' => Url::to(['booking/update']),
    'month'      => $month,
    'year'       => $year,
];
$this->registerJs('window.OSR = ' . Json::encode($osrConfig) . ';', yii\web\View::POS_HEAD);
?>
<style type="text/css">
    td, th { font-size: 14px; }
    .form-group { margin-bottom: 0px; }
    .osr-status-link { text-decoration: underline; cursor: pointer; }
</style>

<div class="order-status-report-index">
    <div class="row">
        <div class="col-12" style="overflow: auto;">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <?php
                        $gridColumns = [
                            [
                                'attribute' => 'order_status',
                                'header'    => 'Order Status',
                                'format'    => 'raw',
                                'headerOptions' => ['style' => 'width:50%'],
                                'value' => function ($model) {
                                    $status = ($model['order_status'] === null || $model['order_status'] === '')
                                        ? ''
                                        : $model['order_status'];
                                    $label = $status === '' ? '-' : Html::encode($status);
                                    $key   = $status === '' ? '__blank__' : $status;
                                    return Html::tag('a', $label, [
                                        'href'        => 'javascript:void(0)',
                                        'class'       => 'osr-status-link',
                                        'data-status' => $key,
                                        'data-label'  => $status === '' ? '(blank)' : $status,
                                    ]);
                                },
                                'pageSummary' => 'Grand Total',
                            ],
                            [
                                'attribute'     => 'total_earning',
                                'header'        => 'Total Earning Amount',
                                'headerOptions' => ['style' => 'width:50%; text-align:right;'],
                                'contentOptions'=> ['style' => 'text-align:right;'],
                                'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                'format'        => ['decimal', 0],
                                'pageSummary'   => $grand_total,
                            ],
                        ];

                        echo GridView::widget([
                            'id'           => 'order-status-report-grid',
                            'dataProvider' => $dataProvider,
                            'showPageSummary' => true,
                            'pageSummaryRowOptions' => ['style' => 'background:#F9F908;font-size:15px;font-weight:bold'],
                            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                            'formatter'    => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
                            'containerOptions' => ['style' => 'overflow: auto'],
                            'columns'      => $gridColumns,
                            'panel' => [
                                'type'   => GridView::TYPE_PRIMARY,
                                'before' => '
                                    <div class="pull-left report-back-btn-ar" style="margin-left:20px;">
                                        ' . Html::a('Back', Url::to(['order-status-report/filter', 'month' => $month, 'year' => $year]), ['class' => 'btn btn-default']) . '
                                    </div>
                                    <div style="text-align: center;font-size:16px;">
                                        <center><b>' . Html::encode($this->title) . '</b></center>
                                    </div>
                                ',
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="osrOverlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:1200; background:rgba(0,0,0,0.5);">
    <div id="osrPanel" style="background:#fff; max-width:720px; margin:80px auto; border-radius:6px; box-shadow:0 10px 40px rgba(0,0,0,0.3); overflow:hidden;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 16px; border-bottom:1px solid #e5e5e5;">
            <h5 style="margin:0; font-weight:600;">Orders - <span id="osrModalStatus"></span></h5>
            <button type="button" id="osrCloseBtn" style="background:none; border:0; font-size:24px; line-height:1; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:12px 16px; max-height:70vh; overflow:auto;">
            <div id="osrModalLoading" style="text-align:center; padding:20px;">Loading...</div>
            <table class="table table-striped" id="osrModalTable" style="display:none;">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th style="text-align:right;">Earning Amount</th>
                    </tr>
                </thead>
                <tbody id="osrModalBody"></tbody>
                <tfoot>
                    <tr style="font-weight:bold; background:#F9F908;">
                        <td>Total</td>
                        <td id="osrModalTotal" style="text-align:right;"></td>
                    </tr>
                </tfoot>
            </table>
            <div id="osrModalEmpty" style="display:none; text-align:center; padding:10px;">No orders found.</div>
            <div id="osrModalError" style="display:none; color:#b00; text-align:center; padding:10px;"></div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
(function(){
    function fmtAmount(v){
        var n = Number(v) || 0;
        return n.toLocaleString('en-IN', { maximumFractionDigits: 0 });
    }

    function showState(state){
        $('#osrModalLoading').toggle(state === 'loading');
        $('#osrModalTable').toggle(state === 'data');
        $('#osrModalEmpty').toggle(state === 'empty');
        $('#osrModalError').toggle(state === 'error');
    }

    function openOverlay(){ $('#osrOverlay').css('display', 'block'); }
    function closeOverlay(){ $('#osrOverlay').hide(); }

    $(document).on('click', '.osr-status-link', function(e){
        e.preventDefault();
        var status = $(this).data('status');
        var label  = $(this).data('label') || status;

        $('#osrModalStatus').text(label);
        $('#osrModalBody').empty();
        $('#osrModalTotal').text('');
        $('#osrModalError').text('');
        showState('loading');
        openOverlay();

        $.getJSON(window.OSR.ordersUrl, {
            month: window.OSR.month,
            year:  window.OSR.year,
            order_status: status
        }).done(function(resp){
            var orders = (resp && resp.orders) ? resp.orders : [];
            if (!orders.length) {
                showState('empty');
                return;
            }
            var \$body = $('#osrModalBody').empty();
            orders.forEach(function(o){
                var url = window.OSR.bookingUrl + '&id=' + encodeURIComponent(o.booking_id);
                var \$tr = $('<tr/>');
                \$tr.append(
                    $('<td/>').append(
                        $('<a/>', {
                            href: url,
                            target: '_blank',
                            rel: 'noopener',
                            text: o.booking_id
                        })
                    )
                );
                \$tr.append(
                    $('<td/>', { style: 'text-align:right;', text: fmtAmount(o.earning_amount) })
                );
                \$body.append(\$tr);
            });
            $('#osrModalTotal').text(fmtAmount(resp.total));
            showState('data');
        }).fail(function(xhr){
            var msg = 'Failed to load orders.';
            if (xhr && xhr.status) {
                msg += ' (HTTP ' + xhr.status + ')';
            }
            $('#osrModalError').text(msg);
            showState('error');
        });
    });

    $(document).on('click', '#osrCloseBtn', closeOverlay);
    $(document).on('click', '#osrOverlay', function(e){
        if (e.target && e.target.id === 'osrOverlay') closeOverlay();
    });
    $(document).on('keydown', function(e){
        if (e.key === 'Escape' && $('#osrOverlay').is(':visible')) closeOverlay();
    });
})();
JS;
$this->registerJs($js);
?>
