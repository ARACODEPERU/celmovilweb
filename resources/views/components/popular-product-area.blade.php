<div>
    <section class="best-sell-area popular-product section-padding-top">
        @if (count($products_recommended) > 0)
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                        <div class="section-title text-center">
                            <h3><span>Productos</span> Populares</h3>
                            <div class="shape">
                                <img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
                            </div>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page
                                when looking at its layout.</p>
                        </div>
                    </div>
                </div>
                <div class="text-center tab-content">
                    <div class="tab-pane fade in active">
                        <div class="single-products">
                            <div class="row">
                                @foreach ($products_recommended as $product)
                                <div class="col-xs-12 col-md-3" style="padding: 15px;">
                                    <div class="product-item">
                                        <div class="pro-img">
                                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"  style="width: 220px; height: 220px;" />
                                            </a>
                                        </div>
                                        <div class="actions-btn">
                                            <ul class="clearfix">
                                                <li>
                                                    <a onclick="agregarAlCarrito({ id: {{ $product->id }}, nombre:{{ '"'.$product->name.'"' }}, color: {{ json_encode($product) }}, precio: {{ $product->price }} })"><i class="fa fa-shopping-cart"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-heart"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#quick-view"><i
                                                            class="fa fa-eye"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="riding-title clearfix">
                                            <div class="product-title">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    <h5>{{ $product->name }}</h5>
                                                </a>
                                                <p>Precio: <span>S/ {{ $product->price - ($product->discount ?? 0) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
