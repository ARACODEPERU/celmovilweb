<div>
    <section class="best-sell-area popular-product section-padding-top">
        @if (count($products_recommended) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-text-center">
                        <div class="section-title text-center">
                            <h1><span>{{ $product_popular_area[0]->content }}</span> {{ $product_popular_area[1]->content }}</h1>
                            <div class="shape">
                            </div>
                            <p>
                                {{ $product_popular_area[2]->content }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    @foreach ($products_recommended as $product)
                        <div class="col-xs-12 col-md-3" style="padding: 15px;">
                            <div class="padding30">
                                <div class="product-item" style="padding: 15px;">
                                    <div class="pro-img">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"  style="width: 220px; height: 220px;" />
                                        </a>
                                    </div>
                                    <div class="">
                                        <div class="product-title">
                                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                <h5  style="height: 40px;"><b>{{ $product->name }}</b></h5>
                                            </a>  
                                            <p>
                                                Precio: <b>S/ 3500.00</b>
                                            </p>
                                            <p>
                                                Antes: <del> S/ 1800.00</del> <br>
                                                Promoción: <span><b>S/ 1620.00</b> </span>
                                            </p>
                                            {{-- <p>Precio: <span>S/ {{ number_format($product->price - ($product->discount ?? 0),2) }}</span></p> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="info" style="margin-top: -10px;">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                            Obtén un <b>Desc. 4%</b>
                                        </a>
                                    </div> --}}
                                    <div style="margin-top: 10px;">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                            <b>Más Información </b>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
