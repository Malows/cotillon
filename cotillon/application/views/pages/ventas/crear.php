<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="root">
  <select name="productos">
    <option v-for="opc in productos" v-bind:value="opc.id">{{opc.text}}</option>
  </select>

  <input type="text" name="cantidad" v-model="cantidad">

  <button type="button" name="button" v-on:click="agregarProducto">agregar</button>

  <ul>
    <li v-for="prod in productos_agregados" v-on:click="eliminarDeLista">
      {{prod.text}} - cantidad: {{prod.cantidad}}
    </li>
  </ul>
</div>
