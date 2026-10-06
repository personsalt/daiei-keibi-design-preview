<?php
/**
 * Service area section.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$areas = array(
	array( '中予', '松山市', '本社所在地・周辺エリア' ),
	array( '東予', '今治周辺', '現場条件に応じてご相談' ),
	array( '南予', '八幡浜周辺', '現場条件に応じてご相談' ),
);
?>
<section class="section area" id="area" aria-labelledby="area-title">
	<div class="container area__grid">
		<header class="section-heading reveal">
			<p class="eyebrow">SERVICE AREA</p>
			<h2 id="area-title">愛媛県内<br>3エリアに対応</h2>
			<p>松山市を拠点に、今治・八幡浜周辺の警備についてご相談いただけます。</p>
			<p class="section-note">※現場条件や時期により対応可否が異なります。まずはお問い合わせください。</p>
		</header>
		<div class="area__list">
			<?php foreach ( $areas as $index => $area ) : ?>
				<article class="area-card reveal">
					<span class="area-card__number">0<?php echo esc_html( $index + 1 ); ?></span>
					<div>
						<p><?php echo esc_html( $area[0] ); ?></p>
						<h3><?php echo esc_html( $area[1] ); ?></h3>
						<small><?php echo esc_html( $area[2] ); ?></small>
					</div>
					<span class="area-card__pin" aria-hidden="true"></span>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
