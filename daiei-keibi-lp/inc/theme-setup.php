<?php
/**
 * Theme supports, assets, and shared WordPress hooks.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configure the theme.
 *
 * @return void
 */
function daiei_theme_setup() {
	load_theme_textdomain( 'daiei-keibi-lp', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 84,
			'width'       => 280,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'グローバルナビゲーション', 'daiei-keibi-lp' ),
			'footer'  => __( 'フッターナビゲーション', 'daiei-keibi-lp' ),
		)
	);
}
add_action( 'after_setup_theme', 'daiei_theme_setup' );

/**
 * Enqueue local styles and scripts.
 *
 * @return void
 */
function daiei_enqueue_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'daiei-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style(
		'daiei-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'daiei-style' ),
		$version
	);
	wp_enqueue_script(
		'daiei-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		$version,
		true
	);
	wp_localize_script(
		'daiei-main',
		'daieiTheme',
		array(
			'reducedMotion' => false,
			'formType'      => isset( $_GET['form_type'] ) ? sanitize_key( wp_unslash( $_GET['form_type'] ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		)
	);
}
add_action( 'wp_enqueue_scripts', 'daiei_enqueue_assets' );

/**
 * Add defer to the theme's standalone JavaScript.
 *
 * @param string $tag    Script HTML.
 * @param string $handle Script handle.
 * @return string
 */
function daiei_defer_script( $tag, $handle ) {
	if ( 'daiei-main' === $handle && false === strpos( $tag, ' defer' ) ) {
		return str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'daiei_defer_script', 10, 2 );

/**
 * Output Customizer colors as a small set of CSS variables.
 *
 * @return void
 */
function daiei_customizer_css() {
	$main   = sanitize_hex_color( daiei_get_option( 'daiei_main_color', '#0B1F33' ) );
	$accent = sanitize_hex_color( daiei_get_option( 'daiei_accent_color', '#F4C430' ) );
	if ( ! $main ) {
		$main = '#0B1F33';
	}
	if ( ! $accent ) {
		$accent = '#F4C430';
	}
	?>
	<style id="daiei-custom-colors">
		:root{--color-main:<?php echo esc_html( $main ); ?>;--color-accent:<?php echo esc_html( $accent ); ?>}
	</style>
	<?php
}
add_action( 'wp_head', 'daiei_customizer_css', 30 );
