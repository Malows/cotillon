<?php defined('BASEPATH') || exit('No direct script access allowed');
$ultima_pagina = ( intval($cantidad/100)+1);
$rango =  range(1, $ultima_pagina);

$items = array_map(function ($x) use ($pagina_actual) {
	$clases =  ($pagina_actual === $x) ? ' class="active"' : '';
	return "<li$clases><a href=\"".base_url("/registros/?pagina=$x"). "\">$x</a></li>\n";
}, $rango);

$previo = '';
$siguiente = '';
if ($pagina_actual === 1) $previo = '<li class="disabled"><a href="#" aria-label="Previo"><span aria-hidden="true">&laquo;</span></a></li>';
else $previo =  '<li><a href="'. base_url("/registros/?pagina=". ($pagina_actual - 1)) .'" aria-label="Previo"><span aria-hidden="true">&laquo;</span></a></li>';

if ($pagina_actual === $ultima_pagina) $siguiente = '<li class="disabled"><a href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
else $siguiente =  '<li><a href="'. base_url("/registros/?pagina=". ($pagina_actual + 1)) .'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
?>

<div class="row">
	<div class="col-md-6 pull-right">
		<nav aria-label="Page navigation" class="pull-right">
			<ul class="pagination">
				<?php
				echo $previo;
				foreach ($items as $item) echo $item;
				echo $siguiente;
				?>
			</ul>
		</nav>
	</div>
	<div class="col-md-6 pull-left">
		<select class="select2" id="select-usuarios">
			<option value="0">Sin filtro</option>
			<option value="1">Usuario 1</option>
			<option value="2">Usuario 2</option>
			<option value="3">Usuario 3</option>
			<option value="4">Usuario 4</option>
			<option value="5">Usuario 5</option>
		</select>
	</div>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Evento</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($oraciones as $oracion): ?>
			<tr>
			<?php $separado = explode(' - ', $oracion); ?>
			<td><?php echo $separado[0]; ?></td>
			<td><?php echo $separado[1]; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<script>
	$('#select-usuarios').on('select2:select', function (e) {
		var currentUrl = '' + window.location
		console.log(currentUrl);

		if (currentUrl.includes('?')) currentUrl += '&usuario=' + e.params.data.id;
		else currentUrl += '/?usuario=' + e.params.data.id;
		window.location.assign(currentUrl)
	})
</script>
