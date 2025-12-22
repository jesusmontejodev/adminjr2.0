<x-app-layout>


    <h1>Soluciones inteligentes de Avaspace Team Solutions</h1>
    <h2>Transformamos tus tareas diarias en procesos automáticos y eficientes</h2>


    <div class="aplicaciones-container">
        <a class="aplicaciones-icons">
            <img src="{{ asset('images/adminjr.png') }}" alt="Foto">
            <h4>Administrador Jr.</h4>
        </a>

        <a class="aplicaciones-icons">
            <img src="{{ asset('images/analistajr.png') }}" alt="Foto">
            <h4>Analista de datos Jr.</h4>
        </a>

        <a class="aplicaciones-icons">
            <img src="{{ asset('images/gerentejr.png') }}" alt="Foto">

            <h4>Gerente empresarial</h4>
        </a>
    </div>


    <h1>Administrador Jr. Apuntará todas tus transacciones por Whatsapp</h1>
    <h2>Número verificados para envíar mensajes</h2>

    <div>
        <img/>
        <h3></h3>
    </div>


<style>
    /* ====== Encabezados ====== */
    h1{
        color: #fff;
        font-weight: 900;
        font-size: 21px
    }
    h2{
        color: #d3d3d3;
    }
    h4 {
        color: #fff;
        font-weight: 700;
        font-size: .9rem;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
    }

    .aplicaciones-container h4:hover {
        text-decoration: underline;
        cursor: pointer;
        color: #ff4b4b; /* tono rojo elegante para resaltar */
    }

    /* ====== Contenedor principal ====== */
    .aplicaciones-container {
        display: flex;
        flex-wrap: wrap; /* se adapta a pantallas pequeñas */
        justify-content: start;
        gap: 24px;
        margin:  21px 0px;
        cursor: pointer;

    }

    /* ====== Tarjeta individual ====== */
    .aplicaciones-icons {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.05); /* fondo sutil translúcido */
        border-radius: 24px;
        padding: 24px;
        width: 210px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .aplicaciones-icons:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    }

    /* ====== Iconos ====== */
    .aplicaciones-icons img {
        width: 100%;
        max-width: 120px;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 20px;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.25));
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .aplicaciones-icons img:hover {
        transform: scale(1.08);
        filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.3));
    }
</style>
</x-app-layout>
