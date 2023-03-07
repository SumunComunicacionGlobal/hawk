<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( es_blog() ) {
	return false;
}

$container = get_theme_mod( 'understrap_container_type' );

$args = array(
	'posts_per_page'	=> 3
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="wrapper hfeed blog-block" id="wrapper-blog">

		<div class="<?php echo esc_attr( $container ); ?>" tabindex="-1">

			<?php if( is_singular() ): ?>
			<div class="row">
			<?php endif; ?>

				<?php while ( $q->have_posts() ) { $q->the_post();

					get_template_part( 'loop-templates/content' );

				} ?>

			<?php if( is_singular() ): ?>
			</div>
			<?php endif; ?>

		</div>

	</div>

<?php }

wp_reset_postdata();
