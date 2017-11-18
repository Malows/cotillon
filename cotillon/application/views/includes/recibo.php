<style>
  body {
    width: 210mm;
    height: 290mm;
    color: black;
    background-color: white;
    padding: 20mm;
  }
  .content {
    border: solid 1px black;
    width: 100%;
    height: 100%;
  }
  .no-valido-factura {
    text-align: center;
    width: 100%;
    text-transform: uppercase;
    border: solid 1mm black;
  }
</style>
<div class="content">
  <p class="no-valido-factura">No válido como factura</p>

  <table>
    <thead>
      <tr>
        <th>producto</th>
        <th>cantidad</th>
        <th>total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detalles as $detalle): ?>
      <tr>
        <td><?= $detalle['nombre']?></td>
        <td><?= $detalle['cantidad_venta']?></td>
        <td>$<?= $detalle['cantidad_venta'] * $detalle['precio_unitario']?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td>total</td>
        <td></td>
        <td>$<?= array_reduce($detalles, function($carry, $elem) {return $carry + ($elem['precio_unitario'] * $elem['cantidad_venta']);}, 0) ?></td>
      </tr>
    </tfoot>
  </table>
</div>
