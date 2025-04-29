<?php
/**
 * Plugin Name:     TJB Birthstone Feature
 * Plugin URI:      https://example.com/plugins/tjb-birthstone-feature
 * Description:     Provides a [birthstone] shortcode to output the title or URL of the birthstone post matching the current month.
 * Version:         1.0.0
 * Author:          Ryan T. M. Reiffenberger
 * Author URI:      https://example.com/
 * Text Domain:     tjb-birthstone-feature
 * Domain Path:     /languages
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcode handler for [birthstone].
 *
 * Attributes:
 *   field (string) – 'title' (default), 'url', 'excerpt', or 'image'
 *   size  (string) – image size when using 'image' (defaults to 'full')
 *
 * @param array $atts Shortcode attributes.
 * @return string Escaped output or empty string if no match.
 */
function tjb_bf_get_current_month_birthstone( $atts ) {
    // Default attributes
	$atts = shortcode_atts( array(
		'field' => 'title',
        'size'  => 'full',
	), $atts, 'birthstone' );

	$field = sanitize_key( $atts['field'] );
    // Allowed fields
    $allowed = array( 'title', 'url', 'excerpt', 'image' );
    if ( ! in_array( $field, $allowed, true ) ) {
		$field = 'title';
	}

	$current_month = date_i18n( 'F' ); // localized month name

    // Query for a birthstone post matching the month name
	$query = new WP_Query( array(
		'post_type'      => 'birthstone',
		'title'          => $current_month,
		'posts_per_page' => 1,
		'no_found_rows'  => true,
		'fields'         => 'ids',
	) );

	if ( empty( $query->posts ) ) {
		return '';
	}

	$post_id = $query->posts[0];

    switch ( $field ) {
        case 'url':
		return esc_url( get_permalink( $post_id ) );

        case 'excerpt':
            $excerpt = get_the_excerpt( $post_id );
            return esc_html( $excerpt );

        case 'image':
            // Get image size attribute
            $size = sanitize_key( $atts['size'] );
            $img_url = get_the_post_thumbnail_url( $post_id, $size );
            if ( ! $img_url ) {
                return '';
            }
            // Output an <img> tag for use in Elementor or other builders
            return sprintf(
                '<img src="%s" alt="%s" />',
                esc_url( $img_url ),
                esc_attr( get_the_title( $post_id ) )
            );

        case 'title':
        default:
	return esc_html( get_the_title( $post_id ) );
    }
}
add_shortcode( 'birthstone', 'tjb_bf_get_current_month_birthstone' );

/**
 * Flush rewrite rules on activation/deactivation.
 */
function tjb_bf_activation_hook() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tjb_bf_activation_hook' );

function tjb_bf_deactivation_hook() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'tjb_bf_deactivation_hook' );
