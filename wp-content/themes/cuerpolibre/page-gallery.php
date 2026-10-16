<?php
/**
 * Template Name: Galerías
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main gallery-page">

        <!-- Page Hero -->
        <section class="page-hero">
            <div class="page-hero-bg-text" aria-hidden="true">G</div>
            <div class="container">
                <span class="page-hero-eyebrow">Colecciones artísticas</span>
                <h1>Galería</h1>
                <p class="subtitle">Obras fotográficas que exploran la forma humana, la luz y la emoción</p>
            </div>
        </section>

        <!-- Gallery Categories -->
        <section class="gallery-categories-section">
            <div class="container">
                <div class="section-header reveal">
                    <span class="section-label">Series</span>
                    <div class="section-divider"></div>
                    <h2>Colecciones</h2>
                    <p>Explora nuestras series fotográficas, cada una con su propia narrativa visual y emocional</p>
                </div>

                <div class="categories-grid">
                <?php
                $args = array(
                    'post_type'      => 'cuerpolibre_gallery',
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                );
                $gallery_query = new WP_Query( $args );

                if ( $gallery_query->have_posts() ) :
                    $i = 0;
                    while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
                        $delay = ( $i % 2 !== 0 ) ? 'reveal-delay-1' : '';
                        $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                        if ( empty( $thumb_url ) ) {
                            $content = apply_filters( 'the_content', get_the_content() );
                            if ( preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches ) ) {
                                $thumb_url = str_replace( 'http://localhost:9005', 'https://cuerpolibre.cl', $matches[1] );
                            }
                        }
                        ?>
                        <div class="category-item reveal <?php echo esc_attr( $delay ); ?>">
                            <?php if ( $thumb_url ) : ?>
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div class="category-placeholder"></div>
                            <?php endif; ?>
                            
                            <div class="category-overlay">
                                <h3><?php the_title(); ?></h3>
                                <p><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn-secondary">Ver galería</a>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="no-posts-found" style="grid-column: 1 / -1; text-align: center; padding: 100px 0; color: var(--white-30);">
                        <p>Próximamente compartiremos nuevas series artísticas.</p>
                        <p style="font-size: 0.8rem;">(Crea tu primera Galería en el panel lateral de WordPress para verla aquí)</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Featured Gallery -->
        <section class="featured-gallery-section">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Selección</span>
                    <div class="section-divider"></div>
                    <h2>Obras destacadas</h2>
                    <p>Una selección de nuestras imágenes más recientes</p>
                </div>

                <div class="featured-grid">
                    <?php
                    $featured_images = get_random_vertical_gallery_images( 8 );
                    
                    if ( ! empty( $featured_images ) ) :
                        $i = 1;
                        foreach ( $featured_images as $img ) :
                            $delay = ( $i <= 4 ) ? 'reveal-delay-' . $i : '';
                            ?>
                            <div class="featured-item reveal <?php echo esc_attr( $delay ); ?>">
                                <img
                                    src="<?php echo esc_url( $img['url'] ); ?>"
                                    alt="Obra Destacada <?php echo $i; ?>"
                                >
                                <div class="featured-overlay">
                                    <span class="featured-title">Obra <?php printf( '%02d', $i ); ?></span>
                                </div>
                            </div>
                            <?php
                            $i++;
                        endforeach;
                    else :
                        // Fallback to placeholders if no images found
                        for ( $i = 1; $i <= 8; $i++ ) {
                            $delay = ( $i <= 4 ) ? 'reveal-delay-' . $i : '';
                            ?>
                            <div class="featured-item reveal <?php echo esc_attr( $delay ); ?>">
                                <img
                                    src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/featured-<?php echo $i; ?>.jpg"
                                    alt="Obra Destacada <?php echo $i; ?>"
                                    onerror="this.closest('.featured-item').style.background='#141414';this.style.display='none'"
                                >
                                <div class="featured-overlay">
                                    <span class="featured-title">Obra <?php printf( '%02d', $i ); ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section reveal">
            <div class="container">
                <h2>¿Quieres ser parte de una obra?</h2>
                <p>Agenda tu sesión y convierte tu cuerpo en arte fotográfico.</p>
                <a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>" class="btn-primary btn-arrow">Reservar sesión</a>
            </div>
        </section>

    </main><!-- #primary -->

<?php
get_footer();
?>
