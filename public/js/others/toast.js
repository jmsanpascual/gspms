'use strict'
angular.module('toast', [])

.constant('toastConfig', {
    closable: false,
    delay: 5
})

.directive('tmjToast', function ($animate, $animateCss, $timeout, toast, toastConfig) {
    function compile(element, attr) {
        element.addClass('alert');
        element.css({
            'position': 'fixed',
            'bottom': 0,
            'left': '50%',
            'max-height': 0,
            'opacity': 0,
            'margin-bottom': '20px',
            'overflow': 'hidden',
            'z-index': 9999,
            'transform': 'translateX(-50%)',
            'transition': 'all 0.25s linear',
            '-webkit-transition': 'all 0.25s linear',
            '-webkit-box-shadow': '0 5px 15px -6px black',
            '-moz-box-shadow': '0 5px 15px -6px black',
	        'box-shadow': '0 5px 15px -6px black'
        });

        return link;
    }

    function controller($scope, $element) {
        // Removes the scope and element
        this.removeToast = function () {
            $scope.$destroy();
            $element.remove();
        };
    }

    function link(scope, element, attr, ctrl) {
        // Proceed if ngAnimate is not available
        if ($animate.enabled() === undefined) {
            animate(); // Fade in
            if (toast.closable) return; //If closable, don't fade out

            // Use timeout function instead of promise
            $timeout(function () {
                animate(); // Fade out
                $timeout(function() {
                    ctrl.removeToast(); // Remove toast after animation
                }, 500, false);
            }, (toastConfig.delay * 1000), false);
        } else {
            // Wrap inside $evalAsync to make the promise work
            scope.$evalAsync(function () {
                // Fade in
                // Use the returned promise because ngAnimate is available
                animate().done(function () {
                    if (toast.closable) return; //If closable, don't fade out

                    // Fade out
                    animate(toastConfig.delay).done(function () {
                        ctrl.removeToast(); // Remove toast after animation
                    });
                });
            });
        }

        // Animate function for fadeIn and fadeOut
        function animate(delay) {
            var toHeight = element[0].offsetHeight != 0 ? 0 : 100;
            var toOpacity = element.css('opacity') == 0 ? 1 : 0;

            return $animateCss(element, {
                from: {
                    'max-height': element[0].offsetHeight,
                    opacity: element.css('opacity')
                },
                to: {
                    'max-height': toHeight + 'px',
                    opacity: toOpacity
                },
                delay: delay
            }).start();
        }
    }

    return {
        compile: compile,
        controller: controller
    };
})

.directive('tmjToastClosable', function () {
    function template() {
        return '<button ng-click="close()" type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    + '<span aria-hidden="true">&times;</span>' +
                '</button><span ng-transclude style="margin-right: 5px;"></span>';
    }

    function link(scope, element, attr, ctrl) {
        scope.close =  ctrl.removeToast;
    }

    return {
        link: link,
        require: '^^tmjToast',
        template: template,
        transclude: true,
    };
})

.service('toast', function ($rootScope, $compile, $document, toastConfig) {
    var _self = this;
    _self.closable = false;

    /* Private functions */
    function createToast(message, type, closable) {
        var angularToastEl = null;

        if (_self.closable) {
            // If closable, add the tmjToastClosable directive to html
            var toast = '<div tmj-toast><div tmj-toast-closable>' + message + '</div></div>';
            angularToastEl = angular.element(toast);
        } else {
            var toast = '<div tmj-toast>' + message + '</div>';
            angularToastEl = angular.element(toast);
        }

        angularToastEl.addClass(type);
        return angularToastEl;
    }

    function show(message, type, closable) {
        _self.closable = closable || toastConfig.closable;
        var angularToastEl = createToast(message, type);
        var toastEl = $compile(angularToastEl)($rootScope.$new());
        var body = $document.find('body').eq(0);
        body.append(toastEl);
    }

    /* Public API functions */
    _self.success = function (message, closable) {
        show(message, 'alert-success', closable);
    };

    _self.info = function (message, closable) {
        show(message, 'alert-info', closable);
    };

    _self.warn = function (message, closable) {
        show(message, 'alert-warning', closable);
    };

    _self.error = function (message, closable) {
        show(message, 'alert-danger', closable);
    };
});
