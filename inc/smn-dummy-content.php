<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function random_image_id() {
    $min = 133;
    $max = 145;

    return rand($min, $max);
}

add_filter( 'the_content', 'filter_content', 10, 1 );
add_filter( 'term_description', 'filter_content', 10, 1 );
function filter_content( $content ) { 

    if (is_admin()) return $content;

    if ('' == $content ) {
        $content .= wpautop( '<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' ); 

        if ( is_singular('producto') ) {
        	$content .= '<img class="my-3" src="'.get_stylesheet_directory_uri().'/img/tabla-producto.png" />';
        	$content .= '<img class="my-3" src="'.get_stylesheet_directory_uri().'/img/esquema-producto.png" />';
        }
    }

    return $content;
} 
function lorem_ipsum_shortcode() {
    $r = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    return $r;
}
add_shortcode('lorem_ipsum', 'lorem_ipsum_shortcode');

add_filter( 'default_post_metadata', 'term_thumbnail_id_placeholder', 10, 5 );
add_filter( 'default_term_metadata', 'term_thumbnail_id_placeholder', 10, 5 );
function term_thumbnail_id_placeholder( $value, $object_id, $meta_key, $single, $meta_type ) {

    if ( is_admin() ) return $value;

    switch ( $meta_key ) {
        case 'thumbnail_id':
        case '_thumbnail_id':
            return random_image_id();

            break;
        
        default:
            return $value;
            break;
    }

    return $value;

}

function random_image_url($dir = 'uploads')
{
    $dir = get_stylesheet_directory() . '/img/random-image/';
    $files = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    $file = array_rand($files);
    $url = str_replace(get_stylesheet_directory(), get_stylesheet_directory_uri(), $files[$file]);
    return $url;
}

function alterImageSRC($image, $attachment_id, $size, $icon)
{        
    if ( $image ) return $image;

    $image[0] = random_image_url();
    $image[1] = 500;
    $image[2] = 500;
    return $image;
}
add_filter('wp_get_attachment_image_src', 'alterImageSRC', 10, 4);