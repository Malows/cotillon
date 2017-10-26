<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>
<div id="root" v-cloak style="margin: 10px 0">

  <v-select
    v-bind:options="proveedoresParaSelect"
    v-model="proveedor_seleccionado"
    placeholder="Seleccione un proveedor">
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

      <label for="cantidad">Cantidad</label>
      <input type="text" name="cantidad" v-model.number="cantidad" v-on:keyup.enter="agregarProducto" placeholder="Cantidad" class="form-control">

      <label for="cantidad">Precio</label>
      <input type="text" name="precio" v-model.number="precio" v-on:keyup.enter="agregarProducto" placeholder="Precio" class="form-control">

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
    <p v-if="totalDePedido">subtotal: <strong>${{totalDePedido}}</strong></p>
    <p v-else>Agregue productos al listado</p>
    <p v-show="proveedor_seleccionado">Cliente: <strong>{{proveedor_seleccionado.label}}</strong></p>
  </div>
  <button type="button" v-show="productos_agregados" v-on:click="confirmarVenta" name="button" class="btn btn-warning">Realizar pedido</button>
<!-- Modal de bulma -->
  <div class="modal" v-bind:class="{ 'is-active': showModal }">
    <div class="modal-background" v-on:click="cerrarModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Confirmar pedido</p>
        <button class="btn btn-default" v-on:click="cerrarModal"><i class="fa fa-remove"></i></button>
      </header>
      <section class="modal-card-body">
        <p>Proveedor: <strong>{{proveedor_seleccionado.label}}</strong></p>
        <hr>
        <ul>
          <li v-for="prod in productos_agregados">
            {{prod.nombre}} - cantidad: {{prod.cantidad}}
          </li>
        </ul>
        <hr>
        <p>subtotal: <strong>${{totalDePedido}}</strong></p>
      </section>
      <footer class="modal-card-foot">
          <button class="btn btn-success" v-on:click="emitirPedido">Pedir</button>
          <button class="btn btn-default" v-on:click="cerrarModal">Cerrar</button>
      </footer>
    </div>
  </div>
</div>
