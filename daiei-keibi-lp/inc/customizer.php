<?php
/**
 * Theme Customizer controls.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $checked Submitted value.
 * @return bool
 */
function daiei_sanitize_checkbox( $checked ) {
	return isset( $checked ) && true === (bool) $checked;
}

/**
 * Sanitize a positive integer.
 *
 * @param mixed $value Submitted value.
 * @return int
 */
function daiei_sanitize_positive_integer( $value ) {
	return max( 0, absint( $value ) );
}

/**
 * Register editable site content.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function daiei_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'daiei_theme_options',
		array(
			'title'       => __( '大永警備 LP 設定', 'daiei-keibi-lp' ),
			'description' => __( '会社情報、ファーストビュー、CTA、フォーム、色、セクション表示を管理します。', 'daiei-keibi-lp' ),
			'priority'    => 30,
		)
	);

	$wp_customize->add_section(
		'daiei_company_section',
		array(
			'title' => __( '会社情報', 'daiei-keibi-lp' ),
			'panel' => 'daiei_theme_options',
		)
	);

	$company_fields = array(
		'company_name'   => array( '正式社名', '株式会社大永警備', 'sanitize_text_field' ),
		'address'        => array( '住所', '愛媛県松山市清水町三丁目43番地12', 'sanitize_text_field' ),
		'phone'          => array( '電話番号', '(089)908-8882', 'sanitize_text_field' ),
		'representative' => array( '代表者名', '岡本永吉', 'sanitize_text_field' ),
		'established'    => array( '設立年月', '令和7年4月1日', 'sanitize_text_field' ),
		'license'        => array( '警備業認定番号', '第 82000378 号', 'sanitize_text_field' ),
		'employees'      => array( '従業員数', 57, 'daiei_sanitize_positive_integer' ),
		'areas'          => array( '対応エリア', '松山市、今治周辺、八幡浜周辺', 'sanitize_text_field' ),
	);

	foreach ( $company_fields as $key => $field ) {
		$wp_customize->add_setting(
			'daiei_' . $key,
			array(
				'default'           => $field[1],
				'sanitize_callback' => $field[2],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'daiei_' . $key,
			array(
				'label'   => $field[0],
				'section' => 'daiei_company_section',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_section(
		'daiei_hero_section',
		array(
			'title' => __( 'ファーストビュー・CTA', 'daiei-keibi-lp' ),
			'panel' => 'daiei_theme_options',
		)
	);

	$text_fields = array(
		'daiei_hero_headline' => array(
			'メインコピー',
			'地域の安心を、確かな警備で支える。',
			'sanitize_text_field',
		),
		'daiei_hero_subheadline' => array(
			'サブコピー',
			'松山市・今治・八幡浜を中心に、交通誘導警備、駐車場警備、雑踏警備に対応します。',
			'sanitize_textarea_field',
		),
		'daiei_recruit_cta' => array(
			'採用CTA文言',
			'警備スタッフに応募する',
			'sanitize_text_field',
		),
		'daiei_business_cta' => array(
			'法人CTA文言',
			'警備の相談・見積もり',
			'sanitize_text_field',
		),
	);

	foreach ( $text_fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field[1],
				'sanitize_callback' => $field[2],
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field[0],
				'section' => 'daiei_hero_section',
				'type'    => 'daiei_hero_subheadline' === $id ? 'textarea' : 'text',
			)
		);
	}

	$wp_customize->add_section(
		'daiei_recruitment_section',
		array(
			'title' => __( '採用連絡先', 'daiei-keibi-lp' ),
			'panel' => 'daiei_theme_options',
		)
	);

	$recruitment_fields = array(
		'phone'             => array( '採用専用電話番号', '090-1573-0761' ),
		'contact'           => array( '採用担当者', '岡本' ),
		'employment'        => array( '雇用形態', 'アルバイト・パート' ),
		'interview_address' => array( '面接場所', '〒790-0823 愛媛県松山市清水町3丁目43-12' ),
	);

	foreach ( $recruitment_fields as $key => $field ) {
		$wp_customize->add_setting(
			'daiei_recruit_' . $key,
			array(
				'default'           => $field[1],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'daiei_recruit_' . $key,
			array(
				'label'   => $field[0],
				'section' => 'daiei_recruitment_section',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'daiei_hero_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'daiei_hero_image',
			array(
				'label'       => __( 'ファーストビュー画像', 'daiei-keibi-lp' ),
				'description' => __( '未設定時はローカルの幾何学パターンを表示します。', 'daiei-keibi-lp' ),
				'section'     => 'daiei_hero_section',
				'mime_type'   => 'image',
			)
		)
	);

	$wp_customize->add_section(
		'daiei_contact_section',
		array(
			'title' => __( 'フォーム・外部リンク', 'daiei-keibi-lp' ),
			'panel' => 'daiei_theme_options',
		)
	);

	$wp_customize->add_setting(
		'daiei_recipient_email',
		array(
			'default'           => 'daiei-4.1@dreamcom.ne.jp',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'daiei_recipient_email',
		array(
			'label'       => __( '問い合わせ受信用メールアドレス', 'daiei-keibi-lp' ),
			'description' => __( '法人お問い合わせ・採用応募の共通受信先です。空欄または無効な場合は daiei-4.1@dreamcom.ne.jp へ送信します。', 'daiei-keibi-lp' ),
			'section'     => 'daiei_contact_section',
			'type'        => 'email',
		)
	);

	$wp_customize->add_setting(
		'daiei_privacy_page',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'daiei_privacy_page',
		array(
			'label'   => __( 'プライバシーポリシーページ', 'daiei-keibi-lp' ),
			'section' => 'daiei_contact_section',
			'type'    => 'dropdown-pages',
		)
	);

	foreach ( array( 'facebook' => 'Facebook URL', 'instagram' => 'Instagram URL', 'x' => 'X URL' ) as $network => $label ) {
		$wp_customize->add_setting(
			'daiei_' . $network . '_url',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'daiei_' . $network . '_url',
			array(
				'label'   => $label,
				'section' => 'daiei_contact_section',
				'type'    => 'url',
			)
		);
	}

	$wp_customize->add_section(
		'daiei_design_section',
		array(
			'title' => __( 'ブランドカラー', 'daiei-keibi-lp' ),
			'panel' => 'daiei_theme_options',
		)
	);

	foreach ( array( 'main' => array( 'メインカラー', '#0B1F33' ), 'accent' => array( 'アクセントカラー', '#F4C430' ) ) as $color => $field ) {
		$wp_customize->add_setting(
			'daiei_' . $color . '_color',
			array(
				'default'           => $field[1],
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'daiei_' . $color . '_color',
				array(
					'label'   => $field[0],
					'section' => 'daiei_design_section',
				)
			)
		);
	}

	$wp_customize->add_section(
		'daiei_visibility_section',
		array(
			'title'       => __( 'セクション表示', 'daiei-keibi-lp' ),
			'description' => __( 'フロントページの各セクションを表示または非表示にします。', 'daiei-keibi-lp' ),
			'panel'       => 'daiei_theme_options',
		)
	);

	$sections = array(
		'stats'      => '信頼を示す数値',
		'about'      => '大永警備について',
		'philosophy' => '企業理念',
		'services'   => '警備サービス',
		'business'   => '法人向け訴求',
		'area'       => '対応エリア',
		'recruit'    => '採用メッセージ',
		'team'      => '現場・制服の写真',
		'benefits'   => '働く魅力',
		'dorm'      => '寮紹介',
		'day_flow'   => '仕事の流れ',
		'jobs'       => '募集要項',
		'entry_flow' => '応募の流れ',
		'faq'        => 'よくある質問',
		'company'    => '会社概要',
		'contact'    => 'お問い合わせ',
	);

	foreach ( $sections as $key => $label ) {
		$wp_customize->add_setting(
			'daiei_show_' . $key,
			array(
				'default'           => true,
				'sanitize_callback' => 'daiei_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'daiei_show_' . $key,
			array(
				'label'   => $label,
				'section' => 'daiei_visibility_section',
				'type'    => 'checkbox',
			)
		);
	}
}
add_action( 'customize_register', 'daiei_customize_register' );
