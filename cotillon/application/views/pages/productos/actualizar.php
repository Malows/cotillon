<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-xm-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well">
  <?php if ( isset($exito) and $exito ) {
    echo '
    <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Genial!</h4>
			Se ha modificado exitosamente el producto <strong>'.$producto['nombre'].'</strong>.
		</div>';
  }
  echo form_open( "/productos/actualizar/" . $producto['id_producto'] ); ?>
    <div class="form-group">

        <label for="id_proveedor">Proveedor<?php echo form_error("id_proveedor");?></label>
        <select name="id_proveedor" class="form-control" placeholder="Seleccione un proveedor">
          <?php foreach ($proveedores as $prov) {
            $aux = '<option value="' . $prov['id_proveedor'];
            $aux .= ( $producto['id_proveedor'] == $prov['id_proveedor'] ) ? '" selected>' : '">';
            $aux .= $prov['nombre_proveedor'] . "</option>\n";
            echo $aux;
          } ?>
        </select>

        <label for="nombre">Nombre<?php echo form_error("nombre");?></label>
        <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo $producto['nombre']; ?>">

        <label for="precio">Precio<?php echo form_error("precio");?></label>
        <input type="text" class="form-control" name="precio" placeholder="Precio" value="<?php echo $producto['precio']; ?>">

        <label for="id_categoria">Categoria<?php echo form_error("id_categoria");?></label>
        <select name="id_categoria" class="form-control" placeholder="Seleccione una categoria">
          <?php foreach ($categorias as $cat){
            $aux = '<option value="' . $cat['id_categoria'];
            $aux .= ( $producto['id_categoria'] == $cat['id_categoria'] ) ? '" selected>' : '">';
            $aux .= $cat['nombre_categoria'] . "</option>\n";
            echo $aux;
          }?>
        </select>

        <label for="unidad">Unidad<?php echo form_error('unidad');?></label>
        <select class="form-control" name="unidad" placeholder="Seleccione una unidad para el producto">
          <option value="unidades" <?php echo $producto['unidad'] === 'unidades' ? 'selected' : '' ;?>>Unidades (u)</option>
          <option value="decenas" <?php echo $producto['unidad'] === 'decenas' ? 'selected' : '' ;?>>Decenas (dec)</option>
          <option value="docenas" <?php echo $producto['unidad'] === 'docenas' ? 'selected' : '' ;?>>Docenas (doc)</option>
          <option value="gramos" <?php echo $producto['unidad'] === 'gramos' ? 'selected' : '' ;?>>Gramos (gr)</option>
          <option value="kilogramos" <?php echo $producto['unidad'] === 'kilogramos' ? 'selected' : '' ;?>>Kilogramos (Kg)</option>
          <option value="litros" <?php echo $producto['unidad'] === 'litros' ? 'selected' : '' ;?>>Litros (L)</option>
          <option value="metro" <?php echo $producto['unidad'] === 'metro' ? 'selected' : '' ;?>>Metro (M)</option>
          <option value="centimetro" <?php echo $producto['unidad'] === 'centimetro' ? 'selected' : '' ;?>>Centimetro (cm)</option>
        </select>

        <label for="descripcion">Descripción<?php echo form_error("descripcion");?></label>
        <textarea name="descripcion" class="form-control" maxlength="255" placeholder="Datos de contacto"><?php echo $producto['descripcion']; ?></textarea>

        <input type="submit" class="btn btn-default" name="submit" value="Enviar">
    </div>
  <?php echo form_close(); ?>
</div>
