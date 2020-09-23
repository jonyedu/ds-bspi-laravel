<template>
  <div class="row">
    <h1 class="mt-4">Parroquia</h1>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="float-right">
                <button class="btn btn-primary" @click="nuevaParroquia()">Nuevo</button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <vuetable-component
                :anular-button="true"
                :modificar-button="true"
                :columns-data="columns"
                :rows-data="parroquias"
                @handleModificarClick="
                                    modificarParroquia
                                "
                @handleAnularClick="
                                    anularParroquiaConfirmacion
                                "
              ></vuetable-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal :width="'65%'" height="auto" :scrollable="true" name="crearModificarParroquia">
      <crear-modificar-parroquia
        :parroquia-mod="parroquiaMod"
        :cantones="cantones"
        @recargarParroquias="cargarParroquias"
        @cerrarModalCrearModificarParroquia="
                    cerrarModalCrearModificarParroquia
                "
        ref="crearModificarCanton"
      ></crear-modificar-parroquia>
    </modal>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      parroquiaMod: null,
      errores: {},
      form: {
        canton_cod: ""
      },
      cantones: [],
      parroquias: [],
      columns: [
        {
          label: "Nombre",
          field: "PARR_NOM",
          type: "String"
        },
        {
          label: "Canton",
          field: "canton_nom",
          type: "String"
        },
        {
          label: "Activo",
          field: "PARR_ACTIVO",
          type: "String"
        },
        {
          label: "Observaciones",
          field: "PARR_OBS",
          type: "String"
        }
      ]
    };
  },
  mounted: function() {
    //arreglar
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.parroquias.parroquias.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Ingreso"
    );
    this.cargarParroquias();
  },
  beforeDestroy: function() {
    let nombreModulo = this.$nombresModulo.datos_generales;
    let nombreFormulario = this.$nombresFormulario.datos_generales
      .configuraciones.parroquias.parroquias.nombre_formulario;
    this.$funcionesGlobales.registrarLogForm(
      nombreModulo,
      nombreFormulario,
      "Salida"
    );
  },
  methods: {
    modificarParroquia(value) {
      this.parroquiaMod = value;
      this.abrirModalCrearModificarParroquia();
    },
    anularParroquiaConfirmacion(value) {
      this.form.parroquia_cod = value.PARR_COD;

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
          that.anularParroquia();
        }
      });
    },
    anularParroquia() {
      let that = this;
      let url = "/datos_generales/configuraciones/eliminar_parroquias/";
      var loader = that.$loading.show();
      axios
        .post(url, this.form)
        .then(function(response) {
          loader.hide();
          that.cargarParroquias();
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
    cerrarModalCrearModificarParroquia: function() {
      this.$modal.hide("crearModificarParroquia");
    },
    nuevaParroquia: function() {
      this.parroquiaMod = null;
      this.abrirModalCrearModificarParroquia();
    },
    abrirModalCrearModificarParroquia: function() {
      this.$modal.show("crearModificarParroquia");
    },
    cargarParroquias: function() {
      let that = this;
      let url = "/datos_generales/configuraciones/cargar_parroquias";
      var loader = that.$loading.show();
      axios
        .get(url)
        .then(function(response) {
          that.parroquias = response.data.parroquias;
          that.cantones = response.data.cantones;

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