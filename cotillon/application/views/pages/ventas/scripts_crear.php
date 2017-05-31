<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
  var vue = new Vue({
    el: '#root',

    data: {
      cantidad: '',
      productos: [
        {id: 1, text: 'Manguera de nafta', precio: 10},
        {id: 2, text: 'Cobertura de chocolate', precio: 15},
        {id: 3, text: 'Producto de ejemplo', precio: 3.5}
      ],
      productos_agregados: [],
      producto_seleccionado: '',
      errors: [],
    },

    methods: {
      agregarProducto() {
        this.errors = []
        if (this.producto_seleccionado !== '' && this.cantidad !== '' && parseFloat(this.cantidad) ) {
          const aux = this.producto_seleccionado
          aux.cantidad = parseFloat(this.cantidad)
          this.cantidad = ''
          this.producto_seleccionado = ''
          this.productos_agregados.push(aux)
        } else {
          if ( this.producto_seleccionado === '' ) this.errors.push('Debe seleccionar un producto.')
          if ( this.cantidad === '' ) this.errors.push('Debe ingresar una cantidad de producto.')
          if ( !parseFloat(this.cantidad) ) this.errors.push('La cantidad ingresada debe ser solo numérica.')
        }
      },

      eliminarDeLista( prod ) {
        let indice = this.productos_agregados.indexOf(prod)
        this.productos_agregados.splice(indice, 1)
      }
    },

    computed: {
      totalDeVenta() {
        return this.productos_agregados.reduce((prev, curr) => { return prev + curr.precio * curr.cantidad }, 0)
      }
    }

  })
</script>
