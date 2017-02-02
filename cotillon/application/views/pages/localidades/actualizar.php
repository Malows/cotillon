<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
  echo '
  <div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4>Genial!</h4>
          Se ha actualizado exitosamente la localidad <strong>'.$localidad['nombre_localidad'].
      '</div>';
  }
  echo form_open("/localidades/actualizar/".$localidad['id_localidad'])?>
    <div class="form-group">
        <label for="nombre_localidad">Nombre de localidad<?php echo form_error("nombre_localidad");?></label>
        <input type="text" class="form-control" name="nombre_localidad" placeholder="Nombre de localidad" value="<?php echo $localidad['nombre_localidad']; ?>">
        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close() ?>
</div>
