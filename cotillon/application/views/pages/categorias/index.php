<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Categorías de productos</h2>
<hr>
<?php if ($es_admin_usuario_logueado): ?>
<div class="row">
  <a href="<?php echo base_url('/categorias/crear');?>" class="btn btn-primary pull-right" title="Agregar una nueva categoria"><i class="fa fa-plus"></i></a>
</div>
<?php endif; ?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Nombre de categoría</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($categorias as $cat):?>
    <tr>
      <td><?php echo $cat['id_categoria'];?></td>
      <td><?php echo $cat['nombre_categoria'];?></td>
      <td>
        <a href="<?php echo base_url("categorias/ver_productos/".$cat['id_categoria']); ?>" class="btn btn-primary" title="Ver los productos correspondientes a esta categoría">Productos <i class="fa fa-eye" aria-hidden="true"></i></a>
        <?php if( $es_admin_usuario_logueado ): ?>
          <div class="btn-group">
            <a href="<?php echo base_url("categorias/actualizar/".$cat['id_categoria']); ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            <button class="btn btn-primary"  data-toggle="modal" data-target="#modal-eliminar-<?php echo $cat['id_categoria']; ?>" ><i class="fa fa-trash"></i></button>
          </div>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php foreach ($categorias as $cat): ?>
<div class="modal fade" id="modal-eliminar-<?php echo $cat['id_categoria']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3>ATENCION!</h3>
      </div>
      <div class="modal-body">
        <strong>CONFIRMAR:</strong> Si borra la siguiente categoría, los productos relacionados desaparecerán del listado. <br>
          ¿Desea eliminar la categoría <?php echo $cat['nombre_categoria']; ?>?
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
        <a href="<?php echo base_url("categorias/eliminar/".$cat['id_categoria']); ?>" class="btn btn-danger">Sí</a>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
