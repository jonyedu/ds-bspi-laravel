<template>
  <div class="row">
    <h1 class="mt-4">ORGANIZACIONES</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaOrganizacion()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :titulo-data="'Lista de Organizaciones BSPI'"
                :columns-data="columns"
                :rows-data="organizaciones"
                @handleModificarClick="modificarOrganizacion"
                @handleAnularClick="
                                    anularOrganizacionConfirmacion
                                "
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" :height="'auto'" :scrollable="true" name="crearOrganizacionBspi">
      <crear-organizacion-bspi
        :organizacion-mod="organizacionMod"
        @recargarOrganizaciones="cargarOrganizaciones"
        @cerrarModalCrearOrganizacion="cerrarModalCrearOrganizacion"
        ref="crearOrganizacionBspi"
      ></crear-organizacion-bspi>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      organizacionMod: null,
      url_data: "",
      errores: {},
      form: {},
      organizaciones: [],
      columns: [
        {
          label: "Nombre",
          field: "ORGANIZACION_NOM",
          type: "String"
        },
        {
          label: "Activo",
          field: "ORGANIZACION_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "ORGANIZACION_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    this.cargarOrganizaciones();
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
    modificarOrganizacion(value) {
      this.organizacionMod = value;
      this.abrirModalCrearOrganizacion();
    },
    anularOrganizacionConfirmacion(value) {
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
          that.anularOrganizacion(value.ORGANIZACION_COD);
        }
      });
    },
    anularOrganizacion(id) {
      let that = this;
      let url = "/datos_generales/generalidades/eliminar_organizaciones/" + id;
      var loader = that.$loading.show();
      axios
        .delete(url)
        .then(function(response) {
          loader.hide();
          that.cargarOrganizaciones();
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
    cerrarModalCrearOrganizacion: function() {
      this.$modal.hide("crearOrganizacionBspi");
    },
    nuevaOrganizacion: function() {
      this.organizacionMod = null;
      this.abrirModalCrearOrganizacion();
    },
    abrirModalCrearOrganizacion: function() {
      this.$modal.show("crearOrganizacionBspi");
    },
    cargarOrganizaciones: function() {
      let that = this;
      let url = "/datos_generales/generalidades/cargar_organizaciones";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          let organizaciones = [];
          organizaciones = response.data.organizaciones;

          that.organizaciones = organizaciones;
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
