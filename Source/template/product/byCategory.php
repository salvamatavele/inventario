<?php $v->layout("theme/master")  ?>
<?php $v->insert('theme/nav'); ?>
<main>
    <div class="nav-wrapper right">
        <form method="POST" id="searchForm">
            <div class="input-field">
                <input id="search" name="search" type="search" required>
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>
    </div>
    <h2 class="title center teal-text">Produtos por Categorias</h2>
    <h4 class="grey-text lighten-4">&nbsp;Total de produtos regisatados: <?= $all ?></h4>
    <div class="row" id="data">
        <?php if (!empty($posts)) :
            foreach ($posts as $post) :  ?>
                <div class='col s12 m4'>
                    <div class="card medium">
                        <div class="card-image">
                            <img class="materialboxed" data-caption="<?= $post->title ?>" src="<?= url($post->image) ?>">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4"><?= $post->name; ?><i class="material-icons right">more_vert</i></span>
                            <p><a href="#">Criado aos <?= $post->created_at ?></a></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4"><?= $post->name; ?><i class="material-icons right">close</i></span>
                            <?php
                            $category = $cty->findById($post->category_id);
                            $location = $lct->findById($post->location_id);
                            $color = $clr->findById($post->color_id); ?>
                            <h6><strong class="blue-grey-text">Compartimento</strong>: <?= $location->name ?></h6>
                            <h6><strong class="blue-grey-text">Categoria</strong>: <?= $category->name ?></h6>
                            <h6><strong class="blue-grey-text">Cor</strong>: <?= $color->name ?></h6>
                            <h6><strong class="blue-grey-text">Quantidade</strong>: <?= $post->stock ?></h6>
                            <h6><strong class="blue-grey-text">Estado</strong>: <?= $post->status ?></h6>
                            <p class="grey-text"><strong class="blue-grey-text">Descricao</strong>: <?= $post->description ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else : ?>
            <h6 class="center">Nenhum iten encotrado.</h6>
        <?php endif; ?>
    </div>
    <?= $paginate->render(); ?>
</main>
<?php $v->insert('theme/footer'); ?>
<?php $v->push('js'); ?>
<script>
    $(function() {
        $(document).ready(function() {
            $("#search").keyup(function() {
                $('#searchForm').submit(function(event) {
                    event.preventDefault();
                    var search = $(this).find('input#search').val();
                    if (search === "") {
                        setInterval('location.reload()', 200);
                    } else {
                        $.ajax({
                            url: '<?= $router->route('product.search') ?>',
                            method: 'post',
                            dataType: 'html',
                            data: $(this).serialize(),
                            success: function(data) {
                                $('#data').empty().html(data);
                            }
                        });
                    }
                    return false;

                })
                $('#searchForm').trigger('submit');
            })
        });


    });
</script>
<?php $v->end(); ?>