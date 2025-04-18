<?php
/**
 * Custom Carousel Module for Divi
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

class DPCM_Custom_Carousel extends ET_Builder_Module {
    public $slug       = 'dpcm_custom_carousel';
    public $vb_support = 'on';
    public $child_slug = 'dpcm_carousel_item';
    
    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'Your Name',
        'author_uri' => '',
    );
    
    public function init() {
        $this->name = esc_html__( 'Custom Carousel', 'divi-post-carousel-module' );
        $this->icon = 'n';
        $this->main_css_element = '%%order_class%%.dpcm-custom-carousel-container';
        
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content' => esc_html__( 'Carousel Settings', 'divi-post-carousel-module' ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'layout'   => esc_html__( 'Layout', 'divi-post-carousel-module' ),
                    'arrows'   => esc_html__( 'Navigation Arrows', 'divi-post-carousel-module' ),
                    'dots'     => esc_html__( 'Pagination Dots', 'divi-post-carousel-module' ),
                    'overlay'  => esc_html__( 'Overlay', 'divi-post-carousel-module' ),
                ),
            ),
        );
    }
    
    public function get_fields() {
        return array(
            'slides_to_show' => array(
                'label'             => esc_html__( 'Slides To Show', 'divi-post-carousel-module' ),
                'type'              => 'range',
                'option_category'   => 'configuration',
                'default'           => '3',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'responsive'        => true,
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'The number of slides to show at once.', 'divi-post-carousel-module' ),
            ),
            'slides_to_scroll' => array(
                'label'             => esc_html__( 'Slides To Scroll', 'divi-post-carousel-module' ),
                'type'              => 'range',
                'option_category'   => 'configuration',
                'default'           => '1',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '1',
                ),
                'mobile_options'    => true,
                'responsive'        => true,
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'The number of slides to scroll at once.', 'divi-post-carousel-module' ),
            ),
            'autoplay' => array(
                'label'             => esc_html__( 'Autoplay', 'divi-post-carousel-module' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-post-carousel-module' ),
                    'on'  => esc_html__( 'Yes', 'divi-post-carousel-module' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'If enabled, the carousel will autoplay.', 'divi-post-carousel-module' ),
            ),
            'autoplay_speed' => array(
                'label'             => esc_html__( 'Autoplay Speed', 'divi-post-carousel-module' ),
                'type'              => 'range',
                'option_category'   => 'configuration',
                'default'           => '3000',
                'range_settings'    => array(
                    'min'  => '1000',
                    'max'  => '10000',
                    'step' => '500',
                ),
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'The speed in milliseconds at which the autoplay cycles.', 'divi-post-carousel-module' ),
                'depends_show_if'   => 'on',
            ),
            'infinite' => array(
                'label'             => esc_html__( 'Infinite Loop', 'divi-post-carousel-module' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-post-carousel-module' ),
                    'on'  => esc_html__( 'Yes', 'divi-post-carousel-module' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'If enabled, the carousel will loop infinitely.', 'divi-post-carousel-module' ),
            ),
            'pause_on_hover' => array(
                'label'             => esc_html__( 'Pause On Hover', 'divi-post-carousel-module' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-post-carousel-module' ),
                    'on'  => esc_html__( 'Yes', 'divi-post-carousel-module' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'If enabled, the carousel will pause when hovered.', 'divi-post-carousel-module' ),
                'depends_show_if'   => 'on',
            ),
            'use_arrows' => array(
                'label'             => esc_html__( 'Show Arrows', 'divi-post-carousel-module' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-post-carousel-module' ),
                    'on'  => esc_html__( 'Yes', 'divi-post-carousel-module' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'This setting will turn on and off the navigation arrows.', 'divi-post-carousel-module' ),
            ),
            'use_dots' => array(
                'label'             => esc_html__( 'Show Dots', 'divi-post-carousel-module' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-post-carousel-module' ),
                    'on'  => esc_html__( 'Yes', 'divi-post-carousel-module' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'This setting will turn on and off the pagination dots.', 'divi-post-carousel-module' ),
            ),
            'equal_height' => array(
                'label'             => esc_html__( 'Equal Height Slides', 'divi-post-carousel-module' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-post-carousel-module' ),
                    'on'  => esc_html__( 'Yes', 'divi-post-carousel-module' ),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'If enabled, all slides will have equal height.', 'divi-post-carousel-module' ),
            ),
            'arrow_color' => array(
                'label'             => esc_html__( 'Arrow Color', 'divi-post-carousel-module' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'description'       => esc_html__( 'Here you can define a custom color for the arrows.', 'divi-post-carousel-module' ),
            ),
            'arrow_hover_color' => array(
                'label'             => esc_html__( 'Arrow Hover Color', 'divi-post-carousel-module' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'description'       => esc_html__( 'Here you can define a custom hover color for the arrows.', 'divi-post-carousel-module' ),
            ),
            'arrow_background_color' => array(
                'label'             => esc_html__( 'Arrow Background Color', 'divi-post-carousel-module' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'description'       => esc_html__( 'Here you can define a background color for the arrows.', 'divi-post-carousel-module' ),
            ),
            'arrow_background_hover_color' => array(
                'label'             => esc_html__( 'Arrow Background Hover Color', 'divi-post-carousel-module' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrows',
                'description'       => esc_html__( 'Here you can define a background hover color for the arrows.', 'divi-post-carousel-module' ),
            ),
            'dots_color' => array(
                'label'             => esc_html__( 'Dots Color', 'divi-post-carousel-module' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'description'       => esc_html__( 'Here you can define a custom color for the pagination dots.', 'divi-post-carousel-module' ),
            ),
            'dots_active_color' => array(
                'label'             => esc_html__( 'Active Dot Color', 'divi-post-carousel-module' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'description'       => esc_html__( 'Here you can define a custom color for the active pagination dot.', 'divi-post-carousel-module' ),
            ),
        );
    }
    
    public function get_advanced_fields_config() {
        return array(
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "{$this->main_css_element}",
                            'border_styles' => "{$this->main_css_element}",
                        ),
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "{$this->main_css_element}",
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'important' => 'all',
                ),
            ),
            'max_width' => array(
                'css' => array(
                    'main' => "{$this->main_css_element}",
                    'module_alignment' => "{$this->main_css_element}",
                ),
            ),
            'filters' => array(
                'css' => array(
                    'main' => "{$this->main_css_element}",
                ),
            ),
            'text' => array(
                'use_text_orientation' => false,
                'css' => array(
                    'text_shadow' => "{$this->main_css_element}",
                ),
            ),
        );
    }
    
    public function render( $attrs, $content = null, $render_slug ) {
        // Get props
        $slides_to_show    = $this->props['slides_to_show'];
        $slides_to_scroll  = $this->props['slides_to_scroll'];
        $autoplay          = $this->props['autoplay'];
        $autoplay_speed    = $this->props['autoplay_speed'];
        $infinite          = $this->props['infinite'];
        $pause_on_hover    = $this->props['pause_on_hover'];
        $use_arrows        = $this->props['use_arrows'];
        $use_dots          = $this->props['use_dots'];
        $equal_height      = $this->props['equal_height'];
        
        // Responsive breakpoints
        $slides_to_show_tablet = isset($this->props['slides_to_show_tablet']) ? $this->props['slides_to_show_tablet'] : $slides_to_show;
        $slides_to_show_phone  = isset($this->props['slides_to_show_phone']) ? $this->props['slides_to_show_phone'] : '1';
        $slides_to_scroll_tablet = isset($this->props['slides_to_scroll_tablet']) ? $this->props['slides_to_scroll_tablet'] : $slides_to_scroll;
        $slides_to_scroll_phone  = isset($this->props['slides_to_scroll_phone']) ? $this->props['slides_to_scroll_phone'] : '1';
        
        // Custom styling
        $arrow_color = !empty($this->props['arrow_color']) ? $this->props['arrow_color'] : '';
        $arrow_hover_color = !empty($this->props['arrow_hover_color']) ? $this->props['arrow_hover_color'] : '';
        $arrow_bg_color = !empty($this->props['arrow_background_color']) ? $this->props['arrow_background_color'] : '';
        $arrow_bg_hover_color = !empty($this->props['arrow_background_hover_color']) ? $this->props['arrow_background_hover_color'] : '';
        $dots_color = !empty($this->props['dots_color']) ? $this->props['dots_color'] : '';
        $dots_active_color = !empty($this->props['dots_active_color']) ? $this->props['dots_active_color'] : '';
        
        // CSS for arrows
        if ( '' !== $arrow_color ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before',
                'declaration' => sprintf('color: %1$s !important;', esc_attr($arrow_color)),
            ));
        }
        
        if ( '' !== $arrow_hover_color ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .slick-prev:hover:before, %%order_class%% .slick-next:hover:before',
                'declaration' => sprintf('color: %1$s !important;', esc_attr($arrow_hover_color)),
            ));
        }
        
        if ( '' !== $arrow_bg_color ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .slick-prev, %%order_class%% .slick-next',
                'declaration' => sprintf('background-color: %1$s !important;', esc_attr($arrow_bg_color)),
            ));
        }
        
        if ( '' !== $arrow_bg_hover_color ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .slick-prev:hover, %%order_class%% .slick-next:hover',
                'declaration' => sprintf('background-color: %1$s !important;', esc_attr($arrow_bg_hover_color)),
            ));
        }
        
        // CSS for dots
        if ( '' !== $dots_color ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .slick-dots li button:before',
                'declaration' => sprintf('color: %1$s !important;', esc_attr($dots_color)),
            ));
        }
        
        if ( '' !== $dots_active_color ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .slick-dots li.slick-active button:before',
                'declaration' => sprintf('color: %1$s !important;', esc_attr($dots_active_color)),
            ));
        }
        
        // Equal height class
        $equal_height_class = 'on' === $equal_height ? ' dpcm-equal-height' : '';
        
        // Data attributes for Slick initialization
        $data_attrs = sprintf(
            'data-slides-to-show="%1$s" data-slides-to-scroll="%2$s" data-autoplay="%3$s" data-autoplay-speed="%4$s" data-infinite="%5$s" data-pause-on-hover="%6$s" data-arrows="%7$s" data-dots="%8$s" data-slides-to-show-tablet="%9$s" data-slides-to-scroll-tablet="%10$s" data-slides-to-show-phone="%11$s" data-slides-to-scroll-phone="%12$s"',
            esc_attr($slides_to_show),
            esc_attr($slides_to_scroll),
            esc_attr($autoplay),
            esc_attr($autoplay_speed),
            esc_attr($infinite),
            esc_attr($pause_on_hover),
            esc_attr($use_arrows),
            esc_attr($use_dots),
            esc_attr($slides_to_show_tablet),
            esc_attr($slides_to_scroll_tablet),
            esc_attr($slides_to_show_phone),
            esc_attr($slides_to_scroll_phone)
        );
        
        // Enqueue Slick scripts and styles
        wp_enqueue_style('slick-carousel', plugin_dir_url(__FILE__) . '../../../assets/css/slick.css');
        wp_enqueue_style('slick-carousel-theme', plugin_dir_url(__FILE__) . '../../../assets/css/slick-theme.css');
        wp_enqueue_script('slick-carousel', plugin_dir_url(__FILE__) . '../../../assets/js/slick.min.js', array('jquery'), '1.8.1', true);
        wp_enqueue_script('divi-custom-carousel', plugin_dir_url(__FILE__) . '../../../assets/js/divi-post-carousel.js', array('jquery', 'slick-carousel'), '1.0.0', true);
        
        // Add our custom CSS
        wp_enqueue_style('divi-custom-carousel', plugin_dir_url(__FILE__) . '../../../assets/css/divi-custom-carousel.css');
        
        // Render output
        $output = sprintf(
            '<div class="dpcm-custom-carousel-container%2$s" %3$s>
                <div class="dpcm-custom-carousel">
                    %1$s
                </div>
            </div>',
            $this->content,
            esc_attr($equal_height_class),
            $data_attrs
        );
        
        return $output;
    }
} 