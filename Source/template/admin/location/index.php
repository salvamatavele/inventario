<?php $v->layout('../layout/master') ?>
<?php $v->insert('../layout/header') ?>
<?php $v->insert('../layout/nav') ?>
<main>

  <div class="fixed-action-btn">
    <a class="create btn-floating btn-large red ">
      <i class="large material-icons">mode_edit</i>
    </a>
  </div>

  <!-- Modal Structure -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4 id="header">Nova Localizacao</h4>
      <div class="row">
        <form class="col s12" id="locationForm">
          <input type="hidden" id="id" name="id" value="">
          <input type="hidden" id="_method" name="_method" value="">
          <input type="hidden" name="action" id="action" value="add">
          <div class="row">
            <div class="input-field col s12">
              <input name="name" id="name" type="text" class="validate" placeholder="">
              <label for="name">Nome</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe o nome do compartimento</span>
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
  <div class="container" id="locations">
    <h3 class="green-text">Compartimentos</h3>
    <table class="responsive-table highlight">
      <thead>
        <tr>
          <th>#</th>
          <th>Local</th>
          <th>Accao</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!empty($locations)) :
          foreach ($locations as $location) : ?>
            <tr>
              <td><?= $location->id  ?></td>
              <td><?= $location->name  ?></td>
              <td>
                <a name="edit" class="edit waves-effect waves-teal " id="<?= $location->id  ?>"><i class="material-icons left green-text">edit</i></a>
                <a name="delete" class="delete waves-effect waves-teal " id="<?= $location->id  ?>"><i class="material-icons left red-text">delete</i></a>
              </td>
            </tr>
          <?php endforeach;
        else : ?>
          <td>Nenhum compartimento encontrado</td>
        <?php endif; ?>
      </tbody>
    </table>
    <?= $paginate->render(); ?>
  </div>
</main>
<?php $v->insert('../layout/footer') ?>

<?php $v->push('js') ?>
<script>
  $(document).ready(function() {
    $('.modal').modal();
  });
  $(document).on('click', '.create', function() {
    $("#locationForm")[0].reset();
    $('#header').text('Novo Compartimento')
    $('#action').val('add')
    $('#modal1').modal('open');
  })

  $(function() {

    //submit
    $('#locationForm').submit(function(event) {
      event.preventDefault();
      var urls = '';

      var id = $(this).find('input#id').val();

      if ($('#action').val() === 'add') {

        urls = "<?= $router->route('location.store'); ?>";
      }
      if ($('#action').val() === 'edit') {

        urls = "<?= $router->route('location.index'); ?>" + "/" + id;

      }
      $.ajax({
        type: "post",
        url: urls,
        cache: false,
        data: $(this).serialize(),
        dataType: "json",
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

            //location.reload();
            //setInterval('location.reload()', 1000);
            var url = "<?= $router->route('location.index') ?>"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
            $('#locations').load(url + ' #locations');
            //readyData();
            Swal.fire({
              position: 'top-end',
              background: '#C8E6C9',
              icon: 'success',
              text: response.success,
              showConfirmButton: false,
              timer: 2000
            })
            $('#locationForm')[0].reset();
            $('#modal1').modal('close');

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
        url: "<?= $router->route('location.index') ?>" + "/" + id + "/edit",
        data: "data",
        dataType: "json",
        success: function(response) {
          var data = response // response.data;
          console.log(response)
          if (data) {
            $('#locationForm')[0].reset();
            $('#header').text('Editar Compartimento: ' + data.name);
            $('#action').val('edit');
            $('#_method').val('PUT');
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#modal1').modal('open');
          } else {
            Swal.fire({
              position: 'top-end',
              icon: 'warning',
              text: 'Ooops...Nenhum item foi encontrada',
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
        title: 'Tem certeza que pretende eliminar esse compartimento?',
        text: "Ao eliminar o compartimento também serão eliminado os produtos registados com o mesmo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim,eliminar!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: "delete",
            url: "<?= $router->route('location.index') ?>" + "/" + id,
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
                var url = '<?= $router->route('location.index'); ?>'; //please insert the url of the your current page here, we are assuming the url is 'index.php'         
                $('#locations').load(url + ' #locations');
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