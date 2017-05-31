<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="root">

  <div class="form-inline">
    <select name="productos" class="form-control" v-model="producto_seleccionado">
      <option v-for="opc in productos" v-bind:value="{text: opc.text, id: opc.id, precio: opc.precio}">{{opc.text}}</option>
    </select>

    <input type="text" name="cantidad" v-model="cantidad" v-on:keyup.enter="agregarProducto" class="form-control">

    <button type="button" name="button" v-on:click="agregarProducto" class="btn btn-success">agregar</button>
  </div>

  <div v-show="errors.length" class="alert alert-danger" role="alert">
    <ul>
      <li v-for="error in errors">{{error}}</li>
    </ul>
  </div>

  <ul>
    <li v-for="prod in productos_agregados" v-on:dblclick="eliminarDeLista">
      {{prod.text}} - cantidad: {{prod.cantidad}}
    </li>
  </ul>
  <hr>
  <p v-if="totalDeVenta">subtotal: <strong>${{totalDeVenta}}</strong></p>
  <p v-else>Agregue productos al listado</p>
</div>
