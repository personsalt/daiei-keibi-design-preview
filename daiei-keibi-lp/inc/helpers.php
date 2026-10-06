<?php
/**
 * Shared helpers and default content.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a theme option with an explicit default.
 *
 * @param string $key     Theme mod name.
 * @param mixed  $default Default value.
 * @return mixed
 */
function daiei_get_option( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Return immutable company defaults.
 *
 * @return array<string, mixed>
 */
function daiei_company_defaults() {
	return array(
		'company_name' => '株式会社大永警備',
		'address'      => '愛媛県松山市清水町三丁目43番地12',
		'phone'        => '(089)908-8882',
		'representative' => '岡本永吉',
		'established'  => '令和7年4月1日',
		'license'      => '第 82000378 号',
		'employees'    => 57,
		'areas'        => '松山市、今治周辺、八幡浜周辺',
	);
}

/**
 * Return confirmed recruitment contact defaults.
 *
 * @return array<string, string>
 */
function daiei_recruitment_defaults() {
	return array(
		'phone'             => '090-1573-0761',
		'contact'           => '岡本',
		'employment'        => 'アルバイト・パート',
		'interview_address' => '〒790-0823 愛媛県松山市清水町3丁目43-12',
	);
}

/**
 * Get a company value, allowing intentional Customizer overrides.
 *
 * @param string $key Default key.
 * @return mixed
 */
function daiei_company( $key ) {
	$defaults = daiei_company_defaults();
	return daiei_get_option( 'daiei_' . $key, $defaults[ $key ] ?? '' );
}

/**
 * Get a recruitment value, allowing Customizer overrides.
 *
 * @param string $key Recruitment default key.
 * @return string
 */
function daiei_recruitment( $key ) {
	$defaults = daiei_recruitment_defaults();
	return (string) daiei_get_option( 'daiei_recruit_' . $key, $defaults[ $key ] ?? '' );
}

/**
 * Convert a display phone number into a tel URI.
 *
 * @param string $phone Display phone number.
 * @return string
 */
function daiei_tel_href( $phone ) {
	$number = preg_replace( '/[^0-9+]/', '', $phone );
	return 'tel:' . $number;
}

/**
 * Convert the editable phone display value into a tel URI.
 *
 * @return string
 */
function daiei_phone_href() {
	return daiei_tel_href( (string) daiei_company( 'phone' ) );
}

/**
 * Recruitment phone URI.
 *
 * @return string
 */
function daiei_recruitment_phone_href() {
	return daiei_tel_href( daiei_recruitment( 'phone' ) );
}

/**
 * Whether a front-page section is enabled.
 *
 * @param string $section Section slug.
 * @return bool
 */
function daiei_section_enabled( $section ) {
	return (bool) daiei_get_option( 'daiei_show_' . $section, true );
}

/**
 * Default FAQ entries.
 *
 * Answers intentionally avoid asserting unconfirmed conditions.
 *
 * @return array<int, array<string, string>>
 */
function daiei_default_faqs() {
	return array(
		array(
			'question' => '未経験でも応募できますか？',
			'answer'   => 'はい。未経験者向けの研修があり、警備業の基礎から実際の業務まで丁寧に指導します。',
		),
		array(
			'question' => '年齢制限はありますか？',
			'answer'   => '18歳以上の方が対象です。警備業法第14条により、18歳未満の方は警備員になることができません。',
		),
		array(
			'question' => '警備の資格は必要ですか？',
			'answer'   => '警備業務の資格をお持ちでない方も応募できます。原付免許以上をお持ちの方が対象で、自転車での勤務もご相談いただけます。',
		),
		array(
			'question' => '勤務地はどのエリアですか？',
			'answer'   => '主に愛媛県松山市内の各現場です。今治市、八幡浜市など南予・東予エリアにも仕事があります。直行直帰が可能です。',
		),
		array(
			'question' => '勤務日数は相談できますか？',
			'answer'   => '1週間ごとの自由シフト制で、週2～3日から勤務できます。家庭、授業、他の仕事に合わせたシフト調整もご相談ください。',
		),
		array(
			'question' => '給与の支払方法は選べますか？',
			'answer'   => '日払い・週払い・月払いから選択でき、給与手渡しにも対応しています。現場が早く終了した場合も、日給は原則そのまま支給します。',
		),
		array(
			'question' => '法人として警備の相談はできますか？',
			'answer'   => 'はい。工事現場、施設、イベントなどの警備について、電話または法人お問い合わせフォームからご相談ください。',
		),
		array(
			'question' => '見積もりを依頼するにはどうすればよいですか？',
			'answer'   => '法人お問い合わせフォームに現場の種類、希望エリア、予定日などをご入力ください。内容を確認後、担当者からご連絡します。',
		),
	);
}

/**
 * Retrieve FAQs from WordPress, falling back to approved defaults.
 *
 * @return array<int, array<string, string>>
 */
function daiei_get_faqs() {
	$query = new WP_Query(
		array(
			'post_type'      => 'security_faq',
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'meta_key'       => '_daiei_faq_order',
			'orderby'        => array(
				'meta_value_num' => 'ASC',
				'date'           => 'ASC',
			),
			'no_found_rows'  => true,
		)
	);

	if ( ! $query->have_posts() ) {
		return daiei_default_faqs();
	}

	$items = array();
	foreach ( $query->posts as $post ) {
		$question = get_post_meta( $post->ID, '_daiei_faq_question', true );
		$answer   = get_post_meta( $post->ID, '_daiei_faq_answer', true );
		$items[]  = array(
			'question' => $question ? $question : get_the_title( $post ),
			'answer'   => $answer ? $answer : $post->post_content,
		);
	}

	return $items;
}

/**
 * Render a small breadcrumb trail on inner pages.
 *
 * @return void
 */
function daiei_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	?>
	<nav class="breadcrumbs container" aria-label="<?php esc_attr_e( 'パンくずリスト', 'daiei-keibi-lp' ); ?>">
		<ol>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'ホーム', 'daiei-keibi-lp' ); ?></a></li>
			<li aria-current="page"><?php echo esc_html( wp_get_document_title() ); ?></li>
		</ol>
	</nav>
	<?php
}

/**
 * Manual navigation used until an administrator assigns a menu.
 *
 * @param string $class CSS class.
 * @return void
 */
function daiei_fallback_menu( $class = 'site-nav__list' ) {
	$items = array(
		'services' => '警備サービス',
		'business' => '法人のお客様',
		'recruit'  => '採用情報',
		'dorm'     => '寮紹介',
		'company'  => '会社概要',
		'contact'  => 'お問い合わせ',
	);
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $items as $anchor => $label ) {
		echo '<li><a href="' . esc_url( home_url( '/#' . $anchor ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Determine a selected form value without storing submissions in WordPress.
 *
 * @param string $field Field key.
 * @return string
 */
function daiei_form_value( $field ) {
	global $daiei_form_feedback;
	if ( ! is_array( $daiei_form_feedback ) || empty( $daiei_form_feedback['values'][ $field ] ) ) {
		return '';
	}
	return (string) $daiei_form_feedback['values'][ $field ];
}

/**
 * Render a field-level validation message.
 *
 * @param string $field Field key.
 * @return void
 */
function daiei_field_error( $field ) {
	global $daiei_form_feedback;
	if ( empty( $daiei_form_feedback['errors'][ $field ] ) ) {
		return;
	}
	printf(
		'<span class="form-error" id="%1$s-error" role="alert">%2$s</span>',
		esc_attr( $field ),
		esc_html( $daiei_form_feedback['errors'][ $field ] )
	);
}

/**
 * Return aria-describedby attribute for a field with an error.
 *
 * @param string $field Field key.
 * @return string
 */
function daiei_error_describedby( $field ) {
	global $daiei_form_feedback;
	if ( empty( $daiei_form_feedback['errors'][ $field ] ) ) {
		return '';
	}
	return $field . '-error';
}
