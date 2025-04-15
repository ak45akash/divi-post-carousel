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
        $this->includes();
        $this->init_hooks();
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
     * Include required files
     */
    private function includes() {
        require_once DPC_PLUGIN_DIR . 'includes/class-post-carousel-module.php';
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
        if (class_exists('ET_Builder_Module')) {
            new Divi_Post_Carousel_Module();
        }
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style('dpc-slick', DPC_PLUGIN_URL . 'assets/css/slick.css', array(), '1.8.1');
        wp_enqueue_style('dpc-style', DPC_PLUGIN_URL . 'assets/css/divi-post-carousel.css', array(), '1.0.0');
        
        wp_enqueue_script('dpc-slick', DPC_PLUGIN_URL . 'assets/js/slick.min.js', array('jquery'), '1.8.1', true);
        wp_enqueue_script('dpc-script', DPC_PLUGIN_URL . 'assets/js/divi-post-carousel.js', array('jquery', 'dpc-slick'), '1.0.0', true);
    }
}

// Initialize the plugin
function divi_post_carousel_init() {
    return Divi_Post_Carousel::get_instance();
}

// Start the plugin
divi_post_carousel_init(); 