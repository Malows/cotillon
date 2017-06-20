<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="root" v-cloak style="margin: 10px 0">

  <v-select
    v-bind:options="clientesParaSelect"
    v-model="cliente_seleccionado"
    placeholder="Seleccione un cliente o dejelo vacío para hacer una venta a 'consumidor final'">
  </v-select>
  <hr>
  <div class="form-inline">
    <div class="row">
      <div class="col-md-4">
        <v-select
          v-bind:options="productosParaSelect"
          v-model="producto_seleccionado"
          placeholder="Seleccione un producto">
        </v-select>
      </div>

      <label for="id">Código de producto</label>
      <input type="text" name="id" v-model.number="id_producto_seleccionado" placeholder="Código de producto" class="form-control" >

      <label for="cantidad">Cantidad</label>
      <input type="text" name="cantidad" v-model.number="cantidad" v-on:keyup.enter="agregarProducto" placeholder="Cantidad" class="form-control">

      <button type="button" name="button" v-on:click="agregarProducto" class="btn btn-success">agregar</button>
    </div>
  </div>

  <div v-show="errors.length" class="alert alert-danger" role="alert" >
    <ul>
      <li v-for="error in errors">{{error}}</li>
    </ul>
  </div>

  <ul>
    <li v-for="prod in productos_agregados" v-on:dblclick="eliminarDeLista">
      {{prod.nombre}} - cantidad: {{prod.cantidad}}
    </li>
  </ul>
  <hr>
  <div>
    <p v-if="totalDeVenta">subtotal: <strong>${{totalDeVenta()}}</strong></p>
    <p v-else>Agregue productos al listado</p>
    <p v-show="cliente_seleccionado">Cliente: <strong>{{cliente_seleccionado.label}}</strong></p>
  </div>
  <button type="button" v-show="totalDeVenta()" v-on:click="confirmarVenta" name="button" class="btn btn-warning">Realizar venta</button>
</div>
