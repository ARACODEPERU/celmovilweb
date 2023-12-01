<nav class="navbar navbar-expand-lg bg-dark " data-bs-theme="dark">
    <div class="container text-primary text-opacity-25">
        <a class="navbar-brand" href="#">Cuentos Cortos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('blog_principal') }}">Inicio</a>
                </li>
                @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog_principal') }}">{{ $category->description }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>