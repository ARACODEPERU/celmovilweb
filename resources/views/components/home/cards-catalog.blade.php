@props(['portadas'])

<section class="promotional-banners section-padding">
    <div class="container">
        <div class="categories-grid">
            <a href="{{ url('productos/1/list') }}" class="category-card hover-effect">
                <img src="{{ $portadas[0]->content }}" alt="Scooters">
                <div class="category-overlay">
                    {{-- <h3>Scooters</h3> --}}
                    <h3>Ver Modelos <i class="fa fa-arrow-right"></i></h3>
                </div>
            </a>
            <a href="{{ url('productos/2/list') }}" class="category-card hover-effect">
                <img src="{{ $portadas[1]->content }}" alt="Bicimotos">
                <div class="category-overlay">
                    {{-- <h3>Bicimotos</h3> --}}
                    <h3>Ver Modelos <i class="fa fa-arrow-right"></i></h3>
                </div>
            </a>
            <a href="{{ url('productos/6/list') }}" class="category-card hover-effect">
                <img src="{{ $portadas[2]->content }}" alt="Motos Eléctricas">
                <div class="category-overlay">
                    {{-- <h3>Bicimotos</h3> --}}
                    <h3>Ver Modelos <i class="fa fa-arrow-right"></i></h3>
                </div>
            </a>
            <a href="{{ url('productos/3/list') }}" class="category-card hover-effect">
                <img src="{{ $portadas[3]->content }}" alt="Accesorios">
                <div class="category-overlay">
                    {{-- <h3>Bicimotos</h3> --}}
                    <h3>Ver Modelos <i class="fa fa-arrow-right"></i></h3>
                </div>
            </a>
        </div>
    </div>
</section>

<style>
    body.dark .section-padding {
        background-color: #111827;
    }

    .section-padding {
        padding: 60px 0;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .category-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        display: block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        padding: 20px;
        color: white;
    }

    .category-overlay h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .category-overlay span {
        font-size: 0.9rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 5px;
    }
</style>