<div class="row" style="margin-top: 2rem;">
	<a href="<?php echo base_url('/pedidos/pdf/' . $this->uri->segments[3]);?>" class="btn btn-primary pull-right" title="Crear factura" target="_blank">
		<i class="fa fa-download"></i>
	</a>
</div>
<div class="cabecera-factura" style="font-size: 1.25em;">
	<h3 style="grid-area: fecha;">
		Creado el: <?= $consulta[0]['fecha_creation']; ?> - <?php if($consulta[0]['fecha_reception'] != NULL) {
			echo "Recibido el: ".$consulta[0]['fecha_reception'];
		} else {
			echo "Recepción pendiente";
		}?>
	</h3>

	<p style="grid-area: nombre;">Proveedor: <strong><?= $consulta[0]['nombre_proveedor'] ?></strong></p>
	<p style="grid-area: tipo-cliente;">Nro de Pedido: <strong><?= $consulta[0]['id_pedido'] ?></strong></p>
</div>
<div class="venta">
	<div class="titulo-venta alineador-venta">
		<p>Producto</p>
		<p>Cantidad</p>
		<p>Precio Unitario</p>
	</div>
	<?php foreach( $consulta as $consultas): ?>
		<div class="alineador-venta">
			<p><?= $consultas['nombre']; ?></p>
			<p><?= $consultas['cantidad']?></p>
			<p><?= $consultas['precio_unitario']?></p>
		</div>

	<?php endforeach; ?>
	<?php
	$tamaño = count($consulta);
	for ($i = $tamaño; $i < 6; $i++) {
		echo "<div class='alineador-venta'></div>\n";
	}
	?>
</div>
<div class="resumen-venta alineador-venta">
	<p>Total acordado</p>
	<p></p>
	<p><?php echo $consulta[0]['precio_total'] ?></p>
</div>
