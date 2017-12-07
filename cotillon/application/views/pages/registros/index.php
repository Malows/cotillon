<?php defined('BASEPATH') || exit('No direct script access allowed');?>

<div class="row">
	<div class="form-inline pull-left" style="margin-top: 2rem;">
    Desde <input type="text" class="form-control" id="datepicker-desde" style="width: 10rem;">
    Hasta <input type="text" class="form-control" id="datepicker-hasta" style="width: 10rem;">
  </div>
	<div class="col-md-6 pull-left">
		<select class="select2" id="select-usuarios">
			<option value="0">Todos los usuarios</option>
			<?php foreach ($usuarios as $usuario) {
				$id = $usuario['id_usuario'];
				$nombre = $usuario['nombre'].' '.$usuario['apellido'];
				$selected = $usuarioSeleccionado == $id ? ' selected' : '';
				echo "<option value=\"$id\"$selected>$nombre</option>";
			} ?>
		</select>
		<button id="enviar-filtro" class="btn btn-primary">Filtrar</button>
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
	$('#datepicker-desde').datepicker();
	$('#datepicker-hasta').datepicker( $.datepicker.regional["es"] );

	const button = document.getElementById('enviar-filtro')
	button.addEventListener('click', (e) => {
		let fechaDesde = $('#datepicker-desde').datepicker('getDate')
		let fechaHasta = $('#datepicker-hasta').datepicker('getDate')
		fechaDesde = fechaDesde ? fechaDesde.toISOString() : '_'
		fechaHasta = fechaHasta ? fechaHasta.toISOString() : '_'
		let idRequested = $('#select-usuarios').val()

		let url = "<?= base_url('/registros/index'); ?>/"

		// console.log(idRequested)

		url += fechaDesde === '_' ? '_/' : fechaDesde.substring(0,fechaDesde.indexOf('T')) + '/'
		url += fechaHasta === '_' ? '_/' : fechaHasta.substring(0,fechaHasta.indexOf('T')) + '/'
		url += idRequested

			window.location.assign(url)
	})

	// $('#select-usuarios').on('select2:select', function (e) {
	// 	const idRequested = parseInt(e.params.data.id)
	// 	let currentUrl = '' + window.location
  //
	// 	const indexOf = currentUrl.indexOf('?')
  //
	// 	const antes = idRequested ? currentUrl.substring(0, indexOf) : indexOf === -1 ? currentUrl : currentUrl.substring(0, indexOf)
	// 	const despues = idRequested ? '?usuario=' + idRequested : ''
	// 	window.location.assign(antes + despues)
	// })
</script>
