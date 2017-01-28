<?php

namespace dronz\scrolledmarquee;

use yii\web\AssetBundle;

/**
 * MouseWheelAsset
 *
 * @author Alexander Koltunov <firstsano@gmail.com>
 * @link https://github.com/firstsano
 * @package firstsano\scrolledmarquee
 */
class MouseWheelAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-mousewheel';

    public $js = [
        'jquery.mousewheel.min.js'
    ];
}
