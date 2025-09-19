(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(anilaSwiperBase, {
                $element,
            });

            if ($element.hasClass('anila-testimonial-layout-5')) {
                
                var initSwiperControl = () => {
                    var $slider = $element.find('.anila-swiper-testimonial-content'),
                        $item = $element.find('.elementor-testimonial-image');
                        
                    var asyncSwiper = elementorFrontend.utils.swiper;
                    new asyncSwiper($slider, {
                        spaceBetween: 10,
                        pagination: false,
                    }).then((newSwiperThumbsInstance) => {
                        $item.on('click', function (e) {
                            e.preventDefault();
                            var $this = $(this);
                            var goto = $this.closest('.caption-top').data('goto');
                            console.log(goto);
                            if (goto) {
                                newSwiperThumbsInstance.slideTo(goto);
                            }
                        });
                    });
                }

                var $wrapper = $element.find('.elementor-testimonial-item-wrapper');
                if ($wrapper.find('.anila-swiper').length) {
                    $wrapper.find('.anila-swiper').on('swiperInit', function(e, slider) {
                        initSwiperControl();
                    });  
                } 
                else {
                    initSwiperControl();
                }
            }

        };
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-testimonials.default', addHandler);
    });

    
})(jQuery);