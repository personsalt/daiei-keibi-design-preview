<?php
/**
 * Not found template.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="inner-page error-page">
	<div class="container content-narrow">
		<p class="error-page__code" aria-hidden="true">404</p>
		<h1>ページが見つかりません</h1>
		<p>お探しのページは移動または削除された可能性があります。</p>
		<a class="button button--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
	</div>
</main>
<?php
get_footer();
