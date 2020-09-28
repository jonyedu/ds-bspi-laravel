<template>
  <div class="row">
    <h1 class="mt-2">Presentación</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaPresentacion()">Nuevo</button>
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
                :rows-data="presentaciones"
                @handleModificarClick="modificarPresentacion"
                @handleAnularClick="anularPresentacionConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearPresentacion">
      <crear-presentacion
        :presentacion-mod="presentacionMod"
        @recargarPresentaciones="cargarPresentaciones"
        @cerrarModalCrearPresentacion="cerrarModalCrearPresentacion"
        ref="crearPresentacion"
      ></crear-presentacion>
    </modal>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      presentacionMod: null,
      url_data: "",
      errores: {},
      form: {},
      presentaciones: [],
      columns: [
        {
          label: "Nombre",
          field: "PRESENTACION_NOM",
          type: "String",
        },
        {
          label: "Unidad",
          field: "PRESENTACION_UNIDAD",
          type: "String",
        },
      ],
    };
  },
  mounted: function () {
    this.cargarPresentaciones();
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
    modificarPresentacion(value) {
      this.presentacionMod = value;
      this.abrirModalCrearPresentacion();
    },
    anularPresentacionConfirmacion(value) {
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
          that.anularPresentacion(value.PRESENTACION_COD);
        }
      });
    },
    anularPresentacion(id) {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_farmacia/eliminar_presentacion/" +
        id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function (response) {
          loader.hide();
          that.cargarPresentaciones();
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
    cerrarModalCrearPresentacion: function () {
      this.$modal.hide("crearPresentacion");
      this.cargarPresentacion();
    },
    nuevaPresentacion: function () {
      this.presentacionMod = null;
      this.abrirModalCrearPresentacion();
    },
    abrirModalCrearPresentacion: function () {
      this.$modal.show("crearPresentacion");
    },
    cargarPresentaciones: function () {
      let that = this;
      let url =
        "/gestion_hospitalaria/administracion_farmacia/cargar_presentaciones";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function (response) {
          let presentaciones = [];
          for (let i = 0; i < response.data.presentaciones.length; i++) {
            let objeto = {
              PRESENTACION_COD: response.data.presentaciones[i].PRESENTACION_COD,
              PRESENTACION_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.presentaciones[i].PRESENTACION_NOM),
              PRESENTACION_CANTIDAD: response.data.presentaciones[i].PRESENTACION_CANTIDAD,
              UNIDAD_COD: response.data.presentaciones[i].unidad.UNIDAD_COD,
              UNIDAD_SIMB: response.data.presentaciones[i].unidad.UNIDAD_SIMB,
              PRESENTACION_UNIDAD: response.data.presentaciones[i].PRESENTACION_UNIDAD
            }
            presentaciones.push(objeto);                       
          }
          that.presentaciones = presentaciones;
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
