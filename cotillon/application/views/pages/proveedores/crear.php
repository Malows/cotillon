<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
    echo '
    <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Genial!</h4>
			Se ha creado exitosamente el proveedor <strong>'.$proveedor.'</strong>.
		</div>';
  }
  echo form_open("/proveedores/crear")?>
    <div class="form-group">

        <label for="nombre_proveedor">Nombre del proveedor<?php echo form_error("nombre_proveedor");?></label>
        <input type="text" class="form-control" name="nombre_proveedor" placeholder="Nombre">

        <label for="localidad">Localidad<?php echo form_error("localidad");?></label>
        <select name="localidad" class="form-control">
          <?php foreach ($localidades as $loc){
            echo "<option value=\"".$loc['id_localidad']."\">".$loc['nombre_localidad'].' - '.$loc['barrio']."</option>\n";
        }?>
        </select>

        <label for="contacto">Contacto<?php echo form_error("contacto");?></label>
        <textarea name="contacto" class="form-control" maxlength="255" placeholder="Datos de contacto"></textarea>

        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close(); ?>
</div>
