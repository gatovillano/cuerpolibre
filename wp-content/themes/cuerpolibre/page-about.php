<?php
/**
 * Template Name: Acerca de Mí
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main about-page">

        <!-- Page Hero -->
        <section class="page-hero">
            <div class="page-hero-bg-text" aria-hidden="true">A</div>
            <div class="container">
                <span class="page-hero-eyebrow">La mirada detrás de la lente</span>
                <h1>Acerca de mí</h1>
                <p class="subtitle">Fotógrafo artístico apasionado por la belleza auténtica del cuerpo humano</p>
            </div>
        </section>

        <!-- Photographer Info -->
        <section class="photographer-section">
            <div class="container">
                <div class="photographer-grid">
                    <div class="photographer-portrait reveal" data-caption="gatovillano.cl">
                        <img
                            src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/photographer.jpg"
                            alt="Fotógrafo Cuerpo Libre"
                            onerror="this.closest('.photographer-portrait').style.background='#141414';this.style.height='460px';this.style.display='none'"
                        >
                    </div>

                    <div class="photographer-text reveal reveal-delay-2">
                        <span class="section-label">Mi historia</span>
                        <div class="section-divider"></div>
                        <h2>Un viaje fotográfico</h2>

                        <p>Me dicen Gato y mi nombre es Sebastián. Soy el fotógrafo detrás de Cuerpo Libre, oficialmente hace 14 años, aunque exploro la fotografía desde mi adolescencia. Mi formación es de fotografía periodística, lo que se expresa profundamente en la estética de mi trabajo, buscando siempre la verdad y la emoción detrás de la imagen.</p>

                        <p>En mi trayectoria he tenido diferentes focos de trabajo, como la fotografía documental de carácter social, periodística en general y fotografía artística de naturaleza. Recientemente he abierto este nuevo campo del retrato fotográfico artístico enfocándome en desnudos, un espacio donde la luz, la sombra y la composición transforman lo físico en algo emocionalmente profundo.</p>

                        <p>Mi trabajo se centra en desmitificar el desnudo, presentándolo no como algo vulgar, sino como una expresión de vulnerabilidad, fuerza y autenticidad. Cada sesión es un proceso de colaboración íntima, construida sobre la confianza mutua y el respeto absoluto, con la meta de que cada persona se sienta vista, valorada y hermosa.</p>


                    </div>
                </div>
            </div>
        </section>

        <!-- Philosophy -->
        <section class="philosophy-section">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Mi filosofía</span>
                    <div class="section-divider"></div>
                    <h2>Los pilares de mi trabajo</h2>
                    <p>Cada imagen que creo está guiada por estos principios fundamentales</p>
                </div>

                <div class="philosophy-grid">
                    <div class="philosophy-item reveal reveal-delay-1">
                        <span class="philosophy-icon">◇</span>
                        <h3>Autenticidad</h3>
                        <p>Capturo la verdadera esencia de cada persona, celebrando sus imperfecciones y fortalezas únicas sin filtros ni retoques excesivos.</p>
                    </div>
                    <div class="philosophy-item reveal reveal-delay-2">
                        <span class="philosophy-icon">◈</span>
                        <h3>Arte</h3>
                        <p>Cada imagen es una composición cuidadosamente diseñada, donde la luz y la sombra crean narrativas visuales de profunda belleza.</p>
                    </div>
                    <div class="philosophy-item reveal reveal-delay-3">
                        <span class="philosophy-icon">◉</span>
                        <h3>Respeto</h3>
                        <p>Mi trabajo está basado en el consentimiento pleno, la confianza absoluta y el respeto por la dignidad de cada co-creador.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section reveal">
            <div class="container">
                <h2>¿Listo para crear arte juntos?</h2>
                <p>Si te sientes inspirado por mi trabajo y quieres explorar tu propia belleza a través de la fotografía artística, estaré encantado de escucharte.</p>
                <a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>" class="btn-primary btn-arrow">Haz tu sesión</a>
            </div>
        </section>

    </main><!-- #primary -->

<?php
get_footer();
?>
