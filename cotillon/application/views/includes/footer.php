<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		</div>
		<?php $replacement = '/cotillon/index.php'; ?>
		<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/datatables.min.js'));?>"></script>
		<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/bootstrap.min.js'));?>"></script>
		<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/select2.min.js'));?>"></script>
		<script>
			$.datepicker.regional['es'] = {
				closeText: 'Cerrar',
				prevText: '< Ant',
				nextText: 'Sig >',
				currentText: 'Hoy',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['es']);

		  $(document).ready(function() {
		    $('table').DataTable({
					"pageLength": 100,
					"dom": '<"top"f>t<"bottom"><"clear">',
				  "language": {
						"decimal":        ",",
				    "emptyTable":     "No hay datos para mostrar",
				    "info":           "Mostrando _START_ - _END_ de _TOTAL_ elementos",
				    "infoEmpty":      "Mostrando 0 - 0 de 0 elementos",
				    "infoFiltered":   "(Filtrado de _MAX_ elementos totales)",
				    "infoPostFix":    "",
				    "thousands":      ".",
				    "lengthMenu":     "Mostrar _MENU_ elementos",
				    "loadingRecords": "Cargando...",
				    "processing":     "Procesando...",
				    "search": "Buscar:",
						"zeroRecords":    "No hay coincidencias",
				    "paginate": {
				        "first":      "Primero",
				        "last":       "Último",
				        "next":       "Siguiente",
				        "previous":   "Anterior"
				    },
				    "aria": {
				        "sortAscending":  ": activar ordenamiento ascendiente",
				        "sortDescending": ": activar ordenamiento descendente"
				    }
				  }
				});

				$('.select2').select2({
					language: 'es'
				});
		  });
		</script>
	</body>
</html>
