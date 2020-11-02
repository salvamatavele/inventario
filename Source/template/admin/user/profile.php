<?php $v->layout('../layout/master') ?>
<?php $v->insert('../layout/header') ?>
<?php $v->insert('../layout/nav') ?>
<?php $v->push('css') ?>
<link rel="stylesheet" href="<?= asset('css/profile.css') ?>">
<?php $v->end() ?>
<main>
  <h3 class="center grey-text">Meu Perfil</h3>

  <div class="card">
    <div class="card-image">
      <img id="photo" width="250" class="circle materialboxed" src="<?= url($user->image) ?>" alt="image">
      <a id="<?= $_SESSION['id'] ?>" class=" btn-small waves-effect waves-light red upload"><i class="material-icons">publish</i>Mudar foto</a>
    </div>
    <h3><i class="material-icons medium prefix"> person</i> <?= $user->name  ?></h3>
    <p><i class="material-icons prefix">email</i> <?= $user->email  ?></p>
    <p class="title"> <i class="material-icons prefix">lock</i> <?= $user->permition  ?></p>
    <div class="row">
      <a id="<?= $_SESSION['id'] ?>" class="waves-effect waves-light btn-small grey update">Actualizar conta</a>
      <a id="<?= $_SESSION['id'] ?>" class="waves-effect waves-light btn-small passwd">Mudar senha</a>
    </div>
  </div>

  <!-- Modal Structure upload-->
  <div id="modal1" class="modal  modal-fixed-footer">
    <div class="modal-content">
      <h4>Mudar Foto</h4>
      <form id="uploadForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <div class="container">
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
          <br>
          <div style="margin-top: 20%;">
            <progress id="bar" class="" style="width: 100%;" value="0" max="100"> Progress: 50%</progress>
          </div>
        </div>

      </form>

    </div>
    <div class="modal-footer">
      <a class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
  </div>
  <!-- Modal Structure update-->
  <div id="update" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Actualizar conta</h4>
      <div class="row">
        <form class="col s12" id="updateForm" method="POST">
          <div class="row">
            <div class="input-field col s12">
              <input name="name" id="name" type="text" class="validate" value="<?= $user->name ?>">
              <label for="title">Nome</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe o nome do usuário</span>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input name="email" id="email" type="email" class="validate" value="<?= $user->email ?>">
              <label for="title">Email</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe o email do usuário</span>
            </div>
          </div>

          <button id="action-button" class="btn waves-effect waves-light right" type="submit" name="action-button">Submit
            <i class="material-icons right">send</i>
          </button>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <a class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
  </div>
  <!-- Modal Structure password-->
  <div id="password" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Alterar senha</h4>
      <div class="row">
        <form class="col s12" id="passwordForm">
          <input type="hidden" name="_method" value="PUT">
          <div class="row" id="passwd">
            <div class="input-field col s12">
              <input name="last_password" id="last" type="password" class="validate">
              <label for="last">Senha anterior</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe a senha anterior</span>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input name="new_password" id="new" type="password" class="validate">
              <label for="new">Nova Senha</label>
              <span class="helper-text" data-error="wrong" data-success="right">Informe a sua nova senha</span>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input name="confirmPassword" id="confirmPassword" type="password" class="validate">
              <label for="confirmPassword">Confirmar Senha</label>
              <span class="helper-text" data-error="wrong" data-success="right">Confirme a sua nova senha</span>
            </div>
          </div>

          <button id="action-button" class="btn waves-effect waves-light right" type="submit" name="action-button">Submit
            <i class="material-icons right">send</i>
          </button>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <a class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
  </div>
</main>
<?php $v->insert('../layout/footer') ?>
<?php $v->push('js') ?>
<script>
  $(document).ready(function() {
    $('.fixed-action-btn').floatingActionButton();
    $('.modal').modal();
    $('.slider').slider();
    $('.materialboxed').materialbox();
  });

  function progressBar() {
    var element = document.getElementById("bar");
    var width = 1;
    var identity = setInterval(scene, 20);

    function scene() {
      if (width >= 100) {
        clearInterval(identity);
      } else {
        width++;
        element.value = width;
      }
    }
  }


  $(document).on('click', '.upload', function() {

    $('#modal1').modal('open');
  });
  $('#uploadForm').submit(function(event) {
    event.preventDefault();

    $.ajax({
      type: "post",
      url: "<?= $router->route('user.profile.upload'); ?>",
      cache: false,
      data: new FormData(this),
      dataType: "json",
      contentType: false,
      processData: false,
      success: function(response) {

        if (response.success) {

          progressBar();
          //$('#uploadForm')[0].reset();
          //$('#modal1').modal('close');
          //$('#gallery').html(response).delay(2000);
          // var url = '<?= $router->route('upload.index'); ?>'; //please insert the url of the your current page here, we are assuming the url is 'index.php'         
          //$('#all').load(url + ' #all'); //note: the space before #div1 is very important 
          //$('#gallery').load(url + '').fadeIn("fast");
          //$('.materialboxed').materialbox('open');

          setInterval('location.reload()', 2000);
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
        setInterval('location.reload()', 2000);
      }

    });
  });
  $(document).on('click', '.update', function() {
    $('#update').modal('open');
  });
  $("#updateForm").submit(function (event) { 
    event.preventDefault();
    console.log($(this).serialize())
    $.ajax({
      type: "PUT",
      url: "<?= $router->route('user.profile.update') ?>",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success){
          Swal.fire({
            position: 'top-end',
            background: '#C8E6C9',
            icon: 'success',
            text: response.success,
            showConfirmButton: false,
            timer: 3800
          })

          setInterval('location.reload()',2000);
        } 
        if (response.error) {
            var error = '';
            for (i in response.error) {
              error += response.error[i] + " \n ";
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


  $(document).on('click', '.passwd', function() {
    $('#password').modal('open');
  });
  $("#last").keypress(function(e) {
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
    $("#new").keypress(function(e) {
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

  $("#passwordForm").submit(function (event) { 
    event.preventDefault()
    $.ajax({
      type: "PUT",
      url: "<?= $router->route('user.profile.password') ?>",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success){
          Swal.fire({
            position: 'top-end',
            background: '#C8E6C9',
            icon: 'success',
            text: response.success,
            showConfirmButton: false,
            timer: 3800
          })

          setInterval('location.reload()',2000);
        } 
        if (response.error) {
            var error = '';
            for (i in response.error) {
              error += response.error[i] + " \n ";
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
      }
    });
   });
</script>
<?php $v->end() ?>