<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="error-404-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main">

					<section class="error-404 not-found">

						<div class="row align-items-center">

							<div class="col-md-6 text-center mb-3">

								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-404.svg" width="400" height="400"  alt="<?php echo __( 'Error 404', 'smn' ) ; ?>" />

							</div>

							<div class="col-md-6 text-center text-md-left mb-3">

								<header class="page-header">

									<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'understrap' ); ?></h1>

									<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'understrap' ); ?></p>

									<?php get_search_form(); ?>

								</header><!-- .page-header -->

							</div>

						</div>

						<div class="page-content">

						<div class="row">

							<div class="col-md-6">

								<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

							</div>

								<?php if ( understrap_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>

									<div class="widget widget_categories col-md-6">

										<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'understrap' ); ?></h2>

										<ul>
											<?php
											wp_list_categories(
												array(
													'orderby'  => 'count',
													'order'    => 'DESC',
													'show_count' => 1,
													'title_li' => '',
													'number'   => 10,
												)
											);
											?>
										</ul>

									</div><!-- .widget -->

								<?php endif; ?>

							</div>

						</div><!-- .page-content -->

					</section><!-- .error-404 -->

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #error-404-wrapper -->

<?php
get_footer();
