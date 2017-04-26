<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Clientes</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/clientes/crear');?>" class="btn btn-primary pull-right" title="Agregar un nuevo proveedor"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Nombre de cliente</th>
    <th>Localidad</th>
    <th>Contacto</th>
    <th>Tipo de cliente</th>
    <th>Opciones</th>
  </thead>
  <tbody>
    <?php foreach ($clientes as $c):?>
    <tr>
      <td><?php echo $c['id_cliente'];?></td>
      <td><?php echo $c['nombre_cliente'];?></td>
      <td><?php echo $c['nombre_localidad'];?></td>
      <td><?php echo $c['contacto'];?></td>
      <td><?php echo $c['tipo_cliente'];?></td>
      <td>
        <div class="btn-group">
          <a href="<?php echo base_url("clientes/ver/".$c['id_cliente']); ?>" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
          <a href="<?php echo base_url("clientes/actualizar/".$c['id_cliente']); ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <?php if( $es_admin_usuario_logueado ): ?>
            <a href="<?php echo base_url("clientes/eliminar/".$c['id_cliente']); ?>" class="btn btn-primary"><i class="fa fa-trash"></i></a>
          <?php endif; ?>
        </div>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
