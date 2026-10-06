<?php
/**
 * Company profile.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_rows = array(
	'会社名'       => daiei_company( 'company_name' ),
	'所在地'       => daiei_company( 'address' ),
	'電話番号'     => daiei_company( 'phone' ),
	'代表者'       => daiei_company( 'representative' ),
	'設立'         => daiei_company( 'established' ),
	'警備業認定番号' => daiei_company( 'license' ),
	'従業員数'     => daiei_company( 'employees' ) . '名',
	'対応業務'     => '交通誘導警備、駐車場警備、雑踏警備',
	'対応エリア'   => daiei_company( 'areas' ),
);
?>
<section class="section company" id="company" aria-labelledby="company-title">
	<div class="container company__grid">
		<header class="section-heading reveal">
			<p class="eyebrow">COMPANY</p>
			<h2 id="company-title">会社概要</h2>
			<p>地域と現場に誠実に向き合い、安全で円滑な環境づくりに努めます。</p>
			<div class="company__message" aria-hidden="true">TRUST.<br>SAFETY.<br>LOCAL.</div>
		</header>
		<dl class="company-table reveal">
			<?php foreach ( $company_rows as $label => $value ) : ?>
				<div>
					<dt><?php echo esc_html( $label ); ?></dt>
					<dd>
						<?php if ( '電話番号' === $label ) : ?>
							<a href="<?php echo esc_url( daiei_phone_href() ); ?>"><?php echo esc_html( $value ); ?></a>
						<?php else : ?>
							<?php echo esc_html( $value ); ?>
						<?php endif; ?>
					</dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
