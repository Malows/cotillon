<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
  <h3 class="text-center"><?php echo $cliente['nombre_cliente']; ?></h3>
  <hr>
  <h4>Datos del cliente</h4>
  <p>Localidad: <strong><?php echo $cliente['nombre_localidad']; ?></strong></p>
  <p>Barrio: <strong><?php echo $cliente['barrio']; ?></strong></p>
  <p>Dirección: <strong><?php echo $cliente['direccion']; ?></strong></p>
  <p>Correo Electrónico: <strong><?php echo $cliente['email']; ?></strong></p>
  <p>Teléfono: <strong><?php echo $cliente['telefono'] ?></strong></p>
  <p>Tipo de cliente: <strong><?php echo $cliente['tipo_cliente']; ?></strong></p>
</div>
