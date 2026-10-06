<?php
/**
 * Recruitment benefits.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$benefits = array(
	array( '01', '選べる給与サイクル', '日払い・週払い・月払いから選択可能。給与手渡しと日給保証にも対応しています。' ),
	array( '02', '入社祝い金3万円', '入社60日後に、入社祝い金30,000円を支給します。' ),
	array( '03', '1週間ごとの自由シフト', '週2～3日から、短期・長期ともに可能。家庭や授業、副業に合わせて調整できます。' ),
	array( '04', '資格取得と生活をサポート', '資格取得支援、個室寮、原付貸出制度を用意しています。' ),
	array( '05', '未経験から始められる', '基礎から丁寧に学べる研修と、体調やライフイベントに応じた勤務相談に対応しています。' ),
);
?>
<section class="section benefits" id="benefits" aria-labelledby="benefits-title">
	<div class="container">
		<header class="section-heading section-heading--center reveal">
			<p class="eyebrow">WHY DAIEI</p>
			<h2 id="benefits-title">大永警備で働く魅力</h2>
			<p>働く人を守るという想いを、日々の声かけや休憩の風景から。給与、シフト、研修、生活面でも新しいスタートを支えます。</p>
		</header>
		<div class="benefits__care reveal">
			<div class="benefits__care-copy">
				<p class="eyebrow">PEOPLE FIRST</p>
				<h3>一人ひとりの健康と安心を、現場の真ん中に。</h3>
				<p>暑い日は日陰で水分をとり、仲間と声をかけ合う。働く人を大切にする姿勢を、何気ない現場の一場面からお伝えします。</p>
			</div>
			<div class="benefits__photos">
				<figure><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/benefit-hydration.jpg' ); ?>" alt="日陰で水を飲む警備員と、そばで見守る仲間" loading="lazy" decoding="async" width="1448" height="1086"><figcaption>日陰で水分補給</figcaption></figure>
				<figure><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/benefit-care.jpg' ); ?>" alt="仲間から水を受け取る警備員" loading="lazy" decoding="async" width="645" height="518"><figcaption>水分補給を声かけから</figcaption></figure>
				<figure><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/benefit-teamwork.jpg' ); ?>" alt="現場で笑顔で相談する二人の警備員" loading="lazy" decoding="async" width="1448" height="1086"><figcaption>現場での声かけ</figcaption></figure>
				<figure><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/benefit-break.jpg' ); ?>" alt="木陰で休みながら笑顔で話す二人の警備員" loading="lazy" decoding="async" width="1536" height="1024"><figcaption>休憩中も、仲間とともに</figcaption></figure>
			</div>
		</div>
		<div class="benefits__grid">
			<?php foreach ( $benefits as $benefit ) : ?>
				<article class="benefit-card reveal">
					<span><?php echo esc_html( $benefit[0] ); ?></span>
					<h3><?php echo esc_html( $benefit[1] ); ?></h3>
					<p><?php echo esc_html( $benefit[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
