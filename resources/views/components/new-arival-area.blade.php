<div>
    <section class="riding-area arival-two riding-one section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3><span>Nuevos</span> Productos</h3>
                        <div class="shape">
                            <img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
                        </div>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a
                            page
                            when looking at its layout.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row text-center">
                <div class="four-item single-products">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="col-xs-12">
                                <div class="product-item">
                                    <div class="pro-img">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}"><img
                                                src="{{ asset($product->image) }}" alt="Product" /></a>
                                    </div>
                                    <div class="actions-btn">
                                        <ul class="clearfix">
                                            <li>
                                                <a href="cart.html"><i class="fa fa-shopping-cart"></i></a>
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
                                            <p>Price: <span>S/ {{ $product->price - ($product->discount ?? 0) }}
                                                </span><del>{{ $product->price }}</del></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
