<?php
/**
 * Template Name: Inscripción y Consentimiento
 *
 * @package Cuerpo_Libre
 */

get_header();

$page_id = get_the_ID();

// Retrieve settings
$hero_eyebrow   = get_post_meta( $page_id, '_cl_form_hero_eyebrow', true ) ?: 'Encuentro Corporal Comunitario';
$hero_title     = get_post_meta( $page_id, '_cl_form_hero_title', true ) ?: 'Inscripción &<br>Consentimiento';
$hero_subtitle  = get_post_meta( $page_id, '_cl_form_hero_subtitle', true ) ?: 'Actividad terapéutico-antropológica de exploración corporal en nudez consensuada.';

$intro_title    = get_post_meta( $page_id, '_cl_form_intro_title', true ) ?: 'Sobre el Encuentro';
$intro_text     = get_post_meta( $page_id, '_cl_form_intro_text', true ) ?: 'Esta actividad busca visibilizar la diversidad corporal y redefinir normativas estéticas mediante dinámicas grupales en un espacio seguro y de mutuo respeto.';

$meta_duracion  = get_post_meta( $page_id, '_cl_form_meta_duracion', true ) ?: '2 - 3 horas';
$meta_formato   = get_post_meta( $page_id, '_cl_form_meta_formato', true ) ?: 'Presencial (máx. 10 personas)';
$meta_lugar     = get_post_meta( $page_id, '_cl_form_meta_lugar', true ) ?: 'Espacio privado con comodidades básicas';
$meta_valor     = get_post_meta( $page_id, '_cl_form_meta_valor', true ) ?: 'Aporte voluntario sugerido $10.000';
$meta_fecha     = get_post_meta( $page_id, '_cl_form_meta_fecha', true ) ?: '';

$dinamicas      = cuerpolibre_get_form_dynamics( $page_id );
$contacto_f     = cuerpolibre_get_form_contacto_f( $page_id );
$privacidad     = cuerpolibre_get_form_privacidad_rules( $page_id );
$organizacion   = cuerpolibre_get_form_organizacion_rules( $page_id );

$pausar_titulo  = get_post_meta( $page_id, '_cl_form_pausar_titulo', true ) ?: 'Entiendo que puedo pausar o salir en cualquier momento *';
$pausar_subtexto = get_post_meta( $page_id, '_cl_form_pausar_subtexto', true ) ?: 'Puedo detener mi participación o retirarme del espacio sin necesidad de justificar mi decisión ni realizar ningún pago.';

$testimonios_titulo = get_post_meta( $page_id, '_cl_form_testimonios_titulo', true ) ?: 'Autorizo el uso de mis testimonios para fines antropológicos';
$testimonios_subtexto = get_post_meta( $page_id, '_cl_form_testimonios_subtexto', true ) ?: 'Mis palabras y reflexiones compartidas durante el encuentro podrán utilizarse en investigaciones académicas, asegurando anonimidad total y absoluta.';

$salud_label    = get_post_meta( $page_id, '_cl_form_salud_label', true ) ?: '¿Tienes alguna condición de salud o trauma corporal relevante? (Totalmente opcional)';
$salud_placeholder = get_post_meta( $page_id, '_cl_form_salud_placeholder', true ) ?: 'Si hay algo físico o emocional que consideres importante que el facilitador sepa...';

$confirmacion_titulo = get_post_meta( $page_id, '_cl_form_confirmacion_titulo', true ) ?: 'CONFIRMO HABER LEÍDO Y COMPRENDIDO TODOS LOS TÉRMINOS DE CONSENTIMIENTO *';
$confirmacion_subtexto = get_post_meta( $page_id, '_cl_form_confirmacion_subtexto', true ) ?: 'Declaro que mi participación en esta actividad es libre, voluntaria y basada en la información entregada.';
?>

<main id="primary" class="site-main consent-page">

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="page-featured-banner">
            <?php the_post_thumbnail( 'full', [ 'class' => 'banner-img' ] ); ?>
        </div>
    <?php endif; ?>

    <!-- Page Hero -->
    <section class="page-hero small-hero">
        <div class="container">
            <span class="page-hero-eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></span>
            <h1><?php echo wp_kses_post( $hero_title ); ?></h1>
            <p class="subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
        </div>
    </section>

    <!-- Content & Form Section -->
    <section class="consent-form-section">
        <div class="container">
            <div class="consent-grid-layout">
                
                <!-- Main Form Area -->
                <div class="consent-form-wrapper reveal">
                    <form class="cl-detailed-form" id="consentForm">
                        <?php wp_nonce_field( 'cl_consent_action', 'cl_consent_nonce' ); ?>
                        <input type="hidden" name="page_id" value="<?php echo esc_attr( $page_id ); ?>">
                        
                        <!-- Actividad Info Panel -->
                        <div class="form-section-intro">
                            <h3><?php echo esc_html( $intro_title ); ?></h3>
                            <p><?php echo esc_html( $intro_text ); ?></p>

                            <?php if ( get_the_content() ) : ?>
                                <div class="page-gutenberg-content">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="activity-meta-grid">
                                <?php if ( ! empty( $meta_fecha ) ) : ?>
                                <div class="meta-item">
                                    <span class="meta-label">Fecha y hora</span>
                                    <span class="meta-value"><?php echo esc_html( $meta_fecha ); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="meta-item">
                                    <span class="meta-label">Duración</span>
                                    <span class="meta-value"><?php echo esc_html( $meta_duracion ); ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Formato</span>
                                    <span class="meta-value"><?php echo esc_html( $meta_formato ); ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Lugar</span>
                                    <span class="meta-value"><?php echo esc_html( $meta_lugar ); ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Valor</span>
                                    <span class="meta-value"><?php echo esc_html( $meta_valor ); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- 1. Datos Personales -->
                        <div class="form-group-section">
                            <h2 class="section-title">1. Datos Personales</h2>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cl-nombre">Nombre completo *</label>
                                    <input type="text" id="cl-nombre" name="nombre" placeholder="Tu nombre y apellidos" required>
                                </div>
                                <div class="form-group">
                                    <label for="cl-edad">Edad *</label>
                                    <input type="number" id="cl-edad" name="edad" placeholder="e.g. 25" min="18" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="cl-contacto">N° de WhatsApp *</label>
                                <input type="tel" id="cl-contacto" name="contacto" placeholder="+56 9 XXXX XXXX" required>
                            </div>

                            <div class="form-group">
                                <label for="cl-experiencia">¿Tienes experiencia previa con nudez o talleres de corporalidad?</label>
                                <textarea id="cl-experiencia" name="experiencia" rows="3" placeholder="Cuéntanos brevemente si has participado en dinámicas similares antes..."></textarea>
                            </div>
                        </div>

                        <!-- 2. Consentimientos Clave -->
                        <div class="form-group-section">
                            <h2 class="section-title">2. Consentimientos Clave</h2>
                            
                            <!-- Dinámicas -->
                            <div class="consent-group-box">
                                <h3 class="group-title">Dinámicas de Participación Activa</h3>
                                <p class="group-desc">Por favor, marca las dinámicas en las que estás de acuerdo en participar de forma activa:</p>
                                
                                <div class="checkbox-list">
                                    <?php foreach ( $dinamicas as $val => $label ) : ?>
                                        <label class="cl-checkbox-label">
                                            <input type="checkbox" name="dinamicas[]" value="<?php echo esc_attr( $val ); ?>" required>
                                            <span class="custom-box"></span>
                                            <span class="label-text"><?php echo esc_html( $label ); ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Contacto Físico -->
                            <div class="consent-group-box">
                                <h3 class="group-title">Contacto Físico Autorizado</h3>
                                <p class="group-desc">Selecciona el tipo de contacto o exposición física que autorizas durante el encuentro:</p>
                                
                                <div class="checkbox-list">
                                    <?php foreach ( $contacto_f as $val => $label ) : ?>
                                        <label class="cl-checkbox-label">
                                            <input type="checkbox" name="contacto_f[]" value="<?php echo esc_attr( $val ); ?>">
                                            <span class="custom-box"></span>
                                            <span class="label-text"><?php echo esc_html( $label ); ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>

                                <div class="form-group margin-top-md">
                                    <label for="cl-limites">Detalles de límites específicos (si los tienes):</label>
                                    <textarea id="cl-limites" name="limites_especificos" rows="3" placeholder="Describe cualquier límite, zona o tipo de interacción con la que no te sientas cómodo/a..."></textarea>
                                </div>
                            </div>

                            <!-- Medidas de Privacidad -->
                            <div class="consent-group-box block-selection">
                                <label class="cl-checkbox-label align-start">
                                    <input type="checkbox" name="privacidad" value="1" required>
                                    <span class="custom-box"></span>
                                    <span class="label-text">
                                        <strong>Entiendo y acepto las medidas de privacidad *</strong>
                                        <ul class="nested-list">
                                            <?php foreach ( $privacidad as $rule ) : ?>
                                                <li><?php echo esc_html( $rule ); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </span>
                                </label>
                            </div>

                            <!-- Derecho a Pausar/Salir -->
                            <div class="consent-group-box block-selection">
                                <label class="cl-checkbox-label align-start">
                                    <input type="checkbox" name="pausar_salir" value="1" required>
                                    <span class="custom-box"></span>
                                    <span class="label-text">
                                        <strong><?php echo esc_html( $pausar_titulo ); ?></strong>
                                        <span class="sub-label-text"><?php echo esc_html( $pausar_subtexto ); ?></span>
                                    </span>
                                </label>
                            </div>

                            <!-- Fines Antropológicos -->
                            <div class="consent-group-box block-selection">
                                <label class="cl-checkbox-label align-start">
                                    <input type="checkbox" name="testimonios" value="1">
                                    <span class="custom-box"></span>
                                    <span class="label-text">
                                        <strong><?php echo esc_html( $testimonios_titulo ); ?></strong>
                                        <span class="sub-label-text"><?php echo esc_html( $testimonios_subtexto ); ?></span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- 3. Salud y Apoyo Adicional -->
                        <div class="form-group-section">
                            <h2 class="section-title">3. Bienestar y Salud</h2>
                            
                            <div class="form-group">
                                <label for="cl-salud"><?php echo esc_html( $salud_label ); ?></label>
                                <textarea id="cl-salud" name="salud" rows="3" placeholder="<?php echo esc_attr( $salud_placeholder ); ?>"></textarea>
                            </div>

                            <!-- Proceso de Organización -->
                            <div class="consent-group-box block-selection">
                                <label class="cl-checkbox-label align-start">
                                    <input type="checkbox" name="organizacion" value="1" required>
                                    <span class="custom-box"></span>
                                    <span class="label-text">
                                        <strong>Entiendo el proceso de organización *</strong>
                                        <ul class="nested-list">
                                            <?php foreach ( $organizacion as $rule ) : ?>
                                                <li><?php echo esc_html( $rule ); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- 4. Confirmación Final -->
                        <div class="form-group-section final-acknowledgement">
                            <label class="cl-checkbox-label align-start highlight-consent">
                                <input type="checkbox" name="confirmacion_leido" value="1" required>
                                <span class="custom-box gold-box"></span>
                                <span class="label-text">
                                    <strong><?php echo esc_html( $confirmacion_titulo ); ?></strong>
                                    <span class="sub-label-text"><?php echo esc_html( $confirmacion_subtexto ); ?></span>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-wrap">
                            <button type="submit" class="btn-primary btn-block consent-submit-btn">Enviar Formulario de Consentimiento</button>
                            <div id="consentFormMessage"></div>
                        </div>

                    </form>
                </div>
                


            </div>
        </div>
    </section>

</main>

<style>
    /* ==========================================================================
       CSS específico para la página de Consentimiento (Diseño Premium)
       ========================================================================== */
    .consent-page {
        padding-bottom: var(--section-v);
    }
    
    .consent-grid-layout {
        max-width: 800px;
        margin: 40px auto 0 auto;
    }
    
    .consent-form-wrapper {
        background: var(--black-soft);
        border: 1px solid var(--border);
        padding: 50px;
        border-radius: 8px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    
    @media (max-width: 768px) {
        .consent-form-wrapper {
            padding: 24px;
        }
    }
    
    .form-section-intro {
        margin-bottom: 48px;
        padding-bottom: 30px;
        border-bottom: 1px solid var(--border-mid);
    }
    
    .form-section-intro h3 {
        color: var(--accent);
        font-family: var(--font-serif);
        font-size: 1.6rem;
        margin-bottom: 12px;
    }
    
    .form-section-intro p {
        color: var(--white-60);
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .page-gutenberg-content {
        margin: 24px 0;
        color: var(--white-90);
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .page-gutenberg-content img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        display: block;
        margin: 16px auto;
    }
    
    .page-gutenberg-content figure {
        margin: 20px 0;
        text-align: center;
    }
    
    .page-gutenberg-content figcaption {
        font-size: 0.85rem;
        color: var(--white-60);
        margin-top: 8px;
        font-style: italic;
    }
    
    .activity-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 24px;
        background: var(--black-mid);
        padding: 18px;
        border-radius: 4px;
        border-left: 3px solid var(--accent);
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
    }
    
    .meta-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--white-30);
        margin-bottom: 4px;
    }
    
    .meta-value {
        font-size: 0.88rem;
        color: var(--white-90);
        font-weight: 500;
    }
    
    .form-group-section {
        margin-bottom: 48px;
    }
    
    .section-title {
        font-size: 1.8rem;
        color: var(--white);
        margin-bottom: 28px;
        font-family: var(--font-serif);
        border-left: 2px solid var(--accent);
        padding-left: 14px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }
    
    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
    
    .consent-group-box {
        background: var(--black-mid);
        border: 1px solid var(--border);
        padding: 24px;
        border-radius: 6px;
        margin-bottom: 24px;
    }
    
    .consent-group-box.block-selection {
        background: rgba(200, 168, 130, 0.03);
        border-color: rgba(200, 168, 130, 0.15);
    }
    
    .group-title {
        font-family: var(--font-serif);
        font-size: 1.3rem;
        color: var(--white);
        margin-bottom: 6px;
    }
    
    .group-desc {
        font-size: 0.85rem;
        color: var(--white-30);
        margin-bottom: 20px;
    }
    
    /* Custom Checkboxes */
    .checkbox-list, .radio-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    
    .cl-checkbox-label, .cl-radio-label {
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        user-select: none;
        position: relative;
    }
    
    .cl-checkbox-label.align-start, .cl-radio-label.align-start {
        align-items: flex-start;
    }
    
    .cl-checkbox-label input[type="checkbox"],
    .cl-radio-label input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    
    .custom-box, .custom-radio {
        width: 20px;
        height: 20px;
        background-color: transparent;
        border: 1px solid var(--border-mid);
        border-radius: 4px;
        flex-shrink: 0;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .custom-radio {
        border-radius: 50%;
    }
    
    .custom-box::after, .custom-radio::after {
        content: "";
        position: absolute;
        display: none;
    }
    
    .cl-checkbox-label input:checked ~ .custom-box {
        background-color: var(--accent-dim);
        border-color: var(--accent);
    }
    
    .cl-radio-label input:checked ~ .custom-radio {
        border-color: var(--accent);
    }
    
    .cl-checkbox-label input:checked ~ .custom-box::after {
        display: block;
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid var(--accent);
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .cl-radio-label input:checked ~ .custom-radio::after {
        display: block;
        left: 5px;
        top: 5px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--accent);
    }
    
    .cl-checkbox-label .custom-box.gold-box {
        border-color: var(--accent);
    }
    
    .cl-checkbox-label input:checked ~ .custom-box.gold-box {
        background-color: var(--accent);
    }
    
    .cl-checkbox-label input:checked ~ .custom-box.gold-box::after {
        border-color: var(--black);
    }
    
    .label-text {
        color: var(--white-90);
        font-size: 0.92rem;
        line-height: 1.5;
    }
    
    .label-text strong {
        color: var(--white);
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
    }
    
    .sub-label-text {
        font-size: 0.82rem;
        color: var(--white-60);
        display: block;
        margin-top: 4px;
    }
    
    .nested-list {
        margin: 8px 0 0 0;
        padding-left: 18px;
        font-size: 0.82rem;
        color: var(--white-60);
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .nested-list li {
        position: relative;
        list-style-type: disc;
    }
    
    .margin-top-md {
        margin-top: 20px;
    }
    
    .highlight-consent {
        background: rgba(200, 168, 130, 0.05);
        border: 1px solid rgba(200, 168, 130, 0.3);
        padding: 24px;
        border-radius: 6px;
    }
    

    
    .submit-wrap {
        margin-top: 36px;
    }
    
    .consent-submit-btn {
        padding: 18px 24px;
        font-size: 0.95rem;
        letter-spacing: 0.08em;
        font-weight: 500;
        text-transform: uppercase;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const consentForm = document.getElementById('consentForm');
    const formMessage = document.getElementById('consentFormMessage');

    if (consentForm && formMessage) {
        consentForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Client side validation of required checkboxes
            const totalDinamicas = <?php echo count( $dinamicas ); ?>;
            const dinamicasChecked = consentForm.querySelectorAll('input[name="dinamicas[]"]:checked').length;
            if (dinamicasChecked < totalDinamicas) {
                formMessage.innerHTML = `<p style="color: #ff5555; font-size: 0.9rem; margin-top: 16px; text-align:center;">✕ &nbsp;Por favor, confirma tu participación en las ${totalDinamicas} dinámicas requeridas.</p>`;
                window.scrollTo({
                    top: consentForm.querySelector('.checkbox-list').getBoundingClientRect().top + window.scrollY - 150,
                    behavior: 'smooth'
                });
                return;
            }

            const formData = new FormData(consentForm);
            formData.append('action', 'submit_consent');

            const btn = consentForm.querySelector('button[type="submit"]');
            const originalText = btn.textContent;

            btn.textContent = 'Enviando Consentimiento...';
            btn.disabled = true;

            fetch(cl_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.textContent = originalText;
                btn.disabled = false;

                if (data.success) {
                    formMessage.innerHTML = `<div style="background: rgba(200, 168, 130, 0.1); border: 1px solid var(--accent); color: var(--accent); padding: 18px; border-radius: 6px; font-size: 0.95rem; margin-top: 24px; text-align:center; letter-spacing:0.05em; line-height:1.5;"><strong>✓ &nbsp;${data.data.message}</strong><br><span style="font-size:0.8rem; color:rgba(255,255,255,0.7);">Los datos han sido enviados de forma segura al facilitador y registrados en el sistema.</span></div>`;
                    consentForm.reset();
                    // Scroll to message
                    formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    formMessage.innerHTML = `<p style="color: #ff5555; font-size: 0.9rem; margin-top: 16px; text-align:center;">✕ &nbsp;${data.data.message}</p>`;
                }
            })
            .catch(error => {
                btn.textContent = originalText;
                btn.disabled = false;
                formMessage.innerHTML = `<p style="color: #ff5555; font-size: 0.9rem; margin-top: 16px; text-align:center;">✕ &nbsp;Error de conexión. Por favor, intenta de nuevo.</p>`;
            });
        });
    }
});
</script>

<?php
get_footer();
