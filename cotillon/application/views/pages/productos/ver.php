<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php var_dump($producto); ?>
<h2 class="text-center">Productos</h2>
<hr>
<h3 class="text-center"><?php echo $producto['nombre'];?></h3>
<div class="row">
  <div class="col-md-2 col-md-offset-4">
    <p><strong>Precio: </strong>$<?php echo $producto['precio'];?></p>
    <p><strong>Categoría: </strong><?php echo $producto['nombre_categoria'];?></p>
  </div>
  <div class="col-md-2">
    <p><strong>Unidad: </strong><?php echo $producto['unidad'];?></p>
    <p><strong>Stock: </strong><?php echo $producto['cantidad'];?></p>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-6">
    <p><strong>Proveedor: </strong><?php echo $producto['nombre_proveedor']; ?></p>
    <p><strong>Contacto: </strong><?php echo $producto['contacto']; ?></p>
  </div>
  <div class="col-md-6">
    <p><strong>Descripción del producto: </strong><?php echo $producto['descripcion'] ?></p>
  </div>
</div>
