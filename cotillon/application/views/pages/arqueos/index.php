<?php defined('BASEPATH') || exit('No direct script access allowed');
$ultimaPagina = intval($cantidadTotalDeArqueos / 100 + 1);
$rango = range(1, $ultimaPagina);

$items = array_map( function ($x) use ($paginaActual) {
	$clases = ($paginaActual === $x) ? ' class="active"' : '';
	return "<li$clases><a href=\"" . base_url("/arqueos/?pagina=$x") ."\">$x</a></li>\n";
}, $rango);

$previo = '';
$siguiente = '';
if ($paginaActual === 1) $previo = '<li class="disabled"><a href="#" aria-label="Previo"><span aria-hidden="true">&laquo;</span></a></li>';
else $previo = '<li><a href="'. base_url("/arqueos/?pagina=" . ($paginaActual + 1)) .'" aria-label="Previo"><span aria-hidden="true">&laquo;</span></a></li>';
if ($paginaActual === $ultimaPagina) $siguiente = '<li class="disabled"><a href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
else $siguiente = '<li><a href="'. base_url("/arqueos/?pagina=" . ($paginaActual - 1)) .'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
?>
<h2>Arqueos</h2>
<div class="row">
	<div class="pull-left">
		<nav aria-label="Page navigation">
			<ul class="pagination">
				<?= $previo; ?>
				<?php foreach ($items as $item) echo $item; ?>
				<?= $siguiente; ?>
			</ul>
		</nav>
	</div>
	<div class="pull-right">
		<button class="btn btn-primary" title="Abrir caja"  data-toggle="modal" data-target="#modal-abrir-caja"><i class="fa fa-plus"></i></button>
		<button class="btn btn-primary" title="Cerrar caja"  data-toggle="modal" data-target="#modal-cerrar-caja"><i class="fa fa-usd"></i></button>
	</div>
</div>
<hr>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Fecha apertura</th>
      <th>Fecha cierre</th>
      <th>Monto inicial</th>
      <th>Monto estimado</th>
      <th>Monto final</th>
      <th>Fluctuación</th>
			<th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($arqueos as $caja): ?>
      <tr>
	<td><?=$caja['fecha_apertura']?></td>
	<td><?= $caja['fecha_cierre'] ? $caja['fecha_cierre'] : ''?></td>
	<td><?= $caja['monto_apertura'] !== null ? '$'.$caja['monto_apertura'] : ''?></td>
	<td><?= $caja['monto_estimado_cierre'] ? '$'.$caja['monto_estimado_cierre'] : ''?></td>
	<td><?= $caja['monto_real_cierre'] ? '$'.$caja['monto_real_cierre'] : ''?></td>
	<td><strong><?php
if ($caja['monto_estimado_cierre'] != null && $caja['monto_real_cierre'] != null) {
	$color = '';
	$icono = '';
	$movimiento = $caja['monto_real_cierre'] - $caja['monto_estimado_cierre'];
	if ($movimiento > 0) { $color = 'text-success'; $icono = 'fa fa-caret-up'; }
	if ($movimiento < 0) { $color = 'text-danger'; $icono = 'fa fa-caret-down'; }
	if ($movimiento == 0) { $color = 'text-muted'; $icono = 'fa fa-minus'; }
	echo "<span class='$color'><i class='$icono'></i> $movimiento</span>";
}?></strong></td>
				<td><a href="<?= base_url('arqueos/ver/'.$caja['id_caja'])?>" class="btn btn-primary">
					<i class="fa fa-eye"></i>
				</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="modal fade" id="modal-abrir-caja" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
	<h3>Monto de apertura</h3>
      </div>
      <div class="modal-body">
	<input type="text" class="form-control">
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
	<button class="btn btn-primary" id="modal-abrir-si">Sí</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-cerrar-caja" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
	<h3>Monto de cierre</h3>
      </div>
      <div class="modal-body">
	<input type="text" class="form-control">
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
	<button class="btn btn-primary" id="modal-cerrar-si">Sí</button>
      </div>
    </div>
  </div>
</div>
