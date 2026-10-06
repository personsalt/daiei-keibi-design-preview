<?php
/**
 * Theme bootstrap.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$daiei_theme_includes = array(
	'/inc/helpers.php',
	'/inc/theme-setup.php',
	'/inc/customizer.php',
	'/inc/post-types.php',
	'/inc/contact-handler.php',
	'/inc/structured-data.php',
);

foreach ( $daiei_theme_includes as $daiei_theme_include ) {
	require_once get_template_directory() . $daiei_theme_include;
}
