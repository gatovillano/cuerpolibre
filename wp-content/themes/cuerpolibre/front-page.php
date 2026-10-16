<?php
/**
 * Front Page Template for Cuerpo Libre
 *
 * Fully editable with Elementor. Includes premium fallback content.
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main front-page">
        <?php
        // If Elementor is active and built with Elementor (or in edit mode), show ONLY Elementor
        if ( defined( 'ELEMENTOR_VERSION' ) && ( \Elementor\Plugin::instance()->db->is_built_with_elementor( get_the_ID() ) || \Elementor\Plugin::instance()->editor->is_edit_mode() ) ) {
            if ( have_posts() ) : while ( have_posts() ) : the_post();
                the_content();
            endwhile; endif;
        } else {
            // Show our custom premium design
        ?>

        <!-- ══════════ HERO ══════════ -->
        <section class="hero-section" id="hero">
            <div class="hero-bg"></div>

            <div class="hero-content">
                <div class="hero-logo-wrap">
                    <img
                        src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/solo-ojo-sinfondo.png"
                        alt="<?php bloginfo( 'name' ); ?>"
                        class="hero-logo-img"
                        onerror="this.style.display='none'"
                    >
                </div>

                <div class="hero-title-wrap">
                    <h1 class="hero-title">
                        <span class="line-1">Cuerpo</span>
                        <span class="line-2">Libre</span>
                    </h1>
                    <span class="hero-fotografia-text">Fotografía</span>
                </div>

                <p class="hero-subtitle">La belleza humana en su expresión más auténtica</p>

                <div class="hero-cta">
                    <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-primary btn-arrow">Ver Galerías</a>
                    <a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>" class="btn-secondary btn-arrow">Reservar Sesión</a>
                </div>
            </div>

            <div class="hero-scroll">
                <span>Scroll</span>
                <div class="scroll-line"></div>
            </div>
        </section>

        <!-- ══════════ QUOTE SECTION ══════════ -->
        <section id="big-quote" class="home-quote reveal">
            <div class="container">
                <div class="quote-wrapper quote-columns">
                    <div class="quote-column quote-text-column">
                        <div class="quote-icon">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 11L8 17H5L7 11V7H11V11H10ZM18 11L16 17H13L15 11V7H19V11H18Z" fill="var(--accent)" fill-opacity="0.2"/>
                            </svg>
                        </div>
                        <blockquote class="quote-text">
                            El desnudo fotográfico expresa desde un lenguaje íntimo mucho más que la corporalidad y sus formas. Puede llegar a exponer nuestra propia noción del cuerpo, la sexualidad y parte de nuestra identidad. Frente al lente, abre nuestra vulnerabilidad, hablando de la perspectiva personal de deseo, intimidad, fortaleza y fragilidad. Se transforma en un espejo y diálogo de creación conjunta, que activa nuestra conexión con nosotros y nuestros cuerpos.
                        </blockquote>
                        <div class="quote-divider"></div>
                    </div>
                    <div class="quote-column quote-image-column">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/quote-image.jpg" alt="Fotografía artística" class="quote-section-image">
                    </div>
                </div>
            </div>
        </section>r

        <!-- ══════════ ABOUT PREVIEW ══════════ -->
        <section class="home-about reveal">
            <div class="container">
                <div class="inner">
                    <div class="home-about-image reveal reveal-delay-1">
                        <img
                            src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/about.jpg"
                            alt="Fotógrafo Cuerpo Libre"
                            onerror="this.closest('.home-about-image').style.background='#141414';this.style.display='none'"
                        >
                    </div>
                    <div class="home-about-text reveal reveal-delay-2">
                        <span class="section-label">Acerca de mí</span>
                        <div class="section-divider"></div>
                        <h2>La mirada detrás de la lente</h2>
                        <p>Me dicen Gato y mi nombre es Sebastián. Soy un fotógrafo con 14 años de trayectoria y formación periodística, apasionado por explorar la diversidad y belleza humana a través del desnudo artístico como hecho reivindicativo.</p>
                        <p>Mi trabajo celebra la forma, la luz y la expresividad del cuerpo en su estado más natural, auténtico y vulnerable, buscando siempre la verdad y la emoción detrás de la imagen.</p>
                        <a href="<?php echo esc_url( home_url( '/acerca-de-mi' ) ); ?>" class="btn-secondary btn-arrow" style="margin-top:16px;">Conoce mi historia</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════ GALLERY PREVIEW ══════════ -->
        <section class="home-gallery">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Galería</span>
                    <div class="section-divider"></div>
                    <h2>Colecciones destacadas</h2>
                    <p>Exploraciones visuales del cuerpo humano en su diversidad y belleza singular</p>
                </div>

                <div class="gallery-preview-grid">
                <?php
                $args = array(
                    'post_type'      => 'cuerpolibre_gallery',
                    'posts_per_page' => 3,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
                $home_gallery_query = new WP_Query( $args );

                if ( $home_gallery_query->have_posts() ) :
                    $i = 1;
                    while ( $home_gallery_query->have_posts() ) : $home_gallery_query->the_post();
                        $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                        if ( empty( $thumb_url ) ) {
                            $content = apply_filters( 'the_content', get_the_content() );
                            if ( preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches ) ) {
                                $thumb_url = str_replace( 'http://localhost:9005', 'https://cuerpolibre.cl', $matches[1] );
                            }
                        }
                        ?>
                        <div class="gallery-preview-item reveal reveal-delay-<?php echo $i; ?>">
                            <?php if ( $thumb_url ) : ?>
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div class="gallery-placeholder" style="background: #141414; width: 100%; height: 100%;"></div>
                            <?php endif; ?>
                            
                            <div class="overlay">
                                <div class="overlay-content">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php echo wp_trim_words( get_the_excerpt(), 10 ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn-secondary">Ver galería</a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback if no galleries created yet
                    for ( $i = 1; $i <= 3; $i++ ) :
                        ?>
                        <div class="gallery-preview-item reveal reveal-delay-<?php echo $i; ?>">
                            <div class="gallery-placeholder" style="background: #141414; width: 100%; height: 100%;"></div>
                            <div class="overlay">
                                <div class="overlay-content">
                                    <h3>Galería de ejemplo <?php echo $i; ?></h3>
                                    <p>Próximamente compartiremos nuevas series artísticas.</p>
                                    <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-secondary">Ver todas</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endfor;
                endif;
                ?>
            </div>

                <div style="text-align:center; padding: 56px 0 0;">
                    <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-primary btn-arrow">Ver todas las galerías</a>
                </div>
            </div>
        </section>

        <!-- ══════════ PROJECT PREVIEW ══════════ -->
        <section class="home-project">
            <div class="container">
                <div class="section-header reveal">
                    <span class="section-label">El Proyecto</span>
                    <div class="section-divider"></div>
                    <h2>Un movimiento de<br>aceptación y arte</h2>
                    <p>Cuerpo Libre es un proyecto fotográfico de desnudo erótico con carga pornográfica suave, que sitúa al cuerpo como territorio de enunciación, resistencia y celebración.</p>
                    <a href="<?php echo esc_url( home_url( '/el-proyecto' ) ); ?>" class="btn-secondary btn-arrow" style="margin-top:32px;">Conocer el proyecto</a>
                </div>

                <div class="project-values-grid">
                    <div class="value-item reveal reveal-delay-1">
                        <span class="value-number">01</span>
                        <h3>Diversidad Radical</h3>
                        <p>Cuerpos de todas las edades, tallas, géneros, capacidades e identidades. Sin castings ni selección estética previa.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-2">
                        <span class="value-number">02</span>
                        <h3>Consentimiento Dinámico</h3>
                        <p>Un diálogo continuo antes, durante y después de la sesión. El "no" es siempre una opción celebrada.</p>
                    </div>
                    <div class="value-item reveal reveal-delay-3">
                        <span class="value-number">03</span>
                        <h3>Co-creación Artística</h3>
                        <p>El participante no es un modelo pasivo; es co-autor de las imágenes. Su perspectiva y límites moldean la sesión.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════ BLOG PREVIEW ══════════ -->
        <section class="home-blog" style="padding: var(--section-v) 0; background: var(--black-soft);">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Blog</span>
                    <div class="section-divider"></div>
                    <h2>Últimos Artículos</h2>
                    <p>Reflexiones, novedades y experiencias detrás del lente</p>
                </div>

                <div class="gallery-preview-grid">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
                $home_blog_query = new WP_Query( $args );

                if ( $home_blog_query->have_posts() ) :
                    $i = 1;
                    while ( $home_blog_query->have_posts() ) : $home_blog_query->the_post();
                        $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                        if ( empty( $thumb_url ) ) {
                            $content = apply_filters( 'the_content', get_the_content() );
                            if ( preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches ) ) {
                                $thumb_url = str_replace( 'http://localhost:9005', 'https://cuerpolibre.cl', $matches[1] );
                            }
                        }
                        ?>
                        <div class="gallery-preview-item reveal reveal-delay-<?php echo $i; ?>">
                            <?php if ( $thumb_url ) : ?>
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div class="gallery-placeholder" style="background: #141414; width: 100%; height: 100%;"></div>
                            <?php endif; ?>
                            
                            <div class="overlay">
                                <div class="overlay-content">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn-secondary">Leer más</a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback if no posts created yet
                    for ( $i = 1; $i <= 3; $i++ ) :
                        ?>
                        <div class="gallery-preview-item reveal reveal-delay-<?php echo $i; ?>">
                            <div class="gallery-placeholder" style="background: #141414; width: 100%; height: 100%;"></div>
                            <div class="overlay">
                                <div class="overlay-content">
                                    <h3>Artículo de ejemplo <?php echo $i; ?></h3>
                                    <p>Próximamente compartiremos nuevas historias y reflexiones.</p>
                                    <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn-secondary">Leer más</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endfor;
                endif;
                ?>
            </div>

                <div style="text-align:center; padding: 56px 0 0;">
                    <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn-primary btn-arrow">Ver todos los artículos</a>
                </div>
            </div>
        </section>

        <!-- ══════════ CTA ══════════ -->
        <section class="cta-section reveal">
            <div class="container">
                <h2>¿Listo para tu experiencia fotográfica?</h2>
                <p>Consulta inicial gratuita y sin compromiso. Descubre tu belleza a través de una sesión artística personalizada.</p>
                <a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>" class="btn-primary btn-arrow">Reserva tu sesión</a>
            </div>
        </section>

        <?php } ?>
    </main><!-- #primary -->

<?php
get_footer();
?>