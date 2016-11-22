<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <div class="form-group">

      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" name="nombre" value="<?php echo $usuario['nombre']?>" readonly>

      <label for="apellido">Apellido</label>
      <input type="text" class="form-control" name="apellido" value="<?php echo $usuario['apellido']?>" readonly>

      <label for="dni">DNI</label>
      <input type="text" class="form-control" name="dni" value="<?php echo $usuario['dni']?>" readonly>

      <label for="email">Email</label>
      <input type="text" class="form-control" name="email" value="<?php echo $usuario['email']?>" readonly>

      <label for="fecha_inicio">Empleado desde...</label>
      <input type="text" class="form-control" name="fecha_inicio" value="<?php echo $usuario['fecha_inicio']?>" readonly>

      <?php if ( $usuario['fecha_fin'] ):?>
        <label for="fecha_fin">Empleado hasta...</label>
        <input type="text" class="form-control" name="fecha_fin" value="<?php echo $usuario['fecha_fin']?>" readonly>
      <?php endif;?>

  </div>
</div>
