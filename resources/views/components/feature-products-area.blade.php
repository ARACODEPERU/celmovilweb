<div>
    <section class="featured-area featured-one section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3><span>Productos</span> Destacados</h3>
                        <div class="shape">
                            <img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
                        </div>
                        <p>It is a long established fact that a reader will be distracted by the readable content page
                            when
                            looking at its layout.</p>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="featured-slider single-products">
                    @if (count($feature_products) > 0)
                        @foreach ($feature_products as $product)
                            <div class="single-slide">
                                <div class="padding30">
                                    <div class="product-item">
                                        <div class="pro-img">
                                            <a href="{{ route('web_producto_descripcion') }}"><img
                                                    src="{{ $product->image }}" style="max-height: 237px"
                                                    alt="" /></a>
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
                                                    <a href="#"
                                                        onclick="openModalProductDetails(event, {{ json_encode($product) }})"><i
                                                            class="fa fa-eye"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-title">
                                            <a href="{{ route('web_producto_descripcion') }}">
                                                <h5>{{ $product->name }}</h5>
                                            </a>
                                            <p>Precio <span>S/. {{ $product->price }}</span></p>
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
    <!-- quick view start -->
    <div class="product-details quick-view modal animated zoomIn" id="quick-view-product">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="d-table">
                        <div class="d-tablecell">
                            <div class="modal-dialog">
                                <div class="main-view modal-content">
                                    <div class="modal-footer" data-dismiss="modal">
                                        <span>x</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="left">
                                                <!-- Single-pro-slider Big-photo start -->
                                                <div class="quick-img">
                                                    <img id="modal-image-product-view" alt="" />
                                                </div>
                                                <!-- Single-pro-slider Big-photo end -->
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="right">
                                                <div class="singl-pro-title">
                                                    <h3 id="modal-name-product-view"></h3>
                                                    <h1 id="modal-price-product-view">$1700.00</h1>
                                                    <hr />
                                                    <p id="modal-description-product-view"></p>
                                                    <hr />
                                                    <div class="color-brand clearfix">
                                                        <div class="s-select">
                                                            <div class="custom-select">
                                                                <select id="modal-color-product-view"
                                                                    class="form-control">
                                                                    <option value="">Color</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="s-select">
                                                            <div class="custom-select">
                                                                <select class="form-control">
                                                                    <option>Brend</option>
                                                                    <option>Men </option>
                                                                    <option>Fashion </option>
                                                                    <option>Shirt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="s-select s-plus-minus">
                                                            <form action="#" method="POST">
                                                                <div class="plus-minus">
                                                                    <a class="dec qtybutton">-</a>
                                                                    <input type="text" value="02"
                                                                        name="qtybutton" class="plus-minus-box">
                                                                    <a class="inc qtybutton">+</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="actions-btn">
                                                        <ul class="clearfix text-center">
                                                            <li>
                                                                <a href="cart.html"><i class="fa fa-shopping-cart"></i>
                                                                    add to cart</a>
                                                            </li>
                                                            <li>
                                                                <a href="cart.html"><i class="fa fa-heart-o"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-compress"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-share-alt"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <hr />
                                                    <div class="categ-tag">
                                                        <ul class="clearfix">
                                                            <li>
                                                                CATEGORIES:
                                                                <a href="#">Bike,</a> <a href="#">Cycle,</a>
                                                                <a href="#">Ride,</a> <a
                                                                    href="#">Mountain</a>
                                                            </li>
                                                            <li>
                                                                TAG:
                                                                <a href="#">Ride,</a> <a
                                                                    href="#">Helmet,</a>
                                                                <a href="#">cycle,</a> <a href="#">bike</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- quick view end -->
    <script>
        function openModalProductDetails(event, productObject) {
            // Evitar que el enlace abra el modal directamente
            event.preventDefault();

            let colores = JSON.parse(productObject.product.sizes);

            const selectElement = document.getElementById('modal-color-product-view');

            // Llenar el select con opciones
            colores.forEach(color => {
                const option = document.createElement('option');
                option.value = color.size;
                option.text = color.size;
                selectElement.appendChild(option);
            });
            // Cambiar el atributo src de la imagen en el modal
            document.getElementById('modal-image-product-view').src = productObject.image;
            document.getElementById('modal-name-product-view').innerHTML = productObject.name;
            document.getElementById('modal-price-product-view').innerHTML = 'S/.' + productObject.price;
            document.getElementById('modal-description-product-view').innerHTML = productObject.description;
            // document.getElementById('modal-centros-dir').innerHTML = centerObject.address;
            // document.getElementById('modal-centros-ifr').innerHTML = centerObject.map;
            // Abre el modal después de procesar la lógica
            // ...

            // Ejemplo: abrir modal usando Bootstrap
            $('#quick-view-product').modal('show');
        }
    </script>
</div>
