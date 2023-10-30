<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( is_page_template() ) return false;

$image_id = false;
$title = '';
$description = '';

if ( is_singular() ) {
	$image_id = get_post_thumbnail_id( get_the_ID() );
	$title = get_the_title();
} elseif ( is_archive() ) {
	$image_id = get_term_meta( get_queried_object_id(), 'thumbnail_id', true );
	$title = get_the_archive_title();
	$description = get_the_archive_description();
}

if ( $title ) {
?>

	<header class="wp-block-cover alignfull is-style-image-header">

		<span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span>

		<?php if ( $image_id ) echo wp_get_attachment_image( $image_id, 'large', false, array('class' => 'wp-block-cover__image-background') ); ?>

		<div class="wp-block-cover__inner-container container">

			<?php if ( is_singular( 'post' ) ) { ?>

				<div class="entry-meta text-white">

					<?php understrap_posted_on(); ?>

				</div><!-- .entry-meta -->

			<?php } ?>

			<h1 class="entry-title"><?php echo $title; ?></h1>

			<?php if ( $description) { ?>
				
				<div class="lead"><?php echo $description; ?></div>
			
			<?php } ?>

		</div>

	</header>

<?php } ?>

<?php smn_breadcrumb(); ?>

