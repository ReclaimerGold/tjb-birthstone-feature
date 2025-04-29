# TJB Birthstone Feature

**Author:** Ryan T. M. Reiffenberger  
**Text Domain:** `tjb-birthstone-feature`

![GitHub License](https://img.shields.io/github/license/reclaimergold/rnd-terraform)

## Description

The **TJB Birthstone Feature** plugin provides a simple shortcode to display information from a custom post type `birthstone`, matching the current month. You can output:

- **Title** of the birthstone post
- **Permalink (URL)** to the birthstone post
- **Excerpt** (summary) of the birthstone post
- **Featured Image** (rendered as an `<img>` tag)

Perfect for embedding in page builders like Elementor or directly in posts.

## Installation

1. **Download** or clone the repository into your WordPress plugins folder:
   ```bash
   wp-content/plugins/tjb-birthstone-feature/
   ```
2. **Activate** the plugin in the WordPress Admin under **Plugins → Installed Plugins**.
3. Ensure you have a custom post type registered as `birthstone`, with posts titled exactly `January`, `February`, etc., and set featured images as needed.

## Usage

Add the `[birthstone]` shortcode anywhere in your content. It supports the following attributes:

| Attribute | Values                             | Default | Description                                    |
|-----------|------------------------------------|---------|------------------------------------------------|
| `field`   | `title`, `url`, `excerpt`, `image` | `title` | What to output from the post                   |
| `size`    | Any registered image size string   | `full`  | Only applies when `field="image"`            |

### Examples

- **Title (default)**
  ```html
  [birthstone]
  ```

- **Permalink URL**
  ```html
  [birthstone field="url"]
  ```

- **Excerpt**
  ```html
  [birthstone field="excerpt"]
  ```

- **Featured Image**
  ```html
  [birthstone field="image" size="medium"]
  ```

## Customization

- **Shortcode tag**: To change the tag name, update the `add_shortcode()` call in `tjb-birthstone-feature.php`.
- **Caching**: For high-traffic sites, consider wrapping the query in a transient to reduce database calls.
- **Localization**: All strings are wrapped in WordPress localization functions; place translation files in `/languages/`.