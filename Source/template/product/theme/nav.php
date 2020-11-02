<header>
  <nav class="blue-grey navbar-fixed">
    <div class="nav-wrapper ">
      <a href="<?= $router->route('product') ?>" class="brand-logo  white-text">UMUM INVENTÁRIO</a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger "><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li>
          <a class='dropdown-trigger ' href='#' data-target='category'>Categorias<i class="material-icons right">arrow_drop_down</i></a>
        </li>
        <ul id='category' class='dropdown-content'>
          <?php if (isset($categories)) :
            foreach ($categories as $key => $category) : ?>
              <li><a href="<?= $router->route('product.category', ['id' => $category->id]) ?>"><?= $category->name ?></a></li>
          <?php endforeach;
          endif; ?>
        </ul>
        <li>

          <a class='dropdown-trigger ' href='#' data-target='location'>Compartimentos<i class="material-icons right">arrow_drop_down</i></a>

        </li>
        <ul id='location' class='dropdown-content'>
          <?php if (isset($locations)) :
            foreach ($locations as $key => $location) : ?>
              <li><a href="<?= $router->route('product.location', ['id' => $location->id]) ?>"><?= $location->name ?></a></li>
          <?php endforeach;
          endif; ?>
        </ul>

        <li><a style=" width: 65px; height: 65px;" title="<?= $user->name ?>" href="#"><img style="margin-top: 8px;" width="50" height="50" class="circle " src="<?= url($user->image)  ?>"></a></li>
        <li>
          <a class='dropdown-trigger ' href='#' data-target='dropdown2'><?= $user->name ?><i class="material-icons right">arrow_drop_down</i></a>
        </li>
        <ul id='dropdown2' class='dropdown-content'>
          <li><a href="<?= $router->route('perfil') ?>">Meu Perfil</a></li>
          <li><a title="Sair" href="<?= $router->route('logout') ?>"><i class="material-icons red-text">logout</i></a></li>
        </ul>
      </ul>
    </div>
  </nav>

  <ul class="sidenav " id="mobile-demo">
    <li>
      <a class='dropdown-trigger ' href='#' data-target='category1'>Categorias<i class="material-icons right">arrow_drop_down</i></a>
    </li>
    <ul id='category1' class='dropdown-content'>
      <?php if (isset($categories)) :
        foreach ($categories as $key => $category) : ?>
          <li><a href="<?= $router->route('product.category', ['id' => $category->id]) ?>"><?= $category->name ?></a></li>
      <?php endforeach;
      endif; ?>
    </ul>
    <li>

      <a class='dropdown-trigger ' href='#' data-target='location1'>Compartimentos<i class="material-icons right">arrow_drop_down</i></a>

    </li>
    <ul id='location1' class='dropdown-content'>
      <?php if (isset($locations)) :
        foreach ($locations as $key => $location) : ?>
          <li><a href="<?= $router->route('product.location', ['id' => $location->id]) ?>"><?= $location->name ?></a></li>
      <?php endforeach;
      endif; ?>
    </ul>

    <li><a style=" width: 65px; height: 65px;" title="<?= $user->name ?>" href="#"><img style="margin-top: 8px;" width="50" class="circle " src="<?= url($user->image)  ?>"></a></li>
    <li><a href=""><?= $user->name ?></a></li>
    <li><a href="<?= $router->route('perfil') ?>">Meu Perfil</a></li>
    <li class="red-text"><a title="Sair" href="<?= $router->route('logout') ?>"><i class="material-icons red-text">logout</i></a></li>
  </ul>
</header>