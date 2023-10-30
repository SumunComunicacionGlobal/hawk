<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$fields = ['modulos', 'tecnologias', 'funcionalidades', 'related_posts'];

$post_types = get_post_types( ['public' => true] );

$taxonomies = array(
	'perfil',
	'sector',
);


foreach( $fields as $field ) {

	$posts_ids = get_post_meta( get_the_ID(), $field, true );

	if ( $posts_ids ) {

		$field_object = get_field_object( $field );
		if ( isset( $field_object['post_type'] ) ) $post_types = $field_object['post_type'];
		$labels = get_post_type_object( $post_types[0] )->labels;

		$args = array(
			'post_type'			=> $post_types,
			'post__in'			=> $posts_ids,
			'orderby'			=> 'post__in',
			'order'				=> 'ASC',
			'posts_per_page'	=> -1,
		);
	
		$q = new WP_Query($args);

		if ( $q->have_posts() ) { ?>

			<div class="wrapper hfeed related-posts">

				<?php echo '<h2 class="mb-2">' . $labels->name . '</h2>'; ?>

				<?php while ( $q->have_posts() ) { $q->the_post();

					get_template_part( 'loop-templates/content', 'show-all' );

				} ?>

				<?php echo wpautop( '<a class="view-all-link btn btn-outline-primary" href="'. get_post_type_archive_link( $post_types[0] ).'">' . $labels->view_items . '</a>' ); ?>

			</div>

		<?php }

		wp_reset_postdata();
	}

}

foreach ( $taxonomies as $tax ) {

	$term_list = get_the_term_list( get_the_ID(), $tax, '<p class="btn-group">', '', '</p>' );

	if ( $term_list ) { ?>

		<div class="wrapper">

			<?php $label = get_taxonomy_labels( get_taxonomy( $tax ) )->name; ?>

			<h2><?php echo sprintf( __( '%s relacionados', 'smn' ), $label ); ?></h2>

			<?php echo $term_list; ?>

		</div>

	<?php }

}


$casos_de_exito_ids = get_post_meta( get_the_ID(), 'casos_de_exito', true );

if ( $casos_de_exito_ids ) {

	$casos_de_exito_term = get_term( CASOS_DE_EXITO_ID );
	$label = $casos_de_exito_term->name;

	$args = array(
		'post_type'			=> 'post',
		'post__in'			=> $casos_de_exito_ids,
		'orderby'			=> 'post__in',
		'order'				=> 'ASC',
		'posts_per_page'	=> -1,
		'ignore_sticky_posts'		=> 1
	);

	$q = new WP_Query($args);

	if ( $q->have_posts() ) { ?>

		<div class="wrapper hfeed related-posts">

			<?php echo '<h2 class="mb-2">' . $label . '</h2>'; ?>

			<?php while ( $q->have_posts() ) { $q->the_post();

				get_template_part( 'loop-templates/content', 'show-all' );

			} ?>

			<?php echo wpautop( '<a class="view-all-link btn btn-outline-primary" href="'. get_term_link( $casos_de_exito_term ) .'">' . __( 'Ver todos los casos de éxito', 'smn' ) . '</a>' ); ?>

		</div>

	<?php }

	wp_reset_postdata();
}