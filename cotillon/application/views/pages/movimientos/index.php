<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 class="text-center">Movimientos</h2>
<hr>

<div class="row">
  <button class="btn btn-primary" data-toggle="modal" data-target="#crear-movimiento"><i class="fa fa-plus fa-lg"></i></button>
  <button class="btn btn-primary" data-toggle="modal" data-target="#crear-razon">Crear razón de movimiento</button>
</div>


<table class="table table-striped">
  <thead>
    <th>#</th>
    <th>Monto</th>
    <th>Descripcion</th>
  </thead>
  <tbody>
    <?php foreach ($movimientos as $movimiento):?>
    <tr>
      <td><?= $movimiento['id_movimiento'];?></td>
      <td><?= $movimiento['monto'];?></td>
      <td><?= $movimiento['descripcion'];?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>

<div class="modal fade" id="crear-movimiento" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?php echo form_open(base_url('movimientos/crear')); ?>
        <div class="modal-header">
          <h3>Crear movimiento nuevo</h3>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Monto</label>
              <input type="number" class="form-control" name="monto" value="">
            </div>
            <div class="form-group">
              <label>Razón</label>
              <select class="form-control" name="id_razon_movimiento">
                <?php foreach ($razones_movimientos as $razon): ?>
                  <option value="<?= $razon['id_razon_movimiento']; ?>"><?= $razon['descripcion']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button>
          <button type="submit" name="submit" class="btn btn-primary">Crear</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="crear-razon" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?php echo form_open(base_url('movimientos/crear_razon')); ?>
        <div class="modal-header">
          <h3>Crear movimiento nuevo</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Descripción</label>
            <input type="text" class="form-control" name="descripcion" value="">
          </div>
          <div class="form-group">
            <label>Ponderación</label>
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-primary active">
                <input type="radio" name="multiplicador" value="1" autocomplete="off" checked> Suma
              </label>
              <label class="btn btn-primary">
                <input type="radio" name="multiplicador" value="-1" autocomplete="off"> Resta
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancelar</span></button>
          <button type="submit" name="submit" class="btn btn-primary">Crear</button>
        </div>
      </form>
    </div>
  </div>
</div>
