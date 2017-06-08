<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
  var vue = new Vue({
    el: '#root',

    data: {
      cantidad: '',
      productos: [
        <?php foreach ($productos as $value) {
          echo json_encode($value).",\n";
        }?>
      ],
      productos_agregados: [],
      producto_seleccionado: '',
      id_producto_seleccionado: '',
      errors: [],
    },

    methods: {
      agregarProducto() {
        // Si ingreso por id el producto, asigno el elemento seleccionado para proseguir
        if ( this.id_producto_seleccionado && !this.producto_seleccionado )
          // filter devuelve un array, de logitud 1, porque solo un id coincide
          this.producto_seleccionado = this.productos.filter( elem => elem.id == this.id_producto_seleccionado )[0]
        // Blanqueo los errores
        this.errors = []

        if ( this.producto_seleccionado  && this.cantidad && this.cantidad <= this.producto_seleccionado.stock ) {
          var aux = this.producto_seleccionado
          // Nos fijamos si ya está
          let resultado = this.productos_agregados.filter( elem => elem.id === aux.id )[0]
          // Si el resultado es undefined(no fue agregado previamente) asigno null al indice
          let indice = resultado ? this.productos_agregados.indexOf( resultado ) : null
          if ( indice !== -1 && indice !== null ) {
            this.productos_agregados[indice].cantidad += this.cantidad
            this.productos_agregados[indice].stock -= this.cantidad
          } else {
            aux.cantidad = this.cantidad
            aux.stock -= this.cantidad
            this.productos_agregados.push(aux)
          }
          this.cantidad = ''
          this.producto_seleccionado = ''
          this.id_producto_seleccionado = ''
          document.querySelector('input[name="id"]').focus()
        } else {
          if ( ! this.producto_seleccionado ) this.errors.push('Debe seleccionar un producto.')
          if ( this.cantidad === '' ) this.errors.push('Debe ingresar una cantidad de producto.')
          if ( !parseFloat(this.cantidad) ) this.errors.push('La cantidad ingresada debe ser solo numérica.')
          if ( this.cantidad > this.producto_seleccionado.stock ) this.errors.push('La cantidad ingresada es mayor a la existencia de stock')
        }
      },

      eliminarDeLista( prod ) {
        let indice = this.productos_agregados.indexOf(prod)
        this.productos_agregados.splice(indice, 1)
      },

      totalDeVenta() {
        return this.productos_agregados.reduce((prev, curr) => { return prev + curr.precio * curr.cantidad }, 0)
      }
    }
  })
</script>
