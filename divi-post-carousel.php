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
    
    // Register scripts
    wp_register_script('dpc-slick', DPC_PLUGIN_URL . 'assets/js/slick.min.js', array('jquery'), '1.8.1', true);
    wp_register_script('dpc-script', DPC_PLUGIN_URL . 'assets/js/divi-post-carousel.js', array('jquery', 'dpc-slick'), '1.0.0', true);
    
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
    // Check if Divi is active
    if (!dpc_is_divi_active()) {
        add_action('admin_notices', 'dpc_divi_not_active_notice');
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
 * Initialize the plugin
 */
function dpc_init() {
    // Load the module
    dpc_load_module();
    
    // Register scripts and styles
    add_action('wp_enqueue_scripts', 'dpc_enqueue_scripts');
}

// Initialize the plugin on plugins loaded with priority 20
add_action('plugins_loaded', 'dpc_init', 20); 