<?php
/**
 * Plugin Name: GCT Carousel Module
 * Plugin URI:  https://www.gctweb.com
 * Description: A custom Divi module for displaying posts in a carousel.
 * Version:     1.0.0
 * Author:      Joshua Wood
 * Author URI:  https://www.gctweb.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: gct-carousel
 * Domain Path: /languages
 *
 * GCT Carousel Module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * GCT Carousel Module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GCT Carousel Module. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Plugin Class
 *
 * @since 1.0.0
 */
class Divi_Post_Carousel {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Plugin's instance
     *
     * @var Divi_Post_Carousel
     */
    protected static $_instance = null;

    /**
     * Get the instance of the plugin
     *
     * @return Divi_Post_Carousel
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->define_constants();
        $this->init_hooks();
    }

    /**
     * Define plugin constants
     */
    private function define_constants() {
        define('DPCM_VERSION', $this->version);
        define('DPCM_PLUGIN_FILE', __FILE__);
        define('DPCM_PLUGIN_BASENAME', plugin_basename(__FILE__));
        define('DPCM_PLUGIN_PATH', plugin_dir_path(__FILE__));
        define('DPCM_PLUGIN_URL', plugin_dir_url(__FILE__));
        define('DPCM_ASSETS_URL', DPCM_PLUGIN_URL . 'assets/');
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Load plugin textdomain
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        
        // Register scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
        
        // Initialize modules using Divi's hooks
        add_action('et_builder_ready', array($this, 'load_modules'));
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain('divi-post-carousel-module', false, dirname(DPCM_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Register and enqueue scripts and styles
     */
    public function register_scripts() {
        // Register Slick Carousel styles and scripts
        wp_register_style('slick-carousel', DPCM_ASSETS_URL . 'css/slick.css', array(), '1.8.1');
        wp_register_style('slick-theme', DPCM_ASSETS_URL . 'css/slick-theme.css', array('slick-carousel'), '1.8.1');
        wp_register_script('slick-carousel', DPCM_ASSETS_URL . 'js/slick.min.js', array('jquery'), '1.8.1', true);
        
        // Register custom styles and scripts
        wp_register_style('divi-post-carousel', DPCM_ASSETS_URL . 'css/divi-post-carousel.css', array('slick-carousel', 'slick-theme'), DPCM_VERSION);
        wp_register_script('divi-post-carousel', DPCM_ASSETS_URL . 'js/divi-post-carousel.js', array('jquery', 'slick-carousel'), DPCM_VERSION, true);
    }

    /**
     * Load modules
     */
    public function load_modules() {
        if (class_exists('ET_Builder_Module')) {
            // Load the Post Carousel module
            require_once DPCM_PLUGIN_PATH . 'includes/modules/PostCarousel/PostCarousel.php';
            
            // Load the Custom Carousel modules
            require_once DPCM_PLUGIN_PATH . 'includes/modules/CustomCarousel/index.php';
        }
    }

    /**
     * Enqueue module-specific scripts and styles
     * This method is called by modules that need these assets
     */
    public function enqueue_module_assets() {
        // Enqueue Slick Carousel
        wp_enqueue_style('slick-carousel');
        wp_enqueue_style('slick-theme');
        wp_enqueue_script('slick-carousel');
        
        // Plugin specific styles and scripts
        wp_enqueue_style('divi-post-carousel');
        wp_enqueue_script('divi-post-carousel');
    }
}

// Instantiate the plugin
function dpcm() {
    return Divi_Post_Carousel::instance();
}

// Global for backwards compatibility
$GLOBALS['divi_post_carousel'] = dpcm(); 