<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script>document.documentElement.className = document.documentElement.className.replace('no-js', 'js');</script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'cuerpolibre' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <!-- Branding -->
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img 
                            src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/solo-ojo-sinfondo.png" 
                            alt="<?php bloginfo( 'name' ); ?>" 
                            class="custom-logo"
                            onerror="this.style.display='none'"
                        >
                        <span class="site-title screen-reader-text"><?php bloginfo( 'name' ); ?></span>
                    </a>
                    <?php
                }
                ?>
            </div><!-- .site-branding -->

            <!-- Menu Button -->
            <button class="menu-open-btn" id="menuOpenBtn" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menú', 'cuerpolibre' ); ?>">
                <span class="menu-open-btn__bars">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <span class="menu-open-btn__label">Menú</span>
            </button>
        </div>
    </header><!-- #masthead -->

    <!-- FullScreen Nav Overlay -->
    <div id="navOverlay" class="nav-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menú de navegación', 'cuerpolibre' ); ?>">
        <button class="nav-overlay__close" id="navOverlayClose" aria-label="<?php esc_attr_e( 'Cerrar menú', 'cuerpolibre' ); ?>">
            <span></span>
            <span></span>
        </button>

        <nav id="site-navigation" class="nav-overlay__nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'cuerpolibre' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false,
                )
            );
            ?>
            <?php if ( ! has_nav_menu( 'menu-1' ) ) : ?>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
                <li><a href="<?php echo esc_url( home_url( '/acerca-de-mi' ) ); ?>">Acerca de mí</a></li>
                <li><a href="<?php echo esc_url( home_url( '/el-proyecto' ) ); ?>">El Proyecto</a></li>
                <li><a href="<?php echo esc_url( home_url( '/manifiesto' ) ); ?>">Manifiesto</a></li>
                <li><a href="<?php echo esc_url( home_url( '/galeria' ) ); ?>">Galería</a></li>
                <li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Blog</a></li>
                <li><a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>">Haz tu Sesión</a></li>
            </ul>
            <?php endif; ?>
        </nav>

        <div class="nav-overlay__footer">
            <span class="nav-overlay__tagline"><?php bloginfo( 'description' ); ?></span>
        </div>

        <div class="nav-overlay__deco" aria-hidden="true"></div>
    </div><!-- #navOverlay -->