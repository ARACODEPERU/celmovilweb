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
                <form method="POST" action="{{ route('send_claim') }}">
                    @csrf
                    <div class="col-md-12">
                        <h3>1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE</h3>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Tu Nombre *</label>
                        <input type="text" class="form-control" name="names" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Tus Apellidos *</label>
                        <input type="text" class="form-control" name="lastnames" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="exampleInputEmail1">Tu correo electrónico *</label>
                      <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Teléfono *</label>
                        <input type="text" class="form-control" name="phone" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="exampleFormControlSelect1">Tipo documento *</label>
                      <select name="document_type" class="form-control" id="exampleFormControlSelect1">
                        <option value="DNI">DNI</option>
                        <option value="C.E.">C.E.</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="formGroupExampleInput">Número de documento *</label>
                        <input type="text" class="form-control" name="number" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="formGroupExampleInput">Dirección *</label>
                        <input type="text" class="form-control" name="address" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Distrito *</label>
                        <input type="text" class="form-control" name="district" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Ciudad *</label>
                        <input type="text" class="form-control" name="city" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Departamento *</label>
                        <input type="text" class="form-control" name="state" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="col-md-12">
                        <h3>2. IDENTIFICACIÓN DEL BIEN CONTRATADO</h3>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="exampleFormControlSelect1">Producto / Servicio *</label>
                      <select class="form-control" name="product_service" id="exampleFormControlSelect1">
                        <option>-- Por favor, elige una opción --</option>
                        <option value="Producto">Producto</option>
                        <option value="Servicio">Servicio</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Descripción del producto/servicio *</label>
                        <input type="text" class="form-control" name="product_description" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Monto del producto/servicio *</label>
                        <input type="text" class="form-control" name="amount" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Lugar de compra *</label>
                        <input type="text" class="form-control" name="bought_place" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Fecha de compra *</label>
                        <input type="text" class="form-control" name="date_bought" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="formGroupExampleInput">Módelo *</label>
                        <input type="text" class="form-control" name="model" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="col-md-12">
                        <h3>3. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h3>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="exampleFormControlSelect1">Queja / Reclamo *</label>
                      <select name="queja_reclamo" class="form-control" id="exampleFormControlSelect1">
                        <option name="0">-- Por favor, elige una opción --</option>
                        <option name="Queja">Queja</option>
                        <option name="Reclamo" >Reclamo</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleFormControlTextarea1" class="form-label">Detalle:</label>
                      <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="4"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="exampleFormControlTextarea1" class="form-label">Pedido:</label>
                      <textarea class="form-control" name="pedido" id="exampleFormControlTextarea1" rows="4"></textarea>
                    </div>
                    <div class="col-md-12">
                        <h3>4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</h3>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="exampleFormControlTextarea1" class="form-label">Detalle:</label>
                      <textarea class="form-control" name="acciones" id="exampleFormControlTextarea1" rows="4"></textarea>
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-celmovil">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar
                        </button>
                    </div>
                  </form>
            </div>
        </div>
    </section>


    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
