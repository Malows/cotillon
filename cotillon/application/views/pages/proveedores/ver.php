<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>
<h2 class="text-center">Proveedor</h2>
<hr>
<h3 class="text-center"><?php echo $proveedor['nombre_proveedor'];?></h3>
<div class="row text-center">
  <div class="col-md-6">
    <p><strong>Localidad: </strong><?php echo $proveedor['nombre_localidad'] .' - '. $proveedor['barrio'];?></p>
  </div>
  <div class="col-md-6">
    <p><strong>Contacto: </strong><?php echo $proveedor['contacto']; ?></p>
  </div>
</div>
<hr>
<ul class="grid-2-col">
  <?php foreach ($productos as $producto): ?>
    <li><strong><?= $producto['nombre']?></strong> $<?=$producto['precio'] .'x'. $producto['unidad'];?></li>
  <?php endforeach; ?>
</ul>
