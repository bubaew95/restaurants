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
        "css/bootstrap.min.css",
        "css/settings.css",
        "css/flexslider.css",
        "css/prettyPhoto.css",
        "css/font-awesome.min.css",
        "css/less-style.css",
        "css/style.css",
    ];
    public $js = [
        //"js/jquery.js",
        "js/bootstrap.min.js",
         "js/jquery.themepunch.plugins.min.js",
         "js/jquery.themepunch.revolution.min.js",
        //"js/jquery.flexslider-min.js",
//        "js/jquery.prettyPhoto.js",
        "js/respond.min.js",
        "js/html5shiv.js",
        "js/custom.js",
        "js/main.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
}
