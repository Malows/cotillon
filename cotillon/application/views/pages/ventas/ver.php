<?php defined('BASEPATH') || exit('No direct script access allowed');
$fecha = new DateTime( $venta['fecha'], new DateTimeZone('America/Argentina/Buenos_Aires') );
?>
<div class="container">
  <div class="row" style="margin-top: 2rem;">
    <a href="<?php echo base_url('/ventas/pdf/' . $this->uri->segments[3]);?>" class="btn btn-primary pull-right" title="Crear factura" target="_blank">
      <i class="fa fa-download"></i>
    </a>
  </div>

  <div class="cabecera-factura" style="font-size: 1.25em;">
    <h3 style="grid-area: fecha;"><?= $fecha->format('d/m/Y')?></h3>
    <p style="grid-area: nombre;">cliente: <strong><?= $venta['nombre_cliente']?></strong></p>
    <p style="grid-area: tipo-cliente;">Tipo de cliente: <strong><?= $venta['tipo_cliente']?></strong></p>
  </div>
  <div class="venta">
    <div class="titulo-venta alineador-venta">
      <p>Producto</p>
      <p>Cantidad</p>
      <p>Total</p>
    </div>
    <div class="detalle-venta">
      <?php foreach( $detalles as $detalle): ?>
        <div class="alineador-venta">
          <p><?= $detalle['nombre']; ?></p>
          <p><?= $detalle['cantidad_venta']?></p>
          <p>$<?= $detalle['cantidad_venta'] * $detalle['precio_unitario']; ?></p>
        </div>
      <?php endforeach; ?>
      <?php
      $tamaño = count($detalles);
      for ($i = $tamaño; $i < 13; $i++) {
        echo "<div class='alineador-venta'></div>\n";
      }
      ?>
    </div>
    <div class="resumen-venta alineador-venta">
      <p>Total</p>
      <p></p> <!-- spacer -->
      <p>$<?php echo array_reduce($detalles, function($carry, $elem) {return $carry + ($elem['precio_unitario'] * $elem['cantidad_venta']);}, 0);?></p>
    </div>
  </div>
</div>
