<?php
/**
 * Security services.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = array(
	array(
		'number'      => '01',
		'title'       => '交通誘導警備',
		'en'          => 'TRAFFIC CONTROL',
		'description' => '工事現場や道路周辺で、車両と歩行者の安全な通行を支援します。',
		'icon'        => 'icon-traffic.svg',
		'tags'        => array( '道路工事', '建設現場', '歩行者誘導' ),
	),
	array(
		'number'      => '02',
		'title'       => '駐車場警備',
		'en'          => 'PARKING SECURITY',
		'description' => '商業施設、催事、各種施設の駐車場で、車両誘導と安全確保を行います。',
		'icon'        => 'icon-parking.svg',
		'tags'        => array( '商業施設', '催事', '車両誘導' ),
	),
	array(
		'number'      => '03',
		'title'       => '雑踏警備',
		'en'          => 'CROWD SECURITY',
		'description' => 'イベントや人が集まる場所で、混雑緩和と事故防止を支援します。',
		'icon'        => 'icon-event.svg',
		'tags'        => array( 'イベント', '会場警備', '混雑緩和' ),
	),
);
?>
<section class="section services" id="services" aria-labelledby="services-title">
	<div class="container">
		<header class="section-heading section-heading--split reveal">
			<div>
				<p class="eyebrow">OUR SERVICES</p>
				<h2 id="services-title">現場の安全を支える<br>3つの警備サービス</h2>
			</div>
			<p>工事・施設・イベントなど、警備が必要な現場についてご相談を受け付けています。</p>
		</header>
		<div class="service-grid">
			<?php foreach ( $services as $service ) : ?>
				<article class="service-card reveal">
					<div class="service-card__top">
						<span class="service-card__number"><?php echo esc_html( $service['number'] ); ?></span>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $service['icon'] ); ?>" width="88" height="88" alt="" loading="lazy">
					</div>
					<p class="service-card__en"><?php echo esc_html( $service['en'] ); ?></p>
					<h3><?php echo esc_html( $service['title'] ); ?></h3>
					<p><?php echo esc_html( $service['description'] ); ?></p>
					<ul class="tag-list" aria-label="<?php echo esc_attr( $service['title'] . 'の例' ); ?>">
						<?php foreach ( $service['tags'] as $tag ) : ?>
							<li><?php echo esc_html( $tag ); ?></li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
