<?php
/**
 * Recruitment entry flow.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$steps = array(
	array( '電話・WEB応募', '採用専用電話または応募フォームからご連絡ください。' ),
	array( 'メール・SMSを受信', '応募後、面接日入力フォームのご案内をお送りします。' ),
	array( '面接日を確定', 'フォームまたは自動返信チャットに希望日を入力します。' ),
	array( '面接', '松山市の本社で実施します。今治市での面接もご相談できます。' ),
	array( '研修・勤務開始', '採用後は研修からスタート。勤務開始日は即日も対応可能です。' ),
);
?>
<section class="entry-flow" id="entry" aria-labelledby="entry-flow-title">
	<span class="anchor-target" id="entry-flow" aria-hidden="true"></span>
	<div class="container">
		<header class="section-heading section-heading--center reveal">
			<p class="eyebrow eyebrow--light">ENTRY FLOW</p>
			<h2 id="entry-flow-title">ご応募から勤務開始まで</h2>
		</header>
		<ol class="entry-flow__steps">
			<?php foreach ( $steps as $index => $step ) : ?>
				<li class="reveal">
					<span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div>
						<h3><?php echo esc_html( $step[0] ); ?></h3>
						<p><?php echo esc_html( $step[1] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
