<head>
		<meta charset="utf-8">
				<link rel="stylesheet" href="http://localhost:8080/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/datatables.min.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/jquery-ui.min.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/select2.min.css">
		<link rel="stylesheet" href="http://localhost:8080/assets/css/style.css">
	</head>
  <div class="cabecera-factura" style="font-size: 1.25em;">
    <h3 style="grid-area: fecha;"><br><br><br><br>

			<?php echo "Creado el: ".$consulta[0]['fecha_creation']; ?> - <?php  if($consulta[0]['fecha_reception'] != NULL){
			echo "Recibido el: ".$consulta[0]['fecha_reception'];
		} else {
			echo "Recepción pendiente";
		} ?></h3>

    <p style="grid-area: nombre;">Proveedor: <strong><?php echo $consulta[0]['nombre_proveedor'] ?></strong></p>
    <p style="grid-area: tipo-cliente;">Nro de Pedido: <strong><?php echo $consulta[0]['id_pedido'] ?></strong></p>
  </div>
  <div class="venta">
    <div class="titulo-venta alineador-venta">
      <p>Producto</p>
      <p>Cantidad</p>
      <p>Precio Unitario</p>
   </div>
				<?php foreach( $consulta as $consultas): ?>
	        <div class="alineador-venta">
	         <p> <?= $consultas['nombre']; ?></p>
	         <p> <?= $consultas['cantidad']?></p>
					 <p> <?= $consultas['precio_unitario']?></p>
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
  </div>
</div>
