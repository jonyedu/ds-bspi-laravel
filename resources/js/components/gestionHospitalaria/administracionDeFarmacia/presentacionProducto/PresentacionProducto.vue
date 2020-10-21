<template>
  <div class="row">
    <h1 class="mt-2">Asociación de Productos y Presentaciones</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaPresentacionProducto()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="false"
                :info-button="false"
                :columns-data="columns"
                :rows-data="presentacionproductos"
                @handleAnularClick="anularPresentacionProductoConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearPresentacionProducto">
      <crear-presentacionProducto
        :productos="productos"
        :presentaciones="presentaciones"
        @recargarPresentacionProductos="cargarPresentacionProductos"
        @cerrarModalCrearPresentacionProducto="cerrarModalCrearPresentacionProducto"
        ref="crearPresentacion"
      ></crear-presentacionProducto>
    </modal>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      errores: {},
      form: {},
      presentacionproductos: [],
      presentaciones: [],
      productos: [],
      columns: [
        {
          label: "Producto",
          field: "PRODUCTO_NOM",
          type: "String",
        },
        {
          label: "Presentacion",
          field: "PRESENTACION_FULL",
          type: "String",
        },
        {
          label: "Precio",
          field: "PRESENTACIONPRODUCTO_PRECIO",
          type: "String",
        },
      ],
    };
  },
  mounted: function () {
    this.cargarPresentacionProductos();
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
    anularPresentacionProductoConfirmacion(value) {
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
          that.anularPresentacion(value.PRESENTACIONPRODUCTO_COD);
        }
      });
    },
    anularPresentacion(id) {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_farmacia/eliminar_presentacion_producto/" +
        id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function (response) {
          loader.hide();
          that.cargarPresentacionProductos();
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
    cerrarModalCrearPresentacionProducto: function () {
      this.$modal.hide("crearPresentacionProducto");
      this.cargarPresentacion();
    },
    nuevaPresentacionProducto: function () {
      this.abrirModalCrearPresentacionProducto();
    },
    abrirModalCrearPresentacionProducto: function () {
      this.$modal.show("crearPresentacionProducto");
    },
    cargarPresentacionProductos: function () {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_presentacion_producto";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function (response) {
          that.presentaciones = response.data.presentaciones;
          that.productos = response.data.productos;
          that.presentacionproductos = response.data.presentacionProductos;
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
