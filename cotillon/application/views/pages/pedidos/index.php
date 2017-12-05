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
    <th>Estado</th>
    <th>Precio acordado</th>
    <th>Precio de pago</th>
    <th>Fluctuación</th>
    <th>Opciones</th>
  </thead>
  <tbody>
    <?php foreach ($pedidos as $ped):?>
    <tr>
      <td><?= $ped['id_pedido']?></td>
      <td><?= $ped['nombre_proveedor'];?></td>
      <td><?= $ped['fecha_creacion'];?></td>
      <td><strong><?= $ped['fecha_recepcion'] === null ? 'Pendiente' : 'Recibido' ?></strong></td>
      <td>$<?= $ped['precio_total'] ?></td>
      <td><?= $ped['precio_real'] ? '$'.$ped['precio_real'] : '' ?></td>
      <?php
        $fluctuacion = $ped['precio_real'] !== null ? $ped['precio_real'] - $ped['precio_total'] : '';
        $direccion = '';
        $color = '';

        if ($fluctuacion !== '') {
          $color = 'text-danger';
          if ($fluctuacion > 0) $direccion = 'fa fa-caret-up fa-lg';
          if ($fluctuacion < 0) $direccion = 'fa fa-caret-down fa-lg';
          if ($fluctuacion == 0) {
            $direccion = 'fa fa-minus fa-lg';
            $color = 'text-muted';
          }
        }
      ?>
      <td><?= $ped['precio_real'] === null ? '' : "<p class=\"$color\"><i class=\"$direccion\"></i> $$fluctuacion</p>"?></td>
      <td>
        <button class="btn btn-primary" title="recibir pedido" data-toggle="modal" data-target="#modal-recibir-<?php echo $ped['id_pedido']; ?>" ><i class="fa fa-truck"></i></button>
        <div class="btn-group">
          <a class="btn btn-primary" href="<?php echo base_url("pedidos/ver/".$ped['id_pedido']); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
          
          <?php if($es_admin_usuario_logueado): ?>
            <button data-toggle="modal" data-target="#modal-eliminar-<?php echo $ped['id_pedido']; ?>" class="btn btn-primary">
              <i class="fa fa-trash"></i>
            </button>
          <?php endif; ?>
        </div>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  </table>
  <?php foreach( $pedidos as $ped):?>
    <div class="modal fade" id="modal-eliminar-<?php echo $ped['id_pedido']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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
            <a href="<?php echo base_url("pedidos/eliminar/".$ped['id_pedido']); ?>" class="btn btn-danger">Sí</a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-recibir-<?php echo $ped['id_pedido']; ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <?= form_open(base_url('/pedidos/recibir/'. $ped['id_pedido'])) ?>
          <div class="modal-header">
            <h3>Confirmación de recepción</h3>
          </div>
          <div class="modal-body">
              <label>Monto inicialmente acordado</label>
              <input type="number" class="form-control" name="precio_total" value="<?= $ped['precio_total'] ?>" disabled>
              <label>Monto de pago a proveedor</label>
              <input type="number" class="form-control" name="precio_real" value="" placeholder="Ingrese el monto de pago">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
            <button type="submit" class="btn btn-primary">Sí</a>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
<?php endforeach; ?>
