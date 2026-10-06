<?php
/**
 * Editable recruitment, FAQ, and employee voice content.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom post types.
 *
 * @return void
 */
function daiei_register_post_types() {
	$types = array(
		'job_listing' => array(
			'singular' => '募集情報',
			'plural'   => '募集情報',
			'menu_icon'=> 'dashicons-businessperson',
			'supports' => array( 'title', 'editor' ),
			'archive'  => true,
			'rewrite'  => 'jobs',
		),
		'security_faq' => array(
			'singular' => 'よくある質問',
			'plural'   => 'よくある質問',
			'menu_icon'=> 'dashicons-editor-help',
			'supports' => array( 'title' ),
			'archive'  => false,
			'rewrite'  => false,
		),
		'employee_voice' => array(
			'singular' => '社員の声',
			'plural'   => '社員の声',
			'menu_icon'=> 'dashicons-format-quote',
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'archive'  => false,
			'rewrite'  => false,
		),
	);

	foreach ( $types as $slug => $config ) {
		register_post_type(
			$slug,
			array(
				'labels' => array(
					'name'          => $config['plural'],
					'singular_name' => $config['singular'],
					'add_new_item'  => $config['singular'] . 'を追加',
					'edit_item'     => $config['singular'] . 'を編集',
					'search_items'  => $config['plural'] . 'を検索',
					'not_found'     => $config['plural'] . 'はありません',
				),
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => $config['archive'],
				'rewrite'      => $config['rewrite'] ? array( 'slug' => $config['rewrite'] ) : false,
				'menu_icon'    => $config['menu_icon'],
				'supports'     => $config['supports'],
			)
		);
	}
}
add_action( 'init', 'daiei_register_post_types' );

/**
 * Register meta boxes.
 *
 * @return void
 */
function daiei_add_meta_boxes() {
	add_meta_box( 'daiei_job_details', '募集条件', 'daiei_job_meta_box', 'job_listing', 'normal', 'high' );
	add_meta_box( 'daiei_faq_details', '質問と回答', 'daiei_faq_meta_box', 'security_faq', 'normal', 'high' );
	add_meta_box( 'daiei_voice_details', '社員プロフィール', 'daiei_voice_meta_box', 'employee_voice', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'daiei_add_meta_boxes' );

/**
 * Render job fields.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function daiei_job_meta_box( $post ) {
	wp_nonce_field( 'daiei_save_meta', 'daiei_meta_nonce' );
	$fields = array(
		'job_type'     => '募集職種',
		'employment'   => '雇用形態',
		'salary'       => '給与',
		'location'     => '勤務地',
		'hours'        => '勤務時間',
		'holidays'     => '休日',
		'requirements' => '応募資格',
		'benefits'     => '待遇',
		'status'       => '募集状況',
	);
	echo '<div class="daiei-admin-fields">';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, '_daiei_' . $key, true );
		printf(
			'<p><label for="daiei_%1$s"><strong>%2$s</strong></label><br><input class="widefat" type="text" id="daiei_%1$s" name="daiei_%1$s" value="%3$s"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '</div>';
}

/**
 * Render FAQ fields.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function daiei_faq_meta_box( $post ) {
	wp_nonce_field( 'daiei_save_meta', 'daiei_meta_nonce' );
	$question = get_post_meta( $post->ID, '_daiei_faq_question', true );
	$answer   = get_post_meta( $post->ID, '_daiei_faq_answer', true );
	$order    = get_post_meta( $post->ID, '_daiei_faq_order', true );
	?>
	<p>
		<label for="daiei_faq_question"><strong><?php esc_html_e( '質問', 'daiei-keibi-lp' ); ?></strong></label>
		<input class="widefat" type="text" id="daiei_faq_question" name="daiei_faq_question" value="<?php echo esc_attr( $question ); ?>">
	</p>
	<p>
		<label for="daiei_faq_answer"><strong><?php esc_html_e( '回答', 'daiei-keibi-lp' ); ?></strong></label>
		<textarea class="widefat" rows="6" id="daiei_faq_answer" name="daiei_faq_answer"><?php echo esc_textarea( $answer ); ?></textarea>
	</p>
	<p>
		<label for="daiei_faq_order"><strong><?php esc_html_e( '表示順', 'daiei-keibi-lp' ); ?></strong></label>
		<input type="number" min="0" id="daiei_faq_order" name="daiei_faq_order" value="<?php echo esc_attr( $order ); ?>">
	</p>
	<?php
}

/**
 * Render employee voice fields.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function daiei_voice_meta_box( $post ) {
	wp_nonce_field( 'daiei_save_meta', 'daiei_meta_nonce' );
	foreach ( array( 'voice_name' => '氏名またはイニシャル', 'voice_age' => '年代', 'voice_experience' => '経験年数' ) as $key => $label ) {
		$value = get_post_meta( $post->ID, '_daiei_' . $key, true );
		printf(
			'<p><label for="daiei_%1$s"><strong>%2$s</strong></label><br><input class="widefat" type="text" id="daiei_%1$s" name="daiei_%1$s" value="%3$s"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}
	echo '<p>コメントは本文、写真はアイキャッチ画像に登録してください。未登録時はフロントページに表示されません。</p>';
}

/**
 * Save custom post metadata.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function daiei_save_post_meta( $post_id ) {
	if (
		! isset( $_POST['daiei_meta_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['daiei_meta_nonce'] ) ), 'daiei_save_meta' ) ||
		( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
		! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	$post_type = get_post_type( $post_id );
	$fields    = array();
	if ( 'job_listing' === $post_type ) {
		$fields = array( 'job_type', 'employment', 'salary', 'location', 'hours', 'holidays', 'requirements', 'benefits', 'status' );
	} elseif ( 'security_faq' === $post_type ) {
		$fields = array( 'faq_question', 'faq_answer', 'faq_order' );
	} elseif ( 'employee_voice' === $post_type ) {
		$fields = array( 'voice_name', 'voice_age', 'voice_experience' );
	}

	foreach ( $fields as $field ) {
		if ( ! isset( $_POST[ 'daiei_' . $field ] ) ) {
			continue;
		}
		$value = wp_unslash( $_POST[ 'daiei_' . $field ] );
		if ( 'faq_answer' === $field ) {
			$value = sanitize_textarea_field( $value );
		} elseif ( 'faq_order' === $field ) {
			$value = absint( $value );
		} else {
			$value = sanitize_text_field( $value );
		}
		update_post_meta( $post_id, '_daiei_' . $field, $value );
	}
}
add_action( 'save_post', 'daiei_save_post_meta' );
