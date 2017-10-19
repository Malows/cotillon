<?php defined('BASEPATH') || exit('No direct script access allowed');
$ultima_pagina = ( intval($cantidad/100)+1);
$rango =  range(1, $ultima_pagina); 

$items = array_map( function ($x) use ($pagina_actual) {
	$clases =  ($pagina_actual === $x) ? ' class="active"' : '';
	return "<li$clases><a href=\"".base_url("/registros/?pagina=$x"). "\">$x</a></li>\n";
}, $rango);

$previo = '';
$siguiente = '';
if ($pagina_actual === 1) $previo = '<li class="disabled"><a href="#" aria-label="Previo"><span aria-hidden="true">&laquo;</span></a></li>';
else $previo =  '<li><a href="'. base_url("/registros/?pagina=". ($pagina_actual - 1)) .'" aria-label="Previo"><span aria-hidden="true">&laquo;</span></a></li>';

if ($pagina_actual === $ultima_pagina) $siguiente = '<li class="disabled"><a href="#" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
else $siguiente =  '<li><a href="'. base_url("/registros/?pagina=". ($pagina_actual + 1)) .'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
?>

<nav aria-label="Page navigation">
	<ul class="pagination">
<?php
echo $previo;
foreach ($items as $item) echo $item;
echo $siguiente;
?>
	</ul>
</nav>
<ul>
<?php foreach ($oraciones as $oracion) echo "<li>$oracion</li>\n"; ?>
</ul>
