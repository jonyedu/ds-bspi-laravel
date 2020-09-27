<template>
  <div class="row">
    <h1 class="mt-2">Unidad</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoUnidad()">Nuevo</button>
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
                :rows-data="unidad"
                @handleModificarClick="modificarUnidad"
                @handleAnularClick="anularUnidadConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'70%'" :height="'auto'" :scrollable="true" name="crearUnidad">
      <crear-modificar-unidad
        :unidad-mod="unidadMod"
        @recargarUnidad="cargarUnidad"
        @cerrarModalCrearUnidad="cerrarModalCrearUnidad"
        ref="crearUnidad"
      ></crear-modificar-unidad>
    </modal>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      unidadMod: null,
      url_data: "",
      errores: {},
      form: {},
      unidad: [],
      columns: [
        {
          label: "Nombre",
          field: "UNIDAD_NOM",
          type: "String",
        },
        {
          label: "Tipo Unidad",
          field: "TIPOUNIDAD_NOM",
          type: "String",
        },
        {
          label: "Simbología",
          field: "UNIDAD_SIMB",
          type: "String",
        },
        {
          label: "Equivalencia",
          field: "UNIDAD_EQUIV",
          type: "String",
        },
        {
          label: "Observación",
          field: "UNIDAD_OBS",
          type: "String",
        },
      ],
    };
  },
  mounted: function () {
    this.cargarUnidad();
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
    modificarUnidad(value) {
      this.unidadMod = value;
      this.abrirModalCrearUnidad();
    },
    anularUnidadConfirmacion(value) {
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
          that.anularUnidad(value.UNIDAD_COD);
        }
      });
    },
    anularUnidad(id) {
      let that = this;
      let url =
        "/datos_generales/configuraciones/eliminar_unidad/" +
        id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function (response) {
          loader.hide();
          that.cargarUnidad();
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
    cerrarModalCrearUnidad: function () {
      this.$modal.hide("crearUnidad");
      this.cargarUnidad();
    },
    nuevoUnidad: function () {
      this.unidadMod = null;
      this.abrirModalCrearUnidad();
    },
    abrirModalCrearUnidad: function () {
      this.$modal.show("crearUnidad");
    },
    cargarUnidad: function () {
      let that = this;
      let url =
        "/datos_generales/configuraciones/cargar_unidad";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function (response) {
          loader.hide();
          let unidad = [];
          for (let i = 0; i < response.data.unidad.length; i++) {
            let objeto = {
              UNIDAD_COD: response.data.unidad[i].UNIDAD_COD,
              UNIDAD_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.unidad[i].UNIDAD_NOM),
              TIPOUNIDAD_COD: response.data.unidad[i].tipo_unidad.TIPOUNIDAD_COD,
              TIPOUNIDAD_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.unidad[i].tipo_unidad.TIPOUNIDAD_NOM),
              UNIDAD_SIMB: response.data.unidad[i].UNIDAD_SIMB,
              UNIDAD_EQUIV: response.data.unidad[i].UNIDAD_EQUIV,
              UNIDAD_OBS: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.unidad[i].UNIDAD_OBS),
              
            }
            unidad.push(objeto);                       
          }
          that.unidad = unidad;
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
