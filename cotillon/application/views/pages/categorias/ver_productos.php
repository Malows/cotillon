<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Productos pertenecientes a '<?php echo $categoria['nombre_categoria']; ?>'</h2>
<hr>
<table class="table table-striped">
  <thead>
    <th>Producto</th>
  </thead>
  <tbody>
    <?php foreach ($productos as $prod):?>
    <tr>
      <td><a href="<?php echo base_url('productos/ver/'.$prod['id_producto'] );?>"><?php echo $prod['nombre_producto'];?></a></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
