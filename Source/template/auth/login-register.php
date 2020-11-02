<?php $v->layout('template') ?>
<?php $v->push('css') ?>
<link rel="stylesheet" href="<?= asset('css/sign.css') ?>">
<?php $v->end() ?>

<div id="login-page" class="row">
  <div class="col s12 z-depth-6 card-panel">
    <form method="POST" class="login-form" id="loginForm" name="loginForm">
      <div class="row">
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">mail_outline</i>
          <input name="user-email" class="validate" id="user-email" type="email">
          <label for="user-email" data-error="wrong" data-success="right">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">lock_outline</i>
          <input name="passwd" id="passwd" type="password">
          <label for="passwd">Password</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <button type="submit" class="btn black-effect black-light col s12 black">Login</button>
        </div>
      </div>
      <div class="row">

        <p class="margin center-align medium-small "><a class="reset waves-effect">Esqueceu a senha?</a></p>

      </div>

    </form>
  </div>
</div>
<!-- Modal Structure -->
<div id="modal1" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>New User</h4>
    <form id="userForm" method="post">
      <input type="hidden" name="_token" value="<?= _token(); ?>">
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="name" class="validate" id="name" type="text">
          <label for="name" data-error="wrong" data-success="right">Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">mail_outline</i>
          <input name="email" class="validate" id="email" type="email">
          <label for="email" data-error="wrong" data-success="right">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">lock_outline</i>
          <input name="password" id="password" type="password">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">lock_outline</i>
          <input name="confirmPassword" id="confirm-password" type="password">
          <label for="confirm-password">Confirm Password</label>
        </div>
      </div>
      <button type="submit" class="btn waves-effect waves-light right">Register</button>
    </form>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">close</a>
  </div>
</div>

<div id="reset" class="modal modal-fixed-footer">
  <div class="modal-content">
    &nbsp;&nbsp;&nbsp;<h5> Reconfigurar senha</h5>
    <form id="resetForm" method="post">
      &nbsp;&nbsp;&nbsp;<label for="email">Informe o seu email para reconfiguração da senha</label>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">mail_outline</i>
          <input name="email" class="validate" id="email" type="email">
          <label for="email" data-error="wrong" data-success="right">Email</label>
        </div>
      </div>
      <button type="submit" class="btn waves-effect waves-light right">Enviar</button>
    </form>
  </div>
  <div class="modal-footer">
    <a class="modal-close waves-effect waves-green btn-flat">close</a>
  </div>
</div>

<div id="preload" class="modal transparent">
  <div class="progress transparent">
    <div class="indeterminate"></div>
  </div>
</div>


<?php $v->push('js') ?>
<script>
  $(document).ready(function() {
    $('.fixed-action-btn').floatingActionButton();
    $('.modal').modal();
    $('.slider').slider();
    $('.materialboxed').materialbox();
  });
  $(document).on('click', '.reset', function() {
    $('#reset').modal('open');
  });
  $(function() {

    //create user
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
    $('#userForm').submit(function(event) {
      event.preventDefault();
      $.ajax({
        type: "post",
        url: "<?= $router->route('register'); ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
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
          if (response.success) {

            Swal.fire({
              position: 'top-end',
              background: '#C8E6C9',
              icon: 'success',
              text: response.success,
              showConfirmButton: false,
              timer: 5000
            })
            $('#userForm')[0].reset();
            $('#modal1').modal('close');
          }
        },
        error: function(response) {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            text: 'Ooops...Problemas no carregamento da pagina tente novamente.',
            showConfirmButton: false,
            timer: 1500
          })

          return;
        }


      });
    });
    // validate user
    $("#passwd").keypress(function(e) {
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
    $('#loginForm').submit(function(event) {
      event.preventDefault();
      $.ajax({
        type: "post",
        url: "<?= $router->route('validation'); ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.errors) {
            var error = '';
            for (i in response.errors) {
              error += response.errors[i] + "\n ";
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
          if (response.error) {
            Swal.fire({
              position: 'top-end',
              background: '#FFCDD2',
              icon: 'error',
              text: response.error,
              showConfirmButton: false,
              timer: 5000
            })
          }
          if (response.success) {
            console.log(response.success);
            setTimeout("window.location = '<?= $_SERVER['HTTP_REFERER'] ?>';", 800);
          }
        },
        error: function(response) {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            text: 'Ooops...Problemas no carregamento da pagina tente novamente.',
            showConfirmButton: false,
            timer: 1500
          })

          return;
        }


      });
    });
    //reset
    $("#resetForm").submit(function(event) {
      event.preventDefault();
      $.ajax({
        type: "post",
        url: "<?= $router->route("password") ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.error) {
            Swal.fire({
              position: 'top-end',
              background: '#FFCDD2',
              icon: 'error',
              text: response.error,
              showConfirmButton: false,
              timer: 5000
            })

          }
          if (response.success) {
            Swal.fire({
              position: 'center',
              background: '#C8E6C9',
              icon: 'success',
              text: response.success,
              showConfirmButton: true,
            })

            $("#reset").modal('close')
          }
        }
      });
    });
    $(document).on({
      ajaxStart: function() {
        $("#preload").modal('open')
      },
      ajaxStop: function() {
        $("#preload").modal('close')
      }
    });
  });
</script>
<?php $v->end() ?>