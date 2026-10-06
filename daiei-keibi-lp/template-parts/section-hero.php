<?php
/**
 * Hero section.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image_id = absint( daiei_get_option( 'daiei_hero_image', 0 ) );
$hero_image    = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'full' ) : '';
$hero_style    = $hero_image ? '--hero-image:url(' . esc_url( $hero_image ) . ');' : '';
$hero_headline = (string) daiei_get_option( 'daiei_hero_headline', '地域の安心を、確かな警備で支える。' );
$headline_parts = explode( '、', $hero_headline, 2 );
?>
<section class="hero" id="hero" aria-labelledby="hero-title" style="<?php echo esc_attr( $hero_style ); ?>">
	<div class="hero__pattern" aria-hidden="true"></div>
	<div class="hero__rails" aria-hidden="true"><span></span><span></span><span></span></div>
	<div class="container hero__inner">
		<div class="hero__content">
			<h1 class="hero__title reveal" id="hero-title" data-reveal="text">
				<?php if ( 2 === count( $headline_parts ) ) : ?>
					<span><?php echo esc_html( $headline_parts[0] . '、' ); ?></span>
					<span><?php echo esc_html( $headline_parts[1] ); ?></span>
				<?php else : ?>
					<?php echo esc_html( $hero_headline ); ?>
				<?php endif; ?>
			</h1>
			<p class="hero__lead reveal"><?php echo esc_html( daiei_get_option( 'daiei_hero_subheadline', '松山市・今治・八幡浜を中心に、交通誘導警備、駐車場警備、雑踏警備に対応します。' ) ); ?></p>
			<ul class="hero__services reveal" aria-label="対応する警備業務">
				<li>交通誘導</li>
				<li>駐車場警備</li>
				<li>雑踏警備</li>
			</ul>
			<div class="hero__actions reveal">
				<a class="button button--recruit button--large" href="#entry">
					<span class="button__eyebrow">RECRUIT</span>
					<?php echo esc_html( daiei_get_option( 'daiei_recruit_cta', '警備スタッフに応募する' ) ); ?>
					<span aria-hidden="true">→</span>
				</a>
				<a class="button button--light button--large" href="#contact">
					<span class="button__eyebrow">FOR BUSINESS</span>
					<?php echo esc_html( daiei_get_option( 'daiei_business_cta', '警備の相談・見積もり' ) ); ?>
					<span aria-hidden="true">→</span>
				</a>
			</div>
			<a class="hero__phone reveal" href="<?php echo esc_url( daiei_phone_href() ); ?>">
				<span aria-hidden="true">☎</span>
				<span><small>お電話でのお問い合わせ</small><strong><?php echo esc_html( daiei_company( 'phone' ) ); ?></strong></span>
			</a>
		</div>

		<div class="hero__trust reveal" aria-label="会社情報">
			<div class="hero__trust-item">
				<small>TEAM</small>
				<strong><span><?php echo esc_html( daiei_company( 'employees' ) ); ?></span><em>名</em></strong>
				<p>従業員数</p>
			</div>
			<div class="hero__trust-item">
				<small>AREA</small>
				<strong><span>3</span><em>地域</em></strong>
				<p>愛媛県内に対応</p>
			</div>
			<div class="hero__trust-item hero__trust-item--license">
				<small>LICENSE</small>
				<strong><?php echo esc_html( daiei_company( 'license' ) ); ?></strong>
				<p>警備業認定</p>
			</div>
		</div>
	</div>
	<a class="scroll-cue" href="#stats">
		<span>SCROLL</span>
		<i aria-hidden="true"></i>
	</a>
</section>
