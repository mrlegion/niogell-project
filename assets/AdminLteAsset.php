<?php


namespace app\assets;


use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/';
    public $css = [
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
        'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'dist/css/adminlte.min.css',
        'plugins/fontawesome-free/css/all.min.css',
//        'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
//        'plugins/jqvmap/jqvmap.min.css',
//        'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'plugins/daterangepicker/daterangepicker.css',
//        'plugins/summernote/summernote-bs4.css',
    ];

    public $js = [
//        'plugins/chart.js/Chart.min.js',
//        'plugins/sparklines/sparkline.js',
//        'plugins/jqvmap/jquery.vmap.min.js',
//        'plugins/jqvmap/maps/jquery.vmap.usa.js',
//        'plugins/jquery-knob/jquery.knob.min.js',
//        'plugins/moment/moment.min.js',
        'plugins/daterangepicker/daterangepicker.js',
//        'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
//        'plugins/summernote/summernote-bs4.min.js',
        'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        'dist/js/adminlte.min.js',
//        'dist/js/pages/dashboard.js',
//        'dist/js/demo.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'yii\jui\JuiAsset',
    ];
}