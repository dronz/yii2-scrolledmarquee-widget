<?php

namespace firstsano\scrolledmarquee;

use yii\web\AssetBundle;

/**
 * ScrolledMarqueeAsset
 *
 * @author Alexander Koltunov <firstsano@gmail.com>
 * @link https://github.com/firstsano
 * @package firstsano\scrolledmarquee
 */
class ScrolledMarqueeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/firstsano/yii2-scrolledmarquee-widget/assets';
    
    public $css = [
        'css/scrolled-marquee.css'
    ];

    public $js = [
        'js/scrolled-marquee.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
} 