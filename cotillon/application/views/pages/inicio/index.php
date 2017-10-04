<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="contenedor-de-alertas">
  <?php
  $alert;
  if (count($caja)) {

    $hoy = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
    $fechaDeCaja = DateTime::createFromFormat('Y-m-d H:i:s', $caja[0]['fecha_apertura']);

    $intervalo = $hoy->diff($fechaDeCaja);
    $minutos = $intervalo->i +  ($intervalo->h * 60) + ($intervalo->days * 24 * 60);
    if ($minuto > 900) {
      $alert['estado'] = 'danger';
      $alert['mensaje'] = '<strong>Una caja de fecha anterior se encuentra aún abierta. Por favor cierrela antes de iniciar las actividades comerciales</strong>';
      $alert['mensaje'] .= '<hr>' . anchor( base_url('arqueos/'), "Cerrar caja");
    } else {
      $alert['estado'] = 'success';
      $alert['mensaje'] = "La caja se encuentra abierta con fecha de $fechaDeCaja->format('d/m/Y') y un monto de $" . $caja[0]['monto_apertura'];
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
</div>
<?php $replacement = '/cotillon/index.php'; ?>
<script src="<?php echo str_replace($replacement, '', base_url('assets/js/Chart.min.js'));?>"></script>
<script src="<?php echo str_replace($replacement, '', base_url('assets/js/moment.min.js'));?>"></script>
<script src="<?php echo str_replace($replacement, '', base_url('assets/js/moment.es.js'));?>"></script>
<!-- <script>
  document.querySelectorAll('canvas').forEach(canvas => {
    let padre = canvas.parentNode;
    canvas.width = padre.offsetWidth;
  })
</script> -->
<script>
let labels_1 = <?= json_encode( array_map( function($elem){return $elem['fecha']->format('Y-m-d');}, $ventas ) );?>;
labels_1 = labels_1.map(fecha => {let aux = moment(fecha); return aux.format('MMMM')})
let data_1 = <?= json_encode( array_map( function($elem){return $elem['total'];}, $ventas ) );?>;
let backgroundColor = [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
];
let borderColor = [
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
];

var ctx1 = document.getElementById("canvas1");
var myChart1 = new Chart(ctx1, {
  type: 'bar',
  data: {
      labels: labels_1,
      datasets: [{
          label: '# of Votes',
          data: data_1,
          backgroundColor: backgroundColor,
          borderColor: borderColor,
          borderWidth: 1
      }]
  },
  options: {
    responsive: true,
  }
});
var ctx2 = document.getElementById("canvas2");
var myChart2 = new Chart(ctx2, {
  type: 'pie',
  data: {
      labels: labels_1,
      datasets: [{
          label: '# of Votes',
          data: data_1,
          backgroundColor: backgroundColor,
          borderColor: borderColor,
          borderWidth: 1
      }]
  },
  options: {
    responsive: true,
  }
});
var ctx3 = document.getElementById("canvas3");
var myChart3 = new Chart(ctx3, {
  type: 'line',
  data: {
      labels: labels_1,
      datasets: [{
          label: '# of Votes',
          data: data_1,
          backgroundColor: backgroundColor,
          borderColor: borderColor,
          borderWidth: 1
      }]
  },
  options: {
    responsive: true,
  }
});
</script>
