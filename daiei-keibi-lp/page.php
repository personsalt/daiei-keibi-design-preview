<?php
/**
 * Standard page template.
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
					<p class="eyebrow">PAGE</p>
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="entry-content"><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
