/**
 * Divi Post Carousel Frontend JS
 */
(function($) {
    'use strict';

    // Initialize each carousel
    function initCarousels() {
        // We don't need to initialize carousels here since it's already handled in the module's render method
        // This file is here for any additional functionality that might be needed in the future
        
        // Example: Re-initialize on window resize for better responsiveness
        $(window).on('resize', function() {
            $('.dpc_carousel').slick('setPosition');
        });
        
        // Example: Re-initialize carousels when Divi's Visual Builder updates the content
        if (window.et_pb_debounce) {
            $(window).on('et_builder_api_ready', window.et_pb_debounce(function() {
                $('.dpc_carousel').each(function() {
                    if ($(this).hasClass('slick-initialized')) {
                        $(this).slick('unslick');
                    }
                    
                    $(this).slick({
                        dots: true,
                        arrows: true,
                        infinite: true,
                        speed: 500,
                        slidesToShow: Number($(this).data('slides-to-show')),
                        slidesToScroll: Number($(this).data('slides-to-scroll')),
                        autoplay: $(this).data('auto-play') === 'on',
                        autoplaySpeed: Number($(this).data('auto-play-speed')),
                        appendDots: $(this).next('.dpc_dots'),
                        // prevArrow: '<button type="button" class="slick-prev">&#8249;</button>',
                        // nextArrow: '<button type="button" class="slick-next">&#8250;</button>',
                        prevArrow: '<button type="button" class="slick-prev"><</button>',
                        nextArrow: '<button type="button" class="slick-next">></button>',
                        responsive: [
                            {
                                breakpoint: 980,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                });
            }, 200));
        }
    }

    // Initialize carousels on document ready
    $(document).ready(function() {
        initCarousels();
    });

})(jQuery); 