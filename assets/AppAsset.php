<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/Site.js',
        'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',// таблица
        'http://code.jquery.com/jquery-1.10.2.js',
        'http://code.jquery.com/ui/1.11.3/jquery-ui.js',
        //'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js', //квадрат
        //'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
