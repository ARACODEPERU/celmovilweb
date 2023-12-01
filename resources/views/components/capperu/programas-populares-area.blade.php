<div>
    <section class="trending-courses-area pd-top-100 pd-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3>Más Populares</h3>
                        <div class="ara-linea-cap"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <ul class="edl-nav nav nav-pills">
                        <li class="nav-item">
                            <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1">Todos los programas</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2">Empresarial</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3">Derecho</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4">Público</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-1"> <!-- Todos los items/programas -->
                            <div class="course-slider owl-carousel">


                                @foreach ($programs as $program)                                
                                <div class="item">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                            <img style="height: 260px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6 class="nombre texto-oculto2">
                                                <a href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a>
                                            </h6>
                                            <div class="user-area" style="padding: 0px;">
                                                <div class="user-details">
                                                    <p class="texto-oculto3" style="padding: 2px 0px;">{{ $program->description }}</p>
                                                </div>
                                            </div>
                                            <div class="user-area" style="padding: 3px;">
                                                <div class="user-details">
                                                    <img  style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                    <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span style="color:orange;">
                                                        <i class="fa fa-users"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="user-area" style="padding: 3px;">
                                                <div class="user-details">
                                                    <a href="">
                                                        <span style="color:orange;">
                                                            Sector:
                                                        </span>
                                                        <br>
                                                        <b>{{ $program->category_description=="Publico"?"Público":$program->category_description }}</b>
                                                    </a>
                                                </div>
                                                <div class="user-rating">
                                                    <span style="color:orange;">
                                                        <i>Modalidad:</i>
                                                    </span>
                                                    <br>
                                                    <b><div style="text-align: right;">{{ $program->additional1 }}</div></b>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <button onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} });" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus"></i>
                                                            Comprar Ahora S/. {{ $program->price }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach



                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-2"> <!-- Empresarial -->
                            <div class="course-slider owl-carousel">
                                

                                @foreach ($programs as $program)                                
                                    @if($program->category_description == "Empresarial")
                                        <div class="item">
                                            <div class="single-course-wrap">
                                                <div class="thumb">
                                                    <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                                    <img style="height: 260px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                                </div>
                                                <div class="wrap-details">
                                                    <h6 class="nombre texto-oculto2">
                                                        <a href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a>
                                                    </h6>
                                                    <div class="user-area" style="padding: 0px;">
                                                        <div class="user-details">
                                                            <p class="texto-oculto3" style="padding: 2px 0px;">{{ $program->description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="user-area" style="padding: 3px;">
                                                        <div class="user-details">
                                                            <img  style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                            <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                        </div>
                                                        <div class="user-rating">
                                                            <span style="color:orange;">
                                                                <i class="fa fa-users"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="user-area" style="padding: 3px;">
                                                        <div class="user-details">
                                                            <a href="">
                                                                <span style="color:orange;">
                                                                    Sector:
                                                                </span>
                                                                <br>
                                                                <b><div style="text-align: right;">{{ $program->category_description=="Publico"?"Público":$program->category_description }}</div></b>
                                                            </a>
                                                        </div>
                                                        <div class="user-rating">
                                                            <span style="color:orange;">
                                                                <i>Modalidad:</i>
                                                            </span>
                                                            <br>
                                                            <b><div style="text-align: right;">{{ $program->additional1 }}</div></b>
                                                        </div>
                                                    </div>
                                                    <div class="price-wrap">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-12">
                                                                <button onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} });" class="btn btn-primary">
                                                                    <i class="fa fa-cart-plus"></i>
                                                                    Comprar Ahora S/. {{ $program->price }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>


                        <div class="tab-pane fade" id="pills-3">  <!-- Derecho -->
                            <div class="course-slider owl-carousel">
                                
                                
                                @foreach ($programs as $program)                                
                                @if($program->category_description == "Derecho")
                                    <div class="item">
                                        <div class="single-course-wrap">
                                            <div class="thumb">
                                                <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                                <img style="height: 260px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                            </div>
                                            <div class="wrap-details">
                                                <h6 class="nombre texto-oculto2">
                                                    <a href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a>
                                                </h6>
                                                <div class="user-area" style="padding: 0px;">
                                                    <div class="user-details">
                                                        <p class="texto-oculto3" style="padding: 2px 0px;">{{ $program->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="user-area" style="padding: 3px;">
                                                    <div class="user-details">
                                                        <img  style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                        <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                    </div>
                                                    <div class="user-rating">
                                                        <span style="color:orange;">
                                                            <i class="fa fa-users"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="user-area" style="padding: 3px;">
                                                    <div class="user-details">
                                                        <a href="">
                                                            <span style="color:orange;">
                                                                Sector:
                                                            </span>
                                                            <br>
                                                            <b><div style="text-align: right;">{{ $program->category_description=="Publico"?"Público":$program->category_description }}</div></b>
                                                        </a>
                                                    </div>
                                                    <div class="user-rating">
                                                        <span style="color:orange;">
                                                            <i>Modalidad:</i>
                                                        </span>
                                                        <br>
                                                        <b>{{ $program->additional1 }}</b>
                                                    </div>
                                                </div>
                                                <div class="price-wrap">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <button onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} });" class="btn btn-primary">
                                                                <i class="fa fa-cart-plus"></i>
                                                                Comprar Ahora S/. {{ $program->price }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach                                
                            </div>
                        </div>


                        <div class="tab-pane fade" id="pills-4"> <!-- Publico -->
                            <div class="course-slider owl-carousel">
                                
                                

                                @foreach ($programs as $program)                                
                                @if($program->category_description == "Publico")
                                    <div class="item">
                                        <div class="single-course-wrap">
                                            <div class="thumb">
                                                <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                                <img style="height: 260px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                            </div>
                                            <div class="wrap-details">
                                                <h6 class="nombre texto-oculto2">
                                                    <a href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a>
                                                </h6>
                                                <div class="user-area" style="padding: 0px;">
                                                    <div class="user-details">
                                                        <p class="texto-oculto3" style="padding: 2px 0px;">{{ $program->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="user-area" style="padding: 3px;">
                                                    <div class="user-details">
                                                        <img  style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                        <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                    </div>
                                                    <div class="user-rating">
                                                        <span style="color:orange;">
                                                            <i class="fa fa-users"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="user-area" style="padding: 3px;">
                                                    <div class="user-details">
                                                        <a href="">
                                                            <span style="color:orange;">
                                                                Sector:
                                                            </span>
                                                            <br>
                                                            <b><div style="text-align: right;">{{ $program->category_description=="Publico"?"Público":$program->category_description }}</div></b>
                                                        </a>
                                                    </div>
                                                    <div class="user-rating">
                                                        <span style="color:orange;">
                                                            <i>Modalidad:</i>
                                                        </span>
                                                        <br>
                                                        <b>{{ $program->additional1 }}</b>
                                                    </div>
                                                </div>
                                                <div class="price-wrap">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <button onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} });" class="btn btn-primary">
                                                                <i class="fa fa-cart-plus"></i>
                                                                Comprar Ahora S/. {{ $program->price }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>