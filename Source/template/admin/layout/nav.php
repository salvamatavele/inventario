<ul id="slide-out" class="sidenav sidenav-fixed white">
    <li>

        <div class="user-view">
            <div class="background">
                <img src="<?= asset('img/bg.jpg') ?>">
            </div>
            <a href="<?= $router->route('user.profile') ?>"><img class="circle responsive-img" src="<?= url($user->image)  ?>"></a>
            <a href="<?= $router->route('user.profile') ?>"><span class="white-text name"><?=$user->name ?></span></a>
            <a href="<?= $router->route('user.profile') ?>"><span class="white-text email"><?=$user->email ?></span></a>
        </div>
    </li>
    <li><a href="<?= $router->route('admin') ?>"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><a href="<?= $router->route('user.index') ?>"><i class="material-icons">people</i>Usuários</a></li>
    <li>
        <div class="divider"></div>
    </li>
    <li><a class="subheader"><i class="material-icons">addchart</i>Atividades</a></li>
    <li><a class="waves-effect" href="<?= $router->route('category.index') ?>"><i class="material-icons">view_list</i>Categorias</a></li>
    <li><a class="waves-effect" href="<?= $router->route('location.index') ?>"><i class="material-icons">add_location_alt</i>Compartimentos</a></li>
    <li><a class="waves-effect" href="<?= $router->route('color.index') ?>"><i class="material-icons">edit</i>Cores</a></li>
    <li><a class="waves-effect" href="<?= $router->route('product.index') ?>"><i class="material-icons">store</i>Produtos</a></li>
</ul>
