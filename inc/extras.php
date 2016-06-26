<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Enterprise
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function enterprise_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) :
		$classes[] = 'group-blog';
	endif;

	return $classes;
}
add_filter( 'body_class', 'enterprise_body_classes' );

/**
 * Render document title for backwards compatibility
 *
 * @resource https://make.wordpress.org/core/2015/10/20/document-title-in-4-4/
 * @since 1.0.3
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function enterprise_lite_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'enterprise_lite_render_title' );
}

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function enterprise_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'enterprise_setup_author' );
