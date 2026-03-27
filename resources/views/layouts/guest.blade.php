<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 overflow-hidden">
        
        <!-- Canvas para partículas animadas (FONDO PRINCIPAL) -->
        <canvas id="particleCanvas" class="absolute inset-0 w-full h-full"></canvas>
        
        <!-- Gradiente de fondo base (semi-transparente para que se vean las partículas) -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-gray-100 -z-10"></div>
        
        <!-- Patrón de puntos decorativo sutil -->
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, #dc2626 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <!-- Elementos decorativos grandes con blur (se ven detrás) -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-red-500/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-red-500/3 rounded-full blur-3xl"></div>
        
        <!-- Líneas decorativas sutiles -->
        <div class="absolute top-20 left-10 w-px h-64 bg-gradient-to-b from-transparent via-red-500/10 to-transparent hidden lg:block"></div>
        <div class="absolute bottom-20 right-10 w-px h-64 bg-gradient-to-t from-transparent via-red-500/10 to-transparent hidden lg:block"></div>

        <!-- CONTENEDOR PRINCIPAL -->
        <div class="relative w-full max-w-md px-4 sm:px-6 py-6 sm:py-8 z-10">
            {{ $slot }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return;
            
            let ctx = canvas.getContext('2d');
            let particles = [];
            let animationId = null;
            let mouseX = null;
            let mouseY = null;
            
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                initParticles();
            }
            
            function initParticles() {
                const particleCount = Math.min(120, Math.floor(window.innerWidth / 15));
                particles = [];
                for (let i = 0; i < particleCount; i++) {
                    particles.push({
                        x: Math.random() * canvas.width,
                        y: Math.random() * canvas.height,
                        radius: Math.random() * 3 + 1,
                        speedX: (Math.random() - 0.5) * 0.6,
                        speedY: (Math.random() - 0.5) * 0.4,
                        opacity: Math.random() * 0.5 + 0.2,
                        color: Math.random() > 0.7 ? '#dc2626' : '#f97316',
                        originalSpeedX: (Math.random() - 0.5) * 0.6,
                        originalSpeedY: (Math.random() - 0.5) * 0.4
                    });
                }
            }
            
            // Seguimiento del mouse para efecto de interacción
            document.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });
            
            function drawParticles() {
                if (!ctx) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                for (let i = 0; i < particles.length; i++) {
                    const p = particles[i];
                    
                    // Efecto de repulsión al mouse
                    if (mouseX !== null && mouseY !== null) {
                        const dx = p.x - mouseX;
                        const dy = p.y - mouseY;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        const maxDistance = 150;
                        
                        if (distance < maxDistance) {
                            const force = (maxDistance - distance) / maxDistance;
                            const angle = Math.atan2(dy, dx);
                            const pushX = Math.cos(angle) * force * 1.5;
                            const pushY = Math.sin(angle) * force * 1.5;
                            p.x += pushX;
                            p.y += pushY;
                        }
                    }
                    
                    // Actualizar posición normal
                    p.x += p.speedX;
                    p.y += p.speedY;
                    
                    // Rebote suave en bordes (con efecto de rebote)
                    if (p.x < 0) {
                        p.x = 0;
                        p.speedX = Math.abs(p.speedX);
                    }
                    if (p.x > canvas.width) {
                        p.x = canvas.width;
                        p.speedX = -Math.abs(p.speedX);
                    }
                    if (p.y < 0) {
                        p.y = 0;
                        p.speedY = Math.abs(p.speedY);
                    }
                    if (p.y > canvas.height) {
                        p.y = canvas.height;
                        p.speedY = -Math.abs(p.speedY);
                    }
                    
                    // Dibujar partícula con glow
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    
                    // Sombra/glow para las partículas
                    ctx.shadowBlur = 8;
                    ctx.shadowColor = p.color;
                    
                    ctx.fillStyle = p.color;
                    ctx.globalAlpha = p.opacity;
                    ctx.fill();
                    
                    // Resetear sombra para las líneas
                    ctx.shadowBlur = 0;
                    
                    // Dibujar líneas entre partículas cercanas
                    for (let j = i + 1; j < particles.length; j++) {
                        const p2 = particles[j];
                        const dx = p.x - p2.x;
                        const dy = p.y - p2.y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        
                        if (distance < 120) {
                            ctx.beginPath();
                            ctx.moveTo(p.x, p.y);
                            ctx.lineTo(p2.x, p2.y);
                            
                            const gradient = ctx.createLinearGradient(p.x, p.y, p2.x, p2.y);
                            gradient.addColorStop(0, `rgba(220, 38, 38, ${0.12 * (1 - distance / 120)})`);
                            gradient.addColorStop(1, `rgba(249, 115, 22, ${0.12 * (1 - distance / 120)})`);
                            
                            ctx.strokeStyle = gradient;
                            ctx.lineWidth = 0.8;
                            ctx.stroke();
                        }
                    }
                }
                
                animationId = requestAnimationFrame(drawParticles);
            }
            
            window.addEventListener('resize', () => {
                resizeCanvas();
            });
            
            resizeCanvas();
            drawParticles();
        });
    </script>
</body>
</html>