<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
    echo '
    <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <h4>Genial!</h4>
      Se ha eliminado exitosamente el usuario de <strong>'.$usuario['nombre'].' '.$usuario['apellido'].'</strong>.
    </div>';
  }?>
  <div class="jumbotron">
    <h1>Eliminar usuario</h1>
    <p>
      Ud. está a punto de eliminar un usuario, los datos del mismo persistiran en el sistema pero no se le perimitirá el acceso al usuario eliminado.
    </p>
    <hr>
    <ul>
      <li>Nombre: <?php echo $usuario['apellido'] .', '. $usuario['nombre']; ?></li>
      <li>DNI: <?php echo $usuario['dni']; ?></li>
      <li>Fecha de empleo: <?php echo $usuario['fecha_inicio']; ?></li>
    </ul>
    <?php echo form_open('/usuarios/eliminar/' . $usuario['id_usuario']);?>
    <input type="submit" class="btn btn-default" name="submit" value="Eliminar">
    <?php echo form_close(); ?>
  </div>
</div>
