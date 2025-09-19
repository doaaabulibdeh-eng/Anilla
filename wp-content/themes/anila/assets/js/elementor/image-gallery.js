(function ($) {
    "use strict";

    
    $(window).on('elementor/frontend/init', () => {

        function getGutter(settings) {
            const elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;
            var breakpoints = {};
            let curDevice = elementorFrontend.getCurrentDeviceMode(),
                lastBreakpointSpacing = settings.column_spacing.size || 30;
                Object.keys(elementorBreakpoints).reverse().forEach(breakpointName => {
                    lastBreakpointSpacing = settings['column_spacing_' + breakpointName].size || lastBreakpointSpacing;

                    breakpoints[breakpointName] = lastBreakpointSpacing;
                });

            return breakpoints[curDevice] || 30;
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/anila-image-gallery.default', ($scope) => {
            let settings = $scope.data('settings')
            let $iso = $scope.find('.isotope-grid');
            var gutter = getGutter(settings);

            if ($iso) {
                let currentIsotope = $iso.isotope({
                    filter: '*',
                    masonry: {
                        columnWidth: '.grid__item',
                        gutter: gutter,
                    }
                });
                $scope.find('.elementor-galerry__filters li').on('click', function () {
                    $(this).parents('ul.elementor-galerry__filters').find('li.elementor-galerry__filter').removeClass('elementor-active');
                    $(this).addClass('elementor-active');
                    let selector = $(this).attr('data-filter');
                    currentIsotope.isotope({
                        filter: selector,
                        masonry: {
                            columnWidth: '.grid__item',
                            gutter: gutter,
                        }
                    });
                });

                $(window).on('resize', function() {
                    let selector = $scope.find('.elementor-galerry__filter.elementor-active').attr('data-filter');
                    currentIsotope.isotope({
                        filter: selector,
                        masonry: {
                            columnWidth: '.grid__item',
                            gutter: getGutter(settings),
                        }
                    });
                })
            }
        });
    });
})(jQuery);

