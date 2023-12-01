<footer class="bg-light py-4">
  <div class="container text-center">
      <div class="row">
          <div class="col-md-6">
              <ul class="nav justify-content-center">
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('blog_stories_policies') }}">Políticas del sitio</a>
                  </li>
              </ul>
          </div>
          <div class="col-md-6">
              <ul class="nav justify-content-center">
                  <li class="nav-item">
                      <a class="nav-link" href="https://www.facebook.com/tu_pagina" target="_blank" rel="noopener noreferrer">
                      <i class="fab fa-facebook-f"></i>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="https://www.twitter.com/tu_pagina" target="_blank" rel="noopener noreferrer">
                      <i class="fab fa-twitter"></i>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="https://www.instagram.com/tu_pagina" target="_blank" rel="noopener noreferrer">
                      <i class="fab fa-instagram"></i>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
      <p>&copy; 2023 {{ env('APP_NAME') }} Blog. Todos los derechos reservados.</p>
  </div>
</footer>