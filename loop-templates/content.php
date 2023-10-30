<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$post_type = get_post_type();
$post_type_object = get_post_type_object( $post_type );
$link = get_the_permalink();


$card_classes = '';
$card_body_classes = '';
$tag = false;
$hide_img = false;
if ( isset($args['tag']) ) {
	$tag = $args['tag'];
} elseif( 'post' == $post_type ) {
	$tag = get_the_category_list( esc_html__( ', ', 'understrap' ) );
	$tag = strip_tags( $tag );
} else {
	$tag = $post_type_object->labels->singular_name;
}
if ( isset($args['hide_img']) ) $hide_img = $args['hide_img'];

if ( $post_type_object->exclude_from_search ) {
	$link = get_post_type_archive_link( $post_type ) . '#post-' . get_the_ID();
} else {
	$card_classes = 'card shadow-sm stretch-linked-block';
	$card_body_classes = 'card-body';
}

?>

<article <?php post_class( 'hfeed-post mb-3' ); ?> id="post-<?php the_ID(); ?>">

	<div class="<?php echo $card_classes; ?>">

		<?php if (!$hide_img) echo get_the_post_thumbnail( $post->ID, 'large', ['class' => 'mb-2 card-img-top'] ); ?>

		<div class="<?php echo $card_body_classes; ?>">
				
			<header class="entry-header">

				<?php if ( $tag ) echo '<p class="badge badge-secondary">'. $tag .'</p>'; ?>

				<?php if ( 'post' === $post_type ) : ?>

					<div class="entry-meta">
						<?php understrap_posted_on(); ?>
					</div><!-- .entry-meta -->

				<?php endif; ?>

				<?php
				if ( $link ) {
					the_title(
						sprintf( '<h2 class="h5 entry-title"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( $link ) ),
						'</a></h2>'
					);
				} else {
					the_title(
						'<h2 class="h5 entry-title">',
						'</h2>'
					);
				}
				?>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<?php
				// the_excerpt();
				understrap_link_pages();
				?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->

		</div>

	</div>

</article><!-- #post-## -->
