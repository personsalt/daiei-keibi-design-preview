<?php
/**
 * Typical work flow.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$steps = array(
	array( '現場集合・準備', '必要な装備を確認し、業務に備えます。' ),
	array( '配置と業務内容の確認', '当日の役割や注意事項を確認します。' ),
	array( '警備業務開始', '車両や歩行者の安全な通行を支えます。' ),
	array( '休憩', '現場の進行に合わせて休憩を取ります。' ),
	array( '午後の警備業務', '周囲の状況を確認しながら業務を続けます。' ),
	array( '業務終了・報告', '現場での業務を終え、必要な報告を行います。' ),
);
?>
<section class="section day-flow" id="day-flow" aria-labelledby="day-flow-title">
	<div class="container">
		<header class="section-heading section-heading--split reveal">
			<div>
				<p class="eyebrow">A DAY AT WORK</p>
				<h2 id="day-flow-title">警備の仕事の流れ</h2>
			</div>
			<p>交通誘導警備を想定した基本的な一例です。実際の流れや休憩の取り方は現場により異なります。</p>
		</header>
		<ol class="timeline">
			<?php foreach ( $steps as $index => $step ) : ?>
				<li class="timeline__item reveal">
					<div class="timeline__marker"><span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span></div>
					<div>
						<h3><?php echo esc_html( $step[0] ); ?></h3>
						<p><?php echo esc_html( $step[1] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
		<p class="section-note section-note--center reveal">※上記は一例です。業務内容・時間帯・進行は現場により異なります。</p>
	</div>
</section>
