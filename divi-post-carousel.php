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

/**
 * Main Divi Post Carousel Class
 */
class Divi_Post_Carousel {
    
    /**
     * Instance of this class
     */
    public static $instance;
    
    /**
     * Return an instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->setup_constants();
        
        // Only load if Divi theme is active
        if ($this->is_divi_active()) {
            $this->includes();
            $this->init_hooks();
        } else {
            add_action('admin_notices', array($this, 'divi_not_active_notice'));
        }
    }
    
    /**
     * Setup plugin constants
     */
    private function setup_constants() {
        // Plugin path
        if (!defined('DPC_PLUGIN_DIR')) {
            define('DPC_PLUGIN_DIR', plugin_dir_path(__FILE__));
        }
        
        // Plugin URL
        if (!defined('DPC_PLUGIN_URL')) {
            define('DPC_PLUGIN_URL', plugin_dir_url(__FILE__));
        }
    }
    
    /**
     * Check if Divi theme is active
     */
    private function is_divi_active() {
        // Check if the ET_BUILDER_VERSION constant is defined (indicates Divi is active)
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
     * Include required files
     */
    private function includes() {
        $module_file = DPC_PLUGIN_DIR . 'includes/class-post-carousel-module.php';
        
        if (file_exists($module_file)) {
            require_once $module_file;
        } else {
            add_action('admin_notices', array($this, 'missing_files_notice'));
        }
    }
    
    /**
     * Init hooks
     */
    private function init_hooks() {
        add_action('et_builder_ready', array($this, 'register_module'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Register the module
     */
    public function register_module() {
        if (class_exists('ET_Builder_Module') && class_exists('Divi_Post_Carousel_Module')) {
            new Divi_Post_Carousel_Module();
        }
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Register styles first
        wp_register_style('dpc-slick', DPC_PLUGIN_URL . 'assets/css/slick.css', array(), '1.8.1');
        wp_register_style('dpc-style', DPC_PLUGIN_URL . 'assets/css/divi-post-carousel.css', array(), '1.0.0');
        
        // Register scripts
        wp_register_script('dpc-slick', DPC_PLUGIN_URL . 'assets/js/slick.min.js', array('jquery'), '1.8.1', true);
        wp_register_script('dpc-script', DPC_PLUGIN_URL . 'assets/js/divi-post-carousel.js', array('jquery', 'dpc-slick'), '1.0.0', true);
        
        // Now enqueue them
        wp_enqueue_style('dpc-slick');
        wp_enqueue_style('dpc-style');
        wp_enqueue_script('dpc-slick');
        wp_enqueue_script('dpc-script');
    }
    
    /**
     * Display notice if Divi theme is not active
     */
    public function divi_not_active_notice() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('Divi Post Carousel requires the Divi theme to be installed and active.', 'divi-post-carousel'); ?></p>
        </div>
        <?php
    }
    
    /**
     * Display notice if files are missing
     */
    public function missing_files_notice() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('Divi Post Carousel: Required files are missing. Please reinstall the plugin.', 'divi-post-carousel'); ?></p>
        </div>
        <?php
    }
}

/**
 * Initialize the plugin
 */
function divi_post_carousel_init() {
    return Divi_Post_Carousel::get_instance();
}

// Start the plugin
add_action('plugins_loaded', 'divi_post_carousel_init'); 