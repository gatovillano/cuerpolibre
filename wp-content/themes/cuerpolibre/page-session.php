<?php
/**
 * Template Name: Haz tu Sesión
 *
 * @package Cuerpo_Libre
 */

get_header();
?>

    <main id="primary" class="site-main session-page">

        <!-- Page Hero -->
        <section class="page-hero">
            <div class="page-hero-bg-text" aria-hidden="true">S</div>
            <div class="container">
                <span class="page-hero-eyebrow">Tu experiencia fotográfica</span>
                <h1>Haz tu<br>Sesión</h1>
                <p class="subtitle">Un proceso íntimo y seguro diseñado para que te sientas completamente libre</p>
            </div>
        </section>

        <!-- Session Info -->
        <section class="session-info-section">
            <div class="container">
                <div class="session-info-grid">
                    <div class="reveal">
                        <span class="section-label">Cómo funciona</span>
                        <div class="section-divider"></div>
                        <h2>Tu experiencia, paso a paso</h2>
                        <p>Una sesión con Cuerpo Libre es más que una simple foto; es un viaje de autodescubrimiento y expresión artística. Te guiaré a través de todo el proceso, desde la planificación hasta la entrega final.</p>

                        <div class="session-steps">
                            <div class="step">
                                <div class="step-number">01</div>
                                <div class="step-content">
                                    <h3>Encuentro previo</h3>
                                    <p>Nos reunimos vía online o presencial para coordinar expectativas, vestuario y ganar confianza antes del día de la sesión.</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">02</div>
                                <div class="step-content">
                                    <h3>La Experiencia</h3>
                                    <p>Al rededor de 2 horas de trabajo creativo conjunto en un ambiente seguro para habitar el cuerpo y la vulnerabilidad.</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">03</div>
                                <div class="step-content">
                                    <h3>Entrega completa</h3>
                                    <p>Recibirás todas las fotografías de la sesión (300+) en alta resolución para que conserves el registro total.</p>
                                </div>
                            </div>
                            <div class="step">
                                <div class="step-number">04</div>
                                <div class="step-content">
                                    <h3>Selección artística</h3>
                                    <p>Realizo una selección y edición artesanal de las 30+ fotografías con mayor potencial estético y artístico.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="session-image reveal reveal-delay-2">
                        <img
                            src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/sesion-proceso.jpg"
                            alt="Proceso Cuerpolibre"
                            onerror="this.closest('.session-image').style.background='#141414';this.style.minHeight='500px';this.style.display='block'"
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- The Experience -->
        <section class="session-types-section">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Propuesta Única</span>
                    <div class="section-divider"></div>
                    <h2>La Experiencia Cuerpolibre</h2>
                    <p>Un proceso creativo conjunto diseñado para habitar el cuerpo con libertad</p>
                </div>

                <div class="experience-featured reveal">
                    <div class="experience-card">
                        <div class="experience-content">
                            <h3>Sesión de Fotografía Artística</h3>
                            <p class="experience-philosophy">
                                Mis sesiones son una experiencia que invita al encuentro con la vulnerabilidad, a la entrega de habitar el cuerpo y a la creación de una mirada propia, cuidada y artística de ti mismo/a.
                            </p>
                            <ul class="experience-inclusions">
                                <li><strong>Todas las fotografías</strong> que se hagan en la sesión (300 o +)</li>
                                <li><strong>~2 horas</strong> de experiencia y trabajo creativo conjunto</li>
                                <li><strong>Selección y edición</strong> de las fotografías con más potencial estético (30+)</li>
                                <li><strong>Flexibilidad:</strong> Puede ser en tu espacio o en el mío</li>
                                <li><strong>Encuentro previo:</strong> Reunión online o presencial para coordinar expectativas y ganar confianza</li>
                            </ul>
                            <div class="experience-footer">
                                <a href="#formReserva" class="btn-primary">Reservar mi cupo</a>
                            </div>
                        </div>
                        <div class="experience-visual">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/sesion-experiencia.jpg" alt="Experiencia Cuerpolibre" onerror="this.closest('.experience-visual').style.background='var(--black-card)'">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="session-faq-section">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Dudas frecuentes</span>
                    <div class="section-divider"></div>
                    <h2>Preguntas frecuentes</h2>
                </div>

                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>¿Necesito saber posar o tener experiencia?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>No es necesario que sepas posar ni que tengas experiencia previa frente a la cámara. De hecho, la mayoría de las veces el resultado es más potente cuando es la primera vez y nos enfocamos en habitar el cuerpo de manera orgánica y co-crear la sesión juntos.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>¿Qué debo traer a la sesión?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Recomiendo traer ropa cómoda para antes y después. Dependiendo del tipo de sesión, podemos trabajar con ropa, sin ropa, o con telas y accesorios. Durante la consulta inicial definiremos todos los detalles.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>¿Las sesiones son confidenciales?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Absolutamente. Tu privacidad es mi máxima prioridad. Todas las imágenes se tratan con el máximo respeto y la confidencialidad garantizada bajo acuerdos mutuos. Solo se comparten con tu consentimiento explícito y dinámico.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>¿Puedo traer a alguien conmigo?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Si te hace sentir más cómodo/a, puedes traer a una persona de confianza. No hay ningún problema con que vengas acompañado/a siempre que se adecuen a la dinámica de la sesión para mantener el ambiente fluido y respetuoso.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3>¿Cómo es el proceso de pago?</h3>
                            <span class="faq-toggle">+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Se solicita un 50% de depósito para confirmar la reserva y el saldo restante se paga el día de la sesión. Aceptamos transferencia bancaria, efectivo y pagos con tarjeta de débito o crédito.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Booking Form -->
        <section class="session-booking-section" id="formReserva">
            <div class="container">
                <div class="section-header centered reveal">
                    <span class="section-label">Contacto</span>
                    <div class="section-divider"></div>
                    <h2>Reserva tu sesión</h2>
                    <p>Completa el formulario o contáctanos directamente. Te responderemos en menos de 48 horas.</p>
                </div>

                <!-- Telegram Bot CTA -->
                <div class="telegram-cta reveal">
                    <div class="telegram-cta-inner">
                        <div class="telegram-cta-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48" height="48" aria-hidden="true">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </div>
                        <div class="telegram-cta-content">
                            <h3>¿Prefieres chatear directamente?</h3>
                            <p>Habla con nuestro asistente en Telegram para resolver todas tus dudas, coordinar detalles y agendar tu reunión previa de forma más rápida.</p>
                        </div>
                        <div class="telegram-cta-action">
                            <a href="https://t.me/CuerpoLibrebot" target="_blank" rel="noopener noreferrer" class="btn-telegram">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18" aria-hidden="true">
                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                </svg>
                                Hablar con @CuerpoLibreBot
                            </a>
                        </div>
                    </div>
                    <div class="telegram-divider">
                        <span>o completa el formulario</span>
                    </div>
                </div>

                <div class="booking-form-wrap reveal">
                    <form class="booking-form" id="bookingForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="book-name">Nombre completo</label>
                                <input type="text" id="book-name" name="name" placeholder="Tu nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="book-email">Email</label>
                                <input type="email" id="book-email" name="email" placeholder="tu@email.com" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="book-phone">Teléfono (opcional)</label>
                                <input type="tel" id="book-phone" name="phone" placeholder="+56 9 XXXX XXXX">
                            </div>
                            <div class="form-group">
                                <label for="book-session">Tipo de sesión</label>
                                <select id="book-session" name="session-type">
                                    <option value="completa">Experiencia Completa</option>
                                    <option value="personalizada">Sesión Personalizada / Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="book-date">Fecha estimada para reunión previa (opcional)</label>
                            <input type="date" id="book-date" name="meeting-date">
                        </div>
                        <div class="form-group">
                            <label for="book-message">Mensaje o preguntas</label>
                            <textarea id="book-message" name="message" rows="5" placeholder="Cuéntanos un poco sobre ti, qué esperas de la sesión o cualquier pregunta que tengas..."></textarea>
                        </div>
                        <div class="form-group consent">
                            <input type="checkbox" id="book-consent" name="consent" required>
                            <label for="book-consent">Acepto la <a href="<?php echo esc_url( home_url( '/politica-de-privacidad' ) ); ?>" target="_blank" style="text-decoration: underline; color: var(--accent);">política de privacidad</a> y autorizo el uso de mis datos para coordinar la sesión fotográfica.</label>
                        </div>
                        <button type="submit" class="btn-primary btn-block">Enviar solicitud →</button>
                    </form>
                    <div id="formMessage"></div>
                </div>
            </div>
        </section>

    </main><!-- #primary -->

<?php
get_footer();
?>
