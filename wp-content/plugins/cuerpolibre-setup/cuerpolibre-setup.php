<?php
/**
 * Plugin Name: Cuerpo Libre — Setup Inicial
 * Description: Crea las páginas del sitio, asigna templates, configura el menú principal y establece la portada estática. Desactiva y elimina este plugin después de ejecutarlo.
 * Version: 1.0
 * Author: Gato Villano
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ───────────────────────────────────────────────────
   Ejecutar el setup cuando se activa el plugin
─────────────────────────────────────────────────── */
register_activation_hook( __FILE__, 'cl_setup_run' );

/* También disponible vía URL con ?cl_setup=1 (por si acaso) */
add_action( 'init', function() {
    if ( isset( $_GET['cl_setup'] ) && $_GET['cl_setup'] === '1' && current_user_can( 'manage_options' ) ) {
        cl_setup_run();
        wp_die( '<h2 style="font-family:monospace">✅ Setup completado. <a href="' . admin_url() . '">Ir al panel</a></h2>' );
    }
});

/* ───────────────────────────────────────────────────
   FUNCIÓN PRINCIPAL DE SETUP
─────────────────────────────────────────────────── */
function cl_setup_run() {

    /* ── 1. DEFINIR PÁGINAS ── */
    $pages = array(

        'home' => array(
            'title'    => 'Inicio',
            'slug'     => 'inicio',
            'template' => '', // front-page.php se usa por defecto para la portada
            'content'  => '',
        ),

        'about' => array(
            'title'    => 'Acerca de mí',
            'slug'     => 'acerca-de-mi',
            'template' => 'page-about.php',
            'content'  => '',
        ),

        'project' => array(
            'title'    => 'El Proyecto',
            'slug'     => 'el-proyecto',
            'template' => 'page-project.php',
            'content'  => '',
        ),

        'gallery' => array(
            'title'    => 'Galería',
            'slug'     => 'galeria',
            'template' => 'page-gallery.php',
            'content'  => '',
        ),

        'session' => array(
            'title'    => 'Haz tu Sesión',
            'slug'     => 'haz-tu-sesion',
            'template' => 'page-session.php',
            'content'  => '',
        ),
    );

    $created_ids = array();

    /* ── 2. CREAR / ACTUALIZAR PÁGINAS ── */
    foreach ( $pages as $key => $page ) {

        // Buscar si ya existe una página con ese slug
        $existing = get_page_by_path( $page['slug'], OBJECT, 'page' );

        if ( $existing ) {
            // Actualizarla por si acaso
            $page_id = $existing->ID;
            wp_update_post( array(
                'ID'         => $page_id,
                'post_title' => $page['title'],
                'post_status'=> 'publish',
            ) );
        } else {
            // Crear nueva página
            $page_id = wp_insert_post( array(
                'post_title'   => $page['title'],
                'post_name'    => $page['slug'],
                'post_content' => $page['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            ) );
        }

        if ( ! is_wp_error( $page_id ) ) {
            // Asignar template de página
            if ( ! empty( $page['template'] ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page['template'] );
            }
            $created_ids[ $key ] = $page_id;
        }
    }

    /* ── 3. CONFIGURAR PORTADA ESTÁTICA ── */
    if ( isset( $created_ids['home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $created_ids['home'] );
        // La front-page.php se activa automáticamente cuando show_on_front=page
    }

    /* ── 4. CREAR / ACTUALIZAR MENÚ PRINCIPAL ── */
    $menu_name = 'Menú Principal';
    $menu_location = 'menu-1'; // registrado en functions.php

    // Verificar si ya existe el menú
    $menu_obj  = wp_get_nav_menu_object( $menu_name );
    $menu_id   = $menu_obj ? $menu_obj->term_id : wp_create_nav_menu( $menu_name );

    if ( ! is_wp_error( $menu_id ) ) {

        // Limpiar items existentes del menú
        $existing_items = wp_get_nav_menu_items( $menu_id );
        if ( $existing_items ) {
            foreach ( $existing_items as $item ) {
                wp_delete_post( $item->ID, true );
            }
        }

        // Orden de páginas en el menú
        $menu_order = array(
            array( 'key' => 'home',    'label' => 'Inicio' ),
            array( 'key' => 'about',   'label' => 'Acerca de mí' ),
            array( 'key' => 'project', 'label' => 'El Proyecto' ),
            array( 'key' => 'gallery', 'label' => 'Galería' ),
            array( 'key' => 'session', 'label' => 'Haz tu Sesión' ),
        );

        foreach ( $menu_order as $i => $item ) {
            if ( isset( $created_ids[ $item['key'] ] ) ) {
                wp_update_nav_menu_item( $menu_id, 0, array(
                    'menu-item-title'     => $item['label'],
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $created_ids[ $item['key'] ],
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $i + 1,
                ) );
            }
        }

        // Asignar el menú a la ubicación 'menu-1' (Primary)
        $locations = get_theme_mod( 'nav_menu_locations', array() );
        $locations[ $menu_location ] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    /* ── 5. CONFIGURACIONES GENERALES DEL SITIO ── */
    update_option( 'blogname',        'Cuerpo Libre' );
    update_option( 'blogdescription', 'Fotografía Artística' );
    update_option( 'permalink_structure', '/%postname%/' );          // URLs limpias
    flush_rewrite_rules();

    /* ── 6. LOG DE RESULTADOS ── */
    $log = array(
        'timestamp'   => current_time( 'mysql' ),
        'pages'       => $created_ids,
        'menu_id'     => $menu_id,
        'front_page'  => get_option( 'page_on_front' ),
    );
    update_option( 'cl_setup_log', $log );
}

/* ───────────────────────────────────────────────────
   ADMIN NOTICE: Mostrar resultado en el panel
─────────────────────────────────────────────────── */
add_action( 'admin_notices', function() {
    $log = get_option( 'cl_setup_log' );
    if ( ! $log ) return;
    ?>
    <div class="notice notice-success is-dismissible">
        <p>
            <strong>✅ Cuerpo Libre Setup completado.</strong><br>
            Páginas creadas: <strong><?php echo implode( ', ', array_keys( $log['pages'] ) ); ?></strong>.
            Portada configurada. Menú principal enlazado.<br>
            <a href="<?php echo esc_url( home_url('/') ); ?>" target="_blank">Ver el sitio →</a>
            &nbsp;|&nbsp;
            <a href="<?php echo admin_url('nav-menus.php'); ?>">Editar menú</a>
            &nbsp;|&nbsp;
            <em>Puedes desactivar y eliminar este plugin ahora.</em>
        </p>
    </div>
    <?php

    // Mostrar solo una vez
    delete_option( 'cl_setup_log' );
});
