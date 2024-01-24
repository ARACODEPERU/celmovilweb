<div>
    @if (count($products_desc) > 0)
        <div class="others-product section-padding bg-3">
            <div class="container">
                <div class="row text-center">
                    <div class="four-item-w single-products">
                        @foreach ($products_desc as $product)
                            <div class="col-xs-12">
                                <div class="product-item">
                                    <div class="pro-img">
                                        <a href="{{ route('web_producto_descripcion', $product->id) }}"><img
                                                src="{{ asset($product->image) }}" alt="{{ $product->name }}" /></a>
                                        <div class="tag-n-s">
                                            <span>-{{ (($product->discount ?? 0) / $product->price) * 100 }}%</span>
                                        </div>
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
                                            <p>Price: <span>S/ {{ $product->price - ($product->discount ?? 0) }} </span>
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
    @endif
</div>
