<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="root" v-cloak style="margin: 10px 0">

  <div class="form-inline">
    <select name="productos" class="form-control" v-model="producto_seleccionado" >
      <option v-for="opc in productos" v-bind:value="{nombre: opc.nombre, id: opc.id , precio: opc.precio, stock: opc.stock}">{{opc.nombre}}</option>
    </select>
    <input type="text" name="id" v-model.number="id_producto_seleccionado" class="form-control" >
    <input type="text" name="cantidad" v-model.number="cantidad" v-on:keyup.enter="agregarProducto" class="form-control">
    <button type="button" name="button" v-on:click="agregarProducto" class="btn btn-success">agregar</button>
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
  </div>

</div>
