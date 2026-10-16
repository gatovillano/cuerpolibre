    <!-- Footer -->
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-top">
                <!-- Brand column -->
                <div class="footer-brand">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <span class="site-title"><?php bloginfo( 'name' ); ?></span>
                    <?php endif; ?>
                    <p>Fotografía artística del cuerpo humano.<br>Un espacio seguro para celebrar la belleza en todas sus formas.</p>
                </div>

                <!-- Nav column -->
                <div class="footer-col">
                    <h4>Navegación</h4>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/acerca-de-mi' ) ); ?>">Acerca de mí</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/el-proyecto' ) ); ?>">El Proyecto</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/manifiesto' ) ); ?>">Manifiesto</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>">Galería</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>">Haz tu Sesión</a></li>
                    </ul>
                </div>

                <!-- Contact column -->
                <div class="footer-col">
                    <h4>Contacto</h4>
                    <ul>
                        <li>
                            <a href="mailto:gato@cuerpolibre.cl">gato@cuerpolibre.cl</a>
                        </li>
                        <li>
                            <a href="https://wa.me/56956816585" target="_blank" rel="noopener noreferrer" class="footer-whatsapp-link">
                                <svg class="footer-whatsapp-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                +56 9 5681 6585
                            </a>
                        </li>
                        <li><a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>">Reservar sesión</a></li>
                    </ul>
                </div>
            </div><!-- .footer-top -->

            <div class="footer-bottom">
                <p class="footer-copy">
                    &copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                    &nbsp;·&nbsp; Fotografía Artística
                    &nbsp;·&nbsp; Diseño por <a href="https://gatovillano.cl" target="_blank" rel="noopener">Gato Villano Fotos</a>
                </p>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Lightbox Container -->
<div id="cl-lightbox" class="cl-lightbox">
    <button class="cl-lightbox-close" id="lightboxClose" aria-label="Cerrar">&times;</button>
    <button class="cl-lightbox-nav cl-lightbox-prev" id="lightboxPrev" aria-label="Anterior">&lsaquo;</button>
    <div class="cl-lightbox-content">
        <img src="" alt="" id="lightboxImg">
        <div class="cl-lightbox-caption" id="lightboxCaption"></div>
    </div>
    <button class="cl-lightbox-nav cl-lightbox-next" id="lightboxNext" aria-label="Siguiente">&rsaquo;</button>
</div>

<!-- Age Verification Modal -->
<div id="age-verification" class="age-verification-overlay">
    <div class="age-verification-content">
        <div class="age-logo-wrap">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/solo-ojo-sinfondo.png" alt="<?php bloginfo( 'name' ); ?>" class="age-logo">
        </div>
        <h2 class="age-title">Bienvenido a Cuerpo Libre</h2>
        <p class="age-text">Este sitio contiene material fotográfico de desnudo artístico.<br>Debes ser mayor de edad para ingresar.</p>
        <div class="age-buttons">
            <button id="age-confirm" class="btn-primary">Tengo +18 años</button>
            <button id="age-exit" class="btn-secondary">Salir</button>
        </div>
    </div>
</div>


<?php wp_footer(); ?>

</body>
</html>