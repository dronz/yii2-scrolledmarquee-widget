<?php
namespace dronz\scrolledmarquee;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * ScrolledMarquee renders template and start infinite scrolling marquee
 *
 * @author Alexander Koltunov <firstsano@gmail.com>
 * @link https://github.com/firstsano
 * @package firstsano\scrolledmarquee
 */
class ScrolledMarquee extends Widget
{
    /**
     * @var array The array of items that compound the widget. The syntax is as follows:
     *
     * - string
     *      - without tags: is converted to div tag
     *      - with tags: is processed as precoded html
     * - array: see Html::tag for documentation. It's keys - name, content, options. If the content - is an
     *          array, it recursively calls Html::tag.
     */
    public $items = [];
    /**
     * @var array The array of options passed to div, containing marqueed elements.
     * Check HTML::tag manual, to see the details.
     */
    public $options = [];
    /**
     * @var array The array of options passed to javascript. Used options are:
     * 
     * - delay    : used in setTimeout function. Default value is 42. The less value - the faster objects slide.
     * - autostop : if set to true, objects move only when container is visible. It's better for perfomance. Set
     *              it to false, if you want objects to move, even if they are out of screen. Default: true.
     * - vector   : determines initial direction of marquee, (1) stands for - from right to left,
     *              (-1) - backwards. Default: (1).
     * - step     : step of scrolling, determines speed of marquee. Default: 1.
     * - maxStep  : max value of step, which is used during scrolling acceleration of marquee. Default: 10.
     * - initialPosition : initial position of marquee, it's first element or last. Default: 'start', any other
     *                     values equals to 'end'.
     */
    public $clientOptions = [];
    
    public function init()
    {
        parent::init();
        $this->options['id'] = ArrayHelper::getValue($this->options, 'id', $this->getId());
        $this->options['class'] = ArrayHelper::getValue($this->options, 'class', '') . ' scrolled-marquee';
    }

    public function run()
    {
        if(empty($this->items)) {
            return null;
        }
        echo $this->renderItems();
        $this->registerClientScripts();
    }

    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }

        return Html::tag('div', implode('', $items), $this->options);
    }

    public function renderItem($item)
    {
        if(is_string($item)) {
            if($item != strip_tags($item)) {
                return $item;
            }
            return Html::tag('div', $item);
        }

        $name = ArrayHelper::getValue($item, 'name', 'div');
        $content = ArrayHelper::getValue($item, 'content');
        if(is_array($content)) {
            $content = renderItem($content);
        }
        $options = ArrayHelper::getValue($item, 'options', []);

        return Html::tag($name, $content, $options);
    }

    public function registerClientScripts()
    {
        $view = $this->getView();
        ScrolledMarqueeAsset::register($view);

        $id = $this->options['id'];
        $options = Json::encode($this->clientOptions);
        $js = "new firstsano.scrolledmarquee('#$id', $options);";
        $view->registerJs($js);
    }
}
