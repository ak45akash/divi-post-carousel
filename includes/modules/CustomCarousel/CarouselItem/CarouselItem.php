<?php

class DPCM_Carousel_Item extends ET_Builder_Module {
    public $slug = 'dpcm_carousel_item';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'content';

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'GCT',
        'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__('Carousel Item', 'divi-post-carousel-module');
        $this->plural = esc_html__('Carousel Items', 'divi-post-carousel-module');
        $this->parent_slug = 'dpcm_custom_carousel';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content' => esc_html__('Content', 'divi-post-carousel-module'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'image' => esc_html__('Image', 'divi-post-carousel-module'),
                    'title' => esc_html__('Title', 'divi-post-carousel-module'),
                    'body'  => esc_html__('Body', 'divi-post-carousel-module'),
                ),
            ),
        );
    }

    public function get_fields() {
        return array(
            'title' => array(
                'label'           => esc_html__('Title', 'divi-post-carousel-module'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input your carousel item title here.', 'divi-post-carousel-module'),
                'toggle_slug'     => 'main_content',
            ),
            'content' => array(
                'label'           => esc_html__('Content', 'divi-post-carousel-module'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Content entered here will appear as the carousel item content.', 'divi-post-carousel-module'),
                'toggle_slug'     => 'main_content',
            ),
            'image' => array(
                'label'              => esc_html__('Image', 'divi-post-carousel-module'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'divi-post-carousel-module'),
                'choose_text'        => esc_attr__('Choose an Image', 'divi-post-carousel-module'),
                'update_text'        => esc_attr__('Set As Image', 'divi-post-carousel-module'),
                'description'        => esc_html__('Upload your desired image, or type in the URL to the image you would like to display.', 'divi-post-carousel-module'),
                'toggle_slug'        => 'main_content',
            ),
            'image_alt' => array(
                'label'           => esc_html__('Image Alt Text', 'divi-post-carousel-module'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Define the HTML ALT text for your image here.', 'divi-post-carousel-module'),
                'toggle_slug'     => 'main_content',
            ),
            'use_button' => array(
                'label'           => esc_html__('Use Button', 'divi-post-carousel-module'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'off' => esc_html__('No', 'divi-post-carousel-module'),
                    'on'  => esc_html__('Yes', 'divi-post-carousel-module'),
                ),
                'default'         => 'off',
                'toggle_slug'     => 'main_content',
            ),
            'button_text' => array(
                'label'           => esc_html__('Button Text', 'divi-post-carousel-module'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input your button text here.', 'divi-post-carousel-module'),
                'toggle_slug'     => 'main_content',
                'show_if'         => array('use_button' => 'on'),
            ),
            'button_url' => array(
                'label'           => esc_html__('Button URL', 'divi-post-carousel-module'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the destination URL for your button.', 'divi-post-carousel-module'),
                'toggle_slug'     => 'main_content',
                'show_if'         => array('use_button' => 'on'),
            ),
        );
    }

    public function get_advanced_fields_config() {
        return array(
            'fonts' => array(
                'title' => array(
                    'label'       => esc_html__('Title', 'divi-post-carousel-module'),
                    'css'         => array(
                        'main' => '%%order_class%% .dpcm-carousel-item-title',
                    ),
                    'font_size'   => array(
                        'default' => '18px',
                    ),
                    'line_height' => array(
                        'default' => '1.3em',
                    ),
                    'toggle_slug' => 'title',
                ),
                'body' => array(
                    'label'       => esc_html__('Body', 'divi-post-carousel-module'),
                    'css'         => array(
                        'main' => '%%order_class%% .dpcm-carousel-item-content',
                    ),
                    'font_size'   => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'toggle_slug' => 'body',
                ),
                'button' => array(
                    'label'         => esc_html__('Button', 'divi-post-carousel-module'),
                    'css'           => array(
                        'main'      => '%%order_class%% .dpcm-carousel-item-button',
                        'important' => 'all',
                    ),
                    'font_size'     => array(
                        'default' => '14px',
                    ),
                    'line_height'   => array(
                        'default' => '1.7em',
                    ),
                    'use_alignment' => true,
                ),
            ),
            'borders' => array(
                'default' => array(),
                'image'   => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .dpcm-carousel-item-image img',
                            'border_styles' => '%%order_class%% .dpcm-carousel-item-image img',
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'divi-post-carousel-module'),
                    'toggle_slug'  => 'image',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'image'   => array(
                    'label'       => esc_html__('Image Box Shadow', 'divi-post-carousel-module'),
                    'css'         => array(
                        'main' => '%%order_class%% .dpcm-carousel-item-image img',
                    ),
                    'toggle_slug' => 'image',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dpcm-carousel-item',
                    'important' => 'all',
                ),
            ),
            'text' => array(
                'use_text_orientation' => true,
                'css' => array(
                    'text_orientation' => '%%order_class%% .dpcm-carousel-item',
                ),
            ),
            'button' => array(
                'button' => array(
                    'label' => esc_html__('Button', 'divi-post-carousel-module'),
                    'css' => array(
                        'main' => '%%order_class%% .dpcm-carousel-item-button',
                        'alignment' => '%%order_class%% .dpcm-carousel-item-button-wrapper',
                    ),
                    'use_alignment' => true,
                    'box_shadow'    => array(
                        'css' => array(
                            'main' => '%%order_class%% .dpcm-carousel-item-button',
                        ),
                    ),
                ),
            ),
        );
    }

    public function render($attrs, $content = null, $render_slug) {
        $title      = $this->props['title'];
        $content    = $this->content;
        $image      = $this->props['image'];
        $image_alt  = $this->props['image_alt'];
        $use_button = $this->props['use_button'];
        $button_text = $this->props['button_text'];
        $button_url = $this->props['button_url'];

        $image_html = '';
        if ($image) {
            $image_html = sprintf(
                '<div class="dpcm-carousel-item-image">
                    <img src="%1$s" alt="%2$s" />
                </div>',
                esc_url($image),
                esc_attr($image_alt)
            );
        }

        $title_html = '';
        if ($title) {
            $title_html = sprintf(
                '<h3 class="dpcm-carousel-item-title">%1$s</h3>',
                esc_html($title)
            );
        }

        $content_html = '';
        if ($content) {
            $content_html = sprintf(
                '<div class="dpcm-carousel-item-content">%1$s</div>',
                et_core_sanitized_previously($content)
            );
        }

        $button_html = '';
        if ('on' === $use_button && $button_text) {
            $button_html = sprintf(
                '<div class="dpcm-carousel-item-button-wrapper">
                    <a class="dpcm-carousel-item-button et_pb_button" href="%1$s">%2$s</a>
                </div>',
                esc_url($button_url),
                esc_html($button_text)
            );
        }

        $output = sprintf(
            '<div class="dpcm-carousel-item">
                %1$s
                <div class="dpcm-carousel-item-content-wrapper">
                    %2$s
                    %3$s
                    %4$s
                </div>
            </div>',
            $image_html,
            $title_html,
            $content_html,
            $button_html
        );

        return $output;
    }
} 