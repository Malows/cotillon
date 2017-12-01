<?php defined('BASEPATH') || exit('No direct script access allowed');?>
<h4>Detalle de arqueo <small>correspondiente al día <?= substr($caja['fecha_apertura'], 0, 10); ?></small></h4>
<table class="table">
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Descripción</th>
      <th>Monto</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($detalles as $elem): ?>
    <tr>
      <td><?= $elem['fecha']?></td>
      <td><?= $elem['descripcion']?></td>
      <td>$ <?= $elem['monto']?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td><strong>Apertura <?= $caja['monto_apertura'] ?></strong></td>
      <td><strong>Estimado <?= $caja['monto_estimado_cierre'] ?></strong></td>
      <td><strong>Real <?= $caja['monto_real_cierre'] ?></strong></td>
    </tr>
  </tfoot>
</table>
