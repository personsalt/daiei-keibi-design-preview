<?php
/**
 * Accessible FAQ accordion.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = daiei_get_faqs();
?>
<section class="section faq" id="faq" aria-labelledby="faq-title">
	<div class="container faq__grid">
		<header class="section-heading reveal">
			<p class="eyebrow">FAQ</p>
			<h2 id="faq-title">よくある質問</h2>
			<p>採用応募と警備のご相談について、よくいただく質問をまとめました。</p>
			<a class="text-link" href="#contact">解決しない場合はお問い合わせください <span aria-hidden="true">→</span></a>
		</header>
		<div class="accordion reveal">
			<?php foreach ( $faqs as $index => $faq ) : ?>
				<div class="accordion__item">
					<h3>
						<button type="button" class="accordion__trigger" aria-expanded="true" aria-controls="faq-panel-<?php echo esc_attr( $index ); ?>" id="faq-button-<?php echo esc_attr( $index ); ?>">
							<span class="accordion__q">Q</span>
							<span><?php echo esc_html( $faq['question'] ); ?></span>
							<i aria-hidden="true"></i>
						</button>
					</h3>
					<div class="accordion__panel" id="faq-panel-<?php echo esc_attr( $index ); ?>" role="region" aria-labelledby="faq-button-<?php echo esc_attr( $index ); ?>">
						<span class="accordion__a">A</span>
						<div><?php echo wp_kses_post( wpautop( $faq['answer'] ) ); ?></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
