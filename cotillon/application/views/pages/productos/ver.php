<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
<hr>
<div class="row" style="margin-top: 10rem;">
  <div class="col-md-6">
    <table class="table">
      <caption><strong>Clientes más vendidos</strong></caption>
      <thead>
        <tr>
          <th>Nombre Cliente</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($consultac as $consul):?>
          <tr>
            <td><?php echo $consul['nombre_cliente']."        ";?></td>
            <td><?php echo intval($consul['cantidad_venta']);?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>

  <div class="col-md-6">
    <table class="table">
      <caption><strong>Proveedores más pedidos</strong></caption>
      <thead>
        <tr>
          <th>Nombre Proveedor</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($consultap as $consul):?>
          <tr>
            <td><?php echo $consul['nombre_proveedor']."        ";?></td>
            <td><?php echo intval($consul['cantidad']);?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
