<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Productos</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/productos/crear');?>" class="btn btn-primary pull-right" title="Agregar un nuevo producto"><i class="fa fa-plus"></i></a>
</div>

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
        <div class="btn-group">
          <a href="<?php echo base_url("productos/ver/".$prod['id_producto']); ?>" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
          <?php if( $es_admin_usuario_logueado ): ?>
          <a href="<?php echo base_url("productos/actualizar/".$prod['id_producto']); ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <button type="button" data-toggle="modal" data-target="#modal-eliminar-<?php echo $prod['id_producto']; ?>" class="btn btn-primary"><i class="fa fa-trash" aria-hidden="true"></i></button>
          <?php endif; ?>
        </div>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>

<?php foreach( $productos as $producto):?>
  <div class="modal fade" id="modal-eliminar-<?php echo $producto['id_producto']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Confirmación</h3>
        </div>
        <div class="modal-body">
          ¿Desea eliminar este producto `<?php echo $producto['nombre']; ?>`?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
          <a href="<?php echo base_url("productos/eliminar/".$prod['id_producto']); ?>" class="btn btn-danger">Sí</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
