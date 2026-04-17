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
		'css/jquery.datetimepicker.css',
		'css/select2.min.css',
        'css/site.css?v=1.0.0.2',
    ];
    public $js = [
		'js/jquery.datetimepicker.min.js',
		'js/select2.min.js',
		'js/script.js?v=1.0.0.4',
        'js/md5-min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
