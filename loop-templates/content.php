<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

global $post;
$post_type = $post->post_type;
$post_type_object = get_post_type_object( $post_type );
$link = get_the_permalink();
$link_alt = get_post_type_archive_link( $post_type ) . '#post-' . get_the_ID();


$card_classes = 'card';
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

if ( 'modulo' == $post_type ) {
	if ( !$post->post_content ) {
		$link = $link_alt;
	}
} elseif ( $post_type_object->exclude_from_search ) {
	$link = $link_alt;
} else {
	$card_classes = 'card stretch-linked-block';
	$card_body_classes = 'card-body';
}

?>

<article <?php post_class( 'hfeed-post mb-3 animated o-anim-ready fadeIn delay-100ms' ); ?> id="post-<?php the_ID(); ?>">

	<div class="<?php echo $card_classes; ?>">
		<div class="card-img card-img-top">
			<?php if (!$hide_img) echo get_the_post_thumbnail( $post->ID, 'medium', ['class' => 'mb-0 card-img-top'] ); ?>
			<?php if ( $tag ) echo '<span class="badge badge-secondary">'. $tag .'</span>'; ?>
		</div>
		<div class="<?php echo $card_body_classes; ?>">
				
			<header class="entry-header">

				<?php if ( 'post' === $post_type ) : ?>

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

		</div>

	</div>

</article><!-- #post-## -->
