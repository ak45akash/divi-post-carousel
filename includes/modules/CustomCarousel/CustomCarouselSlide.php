<?php
/**
 * Custom Carousel Slide Module for Divi
 *
 * @package DiviPostCarousel\Modules
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Only proceed if ET_Builder_Module exists (Divi is active)
if (!class_exists('ET_Builder_Module')) {
    return;
}

class DPCM_Custom_Carousel_Slide extends ET_Builder_Module {
    public $slug = 'dpcm_custom_carousel_slide';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'content';

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'Your Name',
        'author_uri' => '',
    );

    function __construct() {
        parent::__construct();
        $this->init();
    }
    
    public function init() {
        $this->name = esc_html__('Carousel Item', 'divi-post-carousel');
        $this->plural = esc_html__('Carousel Items', 'divi-post-carousel');
        $this->advanced_setting_title_text = esc_html__('New Carousel Item', 'divi-post-carousel');
        $this->settings_text = esc_html__('Carousel Item Settings', 'divi-post-carousel');

        // Define the parent module
        $this->parent_slug = 'dpcm_custom_carousel';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content' => esc_html__('Content', 'divi-post-carousel'),
                    'image' => esc_html__('Image', 'divi-post-carousel'),
                    'button' => esc_html__('Button', 'divi-post-carousel'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'text' => array(
                        'title' => esc_html__('Text', 'divi-post-carousel'),
                    ),
                    'header' => array(
                        'title' => esc_html__('Title', 'divi-post-carousel'),
                        'priority' => 49,
                    ),
                    'image' => array(
                        'title' => esc_html__('Image', 'divi-post-carousel'),
                        'priority' => 50,
                    ),
                    'button' => array(
                        'title' => esc_html__('Button', 'divi-post-carousel'),
                        'priority' => 51,
                    ),
                ),
            ),
        );
        
        $this->advanced_fields = array(
            'fonts' => array(
                'header' => array(
                    'label' => esc_html__('Title', 'divi-post-carousel'),
                    'css' => array(
                        'main' => "%%order_class%% .dpcm_slide_title",
                        'important' => 'all',
                    ),
                    'header_level' => array(
                        'default' => 'h3',
                    ),
                ),
                'body' => array(
                    'label' => esc_html__('Body', 'divi-post-carousel'),
                    'css' => array(
                        'main' => "%%order_class%% .dpcm_slide_content",
                        'line_height' => "%%order_class%% .dpcm_slide_content p",
                        'important' => 'all',
                    ),
                ),
            ),
            'button' => array(
                'button' => array(
                    'label' => esc_html__('Button', 'divi-post-carousel'),
                    'css' => array(
                        'main' => "%%order_class%% .dpcm_slide_button",
                        'important' => 'all',
                    ),
                    'use_alignment' => true,
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .dpcm_slide",
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dpcm_slide",
                            'border_styles' => "%%order_class%% .dpcm_slide",
                        ),
                    ),
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dpcm_slide_image img",
                            'border_styles' => "%%order_class%% .dpcm_slide_image img",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'divi-post-carousel'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dpcm_slide",
                    ),
                ),
                'image' => array(
                    'label' => esc_html__('Image Box Shadow', 'divi-post-carousel'),
                    'css' => array(
                        'main' => "%%order_class%% .dpcm_slide_image img",
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'padding' => "%%order_class%% .dpcm_slide",
                    'margin' => "%%order_class%% .dpcm_slide",
                    'important' => 'all',
                ),
            ),
            'text' => array(
                'use_text_orientation' => true,
                'css' => array(
                    'text_orientation' => "%%order_class%% .dpcm_slide",
                ),
            ),
        );
    }
    
    public function get_fields() {
        return array(
            'title' => array(
                'label' => esc_html__('Title', 'divi-post-carousel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Enter a title for this slide.', 'divi-post-carousel'),
                'toggle_slug' => 'main_content',
            ),
            'image' => array(
                'label' => esc_html__('Image', 'divi-post-carousel'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'divi-post-carousel'),
                'choose_text' => esc_attr__('Choose an Image', 'divi-post-carousel'),
                'update_text' => esc_attr__('Update Image', 'divi-post-carousel'),
                'description' => esc_html__('Upload an image for this slide.', 'divi-post-carousel'),
                'toggle_slug' => 'image',
            ),
            'content' => array(
                'label' => esc_html__('Content', 'divi-post-carousel'),
                'type' => 'tiny_mce',
                'option_category' => 'basic_option',
                'description' => esc_html__('Enter content for this slide.', 'divi-post-carousel'),
                'toggle_slug' => 'main_content',
            ),
            'image_alt' => array(
                'label' => esc_html__('Image Alt Text', 'divi-post-carousel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the HTML ALT text for your image here.', 'divi-post-carousel'),
                'toggle_slug' => 'image',
            ),
            'use_image_as_link' => array(
                'label' => esc_html__('Use Image as Link', 'divi-post-carousel'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'off' => esc_html__('No', 'divi-post-carousel'),
                    'on' => esc_html__('Yes', 'divi-post-carousel'),
                ),
                'affects' => array(
                    'image_url',
                ),
                'default' => 'off',
                'toggle_slug' => 'image',
            ),
            'image_url' => array(
                'label' => esc_html__('Image Link URL', 'divi-post-carousel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('If you want your image to be a link, input your destination URL here.', 'divi-post-carousel'),
                'depends_show_if' => 'on',
                'toggle_slug' => 'image',
            ),
            'button_text' => array(
                'label' => esc_html__('Button Text', 'divi-post-carousel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Enter text for the button.', 'divi-post-carousel'),
                'toggle_slug' => 'button',
                'dynamic_content' => 'text',
            ),
            'button_url' => array(
                'label' => esc_html__('Button URL', 'divi-post-carousel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Enter a URL for the button.', 'divi-post-carousel'),
                'toggle_slug' => 'button',
                'dynamic_content' => 'url',
            ),
            'button_url_new_window' => array(
                'label' => esc_html__('Button URL Opens', 'divi-post-carousel'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'off' => esc_html__('In The Same Window', 'divi-post-carousel'),
                    'on' => esc_html__('In The New Tab', 'divi-post-carousel'),
                ),
                'toggle_slug' => 'button',
                'description' => esc_html__('Choose whether the URL should open in a new window.', 'divi-post-carousel'),
                'default_on_front' => 'off',
            ),
        );
    }
    
    public function render($attrs, $content = null, $render_slug) {
        // Load necessary scripts and styles
        if (function_exists('dpcm')) {
            dpcm()->enqueue_module_assets();
        }
        
        $title = $this->props['title'];
        $image = $this->props['image'];
        $image_alt = $this->props['image_alt'];
        $use_image_as_link = $this->props['use_image_as_link'];
        $image_url = $this->props['image_url'];
        $button_text = $this->props['button_text'];
        $button_url = $this->props['button_url'];
        $button_url_new_window = $this->props['button_url_new_window'] === 'on' ? 'target="_blank"' : '';
        $header_level = $this->props['header_level'];
        
        // Build the slide content
        $output = '<div class="dpcm_slide">';
        
        // Add image if provided
        if ($image) {
            $output .= '<div class="dpcm_slide_image">';
            if ('on' === $use_image_as_link && $image_url) {
                $target = 'on' === $button_url_new_window ? ' target="_blank" rel="noopener noreferrer"' : '';
                $output .= sprintf(
                    '<a href="%1$s"%2$s><img src="%3$s" alt="%4$s" /></a>',
                    esc_url($image_url),
                    $target,
                    esc_url($image),
                    esc_attr($image_alt)
                );
            } else {
                $output .= sprintf(
                    '<img src="%1$s" alt="%2$s" />',
                    esc_url($image),
                    esc_attr($image_alt)
                );
            }
            $output .= '</div>';
        }
        
        // Add title if provided
        if ($title) {
            $output .= sprintf(
                '<%1$s class="dpcm_slide_title">%2$s</%1$s>',
                et_pb_process_header_level($header_level, 'h3'),
                esc_html($title)
            );
        }
        
        // Add content if provided
        if ($this->content) {
            $output .= sprintf(
                '<div class="dpcm_slide_content">%1$s</div>',
                $this->content
            );
        }
        
        // Add button if button text is provided
        if ($button_text && $button_url) {
            $output .= sprintf(
                '<div class="dpcm_slide_button_wrapper">
                    <a class="dpcm_slide_button et_pb_button%3$s" href="%1$s"%2$s>%4$s</a>
                </div>',
                esc_url($button_url),
                $button_url_new_window,
                esc_attr(" {$this->module_classname([
                    'button'
                ])}"),
                esc_html($button_text)
            );
        }
        
        $output .= '</div>';
        
        return $output;
    }
} 