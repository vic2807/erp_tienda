<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dgom_web_assets/bootstrap-4.0.0/css/bootstrap.css',
        'dgom_web_assets/css/site-main.css',
        'dgom_web_assets/css/site-extended.css',
        'dgom_web_assets/css/switch.css',
        'dgom_web_assets/css/dgom-browser_detect.css',
        'plugins/sweet-alert/css/sweetalert2.min.css',
        'plugins/toastr/css/toastr.min.css',
        'plugins/ladda/css/ladda.min.css',
        'plugins/datatable/css/jquery.dataTables.min.css',
        'dgom_web_assets/css/site.css',
    ];
    public $js = [
        'dgom_web_assets/bootstrap-4.0.0/js/bootstrap.js',
        'dgom_web_assets/js/setup/setup.js',
        'dgom_web_assets/js/site.js',
        'plugins/ladda/js/spin.min.js',
        'plugins/ladda/js/ladda.min.js',
        'plugins/toastr/js/toastr.min.js',
        'plugins/sweet-alert/js/sweetalert2.all.min.js',
        'plugins/datatable/js/jquery.dataTables.min.js',
        'dgom_web_assets/js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
