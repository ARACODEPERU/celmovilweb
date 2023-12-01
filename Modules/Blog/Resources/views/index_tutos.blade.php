@extends('blog::layouts.master')
@section('title', 'Delventas Developers')
@section('title')
    <meta name="robots" content="index, follow">
@stop

@section('content')


    <header class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Bienvenido a Delventas Blog</h1>
            <p class="lead">Encuentra tutoriales cortos y consejos para programadores.</p>
        </div>
    </header>

    <section class="container">
        <div class="row mb-4">
            <div class="col-12 col-md-9">
                @foreach ($articles as $article)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('blog_article_by_url', $article->url) }}" class="flex-shrink-0">
                                    <img src="{{ $article->imagen }}" alt="{{ $article->title }}" style="width: 100px;">
                                </a>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="card-title">
                                        <a href="{{ route('blog_article_by_url', $article->url) }}"
                                            style="text-decoration: none; color: inherit;">
                                            {{ $article->title }}
                                        </a>
                                    </h5>
                                    <p>{{ $article->short_description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <img src="{{ asset('img/spc.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Sistema de Punto de Ventas de Calzado en Laravel 10</h5>
                        <p class="card-text">Nuestro sistema de punto de ventas de calzado desarrollado en Laravel 10 ofrece
                            una solución completa y eficiente para la gestión de ventas de zapatillas por tallas.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-primary">Registro de productos</li>
                        <li class="list-group-item list-group-item-secondary">Administración de precios por local</li>
                        <li class="list-group-item list-group-item-success">Gestión de ventas</li>
                        <li class="list-group-item list-group-item-danger">Reportes de ventas</li>
                        <li class="list-group-item list-group-item-warning">Apertura y cierre de caja chica</li>
                        <li class="list-group-item list-group-item-light">Roles de usuario</li>
                    </ul>
                    {{-- <div class="card-body">
                      <a href="#" class="card-link">Roles de usuario</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
