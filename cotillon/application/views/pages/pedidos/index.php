<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>
<h2 class="text-center">PEDIDOS</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/pedidos/crear')?>" class="btn btn-primary pull-right" title="Agregar nuevo pedido"><i class="fa fa-plus"></i></a>
</div>
<br>
<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Proveedor</th>
    <th>Fecha</th>
    <th>Opciones</th>
  </thead>

  <tbody>
    <?php foreach ($pedidos as $ped):?>
    <tr>
      <td><?php echo $ped['id_pedidos']?></td>
      <td><?php echo $ped['nombre_proveedor'];?></td>
      <td><?php echo $ped['fecha_pedido'];?></td>
      <td>
        <div class="btn-group">
          <a href="<?php echo base_url("pedidos/actualizar/".$ped['id_pedidos']); ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <?php if($es_admin_usuario_logueado): ?>
            <button type="button"  data-toggle="modal" data-target="#modal-eliminar-<?php echo $ped['id_pedidos']; ?>" class="btn btn-primary"><i class="fa fa-trash"></i></button>
          <?php endif; ?>
        </div>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  </table>
  <?php foreach( $pedidos as $ped):?>
    <div class="modal fade" id="modal-eliminar-<?php echo $ped['id_pedidos']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Confirmación</h3>
          </div>
          <div class="modal-body">
            ¿Desea eliminar este pedido?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
            <a href="<?php echo base_url("pedidos/eliminar/".$ped['id_pedidos']); ?>" class="btn btn-danger">Sí</a>
          </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>
