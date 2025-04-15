<?php
/**
 * Post Carousel Module Class
 */
if (!class_exists('Divi_Post_Carousel_Module')):

class Divi_Post_Carousel_Module extends ET_Builder_Module {
    
    function __construct() {
        parent::__construct();
        $this->init();
    }
    
    public function init() {
        $this->name       = esc_html__('Post Carousel', 'divi-post-carousel');
        $this->plural     = esc_html__('Post Carousels', 'divi-post-carousel');
        $this->slug       = 'dpc_post_carousel';
        $this->vb_support = 'on';
        $this->icon               = 'n';
        $this->icon_font_family   = 'ETmodules';
        
        $this->main_css_element = '%%order_class%%.dpc_post_carousel';
        
        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content' => esc_html__('Content', 'divi-post-carousel'),
                    'elements'     => esc_html__('Elements', 'divi-post-carousel'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'layout'  => esc_html__('Layout', 'divi-post-carousel'),
                    'header'  => array(
                        'title'    => esc_html__('Heading', 'divi-post-carousel'),
                        'priority' => 49,
                    ),
                    'title'  => array(
                        'title'    => esc_html__('Title', 'divi-post-carousel'),
                        'priority' => 50,
                    ),
                    'body'   => array(
                        'title'    => esc_html__('Body', 'divi-post-carousel'),
                        'priority' => 51,
                    ),
                    'category'   => array(
                        'title'    => esc_html__('Category', 'divi-post-carousel'),
                        'priority' => 52,
                    ),
                    'button'   => array(
                        'title'    => esc_html__('Button', 'divi-post-carousel'),
                        'priority' => 53,
                    ),
                ),
            ),
        );
        
        $this->advanced_fields = array(
            'fonts'      => array(
                'header' => array(
                    'label'    => esc_html__('Heading', 'divi-post-carousel'),
                    'css'      => array(
                        'main' => "{$this->main_css_element} .dpc_heading",
                    ),
                    'font_size' => array(
                        'default' => '30px',
                    ),
                    'line_height' => array(
                        'default' => '1.3em',
                    ),
                    'toggle_slug' => 'header',
                ),
                'title' => array(
                    'label'    => esc_html__('Title', 'divi-post-carousel'),
                    'css'      => array(
                        'main' => "{$this->main_css_element} .dpc_title",
                    ),
                    'font_size' => array(
                        'default' => '18px',
                    ),
                    'line_height' => array(
                        'default' => '1.3em',
                    ),
                    'toggle_slug' => 'title',
                ),
                'body' => array(
                    'label'    => esc_html__('Body', 'divi-post-carousel'),
                    'css'      => array(
                        'main' => "{$this->main_css_element} .dpc_content",
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.5em',
                    ),
                    'toggle_slug' => 'body',
                ),
                'category' => array(
                    'label'    => esc_html__('Category', 'divi-post-carousel'),
                    'css'      => array(
                        'main' => "{$this->main_css_element} .dpc_category",
                    ),
                    'font_size' => array(
                        'default' => '12px',
                    ),
                    'line_height' => array(
                        'default' => '1.2em',
                    ),
                    'toggle_slug' => 'category',
                ),
            ),
            'button' => array(
                'button' => array(
                    'label' => esc_html__('Button', 'divi-post-carousel'),
                    'css' => array(
                        'main' => "{$this->main_css_element} .dpc_button",
                    ),
                    'box_shadow'  => array(
                        'css' => array(
                            'main' => "{$this->main_css_element} .dpc_button",
                        ),
                    ),
                    'margin_padding' => array(
                        'css' => array(
                            'important' => 'all',
                        ),
                    ),
                    'toggle_slug' => 'button',
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "{$this->main_css_element} .dpc_slide",
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "{$this->main_css_element} .dpc_slide",
                            'border_styles' => "{$this->main_css_element} .dpc_slide",
                        ),
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "{$this->main_css_element} .dpc_slide",
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'important' => 'all',
                ),
            ),
            'text' => array(
                'use_background_layout' => false,
                'options' => array(
                    'background_layout' => array(
                        'default' => 'light',
                    ),
                ),
            ),
        );
    }
    
    public function get_fields() {
        $post_types = $this->get_post_types();
        
        return array(
            'heading' => array(
                'label'           => esc_html__('Heading', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the heading for your module here.', 'divi-post-carousel'),
                'toggle_slug'     => 'main_content',
                'default'         => 'Heading Goes Here',
            ),
            'post_type' => array(
                'label'             => esc_html__('Post Type', 'divi-post-carousel'),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'options'           => $post_types,
                'default'           => 'post',
                'description'       => esc_html__('Choose the post type to display in the carousel.', 'divi-post-carousel'),
                'toggle_slug'       => 'main_content',
            ),
            'posts_number' => array(
                'label'             => esc_html__('Number of Posts', 'divi-post-carousel'),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'default'           => '6',
                'description'       => esc_html__('Choose how many posts you would like to display in the carousel.', 'divi-post-carousel'),
                'toggle_slug'       => 'main_content',
            ),
            'show_image' => array(
                'label'             => esc_html__('Show Featured Image', 'divi-post-carousel'),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'elements',
            ),
            'show_title' => array(
                'label'             => esc_html__('Show Title', 'divi-post-carousel'),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'elements',
            ),
            'show_excerpt' => array(
                'label'             => esc_html__('Show Excerpt', 'divi-post-carousel'),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'elements',
            ),
            'excerpt_length' => array(
                'label'             => esc_html__('Excerpt Length', 'divi-post-carousel'),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'default'           => '100',
                'description'       => esc_html__('Choose the length of the excerpt in characters.', 'divi-post-carousel'),
                'toggle_slug'       => 'elements',
                'show_if'           => array(
                    'show_excerpt' => 'on',
                ),
            ),
            'show_category' => array(
                'label'             => esc_html__('Show Category', 'divi-post-carousel'),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'elements',
            ),
            'show_button' => array(
                'label'             => esc_html__('Show Button', 'divi-post-carousel'),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'           => 'on',
                'toggle_slug'       => 'elements',
            ),
            'button_text' => array(
                'label'             => esc_html__('Button Text', 'divi-post-carousel'),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'default'           => 'Learn more',
                'description'       => esc_html__('Input the text for the button.', 'divi-post-carousel'),
                'toggle_slug'       => 'elements',
                'show_if'           => array(
                    'show_button' => 'on',
                ),
            ),
            'slides_to_show' => array(
                'label'             => esc_html__('Slides to Show', 'divi-post-carousel'),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'default'           => '3',
                'description'       => esc_html__('Enter the number of slides to show at once.', 'divi-post-carousel'),
                'toggle_slug'       => 'layout',
            ),
            'slides_to_scroll' => array(
                'label'             => esc_html__('Slides to Scroll', 'divi-post-carousel'),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'default'           => '1',
                'description'       => esc_html__('Enter the number of slides to scroll at a time.', 'divi-post-carousel'),
                'toggle_slug'       => 'layout',
            ),
            'auto_play' => array(
                'label'             => esc_html__('Auto Play', 'divi-post-carousel'),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'layout',
            ),
            'auto_play_speed' => array(
                'label'             => esc_html__('Auto Play Speed', 'divi-post-carousel'),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'default'           => '3000',
                'description'       => esc_html__('Enter the speed in milliseconds for the autoplay.', 'divi-post-carousel'),
                'toggle_slug'       => 'layout',
                'show_if'           => array(
                    'auto_play' => 'on',
                ),
            ),
        );
    }
    
    /**
     * Get available post types
     */
    private function get_post_types() {
        $post_types = get_post_types(array('public' => true), 'objects');
        $options = array();
        
        foreach ($post_types as $post_type) {
            if ($post_type->name !== 'attachment') {
                $options[$post_type->name] = $post_type->label;
            }
        }
        
        return $options;
    }
    
    /**
     * Render the module
     */
    public function render($attrs, $content = null, $render_slug) {
        // Get attributes
        $heading = $this->props['heading'];
        $post_type = $this->props['post_type'];
        $posts_number = (int) $this->props['posts_number'];
        $show_image = $this->props['show_image'];
        $show_title = $this->props['show_title'];
        $show_excerpt = $this->props['show_excerpt'];
        $excerpt_length = (int) $this->props['excerpt_length'];
        $show_category = $this->props['show_category'];
        $show_button = $this->props['show_button'];
        $button_text = $this->props['button_text'];
        $slides_to_show = (int) $this->props['slides_to_show'];
        $slides_to_scroll = (int) $this->props['slides_to_scroll'];
        $auto_play = $this->props['auto_play'];
        $auto_play_speed = (int) $this->props['auto_play_speed'];
        
        // Query posts
        $args = array(
            'post_type'      => $post_type,
            'posts_per_page' => $posts_number,
            'post_status'    => 'publish',
        );
        
        $query = new WP_Query($args);
        
        // Make sure query is a valid WP_Query object to prevent errors
        if (!is_object($query) || !($query instanceof WP_Query)) {
            return '<div class="dpc_error">' . esc_html__('Error initializing post query.', 'divi-post-carousel') . '</div>';
        }
        
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
                
                if (!empty($category_object) && !is_wp_error($category_object)) {
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
        
        // Enqueue the frontend script with the module ID
        $script = sprintf(
            '<script>
                jQuery(document).ready(function($) {
                    $(".dpc_carousel").slick({
                        dots: true,
                        arrows: true,
                        infinite: true,
                        speed: 500,
                        slidesToShow: Number($(".dpc_carousel").data("slides-to-show")),
                        slidesToScroll: Number($(".dpc_carousel").data("slides-to-scroll")),
                        autoplay: $(".dpc_carousel").data("auto-play") === "on",
                        autoplaySpeed: Number($(".dpc_carousel").data("auto-play-speed")),
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
        
        return $output . $script;
    }
}

endif; // End class_exists check 