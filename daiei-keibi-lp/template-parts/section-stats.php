<?php
/**
 * Company statistics.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="stats" id="stats" aria-label="数字で見る大永警備">
	<div class="container stats__grid">
		<div class="stats__intro reveal">
			<p class="eyebrow eyebrow--light">DAIEI IN NUMBERS</p>
			<h2>地域に根ざした<br>警備体制</h2>
		</div>
		<div class="stat-card reveal">
			<span class="stat-card__index">01</span>
			<p class="stat-card__value"><strong data-counter="<?php echo esc_attr( daiei_company( 'employees' ) ); ?>"><?php echo esc_html( daiei_company( 'employees' ) ); ?></strong><em>名</em></p>
			<p>従業員数</p>
		</div>
		<div class="stat-card reveal">
			<span class="stat-card__index">02</span>
			<p class="stat-card__value"><strong data-counter="3">3</strong><em>地域</em></p>
			<p>松山・今治・八幡浜周辺</p>
		</div>
		<div class="stat-card stat-card--text reveal">
			<span class="stat-card__index">03</span>
			<p class="stat-card__value"><strong><?php echo esc_html( daiei_company( 'license' ) ); ?></strong></p>
			<p>警備業認定番号</p>
		</div>
		<div class="stat-card stat-card--text reveal">
			<span class="stat-card__index">04</span>
			<p class="stat-card__value"><strong><?php echo esc_html( daiei_company( 'established' ) ); ?></strong></p>
			<p>設立</p>
		</div>
	</div>
</section>
