@props(['ofprincipal'])

<div class="contact-section section-padding">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-info-card">
                <div class="section-header mb-4">
                    <h2 class="modern-title">{{ $ofprincipal[0]->content }}
                        <span>{{ $ofprincipal[1]->content }}</span></h2>
                    <div class="title-line" style="margin: 0 0 20px 0;"></div>
                </div>

                <p class="contact-desc mb-4">{{ $ofprincipal[2]->content }}</p>

                <div class="contact-details-list">
                    <div class="contact-item">
                        <div class="icon-box"><i class="fa fa-phone"></i></div>
                        <div class="text-box">
                            <h4>Teléfono</h4>
                            <p>{{ $ofprincipal[3]->content }}</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="icon-box"><i class="fa fa-map-marker"></i></div>
                        <div class="text-box">
                            <h4>Ubicación</h4>
                            <p>{{ $ofprincipal[5]->content }}</p>
                        </div>
                    </div>
                </div>

                <div class="store-image mt-4">
                    <img src="{{ $ofprincipal[4]->content }}" alt="Nuestra Tienda" class="rounded-lg shadow-md">
                </div>
            </div>

            <div class="contact-map-wrapper">
                {!! $ofprincipal[6]->content !!}
            </div>
        </div>
    </div>
</div>

<style>
    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 40px;
        align-items: start;
    }

    @media (max-width: 991px) {
        .contact-wrapper {
            grid-template-columns: 1fr;
        }
    }

    .contact-info-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    body.dark .contact-info-card {
        background: #1f2937;
        border: 1px solid #374151;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: #fff0e6;
        color: #ff6600;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    body.dark .icon-box {
        background: rgba(255, 102, 0, 0.15);
    }

    .text-box h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    body.dark .text-box h4 {
        color: #f3f4f6;
    }

    .text-box p {
        margin: 0;
        color: #666;
    }

    body.dark .text-box p,
    body.dark .contact-desc {
        color: #9ca3af;
    }

    .contact-map-wrapper {
        height: 100%;
        min-height: 500px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    body.dark .contact-map-wrapper {
        border: 1px solid #374151;
    }

    .contact-map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
</style>