<?php
/**
 * Template Name: Política de Privacidad
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main privacy-page">

        <section class="page-hero small-hero">
            <div class="container">
                <h1>Política de<br>Privacidad</h1>
            </div>
        </section>

        <section class="privacy-content-section">
            <div class="container">
                <div class="privacy-content reveal">
                    <h2>Tu privacidad es fundamental</h2>
                    <p>En Cuerpo Libre, la confianza es la base de todo trabajo artístico y personal. Por ello, me comprometo a proteger tus datos y tu intimidad bajo los siguientes principios directos:</p>

                    <div class="privacy-grid">
                        <div class="privacy-item">
                            <h3>Canales Establecidos</h3>
                            <p>Toda la información personal, datos de contacto y material fotográfico se manejará exclusivamente a través de nuestros canales oficiales. La información <strong>no saldrá bajo ninguna circunstancia</strong> de los medios de contacto establecidos conmigo.</p>
                        </div>
                        <div class="privacy-item">
                            <h3>No Divulgación</h3>
                            <p>Tus datos no serán vendidos, cedidos ni compartidos con terceros. La información recolectada tiene como único fin la coordinación técnica y artística de tu sesión.</p>
                        </div>
                        <div class="privacy-item">
                            <h3>Consentimiento Explícito</h3>
                            <p>Ninguna sesión será publicada en portafolios o redes sociales sin que exista un consentimiento explícito, firmado y por escrito de tu parte antes de cualquier difusión.</p>
                        </div>
                        <div class="privacy-item">
                            <h3>Resguardo Total</h3>
                            <p>Tengo protocolos estrictos para el almacenamiento del material digital, asegurando que tu registro personal sea tratado con la máxima dignidad y respeto.</p>
                        </div>
                    </div>

                    <div class="privacy-footer-note">
                        <p>Si tienes cualquier duda adicional, la conversaremos en nuestro encuentro previo.</p>
                        <a href="<?php echo esc_url( home_url( '/haz-tu-sesion' ) ); ?>" class="btn-primary">Entendido, volver</a>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- #primary -->

<?php
get_footer();
?>
