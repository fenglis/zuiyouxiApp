<?php
namespace app\assets;

use yii\web\AssetBundle;

class EditorAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'statics/css/ueditor.min.css'
    ];
    public $js = [
        'statics/ueeditor/ueditor.config.js',
        'statics/ueeditor/ueditor.all.min.js',
        'statics/ueeditor/lang/zh-cn/zh-cn.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}