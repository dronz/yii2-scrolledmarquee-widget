ScrolledMarquee Widget for Yii2
=======================

Renders a container which applies 'marquee' effect on its direct children. Marquee is infinite, when mousewheel
is scrolled over it the marquee speeds up, down or changes direction. Calculations during generation fake DOM
nodes include margin, padding and border, so any css style on any type of children can be applied. It also has a
feature of 'autostop' which stops the marquee when parent container is outscreened. Any depth of child nodes is
supported. Marquee in Javascript is a Class, properties of its instances can be dynamically changed. Widget uses
jQuery Mousewheel plugin, for more information, please visit [https://github.com/jquery/jquery-mousewheel](https://github.com/jquery/jquery-mousewheel)

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "dronz/yii2-scrolledmarquee-widget" "*"
```
or add

```json
"dronz/yii2-scrolledmarquee-widget" : "*"
```

to the require section of your application's `composer.json` file.


Usage
-----


***Options***

```
items - array of items that compound the widget. The syntax is as follows:
  string:
    - without tags: is converted to div tag
    - with tags: is processed as precoded html

  array: see Html::tag for documentation. It's keys - name, content, options.
         If the content - is an array, it recursively calls Html::tag.

options - array of options passed to div, containing marqueed elements. Check
          HTML::tag manual, to see the details.

clientOptions - array of options passed to javascript. Option keys are:
  delay: used in setTimeout function. Default value is 42. The less
         value - the faster objects slide.

  autostop: if set to true, objects move only when container is visible. It's
            better for perfomance. Set it to false, if you want objects to move,
            even if they are out of screen. Default: true.

  vector: determines initial direction of marquee, (1) stands for - from right
          to left, (-1) - backwards. Default: (1).

  step: step of scrolling, determines speed of marquee. Default: 1.

  maxStep: max value of step, which is used during scrolling acceleration of
           marquee. Default: 10.

  initialPosition: initial position of marquee, it's first element or last.
                   Default: 'start', any other values equals to 'end'.
```


***Using ScrolledMarquee***

```
// on your view
<?php $items = [
        'this is simple text element',
        '<a>this is html precoded text</a>',
        [
            'name' => 'a',
            'content' => 'This is html generated element through Html::tag'
        ],
        [
            'name' => 'a',
            'content' => [
                'name' => 'span',
                'content' => 'This is recursively html generated element through Html::tag'
            ]
        ]
];?>
<?= dronz\scrolledmarquee\ScrolledMarquee::widget(['items' => $items]);?>
// ...
```

P.S.
-------------------
> I created this widget for my project, but it can be easily improved. If you have interesting ideas don't
hesitate to contact me.
Feedback email: firstsano@gmail.com
