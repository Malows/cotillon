<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="contenedor-de-alertas">
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Placeholder!</strong> futuramente contendrá información.
    </div>
  <?php if ( count($alertas) ): ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Alerta de poco stock!</strong> Revise el stock de los siguientes productos.
      <hr>
      <ul class="stock-lista">
        <?php foreach ($alertas as $producto) {
          echo "<li>$producto->nombre</li>\n";
        } ?>
      </ul>
    </div>
  <?php endif; ?>
</div>
