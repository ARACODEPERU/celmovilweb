<section class="page-header-modern">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="modern-title-large">
                DETALLES DEL <span>PRODUCTO</span>
            </h1>
            <div class="title-line-large"></div>
            <p class="header-description">
                Descubre todas las características, especificaciones y ventajas de este increíble modelo.
                <br>¡Calidad, tecnología y garantía asegurada para ti!
            </p>
        </div>
    </div>
    <div class="shape circle-1"></div>
    <div class="shape circle-2"></div>
</section>

<style>
    /* Title Styles */
    .page-header-modern {
        position: relative;
        padding: 160px 0 80px;
        /* Espacio superior para compensar el header fijo */
        background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        overflow: hidden;
        color: white;
        margin-top: 0;
    }

    .page-header-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 80% 20%, rgba(255, 102, 0, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 20% 80%, rgba(37, 211, 102, 0.1) 0%, transparent 50%);
        z-index: 1;
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .modern-title-large {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 15px;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .modern-title-large span {
        background: linear-gradient(to right, #ff6600, #ff9933);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .title-line-large {
        width: 100px;
        height: 6px;
        background: #ff6600;
        margin: 0 auto 25px;
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
    }

    .header-description {
        font-size: 1.2rem;
        color: #e5e7eb;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 0;
    }

    .circle-1 {
        width: 300px;
        height: 300px;
        background: rgba(255, 102, 0, 0.1);
        top: -50px;
        left: -50px;
    }

    .circle-2 {
        width: 400px;
        height: 400px;
        background: rgba(59, 130, 246, 0.05);
        bottom: -100px;
        right: -100px;
    }

    @media (max-width: 768px) {
        .page-header-modern {
            padding: 140px 0 60px;
        }

        .modern-title-large {
            font-size: 2.5rem;
        }
    }
</style>