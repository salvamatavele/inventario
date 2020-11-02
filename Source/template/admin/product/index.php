<?php $v->layout('../layout/master') ?>
<?php $v->insert('../layout/header') ?>
<?php $v->insert('../layout/nav') ?>

<main>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red create">
            <i class="large material-icons">mode_edit</i>
        </a>
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 id="header">Novo Produto</h4>
            <div class="row">
                <form class="col s12" id="postForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="null">
                    <input type="hidden" name="_method" id="_method" value="null">
                    <input type="hidden" name="action" id="action" value="add">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="name" id="name" type="text" class="validate" placeholder="Nome do produto">
                            <label for="name">Nome</label>
                            <span class="helper-text" data-error="wrong" data-success="right">Informe o nome do
                                produto</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="stock" id="stock" type="number" class="validate" placeholder="">
                            <label for="stock">Quantidade</label>
                            <span class="helper-text" data-error="wrong" data-success="right">Informe a quantidade do
                                produto</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="color" id="color">
                                <option value="" selected>Selecione a cor</option>
                                <?php if (!empty($colores)) :
                                    foreach ($colores as $color) : ?>
                                        <option value="<?= $color->id  ?>"><?= $color->name  ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                            <label>Selecione a cor do produto (optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="status" id="status">
                                <option value="" selected>Selecione o estado</option>
                                <option value="Bom">Bom</option>
                                <option value="Razoavel">Razoável</option>
                                <option value="Mau">Mau</option>
                            </select>
                            <label>Selecione o estado do produto</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="category" id="category">
                                <option value="" selected>Categoria</option>
                                <?php if (!empty($categories)) :
                                    foreach ($categories as $category) : ?>
                                        <option value="<?= $category->id  ?>"><?= $category->name  ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                            <label>Selecione a Categoria</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="location" id="location">
                                <option value="" selected>Departamento</option>
                                <?php if (!empty($locations)) :
                                    foreach ($locations as $location) : ?>
                                        <option value="<?= $location->id  ?>"><?= $location->name  ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                            <label> Selecione o Departamento</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea name="description" id="description" class="materialize-textarea" placeholder=""></textarea>
                            <label for="description">Descricao</label>
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Imagem</span>
                            <input name="image" type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input name="image" class="file-path validate" type="text">
                        </div>
                    </div>
                    <button id="action-button" class="btn waves-effect waves-light right" type="submit" name="action-button">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">close</a>
        </div>
    </div>
    <div id="datas">
    <h4 class="teal-text brand-logo">Produtos</h4>
        <nav class="transparent">
            <div class="nav-wrapper">
                

                <ul class="right nav-wrapper">
                    <li>
                        <div class="nav-wrapper right">
                            <form method="POST" id="searchForm">
                                <div class="input-field">
                                    <input id="search" name="search" type="search" required>
                                    <label class="label-icon" for="search"><i class="material-icons black-text">search</i></label>
                                    <i class="material-icons ">close</i>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <table class="responsive-table highlight">

            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Estado</th>
                    <th>Quantidade</th>
                    <th>Accao</th>
                </tr>
            </thead>

            <tbody id="data">
                <?php if (!empty($products)) :
                    foreach ($products as $product) : ?>
                        <tr>
                            <td><img src="<?= url($product->image) ?>" width="30" srcset="<?= $product->name  ?>"> </td>
                            <td><?= $product->name  ?></td>
                            <td><?= $product->status  ?></td>
                            <td><?= $product->stock  ?></td>
                            <td>
                                <a name="view" class="view waves-effect waves-teal " id="<?= $product->id  ?>"><i class="material-icons left teal-text">remove_red_eye</i></a>
                                <a name="edit" class="edit waves-effect waves-teal " id="<?= $product->id  ?>"><i class="material-icons left green-text">edit</i></a>
                                <a name="delete" class="delete waves-effect waves-teal " id="<?= $product->id  ?>"><i class="material-icons left red-text">delete</i></a>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <td>Nenhum produto encontrado</td>
                <?php endif; ?>
            </tbody>
        </table>
        <?= $paginate->render(); ?>
    </div>

    <!-- Modal Structure -->
    <div id="modal2" class="modal">
        <div class="modal-content">
            <div class="col s1 m7">
                <h4 id="h-title" class="header"></h4>
                <div class="card horizontal">
                    <div class="card-image">
                        <img id="b-img" src="">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p class="blue-grey-text" id="b-qty"></p>
                            <p class="blue-grey-text" id="b-color"></p>
                            <p class="blue-grey-text" id="b-status"></p>
                            <p class="blue-grey-text" id="b-category"></p>
                            <p class="blue-grey-text" id="b-location"></p>
                            <hr>
                            <p id="b-description"></p>
                        </div>
                        <div class="card-action">
                            <a href="#" id="b-create"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>
</main>
<?php $v->insert('../layout/footer') ?>

<?php $v->push('js') ?>
<script>
    $(document).ready(function() {
        $('.modal').modal();
        M.textareaAutoResize($('#description'));
        $('select').formSelect();
        $('.dropdown-trigger').dropdown();

    });

    $(document).on('click', '.create', function() {
        $('#postForm')[0].reset();
        $('#header').text('Novo produto')
        $('#action').val('add');
        $('#_method').val('null');
        $('#id').val('null');
        $('#modal1').modal('open');
    })

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
                            url: '<?= $router->route('product.searchTable') ?>',
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
        //submit
        $('#postForm').submit(function(event) {
            event.preventDefault();
            var urls = '';

            var id = $(this).find('input#id').val();

            if ($('#action').val() === 'add') {

                urls = "<?= $router->route('product.store'); ?>";
            }
            if ($('#action').val() === 'edit') {

                urls = "<?= $router->route('product.index'); ?>" + "/" + id;
            }
            $.ajax({
                type: "post",
                url: urls,
                cache: false,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    //error report
                    if (response.errors) {
                        var error = '';
                        for (i in response.errors) {
                            error += response.errors[i] + " \n ";
                        }
                        Swal.fire({
                            position: 'top-end',
                            background: '#FFCDD2',
                            icon: 'error',
                            text: error,
                            showConfirmButton: false,
                            timer: 5000
                        })


                    }
                    //success
                    if (response.success) {
                        $('#postForm')[0].reset();
                        $('#modal1').modal('close');
                        //location.reload();
                        //setInterval('location.reload()', 1000);
                        var url =
                            "<?= $router->route('product.index') ?>"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
                        $('#datas').load(url + ' #datas');
                        //readyData();
                        Swal.fire({
                            position: 'top-end',
                            background: '#C8E6C9',
                            icon: 'success',
                            text: response.success,
                            showConfirmButton: false,
                            timer: 2000
                        })

                    }
                },
                error: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        text: 'Ocoreu algum problema! Tente novamente.',
                        showConfirmButton: false,
                        timer: 3800
                    })
                    setInterval('location.reload()', 3800);
                }
            });
        });
        //show
        $(document).on('click', '.view', function() {
            var id = $(this).attr('id')
            $.ajax({
                type: "get",
                url: "<?= $router->route('product.index') ?>" + "/" + id,
                data: "data",
                dataType: "json",
                success: function(response) {
                    var data = response.product // response.data;
                    console.log(response);
                    if (data) {
                        $('#h-title').text(data.name);
                        $('#b-description').text('Descrição: ' + data.description);
                        $('#b-qty').text('Quantidade: ' + data.stock);
                        $('#b-status').text('Estado de conservacao: ' + data.status);
                        console.log(response.color);
                        $('#b-color').text('Cor: ' + response.color.name);
                        $('#b-category').text('Categoria: ' + response.category.name);
                        $('#b-location').text('Compartimento: ' + response.location.name);
                        $("#b-img").prop('src', '<?= url("/") ?>' + data.image);
                        $('#b-create').text('Criado aos: ' + data.created_at);
                        $('#modal2').modal('open');
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            text: 'Ooops...Nenhum produto foi encontrado',
                            showConfirmButton: false,
                            timer: 1800
                        })
                    }
                },
                error: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        text: 'Ocoreu algum problema! Tente novamente.',
                        showConfirmButton: false,
                        timer: 3800
                    })
                    setInterval('location.reload()', 3800);
                }
            });
        });

        //edit
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id')
            $.ajax({
                type: "get",
                url: "<?= $router->route('product.index') ?>" + "/" + id + "/edit",
                data: "data",
                dataType: "json",
                success: function(response) {
                    var data = response.product // response.product;

                    if (data) {
                        $('#postForm')[0].reset();
                        $('#header').text('Editar produto: ' + data.name);
                        $('#action').val('edit');
                        $('#_method').val('PUT');
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#stock').val(data.stock);
                        $('#color').val(data.color_id);
                        $('#status').val(data.status);
                        $('#category').val(data.category_id);
                        $('#location').val(data.location_id);
                        $('#description').val(data.description);
                        $('#modal1').modal('open');
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            text: 'Ooops...Nenhum produto foi encontrado',
                            showConfirmButton: false,
                            timer: 1800
                        })
                    }
                },
                error: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        text: 'Ocoreu algum problema! Tente novamente.',
                        showConfirmButton: false,
                        timer: 3800
                    })
                    setInterval('location.reload()', 3800);
                }
            });
        });
        //delete
        $(document).on('click', '.delete', function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Tem certeza que pretende eliminar?',
                text: "Você nao vai poder reverter ao confirmar isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim, eliminar!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "delete",
                        url: "<?= $router->route('product.index') ?>" + "/" + id,
                        cache: false,
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: 'top-end',
                                    background: '#C8E6C9',
                                    icon: 'success',
                                    text: response.success,
                                    showConfirmButton: false,
                                    timer: 4800
                                })
                                var url = '<?= $router->route('
                            product
                            .index '); ?>'; //please insert the url of the your current page here, we are assuming the url is 'index.php'
                                $('#datas').load(url + ' #datas');
                            }
                            if (response.error) {
                                Swal.fire({
                                    position: 'top-end',
                                    background: '#FFCDD2',
                                    icon: 'error',
                                    text: response.error,
                                    showConfirmButton: false,
                                    timer: 3800
                                })
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                text: 'Ocoreu algum problema! Tente novamente.',
                                showConfirmButton: false,
                                timer: 3800
                            })
                            setInterval('location.reload()', 3800);
                        }
                    });

                }
            })

        });


    });
</script>
<?php $v->end() ?>