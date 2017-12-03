<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- -->
<h2>Configuraciones</h2>
<?php echo validation_errors(); ?>
<div class="container">
  <?php echo form_open('/usuarios/configuraciones'); ?>
    <div class="checkbox">
      <label for="">
        <input type="checkbox" name="modo-restore" value="1" <?= boolval($usuario['modo_restore']) ? 'checked' : ''?>>
        Activar modo de recuperación
      </label>
    </div>
    <hr>
    <div class="form-group">
      <input type="submit" name="submit" class="btn btn-primary" value="Guardar"/>
    </div>
  </form>
</div>
