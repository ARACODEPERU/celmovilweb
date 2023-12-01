<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
      <a class="navbar-brand" href="#">Delventas Developers</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('blog_principal') }}">Inicio</a>
              </li>
              {{-- <li class="nav-item">
                  <a class="nav-link" href="#">Tutoriales</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Consejos</a>
              </li> --}}
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('blog_contact_us') }}">Contacto</a>
              </li>
          </ul>
      </div>
  </div>
</nav>