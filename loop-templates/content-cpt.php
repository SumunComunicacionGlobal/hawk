<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

global $post;
$post_type = get_post_type();

// Definir la clase para el contenedor del artículo
$article_class = '';

if ( in_array( $post_type, array( 'modulo', 'tecnologia', 'funcionalidad' ) ) ) {
    $article_class = 'col-md-4 gap-2 animated o-anim-ready fadeIn delay-100ms';
	$content_class = 'flex-grow-1 ms-3';
	$image_class = 'flex-shrink-0 text-center text-md-left';
} else {
    $article_class = 'animated o-anim-ready fadeIn delay-100ms';
	$image_class = '';
	$content_class = '';
}
?>

<article <?php post_class( $article_class ); ?> id="post-<?php the_ID(); ?>">

	<div class="<?php echo $image_class ;?>">
		<?php echo get_the_post_thumbnail( $post->ID, 'large', ['class' => 'mb-3'] ); ?>
	</div>

	<div class="<?php echo $content_class ;?>">
			
		<header class="entry-header">

			<?php if ( 'post' === $post_type ) : ?>

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>

			<?php
				the_title(
					'<h3 class="entry-title h4"><strong>',
					'</strong></h3>'
				);
			?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php
			if ( $post->post_excerpt ) {
				the_excerpt();
			} else {
				the_content();
			}

			understrap_link_pages();
			?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</div>


</article><!-- #post-## -->
