<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$post_type = get_post_type();
?>

<article <?php post_class( 'mb-3' ); ?> id="post-<?php the_ID(); ?>">

	<div class="row align-items-center flex-row-reverse">

		<div class="col-md-6">

			<?php echo get_the_post_thumbnail( $post->ID, 'large', ['class' => 'mb-2'] ); ?>

		</div>

		<div class="col-md-6">
				
			<header class="entry-header">

				<?php if ( 'post' === $post_type ) : ?>

					<div class="entry-meta">
						<?php understrap_posted_on(); ?>
					</div><!-- .entry-meta -->

				<?php endif; ?>

				<?php
					the_title(
						'<h3 class="entry-title">',
						'</h3>'
					);
				?>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<?php
				the_content();
				understrap_link_pages();
				?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->

		</div>

	</div>

</article><!-- #post-## -->
