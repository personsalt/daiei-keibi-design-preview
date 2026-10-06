<?php
/**
 * Privacy policy page template.
 *
 * Template Name: プライバシーポリシー
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="inner-page">
	<?php daiei_breadcrumbs(); ?>
	<div class="container content-layout content-narrow">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<header class="page-header">
					<p class="eyebrow">PRIVACY POLICY</p>
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php if ( trim( get_the_content() ) ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<div class="notice-box">
							<p><strong>本文は公開前にご登録ください。</strong></p>
							<p>個人情報の利用目的、管理方法、第三者提供、開示等の請求、お問い合わせ窓口など、貴社で確認済みの正式な方針をWordPressの固定ページ本文へ入力してください。</p>
						</div>
					<?php endif; ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
