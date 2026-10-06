<?php
/**
 * Business and recruitment contact forms.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $daiei_form_feedback;
$feedback_type = is_array( $daiei_form_feedback ) ? ( $daiei_form_feedback['type'] ?? '' ) : '';
$query_type    = isset( $_GET['form_type'] ) ? sanitize_key( wp_unslash( $_GET['form_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$active_type   = in_array( $feedback_type ?: $query_type, array( 'business', 'recruitment' ), true ) ? ( $feedback_type ?: $query_type ) : 'business';
$success       = isset( $_GET['contact_status'] ) && 'success' === sanitize_key( wp_unslash( $_GET['contact_status'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$privacy_page  = absint( daiei_get_option( 'daiei_privacy_page', 0 ) );
$privacy_url   = $privacy_page ? get_permalink( $privacy_page ) : get_privacy_policy_url();
if ( ! $privacy_url ) {
	$privacy_url = home_url( '/privacy/' );
}
$has_error = static function ( $field ) use ( $daiei_form_feedback ) {
	return ! empty( $daiei_form_feedback['errors'][ $field ] );
};
?>
<section class="contact" id="contact" aria-labelledby="contact-title">
	<div class="contact__top">
		<div class="container">
			<header class="section-heading section-heading--center reveal">
				<p class="eyebrow eyebrow--accent">CONTACT / ENTRY</p>
				<h2 id="contact-title">お問い合わせ</h2>
				<p>警備のご相談と採用応募、それぞれ専用のフォームをご用意しています。</p>
			</header>
			<div class="contact-direct reveal">
				<p>お電話でのお問い合わせ</p>
				<a href="<?php echo esc_url( daiei_phone_href() ); ?>"><span aria-hidden="true">☎</span><?php echo esc_html( daiei_company( 'phone' ) ); ?></a>
				<small>電話受付時間は公開前にご確認ください。</small>
			</div>
		</div>
	</div>
	<div class="container contact__body">
		<?php if ( $success ) : ?>
			<div class="form-notice form-notice--success" role="status" tabindex="-1" data-form-feedback>
				<strong>送信を受け付けました。</strong>
				<p>ご入力のメールアドレスへ自動返信を送信しました。内容を確認後、担当者からご連絡します。</p>
			</div>
		<?php elseif ( ! empty( $daiei_form_feedback['notice'] ) ) : ?>
			<div class="form-notice form-notice--error" role="alert" tabindex="-1" data-form-feedback>
				<strong>送信内容をご確認ください。</strong>
				<p><?php echo esc_html( $daiei_form_feedback['notice'] ); ?></p>
			</div>
		<?php endif; ?>

		<div class="form-tabs reveal" role="tablist" aria-label="お問い合わせ種別">
			<button type="button" role="tab" id="tab-business" aria-controls="panel-business" aria-selected="<?php echo 'business' === $active_type ? 'true' : 'false'; ?>" tabindex="<?php echo 'business' === $active_type ? '0' : '-1'; ?>" data-form-tab="business">
				<span>法人・事業者の方</span>
				<strong>警備の相談・見積もり</strong>
			</button>
			<button type="button" role="tab" id="tab-recruitment" aria-controls="panel-recruitment" aria-selected="<?php echo 'recruitment' === $active_type ? 'true' : 'false'; ?>" tabindex="<?php echo 'recruitment' === $active_type ? '0' : '-1'; ?>" data-form-tab="recruitment">
				<span>お仕事をお探しの方</span>
				<strong>警備スタッフに応募</strong>
			</button>
		</div>

		<div class="form-panel <?php echo 'business' === $active_type ? 'is-active' : ''; ?>" id="panel-business" role="tabpanel" aria-labelledby="tab-business" data-form-panel="business">
			<div class="form-panel__intro">
				<p class="eyebrow">FOR BUSINESS</p>
				<h3>法人お問い合わせフォーム</h3>
				<p><span class="required-mark">必須</span>の項目は必ずご入力ください。</p>
			</div>
			<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="daiei_contact">
				<input type="hidden" name="form_type" value="business">
				<?php wp_nonce_field( 'daiei_business_form', 'daiei_business_nonce' ); ?>
				<div class="honeypot" aria-hidden="true">
					<label for="business-website">Webサイト</label>
					<input type="text" id="business-website" name="website" value="" tabindex="-1" autocomplete="off">
				</div>

				<div class="form-grid">
					<div class="form-field">
						<label for="business_company">会社名 <span class="required-mark">必須</span></label>
						<input type="text" id="business_company" name="business_company" value="<?php echo esc_attr( daiei_form_value( 'business_company' ) ); ?>" autocomplete="organization" required<?php echo $has_error( 'business_company' ) ? ' aria-invalid="true" aria-describedby="business_company-error"' : ''; ?>>
						<?php daiei_field_error( 'business_company' ); ?>
					</div>
					<div class="form-field">
						<label for="business_name">担当者名 <span class="required-mark">必須</span></label>
						<input type="text" id="business_name" name="business_name" value="<?php echo esc_attr( daiei_form_value( 'business_name' ) ); ?>" autocomplete="name" required<?php echo $has_error( 'business_name' ) ? ' aria-invalid="true" aria-describedby="business_name-error"' : ''; ?>>
						<?php daiei_field_error( 'business_name' ); ?>
					</div>
					<div class="form-field">
						<label for="business_phone">電話番号 <span class="required-mark">必須</span></label>
						<input type="tel" id="business_phone" name="business_phone" value="<?php echo esc_attr( daiei_form_value( 'business_phone' ) ); ?>" autocomplete="tel" inputmode="tel" required<?php echo $has_error( 'business_phone' ) ? ' aria-invalid="true" aria-describedby="business_phone-error"' : ''; ?>>
						<?php daiei_field_error( 'business_phone' ); ?>
					</div>
					<div class="form-field">
						<label for="business_email">メールアドレス <span class="required-mark">必須</span></label>
						<input type="email" id="business_email" name="business_email" value="<?php echo esc_attr( daiei_form_value( 'business_email' ) ); ?>" autocomplete="email" required<?php echo $has_error( 'business_email' ) ? ' aria-invalid="true" aria-describedby="business_email-error"' : ''; ?>>
						<?php daiei_field_error( 'business_email' ); ?>
					</div>
					<div class="form-field">
						<label for="business_service">希望する警備業務 <span class="required-mark">必須</span></label>
						<select id="business_service" name="business_service" required<?php echo $has_error( 'business_service' ) ? ' aria-invalid="true" aria-describedby="business_service-error"' : ''; ?>>
							<option value="">選択してください</option>
							<?php foreach ( array( '交通誘導警備', '駐車場警備', '雑踏警備', '複数の警備業務', '相談して決めたい' ) as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php selected( daiei_form_value( 'business_service' ), $option ); ?>><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php daiei_field_error( 'business_service' ); ?>
					</div>
					<div class="form-field">
						<label for="business_area">希望エリア <span class="required-mark">必須</span></label>
						<select id="business_area" name="business_area" required<?php echo $has_error( 'business_area' ) ? ' aria-invalid="true" aria-describedby="business_area-error"' : ''; ?>>
							<option value="">選択してください</option>
							<?php foreach ( array( '松山市周辺', '今治周辺', '八幡浜周辺', 'その他・相談したい' ) as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php selected( daiei_form_value( 'business_area' ), $option ); ?>><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php daiei_field_error( 'business_area' ); ?>
					</div>
					<div class="form-field">
						<label for="business_date">現場予定日 <span class="optional-mark">任意</span></label>
						<input type="date" id="business_date" name="business_date" value="<?php echo esc_attr( daiei_form_value( 'business_date' ) ); ?>"<?php echo $has_error( 'business_date' ) ? ' aria-invalid="true" aria-describedby="business_date-error"' : ''; ?>>
						<?php daiei_field_error( 'business_date' ); ?>
					</div>
					<div class="form-field form-field--full">
						<label for="business_message">お問い合わせ内容 <span class="required-mark">必須</span></label>
						<textarea id="business_message" name="business_message" rows="7" maxlength="3000" required<?php echo $has_error( 'business_message' ) ? ' aria-invalid="true" aria-describedby="business_message-error"' : ''; ?>><?php echo esc_textarea( daiei_form_value( 'business_message' ) ); ?></textarea>
						<?php daiei_field_error( 'business_message' ); ?>
					</div>
					<div class="form-field form-field--full form-consent">
						<label>
							<input type="checkbox" name="business_privacy" value="1" required <?php checked( daiei_form_value( 'business_privacy' ), '1' ); ?><?php echo $has_error( 'business_privacy' ) ? ' aria-invalid="true" aria-describedby="business_privacy-error"' : ''; ?>>
							<span><a href="<?php echo esc_url( $privacy_url ); ?>" target="_blank" rel="noopener">プライバシーポリシー</a>に同意する <span class="required-mark">必須</span></span>
						</label>
						<?php daiei_field_error( 'business_privacy' ); ?>
					</div>
				</div>
				<button class="button button--primary button--submit" type="submit">入力内容を送信する <span aria-hidden="true">→</span></button>
			</form>
		</div>

		<div class="form-panel <?php echo 'recruitment' === $active_type ? 'is-active' : ''; ?>" id="panel-recruitment" role="tabpanel" aria-labelledby="tab-recruitment" data-form-panel="recruitment">
		<div class="form-panel__intro">
				<p class="eyebrow">RECRUIT ENTRY</p>
				<h3>採用応募フォーム</h3>
				<p><span class="required-mark">必須</span>の項目は必ずご入力ください。18歳以上の方が対象です。</p>
				<div class="recruit-contact-box">
					<span>電話応募／担当 <?php echo esc_html( daiei_recruitment( 'contact' ) ); ?></span>
					<a href="<?php echo esc_url( daiei_recruitment_phone_href() ); ?>"><?php echo esc_html( daiei_recruitment( 'phone' ) ); ?></a>
				</div>
			</div>
			<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="daiei_contact">
				<input type="hidden" name="form_type" value="recruitment">
				<?php wp_nonce_field( 'daiei_recruitment_form', 'daiei_recruitment_nonce' ); ?>
				<div class="honeypot" aria-hidden="true">
					<label for="recruit-website">Webサイト</label>
					<input type="text" id="recruit-website" name="website" value="" tabindex="-1" autocomplete="off">
				</div>
				<div class="form-grid">
					<div class="form-field">
						<label for="recruit_name">氏名 <span class="required-mark">必須</span></label>
						<input type="text" id="recruit_name" name="recruit_name" value="<?php echo esc_attr( daiei_form_value( 'recruit_name' ) ); ?>" autocomplete="name" required<?php echo $has_error( 'recruit_name' ) ? ' aria-invalid="true" aria-describedby="recruit_name-error"' : ''; ?>>
						<?php daiei_field_error( 'recruit_name' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_kana">フリガナ <span class="required-mark">必須</span></label>
						<input type="text" id="recruit_kana" name="recruit_kana" value="<?php echo esc_attr( daiei_form_value( 'recruit_kana' ) ); ?>" required<?php echo $has_error( 'recruit_kana' ) ? ' aria-invalid="true" aria-describedby="recruit_kana-error"' : ''; ?>>
						<?php daiei_field_error( 'recruit_kana' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_age">年齢 <span class="required-mark">必須</span></label>
						<input type="text" id="recruit_age" name="recruit_age" value="<?php echo esc_attr( daiei_form_value( 'recruit_age' ) ); ?>" inputmode="numeric" maxlength="3" required<?php echo $has_error( 'recruit_age' ) ? ' aria-invalid="true" aria-describedby="recruit_age-error"' : ''; ?>>
						<?php daiei_field_error( 'recruit_age' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_phone">電話番号 <span class="required-mark">必須</span></label>
						<input type="tel" id="recruit_phone" name="recruit_phone" value="<?php echo esc_attr( daiei_form_value( 'recruit_phone' ) ); ?>" autocomplete="tel" inputmode="tel" required<?php echo $has_error( 'recruit_phone' ) ? ' aria-invalid="true" aria-describedby="recruit_phone-error"' : ''; ?>>
						<?php daiei_field_error( 'recruit_phone' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_email">メールアドレス <span class="required-mark">必須</span></label>
						<input type="email" id="recruit_email" name="recruit_email" value="<?php echo esc_attr( daiei_form_value( 'recruit_email' ) ); ?>" autocomplete="email" required<?php echo $has_error( 'recruit_email' ) ? ' aria-invalid="true" aria-describedby="recruit_email-error"' : ''; ?>>
						<?php daiei_field_error( 'recruit_email' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_area">希望エリア <span class="required-mark">必須</span></label>
						<select id="recruit_area" name="recruit_area" required<?php echo $has_error( 'recruit_area' ) ? ' aria-invalid="true" aria-describedby="recruit_area-error"' : ''; ?>>
							<option value="">選択してください</option>
							<?php foreach ( array( '松山市周辺', '今治周辺', '八幡浜周辺', '相談して決めたい' ) as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php selected( daiei_form_value( 'recruit_area' ), $option ); ?>><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php daiei_field_error( 'recruit_area' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_job_type">希望職種 <span class="required-mark">必須</span></label>
						<select id="recruit_job_type" name="recruit_job_type" required<?php echo $has_error( 'recruit_job_type' ) ? ' aria-invalid="true" aria-describedby="recruit_job_type-error"' : ''; ?>>
							<option value="">選択してください</option>
							<?php foreach ( array( '警備員', '交通誘導警備', 'イベント警備', '相談して決めたい' ) as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php selected( daiei_form_value( 'recruit_job_type' ), $option ); ?>><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php daiei_field_error( 'recruit_job_type' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_experience">警備経験の有無 <span class="required-mark">必須</span></label>
						<select id="recruit_experience" name="recruit_experience" required<?php echo $has_error( 'recruit_experience' ) ? ' aria-invalid="true" aria-describedby="recruit_experience-error"' : ''; ?>>
							<option value="">選択してください</option>
							<?php foreach ( array( '未経験', '経験あり', '回答を控える' ) as $option ) : ?>
								<option value="<?php echo esc_attr( $option ); ?>" <?php selected( daiei_form_value( 'recruit_experience' ), $option ); ?>><?php echo esc_html( $option ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php daiei_field_error( 'recruit_experience' ); ?>
					</div>
					<div class="form-field">
						<label for="recruit_license">保有資格 <span class="optional-mark">任意</span></label>
						<input type="text" id="recruit_license" name="recruit_license" value="<?php echo esc_attr( daiei_form_value( 'recruit_license' ) ); ?>" placeholder="例：交通誘導警備業務検定">
					</div>
					<div class="form-field form-field--full">
						<label for="recruit_workstyle">希望する働き方 <span class="optional-mark">任意</span></label>
						<input type="text" id="recruit_workstyle" name="recruit_workstyle" value="<?php echo esc_attr( daiei_form_value( 'recruit_workstyle' ) ); ?>" placeholder="勤務日数やエリアなど、ご希望があればご入力ください">
					</div>
					<div class="form-field form-field--full">
						<label for="recruit_message">質問・連絡事項 <span class="optional-mark">任意</span></label>
						<textarea id="recruit_message" name="recruit_message" rows="6" maxlength="3000"><?php echo esc_textarea( daiei_form_value( 'recruit_message' ) ); ?></textarea>
					</div>
					<div class="form-field form-field--full form-consent">
						<label>
							<input type="checkbox" name="recruitment_privacy" value="1" required <?php checked( daiei_form_value( 'recruitment_privacy' ), '1' ); ?><?php echo $has_error( 'recruitment_privacy' ) ? ' aria-invalid="true" aria-describedby="recruitment_privacy-error"' : ''; ?>>
							<span><a href="<?php echo esc_url( $privacy_url ); ?>" target="_blank" rel="noopener">プライバシーポリシー</a>に同意する <span class="required-mark">必須</span></span>
						</label>
						<?php daiei_field_error( 'recruitment_privacy' ); ?>
					</div>
				</div>
				<button class="button button--recruit button--submit" type="submit">採用応募を送信する <span aria-hidden="true">→</span></button>
			</form>
		</div>
	</div>
</section>
