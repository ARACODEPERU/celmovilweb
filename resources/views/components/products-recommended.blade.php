<section class="related-area riding-one">
    @if (count($products_recommended) > 0)
        <div class="container">
            <div class="related-title">
                <h5>También te recomendamos</h5>
            </div>
            <div class="row text-center margin50">
                <div class="related-slider single-products">
                    @foreach ($products_recommended as $product)
                        <div class="related-item col-xs-12">
                            <div class="product-item">
                                <div class="pro-img">
                                    <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                                    </a>
                                </div>
                                <div class="riding-title clearfix">
                                    <div class="product-title">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                            <h5>{{ $product->name }}</h5>
                                        </a>
                                        <p>Precio: <span>S/ {{ $product->price - ($product->discount ?? 0) }}</span></p>
                                        <!--
                                        <span style="color: orange;"><b>Agotado </b></span>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</section>
