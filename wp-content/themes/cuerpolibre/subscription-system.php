<?php
/**
 * Cuerpo Libre - Subscription and Content Restriction System
 *
 * @package Cuerpo_Libre
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   1. REGISTRO DE METADATOS Y METABOXES (Restringir Post/Galería)
   ========================================================================== */

function cl_register_restricted_meta() {
    register_post_meta( 'post', '_cl_restricted', array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'boolean',
        'default'      => false,
    ) );
    register_post_meta( 'cuerpolibre_gallery', '_cl_restricted', array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'boolean',
        'default'      => false,
    ) );
}
add_action( 'init', 'cl_register_restricted_meta' );

function cl_add_restricted_meta_box() {
    $screens = array( 'post', 'cuerpolibre_gallery' );
    foreach ( $screens as $screen ) {
        add_meta_box(
            'cl_restricted_meta_box',
            'Restricción de Contenido',
            'cl_restricted_meta_box_callback',
            $screen,
            'side',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'cl_add_restricted_meta_box' );

function cl_restricted_meta_box_callback( $post ) {
    wp_nonce_field( 'cl_save_restricted_meta', 'cl_restricted_meta_nonce' );
    $value = get_post_meta( $post->ID, '_cl_restricted', true );
    ?>
    <p>
        <input type="checkbox" id="cl_restricted_checkbox" name="cl_restricted_checkbox" value="1" <?php checked( $value, '1' ); ?> />
        <label for="cl_restricted_checkbox"><strong>Restringir a Colaboradores</strong></label>
    </p>
    <p class="description">Si está activado, solo los usuarios con suscripción activa podrán ver este contenido.</p>
    <?php
}

function cl_save_restricted_meta( $post_id ) {
    if ( ! isset( $_POST['cl_restricted_meta_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['cl_restricted_meta_nonce'], 'cl_save_restricted_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    $value = isset( $_POST['cl_restricted_checkbox'] ) ? '1' : '0';
    update_post_meta( $post_id, '_cl_restricted', $value );
}
add_action( 'save_post', 'cl_save_restricted_meta' );


/* ==========================================================================
   2. PERFIL DE USUARIOS (Administración de Suscripciones en wp-admin)
   ========================================================================== */

function cl_add_user_subscription_fields( $user ) {
    $status = get_user_meta( $user->ID, 'cl_subscription_status', true );
    $payment_id = get_user_meta( $user->ID, 'cl_mp_payment_id', true );
    $payer_email = get_user_meta( $user->ID, 'cl_mp_payer_email', true );
    ?>
    <h3>Detalles de Suscripción (Cuerpo Libre)</h3>
    <table class="form-table">
        <tr>
            <th><label for="cl_subscription_status">Estado de la Suscripción</label></th>
            <td>
                <select name="cl_subscription_status" id="cl_subscription_status">
                    <option value="inactive" <?php selected( $status, 'inactive' ); ?>>Inactiva (Sin acceso)</option>
                    <option value="active" <?php selected( $status, 'active' ); ?>>Activa (Acceso completo)</option>
                </select>
                <p class="description">Controla si el usuario tiene acceso a todo el contenido exclusivo.</p>
            </td>
        </tr>
        <tr>
            <th><label for="cl_mp_payment_id">ID de Pago de MercadoPago</label></th>
            <td>
                <input type="text" name="cl_mp_payment_id" id="cl_mp_payment_id" value="<?php echo esc_attr( $payment_id ); ?>" class="regular-text" />
                <p class="description">ID de transacción del último pago verificado.</p>
            </td>
        </tr>
        <tr>
            <th><label for="cl_mp_payer_email">Email del Payer (MercadoPago)</label></th>
            <td>
                <input type="email" name="cl_mp_payer_email" id="cl_mp_payer_email" value="<?php echo esc_attr( $payer_email ); ?>" class="regular-text" />
                <p class="description">El email con el que el usuario realizó el pago en MercadoPago.</p>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'cl_add_user_subscription_fields' );
add_action( 'edit_user_profile', 'cl_add_user_subscription_fields' );

function cl_save_user_subscription_fields( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    if ( isset( $_POST['cl_subscription_status'] ) ) {
        update_user_meta( $user_id, 'cl_subscription_status', sanitize_text_field( $_POST['cl_subscription_status'] ) );
    }
    if ( isset( $_POST['cl_mp_payment_id'] ) ) {
        update_user_meta( $user_id, 'cl_mp_payment_id', sanitize_text_field( $_POST['cl_mp_payment_id'] ) );
    }
    if ( isset( $_POST['cl_mp_payer_email'] ) ) {
        update_user_meta( $user_id, 'cl_mp_payer_email', sanitize_email( $_POST['cl_mp_payer_email'] ) );
    }
}
add_action( 'personal_options_update', 'cl_save_user_subscription_fields' );
add_action( 'edit_user_profile_update', 'cl_save_user_subscription_fields' );

// Añadir columna de suscripción en la tabla de usuarios en Admin
function cl_user_table_subscription_column( $columns ) {
    $columns['subscription_status'] = 'Suscripción';
    return $columns;
}
add_filter( 'manage_users_columns', 'cl_user_table_subscription_column' );

function cl_user_table_subscription_column_value( $val, $column_name, $user_id ) {
    if ( 'subscription_status' === $column_name ) {
        $status = get_user_meta( $user_id, 'cl_subscription_status', true );
        if ( 'active' === $status ) {
            return '<span style="color:#c8a882; font-weight:bold;">✅ Activa</span>';
        } else {
            return '<span style="color:rgba(255,255,255,0.3);">✕ Inactiva</span>';
        }
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'cl_user_table_subscription_column_value', 10, 3 );


/* ==========================================================================
   3. PANEL DE AJUSTES GLOBALES (Ajustes -> Suscripción)
   ========================================================================== */

function cl_subscription_settings_menu() {
    add_options_page(
        'Suscripción Cuerpo Libre',
        'Suscripción',
        'manage_options',
        'cl-subscription-settings',
        'cl_subscription_settings_page_callback'
    );
}
add_action( 'admin_menu', 'cl_subscription_settings_menu' );

function cl_subscription_settings_init() {
    register_setting( 'cl_subscription_group', 'cl_mp_link' );
    register_setting( 'cl_subscription_group', 'cl_sub_price' );
    register_setting( 'cl_subscription_group', 'cl_notification_subject' );
    register_setting( 'cl_subscription_group', 'cl_notification_body' );
    
    // Configurar valores por defecto
    if ( ! get_option( 'cl_sub_price' ) ) {
        update_option( 'cl_sub_price', '$1.500 CLP/mes' );
    }
    if ( ! get_option( 'cl_notification_subject' ) ) {
        update_option( 'cl_notification_subject', 'Nueva obra en Cuerpo Libre: {post_title}' );
    }
    if ( ! get_option( 'cl_notification_body' ) ) {
        $default_body = "Hola {username},\n\nHemos publicado nuevo contenido exclusivo para colaboradores en Cuerpo Libre:\n\n\"{post_title}\"\n\nPuedes verlo en el siguiente enlace:\n{post_url}\n\nEsperamos que lo disfrutes.\n\nAtentamente,\nCuerpo Libre";
        update_option( 'cl_notification_body', $default_body );
    }
}
add_action( 'admin_init', 'cl_subscription_settings_init' );

function cl_subscription_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>Ajustes de Suscripción Cuerpo Libre</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'cl_subscription_group' );
            do_settings_sections( 'cl_subscription_group' );
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="cl_mp_link">Enlace de MercadoPago (Link de Pago)</label></th>
                    <td>
                        <input type="url" name="cl_mp_link" id="cl_mp_link" value="<?php echo esc_url( get_option( 'cl_mp_link' ) ); ?>" class="large-text" placeholder="https://mpago.la/..." required />
                        <p class="description">El link de pago estático para que el usuario realice el pago de la suscripción.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cl_sub_price">Precio de Suscripción (Texto)</label></th>
                    <td>
                        <input type="text" name="cl_sub_price" id="cl_sub_price" value="<?php echo esc_attr( get_option( 'cl_sub_price' ) ); ?>" class="regular-text" placeholder="e.g. $1.500 CLP/mes" required />
                        <p class="description">Se mostrará en los textos de suscripción del sitio.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row" colspan="2"><h2 style="margin-top:40px; margin-bottom:10px;">Notificación de Correo (Newsletter)</h2><hr></th>
                </tr>
                <tr>
                    <th scope="row"><label for="cl_notification_subject">Asunto del Correo</label></th>
                    <td>
                        <input type="text" name="cl_notification_subject" id="cl_notification_subject" value="<?php echo esc_attr( get_option( 'cl_notification_subject' ) ); ?>" class="large-text" />
                        <p class="description">Etiquetas soportadas: <code>{post_title}</code></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cl_notification_body">Cuerpo del Correo</label></th>
                    <td>
                        <textarea name="cl_notification_body" id="cl_notification_body" rows="10" class="large-text"><?php echo esc_textarea( get_option( 'cl_notification_body' ) ); ?></textarea>
                        <p class="description">Etiquetas soportadas: <code>{username}</code>, <code>{post_title}</code>, <code>{post_url}</code>, <code>{post_excerpt}</code></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


/* ==========================================================================
   4. DETECCIÓN Y RESTRICCIÓN DE ACCESO (Front-end)
   ========================================================================== */

function cl_is_user_subscribed( $user_id = null ) {
    if ( ! is_user_logged_in() && null === $user_id ) {
        return false;
    }
    if ( null === $user_id ) {
        $user_id = get_current_user_id();
    }
    
    // Administradores y editores siempre tienen acceso libre
    if ( user_can( $user_id, 'manage_options' ) || user_can( $user_id, 'edit_others_posts' ) ) {
        return true;
    }
    
    $status = get_user_meta( $user_id, 'cl_subscription_status', true );
    return 'active' === $status;
}

function cl_restrict_content_filter( $content ) {
    // Solo aplicar en vistas individuales de Post o Galerías
    if ( ! is_singular( array( 'post', 'cuerpolibre_gallery' ) ) ) {
        return $content;
    }
    
    global $post;
    $is_restricted = get_post_meta( $post->ID, '_cl_restricted', true );
    
    if ( '1' !== $is_restricted ) {
        return $content; // Contenido público
    }
    
    if ( cl_is_user_subscribed() ) {
        // Mostrar badge especial para administradores y editores
        if ( current_user_can( 'manage_options' ) ) {
            $badge = '<div class="cl-admin-badge" style="background: rgba(200, 168, 130, 0.1); border: 1px solid var(--accent); color: var(--accent); padding: 12px 20px; font-size: 0.72rem; font-family: var(--font-sans); letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 40px; border-radius: 4px; display: inline-flex; align-items: center; gap: 8px; width: 100%;">';
            $badge .= '<span style="display:inline-block; width: 6px; height: 6px; background: var(--accent); border-radius: 50%;"></span>';
            $badge .= 'Vista previa de Administrador — Este contenido es exclusivo para colaboradores';
            $badge .= '</div>';
            return $badge . $content;
        }
        return $content;
    }
    
    // Si no está suscrito, envolvemos el contenido en un contenedor difuminado e inyectamos el overlay encima
    $blurred_content = '<div class="cl-locked-gallery-wrapper">';
    $blurred_content .= '<div class="cl-locked-gallery-blur">' . $content . '</div>';
    $blurred_content .= cl_get_restricted_overlay_html();
    $blurred_content .= '</div>';
    return $blurred_content;
}
add_filter( 'the_content', 'cl_restrict_content_filter', 99 );


/* ==========================================================================
   5. OVERLAY PREMIUM Y FORMULARIO AJAX
   ========================================================================== */

function cl_get_restricted_overlay_html() {
    $mp_link = get_option( 'cl_mp_link', '#' );
    $price = get_option( 'cl_sub_price', '$1.500 CLP/mes' );
    
    ob_start();
    ?>
    <div class="cl-restricted-overlay reveal">
        <div class="cl-restricted-card">
            <div class="cl-restricted-header">
                <span class="section-label">Contenido Reservado</span>
                <h2>Acceso Exclusivo</h2>
                <div class="section-divider"></div>
                <p>Esta serie artística es exclusiva para los colaboradores activos de Cuerpo Libre. Por solo <strong><?php echo esc_html( $price ); ?></strong>, podrás desbloquear de forma permanente todas nuestras colecciones y recibirás de forma prioritaria en tu correo nuestras nuevas publicaciones.</p>
            </div>
            
            <div class="cl-steps-grid">
                <!-- Paso 1: Pago -->
                <div class="cl-step-card">
                    <span class="cl-step-num">01</span>
                    <h3>Paga tu Suscripción</h3>
                    <p>Realiza tu pago en la plataforma segura de MercadoPago. Haz clic en el botón de abajo para comenzar.</p>
                    <a href="<?php echo esc_url( $mp_link ); ?>" target="_blank" class="btn-primary btn-arrow cl-pay-btn" id="clPayBtn">Pagar Suscripción</a>
                </div>
                
                <!-- Paso 2: Cuenta -->
                <div class="cl-step-card">
                    <span class="cl-step-num">02</span>
                    <h3>Vincula tu Cuenta</h3>
                    <p>Inicia sesión o crea una cuenta nueva. Al regresar de tu pago, tu acceso se activará de forma automática.</p>
                    
                    <div class="cl-auth-tabs">
                        <button class="cl-tab-btn active" data-tab="cl-login-tab">Ingresar</button>
                        <button class="cl-tab-btn" data-tab="cl-register-tab">Registrarse</button>
                    </div>
                    
                    <!-- Formulario Login -->
                    <div id="cl-login-tab" class="cl-tab-content active">
                        <form id="cl-login-form" class="cl-auth-form">
                            <?php wp_nonce_field( 'cl_ajax_login_nonce', 'cl_login_security' ); ?>
                            <div class="form-group">
                                <input type="text" name="log" placeholder="Email o Usuario" required autocomplete="username" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="pwd" placeholder="Contraseña" required autocomplete="current-password" />
                            </div>
                            <button type="submit" class="btn-secondary btn-block">Entrar</button>
                            <div class="form-message"></div>
                        </form>
                    </div>
                    
                    <!-- Formulario Registro -->
                    <div id="cl-register-tab" class="cl-tab-content">
                        <form id="cl-register-form" class="cl-auth-form">
                            <?php wp_nonce_field( 'cl_ajax_register_nonce', 'cl_register_security' ); ?>
                            <div class="form-group">
                                <input type="text" name="user_name" placeholder="Nombre completo" required autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <input type="email" name="user_email" placeholder="Correo electrónico" required autocomplete="email" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="user_password" placeholder="Contraseña" required autocomplete="new-password" />
                            </div>
                            <button type="submit" class="btn-secondary btn-block">Registrarse y Activar</button>
                            <div class="form-message"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


/* ==========================================================================
   6. ENDPOINTS AJAX PARA LOGIN Y REGISTRO
   ========================================================================== */

// AJAX Login Handler
function cl_ajax_login_handler() {
    check_ajax_referer( 'cl_ajax_login_nonce', 'security' );
    
    $info = array();
    $info['user_login'] = sanitize_text_field( $_POST['username'] );
    $info['user_password'] = sanitize_text_field( $_POST['password'] );
    $info['remember'] = true;
    
    $user_signon = wp_signon( $info, false );
    
    if ( is_wp_error( $user_signon ) ) {
        wp_send_json_error( array( 'message' => 'Usuario o contraseña incorrectos.' ) );
    } else {
        wp_set_current_user( $user_signon->ID );
        wp_set_auth_cookie( $user_signon->ID );
        
        // Activar si hay un ID de pago pendiente en POST o cookies
        $payment_id = isset( $_POST['payment_id'] ) ? sanitize_text_field( $_POST['payment_id'] ) : '';
        if ( empty( $payment_id ) ) {
            $payment_id = isset( $_COOKIE['cl_pending_payment'] ) ? sanitize_text_field( $_COOKIE['cl_pending_payment'] ) : '';
        }
        if ( ! empty( $payment_id ) ) {
            $existing_users = get_users( array(
                'meta_key'   => 'cl_mp_payment_id',
                'meta_value' => $payment_id,
                'number'     => 1,
            ) );
            if ( empty( $existing_users ) ) {
                update_user_meta( $user_signon->ID, 'cl_subscription_status', 'active' );
                update_user_meta( $user_signon->ID, 'cl_mp_payment_id', $payment_id );
                setcookie( 'cl_pending_payment', '', time() - 3600, '/' );
            }
        }
        
        $is_subscribed = cl_is_user_subscribed( $user_signon->ID );
        $redirect = isset( $_POST['post_id'] ) ? get_permalink( $_POST['post_id'] ) : home_url('/');
        
        wp_send_json_success( array( 
            'message'    => 'Sesión iniciada con éxito. Redirigiendo...', 
            'subscribed' => $is_subscribed,
            'redirect'   => $redirect 
        ) );
    }
}
add_action( 'wp_ajax_cl_ajax_login', 'cl_ajax_login_handler' );
add_action( 'wp_ajax_nopriv_cl_ajax_login', 'cl_ajax_login_handler' );

// AJAX Register Handler
function cl_ajax_register_handler() {
    check_ajax_referer( 'cl_ajax_register_nonce', 'security' );
    
    $name = sanitize_text_field( $_POST['name'] );
    $email = sanitize_email( $_POST['email'] );
    $password = sanitize_text_field( $_POST['password'] );
    
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Correo electrónico no válido.' ) );
    }
    
    if ( email_exists( $email ) ) {
        wp_send_json_error( array( 'message' => 'Este correo electrónico ya está registrado.' ) );
    }
    
    $username = explode( '@', $email )[0];
    $base_username = $username;
    $counter = 1;
    while ( username_exists( $username ) ) {
        $username = $base_username . $counter;
        $counter++;
    }
    
    $user_id = wp_create_user( $username, $password, $email );
    
    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error( array( 'message' => 'Error al crear la cuenta: ' . $user_id->get_error_message() ) );
    }
    
    wp_update_user( array(
        'ID'           => $user_id,
        'display_name' => $name,
        'first_name'   => $name,
    ) );
    
    wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id );
    
    // Activar si hay un ID de pago pendiente en POST o cookies
    $payment_id = isset( $_POST['payment_id'] ) ? sanitize_text_field( $_POST['payment_id'] ) : '';
    if ( empty( $payment_id ) ) {
        $payment_id = isset( $_COOKIE['cl_pending_payment'] ) ? sanitize_text_field( $_COOKIE['cl_pending_payment'] ) : '';
    }
    $activated_immediately = false;
    
    if ( ! empty( $payment_id ) ) {
        $existing_users = get_users( array(
            'meta_key'   => 'cl_mp_payment_id',
            'meta_value' => $payment_id,
            'number'     => 1,
        ) );
        if ( empty( $existing_users ) ) {
            update_user_meta( $user_id, 'cl_subscription_status', 'active' );
            update_user_meta( $user_id, 'cl_mp_payment_id', $payment_id );
            setcookie( 'cl_pending_payment', '', time() - 3600, '/' );
            $activated_immediately = true;
        }
    }
    
    $redirect = isset( $_POST['post_id'] ) ? get_permalink( $_POST['post_id'] ) : home_url('/');
    
    wp_send_json_success( array( 
        'message'    => $activated_immediately ? 'Cuenta creada y suscripción activada con éxito. Redirigiendo...' : 'Cuenta creada. Verifica tu suscripción o realiza el pago para acceder. Redirigiendo...', 
        'subscribed' => $activated_immediately || cl_is_user_subscribed( $user_id ),
        'redirect'   => $redirect 
    ) );
}
add_action( 'wp_ajax_cl_ajax_register', 'cl_ajax_register_handler' );
add_action( 'wp_ajax_nopriv_cl_ajax_register', 'cl_ajax_register_handler' );


/* ==========================================================================
   7. PAGINA DE CONFIRMACION Y ACTIVACIÓN AUTOMÁTICA (/suscripcion-confirmada)
   ========================================================================== */

function cl_create_subscription_pages() {
    // 1. Página de Confirmación
    $confirm_slug = 'suscripcion-confirmada';
    if ( ! get_page_by_path( $confirm_slug, OBJECT, 'page' ) ) {
        wp_insert_post( array(
            'post_title'   => 'Suscripción Confirmada',
            'post_name'    => $confirm_slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '<!-- cl_subscription_confirmation_page -->',
        ) );
    }

    // 2. Página Landing de Colaborar
    $colaborar_slug = 'colaborar';
    if ( ! get_page_by_path( $colaborar_slug, OBJECT, 'page' ) ) {
        wp_insert_post( array(
            'post_title'   => 'Colaborar',
            'post_name'    => $colaborar_slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'page_template'=> 'page-colaborar.php',
        ) );
    }
}
add_action( 'init', 'cl_create_subscription_pages' );

/**
 * Guardar el ID de pago pendiente en una cookie antes de que se envíen las cabeceras
 */
function cl_set_pending_payment_cookie() {
    if ( is_page( 'suscripcion-confirmada' ) && ! is_user_logged_in() ) {
        $payment_id = isset( $_GET['payment_id'] ) ? sanitize_text_field( $_GET['payment_id'] ) : '';
        if ( empty( $payment_id ) && isset( $_GET['collection_id'] ) ) {
            $payment_id = sanitize_text_field( $_GET['collection_id'] );
        }
        if ( ! empty( $payment_id ) ) {
            setcookie( 'cl_pending_payment', $payment_id, time() + 3600, '/' );
            $_COOKIE['cl_pending_payment'] = $payment_id;
        }
    }
}
add_action( 'template_redirect', 'cl_set_pending_payment_cookie' );

function cl_subscription_confirm_page_content( $content ) {
    if ( ! is_page( 'suscripcion-confirmada' ) ) {
        return $content;
    }
    
    // Obtenemos el ID de pago único que MercadoPago añade a la URL de retorno
    $payment_id = isset( $_GET['payment_id'] ) ? sanitize_text_field( $_GET['payment_id'] ) : '';
    if ( empty( $payment_id ) && isset( $_GET['collection_id'] ) ) {
        $payment_id = sanitize_text_field( $_GET['collection_id'] );
    }
    
    ob_start();
    ?>
    <div class="cl-confirm-page" style="padding: 140px 0 100px; min-height: 70vh; display: flex; align-items: center; justify-content: center; background: var(--black);">
        <div class="cl-restricted-card" style="max-width: 600px; width: 100%; margin: 0 auto; text-align: center;">
            <?php if ( ! empty( $payment_id ) ) : ?>
                <div class="cl-success-icon" style="font-size: 5rem; color: var(--accent); margin-bottom: 24px; line-height: 1;">✓</div>
                <h2>¡Suscripción Confirmada!</h2>
                <div class="section-divider" style="margin: 24px auto;"></div>
                
                <?php
                if ( is_user_logged_in() ) {
                    $user_id = get_current_user_id();
                    
                    // Verificar si el pago ya se usó por alguna cuenta
                    $existing_users = get_users( array(
                        'meta_key'   => 'cl_mp_payment_id',
                        'meta_value' => $payment_id,
                        'number'     => 1,
                    ) );
                    
                    if ( empty( $existing_users ) ) {
                        // El pago es nuevo, lo registramos y activamos al usuario
                        update_user_meta( $user_id, 'cl_subscription_status', 'active' );
                        update_user_meta( $user_id, 'cl_mp_payment_id', $payment_id );
                        ?>
                        <p style="font-size: 1.15rem; color: var(--white-90); margin-bottom: 48px; line-height: 1.8;">Tu suscripción ha sido vinculada y activada con éxito. Ya puedes navegar libremente por todas nuestras colecciones exclusivas.</p>
                        <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-primary btn-arrow">Ver Galerías Exclusivas</a>
                        <?php
                    } else {
                        // El pago ya se usó. Comprobar si pertenece al usuario actual
                        $current_payment_id = get_user_meta( $user_id, 'cl_mp_payment_id', true );
                        if ( $current_payment_id === $payment_id ) {
                            ?>
                            <p style="font-size: 1.15rem; color: var(--white-90); margin-bottom: 48px; line-height: 1.8;">Tu suscripción ya se encuentra activa para este pago. Disfruta de todo el contenido exclusivo.</p>
                            <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-primary btn-arrow">Ver Galerías Exclusivas</a>
                            <?php
                        } else {
                            ?>
                            <p style="font-size: 1.15rem; color: #e74c3c; margin-bottom: 48px; line-height: 1.8;">Este ID de pago ya ha sido utilizado por otra cuenta. No es posible transferirlo. Si crees que esto es un error, por favor ponte en contacto con nosotros.</p>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-secondary">Volver al Inicio</a>
                            <?php
                        }
                    }
                } else {
                    // No está logueado. El pago se almacena en la cookie de sesión en template_redirect
                    ?>
                    <p style="font-size: 1.15rem; color: var(--white-90); margin-bottom: 36px; line-height: 1.8;">Tu pago de MercadoPago fue verificado. Para activar tu cuenta de forma definitiva, <strong>inicia sesión o regístrate</strong> a continuación:</p>
                    
                    <div class="cl-auth-tabs" style="justify-content: center; margin-bottom: 36px;">
                        <button class="cl-tab-btn active" data-tab="cl-login-tab">Ingresar</button>
                        <button class="cl-tab-btn" data-tab="cl-register-tab">Registrarse</button>
                    </div>
                    
                    <!-- Formulario Login -->
                    <div id="cl-login-tab" class="cl-tab-content active" style="max-width: 420px; margin: 0 auto; text-align: left;">
                        <form id="cl-login-form" class="cl-auth-form">
                            <?php wp_nonce_field( 'cl_ajax_login_nonce', 'cl_login_security' ); ?>
                            <div class="form-group">
                                <input type="text" name="log" placeholder="Email o Usuario" required style="width:100%;" autocomplete="username" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="pwd" placeholder="Contraseña" required style="width:100%;" autocomplete="current-password" />
                            </div>
                            <button type="submit" class="btn-secondary btn-block">Entrar y Activar</button>
                            <div class="form-message"></div>
                        </form>
                    </div>
                    
                    <!-- Formulario Registro -->
                    <div id="cl-register-tab" class="cl-tab-content" style="max-width: 420px; margin: 0 auto; text-align: left;">
                        <form id="cl-register-form" class="cl-auth-form">
                            <?php wp_nonce_field( 'cl_ajax_register_nonce', 'cl_register_security' ); ?>
                            <div class="form-group">
                                <input type="text" name="user_name" placeholder="Nombre completo" required style="width:100%;" autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <input type="email" name="user_email" placeholder="Correo electrónico" required style="width:100%;" autocomplete="email" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="user_password" placeholder="Contraseña" required style="width:100%;" autocomplete="new-password" />
                            </div>
                            <button type="submit" class="btn-secondary btn-block">Registrarse y Activar</button>
                            <div class="form-message"></div>
                        </form>
                    </div>
                    <?php
                }
                ?>
            <?php else : ?>
                <div class="cl-error-icon" style="font-size: 5rem; color: #e74c3c; margin-bottom: 24px; line-height: 1;">✕</div>
                <h2>Acceso Denegado</h2>
                <div class="section-divider" style="margin: 24px auto;"></div>
                <p style="font-size: 1.15rem; color: var(--white-90); margin-bottom: 48px; line-height: 1.8;">No se encontró información válida de pago en esta URL. Si realizaste el pago en MercadoPago, por favor ingresa usando el link que se generó al finalizar tu compra.</p>
                <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-primary">Ver Galerías</a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_filter( 'the_content', 'cl_subscription_confirm_page_content', 99 );


/* ==========================================================================
   8. ENVIAR CORREO AUTOMÁTICO (Newsletter al publicar contenido restringido)
   ========================================================================== */

function cl_notify_subscribers_on_publish( $new_status, $old_status, $post ) {
    // Ejecutar únicamente cuando una entrada pasa a estar publicada
    if ( 'publish' !== $new_status || 'publish' === $old_status ) {
        return;
    }
    
    // Solo aplica para entradas de blog y galerías de fotos
    if ( ! in_array( $post->post_type, array( 'post', 'cuerpolibre_gallery' ), true ) ) {
        return;
    }
    
    // Comprobar si está marcado como restringido
    $is_restricted = get_post_meta( $post->ID, '_cl_restricted', true );
    if ( '1' !== $is_restricted ) {
        return;
    }
    
    // Obtener la plantilla de correo
    $subject_tpl = get_option( 'cl_notification_subject', 'Nueva obra en Cuerpo Libre: {post_title}' );
    $body_tpl = get_option( 'cl_notification_body', '' );
    
    // Obtener todos los usuarios con suscripción activa
    $subscribers = get_users( array(
        'meta_key'   => 'cl_subscription_status',
        'meta_value' => 'active',
    ) );
    
    if ( empty( $subscribers ) ) {
        return;
    }
    
    $post_url = get_permalink( $post->ID );
    $post_title = $post->post_title;
    $post_excerpt = ! empty( $post->post_excerpt ) ? $post->post_excerpt : wp_trim_words( $post->post_content, 35 );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Cuerpo Libre Web <wordpress@cuerpolibre.cl>',
    );
    
    foreach ( $subscribers as $sub ) {
        $username = ! empty( $sub->display_name ) ? $sub->display_name : $sub->user_login;
        
        $subject = str_replace( '{post_title}', $post_title, $subject_tpl );
        
        $body = str_replace(
            array( '{username}', '{post_title}', '{post_url}', '{post_excerpt}' ),
            array( $username, $post_title, $post_url, $post_excerpt ),
            $body_tpl
        );
        
        wp_mail( $sub->user_email, $subject, $body, $headers );
    }
}
add_action( 'transition_post_status', 'cl_notify_subscribers_on_publish', 10, 3 );


/* ==========================================================================
   9. ENCOLAR RECURSOS JS Y ENLAZAR CON AJAX
   ========================================================================== */

function cl_subscription_enqueue_assets() {
    // Encolar assets de suscripción únicamente en páginas individuales o en la confirmación y landing
    if ( is_singular( array( 'post', 'cuerpolibre_gallery' ) ) || is_page( 'suscripcion-confirmada' ) || is_page_template( 'page-colaborar.php' ) ) {
        wp_enqueue_script(
            'cl-subscription-js',
            get_template_directory_uri() . '/js/subscription.js',
            array( 'jquery' ),
            time(),
            true
        );
        
        wp_localize_script( 'cl-subscription-js', 'cl_sub_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'post_id'  => get_the_ID(),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'cl_subscription_enqueue_assets' );
