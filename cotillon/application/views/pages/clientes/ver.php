<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
  <h3 class="text-center"><?php echo $cliente['nombre_cliente']; ?></h3>
  <hr>
  <h4>Datos del cliente</h4>
  <p>Localidad: <strong><?php echo $cliente['nombre_localidad']; ?></strong></p>
  <p>Tipo de cliente: <strong><?php echo $cliente['tipo_cliente']; ?></strong></p>
  <p>Contacto: <strong><?php echo $cliente['contacto'] ?></strong></p>
  <hr>
  <h4>Operaciones realizadas</h4>
  <ul>
    <?php foreach ($ops as $value) {
      echo "<li><a href='#'>$value - es una fecha<i class='fa fa-calendar'></i></a></li>\n";
    } ?>
  </ul>
</div>
