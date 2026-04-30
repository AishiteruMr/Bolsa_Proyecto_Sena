{{-- ===== LOADER DE PANTALLA COMPLETA ===== --}}
<div id="loader-wrapper">

    {{-- Logo sin fondo --}}
    <div id="loader-logo-wrap">
        <img src="{{ asset('assets/loader-removebg-preview.png') }}" alt="Inspírate SENA" id="loader-logo">
    </div>

    <h2 id="loader-title">CARGANDO PROYECTOS...</h2>

    <div id="loader-bar-track">
        <div id="loader-bar-fill"></div>
    </div>

    <div id="loader-dots">
        <span></span><span></span><span></span>
    </div>
</div>

<style>
    #loader-wrapper {
        position: fixed;
        inset: 0;
        background: #ffffff;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 18px;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    #loader-wrapper.oculto {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    #loader-wrapper.skip {
        display: none !important;
    }

    /* Círculo con glow verde detrás de la imagen */
    #loader-logo-wrap {
        width: 280px;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(57,169,0,0.08) 0%, rgba(57,169,0,0.03) 60%, transparent 80%);
        animation: logoPulse 2.2s ease-in-out infinite;
    }

    #loader-logo {
        width: 260px;
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 12px 28px rgba(57,169,0,0.22));
    }

    #loader-title {
        color: #39a900;
        font-family: 'Outfit', 'Segoe UI', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: 2px;
        margin: 0;
    }

    #loader-bar-track {
        width: 260px;
        height: 10px;
        background: #e6f4d7;
        border-radius: 99px;
        overflow: hidden;
        border: 1px solid #c3e6a0;
    }

    #loader-bar-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #2d8f00, #39a900, #5ecb1a);
        border-radius: 99px;
        animation: fillBar 2s ease forwards;
    }

    #loader-dots {
        display: flex;
        gap: 8px;
    }

    #loader-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #39a900;
        opacity: 0.25;
        animation: pulseDot 1.2s ease-in-out infinite;
    }

    #loader-dots span:nth-child(1) { animation-delay: 0s; }
    #loader-dots span:nth-child(2) { animation-delay: 0.22s; }
    #loader-dots span:nth-child(3) { animation-delay: 0.44s; }

    @keyframes logoPulse {
        0%, 100% { transform: scale(1);    opacity: 1; }
        50%       { transform: scale(1.05); opacity: 0.88; }
    }

    @keyframes fillBar {
        0%   { width: 0%; }
        55%  { width: 70%; }
        85%  { width: 90%; }
        100% { width: 100%; }
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 0.25; transform: scale(1); }
        50%       { opacity: 1;    transform: scale(1.4); }
    }
</style>

{{-- ============================================================
     LÓGICA DE VISIBILIDAD — controlada desde PHP (sesión Laravel)
     El flag 'mostrar_loader' se activa en AuthController::login()
     y se consume aquí una sola vez por login.
     ============================================================ --}}
@if(session('mostrar_loader'))
    @php session()->forget('mostrar_loader'); @endphp
<script>
(function () {
    var wrapper  = document.getElementById('loader-wrapper');
    if (!wrapper) return;

    var MIN_TIME  = 2200;   // ms mínimos de visibilidad
    var startTime = Date.now();

    function ocultarLoader() {
        var restante = Math.max(0, MIN_TIME - (Date.now() - startTime));
        setTimeout(function () {
            wrapper.classList.add('oculto');
            setTimeout(function () { wrapper.remove(); }, 550);
        }, restante);
    }

    if (document.readyState === 'complete') {
        ocultarLoader();
    } else {
        window.addEventListener('load', ocultarLoader);
    }
})();
</script>
@else
<script>
(function () {
    var w = document.getElementById('loader-wrapper');
    if (w) w.classList.add('skip');
})();
</script>
@endif
