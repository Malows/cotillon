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
  echo form_open("/clientes/actualizar/".$cliente['id_cliente'])?>
    <div class="form-group">

        <label for="nombre_cliente">Nombre<?php echo form_error("nombre_cliente");?></label>
        <input type="text" class="form-control" name="nombre_cliente" placeholder="Ingrese el nombre del cliente" value="<?php echo $cliente['nombre_cliente']; ?>">

        <label for="tipo_cliente">Tipo de cliente<?php echo form_error("tipo_cliente");?></label>
        <select name="tipo_cliente" class="form-control" placeholder="Seleccione un tipo de cliente">
          <option value="Minorista"<?php echo ($cliente['tipo_cliente'] == 'Minorista') ? ' selected' : '' ?>>Minorista</option>
          <option value="Mayorista"<?php echo ($cliente['tipo_cliente'] == 'Mayorista') ? ' selected' : '' ?>>Mayorista</option>
        </select>

        <label for="id_localidad">Localidad<?php echo form_error("id_localidad");?></label>
        <select name="id_localidad" class="form-control" placeholder="Ingrese el nombre del cliente">
          <?php foreach ($localidades as $loc){
            $aux =  '<option value="' . $loc['id_localidad'];
            $aux .= ($cliente['id_localidad'] === $loc['id_localidad']) ? '" selected>' : '">';
            $aux .= $loc['nombre_localidad'] . "</option>\n";
            echo $aux;
          }?>
        </select>

        <label for="contacto">Contacto<?php echo form_error("contacto");?></label>
        <textarea name="contacto" class="form-control" maxlength="255" placeholder="Datos de contacto"><?php echo $cliente['contacto']; ?></textarea>

        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close(); ?>
</div>
