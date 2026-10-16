<?php
/**
 * Plugin Name: Cuerpo Libre - Masonry Gallery Extension
 * Plugin URI:  https://cuerpolibre.cl
 * Description: Añade una opción toggle "Activar Formato Masonry" a la barra lateral del bloque Galería nativo de Gutenberg.
 * Version:     1.0.0
 * Author:      Cuerpo Libre
 * Author URI:  https://cuerpolibre.cl
 * Text Domain: cuerpolibre-masonry
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'CL_MASONRY_VERSION', '1.0.0' );
define( 'CL_MASONRY_PATH', plugin_dir_path( __FILE__ ) );
define( 'CL_MASONRY_URL', plugin_dir_url( __FILE__ ) );

/**
 * Enqueue Block Editor Assets (Gutenberg sidebar extension)
 */
function cl_masonry_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'cl-masonry-editor-script',
        CL_MASONRY_URL . 'assets/js/editor-masonry.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-hooks', 'wp-compose' ),
        CL_MASONRY_VERSION,
        true
    );

    wp_enqueue_style(
        'cl-masonry-editor-style',
        CL_MASONRY_URL . 'assets/css/masonry-gallery.css',
        array(),
        CL_MASONRY_VERSION
    );
}
add_action( 'enqueue_block_editor_assets', 'cl_masonry_enqueue_block_editor_assets' );

/**
 * Enqueue Frontend Assets
 */
function cl_masonry_enqueue_frontend_assets() {
    wp_enqueue_style(
        'cl-masonry-frontend-style',
        CL_MASONRY_URL . 'assets/css/masonry-gallery.css',
        array(),
        CL_MASONRY_VERSION
    );

    wp_enqueue_script(
        'cl-masonry-frontend-script',
        CL_MASONRY_URL . 'assets/js/frontend-masonry.js',
        array(),
        CL_MASONRY_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'cl_masonry_enqueue_frontend_assets' );

/**
 * Auto-activate plugin in WordPress
 */
function cl_masonry_auto_activate() {
    $active_plugins = get_option( 'active_plugins', array() );
    $plugin_file    = 'cuerpolibre-masonry-gallery/cuerpolibre-masonry-gallery.php';

    if ( ! in_array( $plugin_file, $active_plugins, true ) ) {
        $active_plugins[] = $plugin_file;
        update_option( 'active_plugins', $active_plugins );
    }
}
add_action( 'init', 'cl_masonry_auto_activate' );
