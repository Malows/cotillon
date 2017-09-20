<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Proveedores</h2>
<hr>
<?php if($es_admin_usuario_logueado): ?>
<div class="row">
  <a href="<?php echo base_url('/proveedores/crear');?>" class="btn btn-primary pull-right" title="Agregar un nuevo proveedor"><i class="fa fa-plus"></i></a>
</div>
<?php endif; ?>
<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Nombre de proveedor</th>
    <th>Localidad</th>
    <th>Contacto</th>
    <th>Opciones</th>
  </thead>
  <tbody>
    <?php foreach ($proveedores as $prov):?>
    <tr>
      <td><?php echo $prov['id_proveedor'];?></td>
      <td><?php echo $prov['nombre_proveedor'];?></td>
      <td><?php echo $prov['nombre_localidad'];?></td>
      <td><?php echo $prov['contacto'];?></td>
      <td>
        <div class="btn-group">
          <a href="<?php echo base_url("proveedores/ver/".$prov['id_proveedor']); ?>" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
          <?php if( $es_admin_usuario_logueado ): ?>
          <a href="<?php echo base_url("proveedores/actualizar/".$prov['id_proveedor']); ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <button type="button" data-toggle="modal" data-target="#modal-eliminar-<?php echo $prov['id_proveedor']; ?>" class="btn btn-primary" ><i class="fa fa-trash" aria-hidden="true"></i></button>
          <?php endif; ?>
        </div>
      </td>

    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php foreach($proveedores as $proveedor): ?>
  <div class="modal fade" id="modal-eliminar-<?php echo $proveedor['id_proveedor']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Confirmación</h3>
        </div>
        <div class="modal-body">
          ¿Desea eliminar este proveedor `<?php echo $proveedor['nombre_proveedor']; ?>`?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
          <a href="<?php echo base_url("proveedores/eliminar/".$proveedor['id_proveedor']); ?>" class="btn btn-danger">Sí</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
