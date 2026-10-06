<?php
/**
 * Recruitment message and optional employee voices.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$voices = new WP_Query(
	array(
		'post_type'      => 'employee_voice',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);
?>
<section class="recruit" id="recruit" aria-labelledby="recruit-title">
	<div class="recruit__visual" aria-hidden="true">
		<span class="recruit__word">RECRUIT</span>
		<div class="recruit__figure">
			<span></span><span></span><span></span>
		</div>
	</div>
	<div class="container recruit__inner">
		<div class="recruit__copy">
			<p class="eyebrow eyebrow--accent reveal">JOIN OUR TEAM</p>
			<h2 class="reveal" id="recruit-title">未経験から、<br>地域の安全を守る仕事へ。</h2>
			<p class="recruit__lead reveal">日勤8,500円～、週2～3日から。自由シフトで始められます。</p>
			<p class="reveal">工事現場での交通誘導を中心に、イベント会場の警備などを行います。未経験者向けの研修で、警備業の基礎から実際の業務まで丁寧に指導します。</p>
			<div class="recruit__badges reveal" aria-label="採用方針">
				<span>未経験歓迎</span>
				<span>18歳以上</span>
				<span>週2～3日から</span>
				<span>日払い・週払い可</span>
				<span>短期勤務可</span>
			</div>
			<p class="section-note reveal">雇用形態：<?php echo esc_html( daiei_recruitment( 'employment' ) ); ?>／即日勤務可／直行直帰可</p>
			<a class="button button--recruit button--large reveal" href="#entry">
				<?php echo esc_html( daiei_get_option( 'daiei_recruit_cta', '警備スタッフに応募する' ) ); ?>
				<span aria-hidden="true">→</span>
			</a>
			<a class="recruit__phone reveal" href="<?php echo esc_url( daiei_recruitment_phone_href() ); ?>">
				<small>電話応募・採用担当 <?php echo esc_html( daiei_recruitment( 'contact' ) ); ?></small>
				<strong><?php echo esc_html( daiei_recruitment( 'phone' ) ); ?></strong>
			</a>
		</div>
	</div>

	<?php if ( $voices->have_posts() ) : ?>
		<div class="container employee-voices">
			<h3 class="reveal">社員の声</h3>
			<div class="employee-voices__grid">
				<?php while ( $voices->have_posts() ) : $voices->the_post(); ?>
					<article class="voice-card reveal">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); ?>
						<?php endif; ?>
						<blockquote><?php echo wp_kses_post( wpautop( get_the_content() ) ); ?></blockquote>
						<p>
							<strong><?php echo esc_html( get_post_meta( get_the_ID(), '_daiei_voice_name', true ) ?: get_the_title() ); ?></strong>
							<?php
							$age = get_post_meta( get_the_ID(), '_daiei_voice_age', true );
							$exp = get_post_meta( get_the_ID(), '_daiei_voice_experience', true );
							if ( $age || $exp ) {
								echo '<span>' . esc_html( implode( ' / ', array_filter( array( $age, $exp ) ) ) ) . '</span>';
							}
							?>
						</p>
					</article>
				<?php endwhile; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
</section>
