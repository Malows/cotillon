<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="http://localhost:8080/assets/js/vue-select-2.2.0.js"></script>
<script>
  Vue.component('v-select', VueSelect.VueSelect);

  var vue = new Vue({
    el: '#root',

    data: {
      clientes: [
        <?php foreach ($clientes as $cliente) {
          echo json_encode($cliente).",\n";
        } ?>
      ],
      cliente_seleccionado: '',
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
      showModal: false,
    },

    methods: {
      agregarProducto() {
        // Si ingreso por id el producto, asigno el elemento seleccionado para proseguir
        if ( this.id_producto_seleccionado && !this.producto_seleccionado ) {
          // filter devuelve un array, de logitud 1, porque solo un id coincide
          let aux = this.productos.filter( elem => elem.id == this.id_producto_seleccionado )[0]
          this.producto_seleccionado = {label: aux.nombre, value: aux}
        }

        // Blanqueo los errores
        this.errors = []

        if ( this.producto_seleccionado  && this.cantidad && this.cantidad <= this.producto_seleccionado.value.stock ) {
          var aux = this.producto_seleccionado.value
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
          if ( this.cantidad > this.producto_seleccionado.value.stock ) this.errors.push('La cantidad ingresada es mayor a la existencia de stock')
        }
      },

      eliminarDeLista( prod ) {
        let indice = this.productos_agregados.indexOf(prod)
        this.productos_agregados.splice(indice, 1)
      },

      totalDeVenta() {
        return this.productos_agregados.reduce((prev, curr) => { return prev + curr.precio * curr.cantidad }, 0)
      },
      confirmarVenta() {
        this.showModal = true
      },
      emitirVenta() {
        const payload = {
          'cliente': {
            'id': this.cliente_seleccionado.value,
            'nombre': this.cliente_seleccionado.label
          },
          'productos': this.productos_agregados
        }
        console.log(payload);
        $.ajax({
          url: '<?php echo base_url('ventas/api_emitir_venta'); ?>',
          type: 'GET',
          data: payload
        })
        .done(this.wipeDatosDeVenta())
      },
      cerrarModal() {
        this.showModal = false;
      },
      wipeDatosDeVenta() {
        this.cerrarModal()
        this.cantidad = ''
        this.producto_seleccionado = ''
        this.id_producto_seleccionado = ''
        this.cliente_seleccionado = ''
        this.productos_agregados = []
      }
    },
    computed: {
      productosParaSelect() {
        return this.productos.map(elem => {return {value: elem, label: elem.nombre}})
      },
      clientesParaSelect() {
        return this.clientes.map(elem => {return {value: elem.id, label: elem.nombre}})
      }
    }
  })
</script>
