<?php
/**
 * Site header.
 *
 * @package Daiei_Keibi_LP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( '本文へ移動', 'daiei-keibi-lp' ); ?></a>
<div class="scroll-progress" aria-hidden="true"><span></span></div>

<header class="site-header" id="site-header">
	<div class="site-header__inner container">
		<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( daiei_company( 'company_name' ) . ' ホーム' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<span class="site-brand__custom-logo"><?php echo wp_kses_post( get_custom_logo() ); ?></span>
			<?php else : ?>
				<img class="site-brand__mark" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-daiei-mark.png' ); ?>" width="48" height="48" alt="">
				<span class="site-brand__text">
					<small>DAIEI SECURITY</small>
					<strong><?php echo esc_html( daiei_company( 'company_name' ) ); ?></strong>
				</span>
			<?php endif; ?>
		</a>

		<button class="menu-toggle" type="button" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'メニューを開く', 'daiei-keibi-lp' ); ?>">
			<span class="menu-toggle__label"><?php esc_html_e( 'メニュー', 'daiei-keibi-lp' ); ?></span>
			<span class="menu-toggle__lines" aria-hidden="true"><i></i><i></i><i></i></span>
		</button>

		<nav class="site-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'メインメニュー', 'daiei-keibi-lp' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'site-nav__list',
						'depth'          => 2,
					)
				);
			} else {
				daiei_fallback_menu();
			}
			?>
			<div class="site-nav__mobile-cta">
				<a class="button button--recruit" href="<?php echo esc_url( home_url( '/#entry' ) ); ?>"><?php echo esc_html( daiei_get_option( 'daiei_recruit_cta', '警備スタッフに応募する' ) ); ?></a>
				<a class="button button--outline-light" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php echo esc_html( daiei_get_option( 'daiei_business_cta', '警備の相談・見積もり' ) ); ?></a>
			</div>
		</nav>

		<div class="header-actions">
			<a class="header-phone" href="<?php echo esc_url( daiei_phone_href() ); ?>">
				<span>お電話で相談</span>
				<strong><?php echo esc_html( daiei_company( 'phone' ) ); ?></strong>
			</a>
			<a class="header-entry" href="<?php echo esc_url( home_url( '/#entry' ) ); ?>">採用応募</a>
			<a class="header-contact" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">法人相談</a>
		</div>
	</div>
</header>
