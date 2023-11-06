<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function contenido_pagina($atts) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
				'imagen'	=> 'no',
				'dominio'	=> false,

		), $atts)	
	);
	if ($dominio) {
		$api_url = $dominio . '/wp-json/wp/v2/pages/' . $id;
		$data = wp_remote_get( $api_url );
		$data_decode = json_decode( $data['body'] );

		// echo '<pre>'; print_r($data_decode); echo '</pre>';

		$content = $data_decode->content->rendered;
		return $content;
	} else {
		if ( 0 != $id) {
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = '<div class="post-content-container">'.apply_filters('the_content', $content) .'</div>';
			if ('si' == $imagen) {
				$content = '<div class="entry-thumbnail">'.get_the_post_thumbnail($id, 'full') . '</div>' . $content;
			}
			return $content;
		}
	}
}
add_shortcode('contenido_pagina','contenido_pagina');

function home_url_shortcode() {
	return get_home_url();
}
add_shortcode('home_url','home_url_shortcode');

function theme_url_shortcode() {
	return get_stylesheet_directory_uri();
}
add_shortcode('theme_url','theme_url_shortcode');

function uploads_url_shortcode() {
	$upload_dir = wp_upload_dir();
	$uploads_url = $upload_dir['baseurl'];
	return $uploads_url;
}
add_shortcode('uploads_url','uploads_url_shortcode');

function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

function term_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_term_link( $id );
}
add_shortcode('cat_link', 'term_link_sh');

function post_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_the_permalink( $id );
}
add_shortcode('post_link', 'post_link_sh');

function smn_taxonomy( $atts ) {

	extract( shortcode_atts(
		array(
				'slug' 	=> 'category',
		), $atts)	
	);

	$terms = get_terms( array('taxonomy' => $slug) );
	$taxonomy_label = get_taxonomy_labels( get_taxonomy( $slug ) )->singular_name;
	$r = '';

	if ( $terms ) {

		$r .= '<div class="paginas-hijas taxonomy-terms my-3">';

			$r .= '<div class="row">';

			foreach ($terms as $term) {
				$r .= '<div class="col-sm-6 col-lg-4 mb-3 stretch-linked-block">';
					$r .= '<div class="card shadow-sm">';
						$r .= '<div class="card-body">';
							$r .= '<header class="entry-header">';
								$r .= '<p class="badge badge-secondary">' . $taxonomy_label . '</p>';
								$r .= '<h2 class="h5 entry-title"><a href="'.get_term_link( $term ).'" class="stretched-link">'.$term->name.'</a></h2>';
							$r .= '</header>';
						$r .= '</div>';
					$r .= '</div>';
				$r .= '</div>';
				}

			$r .= '</div>';

		$r .= '</div>';

	}

	return $r;
}
add_shortcode( 'taxonomy', 'smn_taxonomy' );

function paginas_hijas( $atts ) {

	extract( shortcode_atts(
		array(
				'id' 	=> 0,
				'hide_img' => true,
				'post_type_archive' => false,
		), $atts)	
	);
	$id = intval($id);

	global $post;
	$r = '';


	if ( $post_type_archive ) {

		$args = array(
			'post_type'			=> $post_type_archive,
			'posts_per_page'	=> -1,
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
		);

		$tag = get_post_type_object( $post_type_archive )->labels->singular_name;

		$query = new WP_Query($args);

		if ($query->have_posts() ) {

			$r .= '<div class="paginas-hijas my-3">';

				$r .= '<div class="row">';

				while($query->have_posts() ) {
					$query->the_post();

					$r .= '<div class="' . COL_CLASSES . '">';

						ob_start();
						get_template_part( 'loop-templates/content', '', ['tag' => $tag, 'hide_img' => $hide_img ] );
						$r .= ob_get_clean();
			
					$r .= '</div>';

				}

				$r .= '</div>';

			$r .= '</div>';

		}

		wp_reset_postdata();

	} elseif ( is_post_type_hierarchical( $post->post_type ) /*&& '' == $post->post_content */) {

		$args = array(
			'post_type'			=> array($post->post_type),
			'posts_per_page'	=> -1,
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_parent'		=> $post->ID,
		);

		if ( $id ) $args['post_parent'] = $id;

		$tag = get_the_title( $args['post_parent'] );

		$query = new WP_Query($args);
		if ($query->have_posts() ) {

			$r .= '<div class="paginas-hijas my-3">';

				$r .= '<div class="row">';

				while($query->have_posts() ) {
					$query->the_post();

					ob_start();
					get_template_part( 'loop-templates/content', '', ['tag' => $tag, 'hide_img' => $hide_img ] );
					$r .= ob_get_clean();
					// $r .= '<a class="btn btn-primary btn-lg mr-2 mb-2 pagina-hija" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
			
				}

				$r .= '</div>';

			$r .= '</div>';

		} elseif(0 != $post->post_parent) {
			wp_reset_postdata();
			$current_post_id = get_the_ID();
			$args['post_parent'] = $post->post_parent;
			if ( $id ) $args['post_parent'] = $id;
			$args['post__not_in'] = array( $post->ID ); 
			$query = new WP_Query($args);

			$tag = get_the_title( $post->post_parent );

			if ($query->have_posts() && $query->found_posts > 1 ) {

				$r .= '<div class="paginas-hijas paginas-hermanas my-3">';

					$r .= '<p class="h4">' . __( 'Ver más', 'smn' ) . '</p>';

					$r .= '<div class="row">';

					while($query->have_posts() ) {
						$query->the_post();
						// if ($current_post_id == get_the_ID()) {
						// 	$r .= '<span class="btn btn-primary btn-sm mr-2 mb-2">'.get_the_title().'</span>';
						// } else {
						// 	$r .= '<a class="btn btn-outline-primary btn-sm mr-2 mb-2" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
						// }

						ob_start();
						get_template_part( 'loop-templates/content', '', ['tag' => $tag, 'hide_img' => $hide_img ] );
						$r .= ob_get_clean();

					}

					$r .= '</div>';

				$r .= '</div>';
			}
		}

		wp_reset_postdata();

	}

	return $r;

}
add_shortcode( 'paginas_hijas', 'paginas_hijas' );

add_filter('the_content', 'mostrar_paginas_hijas', 100);
function mostrar_paginas_hijas($content) {
	global $post;
	if (is_admin() || !is_singular() || !in_the_loop() || is_front_page() ) return $content;
	global $post;
	if (has_shortcode( $post->post_content, 'paginas_hijas' )) return $content;

	return $content . paginas_hijas( array() );

}

function get_redes_sociales() {

	$r = '';
	
    $redes_sociales = array(
        'email' => 'envelope',
        'whatsapp' => 'whatsapp',
        'linkedin' => 'linkedin',
        'twitter' => 'twitter',
        'facebook' => 'facebook',
        'instagram' => 'instagram',
        'youtube' => 'youtube',
        'skype' => 'skype',
        'pinterest' => 'pinterest',
        'flickr' => 'flickr',
        'blog' => 'rss',
    );
    $r .= '<div class="redes-sociales">';

    foreach ($redes_sociales as $red => $fa_class) {
    	$url = get_theme_mod( $red, '' );
    	if( '' != $url) {
	    	$r .= '<a href="'.$url.'" target="_blank" rel="nofollow" title="'.sprintf( __( 'Abrir %s en otra pestaña', 'smn' ), $red ).'"><span class="red-social '.$red.' fa fa-'.$fa_class.'"></span></a>';
    	}
    }

    // $r .= '<span class="follow-us">' . __( 'Follow us', 'smn' ) . '</span>';

    $r .= '</div>';

    return $r;

}
add_shortcode( 'redes_sociales', 'get_redes_sociales' );

function get_info_basica_privacidad() {

	$r = '';
	
	$text = get_theme_mod( 'info_privacidad_formularios', '' );
	if( '' != $text) {
		$r .= '<div class="info-basica-privacidad">';
	    	$r .= wpautop( $text );
		$r .= '</div>';
	}

    return $r;

}
add_shortcode( 'info_basica_privacidad', 'get_info_basica_privacidad' );

function sitemap() {
	$pt_args = array(
		'has_archive'		=> true,
	);
	$pts = get_post_types( $pt_args );
	// if (isset($pts['rl_gallery'])) unset $pts['rl_gallery'];
	$pts = array_merge( array('page'), $pts, array('post') );
	$r = '';

	foreach ($pts as $pt) {
		$pto = get_post_type_object( $pt );
		$taxonomies = get_object_taxonomies( $pt );

		$posts_args = array(
				'post_type'			=> $pt,
				'posts_per_page'	=> -1,
				'orderby'			=> 'menu_order',
				'order'				=> 'asc',
		);

		$posts_q = new WP_Query($posts_args);
		if ($posts_q->have_posts()) {

			$r .= '<h3 class="mt-3">'.$pto->labels->name.'</h3>';
			if ($taxonomies) {
				foreach ($taxonomies as $tax) {
					$terms = get_terms( array('taxonomy' => $tax) );
					foreach ($terms as $term) {
						$r .= '<a href="'.get_term_link( $term ).'" class="btn btn-dark btn-sm mr-1 mb-1">'.$term->name.'</a>';
					}
				}
			}

			while ($posts_q->have_posts()) { $posts_q->the_post();
				$r .= '<a href="'.get_the_permalink().'" class="btn btn-outline-primary btn-sm mr-1 mb-1">'.get_the_title().'</a>';
			}
		}

		wp_reset_postdata();
	}

	return $r;
}
add_shortcode( 'sitemap', 'sitemap' );

function testimonios() {
	ob_start();
	get_template_part( 'global-templates/carousel-testimonios' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'testimonios', 'testimonios' );

function smn_get_reusable_block( $block_id = '' ) {
    if ( empty( $block_id ) || (int) $block_id !== $block_id ) {
        return;
    }
    $content = get_post_field( 'post_content', $block_id );
    return apply_filters( 'the_content', $content );
}

function smn_reusable_block( $block_id = '' ) {
    echo smn_get_reusable_block( $block_id );
}

function smn_reusable_block_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );
    if ( empty( $id ) || (int) $id !== $id ) {
        return;
    }
    $content = smn_get_reusable_block( $id );
    return $content;
}
add_shortcode( 'reusable', 'smn_reusable_block_shortcode' );

function sumun_shortcode_subcategorias() {
	ob_start();
	get_template_part( 'global-templates/subcategories' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'subcategorias', 'sumun_shortcode_subcategorias' );

function sumun_shortcode_blog() {
	ob_start();
	get_template_part( 'global-templates/blog' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'blog', 'sumun_shortcode_blog' );

function sumun_shortcode_casos_de_exito() {
	ob_start();
	get_template_part( 'global-templates/casos-de-exito' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'casos_de_exito', 'sumun_shortcode_casos_de_exito' );

function smn_widget_reserva_demo() {
	
	$r = '<img src="'.get_stylesheet_directory_uri().'/img/widget-reserva-demo.png" />';

	return $r;
}
add_shortcode( 'widget_reserva_demo', 'smn_widget_reserva_demo' );