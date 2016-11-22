<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
    echo '
    <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Genial!</h4>
			Se a creado exitosamente el usuario de <strong>'.$usuario.'</strong> con permisos de tipo <strong>'.$permisos.'</strong>.
		</div>';
  }
  echo form_open("/usuarios/crear")?>
    <div class="form-group">

        <label for="nombre">Nombre<?php echo form_error("nombre");?></label>
        <input type="text" class="form-control" name="nombre" value="">

        <label for="apellido">Apellido<?php echo form_error("apellido");?></label>
        <input type="text" class="form-control" name="apellido" value="">

        <label for="email">Email<?php echo form_error("email");?></label>
        <input type="text" class="form-control" name="email" value="">

        <label for="dni">DNI<?php echo form_error("dni");?></label>
        <input type="text" class="form-control" name="dni" value="">

        <div class="form-group">
          <label for="password">Contraseña<?php echo form_error("password");?></label>
          <div class="input-group">
              <input type="password" id="password-form" class="form-control" name="password" value="">
              <div id="show-me" class="input-group-addon"><i class="fa fa-lg fa-eye"></i></div>
          </div>
        </div>

        <div class="form-group">
          <label for="re-password">Confirmación de Contraseña<?php echo form_error("re-password");?></label>
          <div class="input-group">
              <input type="password" id="password-form" class="form-control" name="re-password" value="">
              <div id="show-me" class="input-group-addon"><i class="fa fa-lg fa-eye"></i></div>
          </div>
        </div>


        <div class="radio">
          <label>
            <input type="radio" name="es_admin" id="optionsRadios1" value="0" checked>
            No Administrador
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="es_admin" id="optionsRadios2" value="1">
            Administrador
          </label>
        </div>

        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close(); ?>
</div>
<script src='http://localhost:8080/assets/js/password-show.js'></script>
