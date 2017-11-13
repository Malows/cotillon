<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <?php $replacement = '/cotillon/index.php'; ?>
  <link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('assets/css/bootstrap.min.css'));?>">
  <link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('assets/css/font-awesome.min.css'));?>">
  <link rel="stylesheet" href="<?php echo str_replace($replacement, '', base_url('assets/css/style.css'));?>">
  <title>Cotillon FTW</title>
</head>
<body>
  <div class="container-fluid">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12" style="margin-top: 50px">
      <div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
        <?php echo form_open("/instalar")?>
        <div class="form-group">
          <h2>Super usuario</h2>
          <!-- Super Usuario -->
          <label for="nombre">Nombre<?php echo form_error("nombre");?></label>
          <input type="text" class="form-control" name="superNombre" value="">

          <label for="apellido">Apellido<?php echo form_error("apellido");?></label>
          <input type="text" class="form-control" name="superApellido" value="">

          <label for="email">Email<?php echo form_error("email");?></label>
          <input type="text" class="form-control" name="superEmail" value="">

          <label for="dni">DNI<?php echo form_error("dni");?></label>
          <input type="text" class="form-control" name="superDni" value="">

          <div class="form-group">
            <label for="password">Contraseña<?php echo form_error("password");?></label>
            <div class="input-group">
              <input type="password" id="password-form" class="form-control" name="superPassword" value="">
              <div id="show-me" class="input-group-addon"><i class="fa fa-lg fa-eye"></i></div>
            </div>
          </div>

          <div class="form-group">
            <label for="re-password">Confirmación de Contraseña<?php echo form_error("re-password");?></label>
            <div class="input-group">
              <input type="password" id="password-form" class="form-control" name="super-re-password" value="">
              <div id="show-me" class="input-group-addon"><i class="fa fa-lg fa-eye"></i></div>
            </div>
          </div>
          <br>
          <hr>
          <br>
          <h3>Administrador</h3>
          <!-- Administrador -->
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



          <input type="submit" class="btn btn-default" name="submit" value="Enviar">
        </div>
        <?php echo form_close(); ?>
      </div>
      <?php $replacement = '/cotillon/index.php'; ?>
      <script src="<?php echo str_replace($replacement, '', base_url('/assets/js/jquery-3.1.1.min.js'));?>"></script>
      <script src="<?php echo str_replace($replacement, '', base_url('/assets/js/bootstrap.min.js'));?>"></script>

    </body>
    </html>
