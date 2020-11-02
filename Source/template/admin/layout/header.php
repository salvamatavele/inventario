<header>
  <nav class="blue-grey navbar-fixed">
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <div class="nav-wrapper ">
      <a href="<?= $router->route('home') ?>" class="brand-logo  white-text">UMUM INVENTÁRIO</a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li class="red-text"><a href="<?= $router->route('logout') ?>"><i class="material-icons red-text">logout</i></a></li>
      </ul>
    </div>
  </nav>

  <ul class="sidenav " id="mobile-demo">
    <li class="red-text"><a href="<?= $router->route('logout') ?>"><i class="material-icons red-text">logout</i></a></li>
  </ul>
</header>