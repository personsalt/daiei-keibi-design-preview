<?php
/**
 * Secure, database-free contact form processing.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the front page with in-memory validation feedback.
 *
 * No submitted personal information is stored in WordPress.
 *
 * @param string               $type   Form type.
 * @param array<string,string> $values Sanitized values.
 * @param array<string,string> $errors Field errors.
 * @param string               $notice General notice.
 * @return void
 */
function daiei_render_form_error( $type, $values, $errors, $notice ) {
	global $daiei_form_feedback;
	$daiei_form_feedback = array(
		'type'   => $type,
		'values' => $values,
		'errors' => $errors,
		'notice' => $notice,
	);
	status_header( 422 );
	nocache_headers();
	require get_template_directory() . '/front-page.php';
	exit;
}

/**
 * Validate a telephone number conservatively.
 *
 * @param string $phone Phone number.
 * @return bool
 */
function daiei_valid_phone( $phone ) {
	return (bool) preg_match( '/\A[0-9０-９+\-\(\)（） 　]{8,24}\z/u', $phone );
}

/**
 * Obtain a non-reversible visitor identifier for rate limiting.
 *
 * @return string
 */
function daiei_rate_limit_key() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return 'daiei_form_' . hash_hmac( 'sha256', $ip, wp_salt( 'nonce' ) );
}

/**
 * Process either contact form.
 *
 * @return void
 */
function daiei_handle_contact_form() {
	$type = isset( $_POST['form_type'] ) ? sanitize_key( wp_unslash( $_POST['form_type'] ) ) : '';
	if ( ! in_array( $type, array( 'business', 'recruitment' ), true ) ) {
		$type = 'business';
	}

	$nonce_action = 'daiei_' . $type . '_form';
	$nonce_name   = 'business' === $type ? 'daiei_business_nonce' : 'daiei_recruitment_nonce';
	$nonce        = isset( $_POST[ $nonce_name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nonce_name ] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, $nonce_action ) ) {
		daiei_render_form_error(
			$type,
			array(),
			array(),
			'セキュリティ確認に失敗しました。ページを再読み込みして、もう一度お試しください。'
		);
	}

	// A filled hidden field indicates an automated submission. Return success without sending.
	$honeypot = isset( $_POST['website'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['website'] ) ) ) : '';
	if ( '' !== $honeypot ) {
		wp_safe_redirect( home_url( '/?contact_status=success&form_type=' . $type . '#contact' ) );
		exit;
	}

	$rate_key = daiei_rate_limit_key();
	if ( get_transient( $rate_key ) ) {
		daiei_render_form_error(
			$type,
			array(),
			array(),
			'短時間に複数回の送信が行われました。しばらく待ってから、もう一度お試しください。'
		);
	}

	$values = array();
	$errors = array();

	if ( 'business' === $type ) {
		$fields = array(
			'business_company' => array( '会社名', true, 'text' ),
			'business_name'    => array( '担当者名', true, 'text' ),
			'business_phone'   => array( '電話番号', true, 'phone' ),
			'business_email'   => array( 'メールアドレス', true, 'email' ),
			'business_service' => array( '希望する警備業務', true, 'text' ),
			'business_area'    => array( '希望エリア', true, 'text' ),
			'business_date'    => array( '現場予定日', false, 'date' ),
			'business_message' => array( 'お問い合わせ内容', true, 'textarea' ),
		);
	} else {
		$fields = array(
			'recruit_name'       => array( '氏名', true, 'text' ),
			'recruit_kana'       => array( 'フリガナ', true, 'text' ),
			'recruit_age'        => array( '年齢', true, 'age' ),
			'recruit_phone'      => array( '電話番号', true, 'phone' ),
			'recruit_email'      => array( 'メールアドレス', true, 'email' ),
			'recruit_area'       => array( '希望エリア', true, 'text' ),
			'recruit_job_type'   => array( '希望職種', true, 'text' ),
			'recruit_experience' => array( '警備経験の有無', true, 'text' ),
			'recruit_license'    => array( '保有資格', false, 'text' ),
			'recruit_workstyle'  => array( '希望する働き方', false, 'text' ),
			'recruit_message'    => array( '質問・連絡事項', false, 'textarea' ),
		);
	}

	foreach ( $fields as $key => $config ) {
		$raw            = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$values[ $key ] = 'textarea' === $config[2] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );

		if ( $config[1] && '' === trim( $values[ $key ] ) ) {
			$errors[ $key ] = $config[0] . 'を入力してください。';
			continue;
		}
		if ( 'email' === $config[2] && ! is_email( $values[ $key ] ) ) {
			$errors[ $key ] = '有効なメールアドレスを入力してください。';
		}
		if ( 'phone' === $config[2] && ! daiei_valid_phone( $values[ $key ] ) ) {
			$errors[ $key ] = '有効な電話番号を入力してください。';
		}
		if ( 'age' === $config[2] ) {
			if ( ! preg_match( '/\A[0-9０-９]{1,3}\z/u', $values[ $key ] ) ) {
				$errors[ $key ] = '年齢は数字で入力してください。';
			} else {
				$normalized_age = function_exists( 'mb_convert_kana' )
					? mb_convert_kana( $values[ $key ], 'n', 'UTF-8' )
					: strtr( $values[ $key ], array( '０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9' ) );
				if ( (int) $normalized_age < 18 ) {
					$errors[ $key ] = '警備業法第14条により、応募は18歳以上の方が対象です。';
				}
			}
		}
		if ( 'date' === $config[2] && '' !== $values[ $key ] ) {
			$date = DateTime::createFromFormat( 'Y-m-d', $values[ $key ] );
			if ( ! $date || $date->format( 'Y-m-d' ) !== $values[ $key ] ) {
				$errors[ $key ] = '有効な日付を入力してください。';
			}
		}
		$value_length = function_exists( 'mb_strlen' ) ? mb_strlen( $values[ $key ] ) : strlen( $values[ $key ] );
		if ( $value_length > ( 'textarea' === $config[2] ? 3000 : 200 ) ) {
			$errors[ $key ] = $config[0] . 'が長すぎます。';
		}
	}

	$privacy_key              = $type . '_privacy';
	$values[ $privacy_key ]   = isset( $_POST[ $privacy_key ] ) ? '1' : '';
	if ( '1' !== $values[ $privacy_key ] ) {
		$errors[ $privacy_key ] = 'プライバシーポリシーへの同意が必要です。';
	}

	if ( $errors ) {
		daiei_render_form_error( $type, $values, $errors, '入力内容をご確認ください。' );
	}

	$recipient = sanitize_email( daiei_get_option( 'daiei_recipient_email', 'daiei-4.1@dreamcom.ne.jp' ) );
	if ( ! is_email( $recipient ) ) {
		$recipient = 'daiei-4.1@dreamcom.ne.jp';
	}

	$email_key  = 'business' === $type ? 'business_email' : 'recruit_email';
	$name_key   = 'business' === $type ? 'business_name' : 'recruit_name';
	$reply_to   = sanitize_email( $values[ $email_key ] );
	$form_label = 'business' === $type ? '法人お問い合わせ' : '採用応募';
	$subject    = '【大永警備Webサイト】' . $form_label;
	$lines      = array(
		'Webサイトから' . $form_label . 'を受け付けました。',
		'',
	);

	foreach ( $fields as $key => $config ) {
		$lines[] = $config[0] . '：' . ( '' !== $values[ $key ] ? $values[ $key ] : '未入力' );
	}
	$lines[] = 'プライバシーポリシー同意：同意済み';

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( is_email( $reply_to ) && ! preg_match( '/[\r\n]/', $reply_to ) ) {
		$headers[] = 'Reply-To: ' . $reply_to;
	}

	$sent = wp_mail( $recipient, $subject, implode( "\n", $lines ), $headers );
	if ( ! $sent ) {
		daiei_render_form_error(
			$type,
			$values,
			array(),
			'送信処理を完了できませんでした。恐れ入りますが、時間をおいて再度お試しいただくか、お電話でご連絡ください。'
		);
	}

	$auto_subject = '【株式会社大永警備】お問い合わせを受け付けました';
	$auto_body    = $values[ $name_key ] . " 様\n\n";
	$auto_body   .= "お問い合わせありがとうございます。以下の内容で受け付けました。\n";
	$auto_body   .= "内容を確認後、担当者からご連絡します。\n\n";
	$auto_body   .= implode( "\n", $lines ) . "\n\n";
	$auto_body   .= "※このメールは自動送信です。\n";
	$auto_body   .= daiei_company( 'company_name' ) . "\n";
	$auto_body   .= ( 'business' === $type ? daiei_company( 'phone' ) : daiei_recruitment( 'phone' ) );
	wp_mail( $reply_to, $auto_subject, $auto_body, array( 'Content-Type: text/plain; charset=UTF-8' ) );

	// Store only a one-way visitor key; submitted content is never persisted.
	set_transient( $rate_key, 1, MINUTE_IN_SECONDS );
	wp_safe_redirect( home_url( '/?contact_status=success&form_type=' . $type . '#contact' ) );
	exit;
}
add_action( 'admin_post_nopriv_daiei_contact', 'daiei_handle_contact_form' );
add_action( 'admin_post_daiei_contact', 'daiei_handle_contact_form' );
