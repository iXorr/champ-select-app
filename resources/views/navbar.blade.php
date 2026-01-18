@auth

<nav class="navbar navbar-light px-2 rounded shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Кофеманы</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Навигация</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          @can('admin')
            <li class="nav-item">
              <a class="nav-link" href="/users">Пользователи</a>
            </li>
          @endcan

          <li class="nav-item">
            <a class="nav-link" href="/profile">Профиль</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="/logout">Выйти</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

@endauth
