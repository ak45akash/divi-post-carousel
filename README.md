# Divi Post Carousel

A custom Divi module that creates beautiful, responsive post carousels for your WordPress website.

## Features

- Display posts from any post type in a responsive carousel
- Customize carousel heading
- Control which elements are shown (image, title, excerpt, category, button)
- Adjust the number of slides to show and scroll
- Enable/disable autoplay and control autoplay speed
- Fully responsive on all devices
- Compatible with Divi Visual Builder
- Can be used as a shortcode anywhere in your content

## Installation

1. Download the plugin zip file
2. Go to WordPress Dashboard > Plugins > Add New
3. Click "Upload Plugin" and select the downloaded zip file
4. Click "Install Now" and then "Activate" the plugin

## Usage

### Divi Builder Module

1. Edit a page with the Divi Builder
2. Click the "+" button to add a new module
3. Search for "Post Carousel" and select it
4. Configure the settings in the module options:
   - Content tab: Set the heading, post type, number of posts
   - Elements tab: Control which elements to display
   - Design tab: Customize colors, fonts, spacing, etc.
   - Advanced tab: Add custom CSS if needed

### Shortcode Usage

You can also use the post carousel anywhere on your site with the shortcode:

```
[divi_post_carousel heading="Events" post_type="post" category="51" posts_number="6" slides_to_show="3" auto_play="off"]
```

#### Available Shortcode Parameters

| Parameter | Description | Default |
|-----------|-------------|---------|
| `heading` | Title displayed above the carousel | (empty) |
| `post_type` | Type of posts to display | post |
| `posts_number` | Number of posts to show | 6 |
| `category` | Category ID to filter posts | (empty) |
| `slides_to_show` | Number of slides visible at once | 3 |
| `slides_to_scroll` | Number of slides to move when navigating | 1 |
| `auto_play` | Enable auto-scrolling (on/off) | on |
| `auto_play_speed` | Time between slides in milliseconds | 3000 |
| `show_image` | Show featured images (on/off) | on |
| `show_title` | Show post titles (on/off) | on |
| `show_excerpt` | Show post excerpts (on/off) | on |
| `excerpt_length` | Character limit for excerpts | 100 |
| `show_category` | Show category labels (on/off) | on |
| `show_button` | Show "Learn more" buttons (on/off) | on |
| `button_text` | Custom text for buttons | Learn more |

## Customization

The module includes extensive design settings that can be adjusted via the Divi Builder interface:

- Typography: Customize font properties for the heading, title, body, and category
- Colors: Set background colors, text colors, button colors
- Spacing: Adjust margins and padding
- Borders: Customize border style, color, width, and radius
- Box Shadow: Add and customize shadows

## Requirements

- WordPress 5.0 or higher
- Divi Theme 4.0 or higher

## Credits

- Uses [Slick Carousel](https://kenwheeler.github.io/slick/) by Ken Wheeler

## License

GPL v2 or later 