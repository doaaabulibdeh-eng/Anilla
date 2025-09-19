(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/anila-video-popup.default', ($scope) => {
            if ($scope.hasClass('elementor-anila-video-style-background')) {
                // Load YT Iframe API
                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                var scopeId = $scope.data('id'),
                    innerScope = $scope.find('.elementor-widget-container'),
                    btnPlay = $scope.find('.elementor-video-popup'),
                    player;

                function getVideoId(url) {
                    let regex = /(youtu.*be.*)\/(watch\?v=|embed\/|v|shorts|)(.*?((?=[&#?])|$))/gm;
                    return regex.exec(url)[3];
                }

                function onYouTubeIframeAPIReady(videoId) {
                    player = new YT.Player(`anila-vid-bg-${scopeId}`, {
                        height: '100%',
                        width: '100%',
                        videoId: videoId,
                        playerVars: {
                            loop: 1,
                            controls: 0,
                            rel: 0,
                            cc_load_policy: 0,
                            iv_load_policy: 3,
                            fs: 0,
                            vq: 'hd720',
                            // disablekb: 0,
                        },
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                };

                function onPlayerStateChange(event) {
                    if (event.data == YT.PlayerState.PAUSED) {
                        $(`#anila-vid-bg-${scopeId}`).fadeOut();
                    }
                }

                function onPlayerReady(event) {
                    event.target.playVideo();
                }

                btnPlay.click(function(e) {
                    e.preventDefault();

                    var videoId = getVideoId(btnPlay.data('url'));
                    if (!videoId) {
                        console.error('Please input a video url');
                        return;
                    }

                    if (typeof YT == 'undefined') {
                        return;
                    }

                    if (!innerScope.find(`#anila-vid-bg-${scopeId}`).length) {
                        innerScope.append(`<div id="anila-vid-bg-${scopeId}" class="anila-vid-bg"></div>`);
                        onYouTubeIframeAPIReady(videoId);
                    }
                    else {
                        player.playVideo();
                    }
                    
                    $(`#anila-vid-bg-${scopeId}`).fadeIn();
                    
                });
            } 
            else {
                $scope.find('.anila-video-popup a.elementor-video-popup').magnificPopup({
                    type: 'iframe',
                    removalDelay: 500,
                    midClick: true,
                    closeBtnInside: true,
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = this.st.el.attr('data-effect');
                        }
                    },
                });
                
            }
        });
    });
})(jQuery);
