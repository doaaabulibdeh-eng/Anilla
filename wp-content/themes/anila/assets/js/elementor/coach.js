(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(anilaSwiperBase, {
                $element,
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-coach.default', addHandler);
    });
})(jQuery);

