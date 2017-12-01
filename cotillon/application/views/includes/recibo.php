<style>

  table {
    border-collapse:collapse;
  }

  tbody > tr  {
    border-bottom: 1px solid black;
  }

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
    border: solid 1mm black;
  }

  .nombre-producto {
    text-align: left;
    width: 70%;
    text-transform: uppercase;
    border: solid 0.25mm black;
  }

  .cantidad {
    text-align: left;
    width: 10%;
    text-transform: uppercase;
    border: solid 0.25mm black;
  }

  .precio {
    text-align: left;
    width: 10%;
    text-transform: uppercase;
    border: solid 0.25mm black;
  }

  .underline-total{
    border-bottom: 1px solid ;
    width: 90%;
    display: block;
  }

  .total-precio {
    text-align: center;
    width: 10%;
    text-transform: uppercase;
    border: solid 1mm black;
  }

  .bottom {
    border-bottom: 1px solid black;
  }
</style>
<div class="content">
  <p class="no-valido-factura">Presupuesto - No válido como factura</p>
  <table>
    <thead>
      <tr>
        <th class="nombre-producto">Producto</th>
        <th class="cantidad">Cantidad</th>
        <th class="precio">Precio Unitario</th>
        <th class="precio">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detalles as $detalle): ?>
        <tr>
          <td class="bottom nombre-producto" ><?= $detalle['nombre']?></td>
          <td class="bottom cantidad" ><?= $detalle['cantidad_venta']?></td>
          <td class="bottom precio" ><?= $detalle['precio_unitario']?> </td>
          <td class="bottom precio" >$ <?= $detalle['cantidad_venta'] * $detalle['precio_unitario']?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td class="underline-total">Total a pagar: </td>
        <td class="cantidad"> </td>
        <td class="precio"> </td>
        <td class="total-precio">$<?= array_reduce($detalles, function($carry, $elem) {return $carry + ($elem['precio_unitario'] * $elem['cantidad_venta']);}, 0) ?></td>
      </tr>
    </tfoot>
  </table>
</div>
