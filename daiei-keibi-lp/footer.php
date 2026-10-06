<?php
/**
 * Site footer.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$privacy_page = absint( daiei_get_option( 'daiei_privacy_page', 0 ) );
$privacy_url  = $privacy_page ? get_permalink( $privacy_page ) : get_privacy_policy_url();
if ( ! $privacy_url ) {
	$privacy_url = home_url( '/privacy/' );
}
?>
<footer class="site-footer">
	<div class="site-footer__accent" aria-hidden="true"></div>
	<div class="container site-footer__grid">
		<div class="footer-company">
			<a class="footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-daiei-mark.png' ); ?>" width="56" height="56" alt="">
				<span><small>DAIEI SECURITY</small><strong><?php echo esc_html( daiei_company( 'company_name' ) ); ?></strong></span>
			</a>
			<address>
				<?php echo esc_html( daiei_company( 'address' ) ); ?><br>
				TEL <a href="<?php echo esc_url( daiei_phone_href() ); ?>"><?php echo esc_html( daiei_company( 'phone' ) ); ?></a><br>
				警備業認定 <?php echo esc_html( daiei_company( 'license' ) ); ?>
			</address>
		</div>
		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'フッターメニュー', 'daiei-keibi-lp' ); ?>">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'footer-nav__list',
						'depth'          => 1,
					)
				);
			} else {
				daiei_fallback_menu( 'footer-nav__list' );
			}
			?>
			<a class="footer-privacy" href="<?php echo esc_url( $privacy_url ); ?>">プライバシーポリシー</a>
		</nav>
		<?php
		$socials = array_filter(
			array(
				'Facebook'  => daiei_get_option( 'daiei_facebook_url', '' ),
				'Instagram' => daiei_get_option( 'daiei_instagram_url', '' ),
				'X'         => daiei_get_option( 'daiei_x_url', '' ),
			)
		);
		if ( $socials ) :
			?>
			<div class="footer-social" aria-label="<?php esc_attr_e( 'ソーシャルメディア', 'daiei-keibi-lp' ); ?>">
				<?php foreach ( $socials as $label => $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $label ); ?><span class="screen-reader-text">（新しいタブで開く）</span></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="site-footer__bottom">
		<div class="container">
			<small>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( daiei_company( 'company_name' ) ); ?></small>
			<span>地域の安心を、確かな警備で。</span>
		</div>
	</div>
</footer>

<button class="back-to-top" type="button" aria-label="<?php esc_attr_e( 'ページ上部へ戻る', 'daiei-keibi-lp' ); ?>">
	<span aria-hidden="true">↑</span>
</button>

<nav class="mobile-fixed-cta" aria-label="<?php esc_attr_e( 'お問い合わせショートカット', 'daiei-keibi-lp' ); ?>">
	<a class="mobile-fixed-cta__phone" href="<?php echo esc_url( daiei_phone_href() ); ?>"><span aria-hidden="true">☎</span>電話</a>
	<a class="mobile-fixed-cta__entry" href="<?php echo esc_url( home_url( '/#entry' ) ); ?>"><span aria-hidden="true">＋</span>応募</a>
	<a class="mobile-fixed-cta__contact" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><span aria-hidden="true">□</span>警備相談</a>
</nav>

<?php wp_footer(); ?>
</body>
</html>
