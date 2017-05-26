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
        <input type="text" name="nombre_cliente" class="form-control" value="<?php echo $cliente['nombre_cliente']; ?>" placeholder="Nombre">

        <label for="">Correo Electrónico<?php echo form_error("email");?></label>
        <input type="email" class="form-control" name="email" value="<?php echo $cliente['email']; ?>" placeholder="ejemplo@email.com">

        <label for="id_localidad">Localidad<?php echo form_error("id_localidad");?></label>
        <select name="id_localidad" class="form-control" placeholder="Ingrese el nombre del cliente">
          <?php foreach ($localidades as $loc){
            $aux =  '<option value="' . $loc['id_localidad'];
            $aux .= ($cliente['id_localidad'] === $loc['id_localidad']) ? '" selected>' : '">';
            $aux .= $loc['nombre_localidad'] .' - '. $loc['barrio'] . "</option>\n";
            echo $aux;
          }?>
        </select>

        <label for="direccion">Dirección<?php echo form_error("direccion");?></label>
        <input type="text" name="direccion" class="form-control" value="<?php echo $cliente['direccion']; ?>" placeholder="Calle altura">

        <label for="telefono">Teléfono<?php echo form_error("telefono");?></label>
        <input type="tel" name="telefono" class="form-control" value="<?php echo $cliente['telefono']; ?>" placeholder="(código de area) - número de telefono">

        <label for="tipo_cliente">Tipo de cliente<?php echo form_error("tipo_cliente");?></label>
        <select name="tipo_cliente" class="form-control" placeholder="Seleccione un tipo de cliente">
          <option value="Minorista"<?php echo ($cliente['tipo_cliente'] == 'Minorista') ? ' selected' : '' ?>>Minorista</option>
          <option value="Mayorista"<?php echo ($cliente['tipo_cliente'] == 'Mayorista') ? ' selected' : '' ?>>Mayorista</option>
        </select>

        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close(); ?>
</div>
