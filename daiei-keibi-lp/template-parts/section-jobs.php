<?php
/**
 * Job listings with confirmed recruitment information.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jobs = new WP_Query(
	array(
		'post_type'      => 'job_listing',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'no_found_rows'  => true,
	)
);

$job_types = array( '警備員', '交通誘導警備', 'イベント警備' );
$shift_items = array(
	'1週間ごとの自由シフト制',
	'週2～3日から勤務可能・週3日以上歓迎',
	'勤務しない週も相談可能',
	'短期勤務可能・長期勤務歓迎',
	'連休取得可能・土日祝休みの相談可能',
	'家庭の都合による休みの調整可能',
	'授業や他の仕事を優先したシフト調整可能',
	'直行直帰可能',
);
$requirements = array(
	'18歳以上（警備業法第14条による）',
	'原付免許以上をお持ちの方（自転車での勤務も相談可能）',
	'学歴不問・性別不問',
	'未経験者歓迎・経験者優遇',
	'学生、主婦・主夫、フリーター歓迎',
	'新卒・第二新卒歓迎',
	'中高年・シニア、定年退職後の再就職歓迎',
	'外国人・留学生歓迎',
	'ダブルワーク・副業可能',
	'ブランクのある方歓迎',
	'友達同士での応募可能',
);
$benefit_items = array(
	'交通費規定内支給',
	'資格手当・各種手当あり',
	'資格取得支援制度',
	'日給保証',
	'個室寮完備・原付貸出制度',
	'入社祝い金30,000円（入社60日後に支給）',
	'未経験者向け研修制度',
	'各種社会保険完備（雇用保険、健康保険、労災保険、厚生年金保険）',
	'友達紹介ボーナス',
	'女性用サイズの制服あり',
	'勤務中のトイレ環境を確保',
	'女性相談窓口あり',
	'体調やライフイベントに応じた勤務相談可能',
	'髪型自由・ひげ・ピアス可能',
);
$feature_items = array(
	'2025年6月開業・オープニングスタッフを大量募集',
	'学生から中高年・シニアまで幅広い年代が活躍',
	'未経験から始められる研修体制',
	'合わない現場がある場合は現場変更を相談可能',
	'友達と一緒に勤務可能',
	'男女を問わず昇給・昇格の機会あり',
);
?>
<section class="section jobs" id="jobs" aria-labelledby="jobs-title">
	<div class="container">
		<header class="section-heading section-heading--split reveal">
			<div>
				<p class="eyebrow">JOB OPENINGS</p>
				<h2 id="jobs-title">募集要項</h2>
			</div>
			<p>交通誘導を中心とした警備スタッフを募集中。未経験の方も研修からスタートできます。</p>
		</header>

		<?php if ( $jobs->have_posts() ) : ?>
			<div class="job-cards">
				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
					<article class="job-card reveal">
						<div class="job-card__header">
							<span><?php echo esc_html( get_post_meta( get_the_ID(), '_daiei_status', true ) ?: '募集状況はお問い合わせください' ); ?></span>
							<h3><?php echo esc_html( get_post_meta( get_the_ID(), '_daiei_job_type', true ) ?: get_the_title() ); ?></h3>
						</div>
						<dl>
							<?php foreach ( array( 'employment' => '雇用形態', 'salary' => '給与', 'location' => '勤務地', 'hours' => '勤務時間' ) as $key => $label ) : ?>
								<?php $value = get_post_meta( get_the_ID(), '_daiei_' . $key, true ); ?>
								<?php if ( $value ) : ?>
									<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
								<?php endif; ?>
							<?php endforeach; ?>
						</dl>
						<a class="text-link" href="<?php the_permalink(); ?>">募集要項の詳細 <span aria-hidden="true">→</span></a>
					</article>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<article class="job-fallback job-offer reveal">
				<div class="job-fallback__header">
					<div>
						<span class="status-badge">オープニングスタッフ募集</span>
						<h3>警備スタッフ｜アルバイト・パート</h3>
					</div>
					<p>即日勤務可能</p>
				</div>

				<div class="job-offer__lead">
					<p>工事現場などで、通行人や車両を安全に誘導する交通誘導警備が中心です。イベント会場での警備業務などもあります。</p>
					<p>未経験者向けの研修があり、警備業の基礎から実際の業務まで丁寧に指導します。</p>
					<ul class="tag-list" aria-label="募集職種">
						<?php foreach ( $job_types as $job_type ) : ?>
							<li><?php echo esc_html( $job_type ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<section class="job-offer__pay" aria-labelledby="job-pay-title">
					<h4 id="job-pay-title">給与</h4>
					<div class="pay-cards">
						<div><span>日勤・未経験者</span><strong>日給8,500円～</strong></div>
						<div><span>日勤・資格保有者</span><strong>日給9,000円～</strong></div>
						<div><span>夜勤・未経験者</span><strong>日給11,600円～</strong></div>
						<div><span>夜勤・資格保有者</span><strong>日給12,600円～</strong></div>
					</div>
					<ul class="job-inline-notes">
						<li>試用期間中は日給8,300円（最大3か月）</li>
						<li>資格手当、その他各種手当あり</li>
						<li>交通費は規定内で一部支給</li>
						<li>日給保証・給与手渡し対応</li>
						<li>日払い・週払い・月払いから選択可能</li>
					</ul>
					<p class="monthly-example"><span>月収例／未経験・週5日・月22日勤務</span><strong>187,000円～</strong><small>日給8,500円 × 22日</small></p>
					<p class="joining-bonus"><span>入社祝い金</span><strong>30,000円</strong><small>入社60日後に支給</small></p>
				</section>

				<dl class="job-offer__table">
					<div>
						<dt>勤務時間</dt>
						<dd><strong>日勤／8:00～17:00</strong><br><strong>夜勤／21:00～翌5:00</strong><br>休憩1時間。基本的に残業はありません。現場が早く終了した場合も、日給は原則そのまま支給します。</dd>
					</div>
					<div>
						<dt>勤務日・シフト</dt>
						<dd><ul class="job-detail-listing"><?php foreach ( $shift_items as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul></dd>
					</div>
					<div>
						<dt>勤務地</dt>
						<dd>愛媛県松山市内の各現場（最寄り駅：JR予讃線 松山駅）<br>今治市、八幡浜市など南予・東予エリアにも仕事があります。</dd>
					</div>
					<div>
						<dt>面接場所</dt>
						<dd><?php echo esc_html( daiei_recruitment( 'interview_address' ) ); ?><br><?php echo esc_html( daiei_company( 'company_name' ) ); ?><br>JR松山駅から車で約10分。今治市での面接、南予・東予在住者の出張面接も相談可能です。</dd>
					</div>
					<div><dt>勤務開始日</dt><dd>即日勤務可能</dd></div>
				</dl>

				<div class="job-offer__columns">
					<section>
						<h4>応募資格</h4>
						<ul class="job-detail-listing"><?php foreach ( $requirements as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul>
					</section>
					<section>
						<h4>待遇・福利厚生</h4>
						<ul class="job-detail-listing"><?php foreach ( $benefit_items as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul>
					</section>
				</div>

				<section class="job-offer__features">
					<h4>職場・求人の特徴</h4>
					<ul class="job-detail-listing job-detail-listing--grid"><?php foreach ( $feature_items as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul>
				</section>

				<div class="job-offer__apply">
					<div>
						<p>電話応募／担当 <?php echo esc_html( daiei_recruitment( 'contact' ) ); ?></p>
						<a href="<?php echo esc_url( daiei_recruitment_phone_href() ); ?>"><?php echo esc_html( daiei_recruitment( 'phone' ) ); ?></a>
					</div>
					<a class="button button--recruit" href="#entry">WEBから応募する <span aria-hidden="true">→</span></a>
				</div>
				<p class="job-offer__management">求人管理情報：管理番号 643894／仕事番号 警備0604</p>
			</article>
		<?php endif; ?>
		<div class="jobs__cta reveal">
			<p>友達同士の応募も歓迎。勤務日数やエリアもお気軽にご相談ください。</p>
			<a class="button button--recruit" href="#entry">採用応募フォームへ <span aria-hidden="true">→</span></a>
		</div>
	</div>
</section>
