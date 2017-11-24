<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Ventas</h2>
<hr>

<div class="row">
  <a href="<?php echo base_url('/ventas/crear');?>" class="btn btn-primary pull-right" title="Agregar una nueva venta"><i class="fa fa-plus"></i></a>
</div>

<div class="row" style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
  <div class="btn-group pull-right">
    <a href="<?= base_url('/ventas/index/ultima_semana');?>" class="btn btn-primary">Útlima semana</a>
    <a href="<?= base_url('/ventas/index/hoy');?>" class="btn btn-primary">Hoy</a>
  </div>

  <div class="form-inline pull-left">
    Desde <input type="text" class="form-control" id="datepicker-desde" style="width: 10rem;">
    Hasta <input type="text" class="form-control" id="datepicker-hasta" style="width: 10rem;">
    <button id="enviar-filtro" class="btn btn-primary">Filtrar</button>
  </div>
</div>

<div class="row">
  <table class="table table-striped">
    <thead>
      <th>#</th>
      <th>Fecha</th>
      <th>Cliente</th>
      <th class="text-center">Monto</th>
      <th class="text-center">Ver detalle</th>
    </thead>
    <tbody>
      <?php foreach ($ventas as $venta):?>
        <tr>
          <td><?php echo $venta['id_venta'];?></td>
          <td><p><strong><?php $fecha = new DateTime($venta['fecha']); echo $fecha->format('d/m/Y')?></strong> - <small><?php echo $fecha->format('H:i'); ?></small></p></td>
          <td><?php echo $venta['nombre_cliente'];?></td>
          <td class="text-center">$<?php echo $venta['total'];?></td>
          <td class="text-center">
            <a class="btn btn-primary" href="<?php echo base_url("ventas/ver/".$venta['id_venta']); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
          </td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<script>
  $('#datepicker-desde').datepicker();
  $('#datepicker-hasta').datepicker();
</script>
<script>
  const button = document.getElementById('enviar-filtro')
  button.addEventListener('click', (e) => {
    let fechaDesde = $('#datepicker-desde').datepicker('getDate')
    let fechaHasta = $('#datepicker-hasta').datepicker('getDate')
    fechaDesde = fechaDesde ? fechaDesde.toISOString() : '_'
    fechaHasta = fechaHasta ? fechaHasta.toISOString() : '_'

    if (fechaHasta === '_' && fechaDesde === '_')
      window.location.assign("<?= base_url('/ventas/index/ultima_semana'); ?>")
    else
      window.location.assign("<?= base_url('/ventas/index/'); ?>" + fechaDesde.substring(0,fechaDesde.indexOf('T'))  + '/' + fechaHasta.substring(0,fechaDesde.indexOf('T')))
  })
</script>
