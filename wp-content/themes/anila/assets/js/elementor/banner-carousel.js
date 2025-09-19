(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(anilaSwiperBase, {
                $element,
            })
        }

        if ($('.elementor-widget-anila-banner-carousel .anila-swiper').length > 0) {
            $('.elementor-widget-anila-banner-carousel .anila-swiper').on('swiperInit', function(e, slider) {
                slider.on('slideChangeTransitionStart', function (e) {
                    $('.elementor-banner-wrap-box-text .elementor-banner-box-text').hide(); 
                }); 
                
                slider.on('slideChangeTransitionEnd', function (e) {
                    $('.elementor-banner-wrap-box-text .elementor-banner-box-text').eq(e.realIndex).fadeIn();    
                }); 
            });    
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/anila-banner-carousel.default', addHandler);
    })
    
})(jQuery);

