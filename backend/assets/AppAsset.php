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
    'assets/plugins/icheck/skins/all.css',
    'css/style.css',
    'css/customize.css',
    'assets/plugins/dropify/dist/css/dropify.min.css',
    'assets/plugins/Magnific-Popup-master/dist/magnific-popup.css',
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
    'assets/plugins/icheck/icheck.min.js',
     'assets/plugins/icheck/icheck.init.js',


    'kai-admin-assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js',
    'kai-admin-assets/js/plugin/select2/select2.full.min.js',
    'kai-admin-assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
    'assets/plugins/dropify/dist/js/dropify.min.js',
    //'kai-admin-assets/js/demo.js',

  ];
  /*  public $css = [
     //'css/site.css',
    'assets/plugins/bootstrap/css/bootstrap.min.css',
    'assets/plugins/chartist-js/dist/chartist.min.css',
    'assets/plugins/chartist-js/dist/chartist-init.css',
    'assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css',
    'assets/plugins/c3-master/c3.min.css',
    'assets/plugins/icheck/skins/all.css',
    'assets/plugins/datatables/media/css/jquery.dataTables.min.css',
    'assets/plugins/dropify/dist/css/dropify.min.css',

    'assets/plugins/Magnific-Popup-master/dist/magnific-popup.css',
    'css/colors/red-dark.css',
    //'assets/plugins/sweetalert/sweetalert.css',
 ];
 public $js = [
     // 'assets/plugins/jquery/jquery.min.js',
     'assets/plugins/bootstrap/js/popper.min.js',
     'assets/plugins/bootstrap/js/bootstrap.min.js',
     'js/jquery.slimscroll.js',
     'js/waves.js',
     'assets/plugins/datatables/media/js/jquery.dataTables.min.js',
     'js/sidebarmenu.js',
     'assets/plugins/sticky-kit-master/dist/sticky-kit.min.js',
     'assets/plugins/sparkline/jquery.sparkline.min.js',
     'js/custom.min.js',
    'assets/plugins/chartist-js/dist/chartist.min.js',
    'assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js',
     'assets/plugins/d3/d3.min.js',
     'assets/plugins/c3-master/c3.min.js',
     'assets/plugins/icheck/icheck.min.js',
     'assets/plugins/icheck/icheck.init.js',
     //'js/dashboard1.js',
     'assets/plugins/dropify/dist/js/dropify.min.js',
     'assets/plugins/styleswitcher/jQuery.style.switcher.js',
     //'js/sweetalert.min.js',
     'assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js',
     'assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js',
     //'assets/plugins/sweetalert/sweetalert.min.js',
    // 'assets/plugins/sweetalert/jquery.sweet-alert.custom.js',

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
