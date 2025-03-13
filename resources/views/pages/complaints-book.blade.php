@extends('layouts.celmovil')
@section('content')
    <!-- Preloader Start                                                                                                                                    </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->
    
	<!-- page banner area start -->
	<div class="page-banner">
			<img style="width: 100%; height: 250px;" src="{{ $banner[0]->content }}" alt="Page Banner" />
	</div>
	<!-- page banner area end -->
		
	
    <section style="padding: 40px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h1>
                            <span> LIBRO DE RECLAMACIONES </span>
                        </h1>
                        <div class="shape">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form>
                    <div class="col-md-12">
                        <h3>1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE</h3>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Tu Nombre *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Tus Apellidos *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="exampleInputEmail1">Tu correo electrónico *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Teléfono *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="exampleFormControlSelect1">Tipo documento *</label>
                      <select class="form-control" id="exampleFormControlSelect1">
                        <option>DNI</option>
                        <option>C.E.</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Número de documento *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="formGroupExampleInput">Dirección *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Distrito *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Ciudad *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Departamento *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="col-md-12">
                        <h3>2. IDENTIFICACIÓN DEL BIEN CONTRATADO</h3>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="exampleFormControlSelect1">Producto / Servicio *</label>
                      <select class="form-control" id="exampleFormControlSelect1">
                        <option>-- Por favor, elige una opción --</option>
                        <option>producto</option>
                        <option>servicio</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Descripción del servicio *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Monto del servicio *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Lugar de compra *</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>
        </div>
    </section>

    
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
