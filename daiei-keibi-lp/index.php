<?php
/**
 * Main fallback template.
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
	<div class="container content-layout">
		<header class="page-header">
			<p class="eyebrow">INFORMATION</p>
			<h1><?php echo esc_html( is_home() ? 'お知らせ' : wp_get_document_title() ); ?></h1>
		</header>
		<?php if ( have_posts() ) : ?>
			<div class="post-list">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-card' ); ?>>
						<p class="post-card__date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div><?php the_excerpt(); ?></div>
					</article>
					<?php
				endwhile;
				the_posts_pagination();
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( '現在、掲載情報はありません。', 'daiei-keibi-lp' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
