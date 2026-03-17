<x-app-layout>
<style>
    /* Dashboard Limpio - Modo Claro Inspirado en Welcome */
    body {
        background: linear-gradient(to br, #f9fafb, #f3f4f6, #e5e7eb);
    }

    .dashboard-wrapper {
        min-height: 100vh;
        padding: 2rem 1rem;
        background: linear-gradient(to br, #f9fafb, #f3f4f6);
    }

    .dashboard-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Header/Bienvenida */
    .welcome-section {
        text-align: center;
        margin-bottom: 4rem;
        padding: 2rem 0;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        border: 2px solid #1f2937;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        box-shadow: 3px 3px 0px 0px #000;
        transition: all 0.3s ease;
    }

    .welcome-badge:hover {
        border-color: #dc2626;
        box-shadow: 4px 4px 0px 0px #dc2626;
    }

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 300;
        line-height: 1.3;
        color: #111827;
        margin: 1.5rem 0;
        letter-spacing: -0.02em;
    }

    .welcome-section h1 .highlight {
        color: #dc2626;
        font-weight: 500;
    }

    .welcome-section p {
        font-size: 1.125rem;
        color: #4b5563;
        max-width: 600px;
        margin: 1.5rem auto;
        line-height: 1.7;
    }

    .divider-line {
        width: 80px;
        height: 2px;
        background: linear-gradient(to right, transparent, #dc2626, transparent);
        margin: 1.5rem auto;
    }

    /* Features Grid */
    .features-section {
        margin: 5rem 0;
    }

    .features-section h2 {
        font-size: 1.875rem;
        font-weight: 600;
        color: #111827;
        text-align: center;
        margin-bottom: 3rem;
        letter-spacing: -0.01em;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .feature-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 2rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .feature-card:hover {
        transform: translateY(-4px);
        border-color: #dc2626;
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.1);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .feature-card h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.75rem;
    }

    .feature-card p {
        font-size: 0.95rem;
        color: #6b7280;
        line-height: 1.6;
    }

    /* How It Works */
    .how-it-works {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 3rem 2rem;
        margin: 4rem 0;
        transition: all 0.3s ease;
    }

    .how-it-works:hover {
        border-color: #dc2626;
    }

    .how-it-works h2 {
        font-size: 1.875rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 2rem;
    }

    .step {
        position: relative;
        padding-left: 3.5rem;
    }

    .step-number {
        position: absolute;
        left: 0;
        top: 0;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #dc2626, #991b1b);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.25rem;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .step h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .step p {
        font-size: 0.9rem;
        color: #6b7280;
        line-height: 1.6;
    }

    /* Security Section */
    .security-section {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        border: 2px solid #fca5a5;
        border-radius: 1rem;
        padding: 3rem 2rem;
        margin: 4rem 0;
    }

    .security-section h2 {
        font-size: 1.875rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .security-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 2rem;
    }

    .security-item {
        display: flex;
        gap: 1rem;
    }

    .security-icon {
        flex-shrink: 0;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        background: #dc2626;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .security-content h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .security-content p {
        font-size: 0.875rem;
        color: #5a3a3a;
        line-height: 1.6;
    }

    /* WhatsApp Section */
    .whatsapp-section {
        margin: 4rem 0;
    }

    .whatsapp-section h2 {
        font-size: 1.875rem;
        font-weight: 600;
        color: #111827;
        text-align: center;
        margin-bottom: 3rem;
    }

    .whatsapp-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .whatsapp-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .whatsapp-card:hover {
        transform: translateY(-4px);
        border-color: #10b981;
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.1);
    }

    .whatsapp-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #f0fdf4;
        border: 2px solid #10b981;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        color: #059669;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .whatsapp-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 1rem 0;
        letter-spacing: 0.05em;
    }

    .whatsapp-description {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .whatsapp-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: #10b981;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .whatsapp-btn:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    /* FAQ Section */
    .faq-section {
        margin: 4rem 0;
    }

    .faq-section h2 {
        font-size: 1.875rem;
        font-weight: 600;
        color: #111827;
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .faq-list {
        max-width: 750px;
        margin: 0 auto;
    }

    .faq-item {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        border-color: #dc2626;
    }

    .faq-question {
        padding: 1.25rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #111827;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        color: #dc2626;
        background: #fef2f2;
    }

    .faq-toggle {
        width: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
        color: #dc2626;
    }

    .faq-item.active .faq-toggle {
        transform: rotate(180deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: #f9fafb;
    }

    .faq-item.active .faq-answer {
        max-height: 400px;
    }

    .faq-answer p {
        padding: 1.25rem;
        color: #4b5563;
        line-height: 1.8;
        font-size: 0.9rem;
    }

    /* CTA Section */
    .cta-section {
        text-align: center;
        margin: 4rem 0;
        padding: 3rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }

    .cta-section:hover {
        border-color: #dc2626;
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.1);
    }

    .cta-section h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }

    .cta-section p {
        color: #6b7280;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .cta-btn-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-section h1 {
            font-size: 1.75rem;
        }

        .features-section h2,
        .faq-section h2,
        .security-section h2,
        .whatsapp-section h2 {
            font-size: 1.5rem;
        }

        .steps-grid,
        .security-grid,
        .whatsapp-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-container">

        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-badge">
                <span>👋</span>
                <span>Bienvenido a AdminJr</span>
            </div>
            <h1>Gestiona tus finanzas <span class="highlight">sin complicaciones</span></h1>
            <div class="divider-line"></div>
            <p>Todo lo que necesitas para tomar control de tu empresa, directamente en tu WhatsApp. Simple, seguro y eficiente.</p>
        </section>

        <!-- Features Grid -->
        <section class="features-section">
            <h2>¿Por qué AdminJr?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h3>IA Inteligente</h3>
                    <p>Análisis automático de tus transacciones. La IA entiende tus gastos y gestiona todo.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>WhatsApp Nativo</h3>
                    <p>Recibe actualizaciones en tiempo real donde ya estás. Sin apps, sin distracciones.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Súper Rápido</h3>
                    <p>De un mensaje a tu dashboard completamente actualizado en segundos.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Precisión Total</h3>
                    <p>Categorización automática inteligente de todos tus gastos.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Reportes Claros</h3>
                    <p>Visualiza tu flujo de efectivo con gráficos intuitivos y actualizados.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>Seguridad Extrema</h3>
                    <p>Todos tus datos protegidos con encriptación de nivel bancario.</p>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="how-it-works">
            <h2>Cómo Funciona</h2>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Escribe un Mensaje</h3>
                    <p>"Gaste $50 en comida con tarjeta" - así de simple</p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3>IA Procesa</h3>
                    <p>AdminJr entiende, categoriza y registra automáticamente</p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Se Actualiza</h3>
                    <p>Tu dashboard refleja el cambio al instante</p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Tomas Decisiones</h3>
                    <p>Con datos frescos y confiables para tu empresa</p>
                </div>
            </div>
        </section>

        <!-- Security Section -->
        <section class="security-section">
            <h2>🛡️ Seguridad y Confianza</h2>
            <div class="security-grid">
                <div class="security-item">
                    <div class="security-icon">✓</div>
                    <div class="security-content">
                        <h3>Números Verificados</h3>
                        <p>Todos registrados con WhatsApp Business oficial</p>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-icon">🔐</div>
                    <div class="security-content">
                        <h3>Encriptación E2E</h3>
                        <p>Todos tus mensajes protegidos de extremo a extremo</p>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-icon">📋</div>
                    <div class="security-content">
                        <h3>Cumplimiento Legal</h3>
                        <p>Totalmente conforme con GDPR, LGPD y normativas locales</p>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-icon">🚫</div>
                    <div class="security-content">
                        <h3>Nunca Compartimos</h3>
                        <p>Tus datos jamás se venden o comparten con terceros</p>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-icon">👁</div>
                    <div class="security-content">
                        <h3>Control Total</h3>
                        <p>Tú decidís qué datos crear o compartir</p>
                    </div>
                </div>

                <div class="security-item">
                    <div class="security-icon">⚡</div>
                    <div class="security-content">
                        <h3>Soporte Inmediato</h3>
                        <p>Equipo listo para ayudarte en cualquier momento</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- WhatsApp Numbers -->
        <section class="whatsapp-section">
            <h2>Números Verificados AdminJr</h2>
            <div class="whatsapp-grid">
                <div class="whatsapp-card">
                    <div class="whatsapp-icon">💬</div>
                    <div class="verified-badge">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Verificado
                    </div>
                    <div class="whatsapp-number">+52 999 219 5077</div>
                    <p class="whatsapp-description">Soporte, reportes y consultas</p>
                    <a href="https://wa.me/529992195077?text=Hola%20AdminJr" target="_blank" class="whatsapp-btn">
                        Enviar Mensaje
                    </a>
                </div>

                <div class="whatsapp-card">
                    <div class="whatsapp-icon">📊</div>
                    <div class="verified-badge">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Verificado
                    </div>
                    <div class="whatsapp-number">+52 999 219 5077</div>
                    <p class="whatsapp-description">Análisis y consultas financieras</p>
                    <a href="https://wa.me/529992195077?text=Necesito%20un%20análisis" target="_blank" class="whatsapp-btn">
                        Enviar Mensaje
                    </a>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section">
            <h2>Preguntas Frecuentes</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>¿Es seguro enviar mensajes con datos financieros?</span>
                        <div class="faq-toggle">▼</div>
                    </div>
                    <div class="faq-answer">
                        <p>100% seguro. WhatsApp usa encriptación E2E como los bancos. Nuestros números están verificados oficialmente. Solo enviamos resúmenes - jamás datos bancarios completos. Puedes revisar nuestra política de privacidad.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>¿Cuánto tiempo tarda en procesarse un gasto?</span>
                        <div class="faq-toggle">▼</div>
                    </div>
                    <div class="faq-answer">
                        <p>Casi instantáneamente. Tu dashboard se actualiza en menos de 5 segundos. La IA procesa, categoriza y registra todo automáticamente sin ningún trabajo manual de tu parte.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>¿Cómo sé que es AdminJr y no es un impostor?</span>
                        <div class="faq-toggle">▼</div>
                    </div>
                    <div class="faq-answer">
                        <p>Los números verificados de AdminJr aparecen en tu dashboard con la insignia verde. Todos están registrados como empresas verificadas en WhatsApp. Nunca dudes en verificar el número directamente en tu panel de control.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>¿Tengo que aprender a usar AdminJr?</span>
                        <div class="faq-toggle">▼</div>
                    </div>
                    <div class="faq-answer">
                        <p>No. AdminJr está diseñado para ser tan simple como enviar un WhatsApp. Escribe como normalmente lo harías: "Gaste 100 en comida" y la IA entiende todo. Sin comandos raros, sin complejidad.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>¿Qué pasa si AdminJr se equivoca en una categoría?</span>
                        <div class="faq-toggle">▼</div>
                    </div>
                    <div class="faq-answer">
                        <p>Puedes corregirlo desde tu dashboard en un click. La IA aprende de tus correcciones y la próxima vez acertará. Es inteligencia artificial que mejora con el tiempo.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>¿Puedo desactivar notificaciones?</span>
                        <div class="faq-toggle">▼</div>
                    </div>
                    <div class="faq-answer">
                        <p>Claro. Controlas exactamente qué quieres recibir: todas las notificaciones, solo alerts importantes, o solo reportes semanales. Todo configurable en tu panel.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <h2>¿Listo para simplificar tus finanzas?</h2>
            <p>Comienza ahora mismo. AdminJr está esperándote.</p>
            <div class="cta-btn-group">
                <a href="{{ route('chat.create') }}" class="whatsapp-btn" style="background: #dc2626; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);">
                    Ir a Panel AdminJr
                </a>
            </div>
        </section>

    </div>
</div>

<script>
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const item = this.parentElement;
            item.classList.toggle('active');
        });
    });
</script>
</x-app-layout>
