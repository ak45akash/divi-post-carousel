<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Load the parent module first
require_once plugin_dir_path(__FILE__) . 'CustomCarousel.php';

// Load the child module
require_once plugin_dir_path(__FILE__) . 'CarouselItem/CarouselItem.php';

// Register the modules
function dpcm_load_custom_carousel_modules() {
    return array(
        'DPCM_Custom_Carousel' => plugin_dir_path(__FILE__) . 'CustomCarousel.php',
        'DPCM_Carousel_Item'   => plugin_dir_path(__FILE__) . 'CarouselItem/CarouselItem.php',
    );
}
add_filter('et_builder_get_custom_modules', 'dpcm_load_custom_carousel_modules'); 