<?php
/**
 * Template Name: El Proyecto
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main project-page">

        <!-- Page Hero -->
        <section class="page-hero">
            <div class="page-hero-bg-text" aria-hidden="true">P</div>
            <div class="container">
                <span class="page-hero-eyebrow">Nuestra misión y valores</span>
                <h1>El Proyecto</h1>
                <p class="subtitle">Celebrando la belleza del cuerpo humano en todas sus formas y expresiones</p>
            </div>
        </section>

        <!-- Project Introduction -->
        <section class="project-intro-section">
            <div class="container">
                <div class="project-intro-grid">
                    <div class="reveal">
                        <span class="section-label">¿Qué es Cuerpo Libre?</span>
                        <div class="section-divider"></div>
                        <h2>Más que fotografía,<br>un movimiento</h2>
                        <p>Cuerpo Libre es un movimiento que busca redefinir la percepción del cuerpo humano en la sociedad contemporánea. Mi enfoque en la fotografía de desnudos eróticos, con una carga pornográfica suave, busca aportar a una redefinición de la ontología del deseo y el cuerpo al centrarse en la diversidad y pluralidad de las corporalidades y formas de expresar el placer. Buscamos mostrar la belleza en todas sus formas, sin juicios ni limitaciones.</p>
                        <p>A través de mi mirada, busco capturar no solo cuerpos hegemónicos, sino también aquellos que trascienden los cánones tradicionales de belleza y sensualidad, creando espacio para la inclusión, el placer y la vulnerabilidad. Mis sesiones invitan a reconectar con el propio cuerpo, capturando su belleza singular más allá de los "ideales" impuestos. Es una reflexión sobre lo erótico como un acto profundamente humano y liberador, donde el cuerpo se convierte en sujeto de deseo propio, y en un territorio de enunciación, reconocimiento y reafirmación personal.</p>
                    </div>
                    <div class="reveal reveal-delay-2">
                        <img
                            src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/project-main.jpg"
                            alt="Cuerpo Libre - Fotografía Artística"
                            class="project-featured-image"
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="mission-section">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Propósito</span>
                    <div class="section-divider"></div>
                    <h2>Misión y Visión</h2>
                </div>

                <div class="mission-grid">
                    <div class="mission-item reveal reveal-delay-1">
                        <h2>Misión</h2>
                        <p>Investigar y repensar el desnudo erótico a través de una práctica de co-creación artística basada en el consentimiento dinámico, situando al cuerpo como territorio de enunciación, placer y diversidad radical.</p>
                    </div>
                    <div class="mission-item reveal reveal-delay-2">
                        <h2>Visión</h2>
                        <p>Consolidar una plataforma artística y conceptual que cuestione los cánones estéticos hegemónicos, promoviendo una nueva ontología del deseo donde cada cuerpo sea celebrado como un archivo vivo y un sujeto ético autónomo.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values -->
        <section class="values-section">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Pilares</span>
                    <div class="section-divider"></div>
                    <h2>Nuestros Principios</h2>
                    <p>Los principios que guían cada sesión y cada imagen que creamos</p>
                </div>

                <div class="values-grid">
                    <div class="value-item reveal reveal-delay-1">
                        <span class="value-number">01</span>
                        <h3>Diversidad Radical</h3>
                        <p>Cuerpos de todas las edades, tallas, géneros, capacidades, identidades y trayectorias. Sin casting ni selección estética previa.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-2">
                        <span class="value-number">02</span>
                        <h3>Mirada No Objetificada</h3>
                        <p>La cámara no consume el cuerpo; lo escucha. Enfoque en texturas, formas, contornos y pliegues: la geografía única de la piel.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-3">
                        <span class="value-number">03</span>
                        <h3>Erotismo como Liberación</h3>
                        <p>El erotismo entendido como transgresión de normas sociales para el autoconocimiento y la reapropiación del placer.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-1">
                        <span class="value-number">04</span>
                        <h3>Consentimiento Dinámico</h3>
                        <p>Un diálogo continuo antes, durante y después de la sesión. El "no" es siempre una opción válida y celebrada.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-2">
                        <span class="value-number">05</span>
                        <h3>Co-creación Artística</h3>
                        <p>El participante no es un modelo pasivo; es co-autor de las imágenes. Su perspectiva y límites moldean la sesión.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-3">
                        <span class="value-number">06</span>
                        <h3>Estética Documental</h3>
                        <p>Momentos no posados, luz natural, verdad del gesto y ausencia de retoques que alteren la historia y marcas de la piel.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section reveal">
            <div class="container">
                <h2>Únete a la misión</h2>
                <p>Si crees en la belleza de la diversidad y quieres ser parte de este movimiento, contáctanos hoy.</p>
                <a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>" class="btn-primary btn-arrow">Haz tu sesión</a>
            </div>
        </section>

    </main><!-- #primary -->

<?php
get_footer();
?>
