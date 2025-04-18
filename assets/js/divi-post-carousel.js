/**
 * Divi Post Carousel Frontend JS
 */
(function($) {
    'use strict';

    // Initialize carousels on document ready
    $(document).ready(function() {
        initCarousels();
    });

    // Initialize carousels
    function initCarousels() {
        // Initialize post carousels
        initPostCarousels();
        
        // Initialize custom carousels
        initCustomCarousels();
    }

    // Initialize post carousels
    function initPostCarousels() {
        $('.dpcm-post-carousel').each(function() {
            const $carousel = $(this);
            
            if (!$carousel.hasClass('slick-initialized')) {
                // Get settings from data attributes or use defaults
                const slidesToShow = parseInt($carousel.data('slides-to-show') || 3, 10);
                const slidesToScroll = parseInt($carousel.data('slides-to-scroll') || 1, 10);
                const autoplay = $carousel.data('autoplay') === 'on';
                const autoplaySpeed = parseInt($carousel.data('autoplay-speed') || 3000, 10);
                const infinite = $carousel.data('infinite') !== 'off';
                const arrows = $carousel.data('arrows') !== 'off';
                const dots = $carousel.data('dots') !== 'off';
                
                // Initialize Slick carousel
                $carousel.slick({
                    slidesToShow: slidesToShow,
                    slidesToScroll: slidesToScroll,
                    autoplay: autoplay,
                    autoplaySpeed: autoplaySpeed,
                    infinite: infinite,
                    arrows: arrows,
                    dots: dots,
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: slidesToShow > 2 ? 2 : slidesToShow,
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
            }
        });
    }
    
    // Initialize custom carousels
    function initCustomCarousels() {
        $('.dpcm-custom-carousel').each(function() {
            const $carousel = $(this);
            
            if (!$carousel.hasClass('slick-initialized')) {
                // Get settings from data attributes or use defaults
                const slidesToShow = parseInt($carousel.data('slides-to-show') || 3, 10);
                const slidesToScroll = parseInt($carousel.data('slides-to-scroll') || 1, 10);
                const autoplay = $carousel.data('autoplay') === 'on';
                const autoplaySpeed = parseInt($carousel.data('autoplay-speed') || 3000, 10);
                const infinite = $carousel.data('infinite') !== 'off';
                const arrows = $carousel.data('arrows') !== 'off';
                const dots = $carousel.data('dots') !== 'off';
                
                // Initialize Slick carousel
                $carousel.slick({
                    slidesToShow: slidesToShow,
                    slidesToScroll: slidesToScroll,
                    autoplay: autoplay,
                    autoplaySpeed: autoplaySpeed,
                    infinite: infinite,
                    arrows: arrows,
                    dots: dots,
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 980,
                            settings: {
                                slidesToShow: slidesToShow > 2 ? 2 : slidesToShow,
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
            }
        });
    }
    
    // Re-initialize carousels when window is resized
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            $('.dpcm-carousel.slick-initialized').slick('unslick');
            initCarousels();
        }, 250);
    });
    
    // Re-initialize carousels after Divi Visual Builder changes
    $(document).on('et_builder_api_ready', function() {
        initCarousels();
    });
    
    // Re-initialize carousels when content is updated via AJAX
    $(document).ajaxComplete(function() {
        initCarousels();
    });
    
    // Initialize carousels after DOM changes (useful for Divi Builder)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                initCarousels();
            }
        });
    });
    
    // Start observing the document body for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

})(jQuery); 