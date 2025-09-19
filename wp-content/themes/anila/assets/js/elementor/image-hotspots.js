(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            if ($element.hasClass('image-hotspots-type-slider')) {
                elementorFrontend.elementsHandler.addHandler(anilaSwiperBase, {
                    $element,
                });

                var active_hotspot = ($index) => {
                    $element.find('.anila-image-hotspots-main-icons').removeClass('actived');
                    $element.find('.anila-image-hotspots-main-icons[data-index="'+$index+'"').addClass('actived');
                }

                $element.on("swiperInit", function(e, slider){
                    let cur = slider.realIndex;
                    active_hotspot(cur);
                    
                    slider.on('slideChangeTransitionStart', function (e) {
                        active_hotspot(e.realIndex);
                    }); 

                    $element.find('.anila-image-hotspots-main-icons').on('click', function(e) {
                        e.preventDefault();
                        let goto = $(this).data('index');
                        slider.slideToLoop(goto);
                    })
                });
            } 
            else {
                let imgHotspotsElem = $element.find('.anila-image-hotspots-container'),
                    imgHotspotsSettings = imgHotspotsElem.data('settings'),
                    triggerClick = null,
                    triggerHover = null;
                // accordion
                let $tabs = $element.find('.elementor-accordion');
                $tabs.find('.elementor-active').show(300);
                $tabs.find('.elementor-tab-title').on('click', function () {
                    if (!$(this).hasClass('elementor-active')) {
                        $tabs.find('.elementor-tab-title').removeClass('elementor-active');
                        $tabs.find('.elementor-tab-content').removeClass('elementor-active').hide(300);
                        $(this).addClass('elementor-active');
                        let id = $(this).attr('aria-controls');
                        $tabs.find('#' + id).addClass('elementor-active').show(300);
                    }
                });
                if ($(window).width() > 767) {
                    $element.find('.elementor-accordion').scrollbar();
                }
                $(window).resize(() => {
                    if ($(window).width() > 767) {
                        $element.find('.elementor-accordion').scrollbar();
                    } else {
                        $element.find('.elementor-accordion').scrollbar('destroy');
                    }
                });
                if (imgHotspotsSettings['trigger'] === 'click') {
                    triggerClick = true;
                    triggerHover = false;
                    if ($element.find('.anila-image-hotspots-accordion').length) {
                        $element.find('.anila-image-hotspots-main-icons').on('click', function () {
                            let $tab = $($(this).data('tab'));
                            if (!$tab.hasClass('elementor-active')) {
                                $tabs.find('.elementor-tab-title').removeClass('elementor-active');
                                $tabs.find('.elementor-tab-content').removeClass('elementor-active').hide(300);
                                $tab.addClass('elementor-active');
                                let id = $tab.attr('aria-controls');
                                $tabs.find('#' + id).addClass('elementor-active').show(300);
                            }
                        });
                    }
                } else if (imgHotspotsSettings['trigger'] === 'hover') {
                    triggerClick = false;
                    triggerHover = true;
                    if ($element.find('.anila-image-hotspots-accordion').length) {
                        $element.find('.anila-image-hotspots-main-icons').on('mouseover', function () {
                            let $tab = $($(this).data('tab'));
                            if (!$tab.hasClass('elementor-active')) {
                                $tabs.find('.elementor-tab-title').removeClass('elementor-active');
                                $tabs.find('.elementor-tab-content').removeClass('elementor-active').hide(500);
                                $tab.addClass('elementor-active');
                                let id = $tab.attr('aria-controls');
                                $tabs.find('#' + id).addClass('elementor-active').show(500);
                            }
                        });
                    }
                }
                imgHotspotsElem.find('.tooltip-wrapper').tooltipster({
                    functionBefore() {
                        if (imgHotspotsSettings['hideMobiles'] && $(window).outerWidth() < 768) {
                            return false;
                        }
                    },
                    functionInit: function (instance, helper) {
                        var content = $(helper.origin).find('.tooltip-content').detach();
                        instance.content(content);
                    },
                    functionReady: function () {
                        $(".tooltipster-box").addClass("tooltipster-box-" + imgHotspotsSettings['id']);
                        $(".tooltipster-arrow").addClass("tooltipster-arrow-" + imgHotspotsSettings['id']);
                    },
                    contentCloning: true,
                    plugins: ['sideTip'],
                    animation: imgHotspotsSettings['anim'],
                    animationDuration: imgHotspotsSettings['animDur'],
                    delay: imgHotspotsSettings['delay'],
                    trigger: "custom",
                    triggerOpen: {
                        click: triggerClick,
                        tap: true,
                        mouseenter: triggerHover
                    },
                    triggerClose: {
                        click: triggerClick,
                        tap: true,
                        mouseleave: triggerHover
                    },
                    arrow: imgHotspotsSettings['arrow'],
                    contentAsHTML: true,
                    autoClose: false,
                    minWidth: imgHotspotsSettings['minWidth'],
                    maxWidth: imgHotspotsSettings['maxWidth'],
                    distance: imgHotspotsSettings['distance'],
                    interactive: true,
                    minIntersection: 16,
                    side: imgHotspotsSettings['side']
                });
            }
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/anila-image-hotspots.default', addHandler);
    });

})(jQuery);