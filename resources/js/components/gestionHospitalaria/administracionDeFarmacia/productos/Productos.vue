<template>
  <div class="row">
    <h1 class="mt-2">Productos</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoProductos()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :info-button="false"
                :columns-data="columns"
                :rows-data="productos"
                @handleModificarClick="modificarProductos"
                @handleAnularClick="anularProductosConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearProductos">
      <crear-productos
        :productos-mod="productosMod"
        @recargarProductos="cargarProductos"
        @cerrarModalCrearProductos="cerrarModalCrearProductos"
        ref="crearProductos"
      ></crear-productos>
    </modal>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      productosMod: null,
      url_data: "",
      errores: {},
      form: {},
      productos: [],
      columns: [
        {
          label: "Nombre",
          field: "PRODUCTO_NOM",
          type: "String",
        },
        {
          label: "Categoría",
          field: "CATEGORIA_NOM",
          type: "String",
        },
        {
          label: "Código",
          field: "PRODUCTO_CLAVE",
          type: "String",
        },
      ],
    };
  },
  mounted: function () {
    this.cargarProductos();
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function () {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarProductos(value) {
      this.productosMod = value;
      this.abrirModalCrearProductos();
    },
    anularProductosConfirmacion(value) {
      let that = this;
      this.$swal({
        title: "¿Desea anular el elemento seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          that.anularProductos(value.PRODUCTO_COD);
        }
      });
    },
    anularProductos(id) {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_farmacia/eliminar_productos/" +
        id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function (response) {
          loader.hide();
          that.cargarProductos();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente.",
          });
        })
        .catch((error) => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
    cerrarModalCrearProductos: function () {
      this.$modal.hide("crearProductos");
      this.cargarProductos();
    },
    nuevoProductos: function () {
      this.productosMod = null;
      this.abrirModalCrearProductos();
    },
    abrirModalCrearProductos: function () {
      this.$modal.show("crearProductos");
    },
    cargarProductos: function () {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_productos";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function (response) {
          that.productos = response.data.productos;
          loader.hide();

          let productos = [];
          for (let i = 0; i < response.data.productos.length; i++) {
            let objeto = {
              PRODUCTO_COD: response.data.productos[i].PRODUCTO_COD,
              PRODUCTO_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.productos[i].PRODUCTO_NOM),
              PRODUCTO_CLAVE: response.data.productos[i].PRODUCTO_CLAVE,
              CATEGORIA_COD: response.data.productos[i].categoria.CATEGORIA_COD,
              CATEGORIA_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.productos[i].categoria.CATEGORIA_NOM),
            }
            productos.push(objeto);                       
          }
          that.productos = productos;
          loader.hide();
        })
        .catch((error) => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error,
          });
        });
    },
  },
};
</script>
