<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $replacement = '/cotillon/index.php'; ?>
<script src="<?php echo str_replace($replacement, '', base_url('/assets/js/vue-select-2.2.0.js'));?>"></script>
<script>
  Vue.component('v-select', VueSelect.VueSelect);

  var vue = new Vue({
    el: '#root',

    data: {
      proveedores: [
        <?php foreach ($proveedores as $proveedor) {
          echo json_encode($proveedor).",\n";
        } ?>
      ],
      proveedor_seleccionado: '',
      cantidad: '',
      precio: '',
      productos: [
        <?php foreach ($productos as $value) {
          $value['nombre'] = html_entity_decode($value['nombre']);
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
        // Blanqueo los errores
        this.errors = []

        if ( this.producto_seleccionado  && this.cantidad && this.precio ) {

          let aux = this.producto_seleccionado.value
          let resultado = this.productos_agregados.find( elem => elem.id === aux.id )
          let indice = resultado ? this.productos_agregados.indexOf( resultado ) : null

          if ( indice !== -1 && indice !== null ) this.productos_agregados[indice].cantidad += this.cantidad
          else {
            aux.cantidad = this.cantidad
            aux.precio = this.precio
            this.productos_agregados.push(aux)
          }
          this.cantidad = ''
          this.producto_seleccionado = ''
          this.id_producto_seleccionado = ''
          this.precio = ''
        } else {
          if ( ! this.producto_seleccionado ) this.errors.push('Debe seleccionar un producto.')
          if ( this.cantidad === '' ) this.errors.push('Debe ingresar una cantidad de producto.')
          if ( !parseFloat(this.cantidad) ) this.errors.push('La cantidad ingresada debe ser solo numérica.')
        }
      },

      eliminarDeLista( prod ) {
        let indice = this.productos_agregados.indexOf(prod)
        this.productos_agregados.splice(indice, 1)
      },

      emitirPedido() {
        const payload = {
          'proveedor': {
            'id': this.proveedor_seleccionado.value,
            'nombre': this.proveedor_seleccionado.label
          },
          'productos': this.productos_agregados
        }
        payload.total = this.totalDePedido
        // payload.total = this.productos_agregados.reduce((c, x) => c + (x.cantidad * c.precio), 0)
        console.log(payload);
        $.ajax({
          url: '<?php echo base_url('pedidos/api_emitir_pedidos'); ?>',
          type: 'GET',
          data: payload
        })
        .done(this.wipeDatosDeVenta())
      },
      confirmarVenta() {
        this.showModal = true
      },
      cerrarModal() {
        this.showModal = false;
      },
      wipeDatosDeVenta() {
        this.cerrarModal()
        this.cantidad = ''
        this.producto_seleccionado = ''
        this.id_producto_seleccionado = ''
        this.proveedor_seleccionado = ''
        this.productos_agregados = []
      }
    },
    computed: {
      totalDePedido () {
        return this.productos_agregados.reduce((c, x) => c + (x.cantidad * x.precio), 0)
      },
      productosParaSelect () {
        return this.productos
          .filter(x => this.proveedor_seleccionado ? x.id_proveedor == this.proveedor_seleccionado.value : true)
          .map(elem => {return {value: elem, label: elem.nombre}})
      },
      proveedoresParaSelect() {
        return this.proveedores.map(elem => {return {value: elem.id, label: elem.nombre}})
      }
    }
  })
</script>
