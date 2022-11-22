<?php

/**
 * Timeline Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'timeline-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">

	<?php if ( have_rows( 'timeline_item') ) {
			
		while ( have_rows( 'timeline_item' ) ) { the_row();
		
			$title = get_sub_field( 'timeline_item_title' ) ?: false;
			$content = get_sub_field( 'timeline_item_content' ) ?: false;
			$image_id = get_sub_field( 'timeline_item_image' ) ?: false;
			$featured = get_sub_field( 'timeline_item_featured' ) ? 'timeline-item-featured' : '';
			
			$has_image_class = 'has-not-image';
			if ( $image_id ) {
				$has_image_class = 'has-image';
			}
			?>

			<div class="timeline-item <?php echo $featured; ?> <?php echo $has_image_class; ?>">

				<?php if ( !$featured ) { ?> 
					<div class="timeline-item-image-wrapper">
						<div class="timeline-item-image-wrapper">
							<?php if( $image_id ) echo wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'rounded-circle shadow' ) ); ?>
						</div>
					</div>
				<?php } ?>

				<div class="timeline-item-content-wrapper">

					<?php if( $title ) { ?>
						<p class="timeline-item-title"><?php echo $title; ?></p>
					<?php } ?>

					<?php if( $content ) { ?>
						<div class="timeline-item-content"><?php echo $content; ?></div>
					<?php } ?>

				</div>

			</div>


		<?php }

	}
	?>

</div>