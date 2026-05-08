@props(['logo' => asset('themes/celmovil/img/logoCM.png')])
<div id="celmovil-preloader" class="preloader-overlay">
    <div class="preloader-content">
        @if($logo)
            <img src="{{ $logo }}" alt="Celmovil Logo" class="preloader-logo pulse-animation">
        @else
            <div class="fallback-spinner pulse-animation"></div>
        @endif
    </div>
</div>

<style>
    .preloader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100000;
        transition: opacity 0.5s ease, visibility 0.5s;
    }

    /* Detección inmediata de modo oscuro */
    body.dark .preloader-overlay,
    .preloader-overlay.dark-mode-active {
        background-color: #111827;
    }

    .preloader-content {
        text-align: center;
    }

    .preloader-logo {
        max-width: 200px;
        height: auto;
        display: inline-block;
        filter: drop-shadow(0 0 10px rgba(255, 102, 0, 0.2));
    }

    .fallback-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(255, 102, 0, 0.1);
        border-left-color: #ff6600;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes heartbeat {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }

    .pulse-animation {
        animation: heartbeat 1.5s infinite ease-in-out;
    }

    .preloader-hidden {
        opacity: 0 !important;
        visibility: hidden !important;
    }
</style>

<script>
    (function() {
        const preloader = document.getElementById('celmovil-preloader');
        // Sincronizar con el modo oscuro inmediatamente para evitar el flash blanco
        if (localStorage.getItem("mode") === "dark-mode") {
            preloader.classList.add('dark-mode-active');
        }

        const startTime = Date.now();
        const MIN_TIME = 1000; // Tiempo mínimo aumentado para asegurar visibilidad

        window.addEventListener('load', function() {
            const now = Date.now();
            const diff = now - startTime;
            const remaining = Math.max(0, MIN_TIME - diff);

            setTimeout(() => {
                preloader.classList.add('preloader-hidden');
                setTimeout(() => preloader.remove(), 600); // Limpiar el DOM
            }, remaining);
        });
    })();
</script>