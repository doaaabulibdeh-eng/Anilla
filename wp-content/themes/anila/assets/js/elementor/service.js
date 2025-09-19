(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            const Swipes_wrap = $('.anila-swiper', $element);

            if (Swipes_wrap.length > 0) {
                elementorFrontend.elementsHandler.addHandler(anilaSwiperBase, {
                    $element,
                });
            }

        };
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-services.default', addHandler);
    });

})(jQuery);
