<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
  var vue = new Vue({
    el: '#root',

    data: {
      cantidad: '',
      productos: [
        {id: 1, text: 'Manguera de nafta'},
        {id: 2, text: 'Cobertura de chocolate'},
        {id: 3, text: 'Producto de ejemplo'}
      ],
      productos_agregados: [],
      producto_seleccionado: '',
    },

    methods: {
      agregarProducto() {
        let aux = { cantidad: this.cantidad, text: 'ejemplo', id: 1 }
        this.cantidad = ''
        this.productos_agregados.push(aux)
      },

      eliminarDeLista( prod ) {
        let indice = this.productos_agregados.indexOf(prod)
        this.productos_agregados.splice(indice, 1)
      }
    }

  })
</script>
