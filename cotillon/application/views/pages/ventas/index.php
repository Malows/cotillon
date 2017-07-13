<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Ventas</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/ventas/crear');?>" class="btn btn-primary pull-right" title="Agregar una nueva venta"><i class="fa fa-plus"></i></a>
</div>
<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Fecha</th>
    <th>Cliente</th>
    <th class="text-center">Cantidad</th>
    <th class="text-center">Ver detalle</th>
  </thead>
  <tbody>
    <?php foreach ($ventas as $venta):?>
    <tr>
      <td><?php echo $venta['id_venta'];?></td>
      <td><p><strong><?php $fecha = new DateTime($venta['fecha']); echo $fecha->format('d/m/Y')?></strong> - <small><?php echo $fecha->format('H:i'); ?></small></p></td>
      <td><?php echo $venta['nombre_cliente'];?></td>
      <td class="text-center">$<?php echo $venta['total'];?></td>
      <td class="text-center">
          <a class="btn btn-primary" href="<?php echo base_url("ventas/ver/".$venta['id_venta']); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
