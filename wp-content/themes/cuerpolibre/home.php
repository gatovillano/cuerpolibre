<?php
/**
 * The template for displaying the blog posts index (Blog section).
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main blog-page">

        <!-- Page Hero -->
        <section class="page-hero">
            <div class="page-hero-bg-text" aria-hidden="true">B</div>
            <div class="container">
                <span class="page-hero-eyebrow">Historias y Reflexiones</span>
                <h1>El Blog</h1>
                <p class="subtitle">Pensamientos, novedades y experiencias detrás del lente</p>
            </div>
        </section>

        <!-- Blog Posts Grid -->
        <section class="home-blog-section" style="padding: 80px 0;">
            <div class="container">
                <div class="gallery-preview-grid" style="margin-top: 0;">
                    <?php
                    if ( have_posts() ) :
                        $i = 1;
                        while ( have_posts() ) : the_post();
                            $delay = 'reveal-delay-' . (($i % 3) + 1);
                            $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                            if ( empty( $thumb_url ) ) {
                                $content = apply_filters( 'the_content', get_the_content() );
                                if ( preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches ) ) {
                                    $thumb_url = str_replace( 'http://localhost:9005', 'https://cuerpolibre.cl', $matches[1] );
                                }
                            }
                            ?>
                            <div class="gallery-preview-item reveal <?php echo esc_attr( $delay ); ?>">
                                <?php if ( $thumb_url ) : ?>
                                    <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php else : ?>
                                    <div class="gallery-placeholder" style="background: #141414; width: 100%; height: 100%;"></div>
                                <?php endif; ?>
                                
                                <div class="overlay">
                                    <div class="overlay-content">
                                        <h3><?php the_title(); ?></h3>
                                        <p><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="btn-secondary">Leer más</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        endwhile;
                    else :
                        ?>
                        <div class="no-posts-found" style="grid-column: 1 / -1; text-align: center; padding: 100px 0; color: var(--white-30);">
                            <p>Próximamente compartiremos nuevas historias.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="cuerpo-pagination" style="margin-top: 60px; text-align: center;">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( '← Anterior', 'cuerpolibre' ),
                        'next_text' => __( 'Siguiente →', 'cuerpolibre' ),
                    ) );
                    ?>
                </div>
            </div>
        </section>

    </main><!-- #primary -->

<?php
get_footer();
?>
