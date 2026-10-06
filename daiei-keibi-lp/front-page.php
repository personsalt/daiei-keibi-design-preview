<?php
/**
 * LP front page.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content">
	<?php get_template_part( 'template-parts/section', 'hero' ); ?>
	<?php
	$sections = array(
		'stats',
		'about',
		'philosophy',
		'services',
		'business',
		'area',
		'recruit',
		'team',
		'benefits',
		'dorm',
		'day-flow',
		'jobs',
		'entry-flow',
		'faq',
		'company',
		'contact',
	);
	foreach ( $sections as $section ) {
		$option_key = str_replace( '-', '_', $section );
		if ( daiei_section_enabled( $option_key ) ) {
			get_template_part( 'template-parts/section', $section );
		}
	}
	?>
</main>
<?php
get_footer();
