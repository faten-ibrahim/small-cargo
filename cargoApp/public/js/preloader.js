(function ($) {
    $.fn.preloadinator = function (options) {
        'use strict';

        var settings = $.extend({
                scroll: false,
                minTime: 0,
                animation: 'fadeOut',
                animationDuration: 400,
                afterDisableScroll: function () {},
                afterEnableScroll: function () {},
                afterRemovePreloader: function () {}
            }, options),
            preloader = this,
            start = new Date().getTime();

        $.fn.preloadinator.disableScroll = function () {
            $('body').css('overflow', 'hidden');

            if (typeof settings.afterDisableScroll == 'function') {
                settings.afterDisableScroll.call(this);
            }
        }

        $.fn.preloadinator.enableScroll = function () {

            if (typeof settings.afterEnableScroll == 'function') {
                settings.afterEnableScroll.call(this);
            }
        }

        $.fn.preloadinator.removePreloader = function () {
            $(preloader)[settings.animation](settings.animationDuration, function () {
                if (settings.scroll === false) {
                    $.fn.preloadinator.enableScroll();
                }
                if (typeof settings.afterRemovePreloader == 'function') {
                    settings.afterRemovePreloader.call(this);
                }
            });
        }

        $.fn.preloadinator.minTimeElapsed = function () {
            var now = new Date().getTime(),
                elapsed = now - start;

            if (elapsed >= settings.minTime) {
                return true;
            } else {
                return false;
            }
        }

        if (settings.scroll === false) {
            $.fn.preloadinator.disableScroll();
        }

        $(window).on('load', function () {
            if ($.fn.preloadinator.minTimeElapsed()) {
                $.fn.preloadinator.removePreloader();
            } else {
                var now = new Date().getTime(),
                    elapsed = now - start;

                setTimeout($.fn.preloadinator.removePreloader, settings.minTime - elapsed);
            }
        });

        return this;
    }
}(jQuery));
$('.js-preloader').preloadinator({
    minTime:100
});
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function () {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();

