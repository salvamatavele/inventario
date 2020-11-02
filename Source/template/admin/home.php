<?php $v->layout('layout/master') ?>
<?php $v->insert('layout/header') ?>
<?php $v->insert('layout/nav') ?>
<main>
    <div class="row">
        <div class="col s6">
            <div align="center" class="card">
                <a href="<?= $router->route('user.index') ?>">
                    <div style="padding: 30px;" class="grey lighten-4 col s6 waves-effect">
                        <i class="indigo-text text-lighten-1 large material-icons">people</i>
                        <span class="indigo-text text-lighten-1">
                            <h5><?=$allUsers ?> Usuários</h5>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <div class="col s6">
            <div align="center" class="card">
                <a href="<?= $router->route('product.index') ?>">
                    <div style="padding: 30px;" class="grey lighten-4 col s6 waves-effect">
                        <i class="indigo-text text-lighten-1 large material-icons">store</i>
                        <span class="indigo-text text-lighten-1">
                            <h5><?=$allProducts ?> Produtos</h5>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s6">
            <div align="center" class="card">
                    <a href="<?= $router->route('location.index') ?>">
                        <div style="padding: 30px;" class="grey lighten-4 col s6 waves-effect">
                            <i class="indigo-text text-lighten-1 large material-icons">add_location_alt</i>
                            <span class="indigo-text text-lighten-1">
                                <h5><?=$allLocations ?> Compartimentos</h5>
                            </span>
                        </div>
                    </a>
            </div>
        </div>

        <div class="col s6">
            <div align="center" class="card">
                    <a href="<?= $router->route('category.index') ?>">
                        <div style="padding: 30px;" class="grey lighten-4 col s6 waves-effect">
                            <i class="indigo-text text-lighten-1 large material-icons">view_list</i>
                            <span class="indigo-text text-lighten-1">
                                <h5><?=$allCategories ?> Categorias</h5>
                            </span>
                        </div>
                    </a>
            </div>
        </div>
    </div>
</main>
<?php $v->insert('layout/footer') ?>