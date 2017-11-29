<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="contenedor-de-alertas">
  <?php
  $alert;
  if (count($caja)) {

    $hoy = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
    $fechaDeCaja = DateTime::createFromFormat('Y-m-d H:i:s', $caja[0]['fecha_apertura']);
    $parsedFecha = $fechaDeCaja->format('d/m/Y');
    $intervalo = $hoy->diff($fechaDeCaja);
    $minutos = $intervalo->i +  ($intervalo->h * 60) + ($intervalo->days * 24 * 60);
    if ($minutos > 900) {
      $alert['estado'] = 'danger';
      $alert['mensaje'] = '<strong>Una caja de fecha anterior se encuentra aún abierta. Por favor cierrela antes de iniciar las actividades comerciales</strong>';
      $alert['mensaje'] .= '<hr>' . anchor( base_url('arqueos/'), "Cerrar caja");
    } else {
      $alert['estado'] = 'success';
      $alert['mensaje'] = "La caja se encuentra abierta con fecha de $parsedFecha y un monto de $" . $caja[0]['monto_apertura'];
    }
  } else {
    $alert['estado'] = 'warning';
    $alert['mensaje'] = '<strong>No tiene la caja abierta. Por favor proceda a abrir la caja antes de empezar las actividades comerciales</strong>';
    $alert['mensaje'] .= '<hr>' . anchor( base_url('arqueos/'), "Abrir caja");
  }
  ?>

  <div class="alert alert-<?=$alert['estado']?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <?php echo $alert['mensaje'] ?>
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
<div class="row">
  <select class="form-control" id="periodo-de-tiempo">
    <option value="0">asdasdasdas</option>
    <option value="1">qweqweqwrwe</option>
    <option value="2">zxcvzxcvx</option>
  </select>
</div>
<div class="contenedor-de-graficos">
  <div>
    <canvas id="canvas1" width="300" height="300"></canvas>
  </div>
  <div>
    <canvas id="canvas2" width="300" height="300"></canvas>
  </div>
  <div>
    <canvas id="canvas3" width="300" height="300"></canvas>
  </div>
  <div>
    <canvas id="canvas4" width="300" height="300"></canvas>
  </div>
</div>
<?php $replacement = '/cotillon/index.php'; ?>
<script src="<?php echo str_replace($replacement, '', base_url('assets/js/Chart.min.js'));?>"></script>
<script src="<?php echo str_replace($replacement, '', base_url('assets/js/moment.min.js'));?>"></script>
<script src="<?php echo str_replace($replacement, '', base_url('assets/js/moment.es.js'));?>"></script>
<script>
const selectPeriodo = document.getElementById('periodo-de-tiempo');
const labels_1 = <?= json_encode( array_keys($ventas) );?>.map(fecha => moment(fecha).format('MMMM'));
const data_1 = <?= json_encode( array_values($ventas) );?>;
const labels_2 = <?= json_encode( array_keys($datos_ventas_categorias) ); ?>;
const data_2 = <?= json_encode( array_values($datos_ventas_categorias) ); ?>;
const labels_3 = <?= json_encode( array_keys($top_productos)); ?>;
const data_3 = <?= json_encode( array_values($top_productos)); ?>;
const labels_4 = <?= json_encode( array_keys($top_clientes)); ?>;
const data_4 = <?= json_encode( array_values($top_clientes)); ?>;
const backgroundColor = [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)',
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
];
const borderColor = [
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
];

let randomIndex = parseInt(Math.random() * (borderColor.length));
var ctx1 = document.getElementById("canvas1").getContext('2d');
var ctx2 = document.getElementById("canvas3").getContext('2d');
var ctx3 = document.getElementById("canvas2").getContext('2d');
var ctx4 = document.getElementById("canvas4").getContext('2d');

function parseDataGrafico (tipoGrafico, labels, data, datasetLabel, colorIndex = null) {
  return {
      labels: labels,
      datasets: [{
          label: datasetLabel, data: data, borderWidth: 1,
          backgroundColor: typeof colorIndex === 'number' ? backgroundColor[colorIndex] : backgroundColor,
          borderColor: typeof colorIndex === 'number' ? borderColor[colorIndex] : borderColor
      }]
    }
}

function renderGrafico (ctx, tipoGrafico, labels, data, datasetLabel, colorIndex = null) {
  return new Chart(ctx, {
    type: tipoGrafico,
    data: parseDataGrafico(tipoGrafico, labels, data, datasetLabel, colorIndex),
    options: { responsive: true }
  })
}
var myChart1 = renderGrafico(ctx1, 'bar', labels_3, data_3, 'Productos más vendidos')
var myChart2 = renderGrafico(ctx2, 'pie', labels_2, data_2, '# de ventas')
var myChart3 = renderGrafico(ctx3, 'line', labels_1.slice(labels_1.length - 13), data_1.slice(data_1.length - 13), 'Ventas por mes', randomIndex)
var myChart4 = renderGrafico(ctx4, 'horizontalBar', labels_4, data_4, 'Top clientes')

selectPeriodo.addEventListener('change', e => {
  randomIndex = parseInt(Math.random() * (borderColor.length));
  const newLabels1 = labels_1.slice(selectPeriodo.value, selectPeriodo.value + 12)
  const newData1 = data_1.slice(selectPeriodo.value, selectPeriodo.value + 12)
  myChart3 = renderGrafico(ctx3, 'line', newLabels1, newData1, 'Ventas por mes', randomIndex)
  myChart3.update()
})
</script>
