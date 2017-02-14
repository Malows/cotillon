<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Proveedores radicados en <?php echo $localidad['nombre_localidad']; ?></h2>
<hr>
<ul>
  <?php foreach ($proveedores as $prov) {
    $url = base_url('proveedores/ver/'.$prov['id_proveedor']);
    $aux = $prov['nombre_proveedor'];

    echo "<li><a href=\"$url\">$aux</a></li>\n";
  } ?>
</ul>
