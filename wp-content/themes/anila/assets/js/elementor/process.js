(function ($) {
    "use strict";

    function hoverProcess($element) {
        var items = $element.find('.anila-inner-process');
        if (items.length) {
            items.on({
                mouseenter: function() {
                    var index = $(this).data('index'),
                        targetImg = $element.find(`.anila-process-image.img-${index}`);

                    if($(this).hasClass('activate')) return;

                    items.removeClass('activate');
                    $(this).addClass('activate');

                    $element.find('.anila-process-image').removeClass('show');
                    targetImg.addClass('show');
                },
                mouseleave: function() {
                    //stuff to do on mouse leave
                }
            });
        }
    }

    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(anilaSwiperBase, {
                $element,
            });

            if ($element.hasClass('elementor-process-layout-2')) {
                if ($element.find('.anila-swiper').length) {
                    $element.find('.anila-swiper').on('swiperInit', function(e, slider) {
                        hoverProcess($(slider.el));
                    })
                }
                else {
                    hoverProcess($element);
                }
            }
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-process.default', addHandler);
    });
})(jQuery);

