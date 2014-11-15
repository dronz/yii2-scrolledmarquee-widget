/**
 * @author Alexander Koltunov <firstsano@gmail.com>
 * @link https://github.com/firstsano
 */
if (typeof firstsano == "undefined" || !firstsano) {
    var firstsano = {};
}
firstsano.scrolledmarquee = (function($){
    return function (selector, opts) {
        var self = this;
        var firstRealNode = null;
        var lastRealNode = null;
        var leftInitialPosition = 0;
        var rightInitialPosition = 9999;
        self.allowMovement = false;
        self.options = {
            delay : 42,
            autostop : true,
            direction : 1,
            step: 1,
            maxStep: 10,
            initialPosition : 'start'
        };

        var offsetInsideContainer = function(el) {
            return(el.offset().left - $(selector).offset().left);
        }

        var outerSideWidth = function(el) {
            return( (el.outerWidth(true) - el.width()) / 2 );
        }

        var configureObjectsAndClones = function() {
            var children = $(selector).children();
            var containerWidth = $(selector).width();
            var elementsWidth = 0;
            lastRealNode = children.last();
            firstRealNode = children.first();
            children.each(function(i, el) {
                elementsWidth += $(el).outerWidth(true);
                $(selector).append($(el).clone());
                $(selector).prepend($(children[children.length - i - 1]).clone());
                if(elementsWidth > containerWidth) { return false; }
            });
            leftInitialPosition = offsetInsideContainer(firstRealNode) - outerSideWidth(firstRealNode);
            rightInitialPosition = offsetInsideContainer(lastRealNode) + lastRealNode.outerWidth(true)
                                - outerSideWidth(firstRealNode) - containerWidth;

            var initialPosition = (self.options.initialPosition === 'start') ? leftInitialPosition : rightInitialPosition;
            $(selector).scrollLeft(initialPosition);
        };

        var moveObjects = function() {
            var lrn = lastRealNode;
            var frn = firstRealNode;
            var offset = self.options.step * (self.options.direction / Math.abs(self.options.direction));
            var scrollLeft = $(selector).scrollLeft() + offset;
            if(offset > 0) {
                var lrnOffset = offsetInsideContainer(lrn) + lrn.outerWidth(true) - outerSideWidth(lrn);
                if(lrnOffset <= 0) {
                    scrollLeft = leftInitialPosition + lrnOffset * (-1);
                }
            } else {
                var frnOffset = offsetInsideContainer(frn) - outerSideWidth(frn) - $(selector).width();
                if(frnOffset >= 0) {
                    scrollLeft = rightInitialPosition + frnOffset * (-1);
                }
            }
            $(selector).scrollLeft(scrollLeft);

            if(self.allowMovement) {
                setTimeout(function() {moveObjects();}, self.options.delay);
            }
        };
        var moveObjectsOnFocus = function() {
            var scrolled = $(window).scrollTop();
            var wHeight = $(window).height();
            var position = $(selector).offset().top;
            var height = $(selector).height();
            if(!self.allowMovement) {
                if((scrolled + wHeight) > position) {
                    self.allowMovement = true;
                    moveObjects();
                }
            } else {
                if(scrolled > (position + height) || (scrolled + wHeight < position)) {
                    self.allowMovement = false;
                }
            }
        };
        var registerScrollEvents = function() {
            $(selector).mousewheel(function(e, delta) {
                var step = self.options.step;
                step += delta;
                if(Math.abs(step) > self.options.maxStep) {
                    step -= delta;
                } else if(!step) {
                    step += delta;
                }
                self.options.step = step;
                e.preventDefault();
            });
        };
        var registerAutocontrolEvents = function() {
            $(window).scroll(function() { moveObjectsOnFocus(); });
            $(window).load(function() { moveObjectsOnFocus(); });
        };
        var registerEvents = function() {
            var thiz = this;
            $(window).load(function() {
                thiz.scrollObjectMarquee();
            });
        };

        for(var i in opts) { self.options[i] = opts[i]; }
        self.allowMovement = !self.options.autostop;
        configureObjectsAndClones();
        if(self.options.autostop) {
            registerAutocontrolEvents();
        } else {
            moveObjects();
        }
        if($.fn.mousewheel) {
            registerScrollEvents();
        }
    };
})(jQuery);