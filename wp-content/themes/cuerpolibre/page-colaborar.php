<?php
/**
 * Template Name: Página de Colaboración
 * 
 * Plantilla dedicada para invitar a los usuarios a colaborar con el proyecto.
 *
 * @package Cuerpo_Libre
 */

get_header();

$mp_link = get_option( 'cl_mp_link', '#' );
$price = get_option( 'cl_sub_price', '$1.500 CLP/mes' );
$is_subscribed = function_exists('cl_is_user_subscribed') && cl_is_user_subscribed();

?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section class="manifesto-hero" style="min-height: 50vh; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; padding: 120px 20px 60px;">
        <div class="hero-bg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, rgba(200, 168, 130, 0.08) 0%, var(--black) 70%); z-index: 1;"></div>
        
        <div class="hero-content text-center" style="position: relative; z-index: 2; max-width: 800px; margin: 0 auto;">
            <span class="section-label" style="display: block; margin-bottom: 24px;">Apoya el Arte Independiente</span>
            <h1 style="font-size: clamp(2.5rem, 6vw, 4.5rem); margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Hazte Colaborador</h1>
            <p style="font-size: 1.1rem; color: var(--white-90); line-height: 1.8; max-width: 600px; margin: 0 auto;">
                Cuerpo Libre es un espacio de resistencia fotográfica. Al unirte como colaborador, no solo accedes a nuestras colecciones privadas y sin censura, sino que financias directamente la creación de nuevo arte libre.
            </p>
        </div>
    </section>

    <!-- Collaboration Form / Card Section -->
    <section class="collaboration-section" style="padding: 40px 20px 100px; position: relative; z-index: 2;">
        
        <?php if ( $is_subscribed ) : ?>
            
            <div class="cl-restricted-overlay reveal active" style="margin: 0 auto;">
                <div class="cl-restricted-card text-center" style="max-width: 600px; padding: 60px 40px;">
                    <div class="cl-success-icon" style="font-size: 4rem; color: var(--accent); margin-bottom: 24px;">✓</div>
                    <h2 style="margin-bottom: 16px;">Ya eres Colaborador</h2>
                    <p style="color: var(--white-60); line-height: 1.8; margin-bottom: 32px;">Tu cuenta ya cuenta con acceso completo a todas nuestras colecciones. Agradecemos profundamente tu apoyo al arte independiente.</p>
                    <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-primary btn-arrow">Explorar Colecciones</a>
                </div>
            </div>

        <?php else : ?>

            <div class="cl-restricted-overlay reveal active" style="margin: 0 auto;">
                <div class="cl-restricted-card">
                    <div class="cl-restricted-header">
                        <h2>Acceso Total</h2>
                        <div class="section-divider"></div>
                        <p>Por solo <strong><?php echo esc_html( $price ); ?></strong>, desbloquea todas las galerías privadas de forma permanente y recibe notificaciones exclusivas con cada nueva obra antes de que sea pública.</p>
                    </div>
                    
                    <div class="cl-steps-grid">
                        <!-- Paso 1: Pago -->
                        <div class="cl-step-card">
                            <span class="cl-step-num">01</span>
                            <h3>Realiza tu Aporte</h3>
                            <p>Tu contribución se procesa de forma rápida y segura a través de MercadoPago. Haz clic en el botón de abajo para comenzar.</p>
                            <a href="<?php echo esc_url( $mp_link ); ?>" target="_blank" class="btn-primary btn-arrow cl-pay-btn" id="clPayBtn">Pagar con MercadoPago</a>
                        </div>
                        
                        <!-- Paso 2: Cuenta -->
                        <div class="cl-step-card">
                            <span class="cl-step-num">02</span>
                            <h3>Activa tu Acceso</h3>
                            <p>Si ya pagaste o estás por hacerlo, regístrate o inicia sesión aquí. Tu acceso se activará automáticamente al retornar del pago.</p>
                            
                            <div class="cl-auth-tabs">
                                <button class="cl-tab-btn active" data-tab="cl-login-tab">Ingresar</button>
                                <button class="cl-tab-btn" data-tab="cl-register-tab">Registrarse</button>
                            </div>
                            
                            <!-- Formulario Login -->
                            <div id="cl-login-tab" class="cl-tab-content active">
                                <form id="cl-login-form" class="cl-auth-form">
                                    <?php wp_nonce_field( 'cl_ajax_login_nonce', 'cl_login_security' ); ?>
                                    <input type="hidden" name="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
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
                                    <input type="hidden" name="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
                                    <div class="form-group">
                                        <input type="text" name="user_name" placeholder="Nombre completo" required autocomplete="name" />
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="user_email" placeholder="Correo electrónico" required autocomplete="email" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="user_password" placeholder="Contraseña" required autocomplete="new-password" />
                                    </div>
                                    <button type="submit" class="btn-secondary btn-block">Registrarse</button>
                                    <div class="form-message"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </section>

</main>

<?php
get_footer();
