<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
  echo '
  <div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4>Genial!</h4>
          Se ha actualizado exitosamente la categoria de productos <strong>'.$categoria['nombre_categoria'].
      '</div>';
  }
  echo form_open("/categorias/actualizar/".$categoria['id_categoria'])?>
    <div class="form-group">
        <label for="nombre_categoria">Nombre de categoria<?php echo form_error("nombre_categoria");?></label>
        <input type="text" class="form-control" name="nombre_categoria" placeholder="Nombre de categoria" value="<?php echo $categoria['nombre_categoria']; ?>">
        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close() ?>
</div>
