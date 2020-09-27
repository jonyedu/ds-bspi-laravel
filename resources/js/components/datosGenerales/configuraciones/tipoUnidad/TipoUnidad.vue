<template>
  <div class="row">
    <h1 class="mt-2">Tipo de Unidad</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevoTipoUnidad()">Nuevo</button>
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
                :rows-data="tipoUnidad"
                @handleModificarClick="modificarTipoUnidad"
                @handleAnularClick="anularTipoUnidadConfirmacion"
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'50%'" :height="'auto'" :scrollable="true" name="crearTipoUnidad">
      <crear-modificar-tipo-unidad
        :tipo-unidad-mod="tipoUnidadMod"
        @recargarTipoUnidad="cargarTipoUnidad"
        @cerrarModalCrearTipoUnidad="cerrarModalCrearTipoUnidad"
        ref="crearTipoUnidad"
      ></crear-modificar-tipo-unidad>
    </modal>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      tipoUnidadMod: null,
      url_data: "",
      errores: {},
      form: {},
      tipoUnidad: [],
      columns: [
        {
          label: "Nombre",
          field: "TIPOUNIDAD_NOM",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "TIPOUNIDAD_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarTipoUnidad();
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales.generalidades
      .organizacion_bspi.organizacion_bspi.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
  },
  beforeDestroy: function() {
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
    modificarTipoUnidad(value) {
      this.tipoUnidadMod = value;
      this.abrirModalCrearTipoUnidad();
    },
    anularTipoUnidadConfirmacion(value) {
      let that = this;
      this.$swal({
        title: "¿Desea anular el elemento seleccionado?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          that.anularTipoUnidad(value.TIPOUNIDAD_COD);
        }
      });
    },
    anularTipoUnidad(id) {
      let that = this;
      let url = "/datos_generales/configuraciones/eliminar_tipo_unidad/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarTipoUnidad();
          that.$swal({
            icon: "success",
            title: "Proceso realizado exitosamente",
            text: "Dato anulado correctamente."
          });
        })
        .catch(error => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    },
    cerrarModalCrearTipoUnidad: function() {
      this.$modal.hide("crearTipoUnidad");
      this.cargarTipoUnidad();
    },
    nuevoTipoUnidad: function() {
      this.tipoUnidadMod = null;
      this.abrirModalCrearTipoUnidad();
    },
    abrirModalCrearTipoUnidad: function() {
      this.$modal.show("crearTipoUnidad");
    },
    cargarTipoUnidad: function() {
      let that = this;
      let url = "/datos_generales/configuraciones/cargar_tipo_unidad";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let tipoUnidad = [];
          for (let i = 0; i < response.data.tipoUnidad.length; i++) {
            let objeto = {
              TIPOUNIDAD_COD: response.data.tipoUnidad[i].TIPOUNIDAD_COD,
              TIPOUNIDAD_NOM: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.tipoUnidad[i].TIPOUNIDAD_NOM),
              TIPOUNIDAD_OBS: that.$funcionesGlobales.toCapitalFirstAllWords(response.data.tipoUnidad[i].TIPOUNIDAD_OBS)
            }
            tipoUnidad.push(objeto);                       
          }
          that.tipoUnidad = tipoUnidad;
          loader.hide();
        })
        .catch(error => {
          //Errores
          loader.hide();
          that.$swal({
            icon: "error",
            title: "Existe un error",
            text: error
          });
        });
    }
  }
};
</script>
