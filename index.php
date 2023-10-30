<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
			
			<?php if ( is_home() && !is_front_page() ) {
				$page_id = get_option( 'page_for_posts' );
				if ( $page_id ) { 
					$page_for_posts = get_page( $page_id );
					?>

					<div class="entry-content">

						<?php echo apply_filters( 'the_content', $page_for_posts->post_content ); ?>

					</div>

				<?php }
			} ?>


				<?php
				if ( have_posts() ) {
					// Start the Loop.
					
					get_template_part( 'global-templates/filtro', 'blog' ); ?>

					<div class="row">
					
					<?php while ( have_posts() ) {
						the_post(); ?>

						<?php if ( is_sticky() ) { ?>

							<div class="col-12">

								<?php get_template_part( 'loop-templates/content', 'sticky' ); ?>

							</div>

						<?php } else { ?>

							<div class="<?php echo COL_CLASSES; ?>">

								<?php
								/*
								* Include the Post-Format-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Format name) and that will be used instead.
								*/
								get_template_part( 'loop-templates/content', get_post_format() );
								?>

							</div>
						
						<?php }

					}

				} else {
					get_template_part( 'loop-templates/content', 'none' );
				}
				?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
