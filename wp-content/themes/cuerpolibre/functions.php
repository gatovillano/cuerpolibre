<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme Setup
 */
function cuerpolibre_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ) );

    // Logo support (wide/flexible)
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'menu-1' => esc_html__( 'Primary', 'cuerpolibre' ),
        'footer-menu' => esc_html__( 'Footer', 'cuerpolibre' ),
    ) );
}
add_action( 'after_setup_theme', 'cuerpolibre_setup' );

/**
 * Enqueue styles and scripts
 */
function cuerpolibre_scripts() {
    // Main stylesheet
    wp_enqueue_style( 'cuerpolibre-style', get_stylesheet_uri(), array(), time() ); // Use time() for development to prevent caching

    // Google Fonts: Cormorant Garamond (elegant serif) + Inter (modern sans)
    wp_enqueue_style(
        'cuerpolibre-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,200;0,300;0,400;0,600;1,200;1,300;1,400&family=Inter:wght@300;400;500&display=swap',
        array(),
        null
    );

    // Main JS
    wp_enqueue_script(
        'cuerpolibre-main',
        get_template_directory_uri() . '/js/main.js',
        array(),
        time(),
        true
    );

    // Localize AJAX URL
    wp_localize_script( 'cuerpolibre-main', 'cl_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'cuerpolibre_scripts' );

/**
 * Elementor full-width support
 */
function cuerpolibre_elementor_support() {
    add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'cuerpolibre_elementor_support' );

/**
 * Register Elementor widget categories
 */
function cuerpolibre_elementor_widgets_categories( $elements_manager ) {
    $elements_manager->add_category(
        'cuerpolibre',
        array(
            'title' => __( 'Cuerpo Libre', 'cuerpolibre' ),
            'icon'  => 'fa fa-camera',
        )
    );
}
add_action( 'elementor/elements/categories_registered', 'cuerpolibre_elementor_widgets_categories' );

/**
 * Register Elementor custom widgets
 */
function cuerpolibre_register_elementor_widgets( $widgets_manager ) {
    // Future custom widgets go here
}
add_action( 'elementor/widgets/register', 'cuerpolibre_register_elementor_widgets' );

/**
 * Remove default WordPress styles (kept block library for Gutenberg layout support)
 */
function cuerpolibre_remove_block_styles() {
    // Keep wp-block-library and global-styles enabled for Gutenberg galleries and layout blocks.
}
add_action( 'wp_enqueue_scripts', 'cuerpolibre_remove_block_styles', 100 );

/**
 * Register 'Galerías' Custom Post Type
 */
function cuerpolibre_register_gallery_cpt() {
    $labels = array(
        'name'                  => _x( 'Galerías', 'Post Type General Name', 'cuerpolibre' ),
        'singular_name'         => _x( 'Galería', 'Post Type Singular Name', 'cuerpolibre' ),
        'menu_name'             => __( 'Galerías', 'cuerpolibre' ),
        'name_admin_bar'        => __( 'Galería', 'cuerpolibre' ),
        'archives'              => __( 'Archivos de Galería', 'cuerpolibre' ),
        'attributes'            => __( 'Atributos de Galería', 'cuerpolibre' ),
        'parent_item_colon'     => __( 'Galería padre:', 'cuerpolibre' ),
        'all_items'             => __( 'Todas las Galerías', 'cuerpolibre' ),
        'add_new_item'          => __( 'Añadir nueva Galería', 'cuerpolibre' ),
        'add_new'               => __( 'Añadir nueva', 'cuerpolibre' ),
        'new_item'              => __( 'Nueva Galería', 'cuerpolibre' ),
        'edit_item'             => __( 'Editar Galería', 'cuerpolibre' ),
        'update_item'           => __( 'Actualizar Galería', 'cuerpolibre' ),
        'view_item'             => __( 'Ver Galería', 'cuerpolibre' ),
        'view_items'            => __( 'Ver Galerías', 'cuerpolibre' ),
        'search_items'          => __( 'Buscar Galería', 'cuerpolibre' ),
        'not_found'             => __( 'No se encontraron galerías', 'cuerpolibre' ),
        'not_found_in_trash'    => __( 'No se encontraron galerías en la papelera', 'cuerpolibre' ),
        'featured_image'        => __( 'Imagen de portada', 'cuerpolibre' ),
        'set_featured_image'    => __( 'Establecer imagen de portada', 'cuerpolibre' ),
        'remove_featured_image' => __( 'Eliminar imagen de portada', 'cuerpolibre' ),
        'use_featured_image'    => __( 'Usar como imagen de portada', 'cuerpolibre' ),
        'insert_into_item'      => __( 'Insertar en la galería', 'cuerpolibre' ),
        'uploaded_to_this_item' => __( 'Subido a esta galería', 'cuerpolibre' ),
        'items_list'            => __( 'Lista de galerías', 'cuerpolibre' ),
        'items_list_navigation' => __( 'Navegación de lista de galerías', 'cuerpolibre' ),
        'filter_items_list'     => __( 'Filtrar lista de galerías', 'cuerpolibre' ),
    );
    $args = array(
        'label'                 => __( 'Galería', 'cuerpolibre' ),
        'description'           => __( 'Colecciones de fotografía artística', 'cuerpolibre' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-gallery',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'galeria-artistica', 'with_front' => false ),
    );
    register_post_type( 'cuerpolibre_gallery', $args );
}
add_action( 'init', 'cuerpolibre_register_gallery_cpt', 0 );

// Force flush rewrite rules on theme activation
function cuerpolibre_flush_rules_on_activate() {
    cuerpolibre_register_gallery_cpt();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cuerpolibre_flush_rules_on_activate' );

/**
 * AUTO-SETUP: Ensure pages and menus are created and linked correctly.
 */
function cuerpolibre_auto_setup() {
    $pages_to_create = array(
        'inicio'        => array('title' => 'Inicio',        'template' => ''), 
        'acerca-de-mi'  => array('title' => 'Acerca de mí',  'template' => 'page-about.php'),
        'el-proyecto'   => array('title' => 'El Proyecto',   'template' => 'page-project.php'),
        'manifiesto'    => array('title' => 'Manifiesto',    'template' => 'page-manifiesto.php'),
        'galeria'       => array('title' => 'Galería',       'template' => 'page-gallery.php'),
        'haz-tu-sesion' => array('title' => 'Haz tu Sesión', 'template' => 'page-session.php'),
        'politica-de-privacidad' => array('title' => 'Política de Privacidad', 'template' => 'page-privacy.php'),
        'inscripcion-y-consentimiento' => array('title' => 'Inscripción y Consentimiento', 'template' => 'page-consentimiento.php'),
    );

    $needs_flush = false;

    foreach ( $pages_to_create as $slug => $data ) {
        $existing = get_page_by_path( $slug, OBJECT, 'page' );
        
        if ( ! $existing ) {
            $page_id = wp_insert_post( array(
                'post_title'   => $data['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ) );
            if ( ! is_wp_error( $page_id ) ) {
                if ( $data['template'] ) {
                    update_post_meta( $page_id, '_wp_page_template', $data['template'] );
                }
                $needs_flush = true;
            }
        } else {
            // Ensure template is set correctly even if page exists
            if ( $data['template'] ) {
                update_post_meta( $existing->ID, '_wp_page_template', $data['template'] );
            }
            if ( $existing->post_status === 'trash' ) {
                wp_untrash_post( $existing->ID );
                wp_update_post( array( 'ID' => $existing->ID, 'post_status' => 'publish' ) );
                $needs_flush = true;
            }
        }
    }

    if ( isset( $pages_to_create['inicio'] ) ) {
        $inicio = get_page_by_path( 'inicio', OBJECT, 'page' );
        if ( $inicio && (int)get_option( 'page_on_front' ) !== (int)$inicio->ID ) {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $inicio->ID );
            $needs_flush = true;
        }
    }

    if ( get_option('permalink_structure') !== '/%postname%/' ) {
        update_option('permalink_structure', '/%postname%/');
        $needs_flush = true;
    }

    // Automatically add Manifiesto to custom menus if they exist but don't have it
    $manifiesto_page = get_page_by_path( 'manifiesto', OBJECT, 'page' );
    if ( $manifiesto_page ) {
        $locations = get_nav_menu_locations();
        
        // Add to main menu (menu-1)
        if ( isset( $locations['menu-1'] ) ) {
            $menu_id = $locations['menu-1'];
            $menu_items = wp_get_nav_menu_items( $menu_id );
            $has_manifiesto = false;
            if ( $menu_items ) {
                foreach ( $menu_items as $item ) {
                    if ( $item->object === 'page' && (int)$item->object_id === (int)$manifiesto_page->ID ) {
                        $has_manifiesto = true;
                        break;
                    }
                }
            }
            if ( ! $has_manifiesto ) {
                // Find order/position (place it after "El Proyecto" or before "Galería")
                $proyecto_page = get_page_by_path( 'el-proyecto', OBJECT, 'page' );
                $menu_order = 0;
                if ( $proyecto_page && $menu_items ) {
                    foreach ( $menu_items as $item ) {
                        if ( $item->object === 'page' && (int)$item->object_id === (int)$proyecto_page->ID ) {
                            $menu_order = $item->menu_order + 1;
                            break;
                        }
                    }
                }
                wp_update_nav_menu_item( $menu_id, 0, array(
                    'menu-item-title'     => 'Manifiesto',
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $manifiesto_page->ID,
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $menu_order,
                ) );
            }
        }

        // Add to footer menu (footer-menu)
        if ( isset( $locations['footer-menu'] ) ) {
            $menu_id = $locations['footer-menu'];
            $menu_items = wp_get_nav_menu_items( $menu_id );
            $has_manifiesto = false;
            if ( $menu_items ) {
                foreach ( $menu_items as $item ) {
                    if ( $item->object === 'page' && (int)$item->object_id === (int)$manifiesto_page->ID ) {
                        $has_manifiesto = true;
                        break;
                    }
                }
            }
            if ( ! $has_manifiesto ) {
                wp_update_nav_menu_item( $menu_id, 0, array(
                    'menu-item-title'     => 'Manifiesto',
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $manifiesto_page->ID,
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                ) );
            }
        }
    }

    if ( $needs_flush ) {
        flush_rewrite_rules();
    }
}
add_action( 'init', 'cuerpolibre_auto_setup' );

/**
 * Virtual Privacy Page Handler
 * Bypasses 404 if the page record is missing in the database
 */
add_action('template_redirect', function() {
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    // Handle both root and common subdirectory installs
    if ($path === 'politica-de-privacidad' || preg_match('/\/politica-de-privacidad$/', $path)) {
        $template = get_template_directory() . '/page-privacy.php';
        if (file_exists($template)) {
            include $template;
            exit;
        }
    }
});

/**
 * AJAX Booking Form Submission
 */
function cuerpolibre_handle_booking() {
    // Basic verification
    if ( ! isset( $_POST['email'] ) || ! isset( $_POST['name'] ) ) {
        wp_send_json_error( array( 'message' => 'Faltan datos obligatorios.' ) );
    }

    $name    = sanitize_text_field( $_POST['name'] );
    $email   = sanitize_email( $_POST['email'] );
    $phone   = sanitize_text_field( $_POST['phone'] );
    $date    = sanitize_text_field( $_POST['meeting_date'] ); // Note: JS will use meeting_date
    $session = sanitize_text_field( $_POST['session_type'] );
    $message = sanitize_textarea_field( $_POST['message'] );

    $to      = 'stola@disroot.org';
    $subject = 'Nueva Reserva: ' . $name;
    
    $body    = "Has recibido una nueva solicitud de reserva desde Cuerpo Libre.\n\n";
    $body   .= "Nombre: $name\n";
    $body   .= "Email: $email\n";
    $body   .= "Teléfono: $phone\n";
    $body   .= "Fecha reunión previa: $date\n";
    $body   .= "Tipo de sesión: $session\n\n";
    $body   .= "Mensaje:\n$message\n";

    $headers = array( 
        'Content-Type: text/plain; charset=UTF-8', 
        "From: Cuerpo Libre Web <wordpress@cuerpolibre.cl>", 
        "Reply-To: $name <$email>" 
    );

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => '¡Solicitud enviada con éxito!' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Hubo un error al enviar el correo. Por favor intenta más tarde.' ) );
    }
}
add_action( 'wp_ajax_submit_booking', 'cuerpolibre_handle_booking' );
add_action( 'wp_ajax_nopriv_submit_booking', 'cuerpolibre_handle_booking' );

/**
 * Configure PHPMailer to use external SMTP (fixes "sendmail not found" in Docker)
 * Define SMTP credentials in wp-config.php:
 *   define( 'CL_SMTP_HOST',     'disroot.org' );
 *   define( 'CL_SMTP_USER',     'stola@disroot.org' );
 *   define( 'CL_SMTP_PASS',     'your_password_here' );
 *   define( 'CL_SMTP_PORT',     587 );
 */
add_action( 'phpmailer_init', function( $phpmailer ) {
    if ( ! defined('CL_SMTP_HOST') || ! defined('CL_SMTP_USER') || ! defined('CL_SMTP_PASS') ) {
        return; // Fall back to default if not configured
    }
    $phpmailer->isSMTP();
    $phpmailer->Host       = CL_SMTP_HOST;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = defined('CL_SMTP_PORT') ? CL_SMTP_PORT : 587;
    $phpmailer->Username   = CL_SMTP_USER;
    $phpmailer->Password   = CL_SMTP_PASS;
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->From       = CL_SMTP_USER;
    $phpmailer->FromName   = 'Cuerpo Libre Web';
} );

add_action('init', 'flush_rewrite_rules', 999);

/**
 * Get random vertical images from photography galleries
 */
function get_random_vertical_gallery_images( $count = 8 ) {
    $exclude_ids = array();
    if ( function_exists('cl_is_user_subscribed') && ! cl_is_user_subscribed() ) {
        // Query IDs of all restricted galleries
        $restricted_galleries = get_posts( array(
            'post_type'      => 'cuerpolibre_gallery',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'meta_query'     => array(
                array(
                    'key'     => '_cl_restricted',
                    'value'     => '1',
                    'compare' => '=',
                ),
            ),
        ) );
        if ( ! empty( $restricted_galleries ) ) {
            $exclude_ids = $restricted_galleries;
        }
    }

    $galleries = get_posts( array(
        'post_type'      => 'cuerpolibre_gallery',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'post__not_in'   => $exclude_ids,
    ) );

    if ( empty( $galleries ) ) return [];

    $args = array(
        'post_type'       => 'attachment',
        'post_mime_type'  => 'image',
        'post_status'     => 'inherit',
        'posts_per_page'  => 300, // Get a large enough pool
        'post_parent__in' => $galleries,
        'orderby'         => 'rand',
    );

    $query = new WP_Query( $args );
    $images = [];

    foreach ( $query->posts as $post ) {
        $meta = wp_get_attachment_metadata( $post->ID );
        if ( $meta && isset( $meta['width'], $meta['height'] ) ) {
            if ( $meta['height'] > $meta['width'] ) {
                $images[] = array(
                    'url' => wp_get_attachment_image_url( $post->ID, 'large' ),
                    'id'  => $post->ID,
                );
            }
        }
        if ( count( $images ) >= $count ) break;
    }

    return $images;
}

/**
 * Register 'Inscripciones' Custom Post Type for Consent forms
 */
function cuerpolibre_register_consent_cpt() {
    $labels = array(
        'name'                  => _x( 'Inscripciones', 'Post Type General Name', 'cuerpolibre' ),
        'singular_name'         => _x( 'Inscripción', 'Post Type Singular Name', 'cuerpolibre' ),
        'menu_name'             => __( 'Inscripciones', 'cuerpolibre' ),
        'name_admin_bar'        => __( 'Inscripción', 'cuerpolibre' ),
        'all_items'             => __( 'Todas las Inscripciones', 'cuerpolibre' ),
        'add_new_item'          => __( 'Añadir nueva Inscripción', 'cuerpolibre' ),
        'edit_item'             => __( 'Ver Inscripción', 'cuerpolibre' ),
        'view_item'             => __( 'Ver Inscripción', 'cuerpolibre' ),
        'search_items'          => __( 'Buscar Inscripciones', 'cuerpolibre' ),
        'not_found'             => __( 'No se encontraron inscripciones', 'cuerpolibre' ),
        'not_found_in_trash'    => __( 'No se encontraron inscripciones en la papelera', 'cuerpolibre' ),
    );
    $args = array(
        'label'                 => __( 'Inscripción', 'cuerpolibre' ),
        'description'           => __( 'Inscripciones y Consentimientos del Encuentro Corporal', 'cuerpolibre' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'hierarchical'          => false,
        'public'                => false, // only accessible in dashboard
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-welcome-write-blog',
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => false,
    );
    register_post_type( 'cl_consent_form', $args );
}
add_action( 'init', 'cuerpolibre_register_consent_cpt', 0 );

/**
 * Configure columns for cl_consent_form in admin list view
 */
add_filter( 'manage_cl_consent_form_posts_columns', 'cuerpolibre_set_consent_columns' );
function cuerpolibre_set_consent_columns($columns) {
    $new_columns = array(
        'cb'        => $columns['cb'],
        'title'     => __( 'Participante', 'cuerpolibre' ),
        'actividad' => __( 'Actividad', 'cuerpolibre' ),
        'edad'      => __( 'Edad', 'cuerpolibre' ),
        'contacto'  => __( 'Contacto', 'cuerpolibre' ),
        'date'      => $columns['date'],
    );
    return $new_columns;
}

add_action( 'manage_cl_consent_form_posts_custom_column', 'cuerpolibre_consent_column_content', 10, 2 );
function cuerpolibre_consent_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'actividad':
            $actividad = get_post_meta( $post_id, 'cl_actividad', true );
            echo '<span id="cl_actividad_' . $post_id . '">' . esc_html( $actividad ? $actividad : '—' ) . '</span>';
            break;
        case 'edad':
            echo esc_html( get_post_meta( $post_id, 'cl_edad', true ) );
            break;
        case 'contacto':
            echo esc_html( get_post_meta( $post_id, 'cl_contacto', true ) );
            break;
    }
}

/**
 * Make 'Actividad' column sortable
 */
add_filter( 'manage_edit-cl_consent_form_sortable_columns', 'cuerpolibre_consent_sortable_columns' );
function cuerpolibre_consent_sortable_columns( $columns ) {
    $columns['actividad'] = 'actividad';
    return $columns;
}

/**
 * Handle ordering by 'Actividad' meta key
 */
add_action( 'pre_get_posts', 'cuerpolibre_consent_orderby' );
function cuerpolibre_consent_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( 'cl_consent_form' === $query->get( 'post_type' ) && 'actividad' === $query->get( 'orderby' ) ) {
        $query->set( 'meta_key', 'cl_actividad' );
        $query->set( 'orderby', 'meta_value' );
    }
}

/**
 * Render fields in the Quick Edit panel
 */
add_action( 'quick_edit_custom_box', 'cuerpolibre_consent_quick_edit_fields', 10, 2 );
function cuerpolibre_consent_quick_edit_fields( $column_name, $post_type ) {
    if ( 'cl_consent_form' !== $post_type ) {
        return;
    }
    if ( 'actividad' === $column_name ) {
        wp_nonce_field( 'cuerpolibre_consent_quick_edit_nonce', 'cuerpolibre_consent_quick_edit_nonce' );
        ?>
        <fieldset class="inline-edit-col-left">
            <div class="inline-edit-col">
                <label>
                    <span class="title">Actividad</span>
                    <span class="input-text-wrap">
                        <input type="text" name="cl_actividad" class="ptitle" value="" placeholder="Ej: Taller A, Taller B...">
                    </span>
                </label>
            </div>
        </fieldset>
        <?php
    }
}

/**
 * Injects Javascript in the dashboard footer to populate Quick Edit fields
 */
add_action( 'admin_footer', 'cuerpolibre_consent_quick_edit_js' );
function cuerpolibre_consent_quick_edit_js() {
    global $current_screen;
    if ( ! $current_screen || 'cl_consent_form' !== $current_screen->post_type || 'edit' !== $current_screen->base ) {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        if (typeof inlineEditPost !== 'undefined') {
            var wp_inline_edit = inlineEditPost.edit;
            inlineEditPost.edit = function( id ) {
                wp_inline_edit.apply( this, arguments );

                var post_id = 0;
                if ( typeof( id ) === 'object' ) {
                    post_id = parseInt( this.getId( id ) );
                }
                
                if ( post_id > 0 ) {
                    var edit_row = $( '#edit-' + post_id );
                    var actividad = $( '#cl_actividad_' + post_id ).text();
                    if ( actividad === '—' ) {
                        actividad = '';
                    }
                    edit_row.find( 'input[name="cl_actividad"]' ).val( actividad );
                }
            };
        }
    });
    </script>
    <?php
}

/**
 * Register Metabox for cl_consent_form details
 */
add_action( 'add_meta_boxes', 'cuerpolibre_add_consent_metabox' );
function cuerpolibre_add_consent_metabox() {
    add_meta_box(
        'cl_consent_details',
        'Detalles de la Inscripción y Consentimiento',
        'cuerpolibre_consent_metabox_callback',
        'cl_consent_form',
        'normal',
        'high'
    );
}

function cuerpolibre_consent_metabox_callback( $post ) {
    // Retrieve metadata
    $nombre      = get_post_meta( $post->ID, 'cl_nombre_completo', true );
    $edad        = get_post_meta( $post->ID, 'cl_edad', true );
    $experiencia = get_post_meta( $post->ID, 'cl_experiencia', true );
    $contacto    = get_post_meta( $post->ID, 'cl_contacto', true );
    
    $dinamicas   = get_post_meta( $post->ID, 'cl_dinamicas', true );
    $contacto_f  = get_post_meta( $post->ID, 'cl_contacto_f', true );
    $limites     = get_post_meta( $post->ID, 'cl_limites_especificos', true );
    
    $privacidad       = get_post_meta( $post->ID, 'cl_privacidad_aceptada', true );
    $pausar_salir     = get_post_meta( $post->ID, 'cl_pausar_salir_aceptada', true );
    $testimonios      = get_post_meta( $post->ID, 'cl_uso_testimonios_autorizado', true );
    $salud            = get_post_meta( $post->ID, 'cl_salud_trauma', true );
    $apoyo            = get_post_meta( $post->ID, 'cl_apoyo_terapeutico', true );
    $organizacion     = get_post_meta( $post->ID, 'cl_proceso_organizacion', true );
    $confirmacion     = get_post_meta( $post->ID, 'cl_confirmacion_leido', true );
    
    // Actividad field
    $actividad        = get_post_meta( $post->ID, 'cl_actividad', true );
    // Original Page ID where they registered
    $page_id_meta     = get_post_meta( $post->ID, 'cl_page_id', true );
    $page_id          = $page_id_meta ? intval( $page_id_meta ) : cuerpolibre_get_consent_page_id();
    
    if ( ! is_array( $dinamicas ) ) {
        $dinamicas = array();
    }
    if ( ! is_array( $contacto_f ) ) {
        $contacto_f = array();
    }
    
    wp_nonce_field( 'cuerpolibre_save_consent_post', 'cuerpolibre_consent_post_nonce' );
    
    // Style and output HTML for admin panel
    ?>
    <style>
        .cl-admin-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }
        .cl-admin-box {
            background: #f9f9f9;
            border: 1px solid #ccd0d4;
            padding: 15px;
            border-radius: 4px;
        }
        .cl-admin-box h3 {
            margin-top: 0;
            border-bottom: 1px solid #ccd0d4;
            padding-bottom: 8px;
            color: #23282d;
            font-family: inherit;
            font-weight: 600;
        }
        .cl-admin-field {
            margin-bottom: 12px;
        }
        .cl-admin-field strong {
            display: inline-block;
            margin-bottom: 4px;
            color: #32373c;
        }
        .cl-admin-badge {
            background: #e5e5e5;
            color: #555;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
            margin: 2px;
            font-size: 11px;
        }
        .cl-admin-badge.checked {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .cl-admin-badge.unchecked {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .cl-text-block {
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 3px;
            white-space: pre-wrap;
            margin-top: 5px;
        }
    </style>
    <div class="cl-admin-grid">
        <div class="cl-admin-box">
            <h3>Datos Personales</h3>
            <div class="cl-admin-field">
                <strong>Actividad:</strong>
                <div>
                    <input type="text" name="cl_actividad" value="<?php echo esc_attr( $actividad ); ?>" style="width: 100%; max-width: 400px; padding: 6px;" placeholder="Ej: Taller A, Yoga, etc." />
                </div>
            </div>
            <div class="cl-admin-field">
                <strong>Nombre Completo:</strong>
                <div><?php echo esc_html( $nombre ); ?></div>
            </div>
            <div class="cl-admin-field">
                <strong>Edad:</strong>
                <div><?php echo esc_html( $edad ); ?> años</div>
            </div>
            <div class="cl-admin-field">
                <strong>N° de WhatsApp:</strong>
                <div><?php echo esc_html( $contacto ); ?></div>
            </div>
            <div class="cl-admin-field">
                <strong>Experiencia previa con nudez/talleres:</strong>
                <div class="cl-text-block"><?php echo esc_html( $experiencia ? $experiencia : 'Ninguna / No especificada' ); ?></div>
            </div>
        </div>
        
        <div class="cl-admin-box">
            <h3>Consentimientos Clave</h3>
            <div class="cl-admin-field">
                <strong>Dinámicas autorizadas:</strong>
                <div>
                    <?php 
                    $dinamicas_list = cuerpolibre_get_form_dynamics( $page_id );
                    foreach ( $dinamicas_list as $key => $label ) {
                        $checked = in_array( $key, $dinamicas ) ? 'checked' : 'unchecked';
                        $icon    = $checked === 'checked' ? '✓' : '✕';
                        echo "<span class='cl-admin-badge {$checked}'>{$icon} {$label}</span><br>";
                    }
                    ?>
                </div>
            </div>
            <div class="cl-admin-field" style="margin-top: 15px;">
                <strong>Contacto físico autorizado:</strong>
                <div>
                    <?php 
                    $contacto_list = cuerpolibre_get_form_contacto_f( $page_id );
                    foreach ( $contacto_list as $key => $label ) {
                        $checked = in_array( $key, $contacto_f ) ? 'checked' : 'unchecked';
                        $icon    = $checked === 'checked' ? '✓' : '✕';
                        echo "<span class='cl-admin-badge {$checked}'>{$icon} {$label}</span><br>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="cl-admin-grid">
        <div class="cl-admin-box">
            <h3>Límites y Condiciones</h3>
            <div class="cl-admin-field">
                <strong>Límites específicos:</strong>
                <div class="cl-text-block"><?php echo esc_html( $limites ? $limites : 'Ninguno especificado' ); ?></div>
            </div>
            <div class="cl-admin-field">
                <strong>Condición de salud o trauma relevante:</strong>
                <div class="cl-text-block"><?php echo esc_html( $salud ? $salud : 'Ninguna especificada / Opcional' ); ?></div>
            </div>
            <div class="cl-admin-field">
                <strong>Apoyo terapéutico actual:</strong>
                <div>
                    <?php
                    $apoyo_si = get_post_meta( $page_id, '_cl_form_apoyo_opcion_si', true ) ?: 'Sí, actualmente tengo terapia';
                    $apoyo_abierto = get_post_meta( $page_id, '_cl_form_apoyo_opcion_abierto', true ) ?: 'No, pero estoy abierto/a a buscar si surge necesidad';
                    $apoyo_no = get_post_meta( $page_id, '_cl_form_apoyo_opcion_no', true ) ?: 'No, y prefiero no recibir apoyo adicional';
                    switch ( $apoyo ) {
                        case 'si':
                            echo esc_html( $apoyo_si );
                            break;
                        case 'abierto':
                            echo esc_html( $apoyo_abierto );
                            break;
                        case 'no':
                            echo esc_html( $apoyo_no );
                            break;
                        default:
                            echo 'No especificado';
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="cl-admin-box">
            <h3>Declaraciones y Aceptación</h3>
            <div class="cl-admin-field">
                <?php $val = ($privacidad === 'yes') ? 'checked' : 'unchecked'; ?>
                <span class="cl-admin-badge <?php echo $val; ?>"><?php echo ($val === 'checked') ? '✓' : '✕'; ?> Medidas de Privacidad Aceptadas</span>
            </div>
            <div class="cl-admin-field">
                <?php $val = ($pausar_salir === 'yes') ? 'checked' : 'unchecked'; ?>
                <span class="cl-admin-badge <?php echo $val; ?>"><?php echo ($val === 'checked') ? '✓' : '✕'; ?> Derecho a Pausar/Salir Comprendido</span>
            </div>
            <div class="cl-admin-field">
                <?php $val = ($testimonios === 'yes') ? 'checked' : 'unchecked'; ?>
                <span class="cl-admin-badge <?php echo $val; ?>"><?php echo ($val === 'checked') ? '✓' : '✕'; ?> Autorización para fines antropológicos</span>
            </div>
            <div class="cl-admin-field">
                <?php $val = ($organizacion === 'yes') ? 'checked' : 'unchecked'; ?>
                <span class="cl-admin-badge <?php echo $val; ?>"><?php echo ($val === 'checked') ? '✓' : '✕'; ?> Proceso de Organización Comprendido</span>
            </div>
            <div class="cl-admin-field" style="margin-top: 15px; border-top: 1px solid #ccd0d4; padding-top: 10px;">
                <?php $val = ($confirmacion === 'yes') ? 'checked' : 'unchecked'; ?>
                <span class="cl-admin-badge <?php echo $val; ?>" style="font-size: 13px; padding: 6px 12px;"><?php echo ($val === 'checked') ? '✓' : '✕'; ?> CONFIRMACIÓN FINAL DE CONSENTIMIENTO</span>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Save custom post metadata for cl_consent_form (both full edit and quick edit)
 */
add_action( 'save_post_cl_consent_form', 'cuerpolibre_save_consent_post_data' );
function cuerpolibre_save_consent_post_data( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['cl_actividad'] ) ) {
        if ( isset( $_POST['cuerpolibre_consent_post_nonce'] ) ) {
            if ( ! wp_verify_nonce( $_POST['cuerpolibre_consent_post_nonce'], 'cuerpolibre_save_consent_post' ) ) {
                return;
            }
        } elseif ( isset( $_POST['cuerpolibre_consent_quick_edit_nonce'] ) ) {
            if ( ! wp_verify_nonce( $_POST['cuerpolibre_consent_quick_edit_nonce'], 'cuerpolibre_consent_quick_edit_nonce' ) ) {
                return;
            }
        }
        
        update_post_meta( $post_id, 'cl_actividad', sanitize_text_field( $_POST['cl_actividad'] ) );
    }
}

/**
 * Handle Inscription/Consent Form AJAX submission
 */
function cuerpolibre_handle_consent_submit() {
    // Nonce verification
    if ( ! isset( $_POST['cl_consent_nonce'] ) || ! wp_verify_nonce( $_POST['cl_consent_nonce'], 'cl_consent_action' ) ) {
        wp_send_json_error( array( 'message' => 'Error de seguridad. Por favor recarga la página e intenta de nuevo.' ) );
    }

    // Required fields
    if ( empty( $_POST['nombre'] ) || empty( $_POST['edad'] ) || empty( $_POST['contacto'] ) ) {
        wp_send_json_error( array( 'message' => 'Los campos de Nombre, Edad y Contacto son obligatorios.' ) );
    }

    if ( empty( $_POST['confirmacion_leido'] ) ) {
        wp_send_json_error( array( 'message' => 'Debes confirmar haber leído y comprendido todos los términos de consentimiento.' ) );
    }

    // Sanitize inputs
    $nombre            = sanitize_text_field( $_POST['nombre'] );
    $edad              = intval( $_POST['edad'] );
    $experiencia       = sanitize_textarea_field( $_POST['experiencia'] );
    $contacto          = sanitize_text_field( $_POST['contacto'] );
    
    // Retrieve submitting page/activity info
    $submitting_page_id = isset( $_POST['page_id'] ) ? intval( $_POST['page_id'] ) : 0;
    $page_id            = $submitting_page_id > 0 ? $submitting_page_id : cuerpolibre_get_consent_page_id();
    $actividad          = get_the_title( $page_id );
    
    $dinamicas         = isset( $_POST['dinamicas'] ) ? array_map( 'sanitize_key', $_POST['dinamicas'] ) : array();
    $contacto_f        = isset( $_POST['contacto_f'] ) ? array_map( 'sanitize_key', $_POST['contacto_f'] ) : array();
    $limites_especificos = sanitize_textarea_field( $_POST['limites_especificos'] );
    
    $privacidad        = isset( $_POST['privacidad'] ) ? 'yes' : 'no';
    $pausar_salir      = isset( $_POST['pausar_salir'] ) ? 'yes' : 'no';
    $testimonios       = isset( $_POST['testimonios'] ) ? 'yes' : 'no';
    
    $salud             = sanitize_textarea_field( $_POST['salud'] );
    $organizacion      = isset( $_POST['organizacion'] ) ? 'yes' : 'no';
    $confirmacion      = isset( $_POST['confirmacion_leido'] ) ? 'yes' : 'no';

    // Insert custom post CPT
    $post_data = array(
        'post_title'   => 'Inscripción: ' . $nombre,
        'post_status'  => 'publish',
        'post_type'    => 'cl_consent_form',
    );

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( array( 'message' => 'Error al guardar la inscripción. Intenta de nuevo.' ) );
    }

    // Save metadata
    update_post_meta( $post_id, 'cl_nombre_completo', $nombre );
    update_post_meta( $post_id, 'cl_edad', $edad );
    update_post_meta( $post_id, 'cl_experiencia', $experiencia );
    update_post_meta( $post_id, 'cl_contacto', $contacto );
    update_post_meta( $post_id, 'cl_dinamicas', $dinamicas );
    update_post_meta( $post_id, 'cl_contacto_f', $contacto_f );
    update_post_meta( $post_id, 'cl_limites_especificos', $limites_especificos );
    update_post_meta( $post_id, 'cl_privacidad_aceptada', $privacidad );
    update_post_meta( $post_id, 'cl_pausar_salir_aceptada', $pausar_salir );
    update_post_meta( $post_id, 'cl_salud_trauma', $salud );
    update_post_meta( $post_id, 'cl_proceso_organizacion', $organizacion );
    update_post_meta( $post_id, 'cl_confirmacion_leido', $confirmacion );
    update_post_meta( $post_id, 'cl_actividad', $actividad );
    update_post_meta( $post_id, 'cl_page_id', $page_id );

    // Email content preparation
    $to = get_post_meta( $page_id, '_cl_form_email_destinatario', true ) ?: 'stola@disroot.org';
    $subject = 'Nueva Inscripción y Consentimiento: ' . $nombre;

    // Build lists for email
    $dinamicas_labels = cuerpolibre_get_form_dynamics( $page_id );
    $contacto_labels  = cuerpolibre_get_form_contacto_f( $page_id );

    $dinamicas_txt = '';
    foreach($dinamicas_labels as $k => $label) {
        $dinamicas_txt .= in_array($k, $dinamicas) ? "[X] $label\n" : "[ ] $label\n";
    }

    $contacto_txt = '';
    foreach($contacto_labels as $k => $label) {
        $contacto_txt .= in_array($k, $contacto_f) ? "[X] $label\n" : "[ ] $label\n";
    }


    $body  = "FORMULARIO DE INSCRIPCIÓN Y CONSENTIMIENTO\n";
    $body .= "Encuentro Corporal Comunitario - Cuerpo Libre\n";
    $body .= "========================================================\n\n";
    $body .= "Actividad: $actividad\n\n";
    $body .= "DATOS PERSONALES\n";
    $body .= "--------------------------------------------------------\n";
    $body .= "Nombre Completo: $nombre\n";
    $body .= "Edad: $edad años\n";
    $body .= "N° de WhatsApp: $contacto\n";
    $body .= "Experiencia previa con nudez/talleres:\n" . ($experiencia ? $experiencia : 'Ninguna / No especificada') . "\n\n";
    $body .= "CONSENTIMIENTOS CLAVE\n";
    $body .= "--------------------------------------------------------\n";
    $body .= "Dinámicas en las que confirma participación activa:\n$dinamicas_txt\n";
    $body .= "Contacto físico autorizado:\n$contacto_txt\n";
    $body .= "Límites específicos:\n" . ($limites_especificos ? $limites_especificos : 'Ninguno especificado') . "\n\n";
    $body .= "Declaración de medidas de privacidad: " . ($privacidad === 'yes' ? 'ACEPTADO' : 'NO ACEPTADO') . "\n";
    $body .= "Declaración de detener participación/pausar: " . ($pausar_salir === 'yes' ? 'ACEPTADO' : 'NO ACEPTADO') . "\n";
    $body .= "Autorización de testimonios para fines antropológicos: " . ($testimonios === 'yes' ? 'AUTORIZADO' : 'NO AUTORIZADO') . "\n\n";
    $body .= "BIENESTAR Y SALUD\n";
    $body .= "--------------------------------------------------------\n";
    $body .= "¿Condición de salud o trauma corporal relevante?:\n" . ($salud ? $salud : 'Ninguna especificada / Opcional') . "\n\n";
    $body .= "Entiende el proceso de organización: " . ($organizacion === 'yes' ? 'ACEPTADO' : 'NO ACEPTADO') . "\n\n";
    $body .= "CONFIRMACIÓN FINAL\n";
    $body .= "--------------------------------------------------------\n";
    $body .= "Confirma haber leído y comprendido todos los términos de consentimiento: " . ($confirmacion === 'yes' ? 'SÍ' : 'NO') . "\n\n";
    $body .= "========================================================\n";
    $body .= "Puedes ver y gestionar esta inscripción desde el panel de administración de WordPress:\n";
    $body .= admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Cuerpo Libre Web <wordpress@cuerpolibre.cl>'
    );
    if ( strpos( $contacto, '@' ) !== false ) {
        $headers[] = "Reply-To: $nombre <$contacto>";
    }

    // Send the email
    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => '¡Inscripción y consentimiento enviados y registrados con éxito!' ) );
    } else {
        wp_send_json_success( array( 'message' => 'Inscripción registrada en el panel, pero hubo un detalle al enviar el correo de respaldo.' ) );
    }
}
add_action( 'wp_ajax_submit_consent', 'cuerpolibre_handle_consent_submit' );
add_action( 'wp_ajax_nopriv_submit_consent', 'cuerpolibre_handle_consent_submit' );

/**
 * ==========================================================================
 * SISTEMA DE CONFIGURACIÓN DEL FORMULARIO DE CONSENTIMIENTO DESDE EL PANEL
 * ==========================================================================
 */

/**
 * Helper to get the consent page ID.
 */
function cuerpolibre_get_consent_page_id() {
    $page = get_page_by_path( 'inscripcion-y-consentimiento', OBJECT, 'page' );
    return $page ? $page->ID : 0;
}

/**
 * Helper to parse textarea lines into key|value array.
 */
function cuerpolibre_parse_form_lines( $text, $default_options = array() ) {
    if ( empty( $text ) ) {
        return $default_options;
    }
    $lines = explode( "\n", str_replace( "\r", "", $text ) );
    $parsed = array();
    foreach ( $lines as $line ) {
        $line = trim( $line );
        if ( empty( $line ) ) {
            continue;
        }
        if ( strpos( $line, '|' ) !== false ) {
            list( $key, $val ) = explode( '|', $line, 2 );
            $parsed[ trim( $key ) ] = trim( $val );
        } else {
            $key = sanitize_title_with_dashes( $line );
            $parsed[ $key ] = $line;
        }
    }
    return $parsed;
}

/**
 * Get form dynamics options.
 */
function cuerpolibre_get_form_dynamics( $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = cuerpolibre_get_consent_page_id();
    }
    $default = array(
        'exposicion'  => 'Exposición progresiva de desnudez',
        'mapas'       => 'Juego de Mapas de Atracción (marcar y ser marcado)',
        'dialogo'     => 'Diálogo sobre autoimagen vs. mirada ajena',
        'caminata'    => 'Caminata sensorial silenciosa',
        'testimonios' => 'Testimonios corporales compartidos',
    );
    if ( ! $page_id ) {
        return $default;
    }
    $meta = get_post_meta( $page_id, '_cl_form_dinamicas', true );
    return cuerpolibre_parse_form_lines( $meta, $default );
}

/**
 * Get form physical contact options.
 */
function cuerpolibre_get_form_contacto_f( $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = cuerpolibre_get_consent_page_id();
    }
    $default = array(
        'toques'     => 'Toques de reconocimiento (hombro, espalda)',
        'visual'     => 'Contacto visual prolongado',
        'propio'     => 'Tocar tu propio cuerpo frente a otros',
        'observado'  => 'Estar siendo observado sin ropa',
        'plantillas' => 'Recibir marcas en plantillas de cuerpo ajeno',
    );
    if ( ! $page_id ) {
        return $default;
    }
    $meta = get_post_meta( $page_id, '_cl_form_contacto_f', true );
    return cuerpolibre_parse_form_lines( $meta, $default );
}

/**
 * Get privacy rules list.
 */
function cuerpolibre_get_form_privacidad_rules( $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = cuerpolibre_get_consent_page_id();
    }
    $default = array(
        'Mis datos personales no se compartirán.',
        'Las observaciones se registrarán de forma totalmente anónima.',
        'No se grabará ni se tomarán fotografías bajo ninguna circunstancia.',
        'Puedo retirarme en cualquier momento sin dar explicaciones.',
    );
    if ( ! $page_id ) {
        return $default;
    }
    $meta = get_post_meta( $page_id, '_cl_form_privacidad', true );
    if ( empty( $meta ) ) {
        return $default;
    }
    $lines = explode( "\n", str_replace( "\r", "", $meta ) );
    return array_filter( array_map( 'trim', $lines ) );
}

/**
 * Get organization rules list.
 */
function cuerpolibre_get_form_organizacion_rules( $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = cuerpolibre_get_consent_page_id();
    }
    $default = array(
        'Recibiré información detallada previa al encuentro.',
        'Habrá una reunión de bienvenida el día del evento.',
        'Se establecerán y acordarán límites claros de forma grupal al inicio.',
        'Se realizará un cierre reflexivo y de contención al finalizar la actividad.',
    );
    if ( ! $page_id ) {
        return $default;
    }
    $meta = get_post_meta( $page_id, '_cl_form_organizacion', true );
    if ( empty( $meta ) ) {
        return $default;
    }
    $lines = explode( "\n", str_replace( "\r", "", $meta ) );
    return array_filter( array_map( 'trim', $lines ) );
}

/**
 * Register Metabox for cl_consent_form settings (on the page edit screen)
 */
add_action( 'add_meta_boxes', 'cl_register_consent_form_settings_metabox' );
function cl_register_consent_form_settings_metabox() {
    global $post;
    if ( ! $post ) return;
    
    // Check if it's the consent page by template or by slug
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( 'page-consentimiento.php' === $template || 'inscripcion-y-consentimiento' === $post->post_name ) {
        add_meta_box(
            'cl_consent_form_settings',
            'Configuración del Formulario de Consentimiento',
            'cl_consent_form_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
}

function cl_consent_form_settings_callback( $post ) {
    wp_nonce_field( 'cl_save_form_settings_action', 'cl_save_form_settings_nonce' );
    
    // Retrieve values
    $hero_eyebrow = get_post_meta( $post->ID, '_cl_form_hero_eyebrow', true );
    $hero_title = get_post_meta( $post->ID, '_cl_form_hero_title', true );
    $hero_subtitle = get_post_meta( $post->ID, '_cl_form_hero_subtitle', true );
    
    $intro_title = get_post_meta( $post->ID, '_cl_form_intro_title', true );
    $intro_text = get_post_meta( $post->ID, '_cl_form_intro_text', true );
    
    $meta_duracion = get_post_meta( $post->ID, '_cl_form_meta_duracion', true );
    $meta_formato = get_post_meta( $post->ID, '_cl_form_meta_formato', true );
    $meta_lugar = get_post_meta( $post->ID, '_cl_form_meta_lugar', true );
    $meta_valor = get_post_meta( $post->ID, '_cl_form_meta_valor', true );
    $meta_fecha = get_post_meta( $post->ID, '_cl_form_meta_fecha', true );
    
    $dinamicas = get_post_meta( $post->ID, '_cl_form_dinamicas', true );
    $contacto_f = get_post_meta( $post->ID, '_cl_form_contacto_f', true );
    $privacidad = get_post_meta( $post->ID, '_cl_form_privacidad', true );
    $organizacion = get_post_meta( $post->ID, '_cl_form_organizacion', true );
    
    $pausar_titulo = get_post_meta( $post->ID, '_cl_form_pausar_titulo', true );
    $pausar_subtexto = get_post_meta( $post->ID, '_cl_form_pausar_subtexto', true );
    
    $testimonios_titulo = get_post_meta( $post->ID, '_cl_form_testimonios_titulo', true );
    $testimonios_subtexto = get_post_meta( $post->ID, '_cl_form_testimonios_subtexto', true );
    
    $salud_label = get_post_meta( $post->ID, '_cl_form_salud_label', true );
    $salud_placeholder = get_post_meta( $post->ID, '_cl_form_salud_placeholder', true );
    
    $confirmacion_titulo = get_post_meta( $post->ID, '_cl_form_confirmacion_titulo', true );
    $confirmacion_subtexto = get_post_meta( $post->ID, '_cl_form_confirmacion_subtexto', true );
    
    $email_destinatario = get_post_meta( $post->ID, '_cl_form_email_destinatario', true );
    
    ?>
    <style>
        .cl-form-settings-container {
            container-type: inline-size;
            container-name: cl_settings;
            width: 100%;
        }
        .cl-form-settings-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        @container cl_settings (min-width: 700px) {
            .cl-form-settings-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        .cl-form-settings-section {
            border: 1px solid #ccd0d4;
            padding: 15px;
            border-radius: 4px;
            background: #f9f9f9;
            margin-bottom: 20px;
        }
        .cl-form-settings-section h3 {
            margin-top: 0;
            border-bottom: 1px solid #ccd0d4;
            padding-bottom: 8px;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .cl-form-settings-field {
            margin-bottom: 15px;
        }
        .cl-form-settings-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .cl-form-settings-field input[type="text"],
        .cl-form-settings-field textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .cl-form-settings-field p.description {
            margin-top: 4px;
            font-style: italic;
            color: #666;
        }
        .cl-form-settings-tip {
            background: #fff8e1;
            border-left: 4px solid #ffb300;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 0 4px 4px 0;
            font-size: 13px;
            line-height: 1.5;
            color: #5d4037;
        }
    </style>
    <div class="cl-form-settings-tip">
        💡 <strong>Consejo de visualización:</strong> Si este panel de edición te aparece muy estrecho en el lateral derecho de la pantalla, puedes moverlo fácilmente al área central inferior (haciendo que sea ancho y cómodo de editar). Para ello, haz clic en el botón de opciones del panel de metabox (el icono de tres puntos verticales o flecha en su esquina superior derecha) y selecciona <strong>"Mover a la parte inferior"</strong> (Move to bottom).
    </div>
    <div class="cl-form-settings-container">
        <div class="cl-form-settings-grid">
        <div class="cl-left-col">
            <div class="cl-form-settings-section">
                <h3>1. Cabecera e Introducción</h3>
                <div class="cl-form-settings-field">
                    <label for="cl_form_hero_eyebrow">Ceja del Hero (Eyebrow)</label>
                    <input type="text" id="cl_form_hero_eyebrow" name="cl_form_hero_eyebrow" value="<?php echo esc_attr( $hero_eyebrow ); ?>" placeholder="Encuentro Corporal Comunitario">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_hero_title">Título del Hero</label>
                    <input type="text" id="cl_form_hero_title" name="cl_form_hero_title" value="<?php echo esc_attr( $hero_title ); ?>" placeholder="Inscripción &lt;br&gt; Consentimiento">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_hero_subtitle">Subtítulo del Hero</label>
                    <textarea id="cl_form_hero_subtitle" name="cl_form_hero_subtitle" rows="2" placeholder="Actividad terapéutico-antropológica de exploración corporal en nudez consensuada."><?php echo esc_textarea( $hero_subtitle ); ?></textarea>
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_intro_title">Título Sección Introducción</label>
                    <input type="text" id="cl_form_intro_title" name="cl_form_intro_title" value="<?php echo esc_attr( $intro_title ); ?>" placeholder="Sobre el Encuentro">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_intro_text">Texto de Introducción</label>
                    <textarea id="cl_form_intro_text" name="cl_form_intro_text" rows="4" placeholder="Esta actividad busca visibilizar la diversidad corporal y redefinir normativas estéticas mediante dinámicas grupales en un espacio seguro y de mutuo respeto."><?php echo esc_textarea( $intro_text ); ?></textarea>
                </div>
            </div>
            
            <div class="cl-form-settings-section">
                <h3>2. Información sobre la Actividad (Meta Grid)</h3>
                <div class="cl-form-settings-field">
                    <label for="cl_form_meta_fecha">Fecha y hora</label>
                    <input type="text" id="cl_form_meta_fecha" name="cl_form_meta_fecha" value="<?php echo esc_attr( $meta_fecha ); ?>" placeholder="e.g. Sábado 25 de Octubre, 17:00 hs">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_meta_duracion">Duración</label>
                    <input type="text" id="cl_form_meta_duracion" name="cl_form_meta_duracion" value="<?php echo esc_attr( $meta_duracion ); ?>" placeholder="2 - 3 horas">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_meta_formato">Formato</label>
                    <input type="text" id="cl_form_meta_formato" name="cl_form_meta_formato" value="<?php echo esc_attr( $meta_formato ); ?>" placeholder="Presencial (máx. 10 personas)">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_meta_lugar">Lugar</label>
                    <input type="text" id="cl_form_meta_lugar" name="cl_form_meta_lugar" value="<?php echo esc_attr( $meta_lugar ); ?>" placeholder="Espacio privado con comodidades básicas">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_meta_valor">Valor</label>
                    <input type="text" id="cl_form_meta_valor" name="cl_form_meta_valor" value="<?php echo esc_attr( $meta_valor ); ?>" placeholder="Aporte voluntario sugerido $10.000">
                </div>
            </div>

            <div class="cl-form-settings-section">
                <h3>3. Configuración del Sistema</h3>
                <div class="cl-form-settings-field">
                    <label for="cl_form_email_destinatario">Email destinatario de notificaciones</label>
                    <input type="text" id="cl_form_email_destinatario" name="cl_form_email_destinatario" value="<?php echo esc_attr( $email_destinatario ); ?>" placeholder="stola@disroot.org">
                    <p class="description">Dirección de correo que recibirá las notificaciones de nuevas inscripciones.</p>
                </div>
            </div>
        </div>
        
        <div class="cl-right-col">
            <div class="cl-form-settings-section">
                <h3>4. Listas y Opciones Dinámicas</h3>
                <p class="description">Ingresa una opción por línea. Puedes usar el formato <code>clave|Nombre Visible</code> o simplemente escribir el texto directo de la opción.</p>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_dinamicas">Dinámicas de Participación Activa</label>
                    <textarea id="cl_form_dinamicas" name="cl_form_dinamicas" rows="5" placeholder="exposicion|Exposición progresiva de desnudez&#10;mapas|Juego de Mapas de Atracción (marcar y ser marcado)"><?php echo esc_textarea( $dinamicas ); ?></textarea>
                </div>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_contacto_f">Contacto Físico Autorizado</label>
                    <textarea id="cl_form_contacto_f" name="cl_form_contacto_f" rows="5" placeholder="toques|Toques de reconocimiento (hombro, espalda)&#10;visual|Contacto visual prolongado"><?php echo esc_textarea( $contacto_f ); ?></textarea>
                </div>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_privacidad">Medidas de Privacidad (Una por línea)</label>
                    <textarea id="cl_form_privacidad" name="cl_form_privacidad" rows="4" placeholder="Mis datos personales no se compartirán.&#10;Las observaciones se registrarán de forma totalmente anónima."><?php echo esc_textarea( $privacidad ); ?></textarea>
                </div>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_organizacion">Proceso de Organización (Una por línea)</label>
                    <textarea id="cl_form_organizacion" name="cl_form_organizacion" rows="4" placeholder="Recibiré información detallada previa al encuentro.&#10;Habrá una reunión de bienvenida el día del evento."><?php echo esc_textarea( $organizacion ); ?></textarea>
                </div>
            </div>

            <div class="cl-form-settings-section">
                <h3>5. Textos de Términos de Consentimiento y Apoyo</h3>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_pausar_titulo">Pausar/Salir - Título</label>
                    <input type="text" id="cl_form_pausar_titulo" name="cl_form_pausar_titulo" value="<?php echo esc_attr( $pausar_titulo ); ?>" placeholder="Entiendo que puedo pausar o salir en cualquier momento *">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_pausar_subtexto">Pausar/Salir - Subtexto</label>
                    <textarea id="cl_form_pausar_subtexto" name="cl_form_pausar_subtexto" rows="2" placeholder="Puedo detener mi participación o retirarme del espacio sin necesidad de justificar mi decisión ni realizar ningún pago."><?php echo esc_textarea( $pausar_subtexto ); ?></textarea>
                </div>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_testimonios_titulo">Testimonios - Título</label>
                    <input type="text" id="cl_form_testimonios_titulo" name="cl_form_testimonios_titulo" value="<?php echo esc_attr( $testimonios_titulo ); ?>" placeholder="Autorizo el uso de mis testimonios para fines antropológicos">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_testimonios_subtexto">Testimonios - Subtexto</label>
                    <textarea id="cl_form_testimonios_subtexto" name="cl_form_testimonios_subtexto" rows="2" placeholder="Mis palabras y reflexiones compartidas durante el encuentro podrán utilizarse en investigaciones académicas, asegurando anonimidad total y absoluta."><?php echo esc_textarea( $testimonios_subtexto ); ?></textarea>
                </div>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_salud_label">Salud y Trauma - Pregunta</label>
                    <input type="text" id="cl_form_salud_label" name="cl_form_salud_label" value="<?php echo esc_attr( $salud_label ); ?>" placeholder="¿Tienes alguna condición de salud o trauma corporal relevante? (Totalmente opcional)">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_salud_placeholder">Salud y Trauma - Placeholder</label>
                    <input type="text" id="cl_form_salud_placeholder" name="cl_form_salud_placeholder" value="<?php echo esc_attr( $salud_placeholder ); ?>" placeholder="Si hay algo físico o emocional que consideres importante que el facilitador sepa...">
                </div>
                
                <div class="cl-form-settings-field">
                    <label for="cl_form_confirmacion_titulo">Confirmación - Título</label>
                    <input type="text" id="cl_form_confirmacion_titulo" name="cl_form_confirmacion_titulo" value="<?php echo esc_attr( $confirmacion_titulo ); ?>" placeholder="CONFIRMO HABER LEÍDO Y COMPRENDIDO TODOS LOS TÉRMINOS DE CONSENTIMIENTO *">
                </div>
                <div class="cl-form-settings-field">
                    <label for="cl_form_confirmacion_subtexto">Confirmación - Subtexto</label>
                    <textarea id="cl_form_confirmacion_subtexto" name="cl_form_confirmacion_subtexto" rows="2" placeholder="Declaro que mi participación en esta actividad es libre, voluntaria y basada en la información entregada."><?php echo esc_textarea( $confirmacion_subtexto ); ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}

/**
 * Save settings for the consent page.
 */
add_action( 'save_post', 'cl_save_consent_form_settings' );
function cl_save_consent_form_settings( $post_id ) {
    if ( ! isset( $_POST['cl_save_form_settings_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['cl_save_form_settings_nonce'], 'cl_save_form_settings_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }
    
    $fields = array(
        'cl_form_hero_eyebrow',
        'cl_form_hero_title',
        'cl_form_hero_subtitle',
        'cl_form_intro_title',
        'cl_form_intro_text',
        'cl_form_meta_fecha',
        'cl_form_meta_duracion',
        'cl_form_meta_formato',
        'cl_form_meta_lugar',
        'cl_form_meta_valor',
        'cl_form_dinamicas',
        'cl_form_contacto_f',
        'cl_form_privacidad',
        'cl_form_organizacion',
        'cl_form_pausar_titulo',
        'cl_form_pausar_subtexto',
        'cl_form_testimonios_titulo',
        'cl_form_testimonios_subtexto',
        'cl_form_salud_label',
        'cl_form_salud_placeholder',
        'cl_form_confirmacion_titulo',
        'cl_form_confirmacion_subtexto',
        'cl_form_email_destinatario',
    );
    
    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            if ( strpos( $field, 'text' ) !== false || strpos( $field, 'subtitle' ) !== false || strpos( $field, 'dinamicas' ) !== false || strpos( $field, 'contacto_f' ) !== false || strpos( $field, 'privacidad' ) !== false || strpos( $field, 'organizacion' ) !== false || strpos( $field, 'subtexto' ) !== false ) {
                $val = sanitize_textarea_field( $_POST[ $field ] );
            } else {
                $val = sanitize_text_field( $_POST[ $field ] );
            }
            update_post_meta( $post_id, '_' . $field, $val );
        }
    }
}

add_action( 'wp_ajax_nopriv_submit_consent', 'cuerpolibre_handle_consent_submit' );

/**
 * Load Subscription and Content Restriction System
 */
require_once get_template_directory() . '/subscription-system.php';

/**
 * Register global AI Assistant submenu page under cl_consent_form CPT
 */
add_action( 'admin_menu', 'cl_register_global_ai_assistant_page' );
function cl_register_global_ai_assistant_page() {
    add_submenu_page(
        'edit.php?post_type=cl_consent_form',
        'Asistente de Análisis IA',
        'Asistente IA 🔍',
        'manage_options',
        'cl-consent-ai-assistant',
        'cl_consent_ai_assistant_render_page'
    );
}

function cl_consent_ai_assistant_render_page() {
    ?>
    <div class="wrap cl-ai-chat-wrap">
        <h1 class="wp-heading-inline">Asistente de Análisis IA — Cuerpo Libre</h1>
        <hr class="wp-header-end">

        <div class="cl-chat-container">
            <div class="cl-chat-sidebar">
                <h3>Consultas Rápidas</h3>
                <button class="cl-quick-btn" data-question="¿Cuáles son los límites físicos y específicos más comunes expresados por los participantes?">📋 Límites más comunes</button>
                <button class="cl-quick-btn" data-question="Haz un resumen ejecutivo de las últimas 15 inscripciones registradas.">👥 Resumen de últimas inscripciones</button>
                <button class="cl-quick-btn" data-question="¿Existe alguna condición médica, de salud o trauma corporal relevante declarada que requiera atención inmediata del facilitador?">⚠️ Alertas de Salud y Trauma</button>
                <button class="cl-quick-btn" data-question="¿Cuáles son las dinámicas y formas de contacto físico que los participantes autorizan con mayor frecuencia?">🔄 Dinámicas y Contactos Autorizados</button>
            </div>

            <div class="cl-chat-main">
                <div class="cl-chat-messages" id="clChatMessages">
                    <div class="cl-message system">
                        <div class="cl-message-bubble">
                            Hola. Soy tu asistente de análisis de Cuerpo Libre. Estoy conectado a la base de datos de inscripciones y consentimientos. Puedes hacerme preguntas sobre los perfiles de los participantes, límites comunes o alertas de salud. ¿Qué te gustaría saber?
                        </div>
                    </div>
                </div>

                <div class="cl-chat-input-area">
                    <input type="text" id="clChatInput" placeholder="Escribe tu consulta sobre las inscripciones aquí..." />
                    <button id="clChatSendBtn" class="button button-primary button-large">Preguntar a la IA</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cl-ai-chat-wrap {
            max-width: 1200px;
            margin: 20px auto;
        }
        .cl-chat-container {
            display: flex;
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            overflow: hidden;
            height: 600px;
            margin-top: 20px;
            color: #e0e0e0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }
        .cl-chat-sidebar {
            width: 280px;
            background: #141414;
            border-right: 1px solid #333;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .cl-chat-sidebar h3 {
            margin-top: 0;
            color: #c8a882; /* Tono dorado del tema */
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #2a2a2a;
            padding-bottom: 10px;
        }
        .cl-quick-btn {
            background: #222;
            border: 1px solid #444;
            color: #d0d0d0;
            padding: 10px 14px;
            border-radius: 4px;
            text-align: left;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s ease;
        }
        .cl-quick-btn:hover {
            background: #c8a882;
            color: #141414;
            border-color: #c8a882;
        }
        .cl-chat-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: #1a1a1a;
        }
        .cl-chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .cl-message {
            display: flex;
            max-width: 80%;
        }
        .cl-message.system {
            align-self: flex-start;
        }
        .cl-message.user {
            align-self: flex-end;
        }
        .cl-message-bubble {
            padding: 12px 16px;
            border-radius: 8px;
            line-height: 1.5;
            font-size: 13px;
            white-space: pre-wrap;
        }
        .cl-message.system .cl-message-bubble {
            background: #2a2a2a;
            color: #e0e0e0;
            border-left: 3px solid #c8a882;
        }
        .cl-message.user .cl-message-bubble {
            background: #c8a882;
            color: #141414;
            font-weight: 500;
        }
        .cl-chat-input-area {
            padding: 15px 20px;
            background: #141414;
            border-top: 1px solid #333;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        #clChatInput {
            flex-grow: 1;
            background: #222;
            border: 1px solid #444;
            color: #fff;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 14px;
        }
        #clChatInput:focus {
            border-color: #c8a882;
            box-shadow: 0 0 0 1px #c8a882;
            outline: none;
        }
        #clChatSendBtn {
            background: #c8a882 !important;
            border-color: #c8a882 !important;
            color: #141414 !important;
            text-shadow: none !important;
            font-weight: bold;
        }
        #clChatSendBtn:hover {
            background: #d9b893 !important;
            border-color: #d9b893 !important;
        }
        .cl-loading-dots span {
            animation: blink 1.4s infinite both;
            display: inline-block;
            font-size: 20px;
            line-height: 1;
        }
        .cl-loading-dots span:nth-child(2) { animation-delay: .2s; }
        .cl-loading-dots span:nth-child(3) { animation-delay: .4s; }
        @keyframes blink {
            0% { opacity: .2; }
            20% { opacity: 1; }
            100% { opacity: .2; }
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            const chatMessages = $('#clChatMessages');
            const chatInput = $('#clChatInput');
            const sendBtn = $('#clChatSendBtn');

            function appendMessage(sender, text) {
                const msgClass = sender === 'user' ? 'user' : 'system';
                const messageHtml = `
                    <div class="cl-message ${msgClass}">
                        <div class="cl-message-bubble">${text}</div>
                    </div>
                `;
                chatMessages.append(messageHtml);
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            }

            function askQuestion(questionText) {
                if (!questionText.trim()) return;

                // Agregar mensaje de usuario
                appendMessage('user', questionText);
                chatInput.val('');

                // Agregar burbuja de carga
                const loadingId = 'loading-' + Date.now();
                const loadingHtml = `
                    <div class="cl-message system" id="${loadingId}">
                        <div class="cl-message-bubble cl-loading-dots">
                            Analizando inscripciones y pensando<span>.</span><span>.</span><span>.</span>
                        </div>
                    </div>
                `;
                chatMessages.append(loadingHtml);
                chatMessages.scrollTop(chatMessages[0].scrollHeight);

                // Llamada AJAX
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'cl_consent_ai_global_chat',
                        question: questionText,
                        nonce: '<?php echo wp_create_nonce("cl_ai_global_chat_nonce"); ?>'
                    },
                    success: function(response) {
                        $(`#${loadingId}`).remove();
                        if (response.success && response.data.answer) {
                            appendMessage('system', response.data.answer);
                        } else {
                            const errorMsg = response.data && response.data.message ? response.data.message : 'Error desconocido al procesar.';
                            appendMessage('system', '❌ Error: ' + errorMsg);
                        }
                    },
                    error: function() {
                        $(`#${loadingId}`).remove();
                        appendMessage('system', '❌ Error de conexión al servidor.');
                    }
                });
            }

            sendBtn.on('click', function() {
                askQuestion(chatInput.val());
            });

            chatInput.on('keypress', function(e) {
                if (e.which === 13) {
                    askQuestion(chatInput.val());
                }
            });

            $('.cl-quick-btn').on('click', function() {
                askQuestion($(this).data('question'));
            });
        });
    </script>
    <?php
}

/**
 * AJAX Handler for the Global AI Assistant
 */
add_action( 'wp_ajax_cl_consent_ai_global_chat', 'cl_handle_ai_global_chat' );
function cl_handle_ai_global_chat() {
    // Verificar seguridad
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'cl_ai_global_chat_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Error de seguridad. Por favor recarga la página.' ) );
    }

    $question = isset( $_POST['question'] ) ? sanitize_text_field( $_POST['question'] ) : '';
    if ( empty( $question ) ) {
        wp_send_json_error( array( 'message' => 'La pregunta no puede estar vacía.' ) );
    }

    if ( ! function_exists( 'wp_ai_client_prompt' ) || ! wp_supports_ai() ) {
        wp_send_json_error( array( 'message' => 'El sistema de Inteligencia Artificial no está soportado en este entorno.' ) );
    }

    // Asegurar aprobación de los conectores necesarios para el tema
    if ( class_exists( 'WordPress\AI\Connector_Approval\Approvals_Store' ) ) {
        $store = new \WordPress\AI\Connector_Approval\Approvals_Store();
        foreach ( array( 'openrouter', 'ai_gateway' ) as $connector_id ) {
            if ( ! $store->is_approved( 'cuerpolibre', $connector_id ) ) {
                $store->set_approval( 'cuerpolibre', $connector_id, true );
            }
        }
    }

    // Obtener todas las inscripciones publicadas (hasta un máximo de 100)
    $args = array(
        'post_type'      => 'cl_consent_form',
        'post_status'    => 'publish',
        'posts_per_page' => 100,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        wp_send_json_success( array( 'answer' => 'Actualmente no hay ninguna inscripción registrada en el sistema sobre la cual pueda responder.' ) );
    }

    // Compilar el contexto de inscripciones
    $inscriptions_context = "LISTA DE INSCRIPCIONES DISPONIBLES:\n";
    $count = 1;

    while ( $query->have_posts() ) {
        $query->the_post();
        $post_id = get_the_ID();

        $nombre      = get_post_meta( $post_id, 'cl_nombre_completo', true );
        $edad        = get_post_meta( $post_id, 'cl_edad', true );
        $experiencia = get_post_meta( $post_id, 'cl_experiencia', true );
        $limites     = get_post_meta( $post_id, 'cl_limites_especificos', true );
        $salud       = get_post_meta( $post_id, 'cl_salud_trauma', true );
        $actividad   = get_post_meta( $post_id, 'cl_actividad', true );
        $dinamicas   = get_post_meta( $post_id, 'cl_dinamicas', true );
        $contacto_f  = get_post_meta( $post_id, 'cl_contacto_f', true );

        $dinamicas_str = is_array( $dinamicas ) ? implode( ', ', $dinamicas ) : 'Ninguna';
        $contacto_str  = is_array( $contacto_f ) ? implode( ', ', $contacto_f ) : 'Ninguno';

        $inscriptions_context .= "Participante #{$count}:\n";
        $inscriptions_context .= "- Actividad: " . ($actividad ?: 'No especificada') . "\n";
        $inscriptions_context .= "- Nombre / Iniciales: " . ($nombre ?: 'Anónimo') . " (Edad: {$edad})\n";
        if ( ! empty( $experiencia ) ) {
            $inscriptions_context .= "- Experiencia declarada: {$experiencia}\n";
        }
        if ( ! empty( $limites ) ) {
            $inscriptions_context .= "- Límites físicos expresados: {$limites}\n";
        }
        if ( ! empty( $salud ) ) {
            $inscriptions_context .= "- Condición de Salud/Trauma: {$salud}\n";
        }
        $inscriptions_context .= "- Dinámicas autorizadas: {$dinamicas_str}\n";
        $inscriptions_context .= "- Contacto físico autorizado: {$contacto_str}\n";
        $inscriptions_context .= "--------------------------------------\n";

        $count++;
    }
    wp_reset_postdata();

    // Construir el prompt completo para el LLM
    $prompt = "A continuación, se te provee el consolidado de inscripciones y consentimientos del taller 'Cuerpo Libre' (un espacio de exploración corporal y nudez consensuada). 

Utiliza este contexto exclusivo para responder a la consulta del organizador.

{$inscriptions_context}

Pregunta del Organizador: \"{$question}\"

Responde en español de manera clara, profesional, concisa y ordenada, usando viñetas si es necesario.";

    // Ejecutar el prompt con el LLM integrado de WordPress
    $response = wp_ai_client_prompt( $prompt )
        ->using_system_instruction( 'Eres el Asistente Analítico del taller Cuerpo Libre. Tu misión es extraer estadísticas, resúmenes de límites, alertas y perfiles grupales a partir de la lista de participantes inscritos. Respondes con objetividad, empatía y extrema claridad.' )
        ->using_temperature( 0.2 )
        ->generate_text();

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( array( 'message' => 'Error de respuesta de la IA: ' . $response->get_error_message() ) );
    }

    wp_send_json_success( array( 'answer' => $response ) );
}
