(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-image-before-after.default', ($scope) => {
            let $beforeAfter = $('.elementor-image-before-after', $scope);
            $beforeAfter.beforeAfter({
                movable: true,
                clickMove: true,
                position: 60,
                separatorColor: '#fafafa',
                bulletColor: '#fafafa',
                onMoveStart: function(e) {
                    // console.log(e.target);
                },
                onMoving: function() {
                    // console.log(e.target);
                },
                onMoveEnd: function() {
                    // console.log(e.target);
                },
            });
        });
    });

})(jQuery);
