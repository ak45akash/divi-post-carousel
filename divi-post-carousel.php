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
    <div class="notice notice-error">
        <p><?php _e('Divi Post Carousel requires the Divi theme to be installed and active.', 'divi-post-carousel'); ?></p>
    </div>
    <?php
}

/**
 * Display admin notice if files are missing
 */
function dpc_missing_files_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php _e('Divi Post Carousel: Required files are missing. Please reinstall the plugin.', 'divi-post-carousel'); ?></p>
    </div>
    <?php
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
    wp_register_style('dpc-style', DPC_PLUGIN_URL . 'assets/css/divi-post-carousel.css', array(), '1.0.0');
    
    // Register Google Fonts
    wp_register_style('dpc-google-fonts', 'https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@400;500;600;700&display=swap', array(), null);
    
    // Register scripts
    wp_register_script('dpc-slick', DPC_PLUGIN_URL . 'assets/js/slick.min.js', array('jquery'), '1.8.1', true);
    wp_register_script('dpc-script', DPC_PLUGIN_URL . 'assets/js/divi-post-carousel.js', array('jquery', 'dpc-slick'), '1.0.0', true);
    
    // Enqueue them
    wp_enqueue_style('dpc-slick');
    wp_enqueue_style('dpc-style');
    wp_enqueue_style('dpc-google-fonts');
    wp_enqueue_script('dpc-slick');
    wp_enqueue_script('dpc-script');
}

/**
 * Force load Divi Builder's ET_Builder_Module if available
 */
function dpc_load_builder_module() {
    if (class_exists('ET_Builder_Module')) {
        return true;
    }
    
    // Try to include ET Builder core file
    if (defined('ET_BUILDER_DIR') && file_exists(ET_BUILDER_DIR . '/core.php')) {
        include_once ET_BUILDER_DIR . '/core.php';
        return class_exists('ET_Builder_Module');
    }
    
    return false;
}

/**
 * Load the module if Divi is active
 */
function dpc_load_module() {
    // Check if Divi is active
    if (!dpc_is_divi_active()) {
        add_action('admin_notices', 'dpc_divi_not_active_notice');
        return;
    }
    
    // Force load ET_Builder_Module if possible
    dpc_load_builder_module();
    
    // Include the module file
    $module_file = DPC_PLUGIN_DIR . 'includes/class-post-carousel-module.php';
    if (file_exists($module_file)) {
        require_once $module_file;
        
        // Register module with Divi
        if (function_exists('et_builder_add_main_elements')) {
            add_action('et_builder_ready', 'dpc_register_module');
        }
    } else {
        add_action('admin_notices', 'dpc_missing_files_notice');
    }
}

/**
 * Register the module with Divi
 */
function dpc_register_module() {
    if (class_exists('ET_Builder_Module') && class_exists('Divi_Post_Carousel_Module')) {
        new Divi_Post_Carousel_Module();
    }
}

/**
 * Render carousel content for the shortcode
 */
function dpc_render_carousel($atts) {
    // Enqueue required scripts and styles
    wp_enqueue_style('dpc-slick');
    wp_enqueue_style('dpc-style');
    wp_enqueue_style('dpc-google-fonts');
    wp_enqueue_script('dpc-slick');
    wp_enqueue_script('dpc-script');
    
    // Default attributes
    $attributes = shortcode_atts(array(
        'heading'         => 'Post Carousel',
        'post_type'       => 'post',
        'category'        => '',
        'posts_number'    => 6,
        'show_image'      => 'on',
        'show_title'      => 'on',
        'show_excerpt'    => 'on',
        'excerpt_length'  => 100,
        'show_category'   => 'on',
        'show_button'     => 'on',
        'button_text'     => 'Learn more',
        'slides_to_show'  => 3,
        'slides_to_scroll'=> 1,
        'auto_play'       => 'off',
        'auto_play_speed' => 3000
    ), $atts);
    
    // Extract variables
    extract($attributes);
    
    // Query posts
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $posts_number,
        'post_status'    => 'publish',
    );
    
    // Add category query if set
    if (!empty($category)) {
        if (strpos($category, '|') !== false) {
            // For custom post types
            list($term_id, $taxonomy) = explode('|', $category);
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ),
            );
        } else {
            // For standard posts
            $args['cat'] = $category;
        }
    }
    
    $query = new WP_Query($args);
    
    // Start building the output
    $output = '<div class="dpc_post_carousel">';
    
    // Add heading
    if (!empty($heading)) {
        $output .= sprintf('<h2 class="dpc_heading">%1$s</h2>', esc_html($heading));
    }
    
    // Start carousel
    $output .= '<div class="dpc_carousel"';
    
    // Add data attributes for slick slider
    $output .= sprintf(
        ' data-slides-to-show="%1$s" data-slides-to-scroll="%2$s" data-auto-play="%3$s" data-auto-play-speed="%4$s"',
        esc_attr($slides_to_show),
        esc_attr($slides_to_scroll),
        esc_attr($auto_play),
        esc_attr($auto_play_speed)
    );
    
    $output .= '>';
    
    // Add slides
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $post_id = get_the_ID();
            $post_link = get_permalink();
            $post_title = get_the_title();
            
            // Get post category
            $category = '';
            $category_object = array();
            
            if ('post' === $post_type) {
                $category_object = get_the_category();
            } elseif (taxonomy_exists('category_' . $post_type)) {
                $category_object = get_the_terms($post_id, 'category_' . $post_type);
            } elseif (taxonomy_exists($post_type . '_category')) {
                $category_object = get_the_terms($post_id, $post_type . '_category');
            }
            
            if (!empty($category_object) && !is_wp_error($category_object) && isset($category_object[0])) {
                $category = $category_object[0]->name;
            }
            
            // Build slide
            $output .= '<div class="dpc_slide">';
            
            // Add featured image
            if ('on' === $show_image && has_post_thumbnail($post_id)) {
                $image = get_the_post_thumbnail($post_id, 'medium');
                $output .= sprintf(
                    '<div class="dpc_image"><a href="%1$s">%2$s</a></div>',
                    esc_url($post_link),
                    $image
                );
            }
            
            // Add category
            if ('on' === $show_category && !empty($category)) {
                $output .= sprintf(
                    '<div class="dpc_category">%1$s</div>',
                    esc_html($category)
                );
            }
            
            // Add title
            if ('on' === $show_title) {
                $output .= sprintf(
                    '<h3 class="dpc_title"><a href="%1$s">%2$s</a></h3>',
                    esc_url($post_link),
                    esc_html($post_title)
                );
            }
            
            // Add excerpt
            if ('on' === $show_excerpt) {
                $excerpt = get_the_excerpt();
                if (strlen($excerpt) > $excerpt_length) {
                    $excerpt = substr($excerpt, 0, $excerpt_length) . '...';
                }
                
                $output .= sprintf(
                    '<div class="dpc_content">%1$s</div>',
                    wp_kses_post($excerpt)
                );
            }
            
            // Add button
            if ('on' === $show_button) {
                $output .= sprintf(
                    '<a href="%1$s" class="dpc_button">%2$s</a>',
                    esc_url($post_link),
                    esc_html($button_text)
                );
            }
            
            $output .= '</div>'; // End .dpc_slide
        }
        
        wp_reset_postdata();
    } else {
        $output .= '<div class="dpc_no_posts">' . esc_html__('No posts found', 'divi-post-carousel') . '</div>';
    }
    
    $output .= '</div>'; // End .dpc_carousel
    
    // Add navigation dots
    $output .= '<div class="dpc_dots"></div>';
    
    $output .= '</div>'; // End .dpc_post_carousel
    
    // Generate a unique ID for this carousel
    $carousel_id = 'dpc_carousel_' . rand(1000, 9999);
    
    // Enqueue the frontend script with the module ID
    $script = sprintf(
        '<script>
            jQuery(document).ready(function($) {
                $(".dpc_carousel").not(".slick-initialized").slick({
                    dots: true,
                    arrows: true,
                    infinite: true,
                    speed: 500,
                    slidesToShow: Number($(".dpc_carousel").data("slides-to-show")) || 3,
                    slidesToScroll: Number($(".dpc_carousel").data("slides-to-scroll")) || 1,
                    autoplay: $(".dpc_carousel").data("auto-play") === "on",
                    autoplaySpeed: Number($(".dpc_carousel").data("auto-play-speed")) || 3000,
                    appendDots: $(".dpc_dots"),
                    prevArrow: \'<button type="button" class="slick-prev">&#8249;</button>\',
                    nextArrow: \'<button type="button" class="slick-next">&#8250;</button>\',
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
        </script>'
    );
    
    // Add custom CSS for font
    $output .= '<style>
        .dpc_post_carousel {
            font-family: "Libre Franklin", sans-serif;
        }
    </style>';
    
    return $output . $script;
}

/**
 * Register shortcode
 */
function dpc_register_shortcode() {
    add_shortcode('divi_post_carousel', 'dpc_render_carousel');
}

/**
 * Add shortcode button to TinyMCE
 */
function dpc_add_shortcode_button() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_buttons', 'dpc_register_shortcode_button');
        add_filter('mce_external_plugins', 'dpc_add_shortcode_tinymce_plugin');
    }
}

/**
 * Register the shortcode button
 */
function dpc_register_shortcode_button($buttons) {
    array_push($buttons, 'dpc_shortcode_button');
    return $buttons;
}

/**
 * Add the TinyMCE plugin
 */
function dpc_add_shortcode_tinymce_plugin($plugin_array) {
    $plugin_array['dpc_shortcode_button'] = DPC_PLUGIN_URL . 'assets/js/shortcode-button.js';
    return $plugin_array;
}

/**
 * Create shortcode generator popup
 */
function dpc_shortcode_generator_popup() {
    if (!is_admin() || !current_user_can('edit_posts') || !current_user_can('edit_pages')) {
        return;
    }
    ?>
    <div id="dpc-shortcode-generator" style="display:none;">
        <div class="dpc-popup-content">
            <h2><?php _e('Divi Post Carousel Shortcode Generator', 'divi-post-carousel'); ?></h2>
            <p><?php _e('Configure your carousel options below:', 'divi-post-carousel'); ?></p>
            
            <div class="dpc-field">
                <label><?php _e('Heading:', 'divi-post-carousel'); ?></label>
                <input type="text" id="dpc-heading" value="Post Carousel">
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Post Type:', 'divi-post-carousel'); ?></label>
                <select id="dpc-post-type" class="dpc-post-type-selector">
                    <?php 
                    $post_types = get_post_types(array('public' => true), 'objects');
                    foreach ($post_types as $post_type) {
                        if ($post_type->name !== 'attachment') {
                            echo '<option value="' . esc_attr($post_type->name) . '">' . esc_html($post_type->label) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div class="dpc-field dpc-categories-field">
                <label><?php _e('Category:', 'divi-post-carousel'); ?></label>
                <select id="dpc-category">
                    <option value=""><?php _e('All Categories', 'divi-post-carousel'); ?></option>
                    <?php 
                    $categories = get_categories(array('hide_empty' => false));
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Number of Posts:', 'divi-post-carousel'); ?></label>
                <input type="number" id="dpc-posts-number" value="6" min="1" max="20">
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Show Featured Image:', 'divi-post-carousel'); ?></label>
                <select id="dpc-show-image">
                    <option value="on"><?php _e('Yes', 'divi-post-carousel'); ?></option>
                    <option value="off"><?php _e('No', 'divi-post-carousel'); ?></option>
                </select>
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Show Title:', 'divi-post-carousel'); ?></label>
                <select id="dpc-show-title">
                    <option value="on"><?php _e('Yes', 'divi-post-carousel'); ?></option>
                    <option value="off"><?php _e('No', 'divi-post-carousel'); ?></option>
                </select>
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Show Excerpt:', 'divi-post-carousel'); ?></label>
                <select id="dpc-show-excerpt">
                    <option value="on"><?php _e('Yes', 'divi-post-carousel'); ?></option>
                    <option value="off"><?php _e('No', 'divi-post-carousel'); ?></option>
                </select>
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Excerpt Length:', 'divi-post-carousel'); ?></label>
                <input type="number" id="dpc-excerpt-length" value="100" min="10" max="500">
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Slides to Show:', 'divi-post-carousel'); ?></label>
                <input type="number" id="dpc-slides-to-show" value="3" min="1" max="6">
            </div>
            
            <div class="dpc-field">
                <label><?php _e('Auto Play:', 'divi-post-carousel'); ?></label>
                <select id="dpc-auto-play">
                    <option value="off"><?php _e('No', 'divi-post-carousel'); ?></option>
                    <option value="on"><?php _e('Yes', 'divi-post-carousel'); ?></option>
                </select>
            </div>
            
            <div class="dpc-actions">
                <button id="dpc-insert-shortcode" class="button button-primary"><?php _e('Insert Shortcode', 'divi-post-carousel'); ?></button>
                <button id="dpc-cancel" class="button"><?php _e('Cancel', 'divi-post-carousel'); ?></button>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Add JavaScript for the shortcode button
 */
function dpc_add_shortcode_script() {
    if (!is_admin() || !current_user_can('edit_posts') || !current_user_can('edit_pages')) {
        return;
    }
    
    // Create JS file if it doesn't exist
    $js_file = DPC_PLUGIN_DIR . 'assets/js/shortcode-button.js';
    if (!file_exists($js_file)) {
        $js_content = '(function() {
            tinymce.PluginManager.add("dpc_shortcode_button", function(editor, url) {
                editor.addButton("dpc_shortcode_button", {
                    title: "Insert Post Carousel",
                    icon: "icon dashicons-slides",
                    onclick: function() {
                        jQuery("#dpc-shortcode-generator").show();
                        
                        // Update categories when post type changes
                        jQuery("#dpc-post-type").off("change").on("change", function() {
                            var postType = jQuery(this).val();
                            if (postType === "post") {
                                jQuery.ajax({
                                    url: ajaxurl,
                                    type: "POST",
                                    data: {
                                        action: "dpc_get_categories",
                                        post_type: postType,
                                        nonce: "' . wp_create_nonce('dpc_get_categories') . '"
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            jQuery("#dpc-category").html(response.data);
                                            jQuery(".dpc-categories-field").show();
                                        } else {
                                            jQuery(".dpc-categories-field").hide();
                                        }
                                    }
                                });
                            } else {
                                // Handle custom post types
                                jQuery.ajax({
                                    url: ajaxurl,
                                    type: "POST",
                                    data: {
                                        action: "dpc_get_categories",
                                        post_type: postType,
                                        nonce: "' . wp_create_nonce('dpc_get_categories') . '"
                                    },
                                    success: function(response) {
                                        if (response.success && response.data !== "") {
                                            jQuery("#dpc-category").html(response.data);
                                            jQuery(".dpc-categories-field").show();
                                        } else {
                                            jQuery(".dpc-categories-field").hide();
                                        }
                                    }
                                });
                            }
                        });
                        
                        // Handle insert button click
                        jQuery("#dpc-insert-shortcode").off("click").on("click", function() {
                            var heading = jQuery("#dpc-heading").val();
                            var postType = jQuery("#dpc-post-type").val();
                            var category = jQuery("#dpc-category").val();
                            var postsNumber = jQuery("#dpc-posts-number").val();
                            var showImage = jQuery("#dpc-show-image").val();
                            var showTitle = jQuery("#dpc-show-title").val();
                            var showExcerpt = jQuery("#dpc-show-excerpt").val();
                            var excerptLength = jQuery("#dpc-excerpt-length").val();
                            var slidesToShow = jQuery("#dpc-slides-to-show").val();
                            var autoPlay = jQuery("#dpc-auto-play").val();
                            
                            var shortcode = \'[divi_post_carousel\';
                            shortcode += \' heading="\' + heading + \'"\';
                            shortcode += \' post_type="\' + postType + \'"\';
                            if (category) {
                                shortcode += \' category="\' + category + \'"\';
                            }
                            shortcode += \' posts_number="\' + postsNumber + \'"\';
                            shortcode += \' show_image="\' + showImage + \'"\';
                            shortcode += \' show_title="\' + showTitle + \'"\';
                            shortcode += \' show_excerpt="\' + showExcerpt + \'"\';
                            shortcode += \' excerpt_length="\' + excerptLength + \'"\';
                            shortcode += \' slides_to_show="\' + slidesToShow + \'"\';
                            shortcode += \' auto_play="\' + autoPlay + \'"\';
                            shortcode += \']\';
                            
                            editor.insertContent(shortcode);
                            jQuery("#dpc-shortcode-generator").hide();
                        });
                        
                        // Handle cancel button click
                        jQuery("#dpc-cancel").off("click").on("click", function() {
                            jQuery("#dpc-shortcode-generator").hide();
                        });
                        
                        // Trigger post type change to load categories
                        jQuery("#dpc-post-type").trigger("change");
                    }
                });
            });
        })();';
        
        // Create directory if it doesn't exist
        if (!file_exists(DPC_PLUGIN_DIR . 'assets/js')) {
            mkdir(DPC_PLUGIN_DIR . 'assets/js', 0755, true);
        }
        
        file_put_contents($js_file, $js_content);
    }
    
    // Add CSS for the popup
    ?>
    <style>
        #dpc-shortcode-generator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 500px;
            max-width: 90%;
            z-index: 159000;
            font-family: "Libre Franklin", sans-serif;
        }
        .dpc-popup-content h2 {
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .dpc-field {
            margin-bottom: 15px;
        }
        .dpc-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .dpc-field input,
        .dpc-field select {
            width: 100%;
        }
        .dpc-actions {
            text-align: right;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
    <?php
    
    // Enqueue Google Fonts in admin
    wp_enqueue_style('dpc-google-fonts', 'https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@400;500;600;700&display=swap', array(), null);
}

/**
 * Ajax handler to get categories based on post type
 */
function dpc_get_categories_ajax() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dpc_get_categories')) {
        wp_send_json_error('Invalid nonce');
        return;
    }
    
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
    $options = '';
    $options .= '<option value="">' . esc_html__('All Categories', 'divi-post-carousel') . '</option>';
    
    if ('post' === $post_type) {
        $categories = get_categories(array('hide_empty' => false));
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $options .= '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
            }
        }
    } else {
        // Try to find a taxonomy for this post type
        $taxonomies = get_object_taxonomies($post_type, 'objects');
        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy->hierarchical) {
                    $terms = get_terms(array(
                        'taxonomy' => $taxonomy->name,
                        'hide_empty' => false,
                    ));
                    
                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $options .= '<option value="' . esc_attr($term->term_id . '|' . $taxonomy->name) . '">' . esc_html($term->name) . '</option>';
                        }
                    }
                    
                    break; // Only use the first hierarchical taxonomy
                }
            }
        }
    }
    
    wp_send_json_success($options);
}

/**
 * Initialize the plugin
 */
function dpc_init() {
    // Load the module
    dpc_load_module();
    
    // Register scripts and styles
    add_action('wp_enqueue_scripts', 'dpc_enqueue_scripts');
    
    // Register shortcode functionality
    dpc_register_shortcode();
    
    // Register AJAX handler for categories
    add_action('wp_ajax_dpc_get_categories', 'dpc_get_categories_ajax');
    
    // TinyMCE button (only in admin)
    if (is_admin()) {
        add_action('admin_init', 'dpc_add_shortcode_button');
        add_action('admin_footer', 'dpc_shortcode_generator_popup');
        add_action('admin_head', 'dpc_add_shortcode_script');
    }
}

// Initialize the plugin on plugins loaded with priority 20
add_action('plugins_loaded', 'dpc_init', 20); 