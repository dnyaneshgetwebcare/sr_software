<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '../../kai-admin-assets/css/bootstrap.min.css',
        '../../kai-admin-assets/css/plugins.min.css',
        '../../kai-admin-assets/css/kaiadmin.min.css',
        '../../assets/plugins/icheck/skins/all.css',
        '../../css/style.css',
    ];
    public $js = [
        '../../kai-admin-assets/js/core/bootstrap.min.js',
        '../../kai-admin-assets/js/plugin/moment/moment.min.js',
        '../../kai-admin-assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
        '../../kai-admin-assets/js/plugin/chart.js/chart.min.js',
        '../../kai-admin-assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js',
        '../../kai-admin-assets/js/plugin/chart-circle/circles.min.js',
        '../../kai-admin-assets/js/plugin/datatables/datatables.min.js',
        '../../kai-admin-assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js',
        '../../kai-admin-assets/js/plugin/jsvectormap/jsvectormap.min.js',
        '../../kai-admin-assets/js/plugin/jsvectormap/world.js',
        '../../kai-admin-assets/js/plugin/sweetalert/sweetalert.min.js',
        '../../kai-admin-assets/js/kaiadmin.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'backend\assets\AppAsset',
    ];
}
