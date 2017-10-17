<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </div>
    <?php $replacement = '/cotillon/index.php'; ?>
    <script src="<?php echo str_replace($replacement, '', base_url('/assets/js/jquery-3.1.1.min.js'));?>"></script>
    <script src="<?php echo str_replace($replacement, '', base_url('/assets/js/bootstrap.min.js'));?>"></script>
    <script>
      (function(){
        modal_abrir = document.getElementById('modal-abrir-caja')
        abrir_btn_si = document.getElementById('modal-abrir-si')
        abrir_form = modal_abrir.getElementsByTagName('input')[0]

        modal_cerrar = document.getElementById('modal-cerrar-caja')
        cerrar_btn_si = document.getElementById('modal-cerrar-si')
        cerrar_form = modal_cerrar.getElementsByTagName('input')[0]

        abrir_btn_si.addEventListener('click', e => {
          let valor_input = parseFloat(abrir_form.value.replace(',','.'))
          $.ajax({
            url: '<?php echo base_url("/arqueos/abrir_caja") ?>',
            method: 'POST',
            data: {
              'monto': valor_input,
              '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            },
            success () { window.location.reload(true) }
          })
        })

        cerrar_btn_si.addEventListener('click', e => {
          let valor_input = parseFloat(cerrar_form.value.replace(',','.'))
          $.ajax({
            url: '<?php echo base_url("/arqueos/cerrar_caja") ?>',
            method: 'POST',
            data: {
              'real': valor_input,
              '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            },
            success () { window.location.reload(true) }
          })
        })

        $('#modal-abrir-caja').on('shown.bs.modal', () => {
          abrir_form.focus()
        })

        $('#modal-cerrar-caja').on('shown.bs.modal', () => {
          $.ajax({
            url: '<?php echo base_url("/arqueos/estimar_caja") ?>',
            method: 'GET',
            success () { cerrar_form.focus() }
          })
        })
      })();
    </script>
  </body>
</html>
