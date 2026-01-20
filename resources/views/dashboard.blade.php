<x-app-layout>
    <!-- Glow rojo -->
    <div class="absolute inset-0 -z-10 flex justify-center items-center">
        <div class="w-[85%] h-[85%] rounded-full blur-[180px]"
            style="background: radial-gradient(circle, rgba(239,68,68,0.35) 0%, rgba(239,68,68,0.05) 45%, transparent 70%);">
        </div>
    </div>

    <h1><span class="text-red-500 font-medium">
        Soluciones inteligentes de Avaspace Team Solutions
    </span></h1>

    <h2>Transformamos tus tareas diarias en procesos automáticos y eficientes</h2>
    <span class="text-red-500 font-medium">Próximamente</span>

    <!-- APLICACIONES -->
    <div class="aplicaciones-container">
        <a class="aplicaciones-icons">
            <img src="{{ asset('images/analistajr.png') }}">
            <h4>Analista de datos Jr.</h4>
        </a>

        <a class="aplicaciones-icons">
            <img src="{{ asset('images/gerentejr.png') }}">
            <h4>Gerente empresarial</h4>
        </a>
    </div>

    <h1><span class="text-red-500 font-medium">
        Administrador Jr. apuntará todas tus transacciones por WhatsApp
    </span></h1>
    <h2>Números verificados para enviar mensajes</h2>

    <!-- CARD WHATSAPP -->
    <div class="numero-card">

        <div class="whatsapp-icon">
            <svg width="22" height="22" viewBox="0 0 24 24">
                <path fill="#ef4444"
                    d="M12.04 2C6.58 2 2.1 6.48 2.1 11.94c0 1.97.52 3.9 1.52 5.6L2 22l4.6-1.58a9.93 9.93 0 0 0 5.44 1.6c5.46 0 9.94-4.48 9.94-9.94C22 6.48 17.5 2 12.04 2z"/>
                <path fill="#fff"
                    d="M9.4 7.9c-.2-.45-.42-.46-.62-.47h-.52c-.18 0-.48.07-.73.35-.25.27-.95.93-.95 2.27s.97 2.64 1.1 2.82c.14.18 1.88 3.02 4.66 4.11 2.31.9 2.78.72 3.28.67.5-.05 1.6-.65 1.83-1.27.23-.62.23-1.15.16-1.27-.07-.12-.25-.18-.52-.32-.27-.14-1.6-.8-1.85-.9-.25-.1-.43-.14-.62.14-.18.27-.7.9-.86 1.08-.16.18-.32.2-.6.07-.27-.14-1.14-.42-2.17-1.34-.8-.7-1.34-1.56-1.5-1.82z"/>
            </svg>
        </div>

        <span class="numero-label">WhatsApp verificado</span>
        <span class="numero-phone">999 219 5077</span>

        <a   href="https://wa.me/529902195077"
            target="_blank"
            class="whatsapp-btn">
            Enviar mensaje
        </a>
    </div>

    <style>
        main {
            background:#16181d;
            min-height:100vh;
            padding:40px;
            position:relative;
            overflow:hidden;
        }

        h1 { color:#fff; font-size:22px; font-weight:800 }
        h2 { color:#c9c9c9; font-size:15px }
        h4 { color:#fff; font-size:14px; font-weight:600 }

        .aplicaciones-container {
            display:flex;
            gap:24px;
            margin:28px 0 48px;
        }

        .aplicaciones-icons {
            width:210px;
            padding:24px;
            border-radius:22px;
            background:rgba(255,255,255,.04);
            border:1px solid rgba(239,68,68,.35);
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:14px;
            transition:.3s;
        }

        .aplicaciones-icons:hover {
            transform:translateY(-6px);
            box-shadow:0 12px 28px rgba(0,0,0,.45);
        }

        .aplicaciones-icons img {
            width:120px;
            border-radius:20px;
            transition:.3s;
        }

        .aplicaciones-icons:hover img { transform:scale(1.08) }
        .aplicaciones-icons:hover h4 { color:#ff6b6b }

        .numero-card {
        margin-top: 18px;
        padding: 20px 26px;
        width: fit-content;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(239, 68, 68, 0.35);
        box-shadow: none; 
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .numero-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45); /* sombra normal, NO glow */
    }


        .numero-label { font-size:12px; color:#fca5a5 }
        .numero-phone { font-size:20px; font-weight:700; color:#fff }

        .whatsapp-icon {
            width:34px;
            height:34px;
            border-radius:10px;
            background:rgba(239,68,68,.18);
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .whatsapp-btn {
            margin-top:10px;
            padding:10px 14px;
            border-radius:12px;
            background:rgba(239,68,68,.18);
            border:1px solid rgba(239,68,68,.45);
            color:#fff;
            font-size:14px;
            font-weight:600;
            text-align:center;
            transition:.25s;
        }

        .whatsapp-btn:hover {
            background:rgba(239,68,68,.35);
            transform:translateY(-2px);
        }
    </style>

</x-app-layout>