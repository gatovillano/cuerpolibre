<?php
/**
 * Template for displaying single photography galleries
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main single-gallery">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>

            <!-- Gallery Hero -->
            <section class="gallery-hero">
                <div class="container centered reveal">
                    <span class="section-label"><?php esc_html_e( 'Colección Artística', 'cuerpolibre' ); ?></span>
                    <div class="section-divider"></div>
                    <h1><?php the_title(); ?></h1>
                    <?php if ( has_excerpt() ) : ?>
                        <div class="gallery-description">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Gallery Content -->
            <section class="gallery-content-section">
                <div class="container container-wide">
                    <div class="gallery-content-wrapper">
                        <?php
                        // The user can add photos using the Block Editor (Gallery Block)
                        // or just inserting images. the_content() will render them.
                        the_content();
                        ?>
                    </div>
                    
                    <div class="gallery-footer centered reveal">
                        <a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>" class="btn-secondary btn-arrow">Volver a Galerías</a>
                    </div>
                </div>
            </section>

            <?php
        endwhile;
        ?>
    </main>

<?php
get_footer();
