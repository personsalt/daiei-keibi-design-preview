<?php
/**
 * Business customer conversion section.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="business" id="business" aria-labelledby="business-title">
	<div class="business__stripe" aria-hidden="true"></div>
	<div class="container business__grid">
		<div class="business__content">
			<p class="eyebrow eyebrow--accent reveal">FOR BUSINESS</p>
			<h2 class="reveal" id="business-title">現場の安全と<br>円滑な進行を支えます</h2>
			<p class="business__lead reveal">工事、施設、イベントの警備について、現場や規模に応じたご相談を承ります。</p>
			<ul class="business__points reveal">
				<li><span>01</span>交通誘導・駐車場・雑踏警備のご相談</li>
				<li><span>02</span>松山市・今治・八幡浜周辺に対応</li>
				<li><span>03</span>電話または専用フォームでお問い合わせ</li>
			</ul>
		</div>
		<aside class="business__cta reveal" aria-label="法人お問い合わせ">
			<p>警備のご依頼を検討中の方へ</p>
			<h3>まずは現場について<br>お聞かせください。</h3>
			<a class="button button--accent button--wide" href="#contact">
				<?php echo esc_html( daiei_get_option( 'daiei_business_cta', '警備の相談・見積もり' ) ); ?>
				<span aria-hidden="true">→</span>
			</a>
			<a class="business__phone" href="<?php echo esc_url( daiei_phone_href() ); ?>">
				<small>お電話でのご相談</small>
				<strong><?php echo esc_html( daiei_company( 'phone' ) ); ?></strong>
			</a>
			<p class="business__note">現場条件や対応可否は内容を確認のうえご案内します。</p>
		</aside>
	</div>
</section>
