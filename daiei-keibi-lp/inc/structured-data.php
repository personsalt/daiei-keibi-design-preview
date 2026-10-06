<?php
/**
 * SEO metadata and structured data.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detect common SEO plugins that already own document metadata.
 *
 * @return bool
 */
function daiei_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) ||
		defined( 'RANK_MATH_VERSION' ) ||
		defined( 'AIOSEO_VERSION' ) ||
		defined( 'SEOPRESS_VERSION' );
}

/**
 * Output non-duplicative social and search metadata.
 *
 * @return void
 */
function daiei_output_meta_tags() {
	if ( daiei_has_seo_plugin() ) {
		return;
	}

	$description = is_front_page()
		? '株式会社大永警備は、松山市・今治・八幡浜周辺で交通誘導警備、駐車場警備、雑踏警備に対応しています。警備のご相談と警備スタッフのご応募を受け付けています。'
		: wp_strip_all_tags( get_the_excerpt() );
	if ( ! $description ) {
		$description = '株式会社大永警備の公式サイトです。';
	}

	$canonical = is_singular() ? wp_get_canonical_url() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
	$image_id  = is_front_page() ? absint( daiei_get_option( 'daiei_hero_image', 0 ) ) : get_post_thumbnail_id();
	$image     = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : get_template_directory_uri() . '/assets/images/hero-daiei-generated-v1.png';
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<meta property="og:locale" content="ja_JP">
	<meta property="og:type" content="<?php echo is_front_page() ? 'website' : 'article'; ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( daiei_company( 'company_name' ) ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( wp_get_document_title() ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $canonical ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<?php
}
add_action( 'wp_head', 'daiei_output_meta_tags', 5 );

/**
 * Output Organization, WebSite, and FAQPage JSON-LD.
 *
 * @return void
 */
function daiei_output_structured_data() {
	if ( daiei_has_seo_plugin() ) {
		return;
	}

	$organization_id = home_url( '/#organization' );
	$logo_id         = get_theme_mod( 'custom_logo' );
	$logo            = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : get_template_directory_uri() . '/assets/images/logo-daiei-full.png';
	$graph           = array(
		array(
			'@type'       => 'Organization',
			'@id'         => $organization_id,
			'name'        => daiei_company( 'company_name' ),
			'url'         => home_url( '/' ),
			'logo'        => esc_url_raw( $logo ),
			'telephone'   => daiei_company( 'phone' ),
			'foundingDate'=> '2025-04-01',
			'address'     => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => daiei_company( 'address' ),
				'addressRegion'   => '愛媛県',
				'addressCountry'  => 'JP',
			),
			'areaServed'  => array( '松山市', '今治市', '八幡浜市' ),
		),
		array(
			'@type'     => 'WebSite',
			'@id'       => home_url( '/#website' ),
			'url'       => home_url( '/' ),
			'name'      => daiei_company( 'company_name' ) . ' 公式サイト',
			'inLanguage'=> 'ja',
			'publisher' => array( '@id' => $organization_id ),
		),
	);

	if ( is_front_page() && daiei_section_enabled( 'faq' ) ) {
		$faq_entities = array();
		foreach ( daiei_get_faqs() as $faq ) {
			$faq_entities[] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $faq['question'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $faq['answer'] ),
				),
			);
		}
		$graph[] = array(
			'@type'      => 'FAQPage',
			'@id'        => home_url( '/#faq' ),
			'mainEntity' => $faq_entities,
		);
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'daiei_output_structured_data', 20 );
