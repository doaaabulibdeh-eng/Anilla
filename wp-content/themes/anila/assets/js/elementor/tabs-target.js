(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            var tabs = $element.find('.elementor-tabs-target-item'),
                eleID = $element.data('id'),
                targetOf = 'target-of-'+eleID;
            if (tabs.length) {
                tabs.each(function(i) {
                    let link = $(this).find('.tab-target-link').attr('href');
                    if ($(link).length) {
                        $(link).addClass(targetOf);
                        if (!$(this).hasClass('actived')) {
                            $(link).hide();
                        }
                    }
                })

                // Remove inline style when event loaded
                // Using for effect
                $('#tabs-target-hidden-'+eleID+'-inline-css').empty();
            }

            var target = $element.find('.tab-target-link');
            if (target.length) {
                target.on('click', function(e) {
                    e.preventDefault();
                    if ($(this).parent().hasClass('actived')) return false;
                    
                    let link = $(this).attr('href');
                    if ($(link).length) {
                        $('.'+targetOf).hide();
                        $(link).fadeIn('slow');

                        tabs.removeClass('actived');
                        $(this).parent().addClass('actived');
                    }
                    
                    return false;
                })
            }
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-tabs-target.default', addHandler);
    });
})(jQuery);

