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
        
        // Generate unique ID for this carousel
        $carousel_id = 'dpc_' . mt_rand(100000, 999999);
        
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
                
                <?php
                // Data attributes for slick initialization
                $data_attributes = sprintf(
                    'data-slides-to-show="%1$s" data-slides-to-scroll="%2$s" data-autoplay="%3$s" data-autoplay-speed="%4$s" data-arrows="%5$s" data-dots="%6$s" data-infinite="%7$s"',
                    esc_attr($slides_to_show),
                    esc_attr($slides_to_scroll),
                    $autoplay === 'on' ? 'true' : 'false',
                    esc_attr($autoplay_speed),
                    $show_arrows === 'on' ? 'true' : 'false',
                    $show_dots === 'on' ? 'true' : 'false',
                    $infinite === 'on' ? 'true' : 'false'
                );
                ?>
                
                <div id="<?php echo esc_attr($carousel_id); ?>" class="dpc_carousel" <?php echo $data_attributes; ?>>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="dpc_slide">
                            <?php if ($show_thumbnail === 'on' && has_post_thumbnail()) : ?>
                                <div class="dpc_image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="dpc_content_wrap">
                                <?php if ($show_date === 'on' || $show_author === 'on' || $show_category === 'on') : ?>
                                    <div class="dpc_meta">
                                        <?php if ($show_date === 'on') : ?>
                                            <span class="dpc_date"><?php echo get_the_date(); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($show_author === 'on') : ?>
                                            <span class="dpc_author">
                                                <?php echo esc_html__('By ', 'divi-post-carousel') . get_the_author(); ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if ($show_category === 'on' && $post_type === 'post') : ?>
                                            <span class="dpc_category">
                                                <?php
                                                $categories = get_the_category();
                                                if (!empty($categories)) {
                                                    echo esc_html($categories[0]->name);
                                                }
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($show_title === 'on') : ?>
                                    <h3 class="dpc_title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                <?php endif; ?>
                                
                                <?php if ($show_excerpt === 'on') : ?>
                                    <div class="dpc_excerpt">
                                        <?php
                                        $excerpt = get_the_excerpt();
                                        echo wp_trim_words($excerpt, intval($excerpt_length), '...');
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($show_read_more === 'on') : ?>
                                    <a href="<?php the_permalink(); ?>" class="dpc_button">
                                        <?php echo esc_html($read_more_text); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
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