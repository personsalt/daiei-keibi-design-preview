<?php
/**
 * Single content template.
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
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class(); ?>>
				<header class="page-header">
					<p class="eyebrow"><?php echo 'job_listing' === get_post_type() ? 'RECRUIT' : 'INFORMATION'; ?></p>
					<h1><?php the_title(); ?></h1>
				</header>
				<?php if ( 'job_listing' === get_post_type() ) : ?>
					<?php
					$job_fields = array(
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
					?>
					<dl class="job-detail-list">
						<?php foreach ( $job_fields as $key => $label ) : ?>
							<?php $value = get_post_meta( get_the_ID(), '_daiei_' . $key, true ); ?>
							<?php if ( $value ) : ?>
								<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
							<?php endif; ?>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
				<div class="entry-content"><?php the_content(); ?></div>
				<?php if ( 'job_listing' === get_post_type() ) : ?>
					<a class="button button--recruit" href="<?php echo esc_url( home_url( '/#entry' ) ); ?>">この募集に応募する</a>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
