<?php
/**
 * Plugin Name: Divi Post Carousel
 * Plugin URI: 
 * Description: A custom post carousel module for Divi
 * Version: 1.0.0
 * Author: Akash
 * Author URI: https://iakash.dev
 * License: GPL2
 * Text Domain: divi-post-carousel
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('DPC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DPC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DPC_VERSION', '1.0.0');

/**
 * Check if Divi theme/builder is active
 */
function dpc_is_divi_active() {
    if (defined('ET_BUILDER_VERSION')) {
        return true;
    }
    
    // Check if the Divi theme is active
    $theme = wp_get_theme();
    if ('Divi' === $theme->get('Name') || 'Divi' === $theme->get('Template')) {
        return true;
    }
    
    return false;
}

/**
 * Display admin notice if Divi theme is not active
 */
function dpc_divi_not_active_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e('Divi Post Carousel requires the Divi theme to be installed and active for Divi Builder functionality. You can still use the shortcode without Divi.', 'divi-post-carousel'); ?></p>
    </div>
    <?php
}

/**
 * Display admin notice if files are missing
 */
function dpc_missing_files_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e('Divi Post Carousel: Required files are missing. Please reinstall the plugin.', 'divi-post-carousel'); ?></p>
    </div>
    <?php
}

/**
 * Check if ET_Builder_Module exists - load the ET_Builder_Module as base class
 */
function dpc_load_builder_module() {
    if (class_exists('ET_Builder_Module')) {
        return true;
    }
    
    // Try to load ET_Builder_Module class if it exists
    if (dpc_is_divi_active() && defined('ET_BUILDER_DIR') && is_readable(ET_BUILDER_DIR . '/module.php')) {
        require_once ET_BUILDER_DIR . '/module.php';
        return true;
    }
    
    return false;
}

/**
 * Register styles and scripts
 */
function dpc_enqueue_scripts() {
    // Only enqueue on frontend
    if (is_admin()) {
        return;
    }
    
    // Register styles
    wp_register_style('dpc-slick', DPC_PLUGIN_URL . 'assets/css/slick.css', array(), '1.8.1');
    wp_register_style('dpc-style', DPC_PLUGIN_URL . 'assets/css/divi-post-carousel.css', array(), DPC_VERSION);
    
    // Register scripts
    wp_register_script('dpc-slick', DPC_PLUGIN_URL . 'assets/js/slick.min.js', array('jquery'), '1.8.1', true);
    wp_register_script('dpc-script', DPC_PLUGIN_URL . 'assets/js/divi-post-carousel.js', array('jquery', 'dpc-slick'), DPC_VERSION, true);
    
    // Enqueue them
    wp_enqueue_style('dpc-slick');
    wp_enqueue_style('dpc-style');
    wp_enqueue_script('dpc-slick');
    wp_enqueue_script('dpc-script');
}

/**
 * Load the module if Divi is active
 */
function dpc_load_module() {
    // Check if ET_Builder_Module can be loaded
    if (!dpc_load_builder_module()) {
        return;
    }
    
    // Include the module file
    $module_file = DPC_PLUGIN_DIR . 'includes/class-post-carousel-module.php';
    if (file_exists($module_file)) {
        require_once $module_file;
    } else {
        add_action('admin_notices', 'dpc_missing_files_notice');
    }
}

/**
 * Render carousel via shortcode
 */
function dpc_render_carousel($atts) {
    // Enqueue necessary scripts
    wp_enqueue_style('dpc-slick');
    wp_enqueue_style('dpc-style');
    wp_enqueue_script('dpc-slick');
    wp_enqueue_script('dpc-script');
    
    // Set defaults
    $atts = shortcode_atts(array(
        'heading' => '',
        'post_type' => 'post',
        'posts_number' => 6,
        'show_image' => 'on',
        'show_title' => 'on',
        'show_excerpt' => 'on',
        'excerpt_length' => 100,
        'show_category' => 'on',
        'show_button' => 'on',
        'button_text' => 'Learn more',
        'slides_to_show' => 3,
        'slides_to_scroll' => 1,
        'auto_play' => 'on',
        'auto_play_speed' => 3000,
        'category' => '',
    ), $atts);
    
    // Query posts
    $args = array(
        'post_type'      => $atts['post_type'],
        'posts_per_page' => intval($atts['posts_number']),
        'post_status'    => 'publish',
    );
    
    // Add category filter if specified
    if (!empty($atts['category'])) {
        if ($atts['post_type'] === 'post') {
            $args['cat'] = intval($atts['category']);
        } else {
            // For custom post types, use tax_query
            $taxonomy = 'category';
            
            // Check for custom taxonomies
            if (taxonomy_exists('category_' . $atts['post_type'])) {
                $taxonomy = 'category_' . $atts['post_type'];
            } elseif (taxonomy_exists($atts['post_type'] . '_category')) {
                $taxonomy = $atts['post_type'] . '_category';
            }
            
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => intval($atts['category']),
                ),
            );
        }
    }
    
    $query = new WP_Query($args);
    
    // Generate a unique ID for this carousel
    $carousel_id = 'dpc_carousel_' . rand(1000, 9999);
    
    // Start building the output
    ob_start();
    ?>
    <div class="dpc_post_carousel">
        <?php if (!empty($atts['heading'])) : ?>
            <h2 class="dpc_heading"><?php echo esc_html($atts['heading']); ?></h2>
        <?php endif; ?>
        
        <div class="dpc_carousel" 
             data-slides-to-show="<?php echo esc_attr($atts['slides_to_show']); ?>" 
             data-slides-to-scroll="<?php echo esc_attr($atts['slides_to_scroll']); ?>" 
             data-auto-play="<?php echo esc_attr($atts['auto_play']); ?>" 
             data-auto-play-speed="<?php echo esc_attr($atts['auto_play_speed']); ?>">
            
            <?php 
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $post_id = get_the_ID();
                    $post_link = get_permalink();
                    $post_title = get_the_title();
                    
                    // Get post category
                    $category = '';
                    $category_object = array();
                    
                    if ('post' === $atts['post_type']) {
                        $category_object = get_the_category();
                    } elseif (taxonomy_exists('category_' . $atts['post_type'])) {
                        $category_object = get_the_terms($post_id, 'category_' . $atts['post_type']);
                    } elseif (taxonomy_exists($atts['post_type'] . '_category')) {
                        $category_object = get_the_terms($post_id, $atts['post_type'] . '_category');
                    }
                    
                    if (!empty($category_object) && !is_wp_error($category_object) && isset($category_object[0])) {
                        $category = $category_object[0]->name;
                    }
                    ?>
                    
                    <div class="dpc_slide">
                        <?php if ('on' === $atts['show_image'] && has_post_thumbnail($post_id)) : ?>
                            <div class="dpc_image">
                                <a href="<?php echo esc_url($post_link); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ('on' === $atts['show_category'] && !empty($category)) : ?>
                            <div class="dpc_category"><?php echo esc_html($category); ?></div>
                        <?php endif; ?>
                        
                        <?php if ('on' === $atts['show_title']) : ?>
                            <h3 class="dpc_title">
                                <a href="<?php echo esc_url($post_link); ?>"><?php echo esc_html($post_title); ?></a>
                            </h3>
                        <?php endif; ?>
                        
                        <?php if ('on' === $atts['show_excerpt']) : 
                            $excerpt = get_the_excerpt();
                            
                            // Set a maximum character limit for excerpt
                            if (strlen($excerpt) > intval($atts['excerpt_length'])) {
                                $excerpt = substr($excerpt, 0, intval($atts['excerpt_length'])) . '...';
                            } else if (strlen($excerpt) < 10) {
                                // Ensure there's always some content to prevent height differences
                                $excerpt .= str_repeat('&nbsp;', 10);
                            }
                        ?>
                            <div class="dpc_content"><?php echo wp_kses_post($excerpt); ?></div>
                        <?php endif; ?>
                        
                        <?php if ('on' === $atts['show_button']) : ?>
                            <a href="<?php echo esc_url($post_link); ?>" class="dpc_button"><?php echo esc_html($atts['button_text']); ?></a>
                        <?php endif; ?>
                    </div>
                    
                <?php 
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div class="dpc_no_posts"><?php _e('No posts found', 'divi-post-carousel'); ?></div>
            <?php endif; ?>
        </div>
        <div class="dpc_dots"></div>
    </div>
    
    <script>
        jQuery(document).ready(function($) {
            $('.dpc_carousel').not('.slick-initialized').slick({
                dots: true,
                arrows: true,
                infinite: true, 
                speed: 500,
                slidesToShow: Number($('.dpc_carousel').data('slides-to-show')) || 3,
                slidesToScroll: Number($('.dpc_carousel').data('slides-to-scroll')) || 1,
                autoplay: $('.dpc_carousel').data('auto-play') === 'on',
                autoplaySpeed: Number($('.dpc_carousel').data('auto-play-speed')) || 3000,
                appendDots: $('.dpc_dots'),
                prevArrow: '<button type="button" class="slick-prev"></button>',
                nextArrow: '<button type="button" class="slick-next"></button>',
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
    </script>
    <?php
    
    return ob_get_clean();
}

/**
 * Initialize the plugin
 */
function dpc_init() {
    // Load the module if Divi is active
    if (dpc_is_divi_active()) {
        dpc_load_module();
    } else {
        add_action('admin_notices', 'dpc_divi_not_active_notice');
    }
    
    // Register shortcode
    add_shortcode('divi_post_carousel', 'dpc_render_carousel');
    
    // Register scripts and styles
    add_action('wp_enqueue_scripts', 'dpc_enqueue_scripts');
}

// Initialize the plugin on plugins loaded with priority 20
add_action('plugins_loaded', 'dpc_init', 20); 