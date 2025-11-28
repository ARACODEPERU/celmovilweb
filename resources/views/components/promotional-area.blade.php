<div>
    <section class="sell-up-area sell-up-one">
        <div class="container">
            <div class="row">
                <div class="col-md-4 ">
                    <div class="shadow-l-r">
                        <div class="sell-up-left">
                            <h4>{{ $promotional[0]->content }}</h4>
                            <h2
                                style="max-width: 300px; /* Ajusta el ancho según tu diseño */
                                white-space: normal; /* Permite el salto de línea */
                                word-wrap: break-word; /* Por si hay palabras muy largas */">
                                <strong>{{ $promotional[1]->content }}</strong>
                            </h2>
                            <hr class="line">
                            <p
                                style="max-width: 300px; /* Ajusta el ancho según tu diseño */
                                white-space: normal; /* Permite el salto de línea */
                                word-wrap: break-word; /* Por si hay palabras muy largas */">
                                {{ $promotional[2]->content }}
                            </p>
                            <a class="shop-btn" href="{{ $promotional[3]->content }}">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <a href="">
                        <img style="width: 100%; margin-top: 20px;"
                            src="{{ $promotional[4]->content }}" alt="Banner Promoción">
                    </a>
                </div>
                {{-- <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-7">
                    <div class="sell-up-right slick-initialized slick-slider">
                        <div aria-live="polite" class="slick-list draggable">
                            <div class="slick-track" role="listbox"
                                style="opacity: 1; width: 3918px; transform: translate3d(-753px, 0px, 0px);">
                                <div class="single-sellup slick-slide slick-cloned" data-slick-index="-1"
                                    aria-hidden="true" tabindex="-1" style="width: 753px;">
                                    <a href="" tabindex="-1">
                                        <img src="{{ asset('themes/celmovil/img/products/u1.png') }}" alt=""></a>
                                </div>
                                <div class="single-sellup slick-slide slick-current slick-active" data-slick-index="0"
                                    aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide10"
                                    style="width: 753px;">
                                    <a href="" tabindex="0">
                                        <img src="{{ asset('themes/celmovil/img/products/u1.png') }}" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
</div>
