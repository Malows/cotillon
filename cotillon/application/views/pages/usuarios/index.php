<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2 class="text-center">Usuarios</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/usuarios/crear');?>" class="btn btn-primary pull-right" title="Agregar un nuevo usuario"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-striped">
  <thead>
    <th>ID</th>
    <th>Nombre</th>
    <th>DNI</th>
    <th>Email</th>
    <th>Administador</th>
    <?php if( $es_admin_usuario_logueado ): ?><th>Opciones</th><?php endif; ?>
  </thead>
  <tbody>
    <?php foreach ($usuarios as $user):?>
    <tr>
      <td><?php echo $user['id_usuario'];?></td>
      <td><?php echo $user['nombre']." ".$user['apellido'];?></td>
      <td><?php echo $user['dni'];?></td>
      <td><?php echo $user['email'];?></td>
      <td><i class="fa <?php echo ( $user['id_tipo_usuario'] < 3 ) ? "fa-check" : "fa-times";?>" aria-hidden="true"></i></td>
      <?php if( $es_admin_usuario_logueado ): ?>
      <td>
        <div class="btn-group">
          <a class="btn btn-primary" href="<?php echo base_url("usuarios/ver/".$user['id_usuario']); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
          <a class="btn btn-primary" href="<?php echo base_url("usuarios/actualizar/".$user['id_usuario']); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <a class="btn btn-primary" href="<?php echo base_url("usuarios/eliminar/".$user['id_usuario']); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </div>
      </td>
    <?php endif; ?>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
