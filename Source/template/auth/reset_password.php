<?php $v->layout('template') ?>
<?php $v->push('css') ?>
<link rel="stylesheet" href="<?= asset('css/sign.css') ?>">
<?php $v->end() ?>

<div id="login-page" class="row">
  <h4>Recuperar Senha</h4>
  <div class="col s12 z-depth-6 card-panel">
    <form method="POST" class="login-form" id="resetForm" name="resetForm">
      <input type="hidden" name="_method" value="PUT">
      <div class="row">
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">lock_outline</i>
          <input name="password" id="password" type="password">
          <label for="password">Nova senha</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">lock_outline</i>
          <input name="confirmPassword" id="confirmPassword" type="password">
          <label for="confirmPassword">Confirmar senha</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <button type="submit" class="btn black-effect black-light col s12 black">Enviar</button>
        </div>
      </div>


    </form>
  </div>
</div>


<?php $v->push('js'); ?>
<script>
  $(function () {
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

    $("#resetForm").submit(function (params) {
      params.preventDefault();
      $.ajax({
        type: "post",
        url: "<?=$router->route('password.store') ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
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
          if (response.success) {

            Swal.fire({
              position: 'top-end',
              background: '#C8E6C9',
              icon: 'success',
              text: response.success,
              showConfirmButton: true,
            })
            setTimeout("window.location = '<?= $router->route('admin') ?>';", 2000);
          }
        }

      });
    })
  });
</script>
<?php $v->end(); ?>