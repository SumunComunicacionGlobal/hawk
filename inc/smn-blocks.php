<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( function_exists( 'register_block_style' ) ) {

    register_block_style(
        'core/cover',
        array(
            'name'         => 'image-header',
            'label'        => __( 'Cabecera', 'smn-admin' ),
            'is_default'   => false,
        )
    );
    
    register_block_style(
        'core/button',
        array(
            'name'         => 'arrow-link',
            'label'        => __( 'Con flecha', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/columns',
        array(
            'name'         => 'gapless',
            'label'        => __( 'Sin espacio', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/list',
        array(
            'name'         => 'list-unstyled',
            'label'        => __( 'Sin viñetas', 'smn-admin' ),
            'is_default'   => false,
        )
    );
       
    $display_text_block_types = array(
        'core/paragraph',
        'core/heading',
    );

    foreach( $display_text_block_types as $block_type ) {

        for ($i=1; $i <= 6; $i++) { 

            register_block_style(
                $block_type,
                array(
                    'name'         => 'h' . $i,
                    'label'        => sprintf( __( 'Imita un h%s', 'smn-admin' ), $i ),
                    'is_default'   => false,
                )
            );

        }
            
        for ($i=1; $i <= 4; $i++) { 

            register_block_style(
                $block_type,
                array(
                    'name'         => 'display-' . $i,
                    'label'        => sprintf( __( 'Display %s', 'smn-admin' ), $i ),
                    'is_default'   => false,
                )
            );

        }
            
    }

    register_block_style(
        'core/praragrap',
        array(
            'name'         => 'cifra-circulo',
            'label'        => __( 'Cifra círculo', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    $carousel_block_types = array(
        'core/group',
        'core/gallery',
    );

    foreach( $carousel_block_types as $block_type ) {

        register_block_style(
            $block_type,
            array(
                'name'         => 'slick-carousel',
                'label'        => sprintf( __( 'Carrusel', 'smn-admin' ), $i ),
                'is_default'   => false,
            )
        );
    }
            

}

add_filter( 'render_block', 'remove_is_style_prefix', 10, 2 );
function remove_is_style_prefix( $block_content, $block ) {

    if ( isset( $block['attrs']['className'] ) ) {
    
        $components = array(
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'display-1',
            'display-2',
            'display-3',
            'display-4',
            'lead',
            'list-unstyled',
        );

        $prefixed_components = array();
    
        foreach ( $components as $component ) {
            $prefixed_components[] = 'is-style-' . $component;
        }

        $block_content = str_replace(
            $prefixed_components,
            $components,
            $block_content
        );

    }

    
    // echo '<pre class="bg-light mb-5">'; print_r( $block ); echo '</pre><p class="text-center">***</p>';
    // echo '<pre class="bg-light mb-5">'; print_r( $block_content ); echo '</pre><p class="text-center">***</p>';
    
    return $block_content;
}

// add_action('acf/init', 'smn_acf_blocks_init');
// function smn_acf_blocks_init() {

//     // Check function exists.
//     if( function_exists('acf_register_block_type') ) {

//         // Register a testimonial block.
//         acf_register_block_type(array(
//             'name'              => 'testimonial',
//             'title'             => __('Testimonio', 'smn-admin'),
//             // 'description'       => __('', 'smn-admin'),
//             'render_template'   => 'block-templates/testimonial.php',
//             'category'          => 'formatting',
//         ));
//     }
// }

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    register_block_type( get_stylesheet_directory() . '/block-templates/timeline' );
}

add_filter( 'render_block', 'list_block_wrapper', 10, 2 );
function list_block_wrapper( $block_content, $block ) {
    if ( $block['blockName'] === 'core/list' ) {
        $block_content = str_replace( 
            array( '<ul class="', '<ol class="'), 
            array( '<ul class="wp-block-list ', '<ol class="wp-block-list '), $block_content );
        }
        $block_content = str_replace( 
            array( '<ul>', '<ol>'), 
            array( '<ul class="wp-block-list">', '<ol class="wp-block-list">'), $block_content );

    return $block_content;
}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_636302428e848',
        'title' => 'Block: timeline',
        'fields' => array(
            array(
                'key' => 'field_636302425f58b',
                'label' => 'Elemento del timeline',
                'name' => 'timeline_item',
                'aria-label' => '',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'block',
                'pagination' => 0,
                'min' => 0,
                'max' => 0,
                'collapsed' => '',
                'button_label' => 'Añadir elemento',
                'rows_per_page' => 20,
                'sub_fields' => array(
                    array(
                        'key' => 'field_636302895f58c',
                        'label' => 'Título',
                        'name' => 'timeline_item_title',
                        'aria-label' => '',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'parent_repeater' => 'field_636302425f58b',
                    ),
                    array(
                        'key' => 'field_636302c25f58e',
                        'label' => 'Imagen',
                        'name' => 'timeline_item_image',
                        'aria-label' => '',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '30',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                        'preview_size' => 'medium',
                        'parent_repeater' => 'field_636302425f58b',
                    ),
                    array(
                        'key' => 'field_6363032b5f58f',
                        'label' => 'Destacado',
                        'name' => 'timeline_item_featured',
                        'aria-label' => '',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '20',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 0,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                        'ui' => 1,
                        'parent_repeater' => 'field_636302425f58b',
                    ),
                    array(
                        'key' => 'field_636302a75f58d',
                        'label' => 'Contenido',
                        'name' => 'timeline_item_content',
                        'aria-label' => '',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'visual',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                        'parent_repeater' => 'field_636302425f58b',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/timeline',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
endif;		