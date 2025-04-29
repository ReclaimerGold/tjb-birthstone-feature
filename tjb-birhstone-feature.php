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
 *   field (string) – either 'title' (default) or 'url'
 *
 * @param array $atts Shortcode attributes.
 * @return string Escaped title or URL, or empty string if no match.
 */
function tjb_bf_get_current_month_birthstone( $atts ) {
	$atts = shortcode_atts( array(
		'field' => 'title',
	), $atts, 'birthstone' );

	$field = sanitize_key( $atts['field'] );
	if ( ! in_array( $field, array( 'title', 'url' ), true ) ) {
		$field = 'title';
	}

	$current_month = date_i18n( 'F' ); // localized month name

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

	if ( 'url' === $field ) {
		return esc_url( get_permalink( $post_id ) );
	}

	return esc_html( get_the_title( $post_id ) );
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
