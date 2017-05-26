<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
    echo '
    <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Genial!</h4>
			Se ha agregado exitosamente el cliente <strong>'.$cliente['nombre_cliente'].'</strong>.
		</div>';
  }
  echo form_open("/clientes/crear")?>
    <div class="form-group">

        <label for="nombre_cliente">Nombre<?php echo form_error("nombre_cliente");?></label>
        <input type="text" class="form-control" name="nombre_cliente" placeholder="Ingrese el nombre del cliente">

        <label for="">Correo Electrónico<?php echo form_error("email");?></label>
        <input type="email" class="form-control" name="email" value="" placeholder="ejemplo@email.com">

        <label for="tipo_cliente">Tipo de cliente<?php echo form_error("tipo_cliente");?></label>
        <select name="tipo_cliente" class="form-control" placeholder="Seleccione un tipo de cliente">
          <option value="Minorista">Minorista</option>
          <option value="Mayorista">Mayorista</option>
        </select>

        <label for="id_localidad">Localidad<?php echo form_error("id_localidad");?></label>
        <select name="id_localidad" class="form-control" placeholder="Ingrese el nombre del cliente">
          <?php foreach ($localidades as $loc){
            echo "<option value=\"".$loc['id_localidad']."\">".$loc['nombre_localidad'] .' - '. $loc['barrio']."</option>\n";
          }?>
        </select>

        <label for="">Dirección<?php echo form_error("direccion");?></label>
        <input type="text" class="form-control" name="direccion" value="" placeholder="Calle altura">

        <label for="contacto">Teléfono<?php echo form_error("telefono");?></label>
        <input type="tel" name="telefono" value="" class="form-control" placeholder="(código de area) - número de telefono">

      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
      </div>
  <?php echo form_close(); ?>
</div>
