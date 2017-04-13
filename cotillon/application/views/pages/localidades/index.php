<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Localidades</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/localidades/crear');?>" class="btn btn-primary pull-right" title="Agregar una nueva localidad"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Nombre de localidad</th>
    <th>Opciones</th>
  </thead>
  <tbody>
    <?php foreach ($localidades as $loc):?>
    <tr>
      <td><?php echo $loc['id_localidad'];?></td>
      <td><?php echo $loc['nombre_localidad'];?></td>
      <td>
        <a href="<?php echo base_url("localidades/ver_clientes/".$loc['id_localidad']); ?>" class="btn btn-primary" title="Ver los clientes correspondientes a esta localidad">Clientes <i class="fa fa-address-book" aria-hidden="true"></i></a>
        <a href="<?php echo base_url("localidades/ver_proveedores/".$loc['id_localidad']); ?>" class="btn btn-primary" title="Ver los proveedores correspondientes a esta localidad"> Proveedores <i class="fa fa-id-card" aria-hidden="true"></i></a>
        <?php if( $es_admin_usuario_logueado ): ?>
        <a href="<?php echo base_url("localidades/actualizar/".$loc['id_localidad']); ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
