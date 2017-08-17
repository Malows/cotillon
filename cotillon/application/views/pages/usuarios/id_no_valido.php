<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Cuidado!</strong> <?php echo $mensaje; ?>
</div>
<input class="form-control" type="text" placeholder="Filtro">
<div id="contenedor">
    <?php foreach ($usuarios as $user) {
      $innerHTML = $user['nombre']." ".$user['apellido']." DNI: ".$user['dni'];
      $title = "Ver usuario ".$user['nombre']." ".$user['apellido'];
      echo "<div>" . anchor( base_url( "usuarios/".$accion."/".$user['id_usuario'] ), $innerHTML, $title) . "</div>";
    } ?>

</div>
<?php $replacement = '/cotillon/index.php'; ?>
<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/finder.js'));?>"></script>
