<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Clientes radicados en <?php echo $localidad['nombre_localidad']; ?></h2>
<hr>
<ul>
  <?php foreach ($clientes as $cliente) {
    $url = base_url('clientes/ver/'.$cliente['id_cliente']);
    $ape_y_nom = $cliente['apellido'].", ".$cliente['nombre'];
    
    echo "<li><a href=\"$url\">$ape_y_nom</a></li>\n";
  } ?>
</ul>
