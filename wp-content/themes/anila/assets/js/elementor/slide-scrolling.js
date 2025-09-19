(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-slide-scrolling.default', ($scope) => {
            let $tickerWrapper = $(".elementor-scrolling-wrapper");
            let $list = $tickerWrapper.find(".elementor-scrolling-inner");
            let $clonedList = $list.clone();
            let listWidth = 0;

            $list.find(".elementor-scrolling-item").each(function (i) {
                listWidth += $(this, i).outerWidth(true);
            });

            let endPos = $tickerWrapper.width() - listWidth;

            $list.add($clonedList).css({
                "width" : listWidth + "px"
            });

            $clonedList.addClass("cloned").appendTo($tickerWrapper);

            //TimelineMax
            let infinite = new TimelineMax({repeat: -1, paused: true});
            let time = 40;

            infinite
                .fromTo($list, time, {rotation:0.01,x:0}, {force3D:true, x: -listWidth, ease: Linear.easeNone}, 0)
                .fromTo($clonedList, time, {rotation:0.01, x:listWidth}, {force3D:true, x:0, ease: Linear.easeNone}, 0)
                .set($list, {force3D:true, rotation:0.01, x: listWidth})
                .to($clonedList, time, {force3D:true, rotation:0.01, x: -listWidth, ease: Linear.easeNone}, time)
                .to($list, time, {force3D:true, rotation:0.01, x: 0, ease: Linear.easeNone}, time)
                .progress(1).progress(0)
                .play();

            //Pause/Play
            $tickerWrapper.on("mouseenter", function(){
                infinite.pause();
            }).on("mouseleave", function(){
                infinite.play();
            });
        });
    });

})(jQuery);
