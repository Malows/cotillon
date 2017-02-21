<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Productos</h2>
<hr>
<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Nombre</th>
    <th>Proveedor</th>
    <th>Categoría</th>
    <th>Precio</th>
    <th>Descripción</th>
    <th>Opciones</th>
  </thead>
  <tbody>
    <?php foreach ($productos as $prod):?>
    <tr>
      <td><?php echo $prod['id_producto'];?></td>
      <td><?php echo $prod['nombre'];?></td>
      <td><?php echo $prod['nombre_proveedor'];?></td>
      <td><?php echo $prod['nombre_categoria'];?></td>
      <td>$<?php echo $prod['precio'];?></td>
      <td><?php echo $prod['descripcion'];?></td>
      <td>
        <a href="<?php echo base_url("productos/ver/".$prod['id_producto']); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
        <?php if( $es_admin_usuario_logueado ): ?>
        <a href="<?php echo base_url("productos/actualizar/".$prod['id_producto']); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
        <a href="<?php echo base_url("productos/eliminar/".$prod['id_producto']); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
