
    
    <section style="padding: 120px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-text-center">
                    <div class="section-title text-center">
                        <h1><span>{{ $product_popular_area[0]->content }}</span>
                            {{ $product_popular_area[1]->content }}</h1>
                        <div class="shape">
                        </div>
                        <p>
                            {{ $product_popular_area[2]->content }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-container">
            @foreach ($products_recommended as $product)
                <div class="grid-item view-pc">
                    <div class="product-item" style="padding: 15px;  height: 400px;">
                        <div class="pro-img">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    style="width: 220px; height: 220px;" />
                            </a>
                        </div>
                        <div class="">
                            <div class="product-title">
                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                    <h5><b>{{ $product->name }}</b></h5>
                                </a>
                                @if ($product->discount > 0)
                                    @php
                                        $new_price = $product->price - $product->discount;
                                    @endphp
                                    <p>
                                        Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                        Promoción: <span><b>S/ {{ number_format($new_price, 2) }}</b>
                                        </span>
                                    </p>
                                @else
                                    <p>
                                        Precio: <b>S/ {{ number_format($product->price, 2) }}</b>
                                    </p>
                                @endif
                                {{-- <p>Precio: <span>S/ {{ number_format($product->price - ($product->discount ?? 0),2) }}</span></p> --}}
                            </div>
                        </div>
                        {{-- <div class="info" style="margin-top: -10px;">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                Obtén un <b>Desc. 4%</b>
                            </a>
                        </div> --}}
                        <div style="margin-top: 10px;">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}"
                                class="btn btn-celmovil">
                                <b>Más Información </b>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="grid-item view-movil">
                    <div class="product-item" style="padding: 15px;  height: 400px;">
                        <div class="pro-img">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    style="width: 100%;" />
                            </a>
                        </div>
                        <div class="">
                            <div class="product-title">
                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                    <h5><b>{{ $product->name }}</b></h5>
                                </a>
                                @if ($product->discount > 0)
                                    @php
                                        $new_price = $product->price - $product->discount;
                                    @endphp
                                    <p>
                                        Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                        Promoción: <span><b>S/ {{ number_format($new_price, 2) }}</b>
                                        </span>
                                    </p>
                                @else
                                    <p>
                                        Precio: <b>S/ {{ number_format($product->price, 2) }}</b>
                                    </p>
                                @endif
                                {{-- <p>Precio: <span>S/ {{ number_format($product->price - ($product->discount ?? 0),2) }}</span></p> --}}
                            </div>
                        </div>
                        {{-- <div class="info" style="margin-top: -10px;">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                Obtén un <b>Desc. 4%</b>
                            </a>
                        </div> --}}
                        <div style="margin-top: 10px;">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}"
                                class="btn btn-celmovil">
                                <b>Más Información </b>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- <div class="grid-item">1</div>
            <div class="grid-item">2</div>
            <div class="grid-item">3</div>
            <div class="grid-item">4</div>
            <div class="grid-item">5</div>
            <div class="grid-item">6</div>
            <div class="grid-item">7</div>
            <div class="grid-item">8</div>
            <div class="grid-item">9</div> --}}
        </div>
    </section>

    <style>
        .grid-container {
        display: grid;
        gap: 10px;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(3, auto);
        width: 100%;
        padding: 20px 40px;
        /* max-width: 600px; */
        }

        .grid-item {
        /* background-color: #007bff; */
        color: white;
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        }

        /* Responsive Design for Mobile */
        @media (max-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, auto);
            width: 98%;
            padding: 5px;
        }

        .grid-item {
            padding: 10px;
        }
        }
    </style>



    {{-- <section class="best-sell-area popular-product section-padding-top">
        @if (count($products_recommended) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-text-center">
                        <div class="section-title text-center">
                            <h1><span>{{ $product_popular_area[0]->content }}</span>
                                {{ $product_popular_area[1]->content }}</h1>
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
                                <div class="product-item" style="padding: 15px;  height: 380px;">
                                    <div class="pro-img">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                style="width: 220px; height: 220px;" />
                                        </a>
                                    </div>
                                    <div class="">
                                        <div class="product-title">
                                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                <h5><b>{{ $product->name }}</b></h5>
                                            </a>
                                            @if ($product->discount > 0)
                                                @php
                                                    $new_price = $product->price - $product->discount;
                                                @endphp
                                                <p>
                                                    Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                                    Promoción: <span><b>S/ {{ number_format($new_price, 2) }}</b>
                                                    </span>
                                                </p>
                                            @else
                                                <p>
                                                    Precio: <b>S/ {{ number_format($product->price, 2) }}</b>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}"
                                            class="btn btn-celmovil">
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
    </section> --}}

    
