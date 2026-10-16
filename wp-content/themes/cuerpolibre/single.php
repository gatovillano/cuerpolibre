<?php
/**
 * The template for displaying all single posts (Blog).
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main single-post">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>

            <!-- Post Hero -->
            <section class="post-hero" style="padding: 180px 0 80px; background: var(--black); text-align: center;">
                <div class="container reveal">
                    <span class="section-label" style="margin-bottom: 24px; display: block;"><?php the_category( ', ' ); ?></span>
                    <h1 style="max-width: 800px; margin: 0 auto 24px;"><?php the_title(); ?></h1>
                    <div class="post-meta" style="color: var(--white-60); font-size: 0.9rem; font-family: var(--font-sans); letter-spacing: 0.05em; text-transform: uppercase;">
                        <span><?php echo get_the_date(); ?></span>
                    </div>
                </div>
            </section>

            <?php if ( has_post_thumbnail() ) : ?>
                <section class="post-featured-image reveal" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
                    <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: auto; display: block; border-radius: 4px;">
                </section>
            <?php endif; ?>

            <!-- Post Content -->
            <section class="post-content-section" style="padding: 80px 0;">
                <div class="container" style="max-width: 800px;">
                    <div class="entry-content" style="font-size: 1.15rem; line-height: 1.9; color: var(--white-90);">
                        <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__( 'Páginas:', 'cuerpolibre' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div><!-- .entry-content -->
                    
                    <div class="post-footer" style="margin-top: 80px; padding-top: 40px; border-top: 1px solid var(--border-mid); display: flex; justify-content: space-between; align-items: center;">
                        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn-secondary btn-arrow" style="flex-direction: row-reverse;">Volver al Blog</a>
                    </div>
                </div>
            </section>

            <?php
        endwhile;
        ?>
    </main>

<?php
get_footer();
?>
