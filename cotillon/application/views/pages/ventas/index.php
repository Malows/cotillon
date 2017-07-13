<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Ventas</h2>
<hr>
<div class="row">
  <a href="<?php echo base_url('/ventas/crear');?>" class="btn btn-primary pull-right" title="Agregar una nueva venta"><i class="fa fa-plus"></i></a>
</div>
<div class="row">
  <nav aria-label="Page navigation" class="pull-left">
  <ul class="pagination">

  <?php if($paginaActual <= 1): ?>
    <li class="disabled">
      <span aria-hidden="true">&laquo;</span>
  <?php else: ?>
    <li>
      <a href="<?php echo base_url( '/ventas/?pagina=' . ($paginaActual - 1) ); ?>" aria-label="Previo">
        <span aria-hidden="true">&laquo;</span>
      </a>
    <?php endif; ?>
    </li>


    <?php for ($i=1; $i <= ( 1 + intval($cantidadTotalDeVentas / 100) ); $i++):?>
      <li<?php if($i === $paginaActual) echo ' class="active"'; ?>><a href="<?php echo base_url( "/ventas/?pagina=$i" ); ?>"><?php echo $i; ?></a></li>
    <?php endfor; ?>

    <?php if ($paginaActual == 0 || $paginaActual ==  (1 + intval($cantidadTotalDeVentas / 100))): ?>
    <li class="disabled">
      <span aria-hidden="true">&raquo;</span>
    <?php else: ?>
      <li>
        <a href="<?php echo base_url('/ventas/?pagina='.($paginaActual+1));?>" aria-label="Siguiente">
          <span aria-hidden="true">&raquo;</span>
        </a>
    <?php endif; ?>
    </li>
  </ul>
</nav>

<nav aria-label="Page navigation" class="pull-right">
  <ul class="pagination">
    <li<?php if($paginaActual === 0) echo ' class="active"'?>>
      <a href="<?php echo base_url('/ventas');?>" aria-label="Ultimas ventas">
        Ventas de la útlima semana
      </a>
    </li>
  </ul>
</nav>
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
