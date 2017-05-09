<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
    echo '
    <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Genial!</h4>
			Se ha creado exitosamente el producto <strong>'.$producto.'</strong>.
		</div>';
  }
  echo form_open("/productos/crear")?>
    <div class="form-group">

        <label for="id_proveedor">Proveedor<?php echo form_error("id_proveedor");?></label>
        <select name="id_proveedor" class="form-control" placeholder="Seleccione un proveedor">
          <?php foreach ($proveedores as $prov){
            echo "<option value=\"".$prov['id_proveedor']."\">".$prov['nombre_proveedor']."</option>\n";
          }?>
        </select>

        <label for="nombre">Nombre<?php echo form_error("nombre");?></label>
        <input type="text" class="form-control" name="nombre" placeholder="Nombre">

        <label for="precio">Precio<?php echo form_error("precio");?></label>
        <input type="text" class="form-control" name="precio" placeholder="Nombre">

        <label for="id_categoria">Categoria<?php echo form_error("id_categoria");?></label>
        <select name="id_categoria" class="form-control" placeholder="Seleccione una categoria">
          <?php foreach ($categorias as $cat){
            echo "<option value=\"".$cat['id_categoria']."\">".$cat['nombre_categoria']."</option>\n";
          }?>
        </select>

        <label for="unidad">Unidad<?php echo form_error('unidad');?></label>
        <select class="form-control" name="unidad" placeholder="Seleccione una unidad para el producto">
          <option value="unidades">Unidades (u)</option>
          <option value="decenas">Decenas (dec)</option>
          <option value="docenas">Docenas (doc)</option>
          <option value="gramos">Gramos (gr)</option>
          <option value="kilogramos">Kilogramos (Kg)</option>
          <option value="litros">Litros (L)</option>
          <option value="metro">Metro (M)</option>
          <option value="centimetro">Centimetro (cm)</option>
        </select>

        <label for="descripcion">Descripción<?php echo form_error("descripcion");?></label>
        <textarea name="descripcion" class="form-control" maxlength="255" placeholder="Datos de contacto"></textarea>

        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close(); ?>
</div>
