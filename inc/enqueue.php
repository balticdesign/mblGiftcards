<?php
/**
 * UnderStrap enqueue scripts
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'understrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function understrap_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.css' );
		wp_enqueue_style( 'understrap-styles', get_template_directory_uri() . '/css/theme.css', array(), $css_version );
		wp_enqueue_style( 'client-styles', get_template_directory_uri() . '/css/customizer_css.php', array(), $css_version );
		wp_enqueue_style( 'slickCSS', get_stylesheet_directory_uri().'/css/slick.css', array(), false, false );
		wp_enqueue_style('dynamic-css',
		admin_url('admin-ajax.php').'?action=dynamic_css',
		$deps,
		$ver,
		$media);
		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'understrap-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );
		wp_enqueue_script('slickJS', get_template_directory_uri().'/js/slick.min.js', array(), false, true);
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'understrap_scripts' ).

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );