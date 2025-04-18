<?php
/**
 * Post Carousel Module Class
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Only proceed if ET_Builder_Module exists (Divi is active)
if (!class_exists('ET_Builder_Module')) {
    return;
}

class DPCM_Post_Carousel extends ET_Builder_Module {
    
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
                'label'           => esc_html__('Posts Number', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'description'     => esc_html__('Choose how many posts you would like to display in the carousel.', 'divi-post-carousel'),
                'toggle_slug'     => 'main_content',
                'default'         => '10',
            ),
            'include_categories' => array(
                'label'            => esc_html__('Include Categories', 'divi-post-carousel'),
                'type'             => 'categories',
                'option_category'  => 'basic_option',
                'renderer_options' => array(
                    'use_terms' => false,
                ),
                'description'      => esc_html__('Choose which categories you would like to include in the carousel.', 'divi-post-carousel'),
                'toggle_slug'      => 'main_content',
                'computed_affects' => array('__posts'),
            ),
            'posts_order' => array(
                'label'           => esc_html__('Order', 'divi-post-carousel'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => array(
                    'DESC' => esc_html__('Descending', 'divi-post-carousel'),
                    'ASC'  => esc_html__('Ascending', 'divi-post-carousel'),
                ),
                'default'         => 'DESC',
                'description'     => esc_html__('Choose the order of the posts.', 'divi-post-carousel'),
                'toggle_slug'     => 'main_content',
            ),
            'posts_orderby' => array(
                'label'           => esc_html__('Order By', 'divi-post-carousel'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => array(
                    'date'          => esc_html__('Date', 'divi-post-carousel'),
                    'title'         => esc_html__('Title', 'divi-post-carousel'),
                    'modified'      => esc_html__('Last Modified Date', 'divi-post-carousel'),
                    'rand'          => esc_html__('Random', 'divi-post-carousel'),
                    'comment_count' => esc_html__('Comment Count', 'divi-post-carousel'),
                ),
                'default'         => 'date',
                'description'     => esc_html__('Choose how to sort the posts.', 'divi-post-carousel'),
                'toggle_slug'     => 'main_content',
            ),
            'show_thumbnail' => array(
                'label'           => esc_html__('Show Featured Image', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'show_title' => array(
                'label'           => esc_html__('Show Title', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'show_excerpt' => array(
                'label'           => esc_html__('Show Excerpt', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'excerpt_length' => array(
                'label'           => esc_html__('Excerpt Length', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'description'     => esc_html__('Define the length of automatically generated excerpts.', 'divi-post-carousel'),
                'default'         => '100',
                'toggle_slug'     => 'elements',
                'show_if'         => array(
                    'show_excerpt' => 'on',
                ),
            ),
            'show_category' => array(
                'label'           => esc_html__('Show Category', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'show_date' => array(
                'label'           => esc_html__('Show Date', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'show_author' => array(
                'label'           => esc_html__('Show Author', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'show_read_more' => array(
                'label'           => esc_html__('Show Read More Button', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'elements',
            ),
            'read_more_text' => array(
                'label'           => esc_html__('Read More Button Text', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'description'     => esc_html__('Define the read more button text.', 'divi-post-carousel'),
                'default'         => esc_html__('Read More', 'divi-post-carousel'),
                'toggle_slug'     => 'elements',
                'show_if'         => array(
                    'show_read_more' => 'on',
                ),
            ),
            // Carousel Settings
            'slides_to_show' => array(
                'label'           => esc_html__('Slides to Show', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'description'     => esc_html__('Number of slides to show at once.', 'divi-post-carousel'),
                'default'         => '3',
                'toggle_slug'     => 'carousel_settings',
            ),
            'slides_to_scroll' => array(
                'label'           => esc_html__('Slides to Scroll', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'description'     => esc_html__('Number of slides to scroll at a time.', 'divi-post-carousel'),
                'default'         => '1',
                'toggle_slug'     => 'carousel_settings',
            ),
            'autoplay' => array(
                'label'           => esc_html__('Autoplay', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'carousel_settings',
            ),
            'autoplay_speed' => array(
                'label'           => esc_html__('Autoplay Speed (ms)', 'divi-post-carousel'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'description'     => esc_html__('Speed of the autoplay slideshow in milliseconds.', 'divi-post-carousel'),
                'default'         => '3000',
                'toggle_slug'     => 'carousel_settings',
                'show_if'         => array(
                    'autoplay' => 'on',
                ),
            ),
            'show_arrows' => array(
                'label'           => esc_html__('Show Arrows', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'carousel_settings',
            ),
            'show_dots' => array(
                'label'           => esc_html__('Show Dots Navigation', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'carousel_settings',
            ),
            'infinite' => array(
                'label'           => esc_html__('Infinite Loop', 'divi-post-carousel'),
                'type'            => 'yes_no_button',
                'option_category' => 'configuration',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'divi-post-carousel'),
                    'off' => esc_html__('No', 'divi-post-carousel'),
                ),
                'default'         => 'on',
                'toggle_slug'     => 'carousel_settings',
            ),
        );
    }
    
    private function get_post_types() {
        $post_types = array();
        
        // Get public post types
        $types = get_post_types(array('public' => true), 'objects');
        
        foreach ($types as $type) {
            if (!in_array($type->name, array('attachment', 'revision', 'nav_menu_item'))) {
                $post_types[$type->name] = $type->label;
            }
        }
        
        return $post_types;
    }
    
    public function render($attrs, $content = null, $render_slug) {
        // Process module attributes
        $heading         = $this->props['heading'];
        $post_type       = $this->props['post_type'];
        $posts_number    = $this->props['posts_number'];
        $include_categories = $this->props['include_categories'];
        $posts_order     = $this->props['posts_order'];
        $posts_orderby   = $this->props['posts_orderby'];
        $show_thumbnail  = $this->props['show_thumbnail'];
        $show_title      = $this->props['show_title'];
        $show_excerpt    = $this->props['show_excerpt'];
        $excerpt_length  = $this->props['excerpt_length'];
        $show_category   = $this->props['show_category'];
        $show_date       = $this->props['show_date'];
        $show_author     = $this->props['show_author'];
        $show_read_more  = $this->props['show_read_more'];
        $read_more_text  = $this->props['read_more_text'];
        
        // Carousel settings
        $slides_to_show  = $this->props['slides_to_show'];
        $slides_to_scroll = $this->props['slides_to_scroll'];
        $autoplay        = $this->props['autoplay'];
        $autoplay_speed  = $this->props['autoplay_speed'];
        $show_arrows     = $this->props['show_arrows'];
        $show_dots       = $this->props['show_dots'];
        $infinite        = $this->props['infinite'];
        
        // Generate unique IDs for this carousel and dots container
        $carousel_id = 'dpc_carousel_' . mt_rand(1000, 9999) . '_' . uniqid();
        $dots_id = 'dpc_dots_' . mt_rand(1000, 9999) . '_' . uniqid();
        
        // Query arguments
        $args = array(
            'post_type'      => $post_type,
            'posts_per_page' => intval($posts_number),
            'post_status'    => 'publish',
            'orderby'        => $posts_orderby,
            'order'          => $posts_order,
        );
        
        // Include specific categories if set
        if (!empty($include_categories) && $post_type == 'post') {
            $args['cat'] = $include_categories;
        }
        
        // Query posts
        $query = new WP_Query($args);
        
        // Start output buffer
        ob_start();
        
        if ($query->have_posts()) :
            ?>
            <div class="dpc_post_carousel">
                <?php if (!empty($heading)) : ?>
                    <h2 class="dpc_heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                
                <div id="<?php echo esc_attr($carousel_id); ?>" class="dpc_carousel" 
                     data-slides-to-show="<?php echo esc_attr($slides_to_show); ?>" 
                     data-slides-to-scroll="<?php echo esc_attr($slides_to_scroll); ?>" 
                     data-auto-play="<?php echo $autoplay === 'on' ? 'on' : 'off'; ?>" 
                     data-auto-play-speed="<?php echo esc_attr($autoplay_speed); ?>">
                    
                    <?php while ($query->have_posts()) : $query->the_post(); 
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
                    ?>
                        <div class="dpc_slide">
                            <?php if ($show_thumbnail === 'on' && has_post_thumbnail()) : ?>
                                <div class="dpc_image">
                                    <a href="<?php echo esc_url($post_link); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($show_category === 'on' && !empty($category)) : ?>
                                <div class="dpc_category"><?php echo esc_html($category); ?></div>
                            <?php endif; ?>
                            
                            <?php if ($show_title === 'on') : ?>
                                <div class="dpc_title">
                                    <a href="<?php echo esc_url($post_link); ?>"><?php echo esc_html($post_title); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($show_excerpt === 'on') : ?>
                                <div class="dpc_content">
                                    <?php
                                    $excerpt = get_the_excerpt();
                                    if (strlen($excerpt) > $excerpt_length) {
                                        $excerpt = substr($excerpt, 0, $excerpt_length) . '...';
                                    }
                                    echo wp_kses_post($excerpt);
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($show_read_more === 'on') : ?>
                                <a href="<?php echo esc_url($post_link); ?>" class="dpc_button">
                                    <?php echo esc_html($read_more_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <div id="<?php echo esc_attr($dots_id); ?>" class="dpc_dots"></div>
            </div>
            
            <script>
                jQuery(document).ready(function($) {
                    $('#<?php echo esc_js($carousel_id); ?>').not('.slick-initialized').slick({
                        dots: true,
                        arrows: true,
                        infinite: true, 
                        speed: 500,
                        slidesToShow: Number($('#<?php echo esc_js($carousel_id); ?>').data('slides-to-show')) || 3,
                        slidesToScroll: Number($('#<?php echo esc_js($carousel_id); ?>').data('slides-to-scroll')) || 1,
                        autoplay: $('#<?php echo esc_js($carousel_id); ?>').data('auto-play') === 'on',
                        autoplaySpeed: Number($('#<?php echo esc_js($carousel_id); ?>').data('auto-play-speed')) || 3000,
                        appendDots: $('#<?php echo esc_js($dots_id); ?>'),
                        prevArrow: '<button type="button" class="slick-prev"><</button>',
                        nextArrow: '<button type="button" class="slick-next">></button>',
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
        else :
            ?>
            <div class="dpc_no_posts">
                <p><?php echo esc_html__('No posts found.', 'divi-post-carousel'); ?></p>
            </div>
            <?php
        endif;
        
        wp_reset_postdata();
        
        return ob_get_clean();
    }
} 