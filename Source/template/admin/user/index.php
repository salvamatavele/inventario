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
      <h4 id="header">Novo Usuário</h4>
      <div class="row">
        <form class="col s12" id="userForm">
          <input type="hidden" name="id" id="id" value="null">
          <input type="hidden" name="_method" id="_method" value="null">
          <input type="hidden" name="action" id="action" value="add">
          <div class="row">
            <div class="input-field col s12">
              <input name="name" id="name" type="text" class="validate" placeholder="">
              <label for="name">Nome</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe o nome do usuário</span>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input name="email" id="email" type="email" class="validate" placeholder="">
              <label for="email">Email</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe o email do usuário</span>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <select name="permition" id="permition">
                <option value="" selected>Escolhe uma opção</option>
                <?php if ($_SESSION['permition'] == 'superadmin') : ?>
                  <option value="admin">Administrador</option>
                <?php endif;  ?>
                <option value="normal">Normal</option>
              </select>
              <label>Selecione o tipo de usuário</label>
            </div>
          </div>
          <div class="row" id="passwd">
            <div class="input-field col s12">
              <input name="password" id="password" type="password" class="validate" placeholder="">
              <label for="password">Senha</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe a senha do usuário</span>
            </div>
          </div>
          <div class="row" id="cf_passwd">
            <div class="input-field col s12">
              <input name="confirmPassword" id="confirmPassword" type="password" class="validate" placeholder="">
              <label for="confirmPassword">Confirmar Senha</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe a senha do usuário novamente</span>
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
  <div id="users" class="container">
    <table class="responsive-table highlight">
      <h4>Usuários</h4>
      <thead>
        <tr>
          <th>Imagem</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Accao</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!empty($users)) :
          foreach ($users as $user) : ?>
            <tr>
              <td><img class="circle responsive-img" src="<?= url($user->image)  ?>" width="30" srcset="<?= $user->name  ?>"> </td>
              <td><?= $user->name  ?></td>
              <td><?= $user->email  ?></td>
              <td>
                <a name="view" class="view waves-effect waves-teal " id="<?= $user->id  ?>"><i class="material-icons left teal-text">remove_red_eye</i></a>
                <a name="edit" class="edit waves-effect waves-teal " id="<?= $user->id  ?>"><i class="material-icons left green-text">edit</i></a>
                <a name="delete" class="delete waves-effect waves-teal " id="<?= $user->id  ?>"><i class="material-icons left red-text">delete</i></a>
              </td>
            </tr>
          <?php endforeach;
        else : ?>
          <td>Nenhum usuário encontrado</td>
        <?php endif; ?>
      </tbody>
    </table>
    <?= $paginate->render(); ?>
  </div>

  <!-- Modal Structure -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <div class="col s12 m7">
        <div class="card horizontal">
          <div class="card-image">
            <img class="circle responsive-img" id="b-img" src="">
          </div>
          <div class="card-stacked">
            <div class="card-content">
              <h5 id="b-name" class="header"></h5>
              <p id="b-email"></p>
              <p id="b-permition"></p>
              <p id="b-status"></p>
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
    $('select').formSelect();
  });
  $(document).on('click', '.create', function() {
    $("#userForm")[0].reset();
    $('#header').text('Novo Usuário')
    $('#action').val('add')
    $('#passwd').show();
    $('#cf_passwd').show();
    $('#modal1').modal('open');
  })


  $(function() {

    $("#password").keypress(function(e) {
      kc = e.keyCode ? e.keyCode : e.which;
      sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
      if (((kc >= 65 && kc <= 90) && !sk) || (kc >= 97 && kc <= 122) && sk) {
        Swal.fire({
          position: 'top-end',
          icon: 'warning',
          text: 'Ooops...A tecla Caps lock esta ligada por favor desligue a.',
          showConfirmButton: true,

        })
      }
    });
    //submit
    $('#userForm').submit(function(event) {
      event.preventDefault();
      var urls = '';

      var id = $(this).find('input#id').val();

      if ($('#action').val() === 'add') {

        urls = "<?= $router->route('user.store'); ?>";
      }
      if ($('#action').val() === 'edit') {

        urls = "<?= $router->route('user.index'); ?>" + "/" + id;
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
            $('#userForm')[0].reset();
            $('#modal1').modal('close');
            //location.reload();
            //setInterval('location.reload()', 1000);
            var url = "<?= $router->route('user.index') ?>"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
            $('#users').load(url + ' #users');
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
        url: "<?= $router->route('user.index') ?>" + "/" + id,
        data: "data",
        dataType: "json",
        success: function(response) {
          var data = response // response.data;
          console.log(data.status);
          if (data) {
            $('#b-name').text('Nome: ' + data.name);
            $('#b-email').text('Email: ' + data.email);
            $('#b-permition').text('Tipo de usuário: ' + data.permition);
            $('#b-status').text('Estado: ' + data.status);
            $("#b-img").prop('src', '<?= url('/') ?>' + data.image);
            $('#b-create').text('Registado aos: ' + data.created_at);
            $('#b-update').text('Actualizado aos: ' + data.updated_at);
            $('#modal2').modal('open');
          } else {
            Swal.fire({
              position: 'top-end',
              icon: 'warning',
              text: 'Ooops...Nenhum usuário foi encontrado',
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
        url: "<?= $router->route('user.index') ?>" + "/" + id + "/edit",
        data: "data",
        dataType: "json",
        success: function(response) {
          var data = response // response.data;

          if (data) {
            $('#userForm')[0].reset();
            $('#header').text('Editar Usuário: ' + data.name);
            $('#action').val('edit');
            $('#_method').val('PUT');
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#permition').val(data.permition);
            $('#password').val(data.password);
            $('#confirmPassword').val(data.password);
            $('#passwd').hide();
            $('#cf_passwd').hide();
            $('#modal1').modal('open');
          } else {
            Swal.fire({
              position: 'top-end',
              icon: 'warning',
              text: 'Ooops...Nenhum usuário foi encontrado',
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
            url: "<?= $router->route('user.index') ?>" + "/" + id,
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
                var url = '<?= $router->route('user.index'); ?>'; //please insert the url of the your current page here, we are assuming the url is 'index.php'         
                $('#users').load(url + ' #users');
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