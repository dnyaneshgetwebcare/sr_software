<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    /*Old Css*/



    /*new Css*/
    'kai-admin-assets/css/bootstrap.min.css',
    'kai-admin-assets/css/plugins.min.css',
    'kai-admin-assets/css/kaiadmin.min.css',
    'js/icheck/skins/all.css',
    'css/style.css',
    'css/customize.css',
    'js/dropify/dist/css/dropify.min.css',
    'js/Magnific-Popup-master/dist/magnific-popup.css',
    //'kai-admin-assets/css/demo.css'
  ];

  public $js = [


    //'kai-admin-assets/js/core/jquery-3.7.1.min.js',
    'kai-admin-assets/js/core/popper.min.js',
    'kai-admin-assets/js/core/bootstrap.min.js',
    'kai-admin-assets/js/plugin/moment/moment.min.js',
    'kai-admin-assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
    'kai-admin-assets/js/plugin/chart.js/chart.min.js',
    'kai-admin-assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js',
    'kai-admin-assets/js/plugin/chart-circle/circles.min.js',
    'kai-admin-assets/js/plugin/datatables/datatables.min.js',
    'kai-admin-assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js',
    'kai-admin-assets/js/plugin/jsvectormap/jsvectormap.min.js',
    'kai-admin-assets/js/plugin/jsvectormap/world.js',
    'kai-admin-assets/js/plugin/sweetalert/sweetalert.min.js',
    'kai-admin-assets/js/kaiadmin.min.js',
    'js/icheck/icheck.min.js',
     'js/icheck/icheck.init.js',


    'kai-admin-assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js',
    'kai-admin-assets/js/plugin/select2/select2.full.min.js',
    'kai-admin-assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
    'js/dropify/dist/js/dropify.min.js',
    //'kai-admin-assets/js/demo.js',

  ];
  /*  public $css = [
     //'css/site.css',
    'js/bootstrap/css/bootstrap.min.css',
    'js/chartist-js/dist/chartist.min.css',
    'js/chartist-js/dist/chartist-init.css',
    'js/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css',
    'js/c3-master/c3.min.css',
    'js/icheck/skins/all.css',
    'js/datatables/media/css/jquery.dataTables.min.css',
    'js/dropify/dist/css/dropify.min.css',

    'js/Magnific-Popup-master/dist/magnific-popup.css',
    'css/colors/red-dark.css',
    //'js/sweetalert/sweetalert.css',
 ];
 public $js = [
     // 'js/jquery/jquery.min.js',
     'js/bootstrap/js/popper.min.js',
     'js/bootstrap/js/bootstrap.min.js',
     'js/jquery.slimscroll.js',
     'js/waves.js',
     'js/datatables/media/js/jquery.dataTables.min.js',
     'js/sidebarmenu.js',
     'js/sticky-kit-master/dist/sticky-kit.min.js',
     'js/sparkline/jquery.sparkline.min.js',
     'js/custom.min.js',
    'js/chartist-js/dist/chartist.min.js',
    'js/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js',
     'js/d3/d3.min.js',
     'js/c3-master/c3.min.js',
     'js/icheck/icheck.min.js',
     'js/icheck/icheck.init.js',
     //'js/dashboard1.js',
     'js/dropify/dist/js/dropify.min.js',
     'js/styleswitcher/jQuery.style.switcher.js',
     //'js/sweetalert.min.js',
     'js/Magnific-Popup-master/dist/jquery.magnific-popup.min.js',
     'js/Magnific-Popup-master/dist/jquery.magnific-popup-init.js',
     //'js/sweetalert/sweetalert.min.js',
    // 'js/sweetalert/jquery.sweet-alert.custom.js',

 ];*/
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
  ];
  /*   public $basePath = '@webroot';
     public $baseUrl = '@web';
     public $css = ['vendor/bower/admin-lte/dist/css/AdminLTE.css',
         'vendor/bower/admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css',
         'vendor/bower/admin-lte/bower_components/font-awesome/css/font-awesome.min.css',
         'vendor/bower/admin-lte/bower_components/Ionicons/css/ionicons.min.css',
         //'admin-lte/dist/css/AdminLTE.min.css',
         'vendor/bower/admin-lte/dist/css/skins/_all-skins.min.css'
         ];
     public $js = ['../../vendor/bower/admin-lte/dist/js/AdminLTE/app.js',
         '../../vendor/bower/admin-lte/bower_components/jquery/dist/jquery.min.js',
         '../../vendor/bower/admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js',
         '../../vendor/bower/admin-lte/bower_components/fastclick/lib/fastclick.js',
         '../../vendor/bower/admin-lte/dist/js/adminlte.min.js',
         '../../vendor/bower/admin-lte/dist/js/demo.js'
         ];
     public $depends = [
         'yii\web\YiiAsset',
         'yii\bootstrap\BootstrapAsset',
         'yii\bootstrap\BootstrapPluginAsset',
     ];*/
}
